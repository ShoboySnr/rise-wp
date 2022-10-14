<?php if ( ! defined( 'ABSPATH' ) ) exit;

//check if the current signed user is not the owner of this profile and also allow to see the admin
$author_meta_data = get_userdata(um_profile_id());
$author_roles = $author_meta_data->roles;
if (um_profile_id() != get_current_user_id() && in_array('administrator', $author_roles)) {
    wp_redirect('/dashboard');
}

if(isset($_GET['profiletab']) && $_GET['profiletab'] == 'messages') {
    wp_redirect('/messages');
}

$nonce = wp_create_nonce("um_user_bookmarks_new_bookmark");
?>

<!-- remove um class -->
<div class="<?php echo esc_attr( $this->get_class( $mode ) ); ?> um-<?php echo esc_attr( $form_id ); ?> um-role-<?php echo esc_attr( um_user( 'role' ) ); ?> ">

    <!-- remove um-form class -->
    <div class="" data-mode="<?php echo esc_attr( $mode ) ?>">
        <div class="h-full overflow-scroll bg-gray100 dark:bg-black ml-auto" >
            <div class="mx-auto md:pl-24 w-5/6 mb-16">
        <?php
        /**
         * UM hook
         *
         * @type action
         * @title um_profile_before_header
         * @description Some actions before profile form header
         * @input_vars
         * [{"var":"$args","type":"array","desc":"Profile form shortcode arguments"}]
         * @change_log
         * ["Since: 2.0"]
         * @usage add_action( 'um_profile_before_header', 'function_name', 10, 1 );
         * @example
         * <?php
         * add_action( 'um_profile_before_header', 'my_profile_before_header', 10, 1 );
         * function my_profile_before_header( $args ) {
         *     // your code here
         * }
         * ?>
         */
        do_action( 'um_profile_before_header', $args );
    
            if ( um_is_on_edit_profile() ) { ?>
        <form method="post" action="">
            <?php }

            /**
             * UM hook
             *
             * @type action
             * @title um_profile_header_cover_area
             * @description Profile header cover area
             * @input_vars
             * [{"var":"$args","type":"array","desc":"Profile form shortcode arguments"}]
             * @change_log
             * ["Since: 2.0"]
             * @usage add_action( 'um_profile_header_cover_area', 'function_name', 10, 1 );
             * @example
             * <?php
             * add_action( 'um_profile_header_cover_area', 'my_profile_header_cover_area', 10, 1 );
             * function my_profile_header_cover_area( $args ) {
             *     // your code here
             * }
             * ?>
             */
            do_action( 'um_profile_header_cover_area', $args );

            /**
             * UM hook
             *
             * @type action
             * @title um_profile_header
             * @description Profile header area
             * @input_vars
             * [{"var":"$args","type":"array","desc":"Profile form shortcode arguments"}]
             * @change_log
             * ["Since: 2.0"]
             * @usage add_action( 'um_profile_header', 'function_name', 10, 1 );
             * @example
             * <?php
             * add_action( 'um_profile_header', 'my_profile_header', 10, 1 );
             * function my_profile_header( $args ) {
             *     // your code here
             * }
             * ?>
             */
            do_action( 'um_profile_header', $args );

            /**
             *
             * Show More Users Information
             */
            do_action('rise_wp_profile_users_information', $args);

            /**
             * UM hook
             *
             * @type filter
             * @title um_profile_navbar_classes
             * @description Additional classes for profile navbar
             * @input_vars
             * [{"var":"$classes","type":"string","desc":"UM Posts Tab query"}]
             * @change_log
             * ["Since: 2.0"]
             * @usage
             * <?php add_filter( 'um_profile_navbar_classes', 'function_name', 10, 1 ); ?>
             * @example
             * <?php
             * add_filter( 'um_profile_navbar_classes', 'my_profile_navbar_classes', 10, 1 );
             * function my_profile_navbar_classes( $classes ) {
             *     // your code here
             *     return $classes;
             * }
             * ?>
             */
            $classes = apply_filters( 'um_profile_navbar_classes', '' ); ?>

            <div class="um-profile-navbar <?php echo esc_attr( $classes ); ?>">
                <?php
                /**
                 * UM hook
                 *
                 * @type action
                 * @title um_profile_navbar
                 * @description Profile navigation bar
                 * @input_vars
                 * [{"var":"$args","type":"array","desc":"Profile form shortcode arguments"}]
                 * @change_log
                 * ["Since: 2.0"]
                 * @usage add_action( 'um_profile_navbar', 'function_name', 10, 1 );
                 * @example
                 * <?php
                 * add_action( 'um_profile_navbar', 'my_profile_navbar', 10, 1 );
                 * function my_profile_navbar( $args ) {
                 *     // your code here
                 * }
                 * ?>
                 */
                //do_action( 'um_profile_navbar', $args ); ?>
                <div class="um-clear"></div>
            </div>

            <?php
            /**
             * UM hook
             *
             * @type action
             * @title um_profile_menu
             * @description Profile menu
             * @input_vars
             * [{"var":"$args","type":"array","desc":"Profile form shortcode arguments"}]
             * @change_log
             * ["Since: 2.0"]
             * @usage add_action( 'um_profile_menu', 'function_name', 10, 1 );
             * @example
             * <?php
             * add_action( 'um_profile_menu', 'my_profile_navbar', 10, 1 );
             * function my_profile_navbar( $args ) {
             *     // your code here
             * }
             * ?>
             */
            //do_action( 'um_profile_menu', $args );

            if ( um_is_on_edit_profile() || UM()->user()->preview ) {

            $nav = 'main';
            $subnav = UM()->profile()->active_subnav();
            $subnav = ! empty( $subnav ) ? $subnav : 'default'; ?>

            <div class="um-profile-body <?php echo esc_attr( $nav . ' ' . $nav . '-' . $subnav ); ?>">

                <?php
                /**
                 * UM hook
                 *
                 * @type action
                 * @title um_profile_content_{$nav}
                 * @description Custom hook to display tabbed content
                 * @input_vars
                 * [{"var":"$args","type":"array","desc":"Profile form shortcode arguments"}]
                 * @change_log
                 * ["Since: 2.0"]
                 * @usage add_action( 'um_profile_content_{$nav}', 'function_name', 10, 1 );
                 * @example
                 * <?php
                 * add_action( 'um_profile_content_{$nav}', 'my_profile_content', 10, 1 );
                 * function my_profile_content( $args ) {
                 *     // your code here
                 * }
                 * ?>
                 */
                do_action("um_profile_content_{$nav}", $args);

                /**
                 * UM hook
                 *
                 * @type action
                 * @title um_profile_content_{$nav}_{$subnav}
                 * @description Custom hook to display tabbed content
                 * @input_vars
                 * [{"var":"$args","type":"array","desc":"Profile form shortcode arguments"}]
                 * @change_log
                 * ["Since: 2.0"]
                 * @usage add_action( 'um_profile_content_{$nav}_{$subnav}', 'function_name', 10, 1 );
                 * @example
                 * <?php
                 * add_action( 'um_profile_content_{$nav}_{$subnav}', 'my_profile_content', 10, 1 );
                 * function my_profile_content( $args ) {
                 *     // your code here
                 * }
                 * ?>
                 */
                do_action( "um_profile_content_{$nav}_{$subnav}", $args ); ?>

                <div class="clear"></div>
            </div>

            <?php if ( ! UM()->user()->preview ) { ?>

        </form>

    <?php }
    } else {
        $menu_enabled = UM()->options()->get( 'profile_menu' );
        $tabs = UM()->profile()->tabs_active();

        $nav = UM()->profile()->active_tab();
        $subnav = UM()->profile()->active_subnav();
        $subnav = ! empty( $subnav ) ? $subnav : 'default';

        if ( $menu_enabled || ! empty( $tabs[ $nav ]['hidden'] ) ) { ?>

            <div class="um-profile-body <?php echo esc_attr( $nav . ' ' . $nav . '-' . $subnav ); ?>">

                <?php
                // Custom hook to display tabbed content
                /**
                 * UM hook
                 *
                 * @type action
                 * @title um_profile_content_{$nav}
                 * @description Custom hook to display tabbed content
                 * @input_vars
                 * [{"var":"$args","type":"array","desc":"Profile form shortcode arguments"}]
                 * @change_log
                 * ["Since: 2.0"]
                 * @usage add_action( 'um_profile_content_{$nav}', 'function_name', 10, 1 );
                 * @example
                 * <?php
                 * add_action( 'um_profile_content_{$nav}', 'my_profile_content', 10, 1 );
                 * function my_profile_content( $args ) {
                 *     // your code here
                 * }
                 * ?>
                 */
                do_action("um_profile_content_{$nav}", $args);

                /**
                 * UM hook
                 *
                 * @type action
                 * @title um_profile_content_{$nav}_{$subnav}
                 * @description Custom hook to display tabbed content
                 * @input_vars
                 * [{"var":"$args","type":"array","desc":"Profile form shortcode arguments"}]
                 * @change_log
                 * ["Since: 2.0"]
                 * @usage add_action( 'um_profile_content_{$nav}_{$subnav}', 'function_name', 10, 1 );
                 * @example
                 * <?php
                 * add_action( 'um_profile_content_{$nav}_{$subnav}', 'my_profile_content', 10, 1 );
                 * function my_profile_content( $args ) {
                 *     // your code here
                 * }
                 * ?>
                 */
                do_action( "um_profile_content_{$nav}_{$subnav}", $args ); ?>

                <div class="clear"></div>
            </div>

        <?php }
    }

    do_action( 'um_profile_footer', $args ); ?>
            </div>
        </div>
    </div>
    <?php
    /**
     * Attach all Edit Profile Modals
     */
    do_action('rise_wp_profile_modal_popup')
    ?>
</div>
