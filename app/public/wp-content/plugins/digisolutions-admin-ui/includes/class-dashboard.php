<?php
namespace DigiSolutions\AdminUI;

defined('ABSPATH') || exit;

final class Dashboard {
    public function register() {
        add_action('wp_dashboard_setup', array($this, 'add_widget'));
    }

    public function add_widget() {
        if (is_network_admin() || is_user_admin() || !current_user_can('manage_options')) {
            return;
        }
        wp_add_dashboard_widget('dsaui_overview', __('DigiSolutions Overview', 'digisolutions-admin-ui'), array($this, 'render'));
    }

    public function render() {
        if (!current_user_can('manage_options')) {
            return;
        }
        $cards = array();
        $definitions = array(
            'projects' => array(__('Published Projects', 'digisolutions-admin-ui'), 'portfolio'),
            'page' => array(__('Published Pages', 'digisolutions-admin-ui'), 'admin-page'),
            'post' => array(__('Published Posts', 'digisolutions-admin-ui'), 'admin-post'),
        );
        foreach ($definitions as $type => $definition) {
            $object = get_post_type_object($type);
            if (!$object || !current_user_can($object->cap->edit_posts)) {
                continue;
            }
            $counts = wp_count_posts($type, 'readable');
            $cards[] = array(
                'label' => $definition[0], 'icon' => $definition[1],
                'count' => (int) ($counts->publish ?? 0),
                'url' => admin_url('edit.php?post_type=' . $type),
            );
        }
        if (current_user_can('upload_files')) {
            $counts = (array) wp_count_attachments();
            unset($counts['trash']);
            $cards[] = array(
                'label' => __('Media Items', 'digisolutions-admin-ui'), 'icon' => 'admin-media',
                'count' => array_sum($counts), 'url' => admin_url('upload.php'),
            );
        }
        $project_type = get_post_type_object('projects');
        $can_create = $project_type && current_user_can($project_type->cap->create_posts);
        $recent = $project_type && current_user_can($project_type->cap->edit_posts)
            ? get_posts(array('post_type' => 'projects', 'post_status' => array('publish', 'draft', 'pending'),
                'numberposts' => 5, 'orderby' => 'modified', 'order' => 'DESC')) : array();
        $enquiries = false;
        foreach ((array) ($GLOBALS['submenu'] ?? array()) as $items) {
            foreach ($items as $item) {
                if (($item[2] ?? '') === 'e-form-submissions' && current_user_can($item[1])) {
                    $enquiries = true;
                }
            }
        }
        $user = wp_get_current_user();
        require __DIR__ . '/../views/dashboard-overview.php';
    }
}
