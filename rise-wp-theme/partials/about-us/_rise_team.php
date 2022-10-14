<section class="container px-6 sm:px-12 lg:px-40 pt-16 pb-24">
    <h3 class="text-2xl sm:text-3.5xl font-bold mt-2 mb-5"><?= $about_contents['rise_team_section_title'];?></h3>
    <p class="text-lg font-light"><?= $about_contents['rise_team_section_subtitle']; ?></p>
    <div class="mt-20 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php foreach ($rise_teams as $rise_team): ?>
        <div class="justify-self-center text-center">
            <img class="h-96 w-96 object-cover" src="<?= $rise_team['image'] ?>" alt="<?= $rise_team['title'];?>">
            <p class="text-xl font-medium mt-8"><?= $rise_team['title'];?></p>
            <p class="text-gray550 mb-2"><?= $rise_team['content']; ?></p>
        </div>
        <?php endforeach; ?>

    </div>
</section>
