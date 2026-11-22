<?php
if (!defined('ABSPATH')) exit;

define('TECHSOLUTIONS_VERSION', '1.0.0');

function digisolutions_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    // Custom Header Logo Support
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
        'script'
    ));

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'digisolutions')
    ));
}
add_action('after_setup_theme', 'digisolutions_setup');

function digisolutions_assets() {
    wp_enqueue_style('digisolutions-style', get_stylesheet_directory_uri() . '/assets/css/main.css', array(), TECHSOLUTIONS_VERSION);
    wp_enqueue_script('digisolutions-main', get_stylesheet_directory_uri() . '/assets/js/main.js', array(), TECHSOLUTIONS_VERSION, true);
}
add_action('wp_enqueue_scripts', 'digisolutions_assets');

function digisolutions_register_content() {
    register_post_type('portfolio', array(
        'labels' => array('name' => 'Portfolio Projects', 'singular_name' => 'Portfolio Project', 'add_new_item' => 'Add New Project', 'edit_item' => 'Edit Project'),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'portfolio'),
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
        'show_in_rest' => true,
    ));
    register_taxonomy('portfolio_category', 'portfolio', array(
        'labels' => array('name' => 'Project Categories', 'singular_name' => 'Project Category'),
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'project-category'),
    ));
}
add_action('init', 'digisolutions_register_content');

function digisolutions_add_roles() {
    if (!get_role('portfolio_editor')) {
        add_role('portfolio_editor', 'Portfolio Editor', array(
            'read' => true,
            'upload_files' => true,
            'edit_portfolio' => true,
            'edit_portfolios' => true,
            'edit_published_portfolios' => true,
            'publish_portfolios' => false,
            'delete_portfolios' => false,
        ));
    }
}
add_action('init', 'digisolutions_add_roles');

function digisolutions_page_url($slug) {
    $page = get_page_by_path($slug);
    return $page ? get_permalink($page) : home_url('/' . trim($slug, '/') . '/');
}

function digisolutions_login_redirect($redirect_to, $request, $user) {
    if (is_object($user) && !is_wp_error($user)) return digisolutions_page_url('dashboard');
    return $redirect_to;
}
add_filter('login_redirect', 'digisolutions_login_redirect', 10, 3);

function digisolutions_hide_admin_bar() {
    if (!current_user_can('manage_options')) show_admin_bar(false);
}
add_action('after_setup_theme', 'digisolutions_hide_admin_bar');

function digisolutions_admin_redirect() {
    if (is_admin() && !wp_doing_ajax() && is_user_logged_in() && !current_user_can('manage_options')) {
        wp_safe_redirect(digisolutions_page_url('dashboard'));
        exit;
    }
}
add_action('admin_init', 'digisolutions_admin_redirect');

function digisolutions_handle_project_form() {
    if (!isset($_POST['digisolutions_project_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['digisolutions_project_nonce'])), 'digisolutions_save_project')) return;
    if (!current_user_can('manage_options') && !current_user_can('edit_portfolios')) wp_die('You do not have permission to do this.');
    $post_id = isset($_POST['project_id']) ? absint($_POST['project_id']) : 0;
    $title = isset($_POST['project_title']) ? sanitize_text_field(wp_unslash($_POST['project_title'])) : '';
    $description = isset($_POST['project_description']) ? wp_kses_post(wp_unslash($_POST['project_description'])) : '';
    if (!$title) return;
    $status = current_user_can('manage_options') ? 'publish' : 'draft';
    $postarr = array('post_type' => 'portfolio', 'post_title' => $title, 'post_content' => $description, 'post_status' => $status);
    if ($post_id && get_post_type($post_id) === 'portfolio') {
        $postarr['ID'] = $post_id;
        wp_update_post($postarr);
    } else {
        $post_id = wp_insert_post($postarr);
    }
    if (!is_wp_error($post_id) && !empty($_FILES['project_image']['name'])) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
        $attachment = media_handle_upload('project_image', $post_id);
        if (!is_wp_error($attachment)) set_post_thumbnail($post_id, $attachment);
    }
    wp_safe_redirect(add_query_arg('saved', '1', digisolutions_page_url('dashboard')));
    exit;
}
add_action('admin_post_digisolutions_save_project', 'digisolutions_handle_project_form');

function digisolutions_handle_delete_project() {
    $post_id = isset($_GET['project_id']) ? absint($_GET['project_id']) : 0;
    check_admin_referer('digisolutions_delete_' . $post_id);
    if (!current_user_can('manage_options')) wp_die('Only an administrator can delete projects.');
    if (get_post_type($post_id) === 'portfolio') wp_trash_post($post_id);
    wp_safe_redirect(digisolutions_page_url('dashboard'));
    exit;
}
add_action('admin_post_digisolutions_delete_project', 'digisolutions_handle_delete_project');
