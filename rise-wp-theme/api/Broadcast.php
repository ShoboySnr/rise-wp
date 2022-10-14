<?php


namespace RiseWP\Api;

class Broadcast
{
    public $post_type = 'broadcast';
    
    
    public function __construct()
    {
        add_action('admin_init', [$this, 'add_post_meta_boxes']);
        add_action('publish_broadcast', [$this, 'save_post_meta_boxes'], 10, 2);
        
        //add columns to the table
        add_filter('manage_' . $this->post_type . '_posts_columns', [$this, 'custom_post_type_columns']);
        add_action('manage_' . $this->post_type . '_posts_custom_column', [$this, 'fill_custom_post_type_columns'], 10, 2);
        
        //remove seo yoasts columns
        add_filter('manage_edit-post_columns', [$this, 'yoast_seo_admin_remove_columns'], 10, 1);
        add_filter('manage_edit-page_columns', [$this, 'yoast_seo_admin_remove_columns'], 10, 1);
        
        add_action('rest_after_insert_post', [$this, 'read_my_meta_field'], 10, 2);
        add_action('rise_send_broadcast_email', [$this, 'send_broadcast_email'], 10, 2);
    }
    
    function read_my_meta_field($post, $request)
    {
        global $post;
        $my_meta_field = get_post_meta($post->ID, 'rise_members_broadcast', true);
        
        return $my_meta_field;
    }
    
    public function save_post_meta_boxes($post_id, $post)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        if (isset($post->ID) && get_post_status($post->ID) === 'auto-draft') {
            return;
        }
        
        if(isset($_POST['rise_broadcast_nonce']) && wp_verify_nonce($_POST['rise_broadcast_nonce'], 'broadcast-members-nonce')) {
            
            $members = isset($_POST["rise_members_category"]) ? (array) $_POST["rise_members_category"] : [];
            
            $args = [
                'role' => 'um_full-membership',
                'search_columns' => ['ID'],
                'fields' => 'ids',
            ];
    
            if(!empty($members)) $args['include'] = $members;
    
            $users = get_users($args);
    
            do_action('rise_send_broadcast_email', $users, $post);
    
            update_post_meta($post_id, "rise_members_broadcast_meta", json_encode($members));
        }
    
    }
    
    
    public function send_broadcast_email($users, $post)
    {
        if (!empty($users)) {
            add_filter( 'wp_mail_content_type', [$this, 'set_the_mail_content_format']);
            
            foreach($users as $user) {
                $this->sendEmail($user, $post);
            }
    
            remove_filter( 'wp_mail_content_type', [$this, 'set_the_mail_content_format']);
        }
    }
    
    public function sendEmail($user_id, $post)
    {
        $userData = get_userdata($user_id);
        
        $email = $userData->user_email;
        $contents = get_the_content($post->ID);
    
        wp_mail($email, $post->post_title, $contents);
    }
    
    public function set_the_mail_content_format() {
        return 'text/html';
    }
    
    
    public function get_post_meta_fields($post)
    {
        $posts = get_post_meta($post, "rise_members_broadcast_meta", true);
        
        if (!empty($posts)) {
            return json_decode($posts, TRUE);
        }
        
        return [];
    }
    
    public function yoast_seo_admin_remove_columns($columns)
    {
        unset($columns['wpseo-score']);
        unset($columns['wpseo-score-readability']);
        unset($columns['wpseo-title']);
        unset($columns['wpseo-metadesc']);
        unset($columns['wpseo-focuskw']);
        unset($columns['wpseo-links']);
        unset($columns['wpseo-linked']);
        return $columns;
    }
    
    
    public function add_post_meta_boxes()
    {
        global $typenow, $wpseo_meta_columns;
        
        add_meta_box(
            'post_metadata_rise_members_category',
            'Send to Members',
            [$this, 'post_meta_box_rise_members_category'],
            $this->post_type,
            'side',
            'core'
        );
        
        //remove SEO filter from the activities page
        if ($typenow == $this->post_type) {
            if ($wpseo_meta_columns) {
                remove_action('restrict_manage_posts', array($wpseo_meta_columns, 'posts_filter_dropdown'));
                remove_action('restrict_manage_posts', array($wpseo_meta_columns, 'posts_filter_dropdown_readability'));
            }
        }
    }
    
    public function post_meta_box_rise_members_category()
    {
        global $post;
        
        $args = [
            'role' => 'um_full-membership',
            'search_columns' => ['ID'],
            'fields' => ['ID', 'display_name', 'user_nicename', 'user_email'],
        ];
        
        $users = get_users($args);
        
        
        $saved_users = $this->get_post_meta_fields($post->ID);
        
        $broadcast_nonce = wp_create_nonce('broadcast-members-nonce');
        
        
        
        $msg = '<div class="rise-members-category">';
        $msg .= '<h3>' . __('Select Members', 'rise-wp-theme') . '</h3>';
        $msg .= '<div class="members-container">';
        $msg .= '<input type="hidden" name="rise_broadcast_nonce" id="rise_broadcast_nonce" value="'.$broadcast_nonce.'" />';
        $msg .= '<select name="rise_members_category[]" class="members-select rise-wp-theme-select2-js" multiple="multiple">';
        $msg .= '<option value="">' . __('Choose members', 'rise-wp-theme') . '</option>';
        foreach ($users as $user) {
            $selected = '';
            $userdata = get_userdata($user->ID);
            $name = $userdata->first_name . ' ' . $userdata->last_name;
            if (strlen($name) < 3) $name = $user->display_name;
            if (in_array($user->ID, $saved_users)) {
                $selected = 'selected';
            }
            $msg .= '<option value="' . $user->ID . '" ' . $selected . '>' . $name . '</option>';
        }
        
        $msg .= '</select>';
        $msg .= '</div></div>';
        
        echo $msg;
    }
    
    
    public function custom_post_type_columns($columns)
    {
        //remove columns
        unset($columns['wpseo-score']);
        unset($columns['wpseo-score-readability']);
        unset($columns['wpseo-title']);
        unset($columns['wpseo-metadesc']);
        unset($columns['wpseo-focuskw']);
        unset($columns['wpseo-links']);
        unset($columns['wpseo-linked']);
        
        return array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Broadcast Title'),
            'custom_members' => __('Recipients', 'rise-wp-theme'),
            'date' => __('Date')
        );
    }
    
    public function fill_custom_post_type_columns($column, $post_id)
    {
        $args = [
            'role' => 'um_full-membership',
            'search_columns' => ['ID', 'display_name'],
            'fields' => ['ID', 'display_name', 'user_email'],
        ];
        
        $saved_members = $this->get_post_meta_fields($post_id);
        
        switch ($column) {
            case 'custom_members':
                echo '<div class="rise-actvities-show-members">';
                if(!empty($saved_members)) {
                    $array_users = [];
                    foreach ($saved_members as $user) {
                        $user = get_userdata($user);
                        $edit_user_url = get_edit_user_link($user->ID);
                        $name = $user->first_name . ' ' . $user->last_name;
                        if (strlen($name) < 3) $name = $user->display_name;
                        $array_users[] = '<a href="' . $edit_user_url . '">' . $name . '</a>';
                    }
                    echo implode(', ', $array_users);
                } else {
                 echo '<p>'.__('All Members', 'rise-wp'). '</p>';
                }
    
                echo '</div>';
                break;
        }
    }
    
    
    /**
     * Singleton poop.
     *
     * @return self
     */
    public static function get_instance()
    {
        static $instance = null;
        
        if (is_null($instance)) {
            $instance = new self();
        }
        
        return $instance;
    }
}
