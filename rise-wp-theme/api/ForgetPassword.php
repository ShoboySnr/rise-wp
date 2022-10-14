<?php

namespace RiseWP\Api;

use \um\core\Password;

class ForgetPassword extends Password {


    private $user_id = '';

    public function __construct()
    {
        add_action("wp_ajax_rise_password_reset_form_submission", [$this, 'rise_password_reset_form_submission']);
        add_action("wp_ajax_nopriv_rise_password_reset_form_submission", [$this, 'rise_password_reset_form_submission']);

        add_action("wp_ajax_rise_password_change_form_submission", [$this, 'rise_password_change_form_submission']);
        add_action("wp_ajax_nopriv_rise_password_change_form_submission", [$this, 'rise_password_change_form_submission']);

        add_action('um_change_password_form', [$this, 'rise_append_preloader']);

//        add_filter('um_template_tags_replaces_hook', [$this, 'rise_fetch_user_id'], 10, 1);

        add_action('um_after_password_reset_fields',  [$this, 'add_reset_password_nonce']);

        add_action('template_redirect', [$this, 'make_password_reset_cookie_available_in_path'], 99999999);
    }


    public function rise_append_preloader($args) {
        wp_nonce_field( 'um_password_change_form' );
        ?>
        <div class="preloader" style="display: none">
            <img src="<?= RISE_THEME_PRELOADER_SVG ?>" alt="preloader" />
        </div>
    <?php
    }


    public function make_password_reset_cookie_available_in_path() {

        if ( um_is_core_page( 'password-reset' ) && isset( $_REQUEST['act'] ) && $_REQUEST['act'] == 'reset_password' ) {
            $rp_cookie = 'wp-resetpass-' . COOKIEHASH;
            $cookie_value = $_COOKIE[$rp_cookie];

            if ( isset( $_COOKIE[ $rp_cookie ] ) && 0 < strpos( $_COOKIE[ $rp_cookie ], ':' ) ) {
                $this->setcookie($rp_cookie, $cookie_value, '', '/');
            }
        }
    }


    public function add_reset_password_nonce($args) {
        wp_nonce_field( 'um_password_reset_form' );
    }

    public function rise_fetch_user_id($replace_placeholders) {
        um_fetch_user($this->user_id);

        return $replace_placeholders;
    }


    public function rise_password_change_form_submission() {
        if ( $_POST[ UM()->honeypot ] != '' ) {
            wp_die( __( 'Hello, spam bot!', 'rise-wp-theme' ) );
        }

        $response = [];

        //verify nonce
        if ( !wp_verify_nonce( $_POST['nonce'], "um_password_change_form")) {
            $response['status'] = false;
            $response['message'] = __('<p>There was a problem changing your password. Please refresh your page and try again.</p>', 'rise-wp-theme');

            echo json_encode($response);
            wp_die();
        }

        //validation error message
        $error_msg = '';

        $password = $_POST['data']['password'];
        if(empty($password)) $error_msg .= __('<p>Please provide your new password</p>', 'rise-wp-theme');

        $c_password = $_POST['data']['c_password'];
        if(empty($c_password)) $error_msg .= __('<p>You must confirm your new password </p>', 'rise-wp-theme');

        if($c_password != $password) $error_msg .= __('<p>Your passwords do not match</p>', 'rise-wp-theme');

        //validations
        $args = [
            'user_password' => $password,
            'user_id'       => $_POST['data']['user_id']
        ];
        $error_messages = $this->rise_password_change_form_error($args);

        if(!empty($error_messages)) {
            foreach($error_messages as $error_message) {
                $error_msg .= '<p>'.$error_message['message'].'</p>';
            }
        }

        if(!empty($error_msg)) {
            $response['status'] = false;
            $response['message'] = $error_msg;

            echo json_encode($response);
            wp_die();
        }

        //get the page_id
        $page_id = $_POST['data']['page_id'];

        $_um_password_change = $_POST['data']['_um_password_change'];
        if(isset($_um_password_change) && $_um_password_change == 1) {
            $rp_cookie = 'wp-resetpass-' . COOKIEHASH;
            $user = get_userdata( $args['user_id']);

            if ( isset( $_COOKIE[ $rp_cookie ] ) && 0 < strpos( $_COOKIE[ $rp_cookie ], ':' ) ) {
                list( $rp_login, $rp_key ) = explode( ':', wp_unslash( $_COOKIE[ $rp_cookie ] ), 2 );

                if ( $user->user_login != $rp_login ) {
                    $user = false;
                } else {
                    $user = check_password_reset_key( $rp_key, $rp_login );
                    if ( isset( $_POST['user_password'] ) && ! hash_equals( $rp_key, $_POST['rp_key'] ) ) {
                        $user = false;
                    }
                }
            } else {
                $user = false;
            }

            if ( ! $user || is_wp_error( $user ) ) {
                $this->setcookie( $rp_cookie, false );
                if ( $user && $user->get_error_code() === 'expired_key' ) {
                    $response['status'] = false;
                    $response['message'] = __('<p>This page is expired. Please refresh and try again</p>', 'rise-wp-theme');
                    $response['redirect'] = add_query_arg( array( 'updated' => 'expiredkey' ), get_permalink($page_id) );

                    echo json_encode($response);
                    wp_die();

                } else {
                    $response['status'] = false;
                    $response['message'] = __('<p>This reset key is invalid. You must reset your password again</p>', 'rise-wp-theme');
                    $response['redirect'] = add_query_arg( array( 'updated' => 'invalidkey' ), get_permalink($page_id) );

                    echo json_encode($response);
                    wp_die();
                }
                exit;
            }

            $errors = new \WP_Error();

            do_action( 'validate_password_reset', $errors, $user );

            if ( ( ! $errors->get_error_code() ) ) {
                reset_password( $user, $args['user_password'] );

                // send the Password Changed Email
                um_fetch_user($user->ID);
                UM()->user()->password_changed();

                // clear temporary data
                $attempts = (int) get_user_meta( $user->ID, 'password_rst_attempts', true );
                if ( $attempts ) {
                    update_user_meta( $user->ID, 'password_rst_attempts', 0 );
                }
                $this->setcookie( $rp_cookie, false );

                // logout
                if ( is_user_logged_in() ) {
                    $response['status'] = true;
                    $response['message'] = __('<p>Password updated. You must log out to continue.</p>', 'rise-wp-theme');
                    $response['redirect'] = wp_logout_url();

                    echo json_encode($response);
                    wp_die();
                }

                do_action( 'um_after_changing_user_password', $args['user_id'] );

                //after all is done
                $response['status'] = true;
                $response['message'] = __('<p>Password updated. You must log out to continue.</p>', 'rise-wp-theme');
                $response['redirect'] =  um_get_core_page('login', 'password_changed' );

                echo json_encode($response);
                wp_die();
            }
        }

        $response['status'] = false;
        $response['message'] = __('<p>There was a problem changing your password. Reload this page and try again.');


        echo json_encode($response);
        wp_die();



    }


