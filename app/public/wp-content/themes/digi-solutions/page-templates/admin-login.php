<?php
/* Template Name: Admin Login */
if (is_user_logged_in()) { wp_safe_redirect(home_url('/dashboard/')); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ts_login_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['ts_login_nonce'])), 'ts_login')) {
    $creds = array(
        'user_login' => sanitize_user(wp_unslash($_POST['log'] ?? '')),
        'user_password' => (string) wp_unslash($_POST['pwd'] ?? ''),
        'remember' => !empty($_POST['rememberme'])
    );
    $user = wp_signon($creds, is_ssl());
    if (is_wp_error($user)) $error = 'Invalid username or password. Please try again.';
    else { wp_safe_redirect(home_url('/dashboard/')); exit; }
}
?><!doctype html><html <?php language_attributes(); ?>><head><meta charset="<?php bloginfo('charset'); ?>"><meta name="viewport" content="width=device-width, initial-scale=1"><?php wp_head(); ?></head><body class="admin-auth"><div class="auth-card"><a class="brand" href="<?php echo esc_url(home_url('/')); ?>"><span class="brand-mark">T</span><span>Tech<span class="brand-accent">Solutions</span></span></a><h1>Welcome back</h1><p>Sign in to manage your portfolio.</p><?php if ($error): ?><div class="form-error"><?php echo esc_html($error); ?></div><?php endif; ?><form method="post"><?php wp_nonce_field('ts_login', 'ts_login_nonce'); ?><label>Username or Email<input name="log" required autocomplete="username"></label><label>Password<input type="password" name="pwd" required autocomplete="current-password"></label><label class="remember"><input type="checkbox" name="rememberme" value="1"> Remember me</label><button class="primary-btn full-btn" type="submit">Sign In →</button></form></div><?php wp_footer(); ?></body></html>
