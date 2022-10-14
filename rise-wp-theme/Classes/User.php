<?php

namespace RiseWP\Classes;


class User {

    public function get_user_post_info($post_id) {
        $return_data = [];

        $author_id = get_post_field( 'post_author', $post_id );

        $image = the_author_meta( 'avatar' , $author_id );
        $nicename = the_author_meta( 'user_nicename' , $author_id );
        $display_name = get_the_author_meta( 'display_name', $author_id );

        $return_data = [
            'id'        =>      $author_id,
            'image'     =>  $image,
            'name'      => $display_name,
            'nicename'      => $nicename
        ];

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
