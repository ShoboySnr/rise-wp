<?php

/**
 * Topics Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

?>

<?php while ( bbp_topics() ) : bbp_the_topic(); ?>

    <?php bbp_get_template_part( 'loop', 'single-topic-related' ); ?>

<?php endwhile; ?><!-- .forums-directory -->

