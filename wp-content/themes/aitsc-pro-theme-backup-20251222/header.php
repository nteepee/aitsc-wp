<?php
/**
 * The Header template for AITSC Pro Theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package AITSCProTheme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <!-- AITSC SEO Optimization -->
    <?php if (is_front_page()) : ?>
    <meta name="description" content="AITSC - Australian Industrial Transport Safety Consulting. Expert transport safety consulting, NHVAS accreditation, Chain of Responsibility training, and compliance management for Australian transport companies.">
    <meta name="keywords" content="transport safety consulting, NHVAS accreditation, Chain of Responsibility training, fatigue management, safety management systems, Australian transport compliance">
    <?php endif; ?>

    <!-- Enhanced Schema.org structured data for AITSC -->
    <?php if (is_front_page()) : ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ProfessionalService",
        "name": "Australian Industrial Transport Safety Consulting (AITSC)",
        "description": "Expert transport safety consulting, NHVAS accreditation, and compliance management for Australian transport companies. Reduce risk and improve safety scores by 47% on average.",
        "url": "<?php echo esc_url(home_url('/')); ?>",
        "telephone": "1300-AITSC",
        "email": "contact@aitsc.au",
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "AU",
            "addressRegion": "NSW"
        },
        "servicesOffered": [
            {
                "@type": "Service",
                "name": "NHVAS Accreditation & Auditing",
                "description": "Complete NHVAS accreditation management including audits and certification"
            },
            {
                "@type": "Service",
                "name": "Chain of Responsibility Training",
                "description": "Expert CoR training programs for all levels of staff"
            },
            {
                "@type": "Service",
                "name": "Safety Management Systems",
                "description": "Custom SMS development and implementation"
            },
            {
                "@type": "Service",
                "name": "Compliance Management",
                "description": "Ongoing compliance support and documentation"
            }
        ],
        "areaServed": "Australia",
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.9",
            "reviewCount": "127",
            "bestRating": "5"
        },
        "provider": {
            "@type": "Organization",
            "name": "Australian Industrial Transport Safety Consulting (AITSC)",
            "url": "https://aitsc.au",
            "logo": "<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo-dark.svg"
        }
    }
    </script>
    <?php endif; ?>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

    <!-- Skip Links for Accessibility -->
    <a class="skip-link screen-reader-text" href="#main-content">
        <?php esc_html_e('Skip to main content', 'aitsc-pro'); ?>
    </a>

    <!-- Sticky Header -->
    <header class="site-header" id="masthead">
        <div class="header-top">
            <div class="container">
                <div class="header-content">
                    <!-- Logo -->
                    <div class="site-branding">
                        <?php
                        if (function_exists('the_custom_logo') && has_custom_logo()):
                            the_custom_logo();
                        else:
                            ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo-text">
                                <span class="logo-main"><?php echo esc_html(get_bloginfo('name')); ?></span>
                                <span class="logo-accent">AITSC</span>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Desktop Navigation -->
                    <nav class="main-navigation desktop-navigation" id="desktop-navigation">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'container_class' => 'menu-wrapper',
                            'menu_class'     => 'primary-menu',
                            'fallback_cb'    => false,
                        ));
                        ?>

                        <!-- CTA Button -->
                        <div class="header-cta">
                            <a href="<?php echo esc_url(get_theme_mod('header_cta_link', '#contact')); ?>"
                               class="btn btn-primary btn-small">
                                <?php echo esc_html(get_theme_mod('header_cta_text', 'Contact Us')); ?>
                            </a>
                        </div>
                    </nav>

                    <!-- Mobile Menu Toggle -->
                    <button class="mobile-menu-toggle" id="mobile-menu-toggle"
                            aria-controls="mobile-navigation"
                            aria-expanded="false">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="sr-only"><?php esc_html_e('Toggle mobile menu', 'aitsc-pro'); ?></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <nav class="mobile-navigation" id="mobile-navigation" aria-hidden="true">
            <div class="mobile-menu-container">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'mobile-primary-menu',
                    'container_class' => 'mobile-menu-wrapper',
                    'menu_class'     => 'mobile-primary-menu',
                    'fallback_cb'    => false,
                ));
                ?>

                <!-- Mobile CTA -->
                <div class="mobile-header-cta">
                    <a href="<?php echo esc_url(get_theme_mod('header_cta_link', '#contact')); ?>"
                       class="btn btn-primary btn-full-width">
                        <?php echo esc_html(get_theme_mod('header_cta_text', 'Contact Us')); ?>
                    </a>
                </div>

                <!-- Social Links -->
                <?php if (get_theme_mod('show_social_in_mobile', true)): ?>
                <div class="mobile-social-links">
                    <a href="<?php echo esc_url(get_theme_mod('linkedin_url', '#')); ?>"
                       class="social-link" aria-label="LinkedIn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    </a>
                    <a href="<?php echo esc_url(get_theme_mod('twitter_url', '#')); ?>"
                       class="social-link" aria-label="Twitter">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main id="main-content" class="site-main">