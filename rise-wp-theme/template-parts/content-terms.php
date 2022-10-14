<?php
$terms_subtitle = get_field('terms_subtitle', get_the_ID());
?>
<section id="first-view">
    <header>
        <top-nav>
        </top-nav>
        <h1 class="container terms-container text-4xl font-bold mb-14 mt-24"><?= the_title();?></h1>
    </header>
</section>
<section class="container terms-container mb-32">
    <h3 class="text-lg sm:text-xl font-semibold mb-5">
        <?= $terms_subtitle;?>
    </h3>
    <div class="sm:text-nav font-light">
        <?= the_content(); ?>
    </div>
</section>
