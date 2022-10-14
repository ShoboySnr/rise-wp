<?php


namespace RiseWP\Pages;


class About
{
    public function get_about_contents($id){

        $return_data = [
                'subtitle_text' => get_field('subtitle_text', $id),
                'first_section_subtitle' => get_field('first_section_subtitle' ,  $id),
                'first_section_text' => get_field('first_section_text' ,  $id),
                'first_section_image' => get_field('first_section_image' ,  $id),
                'first_section_image_two' => get_field('first_section_image_two' ,  $id),
                'universities_information' => get_field('universities_information' ,  $id),
                'eligible_content' => get_field('eligible_content' ,  $id),
                'project_partner_one_image' => get_field('project_partner_one_image' ,  $id),
                'local_council_subtitle' => get_field('local_council_subtitle' ,  $id),
                'project_partner_two_image' => get_field('project_partner_two_image' ,  $id),
                'project_partner_three_image' => get_field('project_partner_three_image' ,  $id),
                'first_section_right' => get_field('first_section_right' ,  $id),
                'faq_url' => get_field('faq_url' ,  $id),
                'rise_team_section_title' => get_field('rise_team_section_title' ,  $id),
                'rise_team_section_subtitle' => get_field('rise_team_section_subtitle' ,  $id),
                'project_partners_section_title' => get_field('project_partners_section_title' ,  $id),
                'project_partners_section_subtitle' => get_field('project_partners_section_subtitle' ,  $id),
                'partner_one_title' => get_field('partner_one_title',  $id),
                'partner_two_title' => get_field('partner_two_title',  $id),
                'partner_three_title' => get_field('partner_three_title',  $id),
                'partner_four_title' => get_field('partner_four_title',  $id),
                'partner_five_title' => get_field('partner_five_title',  $id),
                'partner_one_subtitle' => get_field('partner_one_subtitle',  $id),
                'partner_one_subtitle_more' => get_field('partner_one_subtitle_more',  $id),
                'partner_two_subtitle_more' => get_field('partner_two_subtitle_more',  $id),
                'partner_three_subtitle_more' => get_field('partner_three_subtitle_more',  $id),
                'partner_two_subtitle' => get_field('partner_two_subtitle',  $id),
                'partner_three_subtitle' => get_field('partner_three_subtitle',  $id),
                'erdf_title' => get_field('erdf_title',  $id),
                'erdf_subtitle' => get_field('erdf_subtitle',  $id),
                'erdf_subtitle_more' => get_field('erdf_subtitle_more',  $id),
                'local_council_images_more' => get_field('local_council_images_more',  $id),
                'local_council_title' => get_field('local_council_title',  $id),
                'local_councils_title' => get_field('local_councils_title',  $id),
                'local_councils_subtitle' => get_field('local_councils_subtitle',  $id),
                'partner_one_image' => get_field('partner_one_image',  $id),
                'partner_two_image' => get_field('partner_two_image',  $id),
                'partner_three_image' => get_field('partner_three_image',  $id),
                'partner_four_image' => get_field('partner_four_image',  $id),
                'partner_five_image' => get_field('partner_five_image',  $id),
                'footer_prefix_text' => get_field('footer_prefix_text',  $id),
                'footer_prefix_link' => get_field('footer_pre_link',  $id),
                'footer_prefix_image' => get_field('footer_prefix_image',  $id),
        ];
        return $return_data;
    }

    public function get_rise_team($post_per_page = -1){

        $return_results = [];
        $args = [
            'post_type' => 'rise_team',
            'posts_per_page' => $post_per_page,


        ];



        $results = get_posts($args);





       if(!empty($results)){
           foreach ($results as $result){
               $post_thumbnail = (has_post_thumbnail($result->ID)) ? get_the_post_thumbnail_url($result->ID) : null;

               $return_results[] = [
                    'id' => $result->ID,
                    'slug' => $result->slug,
                    'title' => $result->post_title,
                    'content' => $result->post_content,
                    'image' => $post_thumbnail,
                    'alt' => $result->post_name,
                    'link' => get_permalink($result->ID),
               ];
           }

           return $return_results;
       }




    }










    public static function get_instance() {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }
}
