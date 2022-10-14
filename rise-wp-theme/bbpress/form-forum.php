<?php

/**
 * New/Edit Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

$forum_status = '';
if (bbp_is_forum_edit()) :
  $forum_status = sprintf(esc_html__('Now Editing &ldquo;%s&rdquo;', 'rise-wp-theme'), bbp_get_forum_title());
else :
  $forum_status = bbp_is_single_forum() ? sprintf(esc_html__('Create New Forum in &ldquo;%s&rdquo;', 'rise-wp-theme'), bbp_get_forum_title())  : esc_html__('Create a Forum', 'rise-wp-theme');
endif;


?>
<div class="min-h-screen bg-gray100 md:pl-24">
  <?php
$page_title = get_field('page_title', get_page_by_path('forum')->ID);

$page_header_args = [
    [
        'title'   => get_page_by_path('member-directory')->post_title,
        'link'    => get_permalink(get_page_by_path('member-directory'))
    ],
    [
        'title'   => get_page_by_path('forum')->post_title,
        'link'    => get_permalink(get_page_by_path('forum')),
    ],
    [
        'title'   => get_page_by_path('rise-team')->post_title,
        'link'    => get_permalink(get_page_by_path('rise-team')),
    ]
];

do_action('rise_wp_member_dashboard_header', $page_title, $page_header_args);

?>
      <div class="dashboard-wrap connect-tabs-wrapper">
        <div class="connect-tab">
          <div class="mt-10 flex flex-col lg:flex-row justify-between">
            <div class="flex mb-4 lg:mb-0 items-center">
              <a href="<?= get_permalink(get_page_by_path('member-directory')) ?>" class="mr-4"><?= __('Connect', 'rise-wp-theme') ?></a>
              <?php include RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php' ?>
              <a href="<?= get_permalink(get_page_by_path('forum')) ?>" class="mr-4"><?= __('Forum', 'rise-wp-theme') ?></a>
              <?php include RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php' ?>
              <p class="mr-4 overflow-hidden whitespace-nowrap overflow-ellipsis"><?= $forum_status ?></p>
            </div>
            <div class="flex items-center">
             <?php
                 $how_to_use_rise_dashboard_title = get_field('how_to_the_rise_dashboard_title', get_page_by_path('forum'));
                 $how_to_use_rise_dashboard = get_field('how_to_the_rise_dashboard', get_page_by_path('forum'));
                 include(RISE_THEME_PARTIAL_VIEWS.'/how-to-use-rise.php');
                 ?>
            </div>
          </div>
          <?php
          if ( bbp_is_forum_edit() ) : ?>


              <div id="bbpress-forums" class="bbpress-wrapper">

              <?php bbp_breadcrumb(); ?>

              <?php bbp_single_forum_description( array( 'forum_id' => bbp_get_forum_id() ) ); ?>

          <?php endif; ?>

          <?php if ( bbp_current_user_can_access_create_forum_form() ) : ?>

              <div id="new-forum-<?php bbp_forum_id(); ?>" class="bbp-forum-form">

                  <form id="new-post" name="new-post" method="post">

                      <?php do_action( 'bbp_theme_before_forum_form' ); ?>

                      <div class="bbp-form">
                          <?php do_action( 'bbp_theme_before_forum_form_notices' ); ?>

                          <?php if ( ! bbp_is_forum_edit() && bbp_is_forum_closed() ) : ?>

                              <div class="bbp-template-notice">
                                  <ul>
                                      <li><?php esc_html_e( 'This forum is closed to new content, however your posting capabilities still allow you to post.', 'bbpress' ); ?></li>
                                  </ul>
                              </div>

                          <?php endif; ?>

                          <?php do_action( 'bbp_template_notices' ); ?>

                          <div>

                              <?php do_action( 'bbp_theme_before_forum_form_title' ); ?>

                              <div class="mb-10">
                                  <input class="my-6 h-12 px-5 w-full rounded-lg border border-gray350" type="text" id="bbp_forum_title" value="<?php bbp_form_forum_title(); ?>" size="40" name="bbp_forum_title" maxlength="<?php bbp_title_max_length(); ?>" placeholder="<?= sprintf( esc_html__( 'Forum Name (Maximum Length: %d):', 'rise-wp-theme' ), bbp_get_title_max_length() ); ?>" />
                              </div>

                              <?php do_action( 'bbp_theme_after_forum_form_title' ); ?>

                              <?php do_action( 'bbp_theme_before_forum_form_content' ); ?>

                              <div class="mb-10">
                                <?php bbp_the_content( array( 'context' => 'forum' ) ); ?>
                              </div>

                              <?php do_action( 'bbp_theme_after_forum_form_content' ); ?>

                              <?php if ( ! ( bbp_use_wp_editor() || current_user_can( 'unfiltered_html' ) ) ) : ?>

                                  <p class="form-allowed-tags">
                                      <label><?php esc_html_e( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:','rise-wp-theme' ); ?></label><br />
                                      <code><?php bbp_allowed_tags(); ?></code>
                                  </p>

                              <?php endif; ?>
                              <div class="mt-10 flex flex-row sm:flex-col justify-between">

                              <?php if ( bbp_allow_forum_mods() && current_user_can( 'assign_moderators' ) ) : ?>

                                  <?php do_action( 'bbp_theme_before_forum_form_mods' ); ?>

                                  <div class="mb-4">
                                      <label for="bbp_moderators"><?php esc_html_e( 'Forum Moderators:', 'bbpress' ); ?></label>
                                      <input type="text" value="<?php bbp_form_forum_moderators(); ?>" size="40" name="bbp_moderators" id="bbp_moderators" class="my-3 h-12 px-5 w-full rounded-lg border border-gray350" placeholder="<?php esc_html_e( 'Forum Moderators:', 'rise-wp-theme' ); ?>" />
                                  </div>

                                  <?php do_action( 'bbp_theme_after_forum_form_mods' ); ?>

                              <?php endif; ?>

                                <input type='hidden' name='bbp_forum_parent_id' id='bbp_forum_parent_id' value='-1'>
                              </div>

                              <?php do_action( 'bbp_theme_after_forum_form_parent' ); ?>

                              <?php do_action( 'bbp_theme_before_forum_form_submit_wrapper' ); ?>

                            <div class="mt-12 bg-white flex justify-between sm:justify-end items-center px-6 sm:px-16 h-24 w-full rounded-lg border border-gray350">

                              <?php do_action( 'bbp_theme_before_forum_form_submit_button' ); ?>
                              <button onclick="if(confirm('Are you sure you want to cancel this?')) document.location.href='<?= get_permalink(get_page_by_path('forum')) ?>'" type="button" class="font-medium text-sm bg-none border-none mr-8"><?= __('Cancel', 'rise-wp-theme') ?></button>

                              <button type="submit" id="bbp_forum_submit" name="bbp_forum_submit" class="button submit h-11 w-32 mt-4 sm:mt-0 bg-red border-2 border-red focus:outline-none rounded-full text-white hover:bg-white hover:text-red transition-all"><?php esc_html_e( 'Create Forum', 'bbpress' ); ?></button>
                              <?php do_action( 'bbp_theme_after_forum_form_submit_button' ); ?>

                            </div>

                              <?php do_action( 'bbp_theme_after_forum_form_submit_wrapper' ); ?>

                          </div>

                          <?php bbp_forum_form_fields(); ?>

                      </div>

                      <?php do_action( 'bbp_theme_after_forum_form' ); ?>

                  </form>
              </div>

          <?php elseif ( bbp_is_forum_closed() ) : ?>

              <div id="no-forum-<?php bbp_forum_id(); ?>" class="bbp-no-forum">
                  <div class="bbp-template-notice">
                      <ul>
                          <li><?php printf( esc_html__( 'The forum &#8216;%s&#8217; is closed to new content.', 'bbpress' ), bbp_get_forum_title() ); ?></li>
                      </ul>
                  </div>
              </div>

          <?php else : ?>

              <div id="no-forum-<?php bbp_forum_id(); ?>" class="bbp-no-forum">
                  <div class="bbp-template-notice">
                      <ul>
                          <li><?php is_user_logged_in()
                                  ? esc_html_e( 'You cannot create new forum.',               'bbpress' )
                                  : esc_html_e( 'You must be logged in to create new forum.', 'bbpress' );
                              ?></li>
                      </ul>
                  </div>
              </div>

          <?php endif; ?>

          <?php if ( bbp_is_forum_edit() ) : ?>

              </div>

          <?php endif; ?>
        </div>
      </div>
</div>
