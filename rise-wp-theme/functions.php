<?php
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );


/**
 * Rise OUP functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Rise_OUP
 */

require __DIR__ . '/vendor/autoload.php';



if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'rise_wp_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function rise_wp_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Rise OUP, use a find and replace
		 * to change 'rise-wp-theme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'rise-wp-theme', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

        /**
         * Add post-formats support.
         */
        add_theme_support(
            'post-formats',
            array(
                'link',
                'aside',
                'gallery',
                'image',
                'quote',
                'status',
                'video',
                'audio',
                'chat',
            )
        );

		/*
		 * Enable support for Post Thumbnails on posts and Pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 1568, 9999 );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary menu', 'rise-wp-theme' ),
                'footer'  => __( 'Secondary menu', 'rise-wp-theme' ),
                'footer-2'  => __( 'Footer Secondary menu', 'rise-wp-theme' ),
                'mobile-menu'  => __( 'Mobile menu', 'rise-wp-theme' ),
                'logged-in-menu'  => __( 'Logged In menu', 'rise-wp-theme' ),
			)
		);


//		Adds Hamburger icon to menu on mobile
        function add_last_nav_item( $items, $args ) {

            if($args->theme_location == 'primary') {
                $items .= sprintf(
                    '<button class=" nav-toggle flex flex-col items-end lg:hidden ml-7">
                        <span class="block bg-black border-2 border-black dark:border-white"></span>
                        <span class="block bg-black border-2 border-black dark:border-white"></span>
                        <span class="block bg-black border-2 border-black dark:border-white"></span>
                        </button>'
                );
            }
            return $items;
        }

        add_filter( 'wp_nav_menu_items', 'add_last_nav_item', 10, 2 );



        //add Li class to menu

        function add_classes_on_li($classes, $item, $args) {
           // if ( $args->theme_location == 'primary') {

                $classes[] = 'lg:inline-block font-semibold hover:text-red';
               return $classes;
            //}
        }

        add_filter('nav_menu_css_class','add_classes_on_li',1,3);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'rise_wp_theme_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
        $logo_width  = 250;
        $logo_height = 250;

		add_theme_support(
			'custom-logo',
			array(
				'height'                => $logo_height,
				'width'                 => $logo_width,
				'flex-width'            => true,
				'flex-height'           => true,
                'unlink-homepage-logo'  => true,
			)
		);


	}
endif;
add_action( 'after_setup_theme', 'rise_wp_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function rise_wp_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'rise_wp_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'rise_wp_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function rise_wp_theme_widgets_init() {



	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'rise-wp-theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'rise-wp-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer Area 1', 'rise-wp-theme' ),
            'id'            => 'footer-area-1',
            'description'   => esc_html__( 'Add widgets here.', 'rise-wp-theme' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer Area 2', 'rise-wp-theme' ),
            'id'            => 'footer-area-2',
            'description'   => esc_html__( 'Add widgets here.', 'rise-wp-theme' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s mt-8">',
            'after_widget' => '</div>',
            'before_title' => '<a class="widget-title block font-medium mb-7 text-gray400">',
            'after_title' => '</a>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer Area 3', 'rise-wp-theme' ),
            'id'            => 'footer-area-3',
            'description'   => esc_html__( 'Add widgets here.', 'rise-wp-theme' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s mt-8">',
            'after_widget' => '</div>',
            'before_title' => '<a class="widget-title block font-medium mb-7 text-gray400">',
            'after_title' => '</a>',
        )
    );
}
add_action( 'widgets_init', 'rise_wp_theme_widgets_init' );




/**
 * Enqueue scripts and styles.
 */
