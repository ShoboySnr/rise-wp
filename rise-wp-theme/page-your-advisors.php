<!--
Template Name: Your Advisors
-->
<?php if ( ! defined( 'ABSPATH' ) ) exit;

use RiseWP\Classes\Advisors; ?>
<?php

$advisors = Advisors::get_instance()->get_advisors();
$sub_title = get_field('page_subtitle');

get_header();

global $post;


?>

<div class="min-h-screen bg-gray100 md:pl-24">
  <div>

    <?php
    $page_title = get_field('page_title');

    $page_header_args = [
      [
        'title'   => get_page_by_path('member-directory')->post_title,
        'link'    =>get_permalink(get_page_by_path('member-directory')),
      ],
      [
        'title'   => get_page_by_path('forum')->post_title,
        'link'    => get_permalink(get_page_by_path('forum')),
      ],
      [
        'title'   => get_page_by_path('rise-team')->post_title,
        'link'    => get_permalink(),
      ]
    ];

    do_action('rise_wp_member_dashboard_header', $page_title, $page_header_args)
    ?>

    <div class="dashboard-wrap connect-tabs-wrapper">

      <div class="connections-nav-container">
        <div class="connections-nav">
          <p class="mr-4"><?=__('Connect', 'rise-wp-theme')?></p>
          <svg class="mr-4" width="9" height="17" viewBox="0 0 9 17" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M0.46967 16.1329C0.203403 15.8666 0.179197 15.4499 0.397052 15.1563L0.46967 15.0722L6.939 8.60254L0.46967 2.13287C0.203403 1.8666 0.179197 1.44994 0.397052 1.15633L0.46967 1.07221C0.735936 0.805943 1.1526 0.781736 1.44621 0.999591L1.53033 1.07221L8.53033 8.07221C8.7966 8.33848 8.8208 8.75514 8.60295 9.04875L8.53033 9.13287L1.53033 16.1329C1.23744 16.4258 0.762563 16.4258 0.46967 16.1329Z"
              fill="#A9A9A9" />
          </svg>
          <p class=""><?= $post->post_title ?></p>
        </div>
      </div>


      <div class="connect-tab ">
        <h1 class="text-2xl pt-5 text-riseDark"><?= $sub_title;?></h1>
        <div
          class="
                pt-14
                grid
                gap-5
                grid-cols-1
                md:grid-cols-2
                lg:grid-cols-3
                justify-center
              "
        >
          <?php if(!empty($advisors)): ?>
            <?php $i = 1; foreach ($advisors as $advisor): ?>

              <article
                class="text-center rounded-lg advisors-bg bg-white"
                style="
                  border: 1px solid #e6e6e6;
                  box-shadow: 0px 0px 142.49px #f3f3f3;
                  border-radius: 10px;
                "
              >
                <div
                  style="
                    width: 100%;
                    height: 200px;
                    background: <?php if($i == 1){ echo '#ef4d7f';}elseif($i == 2){ echo '#fcb613';}else{ echo '#a22035';} ?>;
                    border-radius: 8.90564px 8.90564px 0px 0px;
                    "
                ></div>
                <img
                  src="<?= $advisor['image']; ?>"
                  alt="<?= $advisor['title']; ?>"
                  style="
                    width: 150px;
                    height: 150px;
                    border: 1.97903px solid #ffffff;
                    border-radius: 100%;
                    margin: 0 auto;
                    margin-top: -74px;
                    filter: blur(0px);
                    object-fit: cover;
                  "
                  class="z-50"
                />
                <div class="pt-4 px-4 bg-white">
                  <h2 class="text-nav text-riseDark pb-2"><?= $advisor['title']; ?></h2>
                  <div class="text-sm text-riseBodyText">
                    <?= $advisor['advisor_profession'];?>
                  </div>
                  <div
                    style="margin: 0 auto"
                    class="text-riseBodyText pt-10 pb-14 px-4"
                  >
                    <?= $advisor['content'];?>
                  </div>
                </div>
              </article>

              <?php $i++; endforeach;  ?>
          <?php endif; ?>

        </div>
        <div class="flex justify-center pt-18 pb-12">
          <button
            class="
              open-contact-modal
                  bg-red
                  text-white
                  px-10
                  py-3
                  rounded-full
                  flex
                  items-center
                "
          >
            <span><?=__('Contact the RISE team', 'rise-wp-theme')?></span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php

get_footer();
