<?php
$footer_prefix_image = get_field('footer_prefix_image');
$footer_pre_text = get_field('footer_pre_text');
$footer_pre_link = get_field('footer_pre_link');
$shortcode = get_field('contact_form_7_shortcode');
//$shortcode = get_field('shortcode');

?>

<section class="contact-us">
    <div class="grid lg:pl-24 lg:pr-40">
        <h2>
            <?= get_the_title();?>
        </h2>
        <p class="contact-us__text">
            <?php echo get_the_content();?> <a href="<?= the_permalink(get_page_by_path('FAQs'));?>" class="font-extrabold text-red"></a>
        </p>
    </div>

    <?= do_shortcode($shortcode); ?>



</section>



<footer-prefix color="pink" text="<?php echo  $footer_pre_text;?>" link-title="<?= $footer_pre_link['title'];?>" text-color="white" button-color="black"
               image="<?= $footer_prefix_image['url'];?>"   href="<?php echo $footer_pre_link['url']?>"    card-color="orange">
</footer-prefix>

