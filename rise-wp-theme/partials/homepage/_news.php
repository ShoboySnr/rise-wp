<?php

$arrow_white = RISE_THEME_ASSETS_ICONS_DIR.'/arrow-white.svg';
$arrow_white_big = RISE_THEME_ASSETS_ICONS_DIR.'/arrow-white-big.svg';
$arrow_black = RISE_THEME_ASSETS_ICONS_DIR.'/arrow-black.svg';
$arrow_hover_red = RISE_THEME_ASSETS_ICONS_DIR.'/arrow-hover-red.svg';


if(!empty($home_news)) {
?>
  <section class="news bg-off-white dark:bg-gray400 ">
    <div class="container">
        <div class="news-heading flex flex-col sm:flex-row justify-between items-start lg:items-center">
        <h4 class="font-bold text-3xl sm:text-3.5xl black100 mb-4 sm:mb-0"><?= __('News and Updates', 'rise-wp-theme') ?></h4>
        <div class="hidden sm:block">
          <?php include (RISE_THEME_PARTIAL_VIEWS.'/news/_nav.php') ?>
        </div>
        </div>
        <div id="news-items" class="news-wrapper flex flex-col sm:flex-row transform transition-all">
        <?php
        
        foreach($home_news as $new) {
          ?>
          <div class="news-item flex flex-col-reverse lg:flex-row w-7/12">
            <div class="min-w-1/2 bg-white dark:bg-gray900">
              <div class="flex justify-between items-center mt-8 mr-10">
                <p class="bg-red text-white font-semibold text-sm px-4 py-1 -ml-2">
                  <?= $new['category']['title'] ?></p>
                <p class="text-medium text-black100 dark:text-gray100"><?= $new['date'] ?></p>
              </div>
              <div class="mx-5 sm:mx-10 my-4 sm:my-7">
                <a href="<?= $new['link'] ?>" title="<?= $new['title'] ?>">
                  <p class="text-xl sm:text-2xl font-bold text-black100 dark:text-off-white mb-5"><?= $new['title'] ?></p>
                </a>
                <p class="mb-7 text-black300 dark:text-gray100"><?= wp_trim_words($new['summary'],15, '...') ?> </p>
                <a class="btn-fixed-news text-white w-max font-semibold rounded-one bg-black100 py-3 px-6 inline-flex gap-x-3 items-center justify-center border-2 border-black hover:bg-white hover:text-black transition-all"
                   href="<?= $new['link'] ?>" title="<?= $new['title'] ?>"><?= __('Read more', 'rise-wp-theme') ?>
                  <?php include (RISE_THEME_SVG_COMPONENTS.'/arrow-white-dashboard.php'); ?>
                </a>
              </div>
            </div>
            <div class="min-w-1/2 h-60 lg:h-full">
              <a href="<?= $new['link'] ?>" title="<?= $new['title'] ?>">
                <img class="w-full h-full object-cover" src="<?= $new['image'] ?>" alt="<?= $new['title'] ?>" title="<?= $new['title'] ?>" />
              </a>
            </div>
          </div>
        <?php } ?>
        </div>
        <div class="container">
          <a href="<?= get_permalink(get_page_by_path('news'))?>"
             class="news-link flex sm:justify-end items-center text-nav text-black100 hover:text-red font-semibold">
            <?=__('More News','rise-wp-theme') ?> <svg width="20" height="8" viewBox="0 0 20 8" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M16.5 7.5L20 4L16.5 0.5L15.793 1.207L18.086 3.5H0V4.5H18.086L15.793 6.793L16.5 7.5Z"
                    fill="#0D0D0D" />
            </svg>
          </a>
        </div>
    </div>
</section>

<?php } ?>








