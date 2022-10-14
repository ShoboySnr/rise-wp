<?php

namespace RiseWP\Api;

class Settings {

    public function __construct()
    {
        add_action('rise_wp_settings_side_menu', [$this, 'rise_wp_settings_side_menu'], 10, 1);

        add_shortcode('rise_wp_profile_accounts_settings', [$this, 'rise_wp_profile_accounts_settings']);
        add_shortcode('rise_wp_settings_report', [$this, 'rise_wp_settings_report']);
        add_shortcode('rise_wp_notification_preferences', [$this, 'rise_wp_notification_preferences']);

        //register action to update user email
        add_action('wp_ajax_rise_wp_update_user_email',[$this, 'rise_wp_update_user_email']);

        //register actoion to update user password
        add_action('wp_ajax_rise_wp_update_user_password',[$this, 'rise_wp_update_user_password']);

        //update user email notification prefernces
        add_action('wp_ajax_rise_wp_email_notification_messages',[$this, 'rise_wp_email_notification_messages']);
        add_action('wp_ajax_rise_wp_email_notification_replies',[$this, 'rise_wp_email_notification_replies']);

        //register action to update business information
        add_action('wp_ajax_rise_wp_update_business_information',[$this, 'rise_wp_update_business_information']);

        //remove user_ids from notification replies
        add_filter('bbp_get_subscribers', [$this, 'rise_wp_remove_certain_users_from_notifications'], 10, 3);

    }

    public function rise_wp_settings_side_menu($menus)
    {
        $msg = '';
        if(!empty($menus)) {
            $msg .= '<div class="col-span-5 md:col-span-2 py-6 bg-white rounded-xl border border-gray360">';

            foreach($menus as $menu) {
                $active_link = get_permalink() === $menu['link'] ? ' border-l-4 sidebar__button--active' : '';
                $msg .= ' <a href="' . $menu['link'] . '" class="flex gap-6 py-4 px-5 border-red w-full '.$active_link.'">';
                if(get_permalink() === $menu['link']) {
                    $msg .= $menu['active_page_icon'];
                } else {
                    $msg .= $menu['icon'];
                }

                $msg .= '<span>' .$menu['title'] . '</span>';
                $msg .= '</a>';
            }
            $msg .= '</div>';
        }

        echo $msg;
    }

    public function rise_wp_profile_accounts_settings($atts) {
        $args = shortcode_atts([
            'user_id'       => get_current_user_id(),
        ], $atts);

        $user_id = $args['user_id'];

        $group_id = UltimateMembers::get_instance()->get_group_id($user_id);

        $group_role = UltimateMembers::get_instance()->get_role($group_id, $user_id);

        $output  = $this->change_email_form($user_id);
        $output .= $this->change_password_form($user_id);

        //allow only admin have access to this form
        if($group_role === 'admin') $output .= $this->change_business_information_form($group_id, $user_id);


        return $output;
    }

    public function rise_wp_settings_report($atts) {
        $args = shortcode_atts([
            'user_id'       => get_current_user_id(),
        ], $atts);

        $user_id = $args['user_id'];

        return $this->report_a_problem_form($user_id);
    }

    public function rise_wp_notification_preferences($atts) {
        $args = shortcode_atts([
            'user_id'       => get_current_user_id(),
        ], $atts);

        $user_id = $args['user_id'];

        return $this->user_notification_form($user_id);
    }

