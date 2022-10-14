<?php

namespace RiseWP\Api;

class Register {

    public function __construct()
    {
        add_action("wp_ajax_register_eligibility_form", [$this, 'register_eligibility_form']);
        add_action("wp_ajax_nopriv_register_eligibility_form", [$this, 'register_eligibility_form']);

        add_action("wp_ajax_organisation_group_form", [$this, 'organisation_group_form']);
        add_action("wp_ajax_nopriv_organisation_group_form", [$this, 'organisation_group_form']);

        add_action("wp_ajax_check_business_registration_exists", [$this, 'check_business_registration_exists']);
        add_action("wp_ajax_nopriv_check_business_registration_exists", [$this, 'check_business_registration_exists']);

        add_action("wp_ajax_full_membership_form_register", [$this, 'submit_full_membership_form_register']);
        add_action("wp_ajax_nopriv_full_membership_form_register", [$this, 'submit_full_membership_form_register']);
  
        add_action("wp_ajax_eligibility_checking_business_location_form", [$this, 'eligibility_checking_business_location_form']);
        add_action("wp_ajax_nopriv_eligibility_checking_business_location_form", [$this, 'eligibility_checking_business_location_form']);

        add_action('um_rise_wp_main_register_fields', [$this, 'register_form_fields'], 10, 1);
        add_action('um_rise_wp_after_register_fields',  [$this, 'add_nonce']);
    }

    public function add_nonce() {
        wp_nonce_field( 'um_register_form' );
    }


    public function registration_custom_notification($emails) {
        $emails['notification_new_user'] = [
            'key'           => 'notification_new_user',
            'title'         => __( 'New User Notification','ultimate-member' ),
            'subject'       => '[{site_name}] New user account',
            'body'          => '{display_name} has just created an account on {site_name}. To view their own profile click here:<br /><br />' .
                '{user_profile_link}<br /><br />' .
                'Here is the submitted registration form:<br /><br />' .
                '{submitted_registration}',
            'description'   => __('Whether to receive notification when a new user account is approved','ultimate-member'),
            'recipient'   => 'admin',
            'default_active' => true
        ];

        return $emails;
    }


    public function add_user_registration_data($submitted) {
        $submitted['Sample'] = 'Hello';
        return $submitted;
    }


    public function check_business_registration_exists() {
        $response = [];

        $company_name = $_POST['eligibility']['business'];

        if(empty($company_name)) {
            $company_name = $_POST['eligibility']['group_id'];
        }

        //first check whether the group exits
        $check_group = get_page_by_title($company_name, OBJECT, 'um_groups');


        if(!empty($check_group) ) {
            $response['status'] = false;
            $response['message'] = __('<p>This Business exists</p>', 'rise-wp-theme');

            return $response;
        }

        $check_group = get_post($company_name);

        if(!empty($check_group) ) {
            $response['status'] = false;
            $response['message'] = __('<p>This Business exists</p>', 'rise-wp-theme');

            return $response;
        }

        $response['status'] = true;
        $response['message'] = __('<p>This Business does not exits.</p>', 'rise-wp-theme');
        $response['business'] = $company_name;

        return $response;
    }


    public function get_company() {
        $return_data = [];
        $args = [
            'category'                => 0,
            'groups_per_page'         => -1,
            'show_actions'            => 1,
            'show_author'             => 0,
            'show_pagination'         => 1,
            'show_search_form'        => 1,
            'show_search_categories'  => 1,
            'show_search_tags'        => 1,
            'show_total_groups_count' => 1,
            'show_with_greater_than'  => 0,
            'show_with_less_than'     => 0,
            'sort'                    => 'newest_groups',
        ];

        $organisation = UM()->Groups()->api()->get_groups( $args );

        $groups = $organisation['raw']->posts;

        if(!empty($groups) && is_array($groups)) {
            foreach ($groups as $group) {
                $return_data[] = [
                    'id'        => $group->ID,
                    'title'     => $group->post_title,
                    'slug'        => $group->post_name,
                ];
            }
        }

        return $return_data;
    }

