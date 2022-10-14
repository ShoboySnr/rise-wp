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
$query = $wp->query_vars;
$post_type = $query['post_type'];

$posts = [];
if(isset($query[$post_type]) && $post_type === 'forum') {
    $slug = $query[$post_type];

    $posts = get_posts([
        'fields'        => 'ids',
        'name'          => $slug,
        'post_type'     => $post_type,
    ]);
}

$posts = isset($posts[0]) ? $posts[0] : 0;

?>
<option value="<?php echo bbp_get_forum_id(); ?>" <?php selected($posts, bbp_get_forum_id(), true) ?>><?php bbp_forum_title(); ?></option>