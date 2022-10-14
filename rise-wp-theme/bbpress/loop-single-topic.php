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

$author_meta_data = get_userdata($author_id);

$author_roles = $author_meta_data->roles;

$author_link = um_user_profile_url(um_user( 'ID' ));
if(in_array('administrator', $author_roles)) {
    $author_link = 'javascript:void(0);';
}
?>
<div class="bg-white border border-gray350 mt-4 rounded-lg px-6 sm:px-12 pt-8 sm:pt-16 pb-8" id="bbp-forum-<?php bbp_topic_id(); ?>">
    <a href="<?php bbp_topic_permalink(); ?>" class="block text-xl font-semibold mb-7">
        <?php bbp_topic_title(); ?>
    </a>
    <div class="flex flex-col sm:flex-row justify-between">
        <a href="<?= $author_link ?>" class="flex items-center mb-6">
            <img class="h-8 w-8 object-cover mr-4 filter drop-shadow-xl rounded-full"
                 src="<?= get_avatar_url( um_user( 'ID' ), ['size' => 8]) ?>" alt="">
            <span class="text-sm font-medium text-riseBodyText"><?= um_user('display_name') ?></span>
        </a>
        <a href="<?php bbp_forum_permalink(bbp_get_topic_forum_id(bbp_get_topic_id())); ?>" class="w-max px-4 py-1 mb-6 rounded-full bg-gray100"><?php bbp_topic_forum_title(bbp_get_topic_id()) ?></a>
    </div>
    <div class="font-light pt-8 pb-10 border-b border-gray350">
        <div class=""><?= wp_trim_words(strip_tags(bbp_get_topic_content()), 80, '...')  ?></div>
    </div>
    <div class="flex flex-col sm:flex-row justify-between mt-7">
        <a href="<?php bbp_topic_permalink(); ?>" class="mb-4 sm:mb-0 flex items-center text-sm text-gray450">
            <?php include(RISE_THEME_SVG_COMPONENTS.'/comment-icon.php'); ?>
            <?php bbp_topic_reply_count() ?> comments
        </a>
        <p class="text-sm text-gray450"><?= bbp_get_topic_post_date(bbp_get_topic_id(), true) ?></p>
    </div>
</div><!-- #bbp-forum-<?php bbp_topic_id(); ?> -->
