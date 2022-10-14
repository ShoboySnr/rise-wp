<?php

/**
 * Forums Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

do_action( 'bbp_template_before_forums_loop' );

?>
<div class="bg-white rounded-lg border border-gray350 py-6" id="bbp-forum-<?php bbp_forum_id(); ?>">
    <a href="<?= get_permalink(bbp_get_page_by_path('forum')) ?>"
       class="py-4 block w-full text-left hover:bg-orange400 focus: outline-none pl-10 <?php if(bbp_get_forum_id() == '' || bbp_get_forum_id() == null) echo 'bg-orange400 border-red border-l-3'; else echo 'text-gray250'; ?>"><?= __('All', 'rise-wp-theme') ?></a>
    <?php while ( bbp_forums() ) : bbp_the_forum(); ?>
        <?php bbp_get_template_part( 'loop', 'single-forum' ); ?>
    <?php endwhile; ?>
</div>
