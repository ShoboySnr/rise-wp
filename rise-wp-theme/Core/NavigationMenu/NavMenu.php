<?php

namespace RiseWP\Core\NavigationMenu;

use Walker_Nav_Menu;

class NavMenu extends Walker_Nav_Menu  {

    public function start_lvl( &$output, $depth = 0, $args = array()) {
        $output .= '';
    }

    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        $output .= '';
    }

    public function start_el(&$output, $item, $depth = 0, $args = [], $current_object_id = 0 )
    {
        //items wrap
        $args->items_wrap = '<ul id="%1$s" class="%2$s">%3$s</ul>';

        $classes = $item->classes;

        if($args->walker->has_children) {
            $classes[] = 'nav-list-dropdown';
        }

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

        $atts = [];
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
        $atts['slug']   = ! empty( $item->slug )        ? $item->slug      : '';
        #$atts['class']   = 'nav-list-label';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

        $attributes = '';
        $item_output = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        // Check if it is a submenu
        if ($args->walker->has_children && $depth === 0) {
            $sub_menu_details = $this->return_sub_menu_details($args->menu, $item->ID);
            $output .= sprintf('<li id="%s" class="%s"><a %s > %s </a>%s %s</li>',
                "menu-item-$item->ID",
                "relative hidden lg:inline-flex font-semibold mr-10 false hover:text-red dropdown-item",
                $attributes,
                apply_filters( 'the_title', $item->title, $item->ID ), 
                '<!--
                <button type="button" id="'. strtolower($item->title) .'-dropdown" aria-expanded="true" aria-haspopup="true" data-dropdown-toggle="dropdownNavbar" class="text-red hover:text-red">
                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button> -->',
                $this->output_sub_menu($sub_menu_details)
            );

        } else if($depth === 0) {
            $output .= '<li  id="menu-item-'. $item->ID .'" class="'. $class_names .'"><a'. $attributes. ' >';
            $output .= apply_filters( 'the_title', $item->title, $item->ID );
            $output .= '</a></li>';
        }

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    public function return_sub_menu_details($menu_slug, $menu_id) {
        $get_all_nav_menus = wp_get_nav_menu_items($menu_slug);
        $return_sub_menu = [];
        foreach($get_all_nav_menus as $key => $value) {
            if($menu_id == $value->menu_item_parent) {
                $return_sub_menu[] = [
                    'id'    => $value->ID,
                    'title' => apply_filters( 'the_title', $value->title, $value->ID ),
                    'href'  => $value->url
                ];
            }
        }

        return $return_sub_menu;
    }

    public function output_sub_menu($sub_menu_details){
        $output = '<div id="nav-dropdown" class="dropdown-tip hidden -mr-28 origin-top-right absolute right-0 mt-8 w-56 bg-red ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">';
        foreach($sub_menu_details as $sub_menu_detail) {
            $output .= '<div class="py-1" role="none"><a href="'. $sub_menu_detail['href'] .'" class="text-white font-semibold block px-4 py-2 text-sm" role="menuitem" tab-index="-1" id="menu-item-'. $sub_menu_detail['id'] .'">'. $sub_menu_detail['title'] .'</a></div>';
        }
        $output .= '</div>';
        return $output;
    }
}