    public function organisation_group_form() {
        $response = [];

        //verify nonce
        if ( !wp_verify_nonce( $_POST['nonce'], "organisation_group_form_nonce")) {
            $url = apply_filters( 'um_register_invalid_nonce_redirect_url', add_query_arg( [ 'err' => 'invalid_nonce' ] ) );
            exit( wp_redirect( $url ) );
        }

        //create the groups
        $eligibility = $_POST['eligibility'];
        $terms_agreement = $eligibility['terms_agreement'];
        $company_name = $eligibility['company_name'];
        $business_website = $eligibility['business_website'];
        $reg_business_address = $eligibility['reg_business_address'];
        $reg_business_street = $eligibility['reg_business_street'];
        $reg_business_city = $eligibility['reg_business_city'];
        $reg_business_county = $eligibility['reg_business_county'];
        $reg_business_postcode = $eligibility['reg_business_postcode'];
        $primary_area_operation = $eligibility['primary_area_operation'];

        $error_msg = '';
        if(empty($company_name)) $error_msg .= __('<p>Full name entered is required</p>', 'rise-wp-theme');
        if(empty($terms_agreement) || $terms_agreement !== 'Yes')  $error_msg .= __('<p>Acknowledgment and Agreement is required</p>', 'rise-wp-theme');

        if(!empty($error_msg)) {
            $response['status'] = false;
            $response['message'] = $error_msg;

            echo json_encode($response);
            wp_die();
        }

        $args = [
            'post_type'         => 'um_groups',
            'post_status'       => 'publish',
            'post_title'        => $company_name,
            'post_content'      => '',
            'comment_status'    => 'closed',
            'ping_status'	    => 'closed',
        ];

        try {
            //first check whether the group exits
            $check_group = get_page_by_title($company_name, OBJECT, 'um_groups');

            if(!empty($check_group)) {
                $response['status'] = false;
                $response['message'] = __('<p>This business already exists in our system</p>', 'rise-wp-theme');

                echo json_encode($response);
                wp_die();
            }

            $groups = wp_insert_post($args, true);

            if(is_wp_error($groups)) {
                $response['status'] = false;
                $response['message']    = __('<p>There was an error creeating your business profile. Please try again.</p>', 'rise-wp-theme');

                echo json_encode($response);
                wp_die();
            }

            //copy this post meta from um_groups plugin extension
            add_post_meta( $groups, '_um_groups_privacy', 'public');
            add_post_meta( $groups, '_um_groups_invites_settings',  0);
            add_post_meta( $groups, '_um_groups_can_invite', 0);
            add_post_meta( $groups, '_um_groups_posts_moderation', 'auto-published');

            //update the business fields
            //update custom fields for the business information
            update_field( 'business_website', sanitize_text_field($business_website), $groups );
            update_field( 'reg_business_address', sanitize_text_field($reg_business_address), $groups );
            update_field('reg_business_street', $reg_business_street, $groups);
            update_field('reg_business_city', $reg_business_city, $groups);
            update_field('reg_business_county', $reg_business_county, $groups);
            update_field( 'reg_business_postcode', sanitize_text_field($reg_business_postcode), $groups );
            update_field( 'primary_area_operation', sanitize_text_field($primary_area_operation), $groups );

            $response['status'] = true;
            $response['message']    = __('<p>Business successfully created.</p>', 'rise-wp-theme');
            $response['group_id']   = $groups;

            echo json_encode($response);
            wp_die();


        } catch(\Exception $e) {
            $response['status'] = false;
            $response['message'] = __('<p>There was a problem creating your Business Information. Please try again. </p>', 'rise-wp-theme');

            echo json_encode($response);
            wp_die();
        }
    }

