<?php
    /**
     * The template for displaying all single posts
     *
     * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
     *
     * @package Rise_OUP
     */

use RiseWP\Classes\Videos;

global $post;
$id = get_the_ID();

$help_link = get_permalink(get_page_by_path('help'));
$all_videos_link = get_permalink(get_page_by_path('help/all-videos'));
$help_page_subtitle = get_field('page_subtitle', get_page_by_path('help')->ID);

$postDate = rise_wp_format_date_news(get_the_date(), 'D d M Y');
$webinar_video_embed = get_field('webinar_video_embed', $post);
$author_name = get_field('author_name', $post);
$author_image = get_field('author_image', $post);
$webinar_duration = get_field('webinar_duration', $post);

$thumbnail = !empty(get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : $types['image'];

$related_posts = Videos::get_instance()->get_related_help_videos($id, 3);

get_header('dashboard');
?>
    <div class="dashboard-wrapper">
        <section class="dashboard-container remove-padding">
            <h3 class="dashboard-wrap connect-heading"><?= "Help" ?></h3>
            <div class="dashboard-wrap">
                        
                    <div class="mt-10 flex flex-col sm:flex-row justify-between items-start">
                        <div class="flex mb-4 sm:mb-0 font-light text-sm">
                            <a href="<?= $help_link ?>" class="mr-4 text-riseBodyText"><?= get_page_by_path('help')->post_title ?></a>
                            <?php include(RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php'); ?>
                            <a href="<?= $all_videos_link ?>" class="pr-4 text-riseBodyText">'<?= get_page_by_path('help/all-videos')->post_title ?>'</a>
                            <?php include(RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php'); ?>
                            <a href="<?= $all_videos_link ?>" class="pr-4 text-riseBodyText w-40" style="text-overflow:ellipsis;overflow:hidden;white-space:nowrap;"><?= $post->post_title  ?></a>
                        </div>

                        <p class="text-sm text-riseDark sm:text-left mb-7">
                            <?= $help_page_subtitle ?>
                        </p>
                    </div>


                        <div class="pt-14 flex justify-between items-center">
                            <a href="<?= $all_videos_link ?>" class="text-sm text-riseDark sm:text-left mb-7 flex gap-2 items-center w-max">
                                <?php include(RISE_THEME_SVG_COMPONENTS.'/arrow-back-colored-member-area.php'); ?>
                                <span><?= __('Go back', 'rise-wp-theme') ?></span>
                            </a>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center mb-12  pb-12 border-b border-gray360">
                            <div class="relative">
                                <div class="w-full col-span-3 flex justify-center items-center h-full bg-no-repeat bg-cover video-popup cursor-pointer" style="height:372px;background: linear-gradient(
                                        rgb(51 47 47 / 85%),
                                        rgb(90 77 77 / 85%)
                                        ), url('<?= $thumbnail ?>'); background-size:cover; border-radius: 15px " <?= !empty($webinar_video_embed) ? 'video-url="'.$webinar_video_embed.'"' : '' ?>>
                                    <svg width="76" height="47" viewBox="0 0 76 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="76" height="47" rx="10" fill="#DB3B0F"/>
                                        <rect width="76" height="47" rx="10" fill="#DB3B0F"/>
                                        <path d="M45.4886 24.4289C45.4247 24.5067 45.1264 24.8372 44.892 25.051L44.7642 25.1677C42.9744 26.9368 38.5213 29.6002 36.2628 30.4557C36.2628 30.4751 34.9205 30.9806 34.2812 31H34.196C33.2159 31 32.2997 30.4945 31.831 29.678C31.5753 29.2309 31.3409 27.9283 31.3196 27.9089C31.1278 26.7424 31 24.9558 31 22.9903C31 20.9295 31.1278 19.0632 31.3622 17.9162C31.3622 17.8967 31.5966 16.8469 31.7457 16.497C31.9801 15.9915 32.4062 15.5638 32.9389 15.2916C33.3651 15.0972 33.8125 15 34.2812 15C34.7713 15.0194 35.6875 15.313 36.0497 15.4471C38.4361 16.3026 42.9957 19.1021 44.7429 20.8129C45.0412 21.0851 45.3608 21.4156 45.446 21.4933C45.8082 21.921 46 22.4459 46 23.0117C46 23.5152 45.8295 24.0207 45.4886 24.4289Z" fill="white"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="mt-4 text-xs text-riseBodyText"><?= $postDate ?></p>
                                <h2 class="text-riseDark text-3.5xl font-bold mt-8 max-w-sm"><?= get_the_title() ?></h2>
                                <p class="text-riseBodyText mt-8"><?= $webinar_duration ?></p>
                            </div>
                        </div>
                        <div >
                            <div class="list-disc tools-resources-content" id="rise-content-area">
                                <?php the_content() ?>
                            </div>
                            
                        </div>
                        <?php

                            if(!empty($related_posts)) {
                                ?>
                                <div class="border-b border-gray360">
                                    <p class="pt-16 pb-4"><?= __('Related Videos', 'rise-wp-theme') ?></p>
                                </div>
                                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-5 gap-4 w-full pt-10 pb-14">
                                    <?php
                                        foreach ($related_posts as $help_video) {
                                            ?>
                                            <webinar-card title="<?= $help_video['title'] ?>"  link="<?= $help_video['link'] ?>" video_link="<?= json_encode($help_video['webinar_video_link']) ?>" image="<?= $help_video['image'] ?>"></webinar-card>
                                        <?php } ?>
                                </div>
                            <?php } ?>
                    
                </div>
            
        </section>
    </div>


<?php

    get_footer('dashboard');
