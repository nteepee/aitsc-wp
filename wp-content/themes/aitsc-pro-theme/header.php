<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
    <!-- Custom Styles for Glassmorphism (Global) -->
    <style>
        .aitsc-glass-card {
            background-color: rgba(15, 23, 42, 0.5) !important;
            /* slate-900/50 */
            backdrop-filter: blur(4px) !important;
            -webkit-backdrop-filter: blur(4px) !important;
            border: 1px solid rgba(30, 41, 59, 1) !important;
            /* slate-800 */
            transition: all 0.3s ease !important;
        }

        .aitsc-glass-card:hover {
            border-color: rgba(37, 99, 235, 0.3) !important;
            /* blue-600/30 */
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5) !important;
        }

        .aitsc-ecosystem-card {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.6) 0%, rgba(30, 58, 138, 0.2) 100%) !important;
            backdrop-filter: blur(4px) !important;
            -webkit-backdrop-filter: blur(4px) !important;
            border: 1px solid rgba(59, 130, 246, 0.2) !important;
            border-radius: 0.75rem !important;
            /* rounded-xl */
            padding: 1.5rem !important;
            transition: all 0.3s ease !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-height: 80px;
        }

        .aitsc-ecosystem-card:hover {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.3) 0%, rgba(37, 99, 235, 0.2) 100%) !important;
            border-color: rgba(96, 165, 250, 0.5) !important;
            box-shadow: 0 0 15px rgba(37, 99, 235, 0.2) !important;
            transform: translateY(-2px);
        }

        /* CTA Button Styles */
        .aitsc-cta-btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.5rem !important;
            padding: 0.75rem 1.5rem !important;
            border-radius: 0.75rem !important;
            /* rounded-xl */
            font-weight: 600 !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            border-width: 2px !important;
            border-style: solid !important;
        }

        .aitsc-cta-btn-primary {
            border-color: #2563eb !important;
            /* blue-600 */
            color: #60a5fa !important;
            /* blue-400 */
        }

        .aitsc-cta-btn-primary:hover {
            background-color: rgba(37, 99, 235, 0.1) !important;
        }

        .aitsc-cta-btn-secondary {
            border-color: #475569 !important;
            /* slate-600 */
            color: #cbd5e1 !important;
            /* slate-300 */
        }

        .aitsc-cta-btn-secondary:hover {
            border-color: #2563eb !important;
            color: white !important;
        }

        /* Custom Background Pattern */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/brand/bg-pattern-logo.png');
            background-repeat: repeat;
            background-size: 150px auto;
            /* Adjust size as needed */
            opacity: 0.4;
            /* Subtle effect */
            pointer-events: none;
            z-index: -1;
            mix-blend-mode: overlay;
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
            <div class="container header-container"
                style="display: flex; justify-content: space-between; align-items: center;">

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

                <nav id="site-navigation" class="main-navigation">
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id' => 'primary-menu',
                        'container' => false,
                        'fallback_cb' => false, // Don't show pages if no menu assigned
                    ));
                    ?>
                </nav><!-- #site-navigation -->

            </div>
        </header><!-- #masthead -->