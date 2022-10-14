<a href="<?= $home_news_single['link']?>" class="block group"> <div class="news-item flex flex-col-reverse lg:flex-row w-7/12">
        <div class="min-w-1/2 bg-white dark:bg-gray700">
            <div class="flex justify-between items-center mt-8 mr-10">
                <p style="background-color: #DB3B0F;"

                   class="text-white font-semibold text-sm px-4 py-1 -ml-2">
                    <?= $home_news_single['category']['title']?></p>
                <p class="text-medium text-black100 dark:text-gray100"><?= $home_news_single['date']; ?></p>

            </div>
            <div class="mx-5 sm:mx-10 my-4 sm:my-7">
                <p class="text-xl sm:text-2xl font-bold text-black100 dark:text-off-white mb-5">
                    <?= wp_trim_words($home_news_single['title'], '15', '...')?></p>
                <p class="mb-7 text-black300 dark:text-gray100"><?= wp_trim_words($home_news_single['summary'], 15, '...')?>  </p>
                <a class="news-btn text-white inline-block font-semibold nav-btn rounded-one text-white bg-black100 flex items-center justify-center border-2 border-black hover:bg-white hover:text-black transition-all"
                   href="<?= $home_news_single['link']?>"><?=__('Read more','rise-wp-theme'); ?>
                    <?php include RISE_THEME_SVG_COMPONENTS.'/arrow-white-big.php'; ?>
                </a>
            </div>
        </div>
        <div class="min-w-1/2 h-60 lg:h-full">
            <a href="<?= $home_news_single['link']?>"><img class="w-full h-full object-cover" src="<?= $home_news_single['image']?>" alt="<?= $home_news_single['image']?>"></a>
        </div>
    </div>
</a>
