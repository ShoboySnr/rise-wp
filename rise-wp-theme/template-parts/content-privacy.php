<?php
$privacy_subtitle = get_field('page_subtitle', get_the_ID());
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
        <?= $privacy_subtitle;?>
    </h3>
    <div class="sm:text-nav font-light">
       <?= the_content(); ?>
    </div>
</section>
