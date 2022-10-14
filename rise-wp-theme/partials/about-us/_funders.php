<section class="container px-6 sm:px-12 lg:px-40 pb-16">
    <h4 class="mt-24 font-bold text-2xl  mb-14"><?=__('Funders','rise-wp-theme') ?></h4>
    <div>
        <div class="border-gray border-b pb-12">
            <p class="text-xl font-semibold mb-9 sm:mb-5"><?= $about_contents['erdf_title'];?></p>
            <div class="flex flex-col md:flex-row">
                <div class="funders-img">
                    <img src="<?= $about_contents['partner_one_image']['url'] ?>" class="py-1" alt="<?= $about_contents['partner_one_image']['alt'] ?>">
                    <img src="<?= $about_contents['partner_two_image']['url'] ?>" class="py-0.5" alt="<?= $about_contents['partner_two_image']['alt'] ?>">
                </div>

                <div class="flex">

                    <div class="mr-11 sm:text-lg">
                        <div class="funders-text-clip">
                            <?= $about_contents['erdf_subtitle'] ?>
                        </div>
                    </div>

                    <button class="focus:outline-none funders-hide-btn outline-none flex">
                        <svg class="block" width="28" height="28" viewBox="0 0 28 28" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <rect x="12.4923" width="3.44615" height="28" fill="#DB3B0F" />
                            <rect y="15.9385" width="3.44615" height="28" transform="rotate(-90 0 15.9385)"
                                  fill="#DB3B0F" />
                        </svg>
                        <svg class="hidden" width="24" height="3" viewBox="0 0 24 3" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <rect x="24" width="3" height="24" transform="rotate(90 24 0)" fill="#DB3B0F" />
                        </svg>
                    </button>

                </div>





            </div>
        </div>
        <div class="border-gray border-b pb-12 mt-10">
            <p class="text-xl font-semibold mb-9 sm:mb-5"><?= $about_contents['local_council_title']?></p>
            <div class="flex flex-col md:flex-row">
                <div class="funders-img">
                    <img class="mb-3" src="<?= $about_contents['partner_three_image']['url']?>" alt="<?= $about_contents['partner_three_image']['alt']?>">
                </div>

                <div class="flex">
                    <div class="mr-11 sm:text-lg">
                        <p>
                            <?= $about_contents['local_council_subtitle']?>
                        </p>
                        <img class="mt-3" src="<?= $about_contents['local_council_images_more']['url']?>" alt="<?= $about_contents['local_council_images_more']['alt']?>">
                    </div>
                </div>

            </div>
        </div>
        <div class="pb-12 mt-10">
            <p class="text-xl font-semibold mb-9 sm:mb-5"><?= $about_contents['local_councils_title']?></p>
            <div class="flex flex-col md:flex-row">
                <div class="funders-img">
                    <img src="<?= $about_contents['partner_four_image']['url'];?>" class="py-1" alt="<?= $about_contents['partner_four_image']['alt'];?>">
                    <img src="<?= $about_contents['partner_five_image']['url'];?>" class="py-1" alt="<?= $about_contents['partner_five_image']['alt'];?>">
                </div>
                <div class="flex">
                    <div class="mr-11 sm:text-lg">
                        <p>
                            <?= $about_contents['local_councils_subtitle'];?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
