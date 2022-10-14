<?php


namespace RiseWP\Classes;


class Advisors
{

  function get_advisors($post_per_page = 3){
    $return_post = [];
    $args = [
      'post_type' => 'advisors',
      'posts_per_page' => $post_per_page,
      'order' => 'DESC',
      'orderby' => 'menu_order',
    ];

    $results = new \WP_Query($args);

    $results = $results->posts;



    if(!empty($results)){
      foreach ($results as $result){
        $post_thumbnail = ( has_post_thumbnail( $result->ID ) ) ? get_the_post_thumbnail_url( $result->ID ) : null;

        $return_post[] = [
          'id' => $result->ID,
          'slug' => $result->slug,
          'title' => $result->post_title,
          'excerpt' => $result->post_excerpt,
          'content' => apply_filters('the_content', $result->post_content),
          'advisor_profession' =>  get_field('advisor_profession', $result->ID),
          'image' => $post_thumbnail,
          'link' => get_permalink($result->ID),
        ];
      }


      return $return_post;
    }

  }


  /**
   * Singleton poop.
   *
   * @return Advisors|null
   */
  public static function get_instance() {
    static $instance = null;

    if (is_null($instance)) {
      $instance = new self();
    }

    return $instance;
  }
}
