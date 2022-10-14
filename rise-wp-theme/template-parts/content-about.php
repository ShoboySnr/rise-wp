<?php
use RiseWP\Pages\About;
$id = get_the_ID();
$rise_teams = About::get_instance()->get_rise_team('3');
$about_contents = About::get_instance()->get_about_contents($id);

?>

<section id="first-view">
    <header>
        <div class="flex flex-col lg:flex-row justify-end lg:items-center pl-6 sm:pl-12 lg:pl-44 relative mt-12 sm:mt-0">
            <div class="about-heading mr-6 sm:mr-12 lg:absolute 2xl:relative left-6 sm:left-12 lg:left-44 2xl:left-12 dark:bg-transparent bg-white pt-5 pb-9">
                <p class="text-red text-2xl md:text-3xl font-semibold mb-4"><?php the_title();?></p>
                <h1 class="text-black100 dark:text-white text-3xl md:text-4xl font-semibold"><?= $about_contents['subtitle_text']; ?></h1>
            </div>
            <div class="min-w-full lg:min-w-2/3 2xl:min-w-1/2">
                <img class="w-full about-heading-img object-cover" src="<?php echo  get_the_post_thumbnail_url($id); ?>">
            </div>
        </div>

    </header>
</section>


<section class="container px-6 sm:px-12 lg:px-40">
    <div class="grid md:grid-cols-2 gap-12 pt-24 pb-14 ">
        <p class="text-xl sm:text-2xl lg:max-w-lg mb-6 lg:mb-0 lg:mr-4">
            <?= $about_contents['first_section_subtitle'];?> </p>
        <p class="sm:text-lg lg:max-w-xl font-light">
            <?= $about_contents['first_section_right'];?>
        </p>
    </div>
    <div class="grid grid-cols-2 gap-6 sm:gap-12">
        <img class="h-48 sm:h-96 w-full object-cover" src="<?= $about_contents['first_section_image']['url']?>" alt="<?= $about_contents['first_section_image']['alt']?>">
        <img class="h-48 sm:h-96 w-full object-cover" src="<?= $about_contents['first_section_image_two']['url']?>" alt="<?= $about_contents['first_section_image']['alt']?>">
    </div>
    <div class="sm:text-lg mt-14 font-light">

        <?= $about_contents['universities_information'];?>

    </div>
    <h4 class="font-bold text-2xl sm:text-3.5xl mt-7 sm:mt-14"><?=__('Who is eligible?','rise-wp-theme')?></h4>
    <p class="sm:text-lg mt-7 sm:mt-14 font-light"><?= $about_contents['eligible_content']?>
        </p>
    <a class="news-btn mt-4 text-white inline-block font-bold nav-btn rounded-one text-white bg-black100 flex items-center justify-center border-2 border-black dark:border-white hover:bg-white hover:text-black transition-all"
       href="<?= $about_contents['faq_url']['url']?>"><?= $about_contents['faq_url']['title']?>
        <?php include RISE_THEME_SVG_COMPONENTS .'/arrow-white.php' ?>
    </a>
</section>


<!--Rise Team -->
<?php include RISE_THEME_PARTIAL_VIEWS .'/about-us/_rise_team.php';?>

<!--Rise Team Ends-->
<!--Project Partners-->
<?php include RISE_THEME_PARTIAL_VIEWS.'/about-us/_project_partners.php';?>
<!--Project Partners Ends-->

<!--Funders section-->
<?php include RISE_THEME_PARTIAL_VIEWS.'/about-us/_funders.php';?>
<!--Funders Section Ends-->

<footer-prefix color="yellow" image="<?= $about_contents['footer_prefix_image']['url'];?>" href="<?= $about_contents['footer_prefix_link']['url']?>" link-title="<?= $about_contents['footer_prefix_link']['title'];?>" text="<?= $about_contents['footer_prefix_text']?>" card-color="#343434" text-color="black" ></footer-prefix>
