<?php

/**
 * Replies Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;
$author_id = get_the_author_meta( 'ID' );
um_reset_user();
um_fetch_user(bbp_get_reply_author_id());

$author_meta_data = get_userdata(bbp_get_reply_author_id());

$author_roles = $author_meta_data->roles;

$author_link = um_user_profile_url(bbp_get_reply_author_id());
if(in_array('administrator', $author_roles)) {
    $author_link = 'javascript:void(0);';
}

?>
<div class="list-comments-number">
    <div class="mt-18 sm:mt-20">
        <p class="pt-2 text-lg font-semibold"><?=  bbp_get_topic_post_count() - 1 ?> <?= __('comments', 'rise-wp-theme') ?></p>

    </div>
</div>
<div class="mt-10">
    <div id="post-<?php bbp_reply_id(); ?>">
    <div class="flex items-center mb-4">
        <a href="<?= $author_link ?>" class="flex items-center mr-4">
            <img class="h-10 w-10 object-cover mr-5 filter drop-shadow-xl rounded-full"
                 src="<?= get_avatar_url(um_user('ID'), ['size' => 16]) ?>" alt="<?= um_user('display_name'); ?>" title="<?= um_user('display_name'); ?>">
            <span class="text-sm font-semibold"><?= um_user('display_name') ?></span>
        </a>
        <p class="text-sm font-light"><?php bbp_reply_post_date(bbp_get_reply_id(), true) ?></p>
    </div>
    <div class="sm:ml-20" id="topics-contents">
        <div class="font-light sm:font-normal mb-8 text-gray250">
            <?php bbp_reply_content(); ?>
        </div>
        <!-- CSS override -->
        <style>
            #topics-contents img {
                height: unset !important;
                width: unset !important;
            }
        </style>
    </div>
        <div class="mt-4 ml-14" id="topic-action-link">
            <?php do_action( 'bbp_theme_before_reply_admin_links' ); ?>

            <?php echo bbp_get_reply_admin_links([
                'before' => '',
                'after'  => '',
                'sep'    => '',
            ]); ?>

            <?php do_action( 'bbp_theme_after_reply_admin_links' ); ?>
        </div>
</div>
</div>