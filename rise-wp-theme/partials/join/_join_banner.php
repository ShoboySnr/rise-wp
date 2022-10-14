<section class="join-hero">
    <div class="join-hero__container">
        <div class="join-hero__container__text">
            <h2><?= $join_contents['join_banner_title'];?></h2>
            <p class="join-hero__sub-header"> <?= $join_contents['join_banner_subtitle'];?></p>
        </div>
        <div class="join-hero__container__img">
            <img src="<?php echo the_post_thumbnail_url();?>" />
        </div>
    </div>
</section>
