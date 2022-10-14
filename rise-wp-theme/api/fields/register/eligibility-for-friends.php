<?php

$nonce = wp_create_nonce("eligibility_for_friends_form_nonce");
?>
<section class="form__wrapper" id="eligibility-for-friends" style="display: none">
    <div class="form__container">
        <div class="nav-logo">
            <?php include __DIR__.'/logo-header.php' ?>
        </div>
        <div class="form__content">
            <h1 class="form__content__header"><?= __('You are eligible to be a friend of RISE', 'rise-wp-theme') ?></h1>
            <p class="form__content__sub-header"><?= __('You can attend our open events and training, and receive our
                quarterly newsletters. Register your details below.', 'rise-wp-theme') ?></p>
            <h2 class="form__content__header2">
                <?= __('Receive information on
                innovation and business
                development', 'rise-wp-theme') ?>
            </h2>
            <p class="form__content__sub-header">
                <?= __('Fill the form below so that we can keep you in contact', 'rise-wp-theme') ?>
            </p>
            <div id="success_message"></div>
        </div>
        <form method="post" class="eligibility-for-friends" action="" data-nonce="<?= $nonce ?>">
            <custom-input type="text" title="<?=  __('First name', 'rise-wp-theme') ?>"
                          placeholder="<?= __('First name') ?>" name="first_name" type="text" error="<?= __('First name is required','rise-wp-theme') ?>"></custom-input>
            <custom-input type="text" title="<?=  __('Last name', 'rise-wp-theme') ?>"
                          placeholder="<?= __('Last name') ?>" name="last_name" type="text" error="<?= __('Last name is required','rise-wp-theme') ?>"></custom-input>
            <custom-input type="text" title="<?= __('Business" placeholder="Enter the name of your company', 'rise-wp-theme') ?>" name="company_name" type="text"></custom-input>
            <custom-input type="email" title="<?= __('Email Address', 'rise-wp-theme') ?>" placeholder="<?= __('Enter your business email address', 'rise-wp-theme') ?>" name="business_email" type="email" error="<?= __('Business Email is required', 'rise-wp-theme') ?>"></custom-input>
            <custom-radio title="I acknowledge and agree to the RISE <a href='<?= $terms_condition_link ?>' target='_blank' class='text-red' title='<?= $terms_condition_title ?>'><?= $terms_condition_title ?><a> and <a href='<?= $privacy_policy_link ?>' class='text-red' target='_blank' title='<?= $privacy_policy_title ?>'><?= $privacy_policy_title ?></a> and wish to become a Friend of RISE." name="terms_agreement" error="<?= __('Acknowledge and agreement required', 'rise-wp-theme') ?>" only_yes="false"></custom-radio>
            
            <button class="form__submit" type="submit"><?= __('Submit form', 'rise-wp-theme') ?></button>

        </form>
    </div>
    <?php include __DIR__.'/sidebar-color.php' ?>
</section>
