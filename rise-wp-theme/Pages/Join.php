<?php


namespace RiseWP\Pages;


class Join
{


public function get_join_contents(){

    return[

        'join_banner_title' => get_field('join_banner_title'),
    'join_banner_subtitle' => get_field('join_banner_subtitle'),
    'join_banner_button' => get_field('join_banner_button'),
    'section_two_title' => get_field('section_two_title'),
    'section_two_subtitle' => get_field('section_two_subtitle'),
    'friend_box' => get_field('friend_box'),
    'member_box' => get_field('member_box'),
    'section_url' => get_field('section_url'),
    'ceo_name' => get_field('ceo_name'),
    'ceo_position' => get_field('ceo_position'),
    'ceo_content_area' => get_field('ceo_content_area'),
    'ceo_image' => get_field('ceo_image'),
    'join_banner_image' => get_field('join_banner_image'),
    'footer_pre_text' => get_field('footer_pre_text'),
    'footer_pre_link' => get_field('footer_pre_link'),
    'footer_prefix_image' => get_field('footer_prefix_image'),
    'join_banner_subtitle' => get_field('join_banner_subtitle'),
    ];
}





    public static function get_instance() {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }
}
