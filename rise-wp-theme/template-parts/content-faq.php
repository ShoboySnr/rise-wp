<?php

use RiseWP\Classes\Faq;


$faqs = Faq::get_instance()->get_faq();

$faq_link_title = get_field('faq_link_title');
$faq_link_text = get_field('faq_link_text');
$faq_link_image = get_field('faq_link_image');

$faq_footer_link_title  = get_field('footer_pre_text');
$faq_footer_link_text = get_field('footer_pre_link');
$faq_footer_image = get_field('footer_prefix_image');


?>
<section class="custom-container">
    <div class="faq-hero" style=" background: linear-gradient(0deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url(<?= get_the_post_thumbnail_url();?>); background-size: cover;">
        <h2 class="item-center">
            <?=__('Frequently Asked Questions','rise-wp-theme')?>
        </h2>
    </div>
</section>



<?php
if(!empty($faqs)) {
?>
<section class="custom-container">
    <?php
        foreach($faqs as $faq) {
    ?>
    <div class="faq-questions__wrapper">
        <h3>
            <?= $faq['title'] ?>
        </h3>
        <?php
            if(!empty($faq['posts'])) {
        ?>
        <div class="faq-questions">
            <?php
                foreach ($faq['posts'] as $post) {
            ?>
            <div class="faq-question__container relative">
                <div class="relative w-full">
                    <div class="faq-questions__title">
                        <div>
                            <?= $post['title'];?>
                        </div>
                    </div>
                    <button class="absolute">
                        <svg class="plus" width="24" height="25" viewBox="0 0 24 25" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <rect x="11" width="3" height="25" fill="#DB3B0F" />
                            <rect x="24" y="11" width="3" height="24" transform="rotate(90 24 11)" fill="#DB3B0F" />
                        </svg>
                        <svg class="minus" width="24" height="3" viewBox="0 0 24 3" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <rect x="24" width="3" height="24" transform="rotate(90 24 0)" fill="#DB3B0F" />
                        </svg>

                    </button>
                </div>
                <div class="subtitle">
                    <div>
                        <?= $post['content'];?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
</section>
<?php } ?>
<section class="w-full dark-bg-text bg-white">
    <div class="flex justify-center items-center pt-16 pb-14 flex-col text-center mx-auto">
        <h4 class="text-4xl font-extrabold">
            <?=__('Can\'t find an answer to your question?','rise-wp-theme'); ?>
        </h4>
        <button
            class="rounded-one text-white mt-7 md:mt-7 flex items-center px-7 py-3 justify-center text-lg font-bold hover:opacity-70 transition-all top-2 right-2 bg-red">
            <a href="<?= get_permalink(get_page_by_path('contact-us'));?>"><?=__('Send us a message','rise-wp-theme')?></a>
        </button>
    </div>
</section>
<footer-prefix color="black" text-color="white" button-color="red" card-color="orange" link-title="<?php echo $faq_footer_link_text['title']?>" href="<?php echo $faq_footer_link_text['url'];?>" image="<?php echo $faq_footer_image['url'];?>" text-link="white" text="<?php echo $faq_footer_link_title;?>">
</footer-prefix>


