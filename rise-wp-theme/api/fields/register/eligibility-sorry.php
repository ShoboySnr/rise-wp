<?php
  
  $nonce = wp_create_nonce("eligibility_for_friends_form_nonce");
?>
<section class="form__wrapper" id="eligibility-sorry" style="display: none">
  <div class="form__container">
    <div class="nav-logo">
      <?php include __DIR__.'/logo-header.php' ?>
    </div>
    <div class="form__content">
      <h1 class="form__content__header"><?= __('Sorry!', 'rise-wp-theme') ?></h1>
        
        <div class="section_container mt-12">
            <div class="form__content__sub-header font-bold">
              <?= get_field('eligibility_sorry_text'); ?>
            </div>
            
            <form>
                <a href="<?= get_home_url(); ?>" class="form__submit" >
                  <?= __('Click here to return to the RISE homepage', 'rise-wp-theme') ?>
                </a>
            </form>
        </div>
    </div>
  </div>
  <?php include __DIR__.'/sidebar-color.php' ?>
</section>
