<a href="<?= esc_url( home_url( '/' ) )?>" rel="home" title="<?= get_bloginfo('name', 'display') ?>">
    <?php
    $custom_logo_id = get_theme_mod('custom_logo');
    $image = wp_get_attachment_image_src($custom_logo_id, 'full');
    $title_logo = get_the_title($custom_logo_id);

    ?>
    <img src="<?= isset($image[0]) ? $image[0] : RISE_THEME_DEFAULT_LOGO;?>" alt="<?= get_bloginfo('name', 'display') ?>" title="<?= get_bloginfo('name', 'display') ?>">
</a>

