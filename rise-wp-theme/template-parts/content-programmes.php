<?php
use RiseWP\Pages\Programmes;

$id = get_the_ID();

$programmes_contents = Programmes::get_instance()->get_programmes_contents($id);

?>

<section>
    <div class="flex flex-col lg:flex-row items-center news-container mt-9">
        <div class="video-container">
            <img class="video-poster h-full w-full object-cover transform brightness-50" src="<?= get_the_post_thumbnail_url() ?>" alt="News">
            <button type="button" id="play-btn" class="play-btn bg-red z-20">
                <img src="<?= RISE_THEME_ASSETS_DIR . '/icons/play.svg' ?>" alt="play-btn">
            </button>
            <div class="absolute top-0 left-0 video-overlay z-10"></div>

        </div>
        <div class="news-header-text">
            <div>
                <p class="text-2xl text-red font-semibold"><? echo esc_html($programmes_contents['top_section']['programmes_page_title']); ?></p>
            </div>

            <h3 class="font-bold text-4xl sm:text-3.5xl mb-11 mt-7 w-10/12">
                <a href="<?= "#" ?>"><?=  $programmes_contents['top_section']['programmes_page_subtitle']; ?></a>
            </h3>

        </div>
    </div>
</section>

<!-- post content Section-->
<section class="bg-gray150 dark:bg-gray900 mt-12">
    <div class="flex flex-col lg:flex-row items-center news-container py-16">
        <p class="whitespace-pre-line text-black500 dark:text-white text-lg">
            <?= $programmes_contents['top_section']['programmes_page_content'] ?>
        </p>
    </div>
</section>
<!-- post content Section-->

<!-- News Container Intro core-js-pure -->
<section class="news-container">    
    <h4 class="font-bold text-3xl pt-20">
        <?=  $programmes_contents['top_section']['inner_page_title']; ?>
    </h4>
    <p class="py-4"> <?=  $programmes_contents['top_section']['inner_page_subtitle']; ?></p>
</section>
<!-- News Container Intro  -->

<!-- containers -->
<?= Programmes::get_instance()->get_rise_programmes($id); ?>
<!-- containers-->


<section class="bg-black translate-y-40 row-news-container">
    <div class="vertical-card-box news-container justify-center transform -translate-y-40">
        <?= Programmes::get_instance()->print_cols($id); ?>
    </div>
</section>


<section id="trailer" class="video-modal-container hide-trailer video-modal-overlay">
    <div class="flex justify-center items-center h-full w-full">
        <div class="video-modal video-modal-lg">
            <div class="video-modal-content">
                <?= $programmes_contents['top_section']['video_url']; ?>      
            </div>
            <button type="button" id="stop-btn" class="video-modal-close-btn"> &times; </button>
        </div>
    </div>
</section>

<footer-prefix href="<?= $programmes_contents['footer_prefix_link']['url']; ?>" image="<?= $programmes_contents['footer_prefix_image']['url']; ?>" text="<?= $programmes_contents['footer_prefix_text']?>" color="yellow" link-title="<?= $programmes_contents['footer_prefix_link']['title'] ?>" card-color="#FFFFFF" text-color="black"></footer-prefix>
