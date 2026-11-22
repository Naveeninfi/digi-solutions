<!doctype html>
<html <?php language_attributes(); ?>>
<head><meta charset="<?php bloginfo('charset'); ?>"><meta name="viewport" content="width=device-width, initial-scale=1"><?php wp_head(); ?></head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
  <div class="topbar"><div class="container topbar-inner"><div><a href="tel:+919876543210">☎ +91 6380225014</a><a href="mailto:info@digisolutions.com">✉ info@digisolutions.com</a></div><div class="social">f　◎　in　▶</div></div></div>
  <div class="nav-wrap"><div class="container nav-inner">
    <!-- <a class="brand" href="<?php echo esc_url(home_url('/')); ?>"><span class="brand-mark">T</span><span>Tech<span class="brand-accent">Solutions</span></span></a> -->
    <a class="brand" href="<?php echo esc_url(home_url('/')); ?>">
      <?php
      $logo_id = get_theme_mod('custom_logo');

      if ($logo_id) {
          echo wp_get_attachment_image(
              $logo_id,
              'full',
              false,
              array(
                  'class' => 'custom-logo',
                  'alt'   => get_bloginfo('name')
              )
          );
      } else {
          ?>
          <span>Digi<span class="brand-accent">Solutions</span></span>
          <?php
      }
      ?>
    </a>
    <button class="menu-toggle" aria-label="Toggle menu" aria-expanded="false">☰</button>
    <nav class="main-nav"><a class="active" href="<?php echo esc_url(home_url('/')); ?>">Home</a><a href="<?php echo esc_url(home_url('/#about')); ?>">About</a><a href="<?php echo esc_url(home_url('/#services')); ?>">Services</a><a href="<?php echo esc_url(home_url('/#portfolio')); ?>">Portfolio</a><a href="<?php echo esc_url(home_url('/#contact')); ?>">Contact</a><a class="quote-btn" href="<?php echo esc_url(home_url('/#contact')); ?>">Get a Quote <span>→</span></a></nav>
  </div></div>
</header>
