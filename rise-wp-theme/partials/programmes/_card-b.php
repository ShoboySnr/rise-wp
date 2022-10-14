<div class="flex flex-col">
    <picture class="max-h-82">
        <img class="h-full w-full object-cover object-center" src="<?= $column_content['image']; ?>" alt="">
    </picture>
    <div class="vertical-card-info">
        <h6 class="text-3xl font-semibold">
            <?= $column_content['title']; ?>
        </h6>
        <p class="whitespace-pre-line mt-7">
            <?= $column_content['text']; ?>
            <?php if( ! empty($column_content['post_liner']) ): ?>
            <span class="font-semibold block mt-5"><?= $column_content['post_liner']; ?></span>
            <?php endif; ?>
        </p>
    </div>
</div>