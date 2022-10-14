<?php
$nonce = wp_create_nonce("register_eligibility_form_nonce");
?>
<!-- Eligibility Check  -->
<section class="form__wrapper" id="eligibility-form">
    <div class="form__container">
        <div class="nav-logo">
            <?php include __DIR__.'/logo-header.php' ?>
        </div>
        <div class="form__content">
            <h1 class="form__content__header">
                <?= __('Eligibility Check', 'rise-wp-theme') ?>
            </h1>
            <p class="form__content__sub-header">
                <?= sprintf('We need to ensure that you meet our funder’s eligibility requirements. Our funder is the European Regional Development Fund (ERDF) as mentioned in our %sabout%s page',
                   '<a href="'.get_permalink(get_page_by_path('about-us')).'" class="text-red" target="_blank">', '</a>'
                  );
                ?>
            </p>
        </div>
        <form method="post" action="" class="eligibility-form" data-nonce="<?= $nonce ?>">
            <custom-radio title="Is your business annual turnover less than €50m (approx. £43m) AND has an annual balance sheet of under €43m (approx. £37m)?" name="annual_turnover" error="<?= __('This is required', 'rise-wp-theme') ?>"></custom-radio>
            <custom-radio title="Do you have fewer then 250 employees?"  name="number_employees" error="<?= __('This is required', 'rise-wp-theme') ?>"></custom-radio>
            <custom-radio title="Select 'Yes' if you can confirm your business’ focus is NOT one of the following sectors (i.e. your business is NOT one of the following): <ul class='mt-4'><li>Fishery, Aquaculture & Agriculture</li><li>Banking and Insurance</li><li>Coal, Steel and Shipbuilding</li><li>Synthetic Fibres</li></ul>" name="primary_focused" error="<?= __('This is required', 'rise-wp-theme') ?>"></custom-radio>
            <custom-radio title="Select “Yes” if you can you confirm your business has received UNDER €200,000 (approx. £173,000) of <a href='https://www.gov.uk/government/publications/european-regional-development-fund-state-aid' target='_blank' class='text-red'>state aid</a> within the last three years? <br /><br /> Not sure what state aid is? Read <a href='https://www.coast2capital.org.uk/storage/downloads/short_summary_of_state_aid_basics-1560244854.pdf', target='_blank' class='text-red'>here</a> before answering." name="have_not_received" error="<?= __('This is required', 'rise-wp-theme') ?>"></custom-radio>
            <div class="block mt-10">
                <p class="input__title">
                    <?php
                        echo sprintf('If you have answered "no" to any of the above you will not be eligible to participate in RISE. However, if you have any questions about eligibility %scontact us%s we will be happy to discuss and confirm eligibility.', '<a href="/contact-us" target="_blank">', '</a>');
                    ?>
                </p>
            </div>
            <button class="form__submit" type="submit">
                <?= __('Check your eligibility', 'rise-wp-theme') ?>
            </button>
        </form>
    </div>
    <?php include __DIR__.'/sidebar-color.php' ?>
</section>

