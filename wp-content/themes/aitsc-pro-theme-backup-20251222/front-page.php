<?php
/**
 * Front Page Template for AITSC Pro Theme
 *
 * Enhanced homepage with advanced template parts and sections
 * WorldQuant-inspired design with dynamic content integration
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

get_header();
?>

<div id="primary" class="site-content">

    <!-- RESTRICTED HERO SECTION - Above Fold Only -->
    <section class="hero-section" id="hero">
        <!-- Background Elements -->
        <div class="hero-background">
            <div class="hero-overlay"></div>
            <?php if (get_theme_mod('hero_video_url', false)): ?>
                <video class="hero-video" autoplay muted loop playsinline>
                    <source src="<?php echo esc_url(get_theme_mod('hero_video_url')); ?>" type="video/mp4">
                </video>
            <?php endif; ?>
            <div class="hero-gradient"></div>
        </div>

        <!-- Content Container - Optimized for Above Fold -->
        <div class="container hero-container">
            <div class="hero-content">
                <!-- Main Headline - WorldQuant Style -->
                <h1 class="hero-title">
                    <?php
                        $hero_title = get_theme_mod('hero_title', 'Transform Your Transport Safety Program');
                        $hero_words = explode(' ', $hero_title);
                        $word_count = count($hero_words);

                        foreach ($hero_words as $index => $word):
                            $delay = $index * 0.1;
                            $class = ($index === 0) ? 'hero-word hero-word-primary' : 'hero-word';
                            echo '<span class="' . $class . '" style="animation-delay: ' . $delay . 's">' . esc_html($word) . '</span> ';
                            if (($index + 1) % 3 === 0 && $index < $word_count - 1) {
                                echo '<br>';
                            }
                        endforeach;
                    ?>
                </h1>

                <!-- Concise Subtitle -->
                <p class="hero-subtitle animate-fade-in" style="animation-delay: 0.4s;">
                    <?php echo esc_html(get_theme_mod('hero_subtitle', 'Leading Australian transport companies trust AITSC for NHVAS accreditation and comprehensive compliance management.')); ?>
                </p>

                <!-- Primary Call-to-Action Only -->
                <div class="hero-actions animate-slide-up" style="animation-delay: 0.8s;">
                    <a href="<?php echo esc_url(get_theme_mod('primary_cta_link', '#contact')); ?>"
                       class="btn btn-primary btn-large">
                        <?php echo esc_html(get_theme_mod('primary_cta_text', 'Get Free Safety Audit')); ?>
                        <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M5 12h14m-7-7l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="<?php echo esc_url(get_theme_mod('secondary_cta_link', '#solutions')); ?>"
                       class="btn btn-secondary btn-large">
                        <?php echo esc_html(get_theme_mod('secondary_cta_text', 'Our Solutions')); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- STATISTICS SECTION - Separate from Hero -->
    <?php if ( get_theme_mod( 'aitsc_enable_stats_section', true ) ) : ?>
    <section class="stats-section-compact" id="hero-stats">
        <div class="container">
            <div class="stats-grid-compact">
                <div class="stat-item-compact">
                    <span class="stat-number-compact" data-count="<?php echo esc_attr(get_theme_mod('stat_clients', '500')); ?>">0</span>
                    <span class="stat-label-compact"><?php echo esc_html(get_theme_mod('stat_clients_label', 'Companies Certified')); ?></span>
                </div>
                <div class="stat-item-compact">
                    <span class="stat-number-compact" data-count="<?php echo esc_attr(get_theme_mod('stat_projects', '100')); ?>">0</span>
                    <span class="stat-label-compact"><?php echo esc_html(get_theme_mod('stat_projects_label', 'NHVAS Compliance')); ?></span>
                </div>
                <div class="stat-item-compact">
                    <span class="stat-number-compact" data-count="<?php echo esc_attr(get_theme_mod('stat_years', '15')); ?>">0</span>
                    <span class="stat-label-compact"><?php echo esc_html(get_theme_mod('stat_years_label', 'Years Experience')); ?></span>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

      <!-- SOLUTIONS SHOWCASE SECTION -->
    <?php if ( get_theme_mod( 'aitsc_enable_case_studies_preview', true ) ) : ?>
    <!-- Case Studies Preview Section -->
    <?php get_template_part( 'template-parts/case-studies-preview' ); ?>
    <?php endif; ?>

    <!-- TESTIMONIALS SECTION -->
    <?php if ( get_theme_mod( 'aitsc_enable_testimonials', true ) ) : ?>
    <!-- Testimonials / Social Proof Section -->
    <?php get_template_part( 'template-parts/testimonials' ); ?>
    <?php endif; ?>

    <!-- SERVICES SECTION -->
    <?php if ( get_theme_mod( 'aitsc_enable_services_section', true ) ) : ?>
    <!-- Services Section -->
    <section class="services-section section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'aitsc_services_title', 'Comprehensive Safety Solutions' ) ); ?></h2>
                <p class="section-subtitle"><?php echo esc_html( get_theme_mod( 'aitsc_services_subtitle', 'End-to-end transport safety management from initial assessment to ongoing compliance support' ) ); ?></p>
            </div>

            <div class="services-grid">
                <?php for ( $i = 1; $i <= 6; $i++ ) : ?>
                    <?php if ( get_theme_mod( "aitsc_service_{$i}_title" ) ) : ?>
                    <div class="service-card">
                        <div class="service-content">
                            <h3 class="service-title"><?php echo esc_html( get_theme_mod( "aitsc_service_{$i}_title" ) ); ?></h3>
                            <p class="service-description"><?php echo esc_html( get_theme_mod( "aitsc_service_{$i}_desc" ) ); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- CONTACT FORM SECTION -->
    <?php if ( get_theme_mod( 'aitsc_enable_contact_form', true ) ) : ?>
    <!-- Advanced Contact Form Section -->
    <?php get_template_part( 'template-parts/contact-form-advanced' ); ?>
    <?php endif; ?>

    <!-- CTA SECTION -->
    <?php if ( get_theme_mod( 'aitsc_enable_cta_section', true ) ) : ?>
    <!-- Advanced CTA Section -->
    <?php get_template_part( 'template-parts/cta-advanced' ); ?>
    <?php else : ?>
        <!-- Fallback: Legacy CTA Section -->
        <?php if ( get_theme_mod( 'aitsc_display_cta', true ) ) : ?>
        <section class="cta-section section">
            <div class="container">
                <div class="cta-content">
                    <h2 class="cta-title"><?php echo wp_kses_post( get_theme_mod( 'aitsc_cta_title', 'Start Your Safety Transformation Today' ) ); ?></h2>
                    <p class="cta-subtitle"><?php echo esc_html( get_theme_mod( 'aitsc_cta_subtitle', 'Join 500+ Australian transport companies who trust AITSC for complete safety compliance. Get your free assessment in 24 hours.' ) ); ?></p>
                    <div class="cta-buttons">
                        <a href="<?php echo esc_url( get_theme_mod( 'aitsc_cta_primary_url', '#contact' ) ); ?>" class="btn btn-neon btn-lg">
                            <?php echo esc_html( get_theme_mod( 'aitsc_cta_primary_text', 'Get Started' ) ); ?>
                        </a>
                        <a href="<?php echo esc_url( get_theme_mod( 'aitsc_cta_secondary_url', 'tel:1300000000' ) ); ?>" class="btn btn-outline btn-lg">
                            <?php echo esc_html( get_theme_mod( 'aitsc_cta_secondary_text', 'Call Us' ) ); ?>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
    <?php endif; ?>

</div><!-- #primary -->

<?php
get_footer();
?>