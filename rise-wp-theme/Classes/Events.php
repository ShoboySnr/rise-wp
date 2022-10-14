<?php

namespace RiseWP\Classes;

class Events {

    public function get_all_events($post_per_page = 6, $sticky = 0,  $category = '') {
        $return_post = [];
        $args = [
            'post_type'             => RISE_WP_EVENTS,
            'posts_per_page'        => $post_per_page,
            'post__not_in'          => $sticky,
            'ignore_sticky_posts'   => 1,
            'tax_query'             => [],
            'order'				    => 'DESC',
        ];

        if(!empty($category)) {
            $sub_category_args = [
                [
                    'taxonomy'      => 'category',
                    'field'         => 'slug',
                    'terms'         => $category
                ]
            ];
            $args['tax_query'][] = array_merge($sub_category_args, $args['tax_query']);
        }

        $events = new \WP_Query($args);

        $max_num_pages = $events->max_num_pages;

        $events = $events->posts;

        $return_post['data'] = [];
        $return_post['count'] = 0;

        if(!empty($events)) {
            foreach ($events as $event) {
                $post_thumbnail = ( has_post_thumbnail( $event->ID ) ) ? get_the_post_thumbnail_url( $event->ID ) : null;
                $members_only = Utilities::get_instance()->members_only($event->ID);
                $return_post['data'][] =  [
                    'id'                    => $event->ID,
                    'slug'                  => $event->post_name,
                    'title'                 => $event->post_title,
                    'image'                 => $post_thumbnail,
                    'members_only'          => $members_only,
                    'summary'               => rise_wp_get_the_contents($event),
                    'category'              => rise_wp_return_the_category($event->ID),
                    'link'                  => get_permalink($event->ID),
                    'date'                  => rise_wp_format_date(get_field('event_date', $event->ID)),
                ];
            }

            $return_post['count'] = count($events);
        }

        $return_post['max_num_pages'] = $max_num_pages;

        return $return_post;
    }

    public function get_upcoming_events_home( $limit = 3) {
        $return_post = [];

        $today = date('Y-m-d');

        $args = [
            'post_type'     => RISE_WP_EVENTS,
            'posts_per_page'   => $limit,
            'meta_query' => [
                [
                    'relation' => 'AND',
                    'events_date_sort' => [
                        'key'=> 'event_date',
                        'value' => $today,
                        'compare' => '>=',
                        'type' => 'DATE',
                    ],
                    [
                        'relation'  => 'OR',
                        'home_only_order' => [
                            'key' => 'home_only',
                            'compare'   => 'EXISTS',
                        ],
                        'home_only_order_withnulls' => [
                            'key' => 'home_only',
                            'compare' => 'NOT EXISTS',
                        ],
                    ]
                ],
            ],
            'orderby' =>  [
                'home_only_order_withnulls' => 'DESC',
                'events_date_sort' => 'ASC',
            ],
        ];

        $events = new \WP_Query($args);

        $events = $events->posts;

        if(!empty($events)) {
            foreach($events as $event) {
                $post_thumbnail = ( has_post_thumbnail( $event->ID ) ) ? get_the_post_thumbnail_url( $event->ID ) : null;

                $event_time = get_field('event_date', $event->ID);
                $members = get_field('members_only', $event->ID);
                $members_only = Utilities::get_instance()->members_only($event->ID);
                $return_post[] =  [
                    'id'                    => $event->ID,
                    'slug'                  => $event->post_name,
                    'title'                 => $event->post_title,
                    'image'                 => $post_thumbnail,
                    'type'                  => get_field('event_type', $event->ID),
                    'summary'               => rise_wp_get_the_contents($event),
                    'category'              => rise_wp_return_the_category($event->ID, RISE_WP_EVENT_CATEGORIES),
                    'link'                  => get_permalink($event->ID),
                    'members_only'          => $members_only,
                    'event_time'            => $event_time,
                    'month'                 => rise_wp_format_date($event_time,'M'),
                    'day'                   => rise_wp_format_date($event_time, 'd'),
                ];
            }
        }

        return $return_post;
    }

    public function get_upcoming_events($post_not_in = '', $limit = 9) {
        $return_post = [];

        $today = date('Y-m-d');

        $args = [
            'post_type'     => RISE_WP_EVENTS,
            'posts_per_page'   => $limit,
            'post_status' => 'publish',
            'meta_key' => 'event_date',
            'meta_query'    => [
                'key'		=> 'event_date',
                'compare'	=> '>=',
                'value'		=> $today,
                'type' => 'date'
            ],
            'orderby'   => 'meta_value',
            'order' => 'ASC'
        ];

        if(!empty($post_not_in)) {
            $args['post__not_in'] = [$post_not_in];
        }

        // $events = get_posts($args);

        $events = new \WP_Query($args);

        $events = $events->posts;

        if(!empty($events)) {
            foreach($events as $event) {
                $post_thumbnail = ( has_post_thumbnail( $event->ID ) ) ? get_the_post_thumbnail_url( $event->ID ) : null;

                $event_time = get_field('event_date', $event->ID);
                $members = get_field('members_only', $event->ID);
                $members_only = Utilities::get_instance()->members_only($event->ID);
                $return_post[] =  [
                    'id'                    => $event->ID,
                    'slug'                  => $event->post_name,
                    'title'                 => $event->post_title,
                    'image'                 => $post_thumbnail,
                    'type'                  => get_field('event_type', $event->ID),
                    'summary'               => rise_wp_get_the_contents($event),
                    'category'              => rise_wp_return_the_category($event->ID, RISE_WP_EVENT_CATEGORIES),
                    'link'                  => get_permalink($event->ID),
                    'members_only'          => $members_only,
                    'event_time'            => $event_time,
                    'month'                 => rise_wp_format_date($event_time,'M'),
                    'day'                   => rise_wp_format_date($event_time, 'd'),
                ];
            }
        }

        return $return_post;
    }

