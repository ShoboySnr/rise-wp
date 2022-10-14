<?php

namespace RiseWP\Api;

use RiseWP\Classes\Videos;


class Help {


    public function __construct()
    {

        add_shortcode('rise_wp_help_video_resources', [$this, 'rise_wp_help_video_resources']);
        add_shortcode('rise_wp_all_help_video_resources', [$this, 'rise_wp_all_help_video_resources']);

    }

    public function rise_wp_help_video_resources($atts) {
        $args = shortcode_atts([
            'limit'         => 3
        ], $atts);

        $limit = $args['limit'];

        $output = '<div class="pb-10">';
        $output .= $this->get_help_videos_summary($limit, false);
        $output .= '</div>';


        return $output;
    }

    public function rise_wp_all_help_video_resources($atts) {
        $args = shortcode_atts([
            'limit'         => -1
        ], $atts);

        $limit = $args['limit'];

        $output = '<div class="pb-10">';
        $output .= $this->get_all_help_videos_summary($limit, false);
        $output .= '</div>';


        return $output;
    }

    public function get_help_videos_summary($post_per_page = '', $show_pagination = true) {

        $tools_resources = Videos::get_instance()->get_all_help_videos($post_per_page);

        $webinars_link = get_permalink(get_page_by_path('help/all-videos'));

        $output = '';

        if(!empty($tools_resources['data'])) {
            $output .= '<div class="flex justify-between items-center mt-14 mb-7">';
            $output .= '<h2 class="text-2xl font-bold">'.__('How to use the RISE member portal', 'rise-wp-theme'). '</h2>';
            $output .= '<a href="'.$webinars_link .'" title="'.__('View all', 'rise-wp-theme').'" class="flex items-center gap-2">'. __('View all', 'rise-wp-theme').'
                      <svg
                        width="25"
                        height="24"
                        viewBox="0 0 25 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M9 5L16 12L9 19"
                          stroke="#F15400"
                          stroke-width="1.5"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        />
                      </svg>
                    </a>';
            $output .= '</div>';
            $output .= '<div class="flex justify-between items-center">';

            $output .= $this->get_all_help_videos($post_per_page, $show_pagination);

            $output .= '</div>';
        }

        return $output;
    }

    public function get_all_help_videos_summary($post_per_page = '', $show_pagination = true) {

        $tools_resources = Videos::get_instance()->get_all_help_videos($post_per_page);

        $output = '';

        if(!empty($tools_resources['data'])) {
            $output .= '<div class="mb-7 mt-14">';
            $output .= '<h2 class="text-2xl font-bold">'.__('How to use the RISE member portal', 'rise-wp-theme'). '</h2>';
            
            $output .= '</div>';
            $output .= '<div class="flex justify-between items-center">';

            $output .= $this->get_all_help_videos($post_per_page, $show_pagination);

            $output .= '</div>';
        }

        return $output;
    }

    public function get_all_help_videos($post_per_page = '', $show_pagination = true) {

        $output = '<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-5 gap-4 w-full">';

        $tools_resources = Videos::get_instance()->get_all_help_videos($post_per_page);

        if(!empty($tools_resources['data'])) {
            foreach ($tools_resources['data'] as $tools_resource) {
                $title = $tools_resource['title'];
                if(strlen($title) > 70){
                    $title = substr($title, 0, 70) . '...';
                }
                $link = $tools_resource['link'];

                $image = $tools_resource['image'];
                if(empty($image)) {
                    $image = $tools_resource['types']['image'];
                }


                $output .= '<webinar-card title="'. $title. '" link="'. $link.'" image="'. $image. '" cardClass="h-full" ></webinar-card>';

            }
        }
        $output .= '</div>';

        if($show_pagination) $output .= apply_filters('member_area_pagination', $tools_resources['wp_query']);

        return $output;
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
