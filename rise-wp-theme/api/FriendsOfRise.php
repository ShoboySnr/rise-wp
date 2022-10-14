<?php

namespace RiseWP\Api;

class FriendsOfRise {

    public function __construct()
    {
        add_action("wp_ajax_eligibility_for_friends_form", [$this, 'eligibility_for_friends_form']);
        add_action("wp_ajax_nopriv_eligibility_for_friends_form", [$this, 'eligibility_for_friends_form']);
    }

    public function eligibility_for_friends_form() {
        $response = [];

        //verify nonce
        if ( !wp_verify_nonce( $_POST['nonce'], "eligibility_for_friends_form_nonce")) {
            exit("Not allowed");
        }
        
        

        //get the post values
        $eligibility = $_POST['eligibility'];

        $first_name = $eligibility['first_name'];
        $last_name = $eligibility['last_name'];
        $company_name = $eligibility['company_name'];
        $business_email = $eligibility['business_email'];
        $annual_turnover = $eligibility['annual_turnover'];
        $primary_focused = $eligibility['primary_focused'];
        $number_employees = $eligibility['number_employees'];
        $have_not_received = $eligibility['have_not_received'];
        $terms_agreement = $eligibility['terms_agreement'];
        $location_taxonomy = $eligibility['location_taxonomy'];

        $error_msg = '';

        //verify the email address
        if(!is_email($business_email) || empty($business_email)) $error_msg .= __('<p>Email address entered is not valid</p>', 'rise-wp-theme');

        if(empty($first_name)) $error_msg .= __('<p>First name entered is required</p>', 'rise-wp-theme');
        if(empty($last_name)) $error_msg .= __('<p>Last name entered is required</p>', 'rise-wp-theme');
        if(empty($terms_agreement) || $terms_agreement !== 'Yes')  $error_msg .= __('<p>Acknowledgment and Agreement is required</p>', 'rise-wp-theme');

        if(!empty($error_msg)) {
            $response['status'] = false;
            $response['message'] = $error_msg;

            echo json_encode($response);
            wp_die();
        }

        $args = [
            'user_email'        => sanitize_email($business_email),
            'user_login'        => sanitize_email($business_email),
            'user_nicename'     => sanitize_text_field($first_name. ' '. $last_name),
            'first_name'        => sanitize_text_field($first_name),
            'last_name'         => sanitize_text_field($last_name),
            'display_name'      => sanitize_text_field($first_name. ' '. $last_name),
            'role'              => 'um_friends-of-rise'
        ];

        try {

            //create the user details
            do_action('um_submit_form_register', $args);

            $user = get_user_by('email', sanitize_email($business_email));

            $user_id = $user->ID;

            if(!empty($user_id)) {
                $args['ID'] = $user_id;
                $args['first_name'] = $first_name;
                $args['last_name'] = $last_name;
                $user_id = wp_update_user($args);

                update_field( 'company_name', sanitize_text_field($company_name), 'user_'.$user_id );
                update_field( 'annual_turnover', sanitize_text_field($annual_turnover), 'user_'.$user_id );
                update_field( 'number_employees', sanitize_text_field($number_employees), 'user_'.$user_id );
                update_field( 'primary_focused', sanitize_text_field($primary_focused), 'user_'.$user_id );
                update_field( 'have_not_received', sanitize_text_field($have_not_received), 'user_'.$user_id );
  
                //save user location - temporary comment this since Friend of RISE would not be able to create location attached to the business
//                $_POST['location_taxonomy'] = $location_taxonomy;
//                UsersTaxonomy::get_instance()->save_user_location($user_id);
            }

            do_action('um_registration_complete', $user_id, $args);

            $response['status'] = true;
            $response['message'] = __('<p>Successfully created user as Friends of RISE</p>', 'rise-wp-theme');

            echo json_encode($response);
            wp_die();

        } catch(\Exception $e) {
            $response['status'] = false;
            $response['message'] = __('<p>There was an error submitting your information. Please try again later</p>', 'rise-wp-theme');
            echo json_encode($response);
        }

        wp_die();
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
