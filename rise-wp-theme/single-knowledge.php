<?php

use RiseWP\Classes\Knowledge;
global $post;


$parent_id = get_id_by_slug('knowledge');
$id = get_the_ID();

$knowledge_category = rise_wp_return_the_category($id, RISE_WP_KNOWLEDGE_CAT);
$knowledge_type = rise_wp_return_the_category($id, RISE_WP_KNOWLEDGE_TYPE);

$custom_date = rise_wp_format_date_news(get_field('research_date', $id));
$category = rise_wp_return_the_category($id, RISE_WP_KNOWLEDGE_CAT);
$type = rise_wp_return_the_category($id, RISE_WP_KNOWLEDGE_TYPE);

$post_thumbnail = (has_post_thumbnail($id)) ? get_the_post_thumbnail_url($id) : $type['image'];
$research_author_name = get_field('research_author_name', $id);
$researcher_job_title = get_field('researcher_job_title', $id);
$researcher_image = get_field('researcher_image', $id);
$research_date = get_field('research_date', $id);

$author_name = get_field('author_name', $post);
$author_image = get_field('author_image', $post);
$author_title = get_field('author_title', $post);


$postdate = rise_wp_format_date_news(get_the_date(), 'd F, Y');
$program_date = rise_wp_format_date_news(get_field('research_date', $id), 'd F, Y');

$post_cat = $category['id'];


$related = Knowledge::get_instance()->get_related_knowledge($id, 3, $category);

get_header('dashboard');
?>


<div class="dashboard-wrapper">
  <section class="dashboard-container remove-padding">
    <div class="connections">
      <?php

      $page_title = get_field('page_title', get_page_by_path('develop/knowledge-and-tools'));
      $sub_title = get_field('page_subtitle');

      $page_header_args = [
        [
          'title' => get_page_by_path('develop/innovation-audits')->post_title,
          'link' => get_permalink(get_page_by_path('develop/innovation-audits')),
        ],
        [
          'title' => get_page_by_path('develop/knowledge-and-tools')->post_title,
          'link' => get_permalink(get_page_by_path('develop/knowledge-and-tools')),
        ],
        [
          'title' => get_page_by_path('develop/opportunities')->post_title,
          'link' => get_permalink(get_page_by_path('develop/opportunities')),
        ]
      ];


      do_action('rise_wp_member_dashboard_header', $page_title, $page_header_args)
      ?>
    </div>
    <div class="dashboard-wrap connect-tabs-wrapper">
      <section class="connect-tab">
        <div class="mt-10 flex flex-col sm:flex-row justify-between">
          <div class="flex mb-4 sm:mb-0 items-center font-light text-sm">
            <p class="mr-4"><?= get_field('page_title', get_page_by_path('develop/knowledge-and-tools')) ?></p>
            <?php include(RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php'); ?>
            <a href="<?= get_permalink(get_page_by_path('develop/knowledge-and-tools'))?>" class="mr-4"><?= get_page_by_path('develop/knowledge-and-tools')->post_title ?></a>
            <?php include(RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php'); ?>
              <a href="<?= get_permalink(get_page_by_path('develop/knowledge-and-tools/knowledge-and-tools-library'))?>" class="mr-4"><?= get_page_by_path('develop/knowledge-and-tools/knowledge-and-tools-library')->post_title ?></a>
              <?php include(RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php'); ?>
            <p class=""><?= get_the_title(); ?></p>
          </div>
        </div>
        <div>
          <a href="<?= get_permalink(get_page_by_path('develop/knowledge-and-tools/knowledge-and-tools-library'))?>" type="button" class="flex items-center mt-16 mb-8 w-max">
              <?php include(RISE_THEME_SVG_COMPONENTS.'/arrow-back-colored-member-area.php'); ?>
            <span class="text-gray450 pl-2 text-sm"><?=__('Go back','rise-wp-theme')?></span>
          </a>
          <div class="grid grid-cols-1 md:grid-cols-5 gap-12 pb-16 border-b" style="border-color: #E9E9E9;">
            <div class="col-span-2 py-10 flex items-start flex-col justify-center">
              <p class="text-sm text-riseBodyText font-light"><?= $program_date; ?></p>
              <h2 class="pt-5 text-2xl font-medium text-riseDark"><?= get_the_title(); ?></h2>
              <button type="button" class="bg-riseDark text-white text-sm py-1 px-5 mt-6"><?= $knowledge_category['title'];?></button>
              <div class="pt-7 flex gap-4">
                  <?php
                      if(!empty($author_image)) {
                  ?>
                    <img src="<?= $author_image ?>" alt="<?= $author_name ?>" class="w-10 h-10 rounded-full object-cover object-center" title="<?= $author_name ?>">
                  <?php } ?>
                <div>
                  <p class="text-riseDark font-medium"><?= $author_name?></p>
                  <p class="text-riseBodyText text-sm"><?= $author_title?></p>
                </div>
              </div>
            </div>
              <?php
                  if(!empty($post_thumbnail)) {
              ?>
                <picture class="col-span-3">
                  <img src="<?= $post_thumbnail ?>" alt="<?= get_the_title(); ?>" class="rounded-b-one rounded-t-one w-full knowledge-featured-image" title="<?= get_the_title(); ?>">
                </picture>
              <?php } ?>
          </div>
        </div>
        <article class="pt-14 max-w-3xl mx-auto pb-24">

          <div class="text-gray300 " id="rise-content-area">
            <?php the_content(); ?>
          </div>

        </article>
        <div class="pb-20 border-t" style="border-color: #E9E9E9;">
            <?php
                if(!empty($related)){
            ?>
          <p class="text-lg text-riseDark pt-12 pb-8"><?=__('You might also be interested in','rise-wp-theme')?></p>
          <div class="grid gap-4 grid-cols-1 md:grid-cols-3">
           <?php
              foreach ($related as $knowledge) {
                ?>
                <knowledge-card image="<?= $knowledge['image'] ?>"
                                title="<?= $knowledge['title'] ?>"
                                category="<?= $knowledge['category']['title'] ?>" excerpt="<?= $knowledge['excerpt'] ?>"
                                link="<?= $knowledge['link'] ?>"
                                type="<?= $knowledge['type']['title']?>"></knowledge-card>

                <?php } ?>
          </div>
            <?php } ?>
        </div>
      </section>
    </div>
  </section>
</div>

<?php

    get_footer('dashboard')

?>

