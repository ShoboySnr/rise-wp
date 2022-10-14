<!--
Template Name: All Videos Template
-->
<?php
if (!defined('ABSPATH')) exit;


$help_link = get_permalink(get_page_by_path('help'));
$all_videos_link = get_permalink(get_page_by_path('help/all-videos'));
$page_title = get_field('page_title');
$sub_title = get_field('page_subtitle');

get_header();
?>

<div class="dashboard-wrapper">
    <section class="dashboard-container remove-padding pb-24">
        <h3 class="dashboard-wrap connect-heading"><?= $page_title ?></h3>
        <div class="dashboard-wrap">

            <div class="mt-10 flex flex-col sm:flex-row justify-between items-start">
                <div class="flex mb-4 sm:mb-0 font-light text-sm">
                    <a href="<?= $help_link ?>" class="mr-4 text-riseBodyText"><?= __('Help', 'rise-wp-theme') ?></a>
                    <?php include(RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php'); ?>
                    <a href="<?= $all_videos_link ?>" class="pr-4 text-riseBodyText">'<?= get_page_by_path('help/all-videos')->post_title ?>'</a>
                </div>

                <p class="text-sm text-riseDark sm:text-left mb-7">
                   <?= $sub_title ?>
                </p>
            </div>

            <section>
                <?=  the_content();  ?>
            </section>

        </div>
    </section>
</div>


<?php
get_footer()
?>