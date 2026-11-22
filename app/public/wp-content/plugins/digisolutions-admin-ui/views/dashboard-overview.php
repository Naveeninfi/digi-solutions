<?php
namespace DigiSolutions\AdminUI;
defined('ABSPATH') || exit;
?>
<div class="dsaui-overview">
    <div class="dsaui-intro">
        <span class="dsaui-eyebrow">DIGISOLUTIONS / WORKSPACE</span>
        <h3><?php echo esc_html(sprintf(__('Welcome back, %s', 'digisolutions-admin-ui'), $user->display_name)); ?></h3>
        <p><?php esc_html_e('Your content, projects, and conversations in one place.', 'digisolutions-admin-ui'); ?></p>
    </div>
    <div class="dsaui-cards">
        <?php foreach ($cards as $card) : ?>
            <a class="dsaui-card" href="<?php echo esc_url($card['url']); ?>">
                <span class="dashicons dashicons-<?php echo esc_attr($card['icon']); ?>" aria-hidden="true"></span>
                <strong><?php echo esc_html(number_format_i18n($card['count'])); ?></strong>
                <span><?php echo esc_html($card['label']); ?></span>
            </a>
        <?php endforeach; ?>
    </div>
    <section class="dsaui-section" aria-labelledby="dsaui-actions-heading">
        <h3 id="dsaui-actions-heading"><?php esc_html_e('Quick access', 'digisolutions-admin-ui'); ?></h3>
        <div class="dsaui-actions">
            <?php if ($can_create) : ?>
                <a class="dsaui-action dsaui-primary" href="<?php echo esc_url(admin_url('post-new.php?post_type=projects')); ?>"><?php esc_html_e('Add Project', 'digisolutions-admin-ui'); ?></a>
            <?php endif; ?>
            <?php foreach ($cards as $card) : ?>
                <a class="dsaui-action" href="<?php echo esc_url($card['url']); ?>"><?php echo esc_html(str_replace('Published ', '', $card['label'])); ?></a>
            <?php endforeach; ?>
            <?php if ($enquiries) : ?>
                <a class="dsaui-action" href="<?php echo esc_url(admin_url('admin.php?page=e-form-submissions')); ?>"><?php esc_html_e('Enquiries', 'digisolutions-admin-ui'); ?></a>
            <?php endif; ?>
        </div>
    </section>
    <section class="dsaui-section" aria-labelledby="dsaui-projects-heading">
        <h3 id="dsaui-projects-heading"><?php esc_html_e('Recent projects', 'digisolutions-admin-ui'); ?></h3>
        <ul class="dsaui-projects">
            <?php $visible = 0; foreach ($recent as $project) : ?>
                <?php if (!current_user_can('edit_post', $project->ID)) { continue; } $visible++; ?>
                <li>
                    <a href="<?php echo esc_url(get_edit_post_link($project->ID, 'raw')); ?>"><?php echo esc_html($project->post_title ?: __('Untitled project', 'digisolutions-admin-ui')); ?></a>
                    <span class="dsaui-status"><?php $status = get_post_status_object($project->post_status); echo esc_html($status ? $status->label : $project->post_status); ?></span>
                </li>
            <?php endforeach; ?>
            <?php if (!$visible) : ?>
                <li><?php esc_html_e('No projects available to display.', 'digisolutions-admin-ui'); ?></li>
            <?php endif; ?>
        </ul>
    </section>
</div>
