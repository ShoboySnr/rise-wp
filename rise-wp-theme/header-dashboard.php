<?php

//redirect user if not logged in
if ( ! is_user_logged_in() ) {
    wp_redirect(um_get_core_page( 'login' ));
    exit;
}

$custom_logo_id = get_theme_mod('custom__dashboard_logo');
$image = wp_get_attachment_image_src($custom_logo_id, 'full');
$title_logo = get_the_title($custom_logo_id);
$advisors_contactform = get_field('advisors_contact_form', get_page_by_path('dashboard'));

//get the lists of menus
$loggedin_nav = wp_nav_menu([
        'theme_location' => 'logged-in-menu',
        'echo'      => false,
        'walker'    => new \RiseWP\Core\NavigationMenu\LoggedInWalker()
    ]
);

?>
<!doctype html>
<html <?php language_attributes(); ?> >
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">


    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <!-- preloader -->
    <div class="preloader" style="display: none">
        <img src="<?= RISE_THEME_PRELOADER_SVG ?>" alt="preloader" />
    </div>
    <!-- end preloader -->
    <contact-modal contactform='<?= do_shortcode($advisors_contactform); ?>' form_title="<?=__('Contact advisor', 'rise-wp-theme');?>"></contact-modal>
<!-- Taking this accessibility form temporary until the UI is fixed -->
<!--        <accessibility-nav>-->
<!--    </accessibility-nav>-->
    <user-profile data-nonce="<?= wp_create_nonce("um_user_bookmarks_new_bookmark"); ?>"></user-profile>
<div class="dashboard-wrapper">
<!--    <button type="button" id="accessibility-btn" class="accessibility-btn">-->
<!--        <img src="--><?//= RISE_THEME_ASSETS_IMAGES_DIR ?><!--/accessibility.svg" alt="open accessibility">-->
<!--    </button>-->
    <dashboard-nav loggedin_nav='<?= $loggedin_nav ?>' logo_sm="<?= isset($image[0]) ? $image[0] : RISE_THEME_DASHBOARD_FULL_LOGO;?>" home_url="<?= get_home_url();?>"></dashboard-nav>
    <section class="dashboard-container">
        <nav class="dashboard-top-nav">
            <div class="dashboard-top-nav__sm">
                <button id="hamburger" class=" nav-toggle flex flex-col items-end lg:hidden" style="transform: rotate(180deg);margin-top: 15px;">
                    <span class="block bg-black border-2 border-black dark:border-white"></span>
                    <span class="block bg-black border-2 border-black dark:border-white"></span>
                    <span class="block bg-black border-2 border-black dark:border-white"></span>
                </button>
                <div class="">
                    <a href="<?= esc_url( home_url( '/' ) )?>" rel="home" title="<?= get_bloginfo('name', 'display') ?>">
                        <img src="<?= isset($image[0]) ? $image[0] : RISE_THEME_DASHBOARD_FULL_LOGO;?>" alt="<?= get_bloginfo('name', 'display') ?>" title="<?= get_bloginfo('name', 'display') ?>" />
                    </a>
                </div>
            </div>
            <?php echo do_shortcode('[rise_wp_general_search]'); ?>
            <ul class="right-nav-options">
                <li>
                    <?= do_shortcode('[ultimatemember_notifications_button]'); ?>
                </li>
                <li>

                    <a href="<?= get_permalink(get_page_by_path('messages')) ?>" title="Messages" class="relative">
                        <img src="<?= RISE_THEME_ASSETS_IMAGES_DIR ?>/bulk-message.svg" alt="bulk message">
                        <?php
                          $unread_count = UM()->Messaging_API()->api()->get_unread_count(get_current_user_id());
                         if($unread_count > 0) {
                        ?>
                        <span class="um-messages-live-count" style="display: inline;"><?= $unread_count ?></span>
                        <?php } ?>
                    </a>
                </li>

                <li class="rise-wp-popupcover">
                  <a href="<?php echo esc_url(um_user_profile_url(get_current_user_id()));?>">
                            <span class="h-12 rounded-full">
								<img src="<?php echo get_avatar_url(get_current_user_id(), ['size' => 64]) ?>" alt="<?= um_user('display_name') ?>" title="<?= um_user('display_name') ?>" class="h-12 rounded-full" />
							</span>
                  </a>
                  <button type="button" class="profile-btn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M12 15.713L18.01 9.70296L16.597 8.28796L12 12.888L7.40399 8.28796L5.98999 9.70196L12 15.713Z"
                        fill="#FF671F" />
                    </svg>
                  </button>

                    <ul class="profile-options">
                        <li class="profile-option">
                            <a href="<?= add_query_arg(['um_action' => 'edit'], um_user_profile_url(get_current_user_id())); ?>">
                                <?= __('Edit profile', 'rise-wp-theme') ?>
                            </a>
                        </li>
                        <?php

                        if(!empty(get_page_by_path('accounts-settings')->post_title)) {
                        ?>
                        <li class="profile-option">
                            <a href="<?= get_permalink(get_page_by_path('accounts-settings')) ?>"><?= get_page_by_path('accounts-settings')->post_title ?></a>
                        </li>
                        <?php }

                        if(!empty(get_page_by_path('contact-us')->post_title)) {
                        ?>
                        <li class="profile-option">
                            <a href="<?= get_permalink(get_page_by_path('contact-us')) ?>" title=""><?= get_page_by_path('contact-us')->post_title ?></a>
                        </li>
                        <?php
                        }
                        ?>
                        <li class="profile-option">
                            <a href="<?= esc_url( um_get_core_page( 'logout' ) ); ?>"><?= __('Log out', 'rise-wp-theme') ?></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </section>
</div>
