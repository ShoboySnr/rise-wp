<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php

$login_images = acf_photo_gallery('galleries', get_the_ID());

?>
<section class="min-h-screen flex justify-between" id="password-reset-form">
    <div class="max-w-5xl 2xl:ml-auto mr-6 sm:mr-16 2xl:mr-64">
        <div class="w-auto lg:w-full<?= !empty($_GET['updated']) && 'checkemail' == $_GET['updated'] ?  '' : ' login'; ?>">
            <div class="<?= !empty($_GET['updated']) && 'checkemail' == $_GET['updated'] ? 'not-elig-logo-parent' : 'login-logo'; ?>">
                <?php

                if ( isset( $_GET['updated'] ) && 'checkemail' == $_GET['updated'] ) {
                ?>
                <div class="not-elig-logo">
                    <?php } ?>
                    <a href="<?= esc_url( home_url( '/' ) )?>" rel="home" title="<?= get_bloginfo('name', 'display') ?>">
                        <?php
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $image = wp_get_attachment_image_src($custom_logo_id, 'full');
                        $title_logo = get_the_title($custom_logo_id);

                        ?>
                        <img src="<?= isset($image[0]) ? $image[0] : RISE_THEME_DEFAULT_LOGO;?>" alt="<?= get_bloginfo('name', 'display') ?>" title="<?= get_bloginfo('name', 'display') ?>">
                    </a>
                    <?php

                    if ( isset( $_GET['updated'] ) && 'checkemail' == $_GET['updated'] ) {
                    ?>
                </div>
                        <?php } ?>
            </div>
            <?php if ( isset( $_GET['updated'] ) && 'checkemail' == $_GET['updated'] ) { ?>
                <div class="pl-6 sm:pl-12 lg:pl-40 pb-20">
                    <div class="not-elig-content mt-8 mx-auto pr-0 sm:pr-8 flex items-center flex-col">
                        <img src="<?= get_template_directory_uri().'/assets/images/email-confirm.png' ?>" alt="">
                        <h4 class="font-bold text-center text-2xl mt-20 mb-11"><?= __('Check your Email Inbox', 'rise-wp-theme') ?></h4>
                        <p class="text-lg text-center"><?= __('If account exists, an email has been sent with the
                                            recovery link and further instructions', 'rise-wp-theme') ?></p>
                    </div>
                </div>
            <?php } else { ?>
            <div>
                <?php
                    if(!empty($login_images)) {
                ?>
                <div class="flex flex-wrap mt-14 gap-2 sm:gap-4">
                    <?php
                    foreach ($login_images as $login_image) {
                    ?>
                        <img src="<?= $login_image['full_image_url'] ?>" alt="<?= $login_image['title'] ?>" title="<?= $login_image['title'] ?>" style="height: 52px;">
                    <?php } ?>
                </div>
                <?php } ?>
                <h3 class="font-bold text-2xl mt-12 mb-10"><?= __('Reset your password', 'rise-wp-theme') ?>
                    <div class="text-red font-semibold success_message"><p>
                            <?php if ( isset( $_GET['err'] ) && 'invalid_nonce' == $_GET['err'] ) {
                                echo 'Invalid login credentials';
                            }
                            ?></p>
                    </div>
                </h3>
                <div class="um <?php echo esc_attr( $this->get_class( $mode ) ); ?> um-<?php echo esc_attr( $form_id ); ?>">
                    <div class="um-form">
                        <form method="post" class="login-form" action="">
                            <?php
                                //load this action before all ultimate forms
                                do_action( 'um_rise_wp_before_form', $args );
                            ?>
                                <input type="hidden" name="_um_password_reset" id="_um_password_reset" value="1" />

                                <?php
                                /**
                                 * UM hook
                                 *
                                 * @type action
                                 * @title um_reset_password_page_hidden_fields
                                 * @description Password reset hidden fields
                                 * @input_vars
                                 * [{"var":"$args","type":"array","desc":"Password reset shortcode arguments"}]
                                 * @change_log
                                 * ["Since: 2.0"]
                                 * @usage add_action( 'um_reset_password_page_hidden_fields', 'function_name', 10, 1 );
                                 * @example
                                 * <?php
                                 * add_action( 'um_reset_password_page_hidden_fields', 'my_reset_password_page_hidden_fields', 10, 1 );
                                 * function my_reset_password_page_hidden_fields( $args ) {
                                 *     // your code here
                                 * }
                                 * ?>
                                 */
                                do_action( 'um_reset_password_page_hidden_fields', $args );

                                if ( ! empty( $_GET['updated'] ) ) { ?>
                                    <div class="um-field um-field-block um-field-type_block">
                                        <div class="um-field-block">
                                            <div class="text-red">
                                                <?php if ( 'expiredkey' == $_GET['updated'] ) {
                                                    _e( 'Your password reset link has expired. Please request a new link below.', 'rise-wp-theme' );
                                                } elseif ( 'invalidkey' == $_GET['updated'] ) {
                                                    _e( 'Your password reset link appears to be invalid. Please request a new link below.', 'rise-wp-theme' );
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="um-field um-field-block um-field-type_block">
                                        <div class="um-field-block">
                                            <div class="dark:text-white text-black">
                                                <?php // _e( 'To reset your password, please enter your email address or username below', 'ultimate-member' ); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <span class="text-red username-error error" style="display: none"><?= __('Enter your email address or username to reset password', 'rise-wp-theme') ?></span>
                                <input type="text" name="username" id="" placeholder="Email address or username">

                                <?php
//                                $fields = UM()->builtin()->get_specific_fields( 'username_b' );
//
//                                $output = null;
//                                foreach ( $fields as $key => $data ) {
//                                    $output .= UM()->fields()->edit_field( $key, $data );
//                                }
//                                echo $output;

                                /**
                                 * UM hook
                                 *
                                 * @type action
                                 * @title um_after_password_reset_fields
                                 * @description Hook that runs after user reset their password
                                 * @input_vars
                                 * [{"var":"$args","type":"array","desc":"Form data"}]
                                 * @change_log
                                 * ["Since: 2.0"]
                                 * @usage add_action( 'um_after_password_reset_fields', 'function_name', 10, 1 );
                                 * @example
                                 * <?php
                                 * add_action( 'um_after_password_reset_fields', 'my_after_password_reset_fields', 10, 1 );
                                 * function my_after_password_reset_fields( $args ) {
                                 *     // your code here
                                 * }
                                 * ?>
                                 */
                                do_action( 'um_after_password_reset_fields', $args ); ?>

                                <button class="flex items-center justify-center border-2 hover:bg-white hover:text-red text-white bg-red my-8 text-lg font-medium"
                                        type="submit"><?= __('Email me a recovery link', 'rise-wp-theme') ?></button>
                                <a class="block text-center text-lg underline text-black dark:text-white font-bold" href="<?= esc_url( um_get_core_page( 'login' ) ); ?>"><?= __('Login', 'rise-wp-theme') ?></a>

                                <div class="um-clear"></div>
                                <?php
                                /**
                                 * UM hook
                                 *
                                 * @type action
                                 * @title um_reset_password_form
                                 * @description Password reset display form
                                 * @input_vars
                                 * [{"var":"$args","type":"array","desc":"Password reset shortcode arguments"}]
                                 * @change_log
                                 * ["Since: 2.0"]
                                 * @usage add_action( 'um_reset_password_form', 'function_name', 10, 1 );
                                 * @example
                                 * <?php
                                 * add_action( 'um_reset_password_form', 'my_reset_password_form', 10, 1 );
                                 * function my_reset_password_form( $args ) {
                                 *     // your code here
                                 * }
                                 * ?>
                                 */
                                do_action( 'um_reset_password_form', $args );

                                /**
                                 * UM hook
                                 *
                                 * @type action
                                 * @title um_after_form_fields
                                 * @description Password reset after display form
                                 * @input_vars
                                 * [{"var":"$args","type":"array","desc":"Password reset shortcode arguments"}]
                                 * @change_log
                                 * ["Since: 2.0"]
                                 * @usage add_action( 'um_after_form_fields', 'function_name', 10, 1 );
                                 * @example
                                 * <?php
                                 * add_action( 'um_after_form_fields', 'my_after_form_fields', 10, 1 );
                                 * function my_after_form_fields( $args ) {
                                 *     // your code here
                                 * }
                                 * ?>
                                 */
                                do_action( 'um_after_form_fields', $args );
                             ?>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="not-elig-bg relative">
        <!-- <img class="h-full min-h-screen w-full object-cover" src="./assets/images/not-elig-bg.png" alt=""> -->
        <div class="w-full h-full min-h-screen absolute top-0 bg-gray400">
        </div>
    </div>
</section>
