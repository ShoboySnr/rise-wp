<?php

/**
 * Single Topic Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

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

    do_action('rise_wp_member_dashboard_header', $page_title, $page_header_args)
    ?>
    <div class="dashboard-wrap connect-tabs-wrapper">
        <div class="connect-tab">
            <div class="mt-10 flex flex-col sm:flex-row justify-between">
                <div class="flex mb-4 lg:mb-0 items-center font-light text-sm">
                    <p class="mr-4"><?= __('Connect', 'rise-wp-theme') ?></p>
                    <?php include RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php' ?>
                    <a href="<?= get_permalink(get_page_by_path('forum')) ?>" class="mr-4"><?= __('Forum', 'rise-wp-theme') ?></a>
                    <?php include RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php' ?>
                    <p class=""><?= get_the_title(); ?></p>
                </div>
                <div class="flex items-center">
                    <?php
                        $how_to_use_rise_dashboard_title = get_field('how_to_the_rise_dashboard_title', get_page_by_path('forum'));
                        $how_to_use_rise_dashboard = get_field('how_to_the_rise_dashboard', get_page_by_path('forum'));
                        
                        include(RISE_THEME_PARTIAL_VIEWS.'/how-to-use-rise.php');
                        ?>
                </div>
            </div>
            <div class="mt-16 flex flex-col lg:flex-row justify-between mb-16">
                <div class="forum-content pb-20 lg:pb-0 lg:pr-20 border-b lg:border-r border-gray350 mb-8 lg:mb-0 lg:mr-8">
                    <div class="flex justify-between">
                        <a class="flex items-center" href="<?= get_permalink(get_page_by_path('forum')) ?>">
                           <?php include(RISE_THEME_SVG_COMPONENTS.'/arrow-back-colored.php'); ?>
                            <?= __('Go back', 'rise-wp-theme') ?></a>
                    </div>
                    <div id="bbpress-forums" class="bbpress-wrapper">

                        <?php do_action( 'bbp_template_before_single_topic' ); ?>

                        <?php if ( post_password_required() ) : ?>

                            <?php bbp_get_template_part( 'form', 'protected' ); ?>

                        <?php else : ?>

                            <?php bbp_topic_tag_list(); ?>

                            <?php //bbp_single_topic_description(); ?>

                            <?php if ( bbp_show_lead_topic() ) : ?>

                                <?php bbp_get_template_part( 'content', 'single-topic-lead' ); ?>

                            <?php endif; ?>

                            <?php if ( bbp_has_replies() ) : ?>

                                <?php bbp_get_template_part( 'loop',       'replies' ); ?>

                                <?php bbp_get_template_part( 'pagination', 'replies' ); ?>

                            <?php endif; ?>

                            <?php bbp_get_template_part( 'form', 'reply' ); ?>

                        <?php endif; ?>

                        <?php bbp_get_template_part( 'alert', 'topic-lock' ); ?>

                        <?php do_action( 'bbp_template_after_single_topic' ); ?>

                    </div>
                </div>
                <div class="w-full">
                    <p class="text-lg font-semibold my-10"><?= __('Related posts', 'rise-wp-theme') ?></p>
                    <?php
                    global $posts;
                    $post_id = $posts[0]->ID;
                    $related_args = [
                       'posts_per_page'         => 4,
                       'post__not_in'           => [$post_id]
                    ];

                    if ( bbp_has_topics($related_args) ) : ?>

                        <?php bbp_get_template_part( 'loop',     'topics-related'    ); ?>

                    <?php else : ?>

                        <?php bbp_get_template_part( 'feedback', 'no-topics-related' ); ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
