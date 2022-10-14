<?php

namespace RiseWP\Classes;

class Webinars {
    
    public function get_all_webinars($top_filters = '' , $categories = [], $posts_per_page = '') {
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $return_results = [];
        
        $args = [
            'post_type' => RISE_WP_WEBINARS,
            'order' => 'DESC',
            'paged' => $paged,
            'tax_query' => [],
        
        ];
        
        if(!empty($posts_per_page)) {
            $args['posts_per_page'] = $posts_per_page;
            $args['paged'] = -1;
        }
        
        if(!empty($top_filters)) {
            $top_args = [
                [
                    'taxonomy' => RISE_WP_TOOLSRESOURCES_TYPES,
                    'field' => 'slug',
                    'terms' => $top_filters,
                ],
            ];
            
            $args['tax_query'] = array_merge($top_args, $args['tax_query']);
        }
        
        if (!empty($categories)) {
            $cat_args = [];
            foreach ($categories as $category) {
                $cat_args[] = [
                    'taxonomy' => RISE_WP_TOOLSRESOURCES_CAT,
                    'field' => 'slug',
                    'terms' => $category,
                ];
                $cat_args['relation'] = 'OR';
            }
            
            $args['tax_query'] = array_merge($cat_args, $args['tax_query']);
        }
        
        if(!empty($top_filters) && !empty($categories)){
            $args['tax_query']['relation'] = 'AND';
        }
    
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
                
                $return_results['data'][] = [
                    'id'                            => $result->ID,
                    'title'                         => $result->post_title,
                    'webinar_video_embed'           => $video_link,
                    'date'                          => $date,
                    'link'                          => get_permalink($result->ID),
                    'category'                      => rise_wp_return_the_category($result->ID, RISE_WP_TOOLSRESOURCES_CAT),
                    'types'                         => rise_wp_return_the_category($result->ID, RISE_WP_TOOLSRESOURCES_TYPES),
                    'image'                         => $post_thumbnail,
                ];
                
            }
        }
        
        return $return_results;
    }
    
    public function get_related_tools_resources_webinars($post_id, $posts_per_page = '') {
        $return_results = [];
        
        $args = [
            'post_type' => RISE_WP_WEBINARS,
            'order' => 'DESC',
            'post__not_in' => [$post_id],
        ];
        
        if(!empty($posts_per_page)) {
            $args['posts_per_page'] = $posts_per_page;
        }
        
        if(!empty($top_filters) && !empty($categories)){
            $args['tax_query']['relation'] = 'AND';
        }
        
        $results = new \WP_Query($args);
        
        $results = $results->posts;
        
        if (!empty($results)) {
            foreach ($results as $result) {
                $post_thumbnail = (has_post_thumbnail($result->ID)) ? get_the_post_thumbnail_url($result->ID) : '';
                $attachment = get_field('upload_attachment', $result);
                $date = rise_wp_format_date($result->post_date, 'jS F, Y');
                
                $return_results[] = [
                    'id'                => $result->ID,
                    'title'             => $result->post_title,
                    'attachment'        => $attachment,
                    'date'              => $date,
                    'link'              => get_permalink($result->ID),
                    'category'          => rise_wp_return_the_category($result->ID, RISE_WP_TOOLSRESOURCES_CAT),
                    'types'             => rise_wp_return_the_category($result->ID, RISE_WP_TOOLSRESOURCES_TYPES),
                    'image'             => $post_thumbnail,
                ];
                
            }
        }
        
        return $return_results;
    }
    
    /**
     * Singleton poop.
     *
     * @return Webinars|null
     */
    public static function get_instance() {
        static $instance = null;
        
        if (is_null($instance)) {
            $instance = new self();
        }
        
        return $instance;
    }
}