    public function user_notification_form($user_id) {
        $nonce = wp_create_nonce('rise_wp_user_notification_form');

        $default_email_status = get_user_meta( $user_id, '_enable_new_pm', true);

        $email_checked = 'checked';
        if(get_user_meta( $user_id, '_enable_new_pm', true) == 'no' || get_user_meta( $user_id, '_enable_reminder_pm', true) == 'no') {
            $email_checked = '';
        }

        $replies_email_checked = 'checked';
        if(get_user_meta( $user_id, '_rise_wp_enable_replies', true) == 'no') {
            $replies_email_checked = '';
        }

        $msg =  '<div class="bg-white rounded-xl border border-gray360 mb-9" id="user-notification-form" data-nonce="'.$nonce.'">';
        $msg .= '<div>';
        $msg .=  '<h2 class="text-riseDark font-heading text-lg font-medium pt-4 md:pt-11 pb-4 border-b border-gray360 mx-4 md:mx-11">'.__('Email notification', 'rise-wp-theme').'<span class="success-message ml-4 text-orange inline-flex"></span></h2>';
        $msg .= '<div class="mx-4 md:mx-11 py-4 border-b border-gray360 flex justify-between">';
        $msg .= '<p class="text-gray250">'.__('Messages', 'rise-wp-theme') .'</p>';
        $msg .= '<div class="switch-box '. $email_checked .'">
                    <label class="switch" title="accessibility switch" for="email_notification_messages">
                      <span class="sr-only">'.__('Use setting', 'rise-wp-theme').'</span>
                      <input aria-label="contrast-mode"  type="checkbox" name="email_notification_messages" id="email_notification_messages" aria-hidden="true"
                        class="switch-btn" '.$email_checked.'>
                    </label>
                  </div>';
        $msg .= '</div>';
        $msg .= '<div class="mx-4 md:mx-11 py-4 flex justify-between">';
        $msg .= '<p class="text-gray250">'.__('Replies to your forum posts', 'rise-wp-theme').'</p>';
        $msg .= '<div class="switch-box '. $replies_email_checked .'">
                    <label class="switch" title="accessibility switch" for="email_notification_replies">
                      <span class="sr-only">'.__('Use setting', 'rise-wp-theme').'</span>
                      <input aria-label="contrast-mode" type="checkbox" name="email_notification_replies" id="email_notification_replies" aria-hidden="true"
                        class="switch-btn" '. $replies_email_checked .'>
                    </label>
                  </div>';
        $msg .= '</div>';
        $msg .= '</div>';
        $msg .= '</div>';
        $msg .= '</div>';

        return $msg;

    }

