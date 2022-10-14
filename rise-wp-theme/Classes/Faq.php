<?php

namespace RiseWP\Classes;

class Faq {

    public function get_faq() {
        $return_data = [];

        //get all the terms of the faq
        $args = [
            'taxonomy'  => RISE_WP_FAQS_CATEGORY,
            'hide_empty'    => true,
        ];

        $categories = get_terms($args);

        if(!empty($categories)) {
            foreach ($categories as $key => $value) {
                $faq_posts = [];
                $post_args = [
                    'post_type'     => RISE_WP_FAQS,
                    'tax_query'    => [
                        [
                            'taxonomy' => RISE_WP_FAQS_CATEGORY,
                            'field' => 'slug',
                            'terms' => $value->slug,
                        ]
                    ],
                ];

                $faqs = get_posts($post_args);
                foreach($faqs as $faq) {
                    $faq_posts[] = [
                        'id'            => $faq->ID,
                        'slug'          => $faq->post_name,
                        'title'         => $faq->post_title,
                        'content'       => $faq->post_content,
                    ];
                }

                $return_data[] = [
                    'id' => $value->term_id,
                    'title' => $value->name,
                    'slug' => $value->slug,
                    'posts' => $faq_posts,
                ];
            }
        }

        return $return_data;
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
