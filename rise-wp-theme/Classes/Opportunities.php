<?php

namespace RiseWP\Classes;

use RiseWP\Api\UltimateMembers;

class Opportunities {


    public function get_develop_opportunities_list($top_filters = '' , $categories = [], $posts_per_page = '') {
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $return_results = [];

        $args = [
            'post_type' => RISE_WP_OPPORTUNITIES,
            'order' => 'DESC',
            'paged' => $paged,
            'tax_query' => [],
        ];

        if(!empty($posts_per_page)) {
            $args['posts_per_page'] = $posts_per_page;
            unset($args['paged']);
        }

        if(!empty($top_filters)) {
            $top_args = [
                [
                    'taxonomy' => RISE_WP_OPPORTUNITIES_TYPES,
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
                    'taxonomy' => RISE_WP_OPPORTUNITIES_CAT,
                    'field' => 'slug',
                    'terms' => $category,
                ];
                $cat_args['relation'] = 'AND';
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

                $date = !empty(get_field('opportunities_date', $result->ID)) ? rise_wp_format_date_news(get_field('opportunities_date', $result->ID)) : '';
                $types = rise_wp_return_the_category($result->ID, RISE_WP_OPPORTUNITIES_TYPES);

                $post_thumbnail = (has_post_thumbnail($result->ID)) ? get_the_post_thumbnail_url($result->ID) : $types['image'];

                $return_results['data'][] = [
                    'id'              => $result->ID,
                    'title'           => wp_trim_words($result->post_title, 9, '...'),
                    'excerpt'         =>  wp_trim_words($result->post_content, 10, '...'),
                    'content'         => $result->post_content,
                    'link'            => get_permalink($result->ID),
                    'custom_category' => rise_wp_return_the_category($result->ID, RISE_WP_OPPORTUNITIES_CAT),
                    'filters'         => $types,
                    'date'            => $date,
                    'default_date'    => get_the_date(),
                    'post_type'       => $result->post_type,
                    'image'           => $post_thumbnail,
                ];

            }
        }

        return $return_results;
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
