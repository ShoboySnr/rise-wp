<?php

namespace RiseWP\Api;

class Search {
    
    public $post_types = ['advisors'];
    
    public $forums_types = ['forum', 'topic',];
    
    public $business_post_type = 'um_groups';
    
    public function __construct()
    {
        add_shortcode('rise_wp_general_search', [$this, 'rise_wp_general_search']);
    
        //register the action to get the search results
        add_action('wp_ajax_rise_wp_get_search_results',[$this, 'rise_wp_get_search_results']);
    }
    
    
    public function rise_wp_general_search($atts) {
        $args = shortcode_atts([
          'user_id'       => get_current_user_id(),
        ], $atts);
        
        return $this->rise_wp_fireup_search_action($args);
    }
    
    public function rise_wp_fireup_search_action($args) {
        $user_id = $args['user_id'];
        $q = isset($_GET['q']) ? $_GET['q'] : '';
        
        $nonce = wp_create_nonce('rise_wp_search_action');
        
        $msg = '<div class="dashboard-search__wrapper relative rise-wp-popupcover">';
        $msg .= '<div class="dashboard-search">';
        $msg .= '<input type="search" name="s" value="'. $q.'" placeholder="'. __('Need inspiration? &nbsp; Search here', 'rise-wp-theme').'" id="search_directory" autocomplete="off" data-nonce="'.$nonce.'"/>';
        $msg .= '<div class="dashboard-search__icon">';
        $msg .= '<svg width="15" height="15" viewBox="0 0 15 15" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<circle cx="6.84442" cy="6.84442" r="5.99237" stroke="#F15400" stroke-width="1.5"
									stroke-linecap="round" stroke-linejoin="round" />
								<path d="M11.0122 11.3235L13.3616 13.6667" stroke="#F15400" stroke-width="1.5"
									stroke-linecap="round" stroke-linejoin="round" />
							</svg>';
        $msg .= '</div></div>';
        $msg .= '<div class="dropdown-options">';
        $msg .= '<div class="inner-preloader" style="display: none">
                    <img src="'. RISE_THEME_PRELOADER_SVG .'" alt="preloader" />
                </div>';
        $msg .= '<ul>';
        $msg .= '</ul></div></div>';
        
        return $msg;
    }
    
    public function rise_wp_get_search_results()
    {
        //verify nonce
        if ( !wp_verify_nonce( $_POST['nonce'], "rise_wp_search_action")) {
            $response['status'] = false;
            $response['message'] = __('<p>There was a problem getting search results. Please refresh and try again.</p>', 'rise-wp-theme');
        
            echo json_encode($response);
            wp_die();
        }
    
        $s = sanitize_text_field($_POST['s']);
    
        $html = '';
        $outputs = array_merge(
          $this->search_through_member_directory($s),
          $this->search_through_messages($s),
          $this->search_all_forum_post_types($s),
          $this->search_all_custom_post_types($s, RISE_WP_KNOWLEDGE, 'develop/knowledge-and-tools/knowledge-and-tools-library'),
          $this->search_all_custom_post_types($s, RISE_WP_WEBINARS, 'develop/knowledge-and-tools/webinars'),
          $this->search_all_custom_post_types($s, RISE_WP_OPPORTUNITIES, 'develop/opportunities'),
          $this->search_all_custom_post_types($s, RISE_WP_INNOVATION_AUDITS, 'innovation-audits'),
          $this->search_all_custom_post_types($s, RISE_WP_ACTIVITIES, 'activities')
        );
        
        usort($outputs, [$this, 'order_by_dates']);
        
        if(!empty($outputs)) {
            foreach($outputs as $output) {
                $html .= $this->search_item_template($s, $output['link'], $output['name']);
            }
        }
        
        //check if there's returned html
        if(strlen($html) > 2) {
            $response['status'] = true;
            $response['content'] = $html;
            $response['message'] = __('Search successful', 'rise-wp-theme');
            
            echo json_encode($response);
            wp_die();
        }
    
        $response['status'] = false;
        $response['message'] = __('<p>No results found</p>', 'rise-wp-theme');
    
        echo json_encode($response);
        wp_die();
        
        
        wp_die();
    }
    
