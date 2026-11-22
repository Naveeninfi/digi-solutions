
<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme version
 */
define('DIGISOLUTIONS_VERSION', '1.0.0');

/**
 * Theme setup
 */
function digisolutions_setup() {

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 250,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'digisolutions'),
    ));
}
add_action('after_setup_theme', 'digisolutions_setup');


/**
 * Load theme CSS and JavaScript
 */
function digisolutions_assets() {

    wp_enqueue_style(
        'digisolutions-style',
        get_stylesheet_directory_uri() . '/assets/css/main.css',
        array(),
        DIGISOLUTIONS_VERSION
    );

    wp_enqueue_script(
        'digisolutions-main',
        get_stylesheet_directory_uri() . '/assets/js/main.js',
        array(),
        DIGISOLUTIONS_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'digisolutions_assets');


/**
 * Hide admin bar for users who are not administrators
 */
function digisolutions_hide_admin_bar() {

    if (!current_user_can('manage_options')) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'digisolutions_hide_admin_bar');
