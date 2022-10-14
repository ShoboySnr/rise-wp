<?php
namespace um_ext\um_profile_completeness\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Profile_Completeness_Email
 *
 * @package um_ext\um_profile_completeness\core
 */
class Profile_Completeness_Email {


	/**
	 * Profile_Completeness_Email constructor.
	 */
	public function __construct() {
		add_filter( 'um_email_templates_path_by_slug', array( &$this, 'email_templates_path_by_slug' ), 10, 1 );
		add_filter( 'um_email_notifications', array( $this, 'um_profile_completeness_email_notifications' ), 10, 1 );
	}


	/**
	 * Add email notifications templates path
	 *
	 * @param array $slugs
	 *
	 * @return array
	 */
	public function email_templates_path_by_slug( $slugs ) {
		$slugs['profile_completeness_reminder'] = um_profile_completeness_path . 'templates/email/';

		return $slugs;
	}


	/**
	 * Email notifications templates
	 *
	 * @param array $notifications
	 *
	 * @return array
	 */
	public function um_profile_completeness_email_notifications( $notifications ) {
		$notifications['profile_completeness_reminder'] = array(
			'key'            => 'profile_completeness_reminder',
			'title'          => __( 'Profile Completeness - Reminder Email', 'um-profile-completeness' ),
			'subject'        => '{site_name} - Complete your profile',
			'body'           => 'Hi {member},<br /><br />' .
							'Your profile is not complete.<br /><br />' .
							'Please go to your profile and fill it out: {user_profile_link}',
			'description'    => __( 'Whether to send the user an email when user is not completed their profile', 'um-profile-completeness' ),
			'recipient'      => 'user',
			'default_active' => false,
		);

		return $notifications;
	}
}
