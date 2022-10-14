<?php if ( ! defined( 'ABSPATH' ) ) exit;

use RiseWP\Classes\Opportunities;
use RiseWP\Classes\OpportunitiesBanner;

$panels = OpportunitiesBanner::get_instance()->get_top_banners();

    get_header();

    global $post;

    $sub_title = get_field('page_subtitle');
?>


    <div class="dashboard-wrapper min-h-screen">
    <div class="dashboard-container remove-padding">
        <div class="connections">
            <?php
                $page_title = get_field('page_title', get_page_by_path('connections'));


                $page_header_args = [
                    [
                        'title'   => get_page_by_path('connections')->post_title,
                        'link'    => get_permalink(get_page_by_path('connections')),
                    ],
                    [
                        'title'   => get_page_by_path('messages')->post_title,
                        'link'    => get_permalink(get_page_by_path('messages')),
                    ],
                    [
                        'title'   => get_page_by_path('innovation-audits')->post_title,
                        'link'    => get_permalink(get_page_by_path('innovation-audits')),
                    ],
                    [
                        'title'   => get_page_by_path('opportunities')->post_title,
                        'link'    => get_permalink(get_page_by_path('opportunities')),
                    ],
                    [
                        'title'   => get_page_by_path('activities')->post_title,
                        'link'    => get_permalink(get_page_by_path('activities')),
                    ],

                ];

                do_action('rise_wp_member_dashboard_header', $page_title, $page_header_args)
            ?>
        </div>

        <div class="dashboard-wrap connect-tabs-wrapper">
            <div class="mt-10 flex flex-col lg:flex-row justify-between text-riseBodyText mb-16">
                <div class="flex mb-4 lg:mb-0 items-center font-light text-sm">
                    <p class="mr-4"><?= get_page_by_path('connections')->post_title ?></p>
                    <?php include(RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php'); ?>
                    <p class=""><?= get_page_by_path('opportunities')->post_title; ?></p>
                </div>

                <div class="flex items-center">
                    <?php
                        $how_to_use_rise_dashboard_title = get_field('how_to_the_rise_dashboard_title');
                        $how_to_use_rise_dashboard = get_field('how_to_the_rise_dashboard');

                        if(!empty($how_to_use_rise_dashboard_title)) {
                            include RISE_THEME_PARTIAL_VIEWS . '/how-to-use-rise.php';
                        }
                    ?>
                </div>
            </div>
            <div>
                <?= do_shortcode('[rise_wp_bookmarked_opportunities]'); ?>
            </div>
        </div>
    </div>

<?php

    get_footer();
