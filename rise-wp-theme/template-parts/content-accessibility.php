<?php
$accessibility_subtitle = get_field('accessibility_subtitle', get_the_ID());
?>
<section id="first-view">
    <header>
        <top-nav>
        </top-nav>
        <h1 class="container terms-container text-3xl sm:text-4xl font-semibold mb-7 sm:mb-14 mt-12 sm:mt-24"><?= the_title();?></h1>
    </header>
</section>
<section class="container terms-container mb-32">
    <h3 class="text-lg sm:text-xl font-semibold mb-5">
       <?= $accessibility_subtitle;?>
    </h3>
  <button type="button" id="accessibility-btn" class="bg-red text-white py-3 px-6 text-lg sm:text-xl font-semibold mb-5 cursor-pointer flex hover:text-white border-2 rounded-one" >
    <?=__('Enable Accessiblity','rise-wp-theme')?> <span class="pl-2"  style="display: inline; margin: auto 0"><?php include RISE_THEME_SVG_COMPONENTS.'/arrow-white-dashboard.php';?></span>
  </button>
    <div class="sm:text-nav font-light">
        <?= the_content();?>
    </div>
</section>
