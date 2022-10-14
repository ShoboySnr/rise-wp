<?php
use RiseWP\Api\Register;

$organisations = Register::get_instance()->get_company();

$nonce = wp_create_nonce("full_membership_field_form_nonce");
$business_nonce = wp_create_nonce("check_business_registration_exists_nonce");

?>
<section class="form__wrapper" id="full-membership-form" style="display: none">
    <div class="form__container">
        <div class="stepper-logo-wrapper">
            <div class="nav-logo">
                <?php include __DIR__.'/logo-header.php' ?>
            </div>
            <ul class="stepper-tab">
                <li class="active list-none">
                    <a>
                        <?= __('1', 'rise-wp-theme') ?>
                    </a>
                </li>
                <li class="list-none">
                    <a>
                        <?= __('2', 'rise-wp-theme') ?>
                    </a>
                </li>
                <li class="list-none">
                    <a>
                        <?= __('3', 'rise-wp-theme') ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="form__content">
            <h1 class="form__content__header"><?= __('Congratulations!  You are eligible to be a member of RISE', 'rise-wp-theme') ?></h1>
            <p class="form__content__sub-header"><?= __('Register below to create a profile for the RISE member portal.  We’ll approve your details after a quick check and then email you with your login details.', 'rise-wp-theme') ?></p>
            <h2 class="form__content__header2"><?= __('Introduction', 'rise-wp-theme') ?></h2>
            <p class="form__content__sub-header"><?= __('Briefly introduce yourself and your business', 'rise-wp-theme') ?></p>
            <div class="text-red font-semibold success_message"></div>
        </div>
        <form autocomplete="off" action="" data-nonce="<?= $nonce ?>" class="full-membership-form">
            <custom-input title="<?= __('First name', 'rise-wp-theme') ?>"
                          placeholder="<?= __('First name', 'rise-wp-theme') ?>" name="first_name" type="text" error="<?= __('First name is required', 'rise-wp-theme') ?>"></custom-input>
            <custom-input title="<?= __('Last name', 'rise-wp-theme') ?>"
                          placeholder="<?= __('Last name', 'rise-wp-theme') ?>" name="last_name" type="text" error="<?= __('Last name is required', 'rise-wp-theme') ?>"></custom-input>
            <custom-input title="<?= __('Email address', 'rise-wp-theme') ?>" placeholder="<?= __('Enter your business email address', 'rise-wp-theme') ?>" name="company_email" type="email" error="<?= __('Enter valid Email address', 'rise-wp-theme') ?>"></custom-input>
            <div class="custom-input">
                <label class="input__title" for="search-dropdown"><?= __("See if anyone from your business has already registered.  Search for your business below.  If you don’t see an entry you’ll be able to create a new business profile in the next step.", 'rise-wp-theme') ?></label>
                <div class="relative">
                    <input autocomplete="off" name="business" type="text" placeholder="<?= __('Search by business name', 'rise-wp-theme') ?>"
                           id="search-dropdown" data-nonce="<?= $business_nonce; ?>">
                </div>
                <ul class="options">
                    <?php
                    foreach ($organisations as $organisation) {
                    ?>
                    <li>
                        <option value="<?= $organisation['id'] ?>"><?= $organisation['title'] ?></option>
                    </li>
                       <?php } ?>
                </ul>
            </div>

            <button class="next-button" type="submit">
                <?= __('Next', 'rise-wp-theme') ?>
            </button>
        </form>
    </div>
    <?php include __DIR__.'/sidebar-color.php' ?>
</section>
