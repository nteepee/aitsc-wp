<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

get_header();
?>

<div id="primary" class="site-content">
    <div class="container">
        <div class="site-content-inner">

            <!-- Hero Section - Only on front page -->
            <?php if (is_front_page()) : ?>
            <section class="hero-section hero-background">
                <div class="hero-content">
                    <h1 class="hero-headline">
                        <?php echo wp_kses_post(get_theme_mod('aitsc_hero_headline', 'Solving Your Most Expensive Problems')); ?>
                    </h1>
                    <div class="hero-subheadline">
                        <?php echo wp_kses_post(get_theme_mod('aitsc_hero_subheadline', 'Advanced safety solutions for industrial environments.')); ?>
                    </div>
                    <?php if (get_theme_mod('aitsc_hero_cta_text', 'Get Started')) : ?>
                    <div class="hero-cta">
                        <a href="<?php echo esc_url(get_theme_mod('aitsc_hero_cta_url', '#contact')); ?>" class="button button--neon">
                            <?php echo esc_html(get_theme_mod('aitsc_hero_cta_text', 'Get Started')); ?>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Pure CSS Background Effects -->
                <div class="hero-particles">
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                </div>

                <div class="hero-geometry">
                    <div class="geo-shape"></div>
                    <div class="geo-shape"></div>
                    <div class="geo-shape"></div>
                </div>

                <div class="ascii-overlay"></div>

                <div class="code-elements">
                    <div class="code-line">function optimizeSafety() { return maximum; }</div>
                    <div class="code-line">const compliance = 100%;</div>
                    <div class="code-line">while (risk > 0) { reduce(); }</div>
                    <div class="code-line">certification.active = true;</div>
                </div>

                <div class="matrix-rain">
                    <div class="matrix-column">01001110</div>
                    <div class="matrix-column">11010010</div>
                    <div class="matrix-column">00110101</div>
                    <div class="matrix-column">10101001</div>
                    <div class="matrix-column">01101011</div>
                    <div class="matrix-column">10010110</div>
                    <div class="matrix-column">01001101</div>
                    <div class="matrix-column">11010001</div>
                    <div class="matrix-column">00101110</div>
                </div>

                <div class="chart-overlay">
                    <div class="chart-line"></div>
                </div>

            </section>
            <?php endif; ?>

            <!-- Solutions Section - Only on front page if enabled -->
            <?php if (is_front_page() && get_theme_mod('aitsc_display_solutions', true)) : ?>
            <section class="solutions-section">
                <div class="container">
                    <h2 class="section-title">Our Solutions</h2>
                    <div class="solutions-grid">
                        <div class="solution-card">
                            <h3>Safety Consulting</h3>
                            <p>Expert safety assessments and consulting services for your workplace environment and compliance needs.</p>
                        </div>
                        <div class="solution-card">
                            <h3>Training Programs</h3>
                            <p>Comprehensive safety training programs for your team and management personnel.</p>
                        </div>
                        <div class="solution-card">
                            <h3>Compliance Management</h3>
                            <p>Ensure your business meets all safety regulations and industry standards.</p>
                        </div>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <!-- Main Content Area -->
            <main class="content-area">
                <?php
                if (have_posts()) :

                    // Page header for blog pages
                    if (is_home() && !is_front_page()) :
                        ?>
                        <header class="page-header">
                            <h1 class="page-title"><?php single_post_title(); ?></h1>
                        </header>
                        <?php
                    endif;

                    // Load posts
                    while (have_posts()) :
                        the_post();

                        get_template_part('template-parts/content', get_post_type());

                    endwhile;

                    // Previous/next page navigation
                    the_posts_navigation(array(
                        'prev_text' => __('&larr; Older posts', 'aitsc-pro-theme'),
                        'next_text' => __('Newer posts &rarr;', 'aitsc-pro-theme'),
                    ));

                else :

                    get_template_part('template-parts/content', 'none');

                endif;
                ?>
            </main>

            <?php get_sidebar(); ?>

        </div><!-- .site-content-inner -->
    </div><!-- .container -->
</div><!-- #primary -->

<?php
get_footer();