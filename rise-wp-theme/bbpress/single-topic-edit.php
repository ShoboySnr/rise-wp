<?php
  
  /**
   * Edit handler for topics
   *
   * @package bbPress
   * @subpackage Theme
   */
  
  get_header('dashboard');
  
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
                    <a href="<?= get_permalink(get_page_by_path('member-directory')) ?>" title="<?= get_page_by_path('member-directory')->post_title ?>" class="mr-4"><?= __('Connect', 'rise-wp-theme') ?></a>
                  <?php include RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php' ?>
                    <a class="mr-4" href="<?= get_permalink(get_page_by_path('forum')) ?>" title="<?= get_page_by_path('forum')->post_title ?>"><?= __('Forum', 'rise-wp-theme') ?></a>
                  <?php include RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php' ?>
                    <p class=""><?= __('Editing: ', 'rise-wp-theme') ?><?php echo get_the_title(); ?></p>
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
                <div class="w-full">
                    <?php do_action( 'bbp_before_main_content' ); ?>
                    
                    <?php while ( have_posts() ) : the_post(); ?>
                      
                      <div id="bbp-edit-page" class="bbp-edit-page">
                        <div class="entry-content">
                          
                          <?php bbp_get_template_part( 'form', 'topic' ); ?>
                        
                        </div>
                      </div><!-- #bbp-edit-page -->
                    
                    <?php endwhile; ?>
                    
                    <?php do_action( 'bbp_after_main_content' ); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer('dashboard'); ?>
