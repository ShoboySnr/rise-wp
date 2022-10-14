<section class="form__wrapper" id="form-membership-success" style="display: none">
    <div class="form__container">
        <div class="stepper-logo-wrapper">
            <div class="nav-logo">
                <?php include __DIR__.'/logo-header.php' ?>
            </div>
            <ul class="stepper-tab">
                <li>
                    <a>
                        1
                    </a>
                </li>
                <li>
                    <a>
                        2
                    </a>
                </li>
                <li class="active">
                    <a>
                        3
                    </a>
                </li>
            </ul>
        </div>
        <div class="pb-20">
            <div class="not-elig-content mt-8 mx-auto pr-0 sm:pr-8 flex items-center flex-col">
                <img src="<?= get_template_directory_uri().'/assets/images/not-elig.png' ?>" alt="">
                <h4 class="font-bold text-2xl mt-20 mb-11 text-center"><?= __('Great! ', 'rise-wp-theme') ?>
                    <?= __('Your RISE member portal registration is complete.', 'rise-wp-theme') ?> </h4>
                <p class="text-lg font-medium text-center">
                    <?= __('We’ll send you an email shortly with your login details.
                    Our funder requires we gather some further information from you to be able to confirm that you meet all
                    their criteria to access the fully-funded programme of innovation support.  A member of the RISE team will be
                    in contact in the next week to introduce themselves and help you with these
                    final bits of information we have to supply.', 'rise-wp-theme') ?>
                </p>
                <br />
                <p class="text-lg font-medium text-center">
                    <?= __('But we’ll soon get you started on your innovation journey with access to our RISE member portal.  Look out for our email with these details send in the next few days.
                     If you have any further questions do contact us so we can help – ', 'rise-wp-theme') ?><a href="mailto: RISE@brighton.ac.uk;" title="Send us an email"><?= __('RISE@brighton.ac.uk') ?></a>
                </p>
                <button onclick="window.location.href='<?= esc_url( home_url( '/' ) ) ?>';"
                        class="not-elig-btn group border-2 hover:bg-white hover:text-red flex items-center justify-center mt-16 bg-red text-lg text-white font-bold">Return
                    to homepage
                    <svg class="ml-8" width="20" height="10" viewBox="0 0 20 10" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path class="fill-current group-hover:text-red"
                              d="M16.17 6L13.59 8.59L15 10L20 5L15 0L13.59 1.41L16.17 4H0V6H16.17Z" fill="white" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <?php include __DIR__.'/sidebar-color.php' ?>
</section>