    public function search_all_forum_post_types($s) {
        $return_data = [];
        $is_found = false;
        $page = bbp_get_page_by_path('forum');
    
        $args = [
          's'               => $s,
          'post_type'     => $this->forums_types,
        ];
        
        $query = new \WP_Query($args);
    
        if ( $query->have_posts() ) {
            $is_found = true;
            
        }
        
        if($is_found) {
            $link = bbp_get_forums_url();
            $return_data[] = [
              'id'                  => get_the_ID(),
              'link'                => add_query_arg(['q' => $s], $link),
              'name'                => $page->post_title,
              'date'                => $page->post_date
            ];
        }
        
        return $return_data;
    }
    
    public function search_all_custom_post_types($s, $post_type, $page_slug) {
        global $wpdb;
        
        $return_data = [];
        $is_found = false;
        
        $page = get_page_by_path($page_slug);
        
        $keyword = sanitize_text_field($s);
        $keyword = '%' . $wpdb->esc_like( $keyword ) . '%';
    
        // Search in all custom fields
        $post_ids_meta = $wpdb->get_col( $wpdb->prepare( "
                SELECT DISTINCT post_id FROM {$wpdb->postmeta}
                WHERE meta_value LIKE '%s'
            ", $keyword ) );
    
        // Search in post_title and post_content
        $post_ids_post = $wpdb->get_col( $wpdb->prepare( "
                SELECT DISTINCT ID FROM {$wpdb->posts}
                WHERE post_title LIKE '%s'
                OR post_content LIKE '%s'
            ", $keyword, $keyword ) );
    
        $post_ids = array_unique(array_merge($post_ids_meta, $post_ids_post));
    
        // Query arguments
        $args = [
            'post_type'   => $post_type,
            'post__in'    => $post_ids,
        ];
        
        $query = new \WP_Query($args);
        
        if ( $query->have_posts() ) {
            $is_found = true;
        }
        
        if($is_found) {
            $link = get_permalink($page);
            $return_data[] = [
                'id'                  => get_the_ID(),
                'link'                => add_query_arg(['q' => $s], $link),
                'name'                => $page->post_title,
                'date'                => $page->post_date
            ];
        }
        
        return $return_data;
    }
    
    public function search_through_my_locker($s, $post_type, $page_slug) {
        global $wpdb;
        
        $return_data = [];
        $is_found = false;
        
        $page = get_page_by_path($page_slug);
        
        $keyword = sanitize_text_field($s);
        $keyword = '%' . $wpdb->esc_like( $keyword ) . '%';
        
        // Search in all custom fields
        $post_ids_meta = $wpdb->get_col( $wpdb->prepare( "
                SELECT DISTINCT post_id FROM {$wpdb->postmeta}
                WHERE meta_value LIKE '%s'
            ", $keyword ) );
        
        // Search in post_title and post_content
        $post_ids_post = $wpdb->get_col( $wpdb->prepare( "
                SELECT DISTINCT ID FROM {$wpdb->posts}
                WHERE post_title LIKE '%s'
                OR post_content LIKE '%s'
            ", $keyword, $keyword ) );
        
        $post_ids = array_unique(array_merge($post_ids_meta, $post_ids_post));
        
        // Query arguments
        $args = [
            'post_type'   => $post_type,
            'post__in'    => $post_ids,
        ];
        
        $query = new \WP_Query($args);
    
        $user_id = get_current_user_id();
        
        if ( $query->have_posts() ) {
            foreach ($query->posts as $post) {
                //check if the activity belongs to the user
                $members = $this->get_post_meta_fields($post, $user_id);
    
                if($user_id  === $members) {
                    $is_found = true;
                    break;
                }
            }
        }
        
        if($is_found) {
            $link = get_permalink($page);
            $return_data[] = [
                'id'                  => get_the_ID(),
                'link'                => add_query_arg(['q' => $s], $link),
                'name'                => $page->post_title,
                'date'                => $page->post_date
            ];
        }
        
        return $return_data;
    }
    
    public function search_through_member_directory($s) {
        $return_data = [];
        $is_found = false;
        $page = get_page_by_path('member-directory');
        $link = get_permalink($page);
    
        $s = esc_attr( trim($s) );
        
        $args = [
          'meta_query' => [
            'relation' => 'OR',
            [
              'key' => 'first_name',
              'value' => $s,
              'compare' => 'LIKE'
            ],
            [
              'key' => 'last_name',
              'value' => $s,
              'compare' => 'LIKE'
            ]
          ]
        ];
        
        $user_query = new \WP_User_Query( $args );
        
        if ( !empty( $user_query->results ) ) {
            $is_found = true;
        }
        //search through from business name also
        $args = [
          's'               => $s,
          'post_type'       => $this->business_post_type
        ];
    
        $query = new \WP_Query($args);
    
        if ( $query->have_posts() ) {
            $is_found = true;
        }
        
        if($is_found) {
            //455 is the form id of the member directory
            $unique_hash = substr( md5( 455 ), 10, 5 );
            $search_value = 'search_'.$unique_hash;
            $return_data[] = [
              'id'                  => $page->ID,
              'link'                => add_query_arg(['q' => $s, $search_value => $s], $link),
              'name'                => $page->post_title,
              'date'                => $page->post_date,
            ];
        }
        
        return $return_data;
    }
    
    public function search_through_messages($s) {
        $return_data = [];
        global $wpdb;
        $page = get_page_by_path('messages');
        $link = get_permalink($page);
        
        $user_id = get_current_user_id();
    
        $messages = $wpdb->get_results( $wpdb->prepare(
          "SELECT *
							FROM {$wpdb->prefix}um_messages
							WHERE content LIKE '%{$s}%' AND author = %d
							ORDER BY time DESC",
          $user_id
        ));
        
        $message_recipient_found = [];
        
        if(!empty($messages)) {
            foreach ($messages as $message) {
                um_fetch_user($message->recipient);
                
                if(in_array($message->recipient, $message_recipient_found)) {
                    continue;
                }
    
                $message_recipient_found[] = $message->recipient;
                
                $return_data[] = [
                  'id'                  => $message->message_id,
                  'link'                => add_query_arg(['q' => $s, 'conversation_id' => $message->conversation_id], $link),
                  'name'                => $page->post_title . ' From '.um_user('display_name'),
                  'date'                => $message->time,
                ];
            }
        }
        
        return $return_data;
    }
    
    public function search_item_template($s, $link, $name) {
        $msg = '<li class="dropdown-option mt-2 mb-2" onclick="document.location.href=\''.$link.'\'">';
        $msg .= '<p>'.$s.' in <span class="dropdown-option_section"> '.$name.' </span></p>';
        $msg .= '<svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path
									d="M5.99999 4.49284L1.75699 8.73584L0.342987 7.32084L3.17199 4.49284L0.342987 1.66484L1.75699 0.24984L5.99999 4.49284Z"
									fill="#38393E" />
							</svg>';
        $msg .= '</li>';
        
        return $msg;
    }
    
    public function order_by_dates($item_1, $item_2) {
        $date_1 = strtotime($item_1['date']);
        $date_2 = strtotime($item_2['date']);
        
        return $date_1 - $date_2;
    }
    
    /**
     * Singleton poop.
     *
     * @return Search|null
     */
    public static function get_instance() {
        static $instance = null;
        
        if (is_null($instance)) {
            $instance = new self();
        }
        
        return $instance;
    }
}
?>