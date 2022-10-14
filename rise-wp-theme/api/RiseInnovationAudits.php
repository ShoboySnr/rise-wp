<?php

namespace RiseWP\Api;


use RiseWP\Classes\Utilities;

class RiseInnovationAudits {

    public $post_type = 'rise-innovation';

    public function __construct()
    {
        add_action( 'admin_init', [$this, 'add_post_meta_boxes']);
        add_action( 'save_post', [$this, 'save_post_meta_boxes'], 10, 3);

        //add columns to the table
        add_filter('manage_'.$this->post_type.'_posts_columns' , [$this,'custom_post_type_columns']);
        add_action('manage_'.$this->post_type.'_posts_custom_column' , [$this,'fill_custom_post_type_columns'],10, 2);

        //add coluns to the users
        add_filter('manage_users_columns' , [$this,'modify_users_columns']);
        add_filter('manage_users_custom_column' , [$this,'modify_users_custom_column'], 10, 3);

        //manage posts
        add_action('restrict_manage_posts', [$this, 'restrict_manage_posts']);
        add_action('pre_get_posts', [$this, 'filter_query_by_members']);

        add_shortcode('rise_innovation_audits', [$this, 'rise_innovation_audits']);

        //remove seo yoasts columns
        add_filter( 'manage_edit-post_columns', [$this, 'yoast_seo_admin_remove_columns'], 10, 1);
        add_filter( 'manage_edit-page_columns', [$this,'yoast_seo_admin_remove_columns'], 10, 1);
    }
    
    public function save_post_meta_boxes($post_id, $post, $update)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        if (isset($post->ID) && get_post_status($post->ID) === 'auto-draft') {
            return;
        }
        
