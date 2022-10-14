<?php

/**
 * Forums Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

global $wp;
$page_url = $current_url = home_url( add_query_arg( array(), $wp->request ));

$is_active_class = 'text-gray250';
if (bbp_is_single_forum() && (strpos($page_url, bbp_get_forum_permalink()) !== false || strpos(bbp_get_forum_permalink(), $page_url) !== false)) {
    $is_active_class = 'text-red bg-orange400 border-red border-l-3';
}

?>
<a href="<?php bbp_forum_permalink(); ?>" title="<?php bbp_forum_title(); ?>" id="bbp-forum-<?php bbp_forum_id(); ?>"
   class="py-4 block w-full text-left hover:bg-orange400 focus: outline-none pl-10 <?= $is_active_class; ?>"><?php bbp_forum_title(); ?></a>