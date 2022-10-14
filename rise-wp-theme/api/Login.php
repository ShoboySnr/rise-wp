<?php

namespace RiseWP\Api;

class Login {

    public function __construct()
    {
        add_action("wp_ajax_rise_login_form_submission", [$this, 'rise_login_form_submission']);
        add_action("wp_ajax_nopriv_rise_login_form_submission", [$this, 'rise_login_form_submission']);

        add_action( 'um_on_login_before_redirect', [$this, 'login_before_redirection'], 10);

        add_action('um_rise_wp_main_login_fields', [$this, 'login_form_fields'], 10, 1);
        add_action('um_rise_wp_after_login_fields',  [$this, 'add_nonce']);
    }


    public function add_nonce() {
        wp_nonce_field( 'um_login_form' );
    }


    public function login_form_fields() {
        include_once __DIR__.'/fields/login/login.php';
    }

    public function login_before_redirection($user_id) {
        $response = [];
        //the login was successful
        // Role redirect
        um_fetch_user($user_id);
        $after_login = um_user( 'after_login' );


        $response['status'] = true;
        $response['message'] = __('<p>Your login was successful</p>', 'rise-wp-theme');

        if ( empty( $after_login ) ) {
            $response['redirect'] = um_user_profile_url();

            echo json_encode($response);
            wp_die();
        }

        switch ( $after_login ) {

            case 'redirect_admin':
                $response['redirect'] = admin_url();
                break;

            case 'redirect_url':
                $redirect_url = apply_filters( 'um_login_redirect_url', um_user( 'login_redirect_url' ), um_user( 'ID' ) );
                $response['redirect'] = $redirect_url;
                break;

            case 'refresh':
                $response['redirect'] = UM()->permalinks()->get_current_url();
                break;

            case 'redirect_profile':
            default:
                $response['redirect'] = um_user_profile_url();
                break;
        }

        echo json_encode($response);
        wp_die();
    }


    public function rise_login_form_submission() {
        $response = [];
        //verify nonce
        if ( !wp_verify_nonce( $_POST['data']['nonce'], "um_login_form")) {
            $url = apply_filters( 'um_login_invalid_nonce_redirect_url', add_query_arg( [ 'err' => 'invalid_nonce' ] ) );
            $response['status'] = false;
            $response['message'] = __('<p>There was a problem logging you in. Pleasre refresh your page and try again.</p>', 'rise-wp-theme');

            echo json_encode($response);
            wp_die();
        }

        $username = $_POST['data']['username'];
        $password = $_POST['data']['password'];

        //validation error message
        $error_msg = '';

        if(empty($username)) $error_msg .= __('<p>Email address or Username is empty</p>', 'rise-wp-theme');
        if(empty($password)) $error_msg .= __('<p>Please enter a password</p>', 'rise-wp-theme');

        if(!empty($error_msg)) {
            $response['status'] = false;
            $response['message'] = $error_msg;

            echo json_encode($response);
            wp_die();
        }

        //perform a check to know if the user inputted an email
        $args = [
            'password'      => $password,
            'rememberme'    => 1,
        ];

        if(is_email($username)) {
            $args['user_email'] = $username;
        } else {
            $args['user_login'] = $username;
        }

        try {
            //do_action('um_user_login', $args );
            $user = get_user_by('email', $args['user_email']);

            if(!$user) $user = get_user_by('login', $args['user_login']);

            if(empty($user->ID)) {
                $response['status'] = false;
                $response['message'] = __('<p>Invalid login credentials</p>', 'rise-wp-theme');

                echo json_encode($response);
                wp_die();
            }

            $hashed_password = $user->data->user_pass;
            //check if the user password is the same as the one registered
            $check_password = wp_check_password($args['password'], $hashed_password, $user->ID);

            if(!$check_password) {
                $response['status'] = false;
                $response['message'] = __('<p>Invalid login credentials</p>', 'rise-wp-theme');

                echo json_encode($response);
                wp_die();
            }

            //don't allow users with roles capablities to login -> um_friends-of-rise
            $user_roles = $user->roles;
            if(in_array('um_friends-of-rise', $user_roles)) {
                $response['status'] = false;
                $response['message'] = __('<p>Invalid login credentials</p>', 'rise-wp-theme');

                echo json_encode($response);
                wp_die();
            }

            um_fetch_user($user->ID);

            do_action('um_user_login', $args);

        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = __('<p>There was a problem logging you in. Please refresh this page and try again</p>', 'rise-wp-theme');
            echo json_encode($response);
        }
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
