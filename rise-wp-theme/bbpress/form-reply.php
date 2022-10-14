<?php

/**
 * New/Edit Reply
 *
 * @package rise-wp-theme
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

um_fetch_user(bbp_get_current_user_id());

// Replying to...
$reply_to = isset( $_GET['bbp_reply_to'] )
    ? (int) $_GET['bbp_reply_to']
    : 0;
$comment_title = '';
if(!empty($reply_to)) {
    $comment_title = wp_trim_words(get_post($reply_to)->post_content, 10, '...');
}

if ( bbp_is_reply_edit() ) : ?>

<div id="rise-wp-theme-forums" class="rise-wp-theme-wrapper">

	<?php //bbp_breadcrumb(); ?>

<?php endif; ?>

<?php if ( bbp_current_user_can_access_create_reply_form() ) : ?>

	<div id="new-reply-<?php bbp_topic_id(); ?>" class="bbp-reply-form">

		<form id="new-post" name="new-post" method="post">

			<?php do_action( 'bbp_theme_before_reply_form' ); ?>
            <div class="sm:ml-20 flex mt-10">
                <img class="h-12 w-12 object-cover rounded-full mr-4"
                     src="<?= get_avatar_url(bbp_get_current_user_id()) ?>" title="<?= um_user('display_name') ?>" alt="<?= um_user('display_name') ?>">
                <fieldset class="w-full py-3 px-6 rounded-full font-light">
                    				<legend><?php printf( esc_html__( 'Reply To: %s', 'rise-wp-theme' ), ( bbp_get_form_reply_to() ) ? sprintf( esc_html__( '#%1$s', 'rise-wp-theme' ), $comment_title,) : bbp_get_topic_title() ); ?></legend>

                    <?php do_action( 'bbp_theme_before_reply_form_notices' ); ?>

                    <?php if ( ! bbp_is_topic_open() && ! bbp_is_reply_edit() ) : ?>

                        <div class="bbp-template-notice">
                            <ul>
                                <li><?php esc_html_e( 'This topic is marked as closed to new replies, however your posting capabilities still allow you to reply.', 'rise-wp-theme' ); ?></li>
                            </ul>
                        </div>

                    <?php endif; ?>

                    <?php if ( ! bbp_is_reply_edit() && bbp_is_forum_closed() ) : ?>

                        <div class="bbp-template-notice">
                            <ul>
                                <li><?php esc_html_e( 'This forum is closed to new content, however your posting capabilities still allow you to post.', 'rise-wp-theme' ); ?></li>
                            </ul>
                        </div>

                    <?php endif; ?>

                    <?php if ( current_user_can( 'unfiltered_html' ) ) : ?>

                        <div class="bbp-template-notice">
                            <ul>
                                <li><?php esc_html_e( 'Your account has the ability to post unrestricted HTML content.', 'rise-wp-theme' ); ?></li>
                            </ul>
                        </div>

                    <?php endif; ?>

                    <?php do_action( 'bbp_template_notices' ); ?>

                    <div>

                        <?php bbp_get_template_part( 'form', 'anonymous' ); ?>

                        <?php do_action( 'bbp_theme_before_reply_form_content' ); ?>

                        <button type="button" id="add-image-to-content" class="button h-10 w-32 mt-10 mb-2 bg-red border-2 border-red focus:outline-none rounded-full text-white hover:bg-white hover:text-red transition-all"><?php esc_html_e( 'Add Image', 'rise-wp-theme' ); ?></button>
                        <?php bbp_the_content( array( 'context' => 'reply' ) ); ?>

                        <?php do_action( 'bbp_theme_after_reply_form_content' ); ?>

                        <?php if ( ! ( bbp_use_wp_editor() || current_user_can( 'unfiltered_html' ) ) ) : ?>

                            <p class="form-allowed-tags">
                                <label><?php esc_html_e( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:','rise-wp-theme' ); ?></label><br />
                                <code><?php bbp_allowed_tags(); ?></code>
                            </p>

                        <?php endif; ?>

                        <?php if ( bbp_allow_topic_tags() && current_user_can( 'assign_topic_tags', bbp_get_topic_id() ) ) : ?>

                            <?php do_action( 'bbp_theme_before_reply_form_tags' ); ?>

                            <p>
                                <label for="bbp_topic_tags"><?php esc_html_e( 'Tags:', 'rise-wp-theme' ); ?></label><br />
                                <input type="text" value="<?php bbp_form_topic_tags(); ?>" size="40" name="bbp_topic_tags" id="bbp_topic_tags" <?php disabled( bbp_is_topic_spam() ); ?> />
                            </p>

                            <?php do_action( 'bbp_theme_after_reply_form_tags' ); ?>

                        <?php endif; ?>

                        <?php if ( bbp_is_subscriptions_active() && ! bbp_is_anonymous() && ( ! bbp_is_reply_edit() || ( bbp_is_reply_edit() && ! bbp_is_reply_anonymous() ) ) ) : ?>

                            <?php do_action( 'bbp_theme_before_reply_form_subscription' ); ?>

                            <p class="hidden">

                                <input name="bbp_topic_subscription" id="bbp_topic_subscription" type="checkbox" checked value="bbp_subscribe"<?php bbp_form_topic_subscribed(); ?> />

                                <?php if ( bbp_is_reply_edit() && ( bbp_get_reply_author_id() !== bbp_get_current_user_id() ) ) : ?>

                                    <label for="bbp_topic_subscription"><?php esc_html_e( 'Notify the author of follow-up replies via email', 'rise-wp-theme' ); ?></label>

                                <?php else : ?>

                                    <label for="bbp_topic_subscription"><?php esc_html_e( 'Notify me of follow-up replies via email', 'rise-wp-theme' ); ?></label>

                                <?php endif; ?>

                            </p>

                            <?php do_action( 'bbp_theme_after_reply_form_subscription' ); ?>

                        <?php endif; ?>

                        <?php if ( bbp_is_reply_edit() ) : ?>

                            <?php if ( current_user_can( 'moderate', bbp_get_reply_id() ) ) : ?>

                                <?php do_action( 'bbp_theme_before_reply_form_reply_to' ); ?>

                                <div class="hidden">
                                    <p class="form-reply-to">
                                        <label for="bbp_reply_to"><?php esc_html_e( 'Reply To:', 'rise-wp-theme' ); ?></label><br />
                                        <?php bbp_reply_to_dropdown(); ?>
                                    </p>
                                </div>

                                <?php do_action( 'bbp_theme_after_reply_form_reply_to' ); ?>

                                <?php do_action( 'bbp_theme_before_reply_form_status' ); ?>

                                <div class="hidden">
                                    <p>
                                        <label for="bbp_reply_status"><?php esc_html_e( 'Reply Status:', 'rise-wp-theme' ); ?></label><br />
                                      <?php bbp_form_reply_status_dropdown(); ?>
                                    </p>
                                </div>

                                <?php do_action( 'bbp_theme_after_reply_form_status' ); ?>

                            <?php endif; ?>

                            <?php if ( bbp_allow_revisions() ) : ?>

                                <?php do_action( 'bbp_theme_before_reply_form_revisions' ); ?>

                                <fieldset class="bbp-form hidden">
                                    <legend>
                                        <input name="bbp_log_reply_edit" id="bbp_log_reply_edit" type="checkbox" value="0" />
                                        <label for="bbp_log_reply_edit"><?php esc_html_e( 'Keep a log of this edit:', 'rise-wp-theme' ); ?></label><br />
                                    </legend>
                                </fieldset>

                                <?php do_action( 'bbp_theme_after_reply_form_revisions' ); ?>

                            <?php endif; ?>

                        <?php endif; ?>

                        <?php do_action( 'bbp_theme_before_reply_form_submit_wrapper' ); ?>

                        <div class="bbp-submit-wrapper">

                            <?php do_action( 'bbp_theme_before_reply_form_submit_button' ); ?>

                            <?php bbp_cancel_reply_to_link(); ?>

                            <button type="submit" id="bbp_reply_submit" name="bbp_reply_submit" class="button submit h-11 w-32 mt-4 sm:mt-0 bg-red border-2 border-red focus:outline-none rounded-full text-white hover:bg-white hover:text-red transition-all"><?php esc_html_e( 'Reply', 'rise-wp-theme' ); ?></button>

                            <?php do_action( 'bbp_theme_after_reply_form_submit_button' ); ?>

                        </div>

                        <?php do_action( 'bbp_theme_after_reply_form_submit_wrapper' ); ?>

                    </div>

                    <?php bbp_reply_form_fields(); ?>

                </fieldset>
            </div>

			<?php do_action( 'bbp_theme_after_reply_form' ); ?>

		</form>
	</div>

<?php elseif ( bbp_is_topic_closed() ) : ?>

	<div id="no-reply-<?php bbp_topic_id(); ?>" class="bbp-no-reply">
		<div class="bbp-template-notice">
			<ul>
				<li><?php printf( esc_html__( 'The topic &#8216;%s&#8217; is closed to new replies.', 'rise-wp-theme' ), bbp_get_topic_title() ); ?></li>
			</ul>
		</div>
	</div>

<?php elseif ( bbp_is_forum_closed( bbp_get_topic_forum_id() ) ) : ?>

	<div id="no-reply-<?php bbp_topic_id(); ?>" class="bbp-no-reply">
		<div class="bbp-template-notice">
			<ul>
				<li><?php printf( esc_html__( 'The forum &#8216;%s&#8217; is closed to new topics and replies.', 'rise-wp-theme' ), bbp_get_forum_title( bbp_get_topic_forum_id() ) ); ?></li>
			</ul>
		</div>
	</div>

<?php else : ?>

	<div id="no-reply-<?php bbp_topic_id(); ?>" class="bbp-no-reply">
		<div class="bbp-template-notice">
			<ul>
				<li><?php is_user_logged_in()
					? esc_html_e( 'You cannot reply to this topic.',               'rise-wp-theme' )
					: esc_html_e( 'You must be logged in to reply to this topic.', 'rise-wp-theme' );
				?></li>
			</ul>
		</div>

		<?php if ( ! is_user_logged_in() ) : ?>

			<?php bbp_get_template_part( 'form', 'user-login' ); ?>

		<?php endif; ?>

	</div>

<?php endif; ?>

<?php if ( bbp_is_reply_edit() ) : ?>

</div>

<?php endif;
