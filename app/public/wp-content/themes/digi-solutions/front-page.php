<?php
get_header();

if (have_posts()) :
    while (have_posts()) : the_post();

        if (
            did_action('elementor/loaded') &&
            \Elementor\Plugin::$instance->db->is_built_with_elementor(get_the_ID())
        ) {
            the_content();
        } else {
?>
<main>
<section class="hero">
    <div class="container hero-grid">
        <div class="hero-content">
            <span class="eyebrow">CREATIVE DIGITAL AGENCY</span>

            <h1>
                We Build Digital Experiences That
                <span>Grow Your Business.</span>
            </h1>

            <p>
                Websites, branding, and digital marketing solutions
                that help you attract customers, build your brand,
                and scale with confidence.
            </p>

            <div class="hero-actions">
                <a class="primary-btn" href="#portfolio">
                    Explore Our Work →
                </a>
                <a class="text-btn" href="#contact">
                    Let's Talk
                </a>
            </div>
        </div>
    </div>
</section>
<section class="section" id="about"><div class="container two-col"><div><span class="eyebrow">WHO WE ARE</span><h2>We turn bold ideas into <span>meaningful results.</span></h2></div><p class="lead">We are a team of creative thinkers and technology specialists helping ambitious brands connect with people, solve problems, and grow with confidence.</p></div></section>
<section class="section soft" id="services"><div class="container"><span class="eyebrow">WHAT WE DO</span><h2>Services designed for <span>your next stage.</span></h2><div class="service-grid">
<article class="service-card"><b>01</b><h3>Web Development</h3><p>Fast, responsive websites built around your business goals.</p></article><article class="service-card"><b>02</b><h3>Digital Marketing</h3><p>Campaigns that connect your brand with the right audience.</p></article><article class="service-card"><b>03</b><h3>Brand Identity</h3><p>Consistent visual identities that make your business memorable.</p></article>
</div></div></section>
<section class="section" id="portfolio"><div class="container"><div class="section-heading"><div><span class="eyebrow">SELECTED WORK</span><h2>Ideas brought <span>to life.</span></h2></div><span class="muted">A selection of our recent projects</span></div><div class="portfolio-grid">
<?php $projects = new WP_Query(array('post_type'=>'portfolio','post_status'=>'publish','posts_per_page'=>6)); if ($projects->have_posts()): while ($projects->have_posts()): $projects->the_post(); ?>
<a class="project-card" href="<?php the_permalink(); ?>"><div class="project-image"><?php if (has_post_thumbnail()) : the_post_thumbnail('large'); else: ?><div class="placeholder-art">TS</div><?php endif; ?></div><div class="project-meta"><div><h3><?php the_title(); ?></h3><p><?php echo esc_html(get_the_excerpt()); ?></p></div><span>↗</span></div></a>
<?php endwhile; wp_reset_postdata(); else: ?>
<div class="empty-state">Your portfolio projects will appear here after you publish them from the dashboard.</div>
<?php endif; ?></div></div></section>
<section class="section contact-section" id="contact"><div class="container contact-box"><div><span class="eyebrow">HAVE A PROJECT IN MIND?</span><h2>Let’s make something <span>great together.</span></h2><p>Tell us a little about your project and we’ll get back to you.</p></div><a class="primary-btn" href="mailto:info@digisolutions.com">Start a Conversation →</a></div></section>
</main>
<?php
        }
    endwhile;
endif;

get_footer();
?>
