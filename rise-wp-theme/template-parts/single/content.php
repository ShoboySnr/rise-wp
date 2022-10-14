<?php
use RiseWP\Classes\News;

global $post;

$parent_id = get_id_by_slug('news');
$id = get_the_ID();

get_header();

$postData = get_post($id);
$date = rise_wp_format_date_news($postData->post_date);

$post_date = get_field('news_date', $id);
$inner_image = get_field('inner_post_image', $id);
$inner_caption = get_field('inner_post_caption', $id);
$post_thumbnail = (has_post_thumbnail($id)) ? get_the_post_thumbnail_url($id) : null;
$avatar    = get_field('author_image', $id);
$author   = get_field('author_name', $id);
$description    = get_field('author_description', $id);
$footer_prefix = get_field('footer_pre_text', $parent_id);
$footer_pre_link = get_field('footer_pre_link',$parent_id);

$footer_prefix_image = get_field('footer_prefix_image', $parent_id);

$related_posts = News::get_instance()->get_related_post($post, 2);

?>

<header>
    <div class="flex flex-col-reverse lg:flex-row items-center news-container mt-9">
        <div style="max-width: 450px">
            <p class="font-light"><?= $date; ?></p>
            <h3 class="font-bold text-3xl sm:text-3.5xl mb-11 mt-7"><?= get_the_title();?></h3>
            <p class="text-white bg-black px-4 py-1.5 w-max text-sm mb-4 lg:mb-11"><?= get_the_category()[0]->name?></p>
            <?php
                if(empty($author) || empty($avatar['url'])) {
            ?>
            <div class="flex items-center">
                <?php
                    if(!empty($avatar['url'])) {
                ?>
                <img class="w-16 h-16 object-cover rounded-full mr-4" src="<?= $avatar['url'] ?>" alt="<?= $avatar['alt']?>">
                <?php } ?>
                <div>
                    <p class="text-nav font-semibold"><?= $author;?></p>
                    <p class="text-gray250 font-light"><?=$description;?></p>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="news-header-img mb-11 lg:mb-0 lg:ml-11 min-w-1/2">
            <img class="h-full w-full object-cover"   src="<?= $post_thumbnail ?>" alt="<?= $post_thumbnail ?>">
        </div>
    </div>
</header>

<section class="news-container">
    <div class="border-t border-gray350 mt-7 sm:mt-20 pb-24">
        <div class="news-content mx-auto">
            <h3 class="text-xl sm:text-2xl font-semibold mt-11 mb-9 md:mx-24"><?= get_the_excerpt(); ?>
            </h3>


            <div class="font-light sm:text-nav text-gray900 mb-14 md:mx-24" id="content-area">
                <?= the_content();?>
            </div>
            <?php if(!empty($inner_image)): ?>
                <figure>
                    <img class="w-full" src="<?= $inner_image['url']?>" alt="<?= $inner_image['alt']?>">
                    <figcaption class="text-gray500 mt-4 text-center"><?= $inner_caption;?></figcaption>
                </figure>
            <?php endif; ?>
        </div>
    </div>
</section>

<!--Related News -->
<?php
if(!empty($related_posts)):
    ?>

    <section class="bg-gray150 dark:bg-black500">
        <div class="news-container py-20">
            <h4 class="text-3xl sm:text-3.5xl font-semibold text-center mb-14"><?=__('Related Articles','rise-wp-theme'); ?></h4>
            <div class="flex flex-col items-center lg:flex-row mb-7 pt-3">
                <?php foreach ($related_posts as $related_post): ?>
                    <div class="w-full flex flex-col-reverse md:flex-row mb-8 lg:mb-0 bg-white dark:bg-gray400 lg:w-1/2 lg:mr-8">
                        <div class="p-8 w-full">
                            <div class="flex justify-between mb-5">
                                <?php if(!empty($related_post['category'])) {?>
                                    <p class="bg-black text-sm font-semibold p-1 text-white -ml-10"><?= $related_post['category']['title']?></p>
                                <?php }?>
                                <?php if(!empty($related_post['date'])) { ?>
                                    <p class="text-sm text-gray500"><?= $related_post['date']?></p>
                                <?php } ?>
                            </div>
                            <a href="<?= $related_post['link']?>">
                                <p class="text-xl sm:text-2xl font-semibold"><?= mb_strimwidth($related_post['title'], 0, 50, '...')?></p>
                            </a>
                        </div>
                        <?php if(!empty($related_post['image'])) {?>
                            <img class="w-full md:w-60 h-60 md:h-auto object-cover"  src="<?= $related_post['image']; ?>" alt="<?= $related_post['image']?>">
                        <?php } ?>
                    </div>
                <?php endforeach;?>

            </div>
        </div>
    </section>

<?php endif;?>

<footer-prefix text-color="black" image="<?= $footer_prefix_image['url'];?>" color="pink" link-title="<?= $footer_pre_link['title'];?>" href="<?= $footer_pre_link['url'];?>" text="<?= $footer_prefix;?>" card-color="#9CCBDF"></footer-prefix>

<?php

get_footer();

?>
