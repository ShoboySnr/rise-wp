<?php
    
    namespace RiseWP\Api;
    
    class Notifications {
        
        private $user_id;
        
        private $email;
        
        private $group_id;
        
        public function __construct()
        {
            add_filter('um_notifications_core_log_types', [$this, 'add_custom_notification_type'], 200);
            add_filter('um_notifications_get_icon', [$this, 'add_custom_notification_icon'], 10, 2 );
            
            add_filter( 'um_email_notifications', [$this, 'um_new_user_signup_notification'], 10, 1);
            
            add_action( 'um_rise_new_user_notification', [$this, 'um_rise_new_user_notification'], 10, 2);
            
            add_action('um_before_email_notification_sending', [$this, 'find_and_replace_placeholders_before_send'], 10, 3);
            
        }
        
        
        public function um_new_user_signup_notification($email_notifications) {
            $email_notifications['account_new_user_notification'] = array(
              'key'           => 'account_new_user_notification',
              'title'         => __( 'Account New User Notification','um-friends' ),
              'subject'       => 'New RISE registration',
              'body'          => '{display_name} has just created an account on {site_name}. To view their profile click here:<br /><br />' .
                '{user_profile_link}<br /><br />' .
                'Here is the submitted registration form:<br /><br />' .
                '{submitted_registration}',
              'description'   => __('Whether to receive notification when a new user account is approved','ultimate-member'),
              'recipient'   => 'admin',
              'default_active' => true
            );
            
            UM()->options()->options = array_merge([
              'account_new_user_notification_on'      => 1,
              'account_new_user_notification_sub'      => 'New RISE registration',
            ], UM()->options()->options);
            
            return $email_notifications;
        }
        
        public function um_rise_new_user_notification($user_id, $group_id) {
            um_fetch_user( $user_id );
            
            $user_email = um_user('user_email');
            
            $emails = um_multi_admin_email();
            if ( ! empty( $emails ) ) {
                foreach ( $emails as $email ) {
                    UM()->mail()->send( $email, 'account_new_user_notification', array( 'admin' => true, 'user_id' => $user_id, 'email' => $user_email, 'group_id' => $group_id));
                }
            }
        }
        
        
        public function find_and_replace_placeholders_before_send( $email, $template, $args ) {
            switch ($template) {
                case 'account_new_user_notification':
                    if(isset($args['user_id'])) {
                        $user_id = $args['user_id'];
                        $email = $args['email'];
                        $group_id = $args['group_id'];
    
                        $this->user_id = $user_id;
                        $this->email = $email;
                        $this->group_id = $group_id;
    
                        add_filter( 'um_template_tags_patterns_hook', [$this, 'new_user_add_placeholder'], 10, 1 );
                        add_filter( 'um_template_tags_replaces_hook', [$this, 'new_user_add_replace_placeholder'], 10, 1 );
                    }
                break;
                default:
            }
        }
        
        public function approved_user_add_placeholder($placeholders) {
            $placeholders[] = '{user_profile_link}';
            $placeholders[] = '{site_url}';
            $placeholders[] = '{admin_email}';
            $placeholders[] = '{submitted_registration}';
            $placeholders[] = '{login_url}';
            $placeholders[] = '{password}';
            
            return $placeholders;
        }
        
        public function approved_user_add_replace_placeholder( $replace_placeholders ) {
            $user_id = $this->user_id;
            um_fetch_user($user_id);
            
            $user_data = get_userdata($user_id);
            
            $user_profile_url = um_user_profile_url($user_id);
            $user_email = um_user('email');
            $username = um_user('username');
            $firstname =  um_user('first_name');
            $activation_link =  um_user( 'account_activation_link' );
    
            $replace_placeholders[] = $user_profile_url;
            $replace_placeholders[] = get_bloginfo( 'url' );
            $replace_placeholders[] = um_admin_email();
            $replace_placeholders[] = um_user_submitted_registration_formatted();
            $replace_placeholders[] = um_get_core_page( 'login' );
            $replace_placeholders[] = esc_html__( 'Your set password', 'ultimate-member' );
            $replace_placeholders[] = $activation_link;
            
            return $replace_placeholders;
        }
        
        public function new_user_add_placeholder($placeholders) {
            $placeholders[] = '{rise_first_name}';
            $placeholders[] = '{rise_last_name}';
            $placeholders[] = '{rise_email}';
            $placeholders[] = '{rise_business_name}';
            $placeholders[] = '{rise_business_website}';
            $placeholders[] = '{rise_reg_business_address}';
            $placeholders[] = '{rise_reg_business_postcode}';
            $placeholders[] = '{rise_primary_area_operation}';
            $placeholders[] = '{rise_timestamps}';
            return $placeholders;
        }
        
        function new_user_add_replace_placeholder( $replace_placeholders ) {
            //get user details
            um_fetch_user( $this->user_id );
            
            $first_name = um_user('first_name');
            $last_name = um_user('last_name');
            $user_email = um_user('user_email');
            
            //get the groups joined
            $get_groups = UM()->Groups()->api()->get_joined_groups($this->user_id);
            
            $group_title = '';
            $business_website = '';
            $reg_business_address = '';
            $reg_business_postcode = '';
            $primary_area_operation = '';
            
            if(!empty($this->group_id)) {
                $group_id = $this->group_id;
                $group_details = get_post($group_id);
                
                $group_title = $group_details->post_title;
                
                $business_website = get_field('business_website', $group_id);
                $reg_business_address = implode(', ',
                  array_filter([
                    get_field('reg_business_address', $group_id),
                    get_field('reg_business_street', $group_id),
                    get_field('reg_business_city', $group_id),
                    get_field('reg_business_county', $group_id),
                  
                  ]));
                $reg_business_postcode = get_field('reg_business_postcode', $group_id);
            }
            
            //get business location through
            $user_taxonomy = UsersTaxonomy::get_instance()->get_specific_user_taxonomy($this->user_id);
            if(!empty($user_taxonomy[UsersTaxonomy::$location_taxonomy])) {
                $primary_area_operation = $user_taxonomy[UsersTaxonomy::$location_taxonomy][0]['name'];
            }
            
            $replace_placeholders[] = $first_name;
            $replace_placeholders[] = $last_name;
            $replace_placeholders[] = $user_email;
            $replace_placeholders[] = $group_title;
            $replace_placeholders[] = $business_website;
            $replace_placeholders[] = $reg_business_address;
            $replace_placeholders[] = $reg_business_postcode;
            $replace_placeholders[] = $primary_area_operation;
            $replace_placeholders[] = UM()->datetime()->get_time('j M Y');
            
            return $replace_placeholders;
        }
        
        
        public function add_custom_notification_type($not_array) {
            $not_array['account_new_user_notification'] = [
              'title' => 'Account New User Notification',
              'template' => '<strong>{member}</strong> has just did some action.',
              'account_desc' => 'When a new user registers on the website.',
            ];
            
            return $not_array;
        }
        
        public function add_custom_notification_icon($output, $type) {
            if ( $type == 'account_new_user_notification' ) {
                $output = '<i class="um-icon-android-person-add" style="color: #336699"></i>';
            }
            
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