<?php
use RiseWP\Classes\News;

global $paged;

$post_id = get_id_by_slug('news');

$featured_news = News::get_instance()->get_sticky_post();


$news_terms = News::get_instance()->get_news_filter();

$sub_category = isset($_GET['subcategory-filter']) ? $_GET['subcategory-filter'] : '';

$get_news = News::get_instance()->get_news($sub_category, $paged);



$footer_prefix = get_field('footer_pre_text', $post_id);
$footer_pre_link = get_field('footer_pre_link', $post_id);
$footer_prefix_image = get_field('footer_prefix_image', $post_id);

//data nonce
$nonce = wp_create_nonce("filter_rise_wp_news_by_category_nonce");
?>
<header>
    <div class="flex flex-col lg:flex-row items-center news-container mt-9">
        <div class="news-header-img mb-11 lg:mb-0 lg:mr-11 min-w-1/2">
            <a href="<?= $featured_news[0]['link']?>"><img class="h-full w-full object-cover" src="<?= $featured_news[0]['image']; ?>" alt="alt="<?=__('News','rise-wp-theme'); ?>"></a>
        </div>
        <div class="news-header-text">
            <div class="flex justify-between items-center mb-11">
                <p class="text-sm font-light text-gray250"><?= $featured_news[0]['date'];?></p>
                <p class="text-white bg-black px-4 py-1.5 w-max text-sm"><?= $featured_news[0]['category']['title']?></p>
            </div>

            <h3 class="font-bold text-3xl sm:text-3.5xl mb-10">
                <a href="<?= $featured_news[0]['link']?>"><?= wp_trim_words($featured_news[0]['title'], 20, '...')?></a>
            </h3>
            <!-- I replaced the class name w-min from the html to w-max here -->
            <p class="text-black font-semibold bg-gray200 px-4 py-1.5 w-max text-sm mb-0 lg:mb-11"><a href="<?= $featured_news[0]['link']?>"><?=__('Read More', 'rise-wp-theme')?></a></p>

            <div class="flex items-center">
                <?php
                    if(!empty($featured_news[0]['avatar']['url'])) {
                ?>
                <img class="w-16 h-16 rounded-full mr-4" src="<?= $featured_news[0]['avatar']['url'] ?>" alt="<?= $featured_news[0]['avatar']['alt'] ?>">
                <?php } ?>
                <div>
                    <p class="text-nav font-semibold"><?= $featured_news[0]['author']?></p>
                    <p class="text-gray250 font-light"><?= $featured_news[0]['description']?></p>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="news-container" style="margin-top: -2rem">
    <div class="border-t border-gray350 mt-20">
        <div class="flex overflow-scroll sm:overflow-visible" id="filters" data-nonce="<?= $nonce ?>">
            <button class="news-tab-btn border-t-4 <?= empty($sub_category) ? 'border-red' : 'border-transparent'; ?> whitespace-nowrap px-3 sm:px-7 pt-2 md:pt-4 pb-2 md:pb-0 -mt-0.5 text-black sm:text-nav font-semibold" value="" name="news_filter"><?= __('All', 'rise-wp-theme') ?></button>
            <?php foreach ($news_terms as $cat): ?>
                <button name="news_filter" class="news-tab-btn whitespace-nowrap border-t-4  <?= !empty($sub_category) && $sub_category == $cat['slug']  ? 'border-red' : 'border-transparent'; ?> px-3 sm:px-7 pt-2 md:pt-4 pb-2 md:pb-0 -mt-0.5 sm:text-nav font-semibold text-gray250" value="<?=$cat['slug']?>">
                    <?= $cat['title']; ?></button>
            <?php endforeach;?>

            <!-- set the paged value as input -->
            <input type="hidden" value="<?= $paged; ?>" id="paged-id" />
            <input type="hidden" value="<?= $post_id; ?>" id="page_url" />
            <input type="hidden" value="<?= $sub_category; ?>" id="subcategory-filter" />
        </div>
        <!-- preloader -->
        <div class="mt-16 w-full inner-preloader" style="display: none; height: 500px">
            <img src="<?= RISE_THEME_PRELOADER_SVG ?>" alt="preloader" />

        <!-- end preloader --></div>
        <div class="news-card-wrapper grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-16 gap-x-8">
            <?php if(!empty($get_news['data'])):?>
                <?php foreach ($get_news['data'] as $single_news) { ?>
                    <news-card href="<?= $single_news['link']?>" image="<?= $single_news['images'];?>" category="<?= (!empty($single_news['category'])) ? $single_news['category']: ''?>" date="<?= $single_news['date'] ?>"
                               title="<?= wp_trim_words($single_news['title'], 20, '...')?>"
                               summary="<?= $single_news['excerpt']; ?>">
                    </news-card>
                <?php }
                ?>
        </div>
        <?php
        rise_wp_custom_pagination($get_news['wp_query']);
        ?>
        <?php
        else:
            ?>

            <div>
                <p class="mb-12 text-2xl font-bold"><?= __('No news here yet', 'rise-wp-theme') ?></p>
            </div>
        <?php endif;?>



    </div>
</section>


<footer-prefix  image="<?= $footer_prefix_image['url'];?>" color="red" link-title="<?= $footer_pre_link['title'];?>" href="<?= $footer_pre_link['url'];?>" text="<?= $footer_prefix;?>" text-color="black" card-color="#FFFFFF"></footer-prefix>

