<?php
$arrow_hover = RISE_THEME_ASSETS_ICONS_DIR.'/arrow-hover.svg';

if(!empty($home_events)) {
?>

<section class="container events">
    <div class="events-title flex flex-col sm:flex-row justify-between items-start lg:items-center">
        <h4 class="font-bold text-3xl sm:text-3.5xl mb-4 sm:mb-0 black100"><?= __('Upcoming RISE events', 'rise-wp-theme') ?></h4>
        <a href="<?= the_permalink(get_page_by_path(RISE_WP_EVENTS));?>"
           class="flex sm:justify-end items-center text-nav text-red group hover:text-black font-semibold events-link"><?= __('More
            Events', 'rise-wp-theme') ?>
            <?php include RISE_THEME_SVG_COMPONENTS.'/arrow-colored.php';?>
        </a>
    </div>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-3 gap-y-16">
            <?php foreach ($home_events as $home_single_events): ?>
                <?php include RISE_THEME_PARTIAL_VIEWS.'/homepage/_event.php';?>
            <?php endforeach; ?>
    </div>
</section>
<?php } ?>



