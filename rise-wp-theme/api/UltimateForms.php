<?php

namespace RiseWP\Api;


class UltimateForms {

    public function __construct()
    {
        add_action('um_rise_wp_before_form', [$this, 'before_all_ultimate_member_form_fields'], 10, 1);
        $um_priority = apply_filters( 'um_core_enqueue_priority', 10 );
        add_action( 'wp_enqueue_scripts',  [$this, 'remove_default_ultimate_styles'], $um_priority + 1);

    }



    public function remove_default_ultimate_styles() {
        wp_dequeue_style('um_default_css');
        wp_dequeue_style('um_responsive');
        wp_dequeue_style('um_styles');
        wp_dequeue_style('um_profile');
        wp_dequeue_style('um_account');
        wp_dequeue_style('um_members');
        wp_dequeue_style('um_styles');
        wp_dequeue_style('um_misc');
        wp_dequeue_style('um_old_default_css');
        wp_dequeue_style('um_old_css');
        wp_dequeue_script( 'um_notifications' );
        wp_dequeue_style( 'um_notifications' );

    }

    public function before_all_ultimate_member_form_fields($args) {
        ?>
        <!-- Preloader -->
        <div class="preloader" style="display: none">
            <img src="<?= RISE_THEME_PRELOADER_SVG ?>" alt="preloader" />
        </div>
    <?php
    }

    public function get_first_last_names($name)
    {
        $data = [];

        $names = explode(' ', $name);

        if (isset($names[0])) {
            $data[] = trim($names[0]);
            unset($names[0]);
        }

        if(isset($names[1])) {
            $data[] = trim($names[1]);
            unset($names[1]);
        }


        $data[] = implode(' ', $names);

        return $data;
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
