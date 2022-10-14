<?php
    /**
     * The template for displaying all single posts
     *
     * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
     *
     * @package Rise_OUP
     */
    
use RiseWP\Classes\ToolResources;

global $post;
$id = get_the_ID();

$tools_link = get_permalink(get_page_by_path('develop/knowledge-and-tools'));
$downloadable_link = get_permalink(get_page_by_path('develop/knowledge-and-tools/knowledge-and-tools-library'));
$category = rise_wp_return_the_category($id, RISE_WP_TOOLSRESOURCES_CAT);
$postDate = rise_wp_format_date_news(get_the_date(), 'D d M Y');
$attachment = get_field('upload_attachment', $post);
$author_name = get_field('author_name', $post);
$author_image = get_field('author_image', $post);

$related_posts = ToolResources::get_instance()->get_related_tools_resources($id, 3);

$types = rise_wp_return_the_category($id, RISE_WP_OPPORTUNITIES_TYPES);
$post_thumbnail = !empty(get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : $types['image'];
    
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
                        'title' => get_page_by_path('develop/knowledge-and-tools')->post_title,
                        'link' => get_permalink(get_page_by_path('develop/knowledge-and-tools')),
                    ],
                    [
                        'title' => get_page_by_path('develop/innovation-audits')->post_title,
                        'link' => get_permalink(get_page_by_path('develop/innovation-audits')),
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
                        <div class="flex mb-4 sm:mb-0 items-center">
                            <p class="mr-4 text-riseBodyText"><?= $page_title ?></p>
                            <?php include(RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php'); ?>
                            <a href="<?= $tools_link ?>" class="pr-4 text-riseBodyText"><?= get_page_by_path('develop/knowledge-and-tools')->post_title ?></a>
                            <?php include(RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php'); ?>
                            <a href="<?= $downloadable_link ?>" class="pr-4 text-riseBodyText"><?= get_page_by_path('develop/knowledge-and-tools/knowledge-and-tools-library')->post_title ?></a>
                            <?php include(RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php'); ?>
                            <p class="text-riseBodyText"><?= $post->post_title; ?></p>
                        </div>
                    </div>
                
                    <div class="pt-14 flex justify-between items-center">
                        <a href="<?= $downloadable_link ?>" class="text-sm text-riseDark sm:text-left mb-7 flex gap-2 items-center w-max">
                            <?php include(RISE_THEME_SVG_COMPONENTS.'/arrow-back-colored-member-area.php'); ?>
                            <span><?= __('Go back', 'rise-wp-theme') ?></span>
                        </a>
                    </div>
                    <div class="single-tools-page grid grid-cols-1 md:grid-cols-2 gap-8 items-start pb-12 border-b border-gray360">
                        <svg class="w-full" width="573" height="432" viewBox="0 0 573 432" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 0.5H563C568.247 0.5 572.5 4.75329 572.5 10V422C572.5 427.247 568.247 431.5 563 431.5H10C4.75329 431.5 0.5 427.247 0.5 422V9.99999C0.5 4.75328 4.75329 0.5 10 0.5Z" fill="#E8E8E8" stroke="#D3D3D3"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M273.033 182.667H300.97C311.267 182.667 317 188.6 317 198.767V233.2C317 243.533 311.267 249.333 300.97 249.333H273.033C262.9 249.333 257 243.533 257 233.2V198.767C257 188.6 262.9 182.667 273.033 182.667ZM273.933 198.2V198.167H283.897C285.333 198.167 286.5 199.333 286.5 200.763C286.5 202.233 285.333 203.4 283.897 203.4H273.933C272.497 203.4 271.333 202.233 271.333 200.8C271.333 199.367 272.497 198.2 273.933 198.2ZM273.933 218.467H300.067C301.5 218.467 302.667 217.3 302.667 215.867C302.667 214.433 301.5 213.263 300.067 213.263H273.933C272.497 213.263 271.333 214.433 271.333 215.867C271.333 217.3 272.497 218.467 273.933 218.467ZM273.933 233.7H300.067C301.397 233.567 302.4 232.43 302.4 231.1C302.4 229.733 301.397 228.6 300.067 228.467H273.933C272.933 228.367 271.967 228.833 271.433 229.7C270.9 230.533 270.9 231.633 271.433 232.5C271.967 233.333 272.933 233.833 273.933 233.7Z" fill="#FEA517"/>
                        </svg>
                        <div class="mt-14">
                            <div class="flex justify-between">
                                <p class="px-4 py-1 mt-4 text-xs bg-gray350 text-riseBodyText rounded-full"><?= $category['title'] ?></p>
                                <p class="px-4 py-1 mt-4 text-xs text-riseBodyText"><?= $postDate ?></p>
                            </div>
                            <h2 class="text-riseDark text-2xl font-medium mt-8"><?= get_the_title() ?></h2>
                            <p class="text-riseBodyText pt-4 max-w-xs"><?= get_the_excerpt() ?></p>
                            <a download href="<?= $attachment['url'] ?>"
                               class="download-audit flex justify-center items-center rounded-full bg-red mt-10 text-white hover:border hover:border-red hover:text-red hover:bg-white">
                                <svg class="mr-4" width="20" height="19" viewBox="0 0 20 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.2061 12.9365L10.2061 0.895508" stroke="white" stroke-linecap="round"
                                          stroke-linejoin="round" />
                                    <path d="M13.1221 10.0088L10.2061 12.9368L7.29007 10.0088" stroke="white"
                                          stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                            d="M14.8391 5.62793H15.7721C17.8071 5.62793 19.4561 7.27693 19.4561 9.31293V14.1969C19.4561 16.2269 17.8111 17.8719 15.7811 17.8719L4.64106 17.8719C2.60606 17.8719 0.956055 16.2219 0.956055 14.1869V9.30193C0.956055 7.27293 2.60205 5.62793 4.63105 5.62793H5.57305"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span class="ml-0.5"><?= __('Download', 'rise-wp-theme') ?></span>
                            </a>
                        </div>
                    </div>
                    <div class="pt-12 flex grid-cols-1 md:grid-cols-2 items-center">
                        <div class="list-disc tools-resources-content w-1/2" id="rise-content-area">
                            <?php the_content() ?>
                        </div>
                        <?php
                        
                            if(!empty($author_name)) {
                        ?>
                        <div class="flex justify-center flex-col tools-author">
                            <p class="text-riseDark font-medium"><?= __('Uploaded By:', 'rise-wp-theme') ?></p>
                            <div class="pt-4 flex gap-4 items-center">
                                <?php
                                    if(!empty($author_image)) {
                                ?>
                                <img src="<?= $author_image ?>" class="w-12 h-12 rounded-full" alt="" />
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
                        <p class="pt-16 pb-4"><?= __('Similar templates', 'rise-wp-theme') ?></p>
                    </div>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-5 gap-4 w-full pt-10 pb-14">
                        <?php
                            foreach ($related_posts as $tool_resource) {
                        ?>
                        <tools-template title="<?= $tool_resource['title'] ?>" subtitle="<?= $tool_resource['category']['title'] ?>" link="<?= $tool_resource['link'] ?>"></tools-template>
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
