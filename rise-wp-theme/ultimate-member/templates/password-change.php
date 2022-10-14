<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php

$login_images = acf_photo_gallery('galleries', get_the_ID());
?>
<section class="min-h-screen flex justify-between" id="password-change-form">
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
                <div class="um <?php echo esc_attr( $this->get_class( $mode ) ); ?> um-<?php echo esc_attr( $form_id ); ?>">

    <div class="um-form">
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
                <span class="text-red font-semibold success_message"><p>
                        <?php if ( isset( $_GET['err'] ) && 'invalid_nonce' == $_GET['err'] ) {
                            echo 'Invalid login credentials';
                        }
                        ?></p>
                </span>
            </h3>
        </div>
        <form method="post" action="" class="login-form">
            <input type="hidden" name="_um_password_change" id="_um_password_change" value="1" />
            <input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $args['user_id'] ); ?>" />
            <input type="hidden" name="rp_key" value="<?php echo esc_attr( $rp_key ); ?>" />
            <input type="hidden" name="page_id" value="<?php echo get_the_ID() ?>" />

            <?php
            /**
             * UM hook
             *
             * @type action
             * @title um_change_password_page_hidden_fields
             * @description Password change hidden fields
             * @input_vars
             * [{"var":"$args","type":"array","desc":"Password change shortcode arguments"}]
             * @change_log
             * ["Since: 2.0"]
             * @usage add_action( 'um_change_password_page_hidden_fields', 'function_name', 10, 1 );
             * @example
             * <?php
             * add_action( 'um_change_password_page_hidden_fields', 'my_change_password_page_hidden_fields', 10, 1 );
             * function my_change_password_page_hidden_fields( $args ) {
             *     // your code here
             * }
             * ?>
             */
            do_action( 'um_change_password_page_hidden_fields', $args );

            $fields = UM()->builtin()->get_specific_fields( 'user_password' );

            UM()->fields()->set_mode = 'password';

            $output = null;
            foreach ( $fields as $key => $data ) {
                $output .= UM()->fields()->edit_field( $key, $data );
            }
            // do not echo the fields from ultimate member so it can be overwritten
//            echo $output; ?>
            <span class="text-red password-error error" style="display: none"><?= __('Enter your new password', 'rise-wp-theme') ?></span>
            <input type="password" name="password" id="password" placeholder="<?= __('Enter your new password', 'rise-wp-theme') ?>">

            <span class="text-red c_password-error error" style="display: none"><?= __('Confirm password cannot be empty', 'rise-wp-theme') ?></span>
            <input type="password" name="c_password" id="c_password" placeholder="<?= __('Confirm your new password', 'rise-wp-theme') ?>" data-key="confirm_user_password">
            <button class="flex items-center justify-center border-2 hover:bg-white hover:text-red text-white bg-red my-8 text-lg font-medium"
                    type="submit"><?= __('Reset password', 'rise-wp-theme') ?></button>
            <a class="block text-center text-lg underline text-black dark:text-white font-bold" title="<?= __('Login', 'rise-wp-theme') ?>" href="<?= esc_url( um_get_core_page( 'login' ) ); ?>"><?= __('Login', 'rise-wp-theme') ?></a>
            <?php

            /**
             * UM hook
             *
             * @type action
             * @title um_change_password_form
             * @description Password change form content
             * @input_vars
             * [{"var":"$args","type":"array","desc":"Password change shortcode arguments"}]
             * @change_log
             * ["Since: 2.0"]
             * @usage add_action( 'um_change_password_form', 'function_name', 10, 1 );
             * @example
             * <?php
             * add_action( 'um_change_password_form', 'my_change_password_form', 10, 1 );
             * function my_change_password_form( $args ) {
             *     // your code here
             * }
             * ?>
             */
            do_action( 'um_change_password_form', $args );

            /**
             * UM hook
             *
             * @type action
             * @title um_after_form_fields
             * @description Password change after form content
             * @input_vars
             * [{"var":"$args","type":"array","desc":"Password change shortcode arguments"}]
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
            do_action( 'um_after_form_fields', $args ); ?>
        </form>
    </div>
</div>

        </div>
    </div>
    <div class="not-elig-bg relative">
        <!-- <img class="h-full min-h-screen w-full object-cover" src="./assets/images/not-elig-bg.png" alt=""> -->
        <div class="w-full h-full min-h-screen absolute top-0 bg-gray400">
        </div>
    </div>
</section>
