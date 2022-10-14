<?php
use RiseWP\Classes\Utilities;
use RiseWP\Classes\Events;

global $post;

//check if the user is registered
if(!is_user_logged_in() && get_field('members_only') == 'yes') {
    wp_redirect(get_permalink(get_page_by_path('events')));
}
$date = get_field('event_date');
$member_only = get_field('members_only', get_the_id());
$month = rise_wp_format_date($date, 'M');
$day = rise_wp_format_date($date, 'd');

$end_date = get_field('event_end_date');
$end_month = rise_wp_format_date($end_date, 'M');
$end_day = rise_wp_format_date($end_date, 'd');

$parent_id = get_id_by_slug('events');
$footer_prefix = get_field('footer_pre_text', $parent_id);
$footer_pre_link = get_field('footer_pre_link',$parent_id);
$show_registation_form = get_field('show_registration_form');



$footer_prefix_image = get_field('footer_prefix_image', $parent_id);
//event details
$organisation = get_field('organisation');
$event_location = get_field('event_location');
$event_register_link = get_field('event_register_link');
$categories = Utilities::get_instance()->get_post_taxonomy($post->ID, RISE_WP_EVENT_CATEGORIES);
$down_arrow = RISE_THEME_ASSETS_IMAGES_DIR.'/down_arrow.svg';
$twitter = RISE_THEME_ASSETS_IMAGES_DIR.'/twitter.svg';
$instagram = RISE_THEME_ASSETS_IMAGES_DIR.'/instagram.svg';
$facebook = RISE_THEME_ASSETS_IMAGES_DIR.'/facebook.svg';
$linkedin = RISE_THEME_ASSETS_IMAGES_DIR.'/linkedin.svg';


//organiser info
$organiser_name = get_field('organiser_name');
$organiser_job_title = get_field('organiser_job_title');
$organiser_photo = get_field('organiser_photo');

//social media share
$url = get_permalink();
$home_url = home_url();
$content = substr(get_the_title(), 0, 100);
$category_name = isset($categories[0]['title']) ? $categories[0]['title'] : '';
$title = get_the_title();
$twitter_link = "https://twitter.com/share?text=$content&url=$url";
$facebook_link = "https://www.facebook.com/sharer/sharer.php?u=$url&t=$title";
$instagram_link = "";
$linkedin_link = "http://www.linkedin.com/shareArticle?mini=true&url=$url&title=$title&summary=$content&source=$home_url";
//related events
$related_events = Events::get_instance()->get_related_events($post);

?>


<event-single-hero title="<?php the_title() ?>" tag="<?= $category_name ?>"
            month="<?= $month; ?>" date="<?= $day ?>"     image="<?= get_the_post_thumbnail_url(); ?>" color="<?= $member_only === 'No' ? 'pink' : 'red' ?>" member_only="<?= $member_only == 'No' ? 'Open' : 'Members Only'; ?>">
