<?php

namespace RiseWP\Api;

use MC4WP_User_Integration;

class MailChimpUserIntegration extends MC4WP_User_Integration {

    /**
     * Add hooks
     */
    public function add_hooks() {
        add_action( 'um_user_register', array( $this, 'subscribe_from_registration' ), 90, 1 );
        add_action( 'user_register', array( $this, 'subscribe_from_registration' ), 90, 1 );
    }

    /**
     * Subscribes from WP Registration Form
     *
     * @param int $user_id
     *
     * @return bool|string
     */
    public function subscribe_from_registration( $user_id ) {

        // was sign-up checkbox checked?
        if ( ! $this->triggered() ) {
            return false;
        }

        // gather emailadress from user who WordPress registered
        $user = get_userdata( $user_id );

        // was a user found with the given ID?
        if ( ! $user instanceof WP_User ) {
            return false;
        }

        $data = $this->user_merge_vars( $user );

        return $this->subscribe( $data, $user_id );
    }

    /**
     * Singleton poop.
     *
     * @return self
     */
    public static function get_instance() {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }
}