    public function get_past_events($post_not_in = '', $paged = '', $limit = 3) {
        $return_post = [];

        $today = date('Y-m-d');


        $args = [
            'post_type'         => RISE_WP_EVENTS,
            'posts_per_page'    => $limit,
            'meta_key' => 'event_date',
            'meta_query'    => [
                'key'		=> 'event_date',
                'compare'	=> '<',
                'value'		=> $today,
                'type' => 'DATE'
            ],
            'orderby'   => 'event_date',
            'order' => 'DESC'
        ];

        if(!empty($paged)) {
            $args['paged'] = $paged;
        }

        if(!empty($post_not_in)) {
            $args['post__not_in'] = [$post_not_in];
        }


        $events = new \WP_Query($args);

        $return_post['wp_query'] = $events;

        $events = $events->posts;

        $return_post['data'] = [];
        if(!empty($events)) {
            foreach($events as $event) {
                $post_thumbnail = ( has_post_thumbnail( $event->ID ) ) ? get_the_post_thumbnail_url( $event->ID ) : null;
                $members_only = Utilities::get_instance()->members_only($event->ID);
                $return_post['data'][] =  [
                    'id'                    => $event->ID,
                    'slug'                  => $event->post_name,
                    'title'                 => $event->post_title,
                    'image'                 => $post_thumbnail,
                    'members_only'          => $members_only,
                    'type'                  => get_field('event_type', $event->ID),
                    'summary'               => rise_wp_get_the_contents($event),
                    'category'              => rise_wp_return_the_category($event->ID, RISE_WP_EVENT_CATEGORIES),
                    'link'                  => get_permalink($event->ID),
                    'month'                  => rise_wp_format_date(get_field('event_date', $event->ID), 'M'),
                    'day'                  => rise_wp_format_date(get_field('event_date', $event->ID), 'd'),
                ];
            }
        }

        return $return_post;
    }

    public function get_sticky_events() {
        $return_post = [];
        $get_sticky_posts = get_option( 'sticky_posts' );

        $today = date('Y-m-d');

        $args = [
            'post_type'             => RISE_WP_EVENTS,
            'numberposts'           => 1,
            'post__in'              => $get_sticky_posts,
            'meta-query'            => [
                'key'=> 'event_date',
                'value' => $today,
                'compare' => '<',
                'type' => 'DATE',
            ]
        ];

        $events = get_posts($args);

        if(!isset($events[0])) {
            unset($args['post__in']);
            unset($args['ignore_sticky_posts']);
            $today = date('Y-m-d');
            $args['meta_query'] = [
                'key'=> 'event_date',
                'value' => $today,
                'compare' => '<',
                'type' => 'DATE',
            ];
            $args['orderby'] = 'event_date';
            $events = get_posts($args);
        }

        if(!empty($events)) {
            $event = $events[0];
            $post_thumbnail = ( has_post_thumbnail( $event->ID ) ) ? get_the_post_thumbnail_url( $event->ID ) : null;
            $members_only = Utilities::get_instance()->members_only($event->ID);

            $return_post =  [
                'id'                    => $event->ID,
                'slug'                  => $event->post_name,
                'title'                 => $event->post_title,
                'image'                 => $post_thumbnail,
                'members_only'          => $members_only,
                'summary'               => rise_wp_get_the_contents($event),
                'category'              => rise_wp_return_the_category($event->ID, RISE_WP_EVENT_CATEGORIES),
                'link'                  => get_permalink($event->ID),
                'month'                 => rise_wp_format_date(get_field('event_date', $event->ID), 'M'),
                'day'                   => rise_wp_format_date(get_field('event_date', $event->ID), 'd'),
            ];
        }

        return $return_post;
    }

    public function get_related_events($event, $number_of_posts = 3) {
        $args = [
            'post__not_in' => [$event->ID],
            'post_type'      => RISE_WP_EVENTS,
            'posts_per_page'  => $number_of_posts,
            'ignore_sticky_posts' => 1
        ];

        $events = get_posts($args);

        if(!empty($events)) {
            foreach ($events as $event) {
                $post_thumbnail = ( has_post_thumbnail( $event->ID ) ) ? get_the_post_thumbnail_url( $event->ID ) : null;
                $members_only = Utilities::get_instance()->members_only($event->ID);
                $return_post[] =  [
                    'id'                    => $event->ID,
                    'slug'                  => $event->post_name,
                    'title'                 => $event->post_title,
                    'image'                 => $post_thumbnail,
                    'members_only'          => $members_only,
                    'type'                  => get_field('event_type', $event->ID),
                    'summary'               => rise_wp_get_the_contents($event),
                    'category'              => rise_wp_return_the_category($event->ID, RISE_WP_EVENT_CATEGORIES),
                    'link'                  => get_permalink($event->ID),
                    'month'                  => rise_wp_format_date(get_field('event_date', $event->ID), 'M'),
                    'day'                  => rise_wp_format_date(get_field('event_date', $event->ID), 'd'),
                ];
            }
        }

        return $return_post;
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
