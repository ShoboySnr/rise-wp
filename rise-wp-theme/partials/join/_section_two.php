
<section class="join-section">
    <div class="join-section-card">
        <div class="join-section-card__text">
            <p><?= $join_contents['section_two_title'];?>
            </p>
            <p>
                <?= $join_contents['section_two_subtitle']?></p>
        </div>
        <div class="cards">
            <div>
                <p class="card__title"><?=__('Friend','rise-wp-theme')?></p>
                <div class="card__text"> <?= $join_contents['friend_box'];?></div>
            </div>
            <div>
                <p class="card__title"><?=__('Member','rise-wp-theme')?></p>
                <div class="card__text">

                        <?= $join_contents['member_box']; ?>
                     
                </div>

            </div>
        </div>
        <div class="join-section-card__text">
            <p>
                <?= $join_contents['join_banner_subtitle'];?>
            </p>
        </div>
        <a href="<?= $join_contents['section_url']['url']?>" class="join-section-card__link">
            <?= $join_contents['section_url']['title']?>
        </a>
    </div>
</section>
