<?php
/* Template Name: Develop Templates */

if ( ! defined( 'ABSPATH' ) ) exit;

global $post;
get_header('dashboard');
//$nonce = wp_create_nonce("save_opportunities");

?>
<div class="dashboard-wrapper">
    <section class="dashboard-container remove-padding">
        <div class="connections">
              <?php
              $page_title = get_field('page_title');
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
                    <div class="flex mb-4 lg:mb-0 items-center font-light text-sm">
                      <p class="mr-4"><?= __('Develop', 'rise-wp-theme') ?></p>
                      <?php include(RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php'); ?>
                        <?php

                            $parent_id = $post->post_parent;
                            if(!empty($parent_id) && $parent_id !== get_page_by_path('develop')->ID) {
                                ?>
                                <a href="<?= get_permalink($parent_id) ?>" class="mr-4"><?= get_post($parent_id)->post_title ?></a>
                                <?php include(RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php'); ?>
                               <?php
                            }
                        ?>
                      <p class=""><?= $post->post_title ?></p>
                    </div>
                      <?php
                          if($post->post_parent != 0 && get_post($post->post_parent)->post_parent == 0) {
                      ?>
                      <div class="flex items-center">
                          <?php
                              $how_to_use_rise_dashboard_title = get_field('how_to_the_rise_dashboard_title');
                              $how_to_use_rise_dashboard = get_field('how_to_the_rise_dashboard');

                              if(!empty($sub_title)) {
                              ?>
                              <p class="text-riseBodyText"><?= $sub_title; ?></p>
                          <?php
                              } else if(!empty($how_to_use_rise_dashboard_title)) {
                                  include RISE_THEME_PARTIAL_VIEWS . '/how-to-use-rise.php';
                                }
                          ?>
                      </div>
                      <?php } ?>
                  </div>

                   <?php the_content() ?>
                </div>
            </div>
        </div>
    </section>
</div>

<?php


get_footer('dashboard');
