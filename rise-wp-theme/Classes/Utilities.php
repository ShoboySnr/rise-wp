<?php

namespace RiseWP\Classes;

class Utilities {

    public function members_only($post_id, $open = 'Open', $closed = 'Members Only') {
        $members_only = get_field('members_only', $post_id);

        if($members_only === 'Yes') {
            return $closed;
        }

        return $open;
    }
    
    public function get_post_terms($category_type = 'category', $hide_empty = false) {
        $return_cat = [];
        $args = [
            'taxonomy'          => $category_type,
            'hide_empty'        => $hide_empty
        ];
        
        $terms = get_terms($args);
        
        if(!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $return_cat[] = [
                    'id' => $term->term_id,
                    'title' => html_entity_decode($term->name),
                    'slug' => $term->slug,
                    'link'  => get_term_link($term->term_id),
                ];
            }
        }
        
        return $return_cat;
    }


    public function get_post_taxonomy($post_id, $category_type)
    {
        $return_cat = [];
        $categories = get_the_terms($post_id, $category_type);

        if (!empty($categories) && !is_wp_error($categories)) {
            foreach ($categories as $category) {
                $return_cat[] = [
                    'id' => $category->term_id,
                    'title' => html_entity_decode($category->name),
                    'slug' => $category->slug,
                    'link'  => get_term_link($category->term_id),
                ];
            }
        }

        return $return_cat;
    }
    
    public function filter_search_post_ids($s) {
        global $wpdb;
        
        $keyword = sanitize_text_field($s);
        $keyword = '%' . $wpdb->esc_like( $keyword ) . '%';
    
        // Search in all custom fields
        $post_ids_meta = $wpdb->get_col( $wpdb->prepare( "
                SELECT DISTINCT post_id FROM {$wpdb->postmeta}
                WHERE meta_value LIKE '%s'
            ", $keyword ) );
    
        // Search in post_title and post_content
        $post_ids_post = $wpdb->get_col( $wpdb->prepare( "
                SELECT DISTINCT ID FROM {$wpdb->posts}
                WHERE post_title LIKE '%s'
                OR post_content LIKE '%s'
            ", $keyword, $keyword ) );
    
        return array_unique(array_merge( $post_ids_meta, $post_ids_post));
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