    public function rise_password_reset_form_submission() {
        if ( $_POST[ UM()->honeypot ] != '' ) {
            wp_die( __( 'Hello, spam bot!', 'rise-wp-theme' ) );
        }

        $response = [];
        //verify nonce
        if ( !wp_verify_nonce( $_POST['nonce'], "um_password_reset_form")) {
            $response['status'] = false;
            $response['message'] = __('<p>There was a problem sending recovery email. Please refresh your page and try again.</p>', 'rise-wp-theme');

            echo json_encode($response);
            wp_die();
        }

        //validation error message
        $error_msg = '';

        $username = $_POST['data']['username'];
        if(empty($username)) $error_msg .= __('<p>Please provide your username or email</p>', 'rise-wp-theme');

        if(!empty($error_msg)) {
            $response['status'] = false;
            $response['message'] = $error_msg;

            echo json_encode($response);
            wp_die();
        }

        $username = trim($username);

        if ( username_exists( $username ) ) {
            $data = get_user_by( 'login', $username );
        } elseif ( email_exists( $username ) ) {
            $data = get_user_by( 'email', $username );
        }

        if(empty($data)) {
            $response['status'] = false;
            $response['message'] = __('<p>We can\'t find an account registered with that address or username</p>', 'rise-wp-theme');

            echo json_encode($response);
            wp_die();
        }

        //check and updates the password reset lists
        $response = $this->rise_password_reset_form_error($data->ID);

        if(!empty($response['status']) && $response['status'] === false) {
            echo json_encode($response);
            wp_die();
        }

        $this->user_id = $data->ID;

        um_fetch_user( $data->ID );

        $user_id = um_user( 'ID' );

        UM()->user()->password_reset();

        $response['status'] = true;
        $response['message'] = __('<p>A recovery email has been sent to your email.</p>', 'rise-wp-theme');
        $response['redirect'] = um_get_core_page('password-reset', 'checkemail' );

        echo json_encode($response);
        wp_die();
    }


    public function rise_password_reset_form_error($user_id) {
        $attempts = (int) get_user_meta( $user_id, 'password_rst_attempts', true );
        $is_admin = user_can( absint( $user_id ),'manage_options' );

        if ( UM()->options()->get( 'enable_reset_password_limit' ) ) { // if reset password limit is set

            if ( UM()->options()->get( 'disable_admin_reset_password_limit' ) &&  $is_admin ) {
                // Triggers this when a user has admin capabilities and when reset password limit is disabled for admins
            } else {
                $limit = UM()->options()->get( 'reset_password_limit_number' );
                if ( $attempts >= $limit ) {
                    return [
                        'message'   => __( 'You have reached the limit for requesting password change for this user already. Contact support if you cannot open the email', 'rise-wp-theme'),
                        'status'    => false,
                    ];
                } else {
                    update_user_meta( $user_id, 'password_rst_attempts', $attempts + 1 );
                }
            }

        }

    }


    public function rise_password_change_form_error($args) {
        $error_messages = [];


        if ( UM()->options()->get( 'reset_require_strongpass' ) ) {
            if ( strlen( utf8_decode( $args['user_password'] ) ) < 8 ) {
                $error = [
                    'status'    => false,
                    'message'    => __( 'Your password must contain at least 8 characters', 'rise-wp-theme' ),
                ];
                $error_messages[] = array_merge($error, $error_messages);
            }

            if ( strlen( utf8_decode( $args['user_password'] ) ) > 30 ) {
                $error = [
                    'status'    => false,
                    'message'    => __( 'Your password must contain less than 30 characters', 'rise-wp-theme' ),
                ];
                $error_messages[] = array_merge($error, $error_messages);
            }

            if ( ! UM()->validation()->strong_pass( $args['user_password'] ) ) {
                $error = [
                    'status'    => false,
                    'message'    => __( 'Your password must contain at least one lowercase letter, one capital letter and one number', 'rise-wp-theme' ),
                ];
                $error_messages[] = array_merge($error, $error_messages);
            }
        }

        return $error_messages;
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
