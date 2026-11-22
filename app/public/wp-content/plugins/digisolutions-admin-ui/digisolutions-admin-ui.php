<?php
/**
 * Plugin Name: DigiSolutions Admin UI
 * Description: DigiSolutions login presentation and admin menu cleanup.
 * Version: 1.0.0
 * Requires PHP: 7.4
 * Text Domain: digisolutions-admin-ui
 */
namespace DigiSolutions\AdminUI;

defined('ABSPATH') || exit;

// Login presentation is separate from the existing admin-only initialization.
add_action('login_enqueue_scripts', static function () {
    if (($GLOBALS['pagenow'] ?? '') !== 'wp-login.php') {
        return;
    }
    wp_enqueue_style(
        'dsaui-login',
        plugin_dir_url(__FILE__) . 'assets/css/login.css',
        array('login'),
        '1.0.1'
    );
    add_filter('login_body_class', static function ($classes) {
        $classes[] = 'dsaui-login';
        return $classes;
    });
    add_filter('login_headertext', static function ($text) {
        return __('DigiSolutions', 'digisolutions-admin-ui');
    });
    add_filter('login_headerurl', static function ($url) {
        return home_url('/');
    });
    add_filter('login_message', static function ($message) {
        $logo_url = 'http://digi-solutions.local/wp-content/uploads/2026/11/digisolutions-full-logo-tight.png';
        return $message . '<div class="dsaui-login-logo"><img src="' . esc_url($logo_url) . '" alt="DigiSolutions"></div>';
    });
});

add_action('plugins_loaded', static function () {
    if (!is_admin() || wp_doing_ajax() || wp_doing_cron()
        || (defined('REST_REQUEST') && REST_REQUEST)
        || (defined('WP_CLI') && WP_CLI)) {
        return;
    }
    // Remove only the custom top-level menu registered by Digi Solutions Manager.
    add_action('admin_menu', static function () {
        remove_menu_page('digisolutions-dashboard');
    }, 999);
});
