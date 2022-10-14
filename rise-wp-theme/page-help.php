<!--
Template Name: Help Template
-->
<?php
if (!defined('ABSPATH')) exit;


$page_title = get_field('page_title');
$sub_title = get_field('page_subtitle');

get_header();
?>

<div class="dashboard-wrapper">
    <section class="dashboard-container remove-padding pb-24">
        <h3 class="dashboard-wrap connect-heading"><?= $page_title ?></h3>
        <div class="dashboard-wrap">

            <div class="mt-10 flex flex-col sm:flex-row justify-between items-start ">
                <div class="flex mb-4 sm:mb-0">
                    <p class="mr-4 text-riseBodyText"><?= __('Help', 'rise-wp-theme') ?></p>
                </div>

                <p class="text-sm text-riseDark sm:text-left mb-7">
                   <?= $sub_title ?>
                </p>
            </div>

            <?php
                $top_section_title = get_field('top_section_title');
                $top_section_content = get_field('top_section_content');

            ?>
            <section class="bg-white shadow-sm rounded-xl py-10 px-9">
                <h3 class="text-2xl font-bold mb-5"><?= $top_section_title; ?></h3>
                <p class="text-base font-light whitespace-pre-line"><?= $top_section_content; ?></p>
            </section>

            <section>
                <?=  apply_filters( 'the_content','[rise_wp_help_video_resources limit=3]'); ?>
            </section>

            <section class="grid grid-cols-1 gap-4 items-stretch mb-10">
                <div class="bg-white shadow-sm rounded-xl py-10 px-9">
                <?php
                    $mid_section_title = get_field('mid_section_title');
                    $mid_section_content = get_field('mid_section_content');

                ?>
                    <h3 class="text-2xl font-bold mb-5"> <?= $mid_section_title ?></h3>
                    <div class="text-base font-light whitespace-pre-line">
                        <?php the_field('mid_section_content') ?>
                    </div>
                </div>
                <?php 
                    $featured_video_link = get_field("featured_video_link"); 
                    $featured_video_post = get_field("featured_video_post"); 
                ?>
            </section>

            <section class="bg-white shadow-sm rounded-xl py-10 px-9">
                <?php
                    $bottom_section_title = get_field('bottom_section_title');
                    $bottom_section_content = get_field('bottom_section_content');

                ?>
                <h3 class="text-2xl font-bold mb-5"><?= $bottom_section_title ?></h3>
                <p class="text-base font-light whitespace-pre-line"><?= $bottom_section_content ?></p>
            </section>

        </div>
    </section>
</div>


<?php
get_footer()
?>