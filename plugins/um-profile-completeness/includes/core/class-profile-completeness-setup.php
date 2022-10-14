<?php
namespace um_ext\um_profile_completeness\core;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Groups_Setup
 * @package um_ext\um_profile_completeness\core
 */
class Profile_Completeness_Setup {


	/**
	 * @var array
	 */
	public $settings_defaults;


	/**
	 * Groups_Setup constructor.
	 */
	public function __construct() {

		//settings defaults
		$this->settings_defaults = array(
			// Reminder - Email Template
			'profile_completeness_reminder_on'  => 0,
			'profile_completeness_reminder_sub' => '{site_name} - Complete your profile',
			'profile_completeness_reminder'     => 'Hi {member},<br /><br />' .
												'Your profile is not complete.<br /><br />' .
												'Please go to your profile and fill it out: {user_profile_link}',
		);

	}


	/**
	 * Set default settings
	 */
	public function set_default_settings() {
		$options = get_option( 'um_options', array() );

		foreach ( $this->settings_defaults as $key => $value ) {
			//set new options to default
			if ( ! isset( $options[ $key ] ) ) {
				$options[ $key ] = $value;
			}
		}

		update_option( 'um_options', $options );
	}


	/**
	 *
	 */
	public function run_setup() {
		$this->set_default_settings();
	}
}
