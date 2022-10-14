<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php

$login_images = acf_photo_gallery('galleries', get_the_ID());

?>

<section class="min-h-screen flex justify-between" id="login-form-page">
    <div class="max-w-5xl 2xl:ml-auto mr-6 sm:mr-16 2xl:mr-64">
        <div class="w-auto lg:w-full login">
            <div class="login-logo">
                <a href="<?= esc_url( home_url( '/' ) )?>" rel="home" title="<?= get_bloginfo('name', 'display') ?>">
                    <?php
                    $custom_logo_id = get_theme_mod('custom_logo');
                    $image = wp_get_attachment_image_src($custom_logo_id, 'full');
                    $title_logo = get_the_title($custom_logo_id);

                    ?>
                    <img src="<?= isset($image[0]) ? $image[0] : RISE_THEME_DEFAULT_LOGO;?>" alt="<?= get_bloginfo('name', 'display') ?>" title="<?= get_bloginfo('name', 'display') ?>">
                </a>
            </div>
            <div>
                <?php
                    if(!empty($login_images)) {
                ?>
                <div class="flex flex-wrap mt-14 gap-2 sm:gap-4">
                    <?php
                        foreach ($login_images as $login_image) {
                    ?>
                    <img src="<?= $login_image['full_image_url'] ?>" alt="<?= $login_image['title'] ?>" title="<?= $login_image['title'] ?>">
                    <?php } ?>
                </div>
                <?php } ?>
                <h3 class="font-bold text-2xl mt-12 mb-10"><?= __('Welcome back, Sign in', 'rise-wp-theme') ?><br />
                    <div class="text-red font-semibold success_message"><p>
                        <?php if ( isset( $_GET['updated'] ) && 'password_changed' == $_GET['updated'] ) {
                                echo 'Password changed. Please login to continue.';
                            }
                        ?>
                        <?php if ( isset( $_GET['err'] ) && 'invalid_nonce' == $_GET['err'] ) {
                            echo 'Invalid login credentials';
                        }
                        ?>
                        </p>
                    </div>
                </h3>
                <div class="um <?php echo esc_attr( $this->get_class( $mode ) ); ?> um-<?php echo esc_attr( $form_id ); ?>">

                    <div class="um-form">
                        <form method="post" action="" autocomplete="off" class="login-form">

                            <?php
                            /**
                             * UM hook
                             *
                             * @type action
                             * @title um_before_form
                             * @description Some actions before login form
                             * @input_vars
                             * [{"var":"$args","type":"array","desc":"Login form shortcode arguments"}]
                             * @change_log
                             * ["Since: 2.0"]
                             * @usage add_action( 'um_before_form', 'function_name', 10, 1 );
                             * @example
                             * <?php
                             * add_action( 'um_before_form', 'my_before_form', 10, 1 );
                             * function my_before_form( $args ) {
                             *     // your code here
                             * }
                             * ?>
                             */
                            do_action( 'um_rise_wp_before_form', $args );

                            /**
                             * UM hook
                             *
                             * @type action
                             * @title um_before_{$mode}_fields
                             * @description Some actions before login form fields
                             * @input_vars
                             * [{"var":"$args","type":"array","desc":"Login form shortcode arguments"}]
                             * @change_log
                             * ["Since: 2.0"]
                             * @usage add_action( 'um_before_{$mode}_fields', 'function_name', 10, 1 );
                             * @example
                             * <?php
                             * add_action( 'um_before_{$mode}_fields', 'my_before_fields', 10, 1 );
                             * function my_before_form( $args ) {
                             *     // your code here
                             * }
                             * ?>
                             */
                            do_action( "um_before_{$mode}_fields", $args );

                            /**
                             * UM hook
                             *
                             * @type action
                             * @title um_main_{$mode}_fields
                             * @description Some actions before login form fields
                             * @input_vars
                             * [{"var":"$args","type":"array","desc":"Login form shortcode arguments"}]
                             * @change_log
                             * ["Since: 2.0"]
                             * @usage add_action( 'um_before_{$mode}_fields', 'function_name', 10, 1 );
                             * @example
                             * <?php
                             * add_action( 'um_before_{$mode}_fields', 'my_before_fields', 10, 1 );
                             * function my_before_form( $args ) {
                             *     // your code here
                             * }
                             * ?>
                             */
                            do_action( "um_rise_wp_main_{$mode}_fields", $args );

                            /**
                             * UM hook
                             *
                             * @type action
                             * @title um_after_form_fields
                             * @description Some actions after login form fields
                             * @input_vars
                             * [{"var":"$args","type":"array","desc":"Login form shortcode arguments"}]
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
                            do_action( 'um_rise_wp_after_form_fields', $args );

                            /**
                             * UM hook
                             *
                             * @type action
                             * @title um_after_{$mode}_fields
                             * @description Some actions after login form fields
                             * @input_vars
                             * [{"var":"$args","type":"array","desc":"Login form shortcode arguments"}]
                             * @change_log
                             * ["Since: 2.0"]
                             * @usage add_action( 'um_after_{$mode}_fields', 'function_name', 10, 1 );
                             * @example
                             * <?php
                             * add_action( 'um_after_{$mode}_fields', 'my_after_form_fields', 10, 1 );
                             * function my_after_form_fields( $args ) {
                             *     // your code here
                             * }
                             * ?>
                             */
                            do_action( "um_rise_wp_after_{$mode}_fields", $args );

                            /**
                             * UM hook
                             *
                             * @type action
                             * @title um_after_form
                             * @description Some actions after login form fields
                             * @input_vars
                             * [{"var":"$args","type":"array","desc":"Login form shortcode arguments"}]
                             * @change_log
                             * ["Since: 2.0"]
                             * @usage add_action( 'um_after_form', 'function_name', 10, 1 );
                             * @example
                             * <?php
                             * add_action( 'um_after_form', 'my_after_form', 10, 1 );
                             * function my_after_form( $args ) {
                             *     // your code here
                             * }
                             * ?>
                             */
                            do_action( 'um_rise_wp_after_form', $args ); ?>

                        </form>
                        <p class="text-lg"><?= __('Don’t have an account?', 'rise-wp-theme') ?> <a class="text-red font-bold" href="<?= esc_url( um_get_core_page( 'register' ) ); ?>"><?= __('Join
                        RISE', 'rise-wp-theme') ?></a></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="not-elig-bg relative">
        <div class="w-full h-full min-h-screen absolute top-0 bg-gray400">
        </div>
    </div>
</section>
