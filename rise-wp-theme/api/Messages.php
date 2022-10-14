<?php

namespace RiseWP\Api;

class Messages {

    public function __construct()
    {
        add_filter('um_messaging_conversation_json_data', [$this, 'rise_wp_add_more_data_to_conversation'], 10, 2);

        //last login seen
        add_action('wp_login', [$this, 'rise_wp_record_last_seen'], 10, 2);
        //shortcode for last seen
        add_shortcode('rise_wp_lastseen', [$this, 'rise_wp_lastseen']);
    
        add_filter('um_notifications_get_notifications_response', [$this, 'rise_modify_private_message_notification'], 10, 4);
    }

    public function rise_wp_record_last_seen($user_login, $user) {
        update_user_meta( $user->ID, 'last_seen', time());
    }

    public function rise_wp_lastseen($atts) {
        $args = shortcode_atts([
            'user_id'       => get_current_user_id()
        ], $atts);

        $user_id = $args['user_id'];

        $last_seen = get_user_meta($user_id, 'last_seen', true);
        $last_seen_date = '';
        if(!empty($last_seen)) {
            $last_seen_date = date('jS F, Y', $last_seen);
        }

        if(!empty($last_seen_date)) {
            echo 'Last Seen '.$last_seen_date;
        }
    }

    public function rise_wp_add_more_data_to_conversation($array, $conversation) {
        $user_id = $array['user'];
        $is_new = $array['new_conv'];

        $avatar_url = get_avatar_url($user_id, ['sizes' => 32]);

        $date =  rise_wp_human_dates($conversation->last_updated);

        $message_content = '';
        $response = UM()->Messaging_API()->api()->get_conversation_id( $conversation->user_b, $conversation->user_a );
        if(is_array($response) || empty($response)) {
            $message_content = UM()->Messaging_API()->api()->get_conversation( $conversation->user_b, $conversation->user_a, $response['conversation_id'] );
        }

        $seen = $is_new ? 'true' : '';

        $array['avatar_url'] = $avatar_url;
        $array['message_date'] = $date;
        $array['seen'] = $seen;
        $array['message_content'] = wp_trim_words($message_content, 15, '...');

        return $array;
    }
    
    public function get_last_message($conversation_id, $message_to) {
      global $wpdb;
      
      $messages = $wpdb->get_results( $wpdb->prepare(
        "SELECT *
							FROM {$wpdb->prefix}um_messages
							WHERE conversation_id = %d
							ORDER BY time DESC
							LIMIT 1",
        $conversation_id
      ) );
      
      if(!empty($messages[0])) {
        return $messages[0]->content;
      }
      
      return '...';
      
    }
    
    public function get_user_conversion_details($message_to, $user_id) {
    
    }
    
    public function rise_modify_private_message_notification( $results, $per_page, $unread_only, $count ) {
        $message_url = get_permalink(get_page_by_path('messages'));
        
        foreach($results as $key => $result) {
            if($result->type === 'new_pm') {
                $conversation_url = parse_url($result->url);
                parse_str($conversation_url['query'], $params);
                
                //update the url
                $results[$key]->url = add_query_arg(['conversation_id' => $params['conversation_id']], $message_url);
            }
        }
        
        return $results;
    }



    /**
     * Singleton poop.
     *
     * @return Messages|null
     */
    public static function get_instance() {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }
}