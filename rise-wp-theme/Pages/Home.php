<?php

namespace RiseWP\Pages;

class Home {

    /**
     * @return array
     */
    public function get_home() {
        global $posts;

        //first global post content
        $posts = $posts[0];

        $return_data =  [
            'banner_title' => get_field('banner_title', $posts),
            'banner_title_two' => get_field('banner_title_two', $posts),
            'banner_subtitle_one' => get_field('banner_subtitle_one', $posts),
            'banner_subtitle_two' => get_field('banner_subtitle_two', $posts),
            'banner_button' => get_field('banner_button', $posts),
            'banner_image' => get_field('banner_image', $posts),
            'banner_image_lines' => get_field('banner_image_lines', $posts),
            'first_section_image' => get_field('first_section_image', $posts),
            'first_section_title' => get_field('first_section_title', $posts),
            'first_section_description' => get_field('first_section_description', $posts),
            'first_section_link' => get_field('first_section_link', $posts),
            'innovate_section_image' => get_field('innovate_section_image', $posts),
            'innovate_section_title' => get_field('innovate_section_title', $posts),
            'innovate_section_description' => get_field('innovate_section_description', $posts),
            'get_started_title' => get_field('get_started_title', $posts),
            'get_started_description' => get_field('get_started_description', $posts),
            'get_started_image' => get_field('get_started_image', $posts),
            'get_started_link' => get_field('get_started_link', $posts),
            'success_title' => get_field('success_title', $posts),
            'success_quotes' => get_field('success_quotes', $posts),
            'success_subtitle' => get_field('success_subtitle', $posts),
            'success_image' => get_field('success_image', $posts),
            'success_link' => get_field('success_link', $posts),
            'footer_prefix' => get_field('footer_pre_text', $posts),
            'footer_pre_link' => get_field('footer_pre_link',$posts),
             'footer_prefix_image' => get_field('footer_prefix_image', $posts),
            'twitter_title' => get_field('twitter_title', $posts),

        ];

        return $return_data;
    }


    /**
     * @param $posts
     * @return array
     */

    public function get_partners($posts) {
        $images = acf_photo_gallery('logos_partners', $posts);

        $return_partners = [];
        foreach( $images as $image ) {
            $return_partners[] = [
                'id' => $image['id'],
                'image_url' => $image['full_image_url'],
                'title' => $image['title'],
                'caption' => $image['caption'],
            ];
        }

        return $return_partners;
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
