<?php

/**
 * Topics Loop - Single
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;
$author_id = get_the_author_meta( 'ID' );
um_fetch_user($author_id);
?>
<div class="mb-10">
    <div class="flex items-center">
        <a class="flex items-center" href="<?= bbp_get_user_profile_url(um_user('ID')) ?>" title="<?= um_user('display_name') ?>">
            <img class="h-10 w-10 object-cover mr-4 filter drop-shadow-xl rounded-full"
                 src="<?= get_avatar_url( um_user( 'ID' ), ['size' => '10']) ?>" alt="<?= um_user('display_name') ?>">
            <span class="font-medium"><?= um_user('display_name') ?></span>
        </a>
        <span class="ml-4 text-sm font-light"><?= bbp_get_topic_post_date(bbp_get_topic_id(), true) ?></span>
    </div>
    <p onclick="document.location.href='<?php bbp_topic_permalink(); ?>'" class="my-4 text-gray250 cursor-pointer"><?php bbp_topic_title(); ?></p>
    <a href="<?php bbp_topic_permalink(); ?>" class="mb-4 sm:mb-0 flex items-center text-sm text-gray450 font-light">
        <?php include(RISE_THEME_SVG_COMPONENTS.'/comment-icon.php'); ?>
        <?php bbp_topic_reply_count() ?> <?= __('comments', 'rise-wp-theme') ?>
    </a>
</div><!-- #bbp-forum-<?php bbp_topic_id(); ?> -->
