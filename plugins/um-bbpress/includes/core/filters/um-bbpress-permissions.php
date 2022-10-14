<?php if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Filter user permissions in bbPress
 *
 * @param $meta
 * @param $user_id
 *
 * @return mixed
 */
function um_bbpress_user_permissions_filter( $meta, $user_id ) {
	if ( ! isset( $meta['can_have_forums_tab'] ) ) {
		$meta['can_have_forums_tab'] = 1;
	}
		
	if ( ! isset( $meta['can_create_topics'] ) ) {
		$meta['can_create_topics'] = 1;
	}
		
	if ( ! isset( $meta['can_create_replies'] ) ) {
		$meta['can_create_replies'] = 1;
	}
		
	if ( ! isset( $meta['lock_days'] ) ) {
		$meta['lock_days'] = 0;
	}
		
	if ( ! isset( $meta['lock_notice'] ) ) {
		$meta['lock_notice'] = 0;
	}

	if ( ! isset( $meta['lock_notice2'] ) ) {
		$meta['lock_notice2'] = 0;
	}

	return $meta;
}
add_filter( 'um_user_permissions_filter', 'um_bbpress_user_permissions_filter', 10, 4 );


/**
 * Extends get progress results
 *
 * @param array $result
 * @param array $role_data
 *
 * @return array
 */
function um_bbpress_profile_completeness_get_progress_result( $result, $role_data ) {
	$result['prevent_bb'] = ! empty( $role_data['profilec_prevent_bb'] ) ? $role_data['profilec_prevent_bb'] : 0;
	return $result;
}
add_filter( 'um_profile_completeness_get_progress_result', 'um_bbpress_profile_completeness_get_progress_result', 10, 2 );


/**
 * Extends get progress defaults
 *
 * @param array $defaults
 * @param int $user_id
 *
 * @return array
 */
function um_bbpress_profile_completeness_profile_progress_defaults( $defaults, $user_id ) {
	$defaults['prevent_bb'] = 0;
	return $defaults;
}
add_filter( 'um_profile_completeness_profile_progress_defaults', 'um_bbpress_profile_completeness_profile_progress_defaults', 10, 2 );