        if ($post->post_type === $this->post_type) {
            $members = isset($_POST["rise_members_category"]) ? (array)$_POST["rise_members_category"] : [];
            
            if (!empty($members)) {
                $members = json_encode($members);
                update_post_meta($post->ID, "rise_members_innovations_meta", $members);
            }
        }
    }

    public function rise_innovation_audits($atts) {
        $args = shortcode_atts([
            'user_id'       => get_current_user_id(),
        ], $atts);


        $user_id = $args['user_id'];
        $paged = get_query_var( 'paged');
        
        $args = [
            'post_type'         => $this->post_type,
            'paged'              => $paged
        ];
    
        $search_strings = '';
        //implement for search query
        if(!empty($_GET['q'])) {
            $args['post__in'] = Utilities::get_instance()->filter_search_post_ids($_GET['q']);
            $search_strings = sprintf(' <a href="%s" class="text-base text-orange">'. __('clear search', 'rise-wp-theme') .'</a>', remove_query_arg('q'));
        }
        
        $wp_query = new \WP_Query($args);
    
        $msg = '<div class="min-h-screen"><h4 class="text-2xl font-semibold text-riseDark mb-9">'.__('My innovation audit', 'rise-wp-theme'). $search_strings.'</h4>';
        $is_found = false;
        if($wp_query->have_posts()) {
            $msg .= '<div class="pb-56">';
            $msg .= '<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-5">';
    
            foreach ($wp_query->posts as $post) {
        
                //check if the activity belongs to the user
                $members = $this->get_post_meta_fields($post->ID);
                
                if(in_array($user_id, $members)) {
                    $is_found = true;
                    $id = $post->ID;
                    $attachment = get_field('upload_attachment', $id);
                    $date = rise_wp_format_date($post->post_date, 'jS F, Y');
                    $title = $post->post_title;
                    
                    $msg .= '<innovation-card name="'.$title.'" date="Uploaded '.$date.'"  attachment="'.$attachment['url'].'"></innovation-card>';
                }
            }
        }
        
        if(!$is_found) {
            $empty_msg = __('Once we have completed your innovation audit we will upload it here.', 'rise-wp-theme');
            $msg .= '<div class="no-post-text text-center flex items-center w-full" style="margin-top: 2.25rem">';
            $msg .= get_rise_empty_states($empty_msg);
            $msg .= '</div>';
        }
    
        $msg .= '</div>';
        $msg .= apply_filters('member_area_pagination', $wp_query, false);
        $msg .= '</div>';

        $msg .= '</div>';

        return $msg;
    }

    public function get_post_meta_fields($post) {
        $posts = get_post_meta($post, "rise_members_innovations_meta", true);
        
        if($posts && !empty($posts)) {
            return json_decode($posts, TRUE);
        }
        
        return [];
    }

    public function yoast_seo_admin_remove_columns($columns ) {
        unset($columns['wpseo-score']);
        unset($columns['wpseo-score-readability']);
        unset($columns['wpseo-title']);
        unset($columns['wpseo-metadesc']);
        unset($columns['wpseo-focuskw']);
        unset($columns['wpseo-links']);
        unset($columns['wpseo-linked']);
        return $columns;
    }

    public function modify_users_columns($columns) {
        unset($columns['wfls_2fa_status']);
        unset($columns['posts']);

        $columns[$this->post_type] = __('Innovation Audits', 'rise-wp-theme');
        return $columns;
    }
    
    public function get_members_with_post_key() {
        global $wpdb;
    
        // Search in all custom fields
        $post_ids = $wpdb->get_col( $wpdb->prepare( "
                SELECT DISTINCT ID FROM {$wpdb->posts}
                WHERE post_type = '%s'
            ", $this->post_type ) );
        
        $return_data = [];
        if(!empty($post_ids) && !is_wp_error($post_ids)) {
            foreach ($post_ids as $post_id) {
                $members = $this->get_post_meta_fields($post_id);
                if(!empty($members)) {
                    $return_data[$post_id] = $members;
                }
            }
    
            wp_reset_postdata();
        }
        
        return $return_data;
    }
    
    public function get_posts_of_member_by_id($user_id) {
        global $wpdb;
    
        // Search in all custom fields
        $post_ids = $wpdb->get_col( $wpdb->prepare( "
                SELECT DISTINCT ID FROM {$wpdb->posts}
                WHERE post_type = '%s'
            ", $this->post_type ) );
    
        $return_data = [];
        if(!empty($post_ids) && !is_wp_error($post_ids)) {
            foreach ($post_ids as $post_id) {
                $members = $this->get_post_meta_fields($post_id);
                if (!empty($members)) {
                    if (in_array($user_id, $members)) {
                        $return_data = array_merge([$post_id], $return_data);
                    }
                }
            }
    
            wp_reset_postdata();
        }
    
        return $return_data;
    }

    public function modify_users_custom_column($val, $column_name, $user_id) {
        $attached_posts = $this->get_members_with_post_key();
    
        $activities_admin_url = admin_url( 'edit.php?post_type='.$this->post_type);
    
        $edit_rise_activities_url = '';
        $post_ids = array_keys($attached_posts);
        $user_post_ids = [];
        
        foreach ($post_ids as $post_id) {
            $members = $this->get_post_meta_fields($post_id);
            
            if(!empty($members)) {
                if(in_array($user_id, $members)) {
                    $user_post_ids[] = $post_id;
                }
            }
        }
        
        if(!empty($user_post_ids)) {
            $edit_rise_activities_url = add_query_arg([
                'rise_members'  => implode(',', $user_post_ids).'||'.$user_id
            ], $activities_admin_url);
        }

        switch ($column_name) {
            case $this->post_type:
                $msg = '';
                if(!empty($edit_rise_activities_url)) {
                    $msg .= '<div class="rise-actvities">';
                    $msg .= '<a href="'.$edit_rise_activities_url.'">'.__('View Audits', 'rise-wp-theme').'</a>';
                    $msg .= '</div>';
                }
                return $msg;
                break;
        }

        return $val;
    }

    public function add_post_meta_boxes()
    {
        global $typenow, $wpseo_meta_columns;

        add_meta_box(
            'post_metadata_rise_members_category',
            'RISE Members',
            [$this, 'post_meta_box_rise_members_category'],
            $this->post_type,
            'side',
            'core'
        );

        //remove SEO filter from the activities page
        if($typenow ==  $this->post_type) {
            if ( $wpseo_meta_columns ) {
                remove_action( 'restrict_manage_posts', array( $wpseo_meta_columns, 'posts_filter_dropdown' ) );
                remove_action( 'restrict_manage_posts', array( $wpseo_meta_columns , 'posts_filter_dropdown_readability' ) );
            }
        }
    }

    public function post_meta_box_rise_members_category()
    {
        global $post;

        $args = [
            'role'              => 'um_full-membership',
            'search_columns'    => ['ID', 'display_name'],
        ];

        $users = get_users($args);
        
        $saved_users = $this->get_post_meta_fields($post->ID);

        

        $msg    = '<div class="rise-members-category">';
        $msg    .= '<h3>'. __('Select Members', 'rise-wp-theme').'</h3>';
        $msg    .= '<div class="members-container">';
        $msg    .= '<select name="rise_members_category[]" class="members-select rise-wp-theme-select2-js" multiple="multiple">';
        $msg    .= '<option value="">'. __('Choose members', 'rise-wp-theme').'</option>';
        foreach ($users as $user) {
            $selected = '';
            $userdata = get_userdata($user->ID);
            $name = $userdata->first_name. ' '.$userdata->last_name;
            if(strlen($name) < 3) $name = $user->display_name;
            if(in_array($user->ID, $saved_users)) {
                $selected = 'selected';
            }
            $msg    .= '<option value="'.$user->ID.'" '.$selected.'>'.$name.'</option>';
        }

        $msg    .= '</select>';
        $msg    .= '</div></div>';

        echo $msg;
    }

    public function filter_query_by_members($query) {
        global $pagenow;

        $get_members_id = isset($_GET['rise_members']) ? $_GET['rise_members'] : '';

        if ( $pagenow == 'edit.php' && !empty($get_members_id)) {
            $split_user_id_from_posts = explode('||', $get_members_id);
            $split_posts = explode(',', $split_user_id_from_posts[0]);
            $query->set( 'post__in', $split_posts);
        }
    }

    public function custom_post_type_columns($columns) {
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
            'title' => __('Activity Title'),
            'custom_members' => __('Members'),
            'date' =>__( 'Date')
        );
    }

    public function fill_custom_post_type_columns($column, $post_id) {
        $post = get_post($post_id);
        $args = [
            'role'              => 'um_full-membership',
            'search_columns'    => ['ID', 'display_name'],
            'fields'            => ['ID', 'display_name'],
        ];

        $users = get_users($args);
    
        $saved_members = $this->get_post_meta_fields($post_id);

        switch($column) {
            case 'custom_members':
                echo '<div class="rise-actvities-show-members">';
                $array_users = [];
                foreach ($users as $user) {

                    if(in_array($user->ID, $saved_members)) {
                        $user = get_userdata($user->ID);
                        $edit_user_url = get_edit_user_link($user->ID);
                        $name = $user->first_name. ' '.$user->last_name;
                        if(strlen($name) < 3) $name = $user->display_name;

                        $array_users[] = '<a href="'.$edit_user_url.'">'.$name.'</a>';
                    }
                }

                echo implode(', ', $array_users);
                echo '</div>';
                break;
        }
    }

    public function restrict_manage_posts()
    {
        global $typenow;

        $get_members_id = isset($_GET['rise_members']) ? $_GET['rise_members'] : '';
        $splits_user_id_from_posts = explode('||', $get_members_id);

        if($typenow !== $this->post_type) return;
    
        $users = [];
        $posts_list = $this->get_members_with_post_key();
    
        echo '<select name="rise_members" id="rise_members" class="postform">';
        echo '<option value="" >'.__('All Members', 'rise-wp-theme').'</option>';
        
        foreach ($posts_list as $key => $value) {
            $find_member = $this->get_post_meta_fields($key);
            if(!empty($find_member)) {
                foreach ($find_member as $user) {
                    if(!in_array($user, $users)) {
                        $user_id = $user;
                        
                        $value = $this->get_posts_of_member_by_id($user_id);
                        $value = implode(',', $value);
                        
                        $selected = $splits_user_id_from_posts[1] == $user_id ? 'selected' : '';
                        $current_user = get_userdata($user_id);
                        $name = $current_user->first_name. ' '.$current_user->last_name;
                        if(strlen($name) < 3) $name = $current_user->display_name;
                        echo  '<option value="'.$value.'||'.$user_id.'" '.$selected.'>'.$name.'</option>';
                    }
                }
    
                $users = array_unique(array_merge($find_member, $users));
            }
        }
        echo "</select>";
    }

    /**
     * Singleton poop.
     *
     * @return RiseInnovationAudits|null
     */
    public static function get_instance() {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }
}
