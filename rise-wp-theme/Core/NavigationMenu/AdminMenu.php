<?php

namespace RiseWP\Core\NavigationMenu;


define('RISE_THEME_NAVIGATION_ADMIN_MENU', get_template_directory_uri() . '/Core/NavigationMenu');

class AdminMenu {

    public function __construct()
    {
        add_action( 'wp_nav_menu_item_custom_fields', [$this, 'menu_item_list'], 10, 2 );
        add_action('rise_wp_theme_integration_control_enqueue', function () {
            wp_enqueue_script(
                'rise-wp-theme-admin-menu-control',
                RISE_THEME_NAVIGATION_ADMIN_MENU . '/assets/menu.js',
                array('jquery'),
                _S_VERSION
            );
        });
        add_action( 'wp_update_nav_menu_item', [$this, 'save_menu_item'], 10, 2 );
        add_action( 'nav_menu_item_title', [$this, 'show_menu_item'], 10, 2 );

        add_filter('nav_menu_link_attributes', [$this, 'add_class_to_link_attributes'],  100, 3);
    }

    public function menu_item_list($item_id, $item ) {
        $menu_item_list = get_post_meta($item_id, '_rise_wp_menu_items');
        if(isset($menu_item_list[0])) {
            $menu_item_list = json_decode($menu_item_list[0], true);
        }

        ?>
        <div class="rise-wp-admin-nav-menu">
            <p class="title"><?= __('Rise Theme Setting', 'rise-wp-theme') ?></p>
            <label for="rise_wp_menu_items[<?= $item_id; ?>][link_type]" class="description"><?php _e( "Background Color Link", 'rise-wp-theme' ); ?></label><br />
            <select name="rise_wp_menu_items[<?= $item_id; ?>][link_type]" class="widefat" id="rise_wp_menu_items[<?= $item_id; ?>][icons_only]">
                <option value=""><?= __('None', 'rise-wp-theme') ?></option>
                <option value="nav-button" <?php selected($menu_item_list['link_type'], 'nav-button', true) ?>><?= __('Colored Background', 'rise-wp-theme') ?></option>
            </select>
            <label for="rise_wp_menu_items[<?= $item_id; ?>][icons_only]" class="description"><?php _e( "Show Icon Only", 'rise-wp-theme' ); ?></label><br />
            <select name="rise_wp_menu_items[<?= $item_id; ?>][icons_only]" class="rise_wp_theme_admin_nav_select widefat" id="rise_wp_menu_items[<?= $item_id; ?>][icons_only]">
                <option value="no"><?= __('No', 'rise-wp-theme') ?></option>
                <option value="yes" <?php selected($menu_item_list['icons_only'], 'yes', true) ?>><?= __('Yes', 'rise-wp-theme') ?></option>
                <option value="both" <?php selected($menu_item_list['icons_only'], 'both', true) ?>><?= __('Both text and icon', 'rise-wp-theme') ?></option>
            </select>
            <div class="rise-wp-show-icon-box" style="<?= $menu_item_list['icons_only'] === 'no' || empty($menu_item_list['icons_only'])  ? 'display: none;' : 'display: block;' ?>">
                <label for="rise_wp_menu_items[<?= $item_id; ?>][icon_content]" class="description"><?php _e( "Paste Icon", 'rise-wp-theme' ); ?> <small>(paste svg icon here)</small></label><br />
                <textarea class="widefat" id="rise_wp_menu_items[<?= $item_id; ?>][icon_content]" name="rise_wp_menu_items[<?= $item_id; ?>][icon_content]" cols="8" rows="5"><?= isset($menu_item_list['icon_content']) ? $menu_item_list['icon_content'] : ''; ?></textarea>
            </div>
        </div>
        <?php
    }


    public function save_menu_item($menu_id, $menu_item_db_id) {
        if (isset( $_POST['rise_wp_menu_items'][$menu_item_db_id])) {
            $encoded_data = json_encode($_POST['rise_wp_menu_items'][$menu_item_db_id]);
            update_post_meta( $menu_item_db_id, '_rise_wp_menu_items', $encoded_data );
        } else {
            delete_post_meta( $menu_item_db_id, '_rise_wp_menu_items' );
        }
    }

    public function show_menu_item( $title, $item ) {
        if( is_object( $item ) && isset( $item->ID ) ) {
            $menu_item_list = get_post_meta( $item->ID, '_rise_wp_menu_items', true);


            if(!empty($menu_item_list)) {
                $menu_item_list = json_decode($menu_item_list, true);
                if($menu_item_list['icons_only'] == 'yes') {
                    $title = $menu_item_list['icon_content'];
                } else if($menu_item_list['icons_only'] == 'both') {
                    $title = $menu_item_list['icon_content'].$title;
                }
            }
        }
        return $title;
    }


    public function add_class_to_link_attributes($atts, $item, $args) {
        if( is_object( $item ) && isset( $item->ID ) ) {
            $menu_item_list = get_post_meta( $item->ID, '_rise_wp_menu_items', true);

            if(!empty($menu_item_list)) {
                $menu_item_list = json_decode($menu_item_list, true);
                if($menu_item_list['link_type'] == 'nav-button') {
                    $atts['class'] = $menu_item_list['link_type'];
                }
            }
        }
        return $atts;
    }


    /**
     * Singleton poop.
     *
     * @return self
     */
    public static function get_instance() {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }
}
