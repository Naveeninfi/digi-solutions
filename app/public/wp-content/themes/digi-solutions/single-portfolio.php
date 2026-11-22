<?php get_header(); if (have_posts()): while (have_posts()): the_post(); ?>
<main class="single-project"><div class="container"><a class="back-link" href="<?php echo esc_url(home_url('/#portfolio')); ?>">← Back to portfolio</a><span class="eyebrow">CASE STUDY</span><h1><?php the_title(); ?></h1><div class="single-cover"><?php if (has_post_thumbnail()) the_post_thumbnail('full'); ?></div><article class="entry-content"><?php the_content(); ?></article></div></main>
<?php endwhile; endif; get_footer(); ?>
