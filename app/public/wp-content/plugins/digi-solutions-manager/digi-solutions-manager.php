
<?php
/**
 * Plugin Name: Digi Solutions Manager
 * Plugin URI: https://digisolutions.com
 * Description: Manage Portfolio Projects
 * Version: 1.0
 * Author: Digi Solutions
 * Text Domain: digisolutions-manager
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Projects Custom Post Type
 */
function dsm_register_projects() {

    $labels = array(
        'name'                  => 'Projects',
        'singular_name'         => 'Project',
        'menu_name'             => 'Projects',
        'name_admin_bar'        => 'Project',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Project',
        'new_item'              => 'New Project',
        'edit_item'             => 'Edit Project',
        'view_item'             => 'View Project',
        'all_items'             => 'All Projects',
        'search_items'          => 'Search Projects',
        'not_found'             => 'No projects found',
        'not_found_in_trash'    => 'No projects found in Trash',
        'featured_image'        => 'Project Image',
        'set_featured_image'    => 'Set Project Image',
        'remove_featured_image' => 'Remove Project Image',
        'use_featured_image'    => 'Use as Project Image',
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'publicly_queryable'  => true,
        'has_archive'         => true,
        'rewrite'             => array(
            'slug' => 'projects',
        ),
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-portfolio',
        'supports'            => array(
            'title',
            'editor',
            'thumbnail',
            'excerpt',
            'revisions'
        ),
    );

    register_post_type('projects', $args);
}

add_action('init', 'dsm_register_projects');


/**
 * Activation Hook
 */
function dsm_plugin_activate() {

    dsm_register_projects();

    flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'dsm_plugin_activate');


/**
 * Deactivation Hook
 */
function dsm_plugin_deactivate() {

    flush_rewrite_rules();
}

register_deactivation_hook(__FILE__, 'dsm_plugin_deactivate');


/**
 * DigiSolutions Custom Admin Dashboard
 */
function dsm_register_admin_menu() {

    add_menu_page(
        'DigiSolutions Dashboard',
        'DigiSolutions',
        'manage_options',
        'digisolutions-dashboard',
        'dsm_dashboard_page',
        'dashicons-admin-generic',
        3
    );

    add_submenu_page(
        'digisolutions-dashboard',
        'Dashboard',
        'Dashboard',
        'manage_options',
        'digisolutions-dashboard',
        'dsm_dashboard_page'
    );

    add_submenu_page(
        'digisolutions-dashboard',
        'All Projects',
        'All Projects',
        'edit_posts',
        'edit.php?post_type=projects'
    );

    add_submenu_page(
        'digisolutions-dashboard',
        'Add New Project',
        'Add New Project',
        'edit_posts',
        'post-new.php?post_type=projects'
    );
}
add_action('admin_menu', 'dsm_register_admin_menu');


/**
 * Change WordPress admin bar greeting
 */
function dsm_change_admin_greeting($wp_admin_bar) {

    $wp_admin_bar->add_node(array(
        'id'    => 'my-account',
        'title' => 'Welcome, Admin',
    ));

}
add_action('admin_bar_menu', 'dsm_change_admin_greeting', 9999);


