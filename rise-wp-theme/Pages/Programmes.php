<?php

namespace RiseWP\Pages;

class Programmes
{
    public function get_programmes_contents($id){

        $return_data = [
                'top_section' => get_field('top_section' ,  $id),//page_title
                'footer_prefix_text' => get_field('footer_pre_text',  $id),
                'footer_prefix_link' => get_field('footer_pre_link',  $id),
                'footer_prefix_image' => get_field('footer_prefix_image',  $id),
        ];
        return $return_data;
    }

    public function get_rise_programmes($id){
        if( get_field("programme_one", $id) ){
            $programme_content = get_field("programme_one", $id);
            $i = 1;
            include RISE_THEME_PARTIAL_VIEWS . "/programmes/_card-a.php";
        }
        if( get_field("programme_two", $id) ){
            $programme_content = get_field("programme_two", $id);
            $i = 2;
            include RISE_THEME_PARTIAL_VIEWS . "/programmes/_card-a.php";
        }
        if( get_field("programme_three", $id) ){
            $programme_content = get_field("programme_three", $id);
            $i = 3;
            include RISE_THEME_PARTIAL_VIEWS . "/programmes/_card-a.php";
        }
        if( get_field("programme_four", $id) ){
            $programme_content = get_field("programme_four", $id);
            $i = 4;
            include RISE_THEME_PARTIAL_VIEWS . "/programmes/_card-a.php";
        }
    }

    public function print_cols($id){
        if(get_field("column_a", $id)){
            $column_content = get_field("column_a", $id);
            include RISE_THEME_PARTIAL_VIEWS . "/programmes/_card-b.php";
        }

        if (get_field("column_b", $id)){
            $column_content = get_field("column_b", $id);
            include RISE_THEME_PARTIAL_VIEWS . "/programmes/_card-b.php";
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
