<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Rise_OUP
 */

if(load_custom_header_footer()) {
    get_footer('dashboard');
    return;
}

$post = get_the_ID();
$partners = rise_get_partners_logo($post);

?>

</section>
</div>
<footer class="dark:bg-black bg-white relative">
    <div class="container dark:bg-black  bg-white footer relative">
        <div class="flex flex-wrap z-10 relative lg:flex-nowrap justify-between">
            <div class="footer-col-1">
                <div class="footer-logo">
                    <?php
                    $footer_logo = get_theme_mod('footer-logo');
                    ?>
                    <?php if($footer_logo): ?>
                        <img class="dark:filter dark:invert"  src="<?php echo $footer_logo; ?>" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>" >
                    <?php endif;?>
                </div>

                <?php dynamic_sidebar('footer-area-1'); ?>
            </div>


            <div class="mt-14 sm:mt-8">
                <p href="" class="block font-semibold text-xl mb-7"><?=__('Pages', 'rise-wp-theme')?></p>

                <?php
                dynamic_sidebar('footer-area-2');
                ?>

            </div>
            <div class="mt-8">
                <a href="" class="block font-bold text-xl mb-7 invisible">l</a>
                <?php
                dynamic_sidebar('footer-area-3');
                ?>
            </div>
            <div class="mt-8 footer-address-box">
                <p class="font-bold text-xl mb-7"><?=__('Get in touch','rise-wp-theme'); ?></p>
                <?php if(get_theme_mod('rise-wp-contact-email')): ?>
                    <p class="mb-7 text-gray400 dark:text-white"><?= get_theme_mod('rise-wp-contact-email');?></p>
                <?php endif;?>
                <?php if(get_theme_mod('rise-wp-contact-address')) :?>
                    <p class="mb-7 text-gray400 dark:text-white footer-address"><?= get_theme_mod('rise-wp-contact-address');?></p>
                <?php endif;?>
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between mt-12 text-gray500 relative z-1">
            <p class="mb-6 md:mb-0"> <?php
                esc_html_e( 'Copyright &copy; University of Brighton 2022. All rights reserved.', 'rise-wp-theme' );
                ?></p>
            <p><?php echo sprintf("Developed by %s Studio 14 %s", "<a class='text-black100 dark:text-red dark:text-white' href='http://studio14online.co.uk' target='_blank' title='Studio14 Online'>", "</a>"); ?></p>

        </div>
        <svg class="absolute bottom-0 right-0" style="z-index: -1" width="628" height="298" viewBox="0 0 628 298" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path d="M228.383 323.383C283.601 246.844 453.324 213.972 508.223 384.436" stroke="black"
                  stroke-opacity="0.05" stroke-width="73" stroke-linecap="round" stroke-linejoin="round" />
            <path
                d="M62.4862 391.663C62.1229 408.651 75.6006 422.713 92.5897 423.071C109.578 423.429 123.646 409.947 124.009 392.959L62.4862 391.663ZM545.471 282.188C554.697 296.459 573.745 300.541 588.017 291.307C602.285 282.077 606.373 263.028 597.144 248.76L545.471 282.188ZM279.051 163.316L288.172 192.697L279.051 163.316ZM124.009 392.959C124.758 357.963 152.276 234.92 288.172 192.697L269.931 133.935C98.7455 187.123 63.5391 342.451 62.4862 391.663L124.009 392.959ZM288.172 192.697C423.016 150.801 517.408 238.798 545.471 282.188L597.144 248.76C561.472 193.612 442.167 80.421 269.931 133.935L288.172 192.697Z"
                fill="black" fill-opacity="0.05" />
        </svg>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