    public function register_eligibility_form()
    {
        $response['eligibility'] = false;
        //verify nonce
        if ( !wp_verify_nonce( $_POST['nonce'], "register_eligibility_form_nonce")) {
            $url = apply_filters( 'um_register_invalid_nonce_redirect_url', add_query_arg( [ 'err' => 'invalid_nonce' ] ) );
            exit( wp_redirect( $url ) );
        }

        //get all the post values
        $elibility = [];
        if(isset($_POST['eligibility']) && $_POST['eligibility'] != '') {
            $elibility = $_POST['eligibility'];

            //check if any of the eligibility values is no
            if(!in_array('No', $elibility)) {
                $response['eligibility'] = true;
            }
        }
        echo json_encode($response);
        wp_die();
    }
    
    public function eligibility_checking_business_location_form() {
      $response = [];
      //verify nonce
      if ( !wp_verify_nonce( $_POST['nonce'], "register_eligibility_checking_location_form_nonce")) {
        $url = apply_filters( 'um_register_invalid_nonce_redirect_url', add_query_arg( [ 'err' => 'invalid_nonce' ] ) );
        $response['status'] = false;
        $response['message'] = __('<p>Invalid Nonce.</p>', 'rise-wp-theme');
        
        echo json_encode($response);
        wp_die();
      }
      
      if(isset($_POST['eligibility']['prev_data']) && $_POST['eligibility']['prev_data'] != '') {
        $eligibility = $_POST['eligibility']['prev_data'];
    
        //check if any of the eligibility values is no
        if(in_array('No', $eligibility)) {
          $response['eligibility'] = false;
          $response['status'] = false;
          $response['message'] = __('<p>An error occurred, please try again</p>', 'rise-wp-theme');
  
          echo json_encode($response);
          wp_die();
        }
      }
  
      $eligibility = $_POST['eligibility']['data'];
      
      $primary_area_location_taxonomy = $eligibility['primary_area_location_taxonomy'];
  
      $response['status'] = false;
      if(!empty($primary_area_location_taxonomy)) {
        $get_term = get_term((int) $primary_area_location_taxonomy, UsersTaxonomy::$location_taxonomy);
       
        if(!is_wp_error($get_term) && !empty($get_term)) {
          $response['status'] = true;
          //check if its east sussex
          if(strpos($get_term->name, 'East Sussex') !== false || $primary_area_location_taxonomy === 'others') {
            $response['message'] = 'friends-of-rise';
          } else {
            $response['message'] = 'full-membership';
          }
        } else if($primary_area_location_taxonomy === 'others') {
          $response['status'] = true;
          $response['message'] = 'friends-of-rise';
        } else {
          $response['message'] = __('<p>An error occurred.</p>', 'rise-wp-theme');
        }
      } else {
        $response['message'] = __('<p>Please choose a valid business location.</p>', 'rise-wp-theme');
      }
      
      echo json_encode($response);
      wp_die();
      
    }