</event-single-hero>
<section class=" custom-container">
    <div class="internal-event">
        <div class="event-description">
            <div class="font-light">
                <div id="content-area">
                    <?php the_content() ?>
                </div>
                <div class="pt-12 pl-0 lg:pl-10 flex items-center flex lg:hidden">
                    <p class="text-lg font-bold">
                        <?= __('Share event:', 'rise-wp-theme'); ?>
                    </p>
                    <div class="flex space-x-5 mt-0 lg:mt-8 pl-4">
                        <a href="<?= $twitter_link ?>" title="<?= __('Share on Twitter', 'rise-wp-theme') ?>" target="_blank">
                            <img src="<?= $twitter; ?>" alt="<?= __('TwitterIcon', 'rise-wp-theme') ?>"/>
                        </a>
                        <a href="<?= $facebook_link ?>" title="<?= __('Share on Facebook', 'rise-wp-theme') ?>" target="_blank">
                            <img src="<?= $facebook ?>" alt="<?= __('FacebookIcon', 'rise-wp-theme') ?>"/>
                        </a>
                        <a href="<?= $linkedin_link ?>" title="<?= __('Share on LinkedIn', 'rise-wp-theme') ?>" target="_blank" style="margin-top: 5px;margin-left: 5px;">
                            <img src="<?= $linkedin ?>" alt="<?= __('LinkedInIcon', 'rise-wp-theme') ?>" />
                        </a>
                    </div>
                </div>
            </div>
            <?php

            if(!empty($organiser_name)) {
                ?>
                <div class="space-y-7">
                    <h4 class="text-2xl"><?= __('Meet the Organiser', 'rise-wp-theme') ?></h4>
                    <div class="flex  items-center ">
                        <img alt="profile " class="rounded-full h-20 w-20" src="<?= $organiser_photo['url']; ?>" title="<?= $organiser_photo['title']; ?>">
                        <div class="ml-7">
                            <p class="text-lg font-bold"><?= $organiser_name; ?></p>
                            <p class="text-base text-gray600"><?= $organiser_job_title; ?></p>
                        </div>
                        <a class="ml-auto cursor-pointer">
                            <img src="<?= $down_arrow; ?>">
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="event-info">
            <div class="event-info__container ">
                <div>
                    <h4 class="event-info__title"><?= __('Date and Time:', 'rise-wp-theme'); ?> </h4>
                    <p class="text-xl font-semibold text-xl"><?= get_field('event_time'); ?> </p>
                    <p class="font-semibold text-xl d-inline"><?= rise_wp_format_date($date, 'M d, Y') ?></p>
                  <?php if(!empty($end_date)){ ?>
                    <span style="font-weight:800; padding: 5px" > &#8211; </span>
                    <p class="font-semibold text-xl d-inline"><?= rise_wp_format_date($end_date, 'M d, Y') ?></p>
                  <?php } ?>
                </div>
                <div class="mt-6">
                    <h4 class="event-info__title">
                        <?= __('Venue:', 'rise-wp-theme'); ?>
                    </h4>
                    <span class="text-lg font-semibold">
							<?= $event_location; ?>
						</span>
                </div>
              <?php   if($show_registation_form == 'true'): ?>

                <a class="event-info__link modal-open open-register-modal " id="open-eregister-modal">
                  <?= __('Register', 'rise-wp-theme') ?>
                </a>
              <?php else: ?>


                <?php



                if(!empty($event_register_link['url'])) {
                    ?>
                    <a class="event-info__link" href="<?= $event_register_link['url']; ?>" target="<?= $event_register_link['target'] ?>">
                        <?= $event_register_link['title'] ?>
                    </a>
                <?php } ?>

              <?php endif; ?>



            </div>
            <div class="pt-12 pl-10 hidden lg:flex items-center">
                <p class="text-lg font-bold">
                    <?= __('Share event:', 'rise-wp-theme'); ?>
                </p>
                <div class="flex space-x-5 mt-0 lg:mt-8 lg:mt-8 pl-4 lg:pl-0">
                    <a href="<?= $twitter_link ?>" title="<?= __('Share on Twitter', 'rise-wp-theme') ?>" target="_blank">
                        <img src="<?= $twitter; ?>" alt="<?= __('TwitterIcon', 'rise-wp-theme') ?>"  />
                    </a>
                    <a href="<?= $facebook_link ?>" title="<?= __('Share on Facebook', 'rise-wp-theme') ?>" target="_blank">
                        <img src="<?= $facebook ?>" alt="<?= __('FacebookIcon', 'rise-wp-theme') ?>"  />
                    </a>
                    <a href="<?= $linkedin_link ?>" title="<?= __('Share on LinkedIn', 'rise-wp-theme') ?>" target="_blank" style="margin-top: 5px;margin-left: 5px;">
                        <img src="<?= $linkedin ?>" alt="<?= __('LinkedInIcon', 'rise-wp-theme') ?>" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Event Register Form -->

<div
  class="modal-event hidden opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center z-40 justify-center">
  <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

  <div class="modal-container bg-white w-2/4 md:max-w-md mx-auto rounded shadow-lg z-50" style="max-width: 660px;
			margin-right: 0px;
			width: 37%; height: 100%; overflow-y: scroll !important;">
    <!-- Add margin if you want to see some of the overlay behind the modal-->
    <div class="modal-content py-4 text-left dark:bg-black ">
      <!--Title-->

      <div class="flex justify-end items-center pb-3 px-6">
        <div class="modal-close cursor-pointer z-50 mt-3 e-close-btn">
          <svg class="fill-current text-red" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
               viewBox="0 0 18 18">
            <path
              d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
            </path>
          </svg>
        </div>
      </div>

      <div class=" items-center rer-hide" style="padding-left: 3.2rem; padding-bottom: 1.5rem;">
        <p class="text-2xl font-bold pt-5"><?=__('Register for event', 'rise-wp-theme')?></p>

        <p><?=__('RISE members, login for fast registration', 'rise-wp-theme')?></p>

      </div>



      <!--Body-->
      <hr class="rer-hide" style="border: 1px solid #ddd; width: 100%;" />

      <div class="modal-body">

<!--        Rise form shotrcode from rise event users registration plugin here -->
        <?php do_shortcode("[rer_rise_events_registration_form]"); ?>
</div>

  </div>
</div>
</div>

<!--Event Register Form Ends-->
<?php

if(!empty($related_events)) {
    ?>
    <section class="pt-11 bg-gray100 dark-bg-text pb-11">
        <div class="custom-container ">
            <div class="events-header justify-center">
                <h2 class="events-header__title w-full text-left"><?= __('Related Events',  'rise-wp-theme') ?></h2>
            </div>
            <div class="event-section">
                <?php

                foreach ($related_events as $event) {
                    ?>
                    <event-card image="<?= $event['image'] ?>" month="<?= !empty($event['month']) ? $event['month'] : '' ?>" date="<?= !empty($event['day']) ? $event['day'] : '' ?>" color="<?= $event['members_only'] == 'Open' ? 'pink' : 'red' ?>" status="<?= $event['members_only'] ?>"
                                tag="<?= isset($event['category']['title']) ? $event['category']['title'] : '' ?>" type="<?= $event['type'] ?>" title="<?= $event['title'] ?>" href="<?= $event['link'] ?>"></event-card>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>
<footer-prefix text-color="black" image="<?= $footer_prefix_image['url'];?>" color="pink" link-title="<?= $footer_pre_link['title'];?>" href="<?= $footer_pre_link['url'];?>" text="<?= $footer_prefix;?>" card-color="#9CCBDF"></footer-prefix>

<!--<footer-prefix color="pink" link-title="Join us" card-color="orange"></footer-prefix>-->
