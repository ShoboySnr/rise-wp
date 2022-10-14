<?php
/*
Template Name: Rise Activities Template
*/

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

global $post;
$sub_title = get_field('page_subtitle');
?>
<div class="dashboard-wrapper">
<div class="dashboard-container remove-padding">
    <div class="connections">
        <?php
        $page_title = get_field('page_title');

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
        <div class="connections-nav-container">
            <div class="connections-nav">
                <p class="mr-4"><?= $page_title ?></p>
                <?php include(RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php'); ?>
                <p class=""><?= $post->post_title ?></p>
            </div>
    
            <?php
                $how_to_use_rise_dashboard_title = get_field('how_to_the_rise_dashboard_title');
                $how_to_use_rise_dashboard = get_field('how_to_the_rise_dashboard');
        
                if(!empty($how_to_use_rise_dashboard_title)) {
                    include RISE_THEME_PARTIAL_VIEWS . '/how-to-use-rise.php';
                }
            ?>
        </div>

        <?php the_content() ?>
    </div>


    </div>
</div>


<?php

get_footer();
