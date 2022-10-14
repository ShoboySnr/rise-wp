<?php


namespace RiseWP\Classes;


class DashboardBanner
{
  function get_banners($post_per_page = -1){
    $return_post = [];
    $args = [
      'post_type' => 'dashboard_banner',
      'posts_per_page' => $post_per_page,
      'order' => 'ASC',
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
          'content' => apply_filters('the_content', $result->post_content),
          'panel_sub_image' =>  get_field('panel_sub_image', $result->ID),
          'panel_link' =>  get_field('panel_link', $result->ID),
          'image' => $post_thumbnail
        ];
      }


      return $return_post;
    }

  }







  /**
   * Singleton poop.
   *
   * @return Dashboard|null
   */
  public static function get_instance() {
    static $instance = null;

    if (is_null($instance)) {
      $instance = new self();
    }

    return $instance;
  }

}
