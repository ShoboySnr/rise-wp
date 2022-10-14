<?php

namespace RiseWP\Core\NavigationMenu;

use Walker_Nav_Menu;

class LoggedInWalker extends Walker_Nav_Menu {

    public function start_el(&$output, $item, $depth = 0, $args = [], $current_object_id = 0 )
    {
        if(!empty($args)) {
            $page_id = get_the_ID();
            $args->items_wrap = '<ul class="pages items-center">%3$s</ul>';

            $classes = $item->classes;

            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

            $atts = [];
            $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
            $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
            $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
            $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
            $atts['slug']   = ! empty( $item->slug )        ? $item->slug      : '';

            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

            $attributes = '';
            $item_output = '';
            foreach ( $atts as $attr => $value ) {
                if ( ! empty( $value ) ) {
                    $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            //check for the active class
            $active = $page_id == $item->object_id ? 'active' : '';

            $menu_item_list = get_post_meta( $item->ID, '_rise_wp_menu_items', true);


            $title = '<span>'.apply_filters( 'the_title', $item->title, $item->ID ).'</span>';
            if(!empty($menu_item_list)) {
                $menu_item_list = json_decode($menu_item_list, true);
                if($menu_item_list['icons_only'] == 'both') {
                    $title = $menu_item_list['icon_content'].'<span>'.apply_filters( 'the_title', $item->title, $item->ID ).'</span>';
                }
            }

            $output .= '<li class="'.$active.'"><a'. $attributes. ' >';
            $output .=  $title;
            $output .= '</a></li>';


            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    }
}