    public function report_a_problem_form($user_id) {
        $shortcode = get_field('contact_form_shortcode');

        $msg =  '<div class="bg-white rounded-xl border border-gray360 mb-9" id="report-a-problem">';
        $msg .= '<div>';
        $msg .=  '<h2 class="text-riseDark font-heading text-lg font-medium pt-4 md:pt-11 pb-4 border-b border-gray360 mx-4 md:mx-11">'.__('Report a problem', 'rise-wp-theme').'</h2>';
        $msg .= '<div class="mx-4 md:mx-11 py-4">';
        $msg .= '<p style="color: #606060">'.__('Please let us know if you encounter any technical or
        content issues with the site by filling in the contact form below.  We will update you on any fixes we make.', 'rise-wp-theme').'</p>';
        $msg .= do_shortcode($shortcode);
        $msg .= '</div>';
        $msg .= '</div>';
        $msg .= '</div>';

        return $msg;
    }

    public function change_email_form($user_id) {
        $this_user = get_user_by('ID', $user_id);

        $email = $this_user->data->user_email;
        $nonce = wp_create_nonce('rise_wp_change_email_form');
        $msg = '<div class="bg-white rounded-xl border border-gray360 mb-9">';

        $msg .= '<div><h2 class="text-riseDark font-heading text-lg font-medium pt-4 md:pt-11 pb-4 border-b border-gray360 mx-4 md:mx-11">'. __('Personal details', 'rise-wp-theme') .'</h2>';
        $msg .= '<div class="px-4 md:px-11 py-4 md:py-11 border-b border-gray360">';
        $msg .= '<div><label class="text-base text-sm mb-2 capitalize text-riseBodyText">'. __('Email Address', 'rise-wp-theme') .'</label>';

        $msg .= '<input value="'.$email.'" type="email" class="w-full h-15 border border-gray50 dark:border-white dark:bg-black rounded-full outline-none focus:border-gray250 pl-4" name="user_email" data-nonce="'.$nonce.'">';
        $msg .= '<span class="text-red error"></span>';
        $msg .= '</div></div>';
        $msg .= '<div class="flex justify-end px-4 md:px-11 py-6 items-center"><div class="success-message text-orange mr-4"></div>';
        $msg .= '<button type="button" class="bg-red text-white rounded-full py-2 px-10" id="change-user-email">'.__('Save', 'rise-wp-theme') .'</button></div>';
        $msg .= '</div></div>';

        return $msg;
    }

    public function change_password_form($user_id) {
        $nonce = wp_create_nonce('rise_wp_change_password_form');

        $msg = '<div class="bg-white rounded-xl border border-gray360 mb-9" id="change-password-container" data-nonce="'.$nonce.'">';

        $msg .= '<div><h2 class="text-riseDark font-heading text-lg font-medium pt-4 md:pt-11 pb-4 border-b border-gray360 mx-4 md:mx-11">'. __('Change password', 'rise-wp-theme') .'</h2>';

        $msg .= '<div class="px-4 md:px-11 py-4 md:py-11 border-b border-gray360">';
        $msg .= '<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">';
        $msg .= '<div><label class="text-base text-sm mb-2 capitalize text-riseBodyText">'. __('Previous Password', 'rise-wp-theme') .'</label>';

        $msg .= '<input name="prev_password" class="w-full h-15 border border-gray50 dark:border-white dark:bg-black rounded-full outline-nonefocus:border-gray250 pl-4" type="password" placeholder="'. __('Enter previous password', 'rise-wp-theme').'">';
        $msg .= '<span class="text-red error"></span>';
        $msg .= '</div></div>';
        $msg .= '<div class="grid grid-cols-1 lg:grid-cols-2 pt-10 gap-6">';
        $msg .= '<div><label class="text-base text-sm mb-2 capitalize text-riseBodyText">'.__('New Password', 'rise-wp-theme').'</label>';
        $msg .= '<input name="new_password" class="w-full h-15 border border-gray50 dark:border-white dark:bg-black rounded-full outline-none focus:border-gray250 pl-4" type="password" placeholder="'.__('Enter New password', 'rise-wp-theme').'">';
        $msg .= '<span class="text-red error"></span>';
        $msg .= '</div><div>';
        $msg .= '<label class="text-base text-sm mb-2 capitalize text-riseBodyText">'.__('Confirm New password', 'rise-wp-theme').'</label>';
        $msg .= '<input name="confirm_new_password" class="w-full h-15 border border-gray50 dark:border-white dark:bg-black rounded-full outline-none focus:border-gray250 pl-4" type="password" placeholder="'.__('Enter New password', 'rise-wp-theme').'">';
        $msg .= '<span class="text-red error"></span>';
        $msg .= '</div></div></div>';
        $msg .= '<div class="flex justify-end px-4 md:px-11 py-6 items-center"><div class="success-message text-orange mr-4"></div>';
        $msg .= '<button type="button" class="bg-red text-white rounded-full py-2 px-10" id="change-password-button">'.__('Change Password', 'rise-wp-theme').'</button>';
        $msg .= '</div></div></div>';

        return $msg;
    }

    public function change_business_information_form($group_id, $user_id) {
        $group_information = get_post($group_id);

        $group_title = $group_information->post_title;
        $business_website = get_field('business_website', $group_id);
        $reg_business_address = get_field('reg_business_address', $group_id);
        $reg_business_street = get_field('reg_business_street', $group_id);
        $reg_business_city = get_field('reg_business_city', $group_id);
        $reg_business_county = get_field('reg_business_county', $group_id);
        $reg_business_postcode = get_field('reg_business_postcode', $group_id);
        $business_primary_sector = get_field('business_primary_sector', $group_id);
        $business_services = get_field('business_services', $group_id);

        $taxonomies_array = UsersTaxonomy::$taxonomies_array;
        $terms = [];
        $default_term = [];
        foreach ($taxonomies_array as $value) {
            $args = [
                'taxonomy' => $value,
                'hide_empty' => false,
            ];

            $find_terms = get_terms($args);

            foreach($find_terms as $find_term) {
                $terms[$value][] = [
                    'id'        => $find_term->term_id,
                    'title'        => $find_term->name,
                    'slug'        => $find_term->slug,
                ];
            }

            $object_terms = wp_get_object_terms($group_id, $value);
            if(isset($object_terms[0]) && !empty($object_terms)) {
                $object_terms = $object_terms[0];
                $default_term[$value][] = $object_terms->term_id;
            } else {
                $default_term[$value] = [];
            }
        }


        $nonce = wp_create_nonce('rise_wp_change_business_information_form');

        $msg = '<form action="" class="bg-white rounded-xl border border-gray360 mb-9" id="business-update-container" data-nonce="'.$nonce.'">';
        $msg .= '<div><h2 class="text-riseDark font-heading text-lg font-medium pt-4 md:pt-11 pb-4 border-b border-gray360 mx-4 md:mx-11">'. __('Business details', 'rise-wp-theme') .'</h2>';
        $msg .= '<div class="px-4 md:px-11 py-4 md:py-11 border-b border-gray360">';
        $msg .= '<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">';
        $msg .= '<div><label class="text-base text-sm mb-2 capitalize text-riseBodyText">'.__('Business name', 'rise-wp-theme').'</label>';
        $msg .= '<input name="group_name" class="w-full h-15 border border-gray50 dark:border-white dark:bg-black rounded-full outline-none focus:border-gray250 pl-4" type="text" value="'.$group_title.'">';
        $msg .= '<span class="text-red error"></span>';
        $msg .= '</div>';
        $msg .= '<div><label class="text-base text-sm mb-2 capitalize text-riseBodyText">'.__('Business website', 'rise-wp-theme') .'</label>';
        $msg .= '<input name="business_website" class="w-full h-15 border border-gray50 dark:border-white dark:bg-black rounded-full outline-none focus:border-gray250 pl-4" type="text" value="'.$business_website.'">';
        $msg .= '</div></div>';
        $msg .= '<div class="grid grid-cols-1 lg:grid-cols-2 pt-10 gap-6">';
        $msg .= '<div><label class="text-base text-sm mb-2 capitalize text-riseBodyText">'.__('Location', 'rise-wp-theme').'</label>';
        $msg .= '<select class="w-full h-15 border border-gray50 dark:border-white dark:bg-black rounded-full outline-none focus:border-gray250 pl-4 select" name="location_taxonomy">';
        $msg .= '<option value="">'. __('Select option', 'rise-wp-theme').'</option>';

        foreach ($terms['location_taxonomy'] as $location) {
            $selected = in_array($location['id'], $default_term['location_taxonomy']) ? 'selected' : '';
            $msg .= '<option value="'.$location['id'].'"'.$selected.'>'.$location['title'].'</option>';
        }

        $msg .= '</select>';

        $msg .= '</div>';
        $msg .= '<div><label class="text-base text-sm mb-2 capitalize text-riseBodyText">'.__('Industry', 'rise-wp-theme').'</label>';
        $msg .= '<select class="w-full h-15 border border-gray50 dark:border-white dark:bg-black rounded-full outline-none focus:border-gray250 pl-4 select" name="industries_taxonomy">';
        $msg .= '<option value="">'. __('Select option', 'rise-wp-theme').'</option>';

        foreach ($terms['industries_taxonomy'] as $location) {
            $selected = in_array($location['id'], $default_term['industries_taxonomy']) ? 'selected' : '';
            $msg .= '<option value="'.$location['id'].'"'.$selected.'>'.$location['title'].'</option>';
        }

        $msg .= '</select>';

        $msg .= '</div></div>';
        $msg .= '<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-10">';
        $msg .= '<div><label class="text-base text-sm mb-2 capitalize text-riseBodyText">'.__('Street 1', 'rise-wp-theme') .'</label>';
        $msg .= '<input name="business_address" class="w-full h-15 border border-gray50 dark:border-white dark:bg-black rounded-full outline-none focus:border-gray250 pl-4" type="text" value="'.$reg_business_address.'">';
        $msg .= '</div>';
        $msg .= '<div><label class="text-base text-sm mb-2 capitalize text-riseBodyText">'.__('Street 2', 'rise-wp-theme') .'</label>';
        $msg .= '<input name="business_street" class="w-full h-15 border border-gray50 dark:border-white dark:bg-black rounded-full outline-none focus:border-gray250 pl-4" type="text" value="'.$reg_business_street.'">';
        $msg .= '</div></div>';
        $msg .= '<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-10">';
        $msg .= '<div><label class="text-base text-sm mb-2 capitalize text-riseBodyText">'.__('Town', 'rise-wp-theme') .'</label>';
        $msg .= '<input name="business_city" class="w-full h-15 border border-gray50 dark:border-white dark:bg-black rounded-full outline-none focus:border-gray250 pl-4" type="text" value="'.$reg_business_city.'">';
        $msg .= '</div>';
        $msg .= '<div><label class="text-base text-sm mb-2 capitalize text-riseBodyText">'.__('County', 'rise-wp-theme') .'</label>';
        $msg .= '<input name="business_county" class="w-full h-15 border border-gray50 dark:border-white dark:bg-black rounded-full outline-none focus:border-gray250 pl-4" type="text" value="'.$reg_business_county.'">';
        $msg .= '</div></div>';
        $msg .= ' <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-10 items-center">';
        $msg .= '<div><label class="text-base text-sm mb-2 capitalize text-riseBodyText">'.__('Postcode', 'rise-wp-theme') .'</label>';
        $msg .= '<input name="business_postcode" class="w-full h-15 border border-gray50 dark:border-white dark:bg-black rounded-full outline-none focus:border-gray250 pl-4" type="text" value="'. $reg_business_postcode.'">';
        $msg .= '</div>';

        $group_image = get_the_post_thumbnail_url($group_id);
        $add_uploaded_class = 'upload-logo';
        $add_upload_text = __('Upload your logo', 'rise-wp-theme');
        $file_type = 'file';
        if(!empty($group_image)) {
            $add_uploaded_class = 'uploaded';
            $add_upload_text = __('Remove logo', 'rise-wp-theme');
            $file_type = 'hidden';
        }

        $msg .= '<div class="flex gap-4 items-start group-image-upload">';

        if(!empty($group_image)) {
            $msg .= '<svg focusable="true" width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="cursor-pointer">
                   <circle cx="40" cy="40" r="39.5" fill="#DB3C0E" stroke="#DB3C0E"/>
                    <path d="M31.9189 45.5705H48.8886M40.4038 34V45.3131M40.4038 34L35.0046 39.3992M40.4038 34L45.803 39.3992" stroke="#fff" stroke-width="2"/>
                </svg>';
        } else {
            $msg .= '<svg focusable="true" width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="cursor-pointer">
                   <circle cx="40" cy="40" r="39.5" fill="#F7F7F7" stroke="#E6E6E6"/>
                    <path d="M31.9189 45.5705H48.8886M40.4038 34V45.3131M40.4038 34L35.0046 39.3992M40.4038 34L45.803 39.3992" stroke="#A9A9A9" stroke-width="2"/>
                </svg>';
        }


        $msg .= '<div><button type="button" class="rounded-full py-2 px-4 bg-gray100 text-red border border-red '.$add_uploaded_class.'">'.$add_upload_text.'</button>';
        $msg .= ' <p class="text-sm" style="color: #6e6e6e">'.__('Maximum upload file size: 5 MB.', 'rise-wp-theme'). '</p>';
        $msg .= '<input type="'. $file_type.'" accept="image/png, image/jpeg" name="group_image" class="hidden" />';
        $msg .= '<input type="hidden" name="action" value="rise_wp_update_business_information" class="hidden" />';
        $msg .= '<input type="hidden" name="nonce" value="'.$nonce.'" class="hidden" />';
        $msg .= '</div>';
        $msg .= '</div></div></div>';
        $msg .= '<div class="flex justify-end px-4 md:px-11 py-6 items-center"><div class="success-message text-orange mr-4"></div>';
        $msg .= '<button type="submit" class="bg-red text-white rounded-full py-2 px-10" id="business-update-button">'.__('Save', 'rise-wp-theme').'</button>';
        $msg .= '</div></div></form>';

        return $msg;
    }

    public function rise_wp_update_user_email() {

        //verify nonce
        if ( !wp_verify_nonce( $_POST['nonce'], "rise_wp_change_email_form")) {
            $response['status'] = false;
            $response['message'] = __('<p>There was a problem changing your email. Please refresh your page and try again.</p>', 'rise-wp-theme');

            echo json_encode($response);
            wp_die();
        }

        $email = sanitize_email($_POST['data']['email']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['status'] = false;
            $response['message'] = __('<p>Invalid Email format</p>', 'rise-wp-theme');

            echo json_encode($response);
            wp_die();
        }

        $user_id = get_current_user_id();
        $user = get_user_by('ID', $user_id);
        if(empty($user)) {
            $response['status'] = false;
            $response['user_does_not_exists'] = true;
            $response['message'] = __('<p>This user does not exits</p>', 'rise-wp-theme');

            echo json_encode($response);
            wp_die();
        }

        $user_data = [
            'ID'            => $user_id,
            'user_email'     => $email
        ];

        if(wp_update_user($user_data)) {
            $response['status'] = true;
            $response['message'] = __('<p>Email Successfully updated</p>', 'rise-wp-theme');

            echo json_encode($response);
            wp_die();
        }

        $response['status'] = false;
        $response['message'] = __('<p>There was an error updating your email</p>', 'rise-wp-theme');

        echo json_encode($response);
        wp_die();
    }

    public function rise_wp_update_user_password() {
        //verify nonce
        if ( !wp_verify_nonce( $_POST['nonce'], "rise_wp_change_password_form")) {
            $response['status'] = false;
            $response['message'] = __('<p>There was a problem changing your password. Please refresh your page and try again.</p>', 'rise-wp-theme');

            echo json_encode($response);
            wp_die();
        }

        $prev_password = $_POST['data']['prev_password'];
        $new_password = $_POST['data']['new_password'];

        $user_id = get_current_user_id();
        $user = get_user_by('ID', $user_id);

        if(empty($user)) {
            $response['status'] = false;
            $response['user_does_not_exists'] = true;
            $response['message'] = __('<p>This user does not exits</p>', 'rise-wp-theme');

            echo json_encode($response);
            wp_die();
        }

        if(!wp_check_password($prev_password, $user->data->user_pass, $user->ID)) {
            $response['status'] = false;
            $response['message'] = __('<p>You have entered a wrong password</p>', 'rise-wp-theme');

            echo json_encode($response);
            wp_die();
        }
        um_fetch_user($user_id);

        //send email to user
        UM()->user()->password_changed();

        add_filter( 'send_password_change_email', '__return_true' );

        //if all is successful, then finally update the password
        wp_set_password($new_password, $user_id);

        //reset cookies so the user does not get disabled when password changed
        wp_set_auth_cookie($user_id, true);

        $response['status']  = true;
        $response['message'] = __('<p>Password Successfully updated.</p>', 'rise-wp-theme');

        echo json_encode($response);
        wp_die();
    }

    public function rise_wp_remove_certain_users_from_notifications($user_ids, $object_id, $type ) {
        if(!empty($user_ids)) {
            foreach ($user_ids as $key => $user_id) {
                $notification_status = get_user_meta($user_id, '_rise_wp_enable_replies', true);
                if(!empty($notification_status) && $notification_status == 'no') {
                    unset($user_ids[$key]);
                }
            }
        }

        return $user_ids;
    }

    public function rise_wp_email_notification_replies() {
        //verify nonce
        if ( !wp_verify_nonce( $_POST['nonce'], "rise_wp_user_notification_form")) {
            $response['status'] = false;
            $response['message'] = __('<p>There was a problem updating your preferences. Please refresh your page and try again.</p>', 'rise-wp-theme');

            echo json_encode($response);
            wp_die();
        }

        $user_id = get_current_user_id();

        $email_enabled = $_POST['data']['email_enabled'];
        if($email_enabled === 'true') {
            $_POST['_rise_wp_enable_replies'] = $email_enabled;
        }

        //copied from um_messaging core folder class-messaging-account.php L40
        if ( isset( $_POST['_rise_wp_enable_replies'] ) ) {
            update_user_meta( $user_id, '_rise_wp_enable_replies', 'yes' );
            $response['message'] = __('<p>Email notification for replies turned on.</p>', 'rise-wp-theme');
            $response['checked'] = true;
        } else {
            update_user_meta( $user_id, '_rise_wp_enable_replies', 'no' );
            $response['message'] = __('<p>Email notification for replies turned off.</p>', 'rise-wp-theme');
            $response['checked'] = false;
        }

        $response['status']  = true;

        echo json_encode($response);
        wp_die();

    }

    public function rise_wp_email_notification_messages() {
        //verify nonce
        if ( !wp_verify_nonce( $_POST['nonce'], "rise_wp_user_notification_form")) {
            $response['status'] = false;
            $response['message'] = __('<p>There was a problem updating your preferences. Please refresh your page and try again.</p>', 'rise-wp-theme');

            echo json_encode($response);
            wp_die();
        }

        $user_id = get_current_user_id();

        $email_enabled = $_POST['data']['email_enabled'];
        if($email_enabled === 'true') {
            $_POST['_enable_new_pm'] = $email_enabled;
            $_POST['_enable_reminder_pm'] = $email_enabled;
        }

        //copied from um_messaging core folder class-messaging-account.php L40
        if ( isset( $_POST['_enable_new_pm'] ) ) {
            update_user_meta( $user_id, '_enable_new_pm', 'yes' );
            update_user_meta( $user_id, '_enable_reminder_pm', 'yes' );
            $response['message'] = __('<p>Email notification turned on.</p>', 'rise-wp-theme');
            $response['checked'] = true;
        } else {
            update_user_meta( $user_id, '_enable_new_pm', 'no' );
            update_user_meta( $user_id, '_enable_reminder_pm', 'no' );
            $response['message'] = __('<p>Email notification turned off.</p>', 'rise-wp-theme');
            $response['checked'] = false;
        }

        $response['status']  = true;

        echo json_encode($response);
        wp_die();

    }

    public function rise_wp_update_business_information() {
        //verify nonce
        if ( !wp_verify_nonce( $_POST['nonce'], "rise_wp_change_business_information_form")) {
            $response['status'] = false;
            $response['message'] = __('<p>There was a problem updating your business information. Please refresh your page and try again.</p>', 'rise-wp-theme');

            echo json_encode($response);
            wp_die();
        }

        $user_id = get_current_user_id();
        $group_id = UltimateMembers::get_instance()->get_group_id($user_id);


        $group_name = sanitize_text_field($_POST['group_name']);
        $business_website = $_POST['business_website'];
        $location_taxonomy = $_POST['location_taxonomy'];
        $industries_taxonomy = $_POST['industries_taxonomy'];
        $business_address = $_POST['business_address'];
        $business_street = $_POST['business_street'];
        $business_city = $_POST['business_city'];
        $business_country = $_POST['business_county'];
        $business_postcode = $_POST['business_postcode'];


        //making sure images are safe to upload
        if(!empty($_FILES['group_image'])) {
            $group_image = $_FILES['group_image'];
            $allowed_types = array(IMAGETYPE_PNG, IMAGETYPE_JPEG);
            $max_file_size = 5000000; //5MB allowed size

            $detected_type = exif_imagetype($group_image['tmp_name']);

            if(!empty($group_image['name'])) {
                //check if the image file is allowd
                if(!in_array($detected_type, $allowed_types)) {
                    $response['status'] = false;
                    $response['message'] = __('<p>Group image uploaded not allowed.</p>', 'rise-wp-theme');

                    echo json_encode($response);
                    wp_die();
                }

                if($group_image['size'] >= $max_file_size) {
                    $response['status'] = false;
                    $response['message'] = __('<p>Group image file size exceeds the limits (5MB).</p>', 'rise-wp-theme');

                    echo json_encode($response);
                    wp_die();
                }
            }
        }


        try {
            $group_posts = get_post($group_id);

            if(!empty($group_posts)) {
                $postarr = [
                    'ID'        => $group_posts->ID,
                    'post_title'        => $group_name,
                ];
                if(wp_update_post($postarr)) {
                    //handle file upload
                    if(!empty($_FILES['group_image']['name'])) {
                        $group_image = $_FILES['group_image'];
                        $group_image_name = preg_replace('/\s+/', '-', $group_image['name']);
                        $group_image_name = preg_replace('/[^A-Za-z0-9.\-]/', '', $group_image_name);
                        $group_image_name = time().'-'.$group_image_name;

                        $upload = wp_upload_bits($group_image_name, null, file_get_contents($group_image['tmp_name']));

                        if ( ! $upload['error'] ) {
                            $filename = $upload['file'];
                            $wp_filetype = wp_check_filetype($filename, null);
                            $attachment = array(
                                'post_mime_type' => $wp_filetype['type'],
                                'post_title' => sanitize_file_name($filename),
                                'post_content' => '',
                                'post_status' => 'inherit'
                            );

                            $attachment_id = wp_insert_attachment($attachment, $filename, $group_id );

                            if ( ! is_wp_error( $attachment_id ) ) {
                                require_once(ABSPATH . 'wp-admin/includes/image.php');

                                $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
                                wp_update_attachment_metadata( $attachment_id, $attachment_data );
                                set_post_thumbnail( $group_id, $attachment_id );
                            }
                        }
                    } else if(isset($_FILES['group_image']['name'])) {
                        delete_post_thumbnail($group_id);
                    }

                    update_field('business_website', $business_website, $group_id);
                    update_field('reg_business_address', $business_address, $group_id);
                    update_field('reg_business_postcode', $business_postcode, $group_id);
                    update_field('reg_business_street', $business_street, $group_id);
                    update_field('reg_business_city', $business_city, $group_id);
                    update_field('reg_business_county', $business_country, $group_id);

                    //update the taxonomies
                    $_POST['industries_taxonomy'] = $industries_taxonomy;
                    UsersTaxonomy::get_instance()->save_user_industries_taxonomy_terms($group_id);

                    $_POST['location_taxonomy'] = $location_taxonomy;
                    UsersTaxonomy::get_instance()->save_user_location($group_id);

                    $response['status']  = true;
                    $response['message'] = __('<p>Business information successfully updated.</p>', 'rise-wp-theme');

                    echo json_encode($response);
                    wp_die();
                }
            }
        } catch (\Exception $e) {
            echo json_encode($e->getMessage());
            wp_die();
        }

    }

    /**
     * Singleton poop.
     *
     * @return Settings|null
     */
    public static function get_instance() {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }
}
