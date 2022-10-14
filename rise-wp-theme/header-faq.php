<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Rise_OUP
 */

$arrow_white = RISE_THEME_ASSETS_ICONS_DIR.'/arrow-white';

//addbody classes to specify the faq
$body_class = ['dark:bg-black100', 'bg-gray100'];
?>
<!doctype html>
<html <?php language_attributes(); ?> >
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>
<body <?php body_class($body_class); ?> >
<?php wp_body_open(); ?>
<div id="page" class="site">
    <accessibility-nav>
    </accessibility-nav>
    <header>
        <nav class="nav relative flex justify-between max-w-screen-2xl mx-auto dark-bg-text items-center">
            <div class="nav-logo">
                <a href="<?= esc_url( home_url( '/' ) )?>" rel="home" title="<?= get_bloginfo('name', 'display') ?>">
                    <?php
                    $custom_logo_id = get_theme_mod('custom_logo');
                    $image = wp_get_attachment_image_src($custom_logo_id, 'full');
                    $title_logo = get_the_title($custom_logo_id);

                    ?>
                    <img src="<?= isset($image[0]) ? $image[0] : RISE_THEME_DEFAULT_LOGO;?>" alt="<?= get_bloginfo('name', 'display') ?>" title="<?= get_bloginfo('name', 'display') ?>">

            </div>
            <div>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_class' => 'text-sm md:text-nav flex items-center',
                    )
                );
                ?>
            </div>
        </nav>
        <ul class="hidden fixed mobile-nav w-full items-center bg-white dark:bg-black text-xl flex flex-col">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'mobile-menu',
                )
            );

            ?>
        </ul>
    </header>
    <button type="button" id="accessibility-btn" class="accessibility-btn">
        <img  src="<?= RISE_THEME_ASSETS_ICONS_DIR?>/accessibility.svg" alt="open accessibility">
    </button>

    <!-- preloader -->
    <div class="preloader" style="display: none">
        <img src="<?= RISE_THEME_PRELOADER_SVG ?>" alt="preloader" />
    </div>
    <!-- end preloader -->
