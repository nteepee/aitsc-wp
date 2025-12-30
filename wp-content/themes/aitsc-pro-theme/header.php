<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
    <!-- Harrison.ai White Theme Global Styles -->
    <style>
        /* White Theme Card Styles */
        .aitsc-glass-card {
            background-color: var(--aitsc-bg-primary) !important;
            border: 1px solid var(--aitsc-border) !important;
            border-radius: 8px !important;
            box-shadow: var(--aitsc-shadow-md) !important;
            transition: all 0.3s ease !important;
        }

        .aitsc-glass-card:hover {
            border-color: var(--aitsc-primary) !important;
            box-shadow: var(--aitsc-shadow-lg) !important;
            transform: translateY(-2px);
        }

        .aitsc-ecosystem-card {
            background: var(--aitsc-bg-primary) !important;
            border: 1px solid var(--aitsc-border) !important;
            border-radius: 8px !important;
            padding: 1.5rem !important;
            transition: all 0.3s ease !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-height: 80px;
        }

        .aitsc-ecosystem-card:hover {
            border-color: var(--aitsc-primary) !important;
            box-shadow: 0 0 15px rgba(0, 92, 178, 0.15) !important;
            transform: translateY(-2px);
        }

        /* CTA Button Styles - Harrison.ai Cyan */
        .aitsc-cta-btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.5rem !important;
            padding: 0.75rem 1.5rem !important;
            border-radius: 4px !important;
            font-weight: 600 !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            border-width: 2px !important;
            border-style: solid !important;
        }

        .aitsc-cta-btn-primary {
            background-color: var(--aitsc-cta-bg) !important;
            border-color: var(--aitsc-cta-bg) !important;
            color: var(--aitsc-cta-text) !important;
        }

        .aitsc-cta-btn-primary:hover {
            background-color: var(--aitsc-cta-bg-hover) !important;
            border-color: var(--aitsc-cta-bg-hover) !important;
        }

        .aitsc-cta-btn-secondary {
            background-color: transparent !important;
            border-color: var(--aitsc-primary) !important;
            color: var(--aitsc-primary) !important;
        }

        .aitsc-cta-btn-secondary:hover {
            background-color: var(--aitsc-primary-light) !important;
            color: var(--aitsc-primary) !important;
        }
    </style>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <?php
    // Include Global Background Logic
    get_template_part('template-parts/global-background');
    ?>

    <div id="page" class="site">
        <a class="skip-link screen-reader-text"
            href="#primary"><?php esc_html_e('Skip to content', 'aitsc-pro-theme'); ?></a>

        <header id="masthead" class="site-header">
            <div class="container header-container">

                <div class="site-branding">
                    <?php
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        // Use authentic AITSC logo
                        $logo_url = get_template_directory_uri() . '/assets/images/brand/logo.png';
                        ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="site-title">
                            <img src="<?php echo esc_url($logo_url); ?>" alt="AITSC" class="site-logo-img" />
                        </a>
                        <?php
                    }
                    ?>
                </div><!-- .site-branding -->

                <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Primary Navigation', 'aitsc-pro-theme'); ?>">
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation menu', 'aitsc-pro-theme'); ?>">
                        <span class="hamburger">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id' => 'primary-menu',
                        'container' => false,
                        'fallback_cb' => false,
                    ));
                    ?>
                </nav><!-- #site-navigation -->

                <div class="header-cta">
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="aitsc-cta-btn aitsc-cta-btn-primary">
                        <?php esc_html_e('Book a demo', 'aitsc-pro-theme'); ?>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>

            </div>
        </header><!-- #masthead -->