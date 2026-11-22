<?php
namespace DigiSolutions\AdminUI;

defined('ABSPATH') || exit;

final class Admin_UI {
    private $file;

    public function __construct($file) {
        $this->file = $file;
    }

    public function register() {
        add_filter('admin_body_class', array($this, 'body_class'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }

    private function supported() {
        $screen = get_current_screen();
        if (!$screen || !is_admin() || is_network_admin() || is_user_admin()
            || !current_user_can('manage_options')) {
            return false;
        }
        // An allowlist keeps full-screen plugin applications and editors untouched.
        return in_array($screen->base, array('dashboard', 'edit', 'upload'), true)
            && ($screen->base !== 'edit'
                || in_array($screen->post_type, array('projects', 'page', 'post'), true));
    }

    public function body_class($classes) {
        return $this->supported() ? $classes . ' dsaui-admin' : $classes;
    }

    public function enqueue() {
        if (!$this->supported()) {
            return;
        }
        $url = plugin_dir_url($this->file) . 'assets/css/';
        wp_enqueue_style('dsaui-shell', $url . 'admin-shell.css', array(), '1.0.0');
        if (get_current_screen()->base === 'dashboard') {
            wp_enqueue_style('dsaui-dashboard', $url . 'dashboard.css', array('dsaui-shell'), '1.0.0');
        }
    }
}
