<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use RiseWP\Classes\DashboardBanner;
use RiseWP\Pages\Dashboard;


$dashboard = Dashboard::get_instance()->get_dashboard();

$panels = DashboardBanner::get_instance()->get_banners();

get_header();
?>

    <div class="bg-gray100 pb-10 md:pl-24">

        <div class="dashboard-wrap">
            <div class="flex flex-col md:flex-row md:items-center justify-between dashboard-header">
                <h3 class="text-2xl md:text-4xl font-bold mb-8 md:mb-0 md:pr-12"><?= __('Hi', 'rise-wp-theme') . $dashboard['user_info']['first_name'].'!'; ?><br>
                    <?= __('Welcome back', 'rise-wp-theme') ?></h3>
                <div class="max-w-2xl md:text-right">
                    <h3 class="text-2xl font-semibold"><?= $dashboard['user_info']['page_title'] ?></h3>
                    <p class="font-light"><?= $dashboard['user_info']['page_subtitle'] ?></p>
                </div>
            </div>
            <?php

            if(!empty($panels)) {
                ?>
            <div id="dashboard-banners" class="relative w-full">
                <?php
              $i = 1;
              foreach ( $panels as $panel) {
                ?>
                <div class="hiding-panel relative border border-gray360 flex flex-col sm:flex-row items-end bg-cover mt-11 md:mt-14 rounded-lg overflow-hidden"
                  style="background-image: url('<?= $panel['image']; ?>');">
                  <div class="h-80 w-full sm:hidden"></div>
                  <div class="p-7 sm:pt-16 sm:pb-14 sm:pl-14 sm:pr-16 bg-orange200 dashboard-header-bg">
                    <h2 class="mt-2 mb-0.5 text-2xl sm:text-3xl font-bold text-white"><?= $panel['title'] ?></h2>
                    <div class="font-normal text-base text-white mt-5"><?= wp_trim_words($panel['content'], 30, '...') ?></div>
                  <?php if(!empty($panel['panel_link'])): ?>
                    <a class="footer-prefix__button bg-black100 mt-8 mb-0.5"
                      <?php if(!empty($panel['panel_link']['url'])){ ?>
                       href="<?= $panel['panel_link']['url'] ?>"><?php }?><?= $panel['panel_link']['title'] ?>
                      <svg focusable="false"
                           width="20" height="10" viewBox="0 0 20 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.17 6L13.59 8.59L15 10L20 5L15 0L13.59 1.41L16.17 4H0V6H16.17Z" fill="white"/>
                      </svg>
                    </a>

                    <?php endif; ?>

                  </div>
                  <?php
                  if (!empty($panel['panel_sub_image']['url'])) {
                    ?>
                    <div class="px-10 py-4 bg-white rounded-l-full mb-5 hidden sm:block">
                      <img src="<?= $panel['panel_sub_image']['url'] ?>" alt="<?= $panel['panel_sub_image']['alt'] ?>">
                    </div>
                  <?php } ?>
                </div>
                <?php
              }
              ?>
            </div>
            <button class="hide-btn focus:outline-none ml-auto block"><?= __('Hide panel', 'rise-wp-theme') ?></button>
            <?php
            } ?>
            <div class="mt-10 flex flex-col lg:flex-row">
                <?php

                $announcements = $dashboard['announcement'];
                if(!empty($announcements['title'])) {
                    ?>
                    <div class="rounded-lg overflow-hidden bg-white dark:bg-black border border-gray360 sm:pb-12 mb-4 lg:mb-0 lg:mr-4">
                        <p class="relative flex justify-between items-center sm:block text-2xl p-6 sm:px-10 sm:pb-9 text-white sm:pt-12 font-semibold mb-11 bg-black500"><?= __('From the RISE team', 'rise-wp-theme') ?>
                            <?php include (RISE_THEME_SVG_COMPONENTS.'/announcement-white.php'); ?>
                        </p>
                        <p class="text-2xl px-5 sm:px-10 mb-6"><?= $announcements['title'] ?></p>
                        <?php

                        if(!empty($announcements['content'])) {
                            ?>
                            <div class="font-light px-5 sm:px-10 mb-3">
                                <?= $announcements['content'] ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php }

                $rise_team = $dashboard['rise_team'];
                if(!empty($rise_team['title'])) {
                    ?>
                    <div class="rounded bg-white dark:bg-black border border-gray360 p-8 px-4 sm:px-16 sm:pt-12 sm:pb-14 text-center flex flex-col items-center justify-center">
                        <div>
                            <?php include (RISE_THEME_ICONS_COMPONENTS.'/rise-team-group.php') ?>
                        </div>
                        <p class="text-lg font-semibold mt-9 mb-4"><?= $rise_team['title'] ?></p>
                        <?php
                        if(!empty($rise_team['description'])) {
                            ?>
                            <p class="font-light dashboard-team-text mb-10"><?= $rise_team['description'] ?> </p>
                        <?php }


                            ?>
                          <button type="button"
                                  class="open-contact-modal dashboard-team-link flex items-center justify-center text-white rounded-full mx-auto bg-red"
                          ><?=__('Contact Us', 'rise-wp-theme')?>
                            <?php include (RISE_THEME_SVG_COMPONENTS.'/kite-white.php'); ?>
                          </button>

                    </div>
                <?php } ?>
            </div>

            <?php
            $news = $dashboard['news'];
            if(!empty($news['data'])) {
                ?>
                <div class="flex flex-col sm:flex-row justify-between mt-10 sm:mt-16 mb-6 sm:mb-20 sm:items-center">
                    <h4 class="font-bold text-3xl sm:text-3.5xl black100 mb-4 sm:mb-0"><?= __('News and Updates', 'rise-wp-theme') ?></h4>
                  <div class="hidden sm:block">
                  <?php include (RISE_THEME_PARTIAL_VIEWS.'/news/_nav.php') ?>
                  </div>
                </div>
              <div id="news-items" class="flex flex-col sm:flex-row transform transition-all">
                    <?php
                    foreach($news['data'] as $new) {
                        ?>
                      <div class="news-item flex flex-col-reverse lg:flex-row w-7/12 ">
                        <div class="min-w-1/2 bg-white dark:bg-gray900 relative">
                          <div class="flex justify-between items-center mt-8 mr-10">
                                    <p class="bg-red text-white font-semibold text-sm px-4 py-1 -ml-2">
                                        <?= $new['category'] ?></p>
                                    <p class="text-medium text-black100 dark:text-gray100"><?= $new['date'] ?></p>
                                </div>
                                <div class="mx-5 sm:mx-10 my-4 sm:my-7 ">
                                    <a href="<?= $new['link'] ?>" title="<?= $new['title'] ?>">
                                        <p class="text-xl sm:text-2xl font-bold text-black100 dark:text-off-white mb-5"><?= $new['title'] ?></p>
                                    </a>
                                    <p class="mb-7 text-black300 dark:text-gray100"><?= $new['excerpt'] ?> </p>

                                    <a class="text-white  font-semibold rounded-one btn-fixed-news bg-black100 py-3 px-6 inline-flex gap-x-3 items-center justify-center border-2 border-black hover:bg-white hover:text-black transition-all"
                                       href="<?= $new['link'] ?>" title="<?= $new['title'] ?>"><?= __('Read more', 'rise-wp-theme') ?>
                                        <?php include (RISE_THEME_SVG_COMPONENTS.'/arrow-white-dashboard.php'); ?>
                                    </a>

                                </div>
                            </div>
                            <div class="min-w-1/2 h-60 lg:h-full">
                                <a href="<?= $new['link'] ?>" title="<?= $new['title'] ?>">
                                    <img class="w-full h-full object-cover" src="<?= $new['images'] ?>" alt="<?= $new['title'] ?>" title="<?= $new['title'] ?>" />
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <a href="<?= get_permalink(get_option('page_for_posts')) ?>" class="group flex sm:justify-end items-center text-nav text-black100 dark:text-white hover:text-red font-semibold sm:mt-11">
                <?= __('More News', 'rise-wp-theme') ?>
                <?php include (RISE_THEME_SVG_COMPONENTS.'/arrow-dashboard-coloured.php'); ?>
            </a>
            <?php

            $events = $dashboard['events'];
            if(!empty($events)) {
                ?>
                <div class="events-title flex flex-col sm:flex-row justify-between mt-9">
                    <h4 class="font-bold text-3xl sm:text-3.5xl mb-4 sm:mb-0 black100"><?= __('Upcoming RISE events', 'rise-wp-theme') ?></h4>
                    <a href="<?= get_permalink(get_page_by_path('events')); ?>"
                       class="hidden sm:flex sm:justify-end items-center text-nav text-red group hover:text-black font-semibold events-link"><?= __('More Events', 'rise-wp-theme') ?>
                        <?php include (RISE_THEME_SVG_COMPONENTS.'/arrow-dashboard-coloured.php'); ?>
                    </a>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-3 gap-y-16">
                    <?php
                    foreach ($events as $event) {
                        ?>
                        <event-card image="<?= $event['image'] ?>" month="<?= !empty($event['month']) ? $event['month'] : '' ?>" date="<?= !empty($event['day']) ? $event['day'] : '' ?>" color="<?= $event['members_only'] === 'Open' ? 'pink' : 'red' ?>" status="<?= $event['members_only'] ?>"
                                    tag="<?= isset($event['category']['title']) ? $event['category']['title'] : '' ?>" type="<?= $event['type'] ?>" title="<?= $event['title'] ?>" href="<?= $event['link'] ?>"></event-card>
                    <?php } ?>
                </div>
                <div class="sm:hidden mt-8">
                    <a href="<?= get_permalink(get_page_by_path('events')); ?>"
                       class="flex sm:justify-end items-center text-nav text-red group hover:text-black font-semibold events-link"><?= __('More Events', 'rise-wp-theme') ?>
                        <?php include (RISE_THEME_SVG_COMPONENTS.'/arrow-dashboard-coloured.php'); ?>
                    </a>
                </div>

            <?php } ?>
            <div  class="mt-14">
                <div class="flex flex-col sm:flex-row justify-between mb-14">
                    <p class="font-bold text-3xl sm:text-3.5xl mb-8 sm:mb-0"><?= __('Latest forum posts', 'rise-wp-theme') ?></p>
                    <a href="<?= get_permalink(get_page_by_path('forum')) ?>" class="group flex sm:justify-end items-center text-nav text-black100 hover:text-red font-semibold">
                      <?= __('View more', 'rise-wp-theme') ?>
                      <?php include (RISE_THEME_SVG_COMPONENTS.'/arrow-dashboard-coloured.php'); ?>
                    </a>
                </div>
                <?= do_shortcode("[rise_latest_forum user_id='' limit=2]"); ?>
            </div>

          <div class="mb-10">
            <p class="font-bold text-3xl sm:text-3.5xl my-10"><?=__('Meet your fellow members','rise-wp-theme')?></p>
            <div class="flex flex-col lg:flex-row">
                <div class="follow-up mb-4 lg:mb-0 lg:mr-4 bg-white dark:bg-black border border-gray360  rounded-lg py-7 px-4 sm:px-10 sm:py-11">
                    <p class="text-lg font-semibold mb-5 sm:mb-9"><?= __('Follow - up', 'rise-wp-theme') ?></p>
                    <?= do_shortcode("[rise_follow_up_widget]"); ?>
                </div>
              <div
                class="bg-white dark:bg-black border border-gray360 sm:overflow-scroll rounded-lg px-5 sm:px-8 pt-12 pb-11 w-full">
                <div class="flex flex-col sm:flex-row justify-between mb-6">
                <p class="text-lg font-semibold mb-10"><?= __('Suggested matches', 'rise-wp-theme'); ?></p>
                  <div class="hidden sm:block">
                    <button data-carousel="suggested-matches" aria-label="slide left" type="button"
                            class="mr-4 news-left opacity-30"><svg focusable="false" width="32" height="32" viewBox="0 0 56 56" fill="none"
                                                                   xmlns="http://www.w3.org/2000/svg">
                        <g opacity="1">
                          <circle cx="28" cy="28" r="27" stroke="#FA0D05" stroke-width="2" />
                          <path
                            d="M31.5348 19.5149L23.0498 27.9999L31.5348 36.4849L32.9498 35.0709L25.8778 27.9999L32.9498 20.9289L31.5348 19.5149Z"
                            fill="#FA0D05" />
                        </g>
                      </svg>
                    </button>
                    <button data-carousel="suggested-matches" aria-label="slide right" type="button" class="news-right"><svg
                        focusable="false" width="32" height="32" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="28" cy="28" r="27" stroke="#DB3B0F" stroke-width="2" />
                        <path
                          d="M24.4652 36.4851L32.9502 28.0001L24.4652 19.5151L23.0502 20.9291L30.1222 28.0001L23.0502 35.0711L24.4652 36.4851Z"
                          fill="#DB3B0F" />
                      </svg>
                    </button>
                  </div>
                </div>
                    <?= do_shortcode("[rise_suggested_matches_widget]"); ?>

                </div>


            </div>
        </div>
    </div>


<?php
get_footer()
?>
