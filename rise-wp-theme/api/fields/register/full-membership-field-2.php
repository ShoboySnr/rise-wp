<?php

$nonce = wp_create_nonce("organisation_group_form_nonce");

$business_primary_sector = '';
$primary_area_operation = 'Gatwick Diamond – incl. Crawley, Horsham and Mid Sussex / Coastal West Sussex / Rural West Sussex';
?>
<section class="form__wrapper" id="company-membership-form" style="display: none">
    <div class="form__container">
        <div class="stepper-logo-wrapper">
            <div class="nav-logo">
                <?php include __DIR__.'/logo-header.php' ?>
            </div>
            <ul class="stepper-tab">
                <li>
                    <a>
                        <?= __('1', 'rise-wp-theme') ?>
                    </a>
                </li>
                <li class="active">
                    <a>
                        <?= __('2','rise-wp-theme') ?>
                    </a>
                </li>
                <li>
                    <a>
                        <?= __('3', 'rise-wp-theme') ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="form__content">
            <h1 class="form__content__header"><?= __('Your business profile', 'rise-wp-theme') ?></h1>
            <p class="form__content__sub-header"><?= __('Tell us more about your company', 'rise-wp-theme') ?></p>
            <div class="success_message text-red font-semibold"></div>
        </div>
        <form method="post" action="" class="company-membership-form" data-nonce="<?= $nonce ?>">
            <custom-input type="text" title="<?= __('Business trading name', 'rise-wp-theme') ?>" placeholder="<?= __('Business trading name', 'rise-wp-theme') ?>" name="company_name" error="<?= __('Business Trading Name is required', 'rise-wp-theme') ?>"></custom-input>
            <custom-input type="text" title="<?= __('Steet 1', 'rise-wp-theme')  ?>" placeholder="<?= __('Street 1', 'rise-wp-theme') ?>" name="reg_business_address"></custom-input>
            <custom-input type="text" title="<?= __('Street 2', 'rise-wp-theme') ?>" placeholder="<?= __('Street 2', 'rise-wp-theme') ?>" name="reg_business_street"></custom-input>
            <custom-input type="text" title="<?= __('Town', 'rise-wp-theme') ?>" placeholder="<?= __('Town', 'rise-wp-theme') ?>" name="reg_business_city"></custom-input>
            <custom-input type="text" title="<?= __('County', 'rise-wp-theme') ?>" placeholder="<?= __('County', 'rise-wp-theme') ?>" name="reg_business_county"></custom-input>
            <custom-input type="text" title="<?= __('Reg business postcode', 'rise-wp-theme') ?>" placeholder="<?= __('Registered business postcode', 'rise-wp-theme') ?>" name="reg_business_postcode"></custom-input>
            <custom-input type="text" title="<?= __('Business website', 'rise-wp-theme') ?>" placeholder="<?= __('Enter your business website', 'rise-wp-theme') ?>" name="business_website">
            </custom-input>
            <custom-radio title="I acknowledge and agree to the RISE <a href='<?= $terms_condition_link ?>' target='_blank' class='text-red' title='<?= $terms_condition_title ?>'><?= $terms_condition_title ?><a> and <a href='<?= $privacy_policy_link ?>' class='text-red' target='_blank' title='<?= $privacy_policy_title ?>'><?= $privacy_policy_title ?></a> and wish to become a member of RISE." name="terms_agreement" error="<?= __('Acknowledge and agreement required', 'rise-wp-theme') ?>" only_yes="false"></custom-radio>
            <button class="form__submit" type="submit"><?= __('Submit form', 'rise-wp-theme') ?></button>
        </form>
    </div>
    <?php include __DIR__.'/sidebar-color.php' ?>
</section>
