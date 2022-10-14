<?php

namespace RiseWP\Classes;

class News
{
    public function get_news_category($taxonomy = 'category') {
        $return_cat = [];
        $args = [
            'taxonomy' => $taxonomy,
            'include_parent' => 0,
            'hide_empty' => false,
            'order' => 'DESC'
        ];

        $categories = get_terms($args);



        if(!empty($categories) && !is_wp_error($categories)) {
            foreach ($categories as $category) {
                $return_cat[] = [
                    'id' => $category->term_id,
                    'title' => $category->name,
                    'slug' => $category->slug,
                ];
            }
        }

        return $return_cat;
    }

    public function get_news_filter($taxonomy = 'news_filter'){
        $return_filter = [];
        $args = [
            'taxonomy' => $taxonomy,
            'include_parent' => 0,
            'hide_empty' => true,
            'order' => 'DESC'
        ];

        $filters = get_terms($args);

        if(!empty($filters) && !is_wp_error($filters)) {
            foreach ($filters as $filter) {
                $return_filter[] = [
                    'id' => $filter->term_id,
                    'title' => $filter->name,
                    'slug' => $filter->slug,
                ];
            }
        }

        return $return_filter;

    }

    public function get_news_homepage($limit = 3)
    {
        $return_post = [];

        $today = date('Ymd');

        $args = [
            'numberposts'   => $limit,
            'meta_key'      => 'home_only',
            'meta_query'    => [
                'relation' => 'OR',
                'home_only_order' => [
                    'key' => 'home_only',
                    'compare'   => 'EXISTS',
                ],
                'home_only_order_withnulls' => [
                    'key' => 'home_only',
                    'compare' => 'NOT EXISTS',
                ]
            ],
           'orderby'    => [
               'home_only_order_withnulls'  => 'DESC',
                'post_date'             => 'DESC'
            ]
        ];

        $news = get_posts($args);

        if (!empty($news)) {
            foreach ($news as $new) {
                $title = mb_strimwidth($new->post_title, 0, 62, '...');
                $post_thumbnail = (has_post_thumbnail($new->ID)) ? get_the_post_thumbnail_url($new->ID) : null;
                $return_post[] = [
                    'id'        => $new->ID,
                    'slug'      => $new->post_name,
                    'title'     => $title,
                    'image'     => $post_thumbnail,
                    'summary'   => rise_wp_get_the_contents($new),
                    'category'  => rise_wp_return_the_category($new->ID),
                    'link'      => get_permalink($new->ID),
                    'date'      => rise_wp_format_date($new->post_date, 'd M'),

                ];
            }
            return $return_post;
        }
    }

    public function get_sticky_post(){
        $return_results = [];

        $sticky_post = get_option( 'sticky_posts' );

        $args = [
            'numberposts' => 1,
            'post__in' => $sticky_post,
        ];

        $results = get_posts($args);

        if(!isset($results[0])) {
            unset($args['post__in']);
            unset($args['ignore_sticky_posts']);
            $results = get_posts($args);
        }

        if(!empty($results)) {
            $result = $results[0];

            $post_thumbnail = (has_post_thumbnail($result->ID)) ? get_the_post_thumbnail_url($result->ID) : null;
            $tag_news = (!empty(wp_get_post_tags($result->ID)[0]->name)) ? wp_get_post_tags($result->ID)[0]->name : '';
            $return_results[] = [
                'id' => $result->ID,
                'slug' => $result->post_name,
                'title' => $result->post_title,
                'content' => $result->post_content,
                'avatar' => get_field('author_image', $result->ID),
                'author' => get_field('author_name', $result->ID),
                'description' => get_field('author_description', $result->ID),
                'image' => $post_thumbnail,
                'tag' => $tag_news,
                'summary' => rise_wp_get_the_contents($result),
                'category' => rise_wp_return_the_category($result->ID),
                'link' => get_permalink($result->ID),
                'date' => get_the_date('d M Y'),

            ];
        }

        return $return_results;
    }

    public function get_news($sub_category = '', $paged = '', $limit = '', $date_format = 'd M Y')
    {
        $return_data = [];
        $args = [
            'paged' => $paged,
            'tax_query' => [],
        ];

        if (!empty($sub_category)) {
            $cat_args = [
                'taxonomy' => 'news_filter',
                'field' => 'slug',
                'terms' => $sub_category,
            ];

            $args['tax_query'][] = array_merge($args['tax_query'], $cat_args);
        }

        if(!empty($limit)) {
            $args['posts_per_page'] = $limit;
        }

        $posts = new \WP_Query($args);

        $return_data['wp_query'] = $posts;

        $posts = $posts->posts;

        $return_data['data'] = [];

        if (!empty($posts)) {
            foreach ($posts as $post) {
                $excerpt = mb_strimwidth($post->post_excerpt, 0, 110, '...');
                $title = mb_strimwidth($post->post_title, 0, 62, '...');
                $post_thumbnail = (has_post_thumbnail($post->ID)) ? get_the_post_thumbnail_url($post->ID) : null;
                $tag_news = (!empty(wp_get_post_tags($post->ID)[0]->name))? wp_get_post_tags($post->ID)[0]->name : '';
                $return_data['data'][] = [
                    'id' => $post->ID,
                    'title' => $title,
                    'images' => $post_thumbnail,
                    'category' => get_the_category($post->ID)[0]->name,
                    'tag' => $tag_news,
                    'link' => get_permalink($post->ID),
                    'inner_image' => get_field('single_post_image', $post->ID),
                    'excerpt' => $excerpt,
                    'date' => get_the_date($date_format, $post->ID),

                ];
            }
        }

        return $return_data;
    }


     public function get_related_post($post, $number_of_posts = 3){


         $return_data = [];

         $args = [
             'post__not_in' => [$post->ID],
             'posts_per_page'  => $number_of_posts,
         ];

         $results = new \WP_Query($args);

         $results = $results->posts;

         if (!empty($results)) {
             foreach ($results as $result) {
                 $related_post_thumbnail = (has_post_thumbnail($result->ID)) ? get_the_post_thumbnail_url($result->ID) : null;
                 $tag_news = (!empty(wp_get_post_tags($result->ID)[0]->name))? wp_get_post_tags($result->ID)[0]->name : '';
                 $return_data[] = [
                     'id' => $result->ID,
                     'title' => $result->post_title,
                     'link' => get_permalink($result->ID),
                     'image' => $related_post_thumbnail,
                     'tag' => $tag_news,
                    'category' => rise_wp_return_the_category($result->ID),
                     'date' => get_the_date('d M Y', $result->ID),

                 ];
             }

             return $return_data;
         }

     }




    //Custom Numeric Pagination
    function custom_pagination( $max_num_pages) {

        $allowed_tags = [
            'span' => [
                'class' => [],
            ],
            'i'    => [
                'class' => [],
            ],
            'a'    => [
                'class' => [],
                'href'  => [],
            ],

        ];

        $args = [
            'prev_text' =>  __( 'Previous', 'rise-wp-theme' ),
            'next_text' => __( 'Next', 'rise-wp-theme' ),
            'total'     => $max_num_pages
        ];

        printf('<div class="pagination">%s</div>', wp_kses(paginate_links($args),$allowed_tags));
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
