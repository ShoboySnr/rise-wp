<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Rise_OUP
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function rise_wp_theme_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular Pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'rise_wp_theme_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, Pages, or attachments.
 */
function rise_wp_theme_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'rise_wp_theme_pingback_header' );

/**
 * Change the default posts to news
 *
 */
function rise_wp_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'News';
    $submenu['edit.php'][5][0] = 'News';
    $submenu['edit.php'][10][0] = 'Add News';
    $submenu['edit.php'][16][0] = 'News Tags';
}

function rise_wp_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'News';
    $labels->singular_name = 'News';
    $labels->add_new = 'Add News';
    $labels->add_new_item = 'Add News';
    $labels->edit_item = 'Edit News';
    $labels->new_item = 'News';
    $labels->view_item = 'View News';
    $labels->search_items = 'Search News';
    $labels->not_found = 'No News found';
    $labels->not_found_in_trash = 'No News found in Trash';
    $labels->all_items = 'All News';
    $labels->menu_name = 'News';
    $labels->name_admin_bar = 'News';
}
add_action( 'admin_menu', 'rise_wp_change_post_label' );
add_action( 'init', 'rise_wp_change_post_object' );

function get_rise_empty_states($message  = '') {
    return \RiseWP\Api\Init::empty_states($message);
}

function rise_empty_states($message  = '') {
    echo get_rise_empty_states($message);
}

