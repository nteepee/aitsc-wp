<?php
/**
 * The template for displaying the footer
 */
?>

<footer id="colophon" class="site-footer">
    <div class="footer-pattern-overlay" aria-hidden="true"></div>
    <div class="container footer-container">
        <div class="footer-widgets-grid">

            <!-- Column 1: Branding & Info -->
            <div class="footer-col">
                <div class="footer-branding">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brand/logo.png" alt="AITSC"
                            width="120" style="height: auto;">
                    </a>
                </div>
                <p class="footer-desc">
                    Custom electronics engineering for automotive and transport. From concept to deployment - we solve
                    your most expensive technology problems without spending more.
                </p>
                <div class="footer-contact">
                    <p class="mb-2"><strong class="text-slate-900">1300 AITSC</strong> (1300 000 000)</p>
                    <p><a href="mailto:info@aitsc.au"
                            class="text-cyan-700 hover:text-cyan-900 focus:text-cyan-900">info@aitsc.au</a></p>
                </div>
            </div>

            <!-- Column 2: Solutions -->
            <div class="footer-col">
                <h4 class="footer-heading">Engineering Services</h4>
                <ul class="footer-menu">
                    <li><a href="<?php echo esc_url(home_url('/solutions/passenger-monitoring-systems')); ?>">Passenger
                            Monitoring Systems</a></li>
                    <li><a href="<?php echo esc_url(home_url('/solutions/custom-pcb-design')); ?>">Custom PCB Design</a>
                    </li>
                    <li><a href="<?php echo esc_url(home_url('/solutions/embedded-systems')); ?>">Embedded Systems</a>
                    </li>
                    <li><a href="<?php echo esc_url(home_url('/solutions/automotive-electronics')); ?>">Automotive
                            Electronics</a></li>
                </ul>
            </div>

            <!-- Column 3: Company -->
            <div class="footer-col">
                <h4 class="footer-heading">Company</h4>
                <ul class="footer-menu">
                    <li><a href="<?php echo esc_url(home_url('/about')); ?>">About Us</a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a></li>
                </ul>
            </div>

            <!-- Column 4: Quick Links -->
            <div class="footer-col">
                <h4 class="footer-heading">Resources</h4>
                <ul class="footer-menu">
                    <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Free Tech Review</a></li>
                    <li><a href="<?php echo get_post_type_archive_link('solutions'); ?>">All Solutions</a></li>
                    <li><a href="<?php echo get_post_type_archive_link('case-studies'); ?>">Case Studies</a></li>
                </ul>
            </div>

        </div>

        <div class="site-info">
            <div class="copyright">
                &copy; <?php echo date('Y'); ?> Australian International Technology Solutions Company. All rights
                reserved.
            </div>
            <div class="credits">
                Custom Electronics &amp; Safety Engineering
            </div>
        </div>
    </div>
</footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>

</html>

<style>
    /* Footer - Harrison.ai White Theme with Cyan Square Patterns */
    .site-footer {
        background-color: var(--aitsc-bg-primary);
        border-top: 1px solid var(--aitsc-border);
        padding: 4rem 0 2rem;
        font-size: var(--font-size-sm);
        color: var(--aitsc-text-secondary);
        position: relative;
        overflow: hidden;
    }

    /* Cyan Square Pattern Overlay */
    .footer-pattern-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0.05;
        pointer-events: none;
        z-index: 0;
        background-image:
            repeating-linear-gradient(0deg,
                transparent,
                transparent 20px,
                var(--aitsc-primary) 20px,
                var(--aitsc-primary) 21px),
            repeating-linear-gradient(90deg,
                transparent,
                transparent 20px,
                var(--aitsc-primary) 20px,
                var(--aitsc-primary) 21px);
        background-size: 40px 40px;
    }

    /* Decorative cyan squares */
    .footer-pattern-overlay::before {
        content: '';
        position: absolute;
        top: 20%;
        right: 10%;
        width: 60px;
        height: 60px;
        background-color: var(--aitsc-primary);
        opacity: 0.08;
        transform: rotate(15deg);
    }

    .footer-pattern-overlay::after {
        content: '';
        position: absolute;
        bottom: 30%;
        left: 15%;
        width: 40px;
        height: 40px;
        background-color: var(--aitsc-primary);
        opacity: 0.06;
        transform: rotate(-10deg);
    }

    .footer-container {
        position: relative;
        z-index: 1;
    }

    .footer-widgets-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 3rem;
        margin-bottom: 3rem;
    }

    .footer-branding {
        margin-bottom: 1.5rem;
    }

    .footer-branding img {
        filter: none;
    }

    .site-title-footer {
        font-weight: 800;
        color: var(--aitsc-text-primary);
        font-size: var(--font-size-xl);
    }

    .footer-desc {
        margin-bottom: 1.5rem;
        max-width: 320px;
        line-height: 1.6;
        color: var(--aitsc-text-secondary);
    }

    .footer-contact {
        color: var(--aitsc-text-secondary);
    }

    .footer-contact strong {
        color: var(--aitsc-text-primary);
    }

    .footer-heading {
        color: var(--aitsc-text-primary);
        font-weight: 600;
        margin-bottom: 1.5rem;
        font-size: var(--font-size-sm);
        letter-spacing: 0.05em;
    }

    .footer-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-menu li {
        margin-bottom: 0.75rem;
    }

    .footer-menu a {
        color: var(--aitsc-text-secondary);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .footer-menu a:hover,
    .footer-menu a:focus {
        color: var(--aitsc-primary);
    }

    .site-info {
        border-top: 1px solid var(--aitsc-border);
        padding-top: 2rem;
        display: flex;
        justify-content: space-between;
        font-size: var(--font-size-xs);
        color: var(--aitsc-text-muted);
    }

    .copyright,
    .credits {
        color: var(--aitsc-text-muted);
    }

    @media (max-width: 61.9375rem) {
        .footer-widgets-grid {
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
    }

    @media (max-width: 47.9375rem) {
        .site-footer {
            padding: 3rem 0 1.5rem;
        }

        .footer-widgets-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .footer-desc {
            max-width: 100%;
        }

        .site-info {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
    }
</style>