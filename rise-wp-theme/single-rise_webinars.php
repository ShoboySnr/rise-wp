<?php
    /**
     * The template for displaying all single posts
     *
     * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
     *
     * @package Rise_OUP
     */

use RiseWP\Classes\Webinars;

global $post;
$id = get_the_ID();

$tools_link = get_permalink(get_page_by_path('develop/knowledge-and-tools'));
$downloadable_link = get_permalink(get_page_by_path('develop/tools-and-resources/webinars'));

$category = rise_wp_return_the_category($id, RISE_WP_TOOLSRESOURCES_CAT);
$postDate = rise_wp_format_date_news(get_the_date(), 'D d M Y');
$webinar_video_embed = get_field('webinar_video_embed', $post);
$author_name = get_field('author_name', $post);
$author_image = get_field('author_image', $post);
$webinar_duration = get_field('webinar_duration', $post);

$types = rise_wp_return_the_category($id, RISE_WP_TOOLSRESOURCES_TYPES);
$thumbnail = !empty(get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : $types['image'];

$related_posts = \RiseWP\Classes\Webinars::get_instance()->get_related_tools_resources_webinars($id, 3);

get_header('dashboard');
?>
    <div class="dashboard-wrapper">
        <section class="dashboard-container remove-padding">
            <div class="connections">
                <?php
                    $page_title = get_field('page_title', get_page_by_path('develop/knowledge-and-tools'));
                    $sub_title = get_field('page_subtitle');
    
                    $page_header_args = [
                        [
                            'title' => get_page_by_path('develop/innovation-audits')->post_title,
                            'link' => get_permalink(get_page_by_path('develop/innovation-audits')),
                        ],
                        [
                            'title' => get_page_by_path('develop/knowledge-and-tools')->post_title,
                            'link' => get_permalink(get_page_by_path('develop/knowledge-and-tools')),
                        ],
                        [
                            'title' => get_page_by_path('develop/opportunities')->post_title,
                            'link' => get_permalink(get_page_by_path('develop/opportunities')),
                        ]
                    ];

                    do_action('rise_wp_member_dashboard_header', $page_title, $page_header_args)
                ?>
            </div>
            <div class="dashboard-wrap connect-tabs-wrapper">
                <div class="connect-tab">
                    <div>
                        <div class="mt-10 flex flex-col sm:flex-row justify-between">
                            <div class="flex items-center font-light text-sm">
                                <p class="mr-4"><?= __('Develop', 'rise-wp-theme') ?></p>
                                <?php include(RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php'); ?>
                                <a href="<?= $tools_link ?>" class="pr-4"><?= get_page_by_path('develop/knowledge-and-tools')->post_title ?></a>
                                <?php include(RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php'); ?>
                                <a href="<?= get_permalink(get_page_by_path('develop/knowledge-and-tools/webinars')) ?>" class="pr-4"><?= get_page_by_path('develop/knowledge-and-tools/webinars')->post_title ?></a>
                                <?php include(RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php'); ?>
                                <p><?= $post->post_title; ?></p>
                            </div>
                        </div>

                        <div class="pt-14 flex justify-between items-center">
                            <a href="<?= get_permalink(get_page_by_path('develop/knowledge-and-tools/webinars')) ?>" class="text-sm text-riseDark sm:text-left mb-7 flex gap-2 items-center w-max">
                                <?php include(RISE_THEME_SVG_COMPONENTS.'/arrow-back-colored-member-area.php'); ?>
                                <span><?= __('Go back', 'rise-wp-theme') ?></span>
                            </a>
                        </div>
                        <div class="single-tools-page grid grid-cols-1 md:grid-cols-5 gap-8 items-start pb-12 border-b border-gray360">
                            <div class="w-full col-span-3 flex justify-center items-center h-full bg-no-repeat bg-cover video-popup cursor-pointer" style="background: linear-gradient(
                                    rgb(51 47 47 / 85%),
                                    rgb(90 77 77 / 85%)
                                    ), url('<?= $thumbnail ?>'); border-radius: 15px " <?= !empty($webinar_video_embed) ? 'video-url="'.$webinar_video_embed.'"' : '' ?>>
                                <svg width="76" height="47" viewBox="0 0 76 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="76" height="47" rx="10" fill="#DB3B0F"/>
                                    <rect width="76" height="47" rx="10" fill="#DB3B0F"/>
                                    <path d="M45.4886 24.4289C45.4247 24.5067 45.1264 24.8372 44.892 25.051L44.7642 25.1677C42.9744 26.9368 38.5213 29.6002 36.2628 30.4557C36.2628 30.4751 34.9205 30.9806 34.2812 31H34.196C33.2159 31 32.2997 30.4945 31.831 29.678C31.5753 29.2309 31.3409 27.9283 31.3196 27.9089C31.1278 26.7424 31 24.9558 31 22.9903C31 20.9295 31.1278 19.0632 31.3622 17.9162C31.3622 17.8967 31.5966 16.8469 31.7457 16.497C31.9801 15.9915 32.4062 15.5638 32.9389 15.2916C33.3651 15.0972 33.8125 15 34.2812 15C34.7713 15.0194 35.6875 15.313 36.0497 15.4471C38.4361 16.3026 42.9957 19.1021 44.7429 20.8129C45.0412 21.0851 45.3608 21.4156 45.446 21.4933C45.8082 21.921 46 22.4459 46 23.0117C46 23.5152 45.8295 24.0207 45.4886 24.4289Z" fill="white"/>
                                </svg>
                            </div>
                            <div class="mt-14 col-span-2">
                                <div class="flex justify-between">
                                    <?php
                                        if(!empty($category['title'])) {
                                    ?>
                                    <p class="px-4 py-1 mt-4 text-xs bg-gray350 text-riseBodyText rounded-full"><?= $category['title'] ?></p>
                                    <?php } ?>
                                    <p class="px-4 py-1 mt-4 text-xs text-riseBodyText text-right w-full"><?= $postDate ?></p>
                                </div>
                                <h2 class="text-riseDark text-2xl font-medium mt-8"><?= get_the_title() ?></h2>
                                <p class="text-riseBodyText pt-4 w-max"><?= $webinar_duration ?></p>
                            </div>
                        </div>
                        <div class="pt-12 grid grid-cols-1 md:grid-cols-2">
                            <div class="list-disc tools-resources-content" id="rise-content-area">
                                <?php the_content() ?>
                            </div>
                            <?php

                                if(!empty($author_name)) {
                                    ?>
                                    <div class="text-center flex flex-col items-center">
                                        <p class="text-riseDark font-medium self-end" style="margin: 0 auto"><?= __('Uploaded By:', 'rise-wp-theme') ?></p>
                                        <div class="pt-4 flex gap-4 items-center self-end" style="margin: 0 auto; padding-left: 36px; ">
                                            <?php
                                            if(!empty($author_image)) {
                                                ?>
                                                <img src="<?= $author_image ?>" class="w-12 h-12 object-fit rounded-full" alt="<?= $author_name; ?>" title="<?= $author_name; ?>" />
                                            <?php } ?>
                                                <p class="text-riseDark"><?= $author_name; ?></p>
                                        </div>
                                    </div>
                                <?php } ?>
                        </div>
                        <?php

                            if(!empty($related_posts)) {
                                ?>
                                <div class="border-b border-gray360">
                                    <p class="pt-16 pb-4"><?= __('Related webinars', 'rise-wp-theme') ?></p>
                                </div>
                                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-5 gap-4 w-full pt-10 pb-14">
                                    <?php
                                        foreach ($related_posts as $tool_resource) {
                                            ?>
                                            <webinar-card title="<?= $tool_resource['title'] ?>" tag="<?= $tool_resource['category']['title'] ?>" link="<?= $tool_resource['link'] ?>" video_link="<?= json_encode($tool_resource['webinar_video_link']) ?>" image="<?= $tool_resource['image'] ?>"></webinar-card>
                                        <?php } ?>
                                </div>
                            <?php } ?>
                    </div>
                </div>
            </div>
        </section>
    </div>


<?php

    get_footer('dashboard');
