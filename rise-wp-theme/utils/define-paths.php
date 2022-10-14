<?php


define('RISE_THEME_ASSETS_DIR', get_template_directory_uri() . '/assets');
define('RISE_THEME_BUNDLED_ACF_REPEATER_URI', get_template_directory_uri() . '/acf-repeater');
define('RISE_THEME_BUNDLED_ACF_REPEATER', get_template_directory() . '/acf-repeater');
define('RISE_THEME_ASSETS_ICONS_DIR', RISE_THEME_ASSETS_DIR . '/icons');
define('RISE_THEME_ASSETS_IMAGES_DIR', RISE_THEME_ASSETS_DIR . '/images');
define('RISE_THEME_PARTIAL_VIEWS', get_template_directory() . '/partials');
define('RISE_THEME_PARTIAL_MEMBERS_VIEWS', RISE_THEME_PARTIAL_VIEWS. '/members');
define('RISE_THEME_DEFAULT_LOGO', RISE_THEME_ASSETS_DIR . '/images/logo.png');
define('RISE_THEME_DASHBOARD_LOGO', RISE_THEME_ASSETS_DIR . '/images/rise_logo_sm.png');
define('RISE_THEME_DASHBOARD_FULL_LOGO', RISE_THEME_ASSETS_DIR . '/images/dashboard-new.svg');
define('RISE_THEME_SVG_COMPONENTS', RISE_THEME_PARTIAL_VIEWS . '/components/svgs');
define('RISE_THEME_ICONS_COMPONENTS', RISE_THEME_PARTIAL_VIEWS . '/components/icons');
define('RISE_THEME_PRELOADER_SVG', get_template_directory_uri() . '/img/preloader.svg');
define('RISE_THEME_API_BASE_ROUTE', 'rise-wp-theme/v1');
define('RISE_THEME_API_BASE', get_home_url().'/wp-json/'. RISE_THEME_API_BASE_ROUTE);

