<?php
namespace RiseWP\Classes;

class Customizer {

    /**
     * Constructor. Instantiate the object.
     *
     * @access public
     *
     */
    public function __construct() {
        add_action( 'customize_register', [$this, 'register']);
        add_action( 'customize_preview_init', [$this, 'rise_wp_theme_customize_preview_js']);
    }

    /**
     * Register customizer options.
     *
     * @access public
     *
     *
     * @param WP_Customize_Manager $wp_customize Theme Customizer object.
     *
     * @return void
     */
    public function register( $wp_customize ) {
        $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
        $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
        $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';



        if ( isset( $wp_customize->selective_refresh ) ) {
            $wp_customize->selective_refresh->add_partial(
                'blogname',
                array(
                    'selector'        => '.site-title a',
                    'render_callback' => [$this, 'rise_wp_theme_customize_partial_blogname'],
                )
            );
            $wp_customize->selective_refresh->add_partial(
                'blogdescription',
                array(
                    'selector'        => '.site-description',
                    'render_callback' => [$this, 'rise_wp_theme_customize_partial_blogdescription'],
                )
            );
        }

        //rise theme logos
        $wp_customize->add_setting('footer-logo');
        $wp_customize->add_control(new \WP_Customize_Image_Control($wp_customize, 'footer-logo',
            array(
                'label' => 'Footer Logo',
                'section' => 'title_tagline',
                'settings' => 'footer-logo',
            )
        ));



        $wp_customize->add_setting('custom_logo_1');
        $wp_customize->add_control(new \WP_Customize_Image_Control($wp_customize, 'custom_logo_1',
            array(
                'label' => 'Upload Second Logo',
                'section' => 'title_tagline',
                'settings' => 'custom_logo_1',
            )
        ));

        $wp_customize->add_setting('custom_logo_2');
        $wp_customize->add_control(new \WP_Customize_Image_Control($wp_customize, 'custom_logo_2',
            array(
                'label' => 'Upload Third Logo',
                'section' => 'title_tagline',
                'settings' => 'custom_logo_2',
            )
        ));

//        Contact Information Section

        $wp_customize->add_setting('rise-wp-contact-email', [
            'default' => 'info@example.co.uk',
        ]);
        $wp_customize->add_setting('rise-wp-contact-address', [
            'default' => '',
        ]);

        $wp_customize->add_section( 'rise-wp-contact-section' , array(
            'title'      => __( 'Contact Information', 'rise-wp-theme' ),
            'priority'   => 30,

        ) );

        $wp_customize->add_control(new \WP_Customize_Control(
            $wp_customize,
            'rise-wp-email-input',
            array(
                'label' => __('Email Address', 'rise-wp-theme'),
                'section' => 'rise-wp-contact-section',
                'settings' => 'rise-wp-contact-email',
                'type' => 'text',
            )
        ));

        $wp_customize->add_control(new \WP_Customize_Control(
            $wp_customize,
            'rise-wp-address',
            array(
                'label' => __('Contact Address', 'rise-wp-theme'),
                'section' => 'rise-wp-contact-section',
                'settings' => 'rise-wp-contact-address',
                'type' => 'textarea',
            )
        ));





    }

    public function rise_wp_theme_customize_partial_blogname() {
        bloginfo( 'name' );
    }

    public function rise_wp_theme_customize_partial_blogdescription() {
        bloginfo( 'description' );
    }

    public function rise_wp_theme_customize_preview_js() {
        wp_enqueue_script( 'rise-wp-theme-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
    }

    /**
     * Singleton poop.
     *
     * @return Customizer|null
     */
    public static function get_instance() {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }
}
