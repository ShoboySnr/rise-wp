<?php

namespace RiseWP\Classes;

use WP_Query;

class Knowledge
{

      public function get_all_knowledge($knowledge_category = '', $knowledge_type = '', $posts_per_page = '')
      {
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $return_post = [];
            $args = [
                'post_type' => RISE_WP_KNOWLEDGE,
                'tax_query' => [],
                'order' => 'DESC',
                'paged'     => $paged
            ];

          if(!empty($posts_per_page)) {
              $args['posts_per_page'] = $posts_per_page;
          }

        if (!empty($knowledge_category)) {
          $knowledge_category_args = [
            [
              'taxonomy' => RISE_WP_KNOWLEDGE_CAT,
              'field' => 'slug',
              'terms' => $knowledge_category,
            ],
          ];
          $args['tax_query'][] = array_merge($knowledge_category_args, $args['tax_query']);
        }

        if (!empty($knowledge_type)) {
          $knowledge_type_args = [
            [
              'taxonomy' => RISE_WP_KNOWLEDGE_TYPE,
              'field' => 'slug',
              'terms' => $knowledge_type,
            ],
          ];

            $args['tax_query'] = array_merge($knowledge_type_args, $args['tax_query']);
        }

          if(!empty($top_filters) && !empty($categories)){
              $args['tax_query']['relation'] = 'AND';
          }
    
          //implement for search query
          if(!empty($_GET['q'])) {
              $args['post__in'] = Utilities::get_instance()->filter_search_post_ids($_GET['q']);
          }

        $args = array_merge($args);

        $results = new WP_Query($args);
        $return_post['wp_query'] = $results;

        $results = $results->posts;

        if (!empty($results)) {
          foreach ($results as $knowledge) {
              $types = rise_wp_return_the_category($knowledge->ID, RISE_WP_KNOWLEDGE_TYPE);
            $post_thumbnail = (has_post_thumbnail($knowledge->ID)) ? get_the_post_thumbnail_url($knowledge->ID) : $types['image'];
            $date = date('js M Y', strtotime(get_field('research_date', $knowledge->ID)));

            $return_post['data'][] = [
              'id'          => $knowledge->ID,
              'slug'        => $knowledge->post_name,
              'title'       => wp_trim_words($knowledge->post_title, 9, '...'),
              'content'     => $knowledge->post_content,
              'image'       => $post_thumbnail,
              'excerpt'     => wp_trim_words($knowledge->post_content, 9, '...'),
              'category'    => rise_wp_return_the_category($knowledge->ID, RISE_WP_KNOWLEDGE_CAT),
              'type'        => $types,
              'custom_date' => rise_wp_format_date_news(get_field('research_date', $knowledge->ID)),
              'link'        => get_permalink($knowledge->ID),
              'date'        => $date,
            ];
          }
        }

        return $return_post;
      }


      public function get_related_knowledge($knowledge_id, $posts_per_page = 3, $category)
      {
          $return_post = [];

          $args = [
             'post__not_in' => [$knowledge_id],
              'post_type' => RISE_WP_KNOWLEDGE,
            'category_id' => [$category],
              'tax_query' => [],
          ];

          if(!empty($posts_per_page)) {
              $args['posts_per_page'] = $posts_per_page;
              $args['paged'] = -1;
          }

          $results = new WP_Query($args);

          $results = $results->posts;

          if (!empty($results)) {
              foreach ($results as $knowledge) {
                  $types = rise_wp_return_the_category($knowledge->ID, RISE_WP_KNOWLEDGE_TYPE);
                  $post_thumbnail = (has_post_thumbnail($knowledge->ID)) ? get_the_post_thumbnail_url($knowledge->ID) : $types['image'];

                  $return_post[] = [
                      'id'              => $knowledge->ID,
                      'slug'            => $knowledge->post_name,
                      'title'           => $knowledge->post_title,
                      'content'         => $knowledge->post_content,
                      'image'           => $post_thumbnail,
                      'excerpt'         => wp_trim_words($knowledge->post_content, 10, '...'),
                      'category'        => rise_wp_return_the_category($knowledge->ID, RISE_WP_KNOWLEDGE_CAT),
                      'type'            => $types,
                      'custom_date'     => rise_wp_format_date_news(get_field('research_date', $knowledge->ID)),
                      'link'            => get_permalink($knowledge->ID),

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
      public static function get_instance()
      {
        static $instance = null;

        if (is_null($instance)) {
          $instance = new self();
        }

        return $instance;
      }

}
