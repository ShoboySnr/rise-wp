<section class="z-10 relative bg-off-white">
    <div class="bg-gray100 dark-bg-text bg-opacity-30">
        <div class="2xl:mx-auto flex flex-col-reverse lg:flex-row items-center pt-6 lg:pt-16">
            <div class="min-w-full lg:min-w-1/2 lg:mr-10">
                <?php
                    if(!empty($home_contents['first_section_image']['url'])) {
                 ?>
                    <img class="w-full" src="<?= $home_contents['first_section_image']['url']; ?>" alt="<?= $home_contents['first_section_image']['alt']; ?>" title="<?= $home_contents['first_section_image']['title']; ?>">
                <?php } ?>
            </div>
            <div class="partners px-6 sm:px-12 lg:px-0 mb-12 mt-12 lg:mt-0">
                <h3 class="font-extrabold text-3xl sm:text-3.5xl partners-primary dark:text-white text-black200">
                    <?= $home_contents['first_section_title']; ?></h3>
                <p class="partners-secondary text-base"> <?= $home_contents['first_section_description'];?></p>
                <a class="partners-link font-extrabold group border-2 border-black dark:border-white flex justify-center items-center rounded-one dark-bg-text dark:hover:bg-white dark:hover:text-black hover:bg-black hover:text-white transition-all"
                   href="<?= $home_contents['first_section_link']['url']; ?>" title="<?= $home_contents['first_section_link']['title']; ?>"><?= $home_contents['first_section_link']['title']; ?>
                    <?php include RISE_THEME_SVG_COMPONENTS.'/arrow-black-hover.php'; ?>
                </a>
            </div>
        </div>
    </div>

    <div class="px-6 mb-12 sm:px-12 lg:px-0 mx-auto innovate flex flex-col-reverse md:flex-col lg:flex-row justify-end items-center bg-white">
        <div class="innovate-text text-black200 dark:text-white lg:my-0 mt-8 lg:mt-0 mb-12 lg:mb-0">
            <h3 class="font-extrabold text-3xl sm:text-3.5xl innovate-primary"><?= $home_contents['innovate_section_title'];?></h3>
            <div class="text-base" style="'font-size: 17px"><?= $home_contents['innovate_section_description'];?></div>
        </div>
        <div class="innovate-img min-w-full lg:min-w-7/12 mt-12 lg:mt-0">
            <?php
            if(!empty($home_contents['innovate_section_image']['url'])) {
                ?>
                <img class="w-full" src="<?= $home_contents['innovate_section_image']['url']; ?>" title="<?= $home_contents['innovate_section_image']['title']; ?>" >
            <?php } ?>
        </div>
    </div>

    <div class="container mx-auto">
        <div class="px-6 sm:px-12 lg:px-0 flex flex-col items-center lg:flex-row register">
            <div class="register-vid mb-12 lg:mb-0 mt-12 lg:mt-0">
                <?php if(!empty($home_contents['get_started_image']['url'])) { ?>
                <img src="<?= $home_contents['get_started_image']['url'] ?>" alt="<?= $home_contents['get_started_image']['title'] ?>" title="<?= $home_contents['get_started_image']['title'] ?>">
                <?php } ?>
            </div>
            <div class="text-black200 dark-bg-text">
                <h3 class="font-extrabold text-3xl sm:text-3.5xl mb-5" style="line-height: 28px"><?= $home_contents['get_started_title'];?></h3>
                <div class="text-base" style="font-size: 17px;"> <?= $home_contents['get_started_description'];?></div>
                <a class="partners-link font-extrabold group border-2 border-black dark:border-white flex justify-center items-center rounded-one
                 dark-bg-text dark:hover:bg-white dark:hover:text-black hover:bg-black hover:text-white transition-all"
                   href="<?= $home_contents['get_started_link']['url'] ?>" title="<?= $home_contents['get_started_link']['title'] ?>"><?= $home_contents['get_started_link']['title']?>
                <?php include RISE_THEME_SVG_COMPONENTS.'/arrow-black-hover.php'; ?>
                </a>
            </div>
        </div>
    </div>

    <div style="background-image: url(<?= $home_contents['success_image']['url']; ?>);" class="bg-cover bg-no-repeat bg-center">
       <div class="success container flex justify-center lg:justify-start">
           <div class="success-story bg-black400 text-white py-16 px-10 sm:px-20 mt-auto">
               <p class="font-extrabold text-3xl sm:text-3.5xl"><?= $home_contents['success_title'];?></p>
               <p class="text-base" style="font-size: 17px"><?= $home_contents['success_quotes'];?></p>
                <p class="sm:text-nav mt-12 mb-11"><?= $home_contents['success_subtitle']; ?></p>
                <a class="success-btn inline-block font-bold text-nav rounded-one text-white flex items-center
                justify-center text-white border-2 border-black hover:bg-white hover:text-black transition-all"
                    href="<?= $home_contents['success_link']['url']; ?>" title="<?= $home_contents['success_link']['title']; ?>"> <?= $home_contents['success_link']['title']; ?>
                <?php include RISE_THEME_SVG_COMPONENTS.'/arrow-white.php'; ?></a>
            </div>
        </div>
    </div>






</section>
