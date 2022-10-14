
<section id="first-view" class="dark:bg-black dark:text-white">
    <section class="hero dark-bg-text">
        <div class="hero-text-contents">
            <div class="hero-header">
                <p id="typewriter1">
                    <?= $home_contents['banner_title']; ?>
                </p>
                <p id="typewriter2">
                    <?= $home_contents['banner_title_two']; ?>

                </p>
            </div>
            <div>
                <p class="hero-text">
                    <?= $home_contents['banner_subtitle_one'];?>

                </p>
                <p class="hero-text">
                    <?= $home_contents['banner_subtitle_two'];?>

                </p>
            </div>

            <?php

            if (!empty($home_contents['banner_button'])) {
                ?>

                <a class="forward-link text-lg font-bold group border-2 border-black dark:border-white text-white bg-black dark:border-black flex justify-center items-center rounded-one dark:hover:bg-white dark:hover:text-black hover:bg-white hover:text-black transition-all"
                   href="<?= $home_contents['banner_button']['url']; ?>" title="<?=  $home_contents['banner_button']['title'] ?>"><?=  $home_contents['banner_button']['title'] ?>
                    <?php include (RISE_THEME_SVG_COMPONENTS.'/arrow-white-thin.php'); ?>
                </a>

            <?php }
            $partners_logos = acf_photo_gallery('logos_partners', $page_id);
            if(!empty($partners_logos)) {
                ?>
                <div class="sponsors">
                    <?php
                        foreach ($partners_logos as $partner) {
                    ?>
                        <img src="<?= $partner['full_image_url']; ?>" alt="<?= $partner['caption']; ?>" title="<?= $partner['title']; ?>">
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <div>

        </div>
        <?php if (!empty($home_contents['banner_image_lines']['url'])) { ?>
            <div class="circle-img">
                <img id="circle-img"  src="<?= $home_contents['banner_image_lines']['url']; ?>" title="<?= $home_contents['banner_image_lines']['title']; ?>"  />
            </div>
        <?php } ?>
    </section>
</section>
