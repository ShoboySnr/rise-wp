<?php

    use RiseWP\Api\UltimateMembers;

    get_header('dashboard');
global $post;

$parent_id = get_id_by_slug('develop-opportunity');
$id = get_the_ID();

$types = rise_wp_return_the_category($id, RISE_WP_OPPORTUNITIES_TYPES);
$post_thumbnail = !empty(get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : $types['image'];


$custom_category = rise_wp_return_the_category($id, RISE_WP_OPPORTUNITIES_CAT);
$custom_filters = rise_wp_return_the_category($id, RISE_WP_OPPORTUNITIES_TYPES);
$postData = get_post($id);
$postDate = rise_wp_format_date_news(get_the_date());
$program_date = rise_wp_format_date_news(get_field('opportunities_date', $id), 'D d M Y');

$enquiry_title = get_field('enquiry_title', $id);
$enquiry_subtitle = get_field('enquiry_subtitle', $id);
$show_enquire_button = get_field('show_enquire_button', $id);
$enquiry_form = get_field('enquiry_submission_form', get_page_by_path('develop/opportunities'));

$submission_state = get_post_meta(get_current_user_id(), 'user_opportunities_submitted');
$is_submitted_state = false;
if(in_array($id, $submission_state)) $is_submitted_state = true;

//check if this opportunity is bookmarked
$bookmarked_opportunities = UltimateMembers::get_instance()->get_user_bookmarks(get_current_user_id(), 'opportunities');
$is_bookmarked_text = __('Add to bookmarks', 'rise-wp-theme');
$is_bookmarked_text_toggle = __('Bookmarked', 'rise-wp-theme');
$bookmarked_selector = 'save-opportunities';
if(in_array($id, $bookmarked_opportunities)) {
    $is_bookmarked_text = __('Bookmarked', 'rise-wp-theme');
    $is_bookmarked_text_toggle = __('Add to bookmarks', 'rise-wp-theme');
    $bookmarked_selector = 'delete-opportunities';
}
?>
<main id="primary" class="site-main">
    <div class="dashboard-wrapper">
      <section class="dashboard-container remove-padding">
        <div class="connections">
          <?php

          $page_title = get_field('page_title', get_page_by_path('develop/opportunities'));
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
          <div class="connect-tab">
            <div>

              <div class="connect-tabs-wrapper">
                <div class="flex mt-10 mb-4 lg:mb-0 items-center font-light text-sm">
                  <p class="mr-4"><?= get_field('page_title', get_page_by_path('develop/opportunities')) ?></p>
                    <?php include(RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php'); ?>
                  <a href="<?= get_permalink(get_page_by_path('develop/opportunities')) ?>" class="mr-4"><?= get_page_by_path('develop/opportunities')->post_title ?></a>
                    <?php include(RISE_THEME_SVG_COMPONENTS.'/breadcrumb-arrow.php'); ?>
                  <p class=""> <?= get_the_title(); ?> </p>
                </div>
                <section>
                  <a href="<?= get_permalink(get_page_by_path('develop/opportunities'))?>" class="hidden lg:flex items-center text-gray450 font-normal text-sm mt-14 w-max"
                  >
                    <svg focusable="false" class="mr-3" width="17" height="15" viewBox="0 0 17 15" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                      <path d="M0.75 7.27441L15.75 7.27441" stroke="#DB3B0F" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"/>
                      <path d="M6.7998 13.2988L0.749804 7.27476L6.7998 1.24976" stroke="#DB3B0F" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <?=__('Go back', 'rise-wp-theme')?>
                  </a>


                  <div class="flex flex-col-reverse lg:flex-row w-full">
                    <div class="flex-shrink-0 lg:w-3/4 lg:pr-19 text-riseBodyText dark:text-white leading-8 mb-32">
                      <h2
                        class="text-2xl font-bold mt-9 text-riseDark dark:text-white  hidden lg:block"><?= get_the_title(); ?></h2>
                        <?php
                            if(!empty($post_thumbnail)) {
                        ?>
                        <img src="<?= $post_thumbnail; ?>" alt="<?= $post->post_name ?>" title="<?= get_the_title(); ?>" class="mt-12 hidden lg:inline-block w-full h-81 object-cover object-center">
                      <?php } ?>
                        <div class="mt-12 " id="rise-content-area">
                        <?php the_content(); ?>
                      </div>

                        <?php
                            if($show_enquire_button) {
                        ?>
                      <div class="flex justify-end">
                          <?php
                              if(!$is_submitted_state) {
                          ?>
                            <button type="button" data-modal="enquiry-form" class="enquiry-form py-2.5 px-10.5 bg-red text-white rounded-3xl text-base font-normal hidden lg:inline-flex open-modal mt-9 capitalize">
                              <?= __('Enquiry here', 'rise-wp-theme') ?>
                            </button>
                          <?php } else {
                           ?>
                              <button type="button" class="py-2.5 px-10.5 applied-submission flex items-center text-white rounded-3xl text-base font-normal hidden lg:inline-flex mt-9 capitalize">
                                  <span class="mr-2"><?= __('Applied', 'rise-wp-theme') ?></span>
                                  <svg width="21" height="21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.17.5h8.67c3.39 0 5.66 2.38 5.66 5.92v8.171c0 3.529-2.27 5.909-5.66 5.909H6.17C2.78 20.5.5 18.12.5 14.591V6.42C.5 2.88 2.78.5 6.17.5Zm3.76 12.99 4.75-4.75c.34-.34.34-.89 0-1.24a.881.881 0 0 0-1.24 0l-4.13 4.13-1.75-1.75a.881.881 0 0 0-1.24 0c-.34.34-.34.89 0 1.24l2.38 2.37c.17.17.39.25.61.25.23 0 .45-.08.62-.25Z" fill="#fff"/>
                                  </svg>
                              </button>
                          <?php
                          }
                          ?>
                      </div>
                        <?php } ?>
                    </div>
                    <div class="flex-shrink-0 lg:pl-12 lg:border-l border-gray50">
                        <?php
                            if($show_enquire_button) {
                                if(!$is_submitted_state) {
                        ?>
                              <button type="button" data-modal="enquiry-form" class="enquiry-form py-2.5 px-10.5 bg-red text-white rounded-3xl text-base font-normal hidden lg:inline-flex open-modal mt-9 capitalize">
                                  <?= __('Enquiry here', 'rise-wp-theme') ?>
                              </button>
                               <input type="hidden" value="<?= get_the_ID() ?>" id="post_id"  />
                               <input type="hidden" value="<?= get_the_title(). ' - '.get_permalink() ?>" id="post_title"  />
                            <?php } else {
                                ?>
                                <button type="button" class="py-2.5 px-10.5 applied-submission flex items-center text-white rounded-3xl text-base font-normal hidden lg:inline-flex mt-9 capitalize">
                                    <span class="mr-2"><?= __('Applied', 'rise-wp-theme') ?></span>
                                    <svg width="21" height="21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.17.5h8.67c3.39 0 5.66 2.38 5.66 5.92v8.171c0 3.529-2.27 5.909-5.66 5.909H6.17C2.78 20.5.5 18.12.5 14.591V6.42C.5 2.88 2.78.5 6.17.5Zm3.76 12.99 4.75-4.75c.34-.34.34-.89 0-1.24a.881.881 0 0 0-1.24 0l-4.13 4.13-1.75-1.75a.881.881 0 0 0-1.24 0c-.34.34-.34.89 0 1.24l2.38 2.37c.17.17.39.25.61.25.23 0 .45-.08.62-.25Z" fill="#fff"/>
                                    </svg>
                                </button>
                                <?php
                                }
                            }
                        ?>
                      <h2
                        class="text-lg font-bold mt-9 text-riseDark dark:text-white border-b border-gray50 lg:border-none pb-6 block lg:hidden">
                        <?= get_the_title() ?> </h2>
                        <?php
                            if(!empty($post_thumbnail)) {
                                ?>
                                <img src="<?= $post_thumbnail; ?>" alt="<?= $post->post_name ?>" title="<?= get_the_title(); ?>" class="mt-12 inline-block lg:hidden w-full h-81 object-cover object-center" style="height: 160px">
                            <?php } ?>
                      <div class="grid grid-cols-2 lg:grid-cols-1">
                          <?php
                          
                              if(!empty($program_date)) {
                          ?>
                        <div class="flex flex-col text-base mt-10">
                          <span
                            class="font-bold text-riseDark dark:text-white"><?= __('Closing date', 'rise-wp-theme') ?> </span>
                          <span class="font-light mt-2 text-riseBodyText dark:text-white"> <?= $program_date; ?> </span>
                        </div>
                          <?php }
                          
                              if(!empty($custom_category['title'])) {
                          ?>
                        <div class="flex flex-col text-base mt-10">
                          <span
                            class="font-bold text-riseDark dark:text-white"><?= __('Category', 'rise-wp-theme') ?> </span>
                          <span
                            class="font-light mt-2 text-riseBodyText dark:text-white"> <?= $custom_category['title']; ?></span>
                        </div>
                        <?php }
                        
                              if(!empty($custom_filters['title'])) {
                        ?>
                        <div class="flex flex-col text-base mt-10">
                          <span
                            class="font-bold text-riseDark dark:text-white"><?= __('Call type', 'rise-wp-theme') ?> </span>
                          <span
                            class="font-light mt-2 text-riseBodyText dark:text-white"> <?= $custom_filters['title'] ?></span>
                        </div>
                        <?php
                              }
                              
                              if(false){//(!empty($postDate)) {
                              
                        ?>
                        <div class="flex flex-col text-base mt-10">
                          <span
                            class="font-bold text-riseDark dark:text-white"> <?= __('Publication date', 'rise-wp-theme') ?> </span>
                          <span class="font-light mt-2 text-riseBodyText dark:text-white"> <?= $postDate ?></span>
                        </div>
                        <?php } ?>
                        <div class="flex flex-col text-base mt-10">
                            <a class="w-max px-4 mb-5 lg:mb-0 py-2 flex justify-center items-center border border-red hover:text-red hover:bg-white bg-red rounded-full text-white font-medium text-input mr-2 <?= $bookmarked_selector ?>" href="javascript:void(0);"
                               data-is-connected="<?= $is_bookmarked_text_toggle ?>"
                               data-remove-nonce="<?= $remove_nonce = wp_create_nonce('um_user_bookmarks_remove_'.$id); ?>"
                               data-add-nonce="<?= wp_create_nonce('um_user_bookmarks_new_bookmark') ?>" data-id="<?= $id ?>">
                                <?= $is_bookmarked_text ?></a>
                        </div>
                      </div>
                        <?php

                            if ($show_enquire_button) {
                                if(!$is_submitted_state) {
                        ?>
                          <button type="button" data-modal="enquiry-form"
                                  class="enquiry-form py-2.5 px-10.5 bg-red text-white rounded-3xl text-base font-normal open-modal mt-9 lg:hidden capitalize"><?= __('Enquiry here', 'rise-wp-theme') ?>
                          </button>
                            <?php } else {
                                ?>
                                <button type="button" class="py-2.5 px-10.5 applied-submission flex items-center text-white rounded-3xl text-base font-normal open-modal mt-9 lg:hidden capitalize">
                                    <span class="mr-2"><?= __('Applied', 'rise-wp-theme') ?></span>
                                    <svg width="21" height="21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.17.5h8.67c3.39 0 5.66 2.38 5.66 5.92v8.171c0 3.529-2.27 5.909-5.66 5.909H6.17C2.78 20.5.5 18.12.5 14.591V6.42C.5 2.88 2.78.5 6.17.5Zm3.76 12.99 4.75-4.75c.34-.34.34-.89 0-1.24a.881.881 0 0 0-1.24 0l-4.13 4.13-1.75-1.75a.881.881 0 0 0-1.24 0c-.34.34-.34.89 0 1.24l2.38 2.37c.17.17.39.25.61.25.23 0 .45-.08.62-.25Z" fill="#fff"/>
                                    </svg>
                                </button>
                                <?php
                                }
                            }
                        ?>
                    </div>
                  </div>
                </section>
              </div>

                <?php
                    if ($show_enquire_button) {
                        if(!$is_submitted_state) {
                ?>
              <section id="enquiry-form" class="hidden">
                <div class="modal-overlay z-10">
                  <div
                    class=" absolute h-full bg-white z-10 top-0 bottom-0 overflow-y-auto w-11/12 md:w-4/6 lg:w-3/5 right-0 transition-all ">
                    <div class=" relative max-w-xl w-10/12 md:w-11/12 flex flex-col mx-auto pt-10 ">
                      <button data-modal="enquiry-form" class="close-modal self-end p-3 rounded-full bg-orange300">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path
                            d="M17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41L17.59 5Z"
                            fill="#DB3B0F" />
                        </svg> </button>
                      <div id="enquiry-form" class="text-riseDark dark:text-white pb-10">
                        <header>
                          <p class="text-base uppercase"><?=__('ENQUIRY FOR:', 'rise-wp-theme')?></p>
                          <h1 class="font-bold text-2xl mt-3"> <?= get_the_title() ?>  </h1>
                          <p class="text-base font-light mt-6 text-riseBodyText dark:text-white">
                              <?= __('All fields are required unless marked as optional.
                              Some of the details have been filled in based on some details you gave us earlier.', 'rise-wp-theme') ?>
                          </p>
                          <h2 class="text-nav mt-14 font-bold"><?= __('Your details', 'rise-wp-theme') ?></h2>
                        </header>

                        <?= do_shortcode($enquiry_form);?>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

              <!-- Success Modal -->
              <section id="success-modal" class="hidden">
                <div class="modal-overlay z-10">
                  <div class=" absolute bg-white z-10 top-0 bottom-0 overflow-y-auto w-11/12 md:w-4/6 lg:w-3/5 right-0 transition-all ">
                    <div class=" relative max-w-xl w-10/12 md:w-11/12 h-full flex flex-col mx-auto pt-10 ">
                        <a href="<?= get_permalink() ?>" class="self-end p-3 rounded-full bg-orange300">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41L17.59 5Z"
                                fill="#DB3B0F" />
                            </svg>
                        </a>
                      <div class="max-w-md w-4/5 mx-auto h-2/3 text-center mt-auto">
                          <svg class="w-18 h-18 md:w-46 md:h-46 mx-auto" viewBox="0 0 186 186" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <circle cx="93" cy="93" r="93" fill="#4FC068" />
                          <path d="M57.2305 95.8616L84.0574 121.615L128.769 78.6924" stroke="white" stroke-width="12" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <h1 class="text-2xl text-riseDark dark:text-white mt-8 md:mt-20"><?= __('Enquiry Submitted', 'rise-wp-theme') ?></h1>
                        <p class="text-base text-riseBodyText dark:text-white mt-4 font-light"><?=  __('An Innovation Advisor will get back to you shortly.', 'rise-wp-theme') ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
                <?php
                        }
                    }
                ?>
            </div>
          </div>
        </div>
      </section>
    </div>
</main>

<?php

get_footer('dashboard')

?>


