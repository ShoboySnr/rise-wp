<?php

/**
 * Replies Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

do_action( 'bbp_template_before_replies_loop' );
?>
<div id="topic-<?php bbp_topic_id(); ?>-replies" class="forums bbp-replies">
    <p class="text-xl sm:text-lg font-semibold mt-8 mb-5"><?= bbp_topic_title() ?></p>
    <div class="flex flex-wrap items-center text-xs font-light">
        <p class="pr-4 border-r border-gray250"><?= bbp_get_topic_post_date(bbp_get_topic_id()) ?></p>
        <button type="button" class="open-contact-modal text-xs font-light mx-4" id="report-topic"><?= __('Report', 'rise-wp-theme') ?></button>
        <a href="<?php bbp_forum_permalink(bbp_get_topic_forum_id(bbp_get_topic_id())); ?>" class="w-max mt-3 sm:mt-0 ml-auto px-4 py-1 rounded-full bg-gray350"><?php bbp_topic_forum_title(bbp_get_topic_id()) ?></a>
    </div>
    <div class="mt-14" id="threaded-comments">
        <?php if ( bbp_thread_replies() ) : ?>
            <?php bbp_list_replies(); ?>

        <?php else : ?>
            <?php while ( bbp_replies() ) : bbp_the_reply(); ?>

                <?php bbp_get_template_part( 'loop', 'single-reply' ); ?>

            <?php endwhile; ?>

        <?php endif; ?>
    </div>
</div><!-- #topic-<?php bbp_topic_id(); ?>-replies -->

<?php do_action( 'bbp_template_after_replies_loop' ); ?>
