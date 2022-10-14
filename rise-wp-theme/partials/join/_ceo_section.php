
<section class="ceo-info-section">
    <div class="ceo-info">

        <div class="ceo-info__content">
            <div class="content__image">
                <img src="<?=$join_contents['ceo_image']['url'] ?>" alt="<?=$join_contents['ceo_image']['alt'] ?>"" />

            </div>

            <?php

            if(!empty($join_contents['ceo_content_area'])) {
            ?>
            <div class="content__text__wrapper">
                <div class="ceo-info__text md:text-left lg:text-left">

                    <?= $join_contents['ceo_content_area'];?></span>

                </div>
                <?php } ?>
                <p class="mt-9 text-lg font-semibold name-title">
                    <?= $join_contents['ceo_name'];?>
                </p>
                <p class="mt-3 text-sm  name-title">
                    <?= $join_contents['ceo_position'];?>
                </p>
            </div>
        </div>

    </div>
</section>
