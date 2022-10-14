<?php
    
    /**
     * Archive Forum Content Part
     *
     * @package bbPress
     * @subpackage Theme
     */
    
    // Exit if accessed directly
    defined( 'ABSPATH' ) || exit;
    
    global $post;
    global  $paged;

?>
<div class="min-h-screen bg-gray100 md:pl-24">
    <?php
        $page_title = get_field('page_title', get_page_by_path('forum')->ID);
        $page_subtitle = get_field('page_subtitle', get_page_by_path('forum')->ID);
        
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
                    <p class=""><?= get_page_by_path('forum')->post_title ?></p>
                </div>
                <div class="flex items-center">
                    <?php
                        $how_to_use_rise_dashboard_title = get_field('how_to_the_rise_dashboard_title', get_page_by_path('forum'));
                        $how_to_use_rise_dashboard = get_field('how_to_the_rise_dashboard', get_page_by_path('forum'));
                        include(RISE_THEME_PARTIAL_VIEWS.'/how-to-use-rise.php');
                    
                    ?>
                </div>
            </div>
            <p class="font-light mt-9 mb-10"><?= $page_subtitle ?></p>
            <div class="flex flex-col lg:flex-row justify-between">
                <?php if ( bbp_has_forums() ) : ?>
                    <div class="forum-latest mb-8 lg:mb-0 lg:mr-8">
                        <p class="text-lg font-semibold mb-7"><?= __('Latest Topics', 'rise-wp-theme') ?></p>
                        <?php bbp_get_template_part( 'loop',     'forums' ); ?>
                    </div>
                <?php endif; ?>
                <div class="w-full">
                    <div class="flex justify-between items-center lg:-mt-4">
                        <?php
                            
                            $page_title = __('Posts', 'rise-wp-theme');
                            if(isset($_GET['q'])) {
                                $s = trim($_GET['q']);
                                $page_title = __('Posts result for "'.$s.'"', 'rise-wp-theme');
                                $page_title .= ' <a href="'.remove_query_arg('q').'" class="text-red text-xs query-string-text" title="'. __('Clear search', 'rise-wp-theme').'">'. __('Clear search', 'rise-wp-theme').'</a>';
                            }
                        ?>
                        <p class="text-lg font-semibold"><?= $page_title ?></p>
                        <?php include(__DIR__.'/partials/filter.php'); ?>
                    </div>
                    <div class="mt-4 mb-14">
                        <div class="bg-white flex flex-wrap items-center px-6 sm:px-11 border border-gray350 rounded-lg py-6">
                            <?php include(RISE_THEME_SVG_COMPONENTS.'/share-icon-black.php') ?>
                            <p class="text-lg font-light"><?= __('What would you like to share?', 'rise-wp-theme') ?></p>
                            <button id="create-topics" class="h-11 w-32 mt-4 sm:mt-0 bg-red border-2 border-red rounded-full text-white ml-auto hover:bg-white hover:text-red transition-all">
                                <?= __('Create a post', 'rise-wp-theme') ?></button>
                        </div>
                        <?php bbp_get_template_part( 'form',       'topic'     ); ?>
                        <?php do_action( 'bbp_template_before_forums_index' ); ?>
                        
                        <?php
                            
                            $topic_args = [];
                            if(isset($_GET['sort-by']) && $_GET['sort-by'] == 'popular') {
                                $topic_args = [
                                  'meta_key' => '_bbp_reply_count',
                                  'meta_type'     => 'NUMERIC',
                                  'orderby' => 'meta_value_num',
                                  'show_stickies' => false,
                                  'post_parent'   => 'any'
                                ];
                                
                            }
                            if(isset($_GET['q'])) {
                                $topic_args['s'] = $_GET['q'];
                            }
                            
                            if ( bbp_has_topics($topic_args) ) : ?>
                                
                                <?php bbp_get_template_part( 'loop',     'topics'    ); ?>
                                
                                <?php bbp_get_template_part( 'pagination', 'topics'    ); ?>
                            
                            <?php else : ?>
                                
                                <?php bbp_get_template_part( 'feedback', 'no-topics' ); ?>
                            
                            <?php endif; ?>
                        
                        <?php do_action( 'bbp_template_after_forums_index' ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