function rise_wp_theme_scripts() {
    wp_style_add_data( 'rise-wp-theme-style', 'rtl', 'replace' );
    wp_enqueue_style( 'rise-wp-theme-main-css', get_template_directory_uri().'/styles/main.css', array(), _S_VERSION );
    wp_enqueue_style( 'rise-wp-theme-custom-css', get_template_directory_uri().'/styles/custom.css', array(), _S_VERSION );
    wp_enqueue_style( 'rise-wp-theme-um-css', get_template_directory_uri().'/styles/um.css', array('rise-wp-theme-custom-css'), _S_VERSION );
    wp_enqueue_style( 'rise-wp-theme-owl-carousel-min-css', get_template_directory_uri().'/assets/owl-carousel/assets/owl.carousel.min.css', array('rise-wp-theme-custom-css'), _S_VERSION );
    wp_enqueue_style( 'rise-wp-theme-video-popup-css', get_template_directory_uri().'/styles/video.popup.css', array('rise-wp-theme-custom-css'), _S_VERSION );

    wp_enqueue_style( 'rise-wp-theme-style', get_stylesheet_uri(), array('rise-wp-theme-main-css', 'rise-wp-theme-custom-css', 'rise-wp-theme-um-css'), _S_VERSION );

    wp_enqueue_script( 'rise-wp-gsap-js', '//cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js', array('jquery'), _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-scrollTrigger-js', '//cdnjs.cloudflare.com/ajax/libs/gsap/3.4.2/ScrollTrigger.min.js', array('jquery','rise-wp-gsap-js'), _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-hero-js', get_template_directory_uri() . '/scripts/hero.js', [], _S_VERSION, true );

    wp_enqueue_script( 'rise-wp-accessibility-js', get_template_directory_uri() . '/scripts/accessibility.js', array(), _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-home-js', get_template_directory_uri() . '/scripts/home.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-home-news-js', get_template_directory_uri() . '/scripts/home-news.js', array('jquery'), _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-mobile-nav-js', get_template_directory_uri() . '/scripts/nav.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-about-js', get_template_directory_uri() . '/scripts/about.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-modal-js', get_template_directory_uri() . '/scripts/modal.js', array(), _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-um-js', get_template_directory_uri() . '/scripts/um.js', array( 'jquery', 'wp-util', 'wp-hooks', 'rise-wp-user-profile-component-js'), _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-dropdown-search-js', get_template_directory_uri() . '/scripts/dropdown-search.js', array(), _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-user-profile-js', get_template_directory_uri() . '/scripts/user-profile.js', array(), _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-connect-js', get_template_directory_uri() . '/scripts/connect.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-dashboard-js', get_template_directory_uri() . '/scripts/dashboard.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-messages-js', get_template_directory_uri() . '/scripts/messages.js', array(), _S_VERSION, true );

    wp_enqueue_script( 'rise-wp-custom-js', get_template_directory_uri() . '/scripts/custom.js', array('jquery'), _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-owl-carousel-js', get_template_directory_uri() . '/assets/owl-carousel/owl.carousel.min.js', array('jquery'), _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-video-popup-js', get_template_directory_uri() . '/scripts/video.popup.js', array('jquery'), '', false );
    wp_enqueue_script( 'rise-wp-video-player-js', get_template_directory_uri() . '/scripts/video-player.js', array(), '', false );

    wp_enqueue_script( 'rise-wp-faq-js', get_template_directory_uri() . '/scripts/faq.js', [], _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-news-tab-js', get_template_directory_uri() . '/scripts/news-tab.js', [], _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-event-card-js', get_template_directory_uri() . '/components/event-card.js', [], _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-event-hero-js', get_template_directory_uri() . '/components/event-hero.js', [], _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-footer-js', get_template_directory_uri() . '/components/footer.js', [], _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-footer-prefix-js', get_template_directory_uri() . '/components/footer-prefix.js', [], _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-news-card-js', get_template_directory_uri() . '/components/news-card.js', [], _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-accessibility-html-js', get_template_directory_uri() . '/components/accessibility.js', [], _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-custom-modal-js', get_template_directory_uri() . '/components/modal.js', array(), _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-custom-radio-js', get_template_directory_uri() . '/components/custom-radio.js', array(), _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-custom-select-js', get_template_directory_uri() . '/components/custom-select.js', array(), _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-custom-input-js', get_template_directory_uri() . '/components/custom-input.js', array(), _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-notification-js', get_template_directory_uri() . '/components/notifications.js', array(), _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-notification-item-js', get_template_directory_uri() . '/components/notification-item.js', array(), _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-dashboard-nav-js', get_template_directory_uri() . '/components/dashboard-nav.js', array(), _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-member-card-js', get_template_directory_uri() . '/components/member-card.js', array(), _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-advisors-contact-js', get_template_directory_uri() . '/components/contact-advisor.js', array(), _S_VERSION, false );
    wp_enqueue_script( 'rise-wp-user-profile-component-js', get_template_directory_uri() . '/components/user-profile.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-innovation-component-js', get_template_directory_uri() . '/components/innovation-card.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-innovation-develop-component-js', get_template_directory_uri() . '/components/develop-innovation-audit.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-knowledge-card-js', get_template_directory_uri() . '/components/knowledge-card.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-knowledge-hub-js', get_template_directory_uri() . '/components/knowledge-hub.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-opportunity-card-js', get_template_directory_uri() . '/components/opportunity-card.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-tools-template-js', get_template_directory_uri() . '/components/tools-template.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-webinar-card-js', get_template_directory_uri() . '/components/webinar-card.js', array(), _S_VERSION, true );

    wp_enqueue_script( 'rise-wp-message-box-js', get_template_directory_uri() . '/components/message-box.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-contact-js', get_template_directory_uri() . '/components/contact.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-activity-card-js', get_template_directory_uri() . '/components/activity.js', array(), _S_VERSION, true );



    wp_enqueue_script( 'rise-wp-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
    wp_enqueue_script( 'rise-wp-custom-js', get_template_directory_uri() . '/scripts/custom.js', array('jquery'), _S_VERSION, true );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'rise_wp_theme_scripts' );

function ultimate_member_script_enqueuer() {
    wp_register_script( 'rise-wp-um-js', get_template_directory_uri() . '/scripts/um.js', array('jquery', 'wp-util', 'wp-hooks'), _S_VERSION, true );
    wp_localize_script( 'rise-wp-um-js', 'rise_um_js', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
    wp_enqueue_script( 'rise-wp-um-js' );

}
add_action( 'init', 'ultimate_member_script_enqueuer' );

//load to admin interface scripts
function rise_wp_theme_admin_scripts() {
    wp_enqueue_style( 'rise-wp-theme-admin-custom-css', get_template_directory_uri().'/styles/admin.css', array(), _S_VERSION );
    wp_enqueue_script( 'rise-wp-select2-scripts', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array(), _S_VERSION, true );
    wp_enqueue_style( 'rise-wp-select2-styles', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', array(), _S_VERSION );
    wp_enqueue_script( 'rise-wp-theme-admin-custom-js', get_template_directory_uri() . '/scripts/admin.js', array('jquery', 'rise-wp-select2-scripts'), _S_VERSION, true );

    do_action('rise_wp_theme_integration_control_enqueue');
}
add_action( 'admin_enqueue_scripts', 'rise_wp_theme_admin_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

// Menu functions and filters.
require get_template_directory() . '/inc/menu-functions.php';

/**
 * Custom Customizer.
 */
//require get_template_directory() . '/inc/customizer.php';
new \RiseWP\Classes\Customizer();

/**
 * Require Custom Functions
 *
 */


require get_template_directory() . '/utils/custom_functions.php';

//define the constant variables
require get_template_directory() . '/utils/constants.php';

//define paths
require get_template_directory() . '/utils/define-paths.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Initialize admin core files
 */
\RiseWP\Core\Init::init();
\RiseWP\Api\Init::init();

function fix_post_id_on_preview($null, $post_id) {
    if (is_preview()) {
        return get_the_ID();
    }
}
add_filter( 'acf/pre_load_post_id', 'fix_post_id_on_preview', 10, 2 );