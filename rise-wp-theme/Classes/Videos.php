<?php

namespace RiseWP\Classes;

class Videos {
    
    public function get_all_help_videos( $posts_per_page = '') {
        $paged = get_query_var('paged');
        if(empty($posts_per_page)) $posts_per_page = get_option('posts_per_page');
        $return_results = [];
        
        $args = [
            'post_type' => RISE_WP_HELP_VIDEOS,
            'paged' => $paged,
            'posts_per_page' => $posts_per_page,
            'tax_query' => [],
        
        ];
    
        //implement for search query
        if(!empty($_GET['q'])) {
            $args['post__in'] = Utilities::get_instance()->filter_search_post_ids($_GET['q']);
        }
        
        $results = new \WP_Query($args);
        $return_results['wp_query'] = $results;
        
        $results = $results->posts;
        
        $return_results['data'] = [];
        
        if (!empty($results)) {
            foreach ($results as $result) {
                $post_thumbnail = (has_post_thumbnail($result->ID)) ? get_the_post_thumbnail_url($result->ID) : '';
                $video_link = get_field('webinar_video_embed', $result);
                $date = rise_wp_format_date($result->post_date, 'jS F, Y');
                

                array_push( $return_results['data'], [
                    'id'                            => $result->ID,
                    'title'                         => $result->post_title,
                    'webinar_video_embed'           => $video_link,
                    'date'                          => $date,
                    'link'                          => get_permalink($result->ID),
                    'image'                         => $post_thumbnail,
                ]);
            }
        }
        
        return $return_results;
    }
    
    public function get_related_help_videos($post_id, $posts_per_page = '') {
        $return_results = [];
        if(empty($posts_per_page)) $posts_per_page = get_option('posts_per_page');
        
        $args = [
            'post_type' => RISE_WP_HELP_VIDEOS,
            'post__not_in' => [$post_id],
            'posts_per_page' => $posts_per_page
        ];
        
        $results = new \WP_Query($args);
        
        $results = $results->posts;
        
        if (!empty($results)) {
            foreach ($results as $result) {
                $post_thumbnail = (has_post_thumbnail($result->ID)) ? get_the_post_thumbnail_url($result->ID) : '';
                $attachment = get_field('upload_attachment', $result);
                $date = rise_wp_format_date($result->post_date, 'jS F, Y');
               
                array_push($return_results, array(
                    'id'                => $result->ID,
                    'title'             => $result->post_title,
                    'attachment'        => $attachment,
                    'date'              => $date,
                    'link'              => get_permalink($result->ID),
                    'image'             => $post_thumbnail,
                ));
                
            }
        }
        
        return $return_results;
    }

    
    /**
     * Singleton poop.
     *
     * @return Videos
     */
    public static function get_instance() {
        static $instance = null;
        
        if (is_null($instance)) {
            $instance = new self();
        }
        
        return $instance;
    }
}