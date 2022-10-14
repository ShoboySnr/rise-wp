<section class="flex justify-between" id="eligibility-for-friends-success" style="display: none;">
    <div class="max-w-5xl 2xl:ml-auto mr-6 sm:mr-16 2xl:mr-64">
        <div class="w-full">
            <div class="not-elig-logo-parent">
                <div class="not-elig-logo">
                    <?php include __DIR__.'/logo-header.php'; ?>
                </div>
            </div>
            <div class="pl-6 sm:pl-12 lg:pl-40 pb-20">
                <div class="not-elig-content mt-8 mx-auto pr-0 sm:pr-8 flex items-center flex-col">
                    <img src="<?= get_template_directory_uri().'/assets/images/not-elig.png' ?>" alt="">
                    <h4 class="font-bold text-2xl mt-20 mb-11"><?= __('Thank you! Your registration was successful', 'rise-wp-theme') ?></h4>
                    <p class="text-lg font-medium text-center"><?= __('Your registration was successful. You have subscribed
                        for our e-newsletter and can unsubscribe at any time. You can access our news,
                        open events and training sessions at any time via the RISE homepage.', 'rise-wp-theme') ?></p>
                    <button onclick="window.location.href='<?= esc_url( home_url( '/' ) ) ?>'"
                        class="not-elig-btn group border-2 hover:bg-white hover:text-red flex items-center justify-center mt-16 bg-red text-lg text-white font-bold">Return
                        to homepage
                        <svg class="ml-8" width="20" height="10" viewBox="0 0 20 10" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path class="fill-current group-hover:text-red"
                                  d="M16.17 6L13.59 8.59L15 10L20 5L15 0L13.59 1.41L16.17 4H0V6H16.17Z"
                                  fill="white" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="not-elig-bg relative">
        <!-- <img class="h-full min-h-screen w-full object-cover" src="./assets/images/not-elig-bg.png" alt=""> -->
        <div class="w-full h-full min-h-screen absolute top-0 bg-gray400">
        </div>
    </div>
</section>
