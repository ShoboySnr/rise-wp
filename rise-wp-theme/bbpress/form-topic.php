<?php

/**
 * New/Edit Topic
 *
 * @package rise-wp-theme
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

?>

<?php
if ( ! bbp_is_single_forum() ) : ?>

<div id="rise-wp-theme-forums" class="rise-wp-theme-wrapper">

  <?php //bbp_breadcrumb(); ?>

<?php endif; ?>

<?php if ( bbp_is_topic_edit() ) : ?>
  <div>
  <?php bbp_topic_tag_list( bbp_get_topic_id() ); ?>

  <?php bbp_single_topic_description( array( 'topic_id' => bbp_get_topic_id() ) ); ?>

  <?php bbp_get_template_part( 'alert', 'topic-lock' ); ?>

<?php else: ?>
    <div class="mt-10">
      <?php endif; ?>

<?php if ( bbp_current_user_can_access_create_topic_form() ) : ?>

  <div id="new-topic-<?php bbp_topic_id(); ?>" class="bbp-topic-form" style="<?php echo bbp_has_errors() ? 'display: block;' : '' ?>">

    <form id="new-post" name="new-post" method="post" class="bg-white topics-submission">
        <div class="border border-gray350 rounded-lg p-6 sm:py-14 sm:px-16">
      <?php do_action( 'bbp_theme_before_topic_form' ); ?>

      <div class="bbp-form">
        <?php do_action( 'bbp_theme_before_topic_form_notices' ); ?>

        <?php if ( ! bbp_is_topic_edit() && bbp_is_forum_closed() ) : ?>

          <div class="bbp-template-notice">
            <ul>
              <li><?php esc_html_e( 'This forum is marked as closed to new topics, however your posting capabilities still allow you to create a topic.', 'rise-wp-theme' ); ?></li>
            </ul>
          </div>

        <?php endif; ?>

        <?php do_action( 'bbp_template_notices' ); ?>

        <div>

          <?php bbp_get_template_part( 'form', 'anonymous' ); ?>


            <?php if ( ! bbp_is_single_forum() ) : ?>

                <?php do_action( 'bbp_theme_before_topic_form_forum' ); ?>
                <div class="relative">
                    <label class="block text-xl font-semibold mb-6" for="bbp_topic_forum_select"><?= __('Choose topic', 'rise-wp-theme') ?> <span
                                class="text-sm font-light"><?= __('(Required)', 'rise-wp-theme') ?></span></label>
                        <div class="relative">
                            <?php
                            bbp_dropdown( array(
                                'show_none'     => __('Select topic', 'rise-wp-theme'),
                                'selected'      => bbp_get_form_topic_forum(),
                                'select_id'     => 'bbp_topic_forum_select',
                                'select_class'  => 'member-filter w-full py-4 pl-6 pr-16 border border-gray350 rounded-full focus:outline-none',
                            ) );
                            ?>
                            <svg class="absolute top-1/2 transform -translate-y-1/2 right-6" width="16" height="10" viewBox="0 0 16 10" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 1.5L8 8.5L1 1.5" stroke="#130F26" stroke-width="1.5"
                                      stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                </div>

                <?php do_action( 'bbp_theme_after_topic_form_forum' ); ?>

            <?php endif; ?>

          <?php do_action('bbp_theme_before_topic_form_forum_select'); ?>

            <?php if (bbp_is_single_forum() ) : ?>

            <?php

            if (bbp_has_forums(['post_parent' => 0])) :
            ?>
                <div class="relative">
                        <label class="block text-xl font-semibold mb-6" for="bbp_topic_forum_select"><?= __('Choose topic', 'rise-wp-theme') ?> <span
                                    class="text-sm font-light"><?= __('(Required)', 'rise-wp-theme') ?></span></label>
                    <div class="relative">
                        <select class="member-filter w-full py-4 pl-6 pr-16 border border-gray350 rounded-full focus:outline-none" name="bbp_topic_forum_select" id="bbp_topic_forum_select" required="required">
                            <option value=""><?= __('Select topic', 'rise-wp-theme') ?></option>
                            <?php bbp_get_template_part( 'loop',     'forums-select' ); ?>
                        </select>
                        <svg class="absolute top-1/2 transform -translate-y-1/2 right-6" width="16" height="10" viewBox="0 0 16 10" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 1.5L8 8.5L1 1.5" stroke="#130F26" stroke-width="1.5"
                                  stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
            <?php endif; ?>
            <?php endif; ?>

            <?php do_action('bbp_theme_after_topic_form_forum_select'); ?>

          <?php do_action( 'bbp_theme_before_topic_form_title' ); ?>

          <label class="block text-xl font-semibold mb-6 mt-12" for="bbp_topic_title"><?= __('Title', 'rise-wp-theme') ?> <span
                      class="text-sm font-light"><?= __('(Required)', 'rise-wp-theme') ?></span></label>
        <input class="h-12 w-full font-light border border-gray350 rounded-full px-6 py-3" type="text" id="bbp_topic_title" value="<?php bbp_form_topic_title(); ?>" size="40" name="bbp_topic_title" maxlength="<?php bbp_title_max_length(); ?>" placeholder="<?= esc_html__( 'Add your post title', 'rise-wp-theme' ); ?>" required="required" />

          <?php do_action( 'bbp_theme_after_topic_form_title' ); ?>

          <?php do_action( 'bbp_theme_before_topic_form_content' ); ?>
            <div class="flex justify-between">
                <label class="block text-xl font-semibold mb-6 mt-12" for="post"><?= __('Write your post', 'rise-wp-theme') ?> <span class="text-sm font-light"><?= __('(Required)', 'rise-wp-theme') ?></span></label>
                <button type="button" id="add-image-to-content" class="button h-10 w-32 mt-10 bg-red border-2 border-red focus:outline-none rounded-full text-white hover:bg-white hover:text-red transition-all"><?php esc_html_e( 'Add Image', 'rise-wp-theme' ); ?></button>
            </div>
          <?php bbp_the_content( array( 'context' => 'topic') ); ?>

          <?php do_action( 'bbp_theme_after_topic_form_content' ); ?>

          <?php if ( ! ( bbp_use_wp_editor() || current_user_can( 'unfiltered_html' ) ) ) : ?>

            <p class="form-allowed-tags">
              <label><?php printf( esc_html__( 'You may use these %s tags and attributes:', 'rise-wp-theme' ), '<abbr title="HyperText Markup Language">HTML</abbr>' ); ?></label><br />
              <code><?php bbp_allowed_tags(); ?></code>
            </p>

          <?php endif; ?>

          <?php if ( bbp_allow_topic_tags() && current_user_can( 'assign_topic_tags', bbp_get_topic_id() ) ) : ?>

            <?php do_action( 'bbp_theme_before_topic_form_tags' ); ?>

            <p>
              <label for="bbp_topic_tags"><?php esc_html_e( 'Topic Tags:', 'rise-wp-theme' ); ?></label><br />
              <input type="text" value="<?php bbp_form_topic_tags(); ?>" size="40" name="bbp_topic_tags" id="bbp_topic_tags" <?php disabled( bbp_is_topic_spam() ); ?> />
            </p>

            <?php do_action( 'bbp_theme_after_topic_form_tags' ); ?>

          <?php endif; ?>

          <?php if ( bbp_is_subscriptions_active() && ! bbp_is_anonymous() && ( ! bbp_is_topic_edit() || ( bbp_is_topic_edit() && ! bbp_is_topic_anonymous() ) ) ) : ?>

            <?php do_action( 'bbp_theme_before_topic_form_subscriptions' ); ?>

            <p class="hidden">
              <input name="bbp_topic_subscription" id="bbp_topic_subscription" type="checkbox" checked value="bbp_subscribe" <?php bbp_form_topic_subscribed(); ?> />

              <?php if ( bbp_is_topic_edit() && ( bbp_get_topic_author_id() !== bbp_get_current_user_id() ) ) : ?>

                <label for="bbp_topic_subscription"><?php esc_html_e( 'Notify the author of follow-up replies via email', 'rise-wp-theme' ); ?></label>

              <?php else : ?>

                <label for="bbp_topic_subscription"><?php esc_html_e( 'Notify me of follow-up replies via email', 'rise-wp-theme' ); ?></label>

              <?php endif; ?>
            </p>

            <?php do_action( 'bbp_theme_after_topic_form_subscriptions' ); ?>

          <?php endif; ?>

          <?php if ( bbp_allow_revisions() && bbp_is_topic_edit() ) : ?>

            <?php do_action( 'bbp_theme_before_topic_form_revisions' ); ?>

            <fieldset class="bbp-form hidden">
              <legend>
                <input name="bbp_log_topic_edit" id="bbp_log_topic_edit" type="checkbox" value="1" />
                <label for="bbp_log_topic_edit"><?php esc_html_e( 'Keep a log of this edit:', 'rise-wp-theme' ); ?></label><br />
              </legend>
            </fieldset>

            <?php do_action( 'bbp_theme_after_topic_form_revisions' ); ?>

          <?php endif; ?>

          <?php do_action( 'bbp_theme_before_topic_form_submit_wrapper' ); ?>

            <div class="mt-12 bg-white flex justify-between sm:justify-end items-center px-6 sm:px-16 h-24 w-full rounded-lg border border-gray350">

            <?php do_action( 'bbp_theme_before_topic_form_submit_button' ); ?>
            <button id="cancel-topics-form" type="button" class="font-medium text-sm bg-none border-none mr-8"><?= __('Cancel', 'rise-wp-theme') ?></button>
            <button type="submit" id="bbp_topic_submit" name="bbp_topic_submit" class="button submit h-11 w-32 mt-4 sm:mt-0 bg-red border-2 border-red focus:outline-none rounded-full text-white hover:bg-white hover:text-red transition-all  <?php if(!(bbp_is_topic_edit())): echo 'hidden'; endif ?>" <?php if(!(bbp_is_topic_edit())): echo 'disabled'; endif ?>><?php esc_html_e( 'Publish', 'rise-wp-theme' ); ?></button>

            
                <input type="hidden" name="bbp_forum_id" id="bbp_forum_id" value="<?php echo bbp_get_topic_forum_id(); ?>">
            

            <?php do_action( 'bbp_theme_after_topic_form_submit_button' ); ?>

          </div>

          <?php do_action( 'bbp_theme_after_topic_form_submit_wrapper' ); ?>

        </div>

        <?php bbp_topic_form_fields(); ?>

      </div>

      <?php do_action( 'bbp_theme_after_topic_form' ); ?>
        </div>
    </form>
  </div>

<?php elseif ( bbp_is_forum_closed() ) : ?>

  <div id="forum-closed-<?php bbp_forum_id(); ?>" class="bbp-forum-closed">
    <div class="bbp-template-notice">
      <ul>
        <li><?php printf( esc_html__( 'The forum &#8216;%s&#8217; is closed to new topics and replies.', 'rise-wp-theme' ), bbp_get_forum_title() ); ?></li>
      </ul>
    </div>
  </div>

<?php else : ?>

  <div id="no-topic-<?php bbp_forum_id(); ?>" class="bbp-no-topic">
    <div class="bbp-template-notice">
      <ul>
        <li><?php is_user_logged_in()
          ? esc_html_e( 'You cannot create new topics.',               'rise-wp-theme' )
          : esc_html_e( 'You must be logged in to create new topics.', 'rise-wp-theme' );
        ?></li>
      </ul>
    </div>

    <?php if ( ! is_user_logged_in() ) : ?>

      <?php bbp_get_template_part( 'form', 'user-login' ); ?>

    <?php endif; ?>

  </div>

<?php endif; ?>
    </div>
<?php if ( ! bbp_is_single_forum() ) : ?>

</div>

<?php endif; ?>

