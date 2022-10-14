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
<?php while ( bbp_forums() ) : bbp_the_forum(); ?>
        <?php bbp_get_template_part( 'loop', 'single-forum-select' ); ?>
    <?php endwhile; ?>
