<?php namespace um_ext\um_profile_completeness\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/**
 * Class Cron
 *
 * @package um_ext\um_profile_completeness\core
 */
class Profile_Completeness_Cron {


	/**
	 * Cron constructor.
	 */
	public function __construct() {
		add_action( 'um_hourly_scheduled_events', array( &$this, 'check_profile_completeness' ) );
	}


	/**
	 *
	 */
	public function check_profile_completeness() {
		global $wp_roles;

		$days  = 0;
		$roles = array();
		foreach ( $wp_roles->roles as $key => $role ) {
			$role_data = UM()->roles()->role_data( $key );
			if ( empty( $role_data ) ) {
				continue;
			}

			if ( ! empty( $role_data['profilec'] ) && ! empty( $role_data['profilec_enable_email_reminder'] ) ) {
				$reminder_period = ! empty( $role_data['profilec_email_reminder_period'] ) ? $role_data['profilec_email_reminder_period'] : 7;
				if ( $reminder_period > $days ) {
					$days = $reminder_period;
				}

				$roles[] = $key;
			}
		}

		$transient_expiration = ! empty( $days ) ? $days * DAY_IN_SECONDS : 7 * DAY_IN_SECONDS;
		$users_per_action = 100;

		$query_args = array(
			'role__in'   => $roles,
			'fields'     => array( 'ID', 'display_name', 'user_email', 'user_url', 'user_registered' ),
			'number'     => $users_per_action,
			'meta_query' => array(
				array(
					'key'     => 'account_status',
					'value'   => 'approved',
					'compare' => '='
				)
			),
		);

		$offset = get_transient( 'um_profile_completeness_reminder_users_offset' );
		if ( ! empty( $offset ) ) {
			$query_args['offset'] = $offset;
		} else {
			$offset = 0;
		}
		$users = get_users( $query_args );

		if ( ! empty( $users ) ) {
			foreach ( $users as $user ) {
				$user_role = UM()->roles()->get_priority_user_role( $user->ID );
				$role_data = UM()->roles()->role_data( $user_role );

				if ( empty( $role_data['profilec'] ) || empty( $role_data['profilec_enable_email_reminder'] ) ) {
					continue;
				}

				$result = UM()->Profile_Completeness_API()->get_progress( $user->ID );
				if ( -1 === $result ) {
					continue;
				}

				if ( (int) $result['progress'] < (int) $result['req_progress'] ) {
					$last_reminder = get_user_meta( $user->ID, '_profile_completeness_last_reminder', true );
					if ( empty( $last_reminder ) ) {
						$last_reminder = strtotime( $user->user_registered );
					}

					$days          = ! empty( $role_data['profilec_email_reminder_period'] ) ? $role_data['profilec_email_reminder_period'] : 7;
					$required_time = strtotime( '-' . $days . ' day' );

					if ( (int) $last_reminder < (int) $required_time ) {
						UM()->mail()->send(
							$user->user_email,
							'profile_completeness_reminder',
							array(
								'path'         => um_profile_completeness_path . 'templates/email/',
								'tags'         => array(
									'{member}',
									'{user_profile_link}',
								),
								'tags_replace' => array(
									$user->display_name,
									$user->user_url,
								),
							)
						);

						update_user_meta( $user->ID, '_profile_completeness_last_reminder', time() );
					}
				}
			}

			set_transient( 'um_profile_completeness_reminder_users_offset', absint( $offset ) + $users_per_action, $transient_expiration );
		} else {
			delete_transient( 'um_profile_completeness_reminder_users_offset' );
		}
	}
}
