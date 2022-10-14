<section class="news-container">
    <?php if (!empty($programme_content['programme_pre_liner'])){ ?>
        <p><?= $programme_content['programme_pre_liner']; ?></p>
    <?php } ?>
    <figure class="lg:flex-row<?= $i % 2 == 0 ? "-reverse" : "" ; ?> programme-card">
        <figcaption>
            <h5 class="font-bold"><?= $programme_content['programme_title']; ?></h5>
            <p class="whitespace-pre-line">
                <?= $programme_content['programme_content']; ?>
            </p>
        </figcaption>
        <picture>
            <img src="<?= $programme_content['programme_image']; ?>" alt="">
        </picture>
    </figure>
</section>