    public function submit_full_membership_form_register() {
        $response = [];
        //verify nonce
        if ( !wp_verify_nonce( $_POST['nonce'], "full_membership_field_form_nonce")) {
            $url = apply_filters( 'um_register_invalid_nonce_redirect_url', add_query_arg( [ 'err' => 'invalid_nonce' ] ) );
            exit( wp_redirect( $url ) );
        }

        //get the post values
        $eligibility = $_POST['eligibility'];

        $first_name = $eligibility['first_name'];
        $last_name = $eligibility['last_name'];
        $company_email = $eligibility['company_email'];
        $group_id = $eligibility['business'];
        $annual_turnover = $eligibility['annual_turnover'];
        $primary_focused = $eligibility['primary_focused'];
        $number_employees = $eligibility['number_employees'];
        $have_not_received = $eligibility['have_not_received'];
        $location_taxonomy = $eligibility['location_taxonomy'];

        $error_msg = '';

        //verify the email address
        if(!is_email($company_email) || empty($company_email)) $error_msg .= __('<p>Email address entered is not valid</p>', 'rise-wp-theme');

        if(empty($first_name)) $error_msg .= __('<p>First name entered is required</p>', 'rise-wp-theme');
        if(empty($last_name)) $error_msg .= __('<p>Last name entered is required</p>', 'rise-wp-theme');

        if(!empty($error_msg)) {
            $response['status'] = false;
            $response['message'] = $error_msg;

            echo json_encode($response);
            wp_die();
        }

        $user = get_user_by('email', sanitize_email($company_email));

        if(!empty($user)) {
            $response['status'] = false;
            $response['message'] = __('<p>This email address already exists in our system.</p>', 'rise-wp-theme');

            echo json_encode($response);
            wp_die();
        }

        //check if the business already exist
        $business_check = $this->check_business_registration_exists();
        if($business_check['status']) {
            $response['status'] = false;
            $response['business'] = $business_check['business'];

            echo json_encode($response);
            wp_die();
        }


        $user_args = [
            'user_email'        => sanitize_email($company_email),
            'user_login'        => sanitize_email($company_email),
            'user_nicename'     => sanitize_text_field($last_name. ' '. $first_name),
            'role'              => 'um_full-membership'
        ];

        try {
            //create the user details
            do_action('um_submit_form_register', $user_args);

            $user = get_user_by('email', sanitize_email($company_email));

            $user_id = $user->ID;

            if(!empty($user_id)) {
                $args['ID'] = $user_id;
                $args['first_name'] = $first_name;
                $args['last_name'] = $last_name;

                $user_id = wp_update_user($args);

                //update custom fields
                update_field( 'annual_turnover', sanitize_text_field($annual_turnover), 'user_'.$user_id );
                update_field( 'number_employees', sanitize_text_field($number_employees), 'user_'.$user_id );
                update_field( 'primary_focused', sanitize_text_field($primary_focused), 'user_'.$user_id );
                update_field( 'have_not_received', sanitize_text_field($have_not_received), 'user_'.$user_id );
  
              //save user location
              $_POST['location_taxonomy'] = $location_taxonomy;
              UsersTaxonomy::get_instance()->save_user_location($group_id);

                //add user to groups
                if(!empty($group_id)) {

                    //send notification to user
                    do_action('um_rise_new_user_notification', $user_id, $group_id);

                    $admin_user = get_user_by('login', 'administrator');

                    UM()->Groups()->api()->join_group($user_id, $admin_user->ID, $group_id, 'admin');

                    //add admin to all groups created
                    UM()->Groups()->api()->join_group($admin_user->ID, $admin_user->ID, $group_id, 'admin');
                }

                do_action('um_registration_complete', $user_id, $user_args);

            }


           $response['status'] = true;
           $response['message'] = __('<p>User membership registration was successful</p>', 'rise-wp-theme');

           echo json_encode($response);
           wp_die();

        } catch(\Exception $e) {
            $response['status'] = false;
            $response['message'] = __('<p>There was an error submitting your information. Please try again later</p>', 'rise-wp-theme');
            echo json_encode($response);
        }

        wp_die();
    }

    public function register_form_fields($args) {
        //get all the custom fields
        $custom_fields = $args['custom_fields'];
  
        $terms_condition_link = get_permalink(get_page_by_path('terms-and-conditions'));
        $terms_condition_title = !empty(get_page_by_path('terms-and-conditions')) ? get_page_by_path('terms-and-conditions')->post_title : '';
        $privacy_policy_link = get_permalink(get_page_by_path('privacy-policy'));
        $privacy_policy_title = !empty(get_page_by_path('privacy-policy')) ? get_page_by_path('privacy-policy')->post_title : '';

        $output = '';
        include_once __DIR__.'/fields/register/eligibility-form.php';
        include_once __DIR__.'/fields/register/eligibility-sorry.php';
        include_once __DIR__.'/fields/register/eligibility-checking-location.php';
        include_once __DIR__.'/fields/register/eligibility-for-friends.php';
        include_once __DIR__.'/fields/register/full-membership-field.php';
        include_once __DIR__.'/fields/register/full-membership-field-2.php';
        include_once __DIR__.'/fields/register/full-membership-field-success.php';
        include_once __DIR__.'/fields/register/eligibiltiy-for-friends-success.php';

        return $output;
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
