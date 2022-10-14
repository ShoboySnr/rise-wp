<?php
  use RiseWP\Api\UsersTaxonomy;

  $nonce = wp_create_nonce("register_eligibility_checking_location_form_nonce");

  $west_sussex_taxonomies = UsersTaxonomy::get_instance()->get_custom_business_location_taxonomy(true);
  $west_sussex_taxonomies = $west_sussex_taxonomies['west_sussex'];

  $other_location_taxonomies = UsersTaxonomy::get_instance()->get_custom_business_location_taxonomy();
  $other_location_taxonomies = $other_location_taxonomies['others'];


?>
<section class="form__wrapper" id="eligibility-checking-location" style="display: none;">
  <div class="form__container">
    <div class="nav-logo">
      <?php include __DIR__.'/logo-header.php' ?>
    </div>
    <div class="form__content">
      <h1 class="form__content__header">
        <?= __('Checking the location of your business', 'rise-wp-theme') ?>
      </h1>
        <p class="form__content__sub-header"><?= __('RISE project funding prioritises certain geographical areas, so we need to check where your business is based.
        Your location will determine whether you can be a ‘friend’ of RISE or a member of RISE.', 'rise-wp-theme') ?></p>
    </div>
    <form method="post" action="" class="eligibility-checking-location-form" data-nonce="<?= $nonce ?>">
        <div class="custom-select">
            <label class="input__title"><?= __('Where is your business primarily located:', 'rise-wp-theme') ?></label>
            <div class=" relative">
                <select class="" name="primary_area_location_taxonomy">
                    <option value="" ><?= __('Where is your business primarily located:', 'rise-wp-theme') ?></option>
                  <?php
                    foreach($other_location_taxonomies as $taxonomy) {
                      ?>
                        <option value="<?= $taxonomy['id'] ?>" data-name="<?= $taxonomy['name'] ?>"><?= $taxonomy['name'] ?></option>
                      <?php
                    }
                  ?>
                    <option value="west_sussex" data-name="<?= 'west_sussex' ?>"><?= __('West Sussex', 'rise-wp-theme') ?></option>
                    <option value="others" data-name="<?= 'others' ?>"><?= __('Any other geographical area other than the above', 'rise-wp-theme') ?></option>
                </select>
            </div>
            <p class="error text-red" style="display: none"><?= __('Please select a valid business location.', 'rise-wp-theme') ?></p>
        </div>
          <?php

          if(!empty($west_sussex_taxonomies)) {
          ?>
             <div class="custom-select hidden" id="show-if-west-sussex">
                    <label class="input__title"><?= __('Please tell us where in West Sussex your business is based:', 'rise-wp-theme') ?></label>
                    <div class=" relative">
                        <select class="" name="member_location_taxonomy">
                            <option value="" ><?= __('Please tell us where in West Sussex your business is based:', 'rise-wp-theme') ?></option>
                          <?php
                            foreach($west_sussex_taxonomies as $taxonomy) {
                              ?>
                                <option value="<?= $taxonomy['id'] ?>" data-name="<?= $taxonomy['name'] ?>"><?= $taxonomy['name'] ?></option>
                              <?php
                            }
                          ?>
                        </select>
                    </div>
                    <p class="error text-red" style="display: none"><?= __('Please select where your business is in West Sussex.', 'rise-wp-theme') ?></p>
                </div>
          <?php } ?>
      <button class="form__submit" type="submit">
        <?= __('Progress to next step', 'rise-wp-theme') ?>
      </button>
    </form>
  </div>
  <?php include __DIR__.'/sidebar-color.php' ?>
</section>
