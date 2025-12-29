<?php
/**
 * The template for displaying the footer
 */
?>

<footer id="colophon" class="site-footer">
    <div class="container">
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
                    Custom electronics engineering for automotive and transport. From concept to deployment - we solve your most expensive technology problems without spending more.
                </p>
                <div class="footer-contact">
                    <p class="mb-2"><strong class="text-white">1300 AITSC</strong> (1300 000 000)</p>
                    <p><a href="mailto:info@aitsc.au" class="text-grey hover:text-white">info@aitsc.au</a></p>
                </div>
            </div>

            <!-- Column 2: Solutions -->
            <div class="footer-col">
                <h4 class="footer-heading">Engineering Services</h4>
                <ul class="footer-menu">
                    <li><a href="<?php echo esc_url(home_url('/solutions/passenger-monitoring-systems')); ?>">Passenger Monitoring Systems</a></li>
                    <li><a href="<?php echo esc_url(home_url('/solutions/custom-pcb-design')); ?>">Custom PCB Design</a></li>
                    <li><a href="<?php echo esc_url(home_url('/solutions/embedded-systems')); ?>">Embedded Systems</a></li>
                    <li><a href="<?php echo esc_url(home_url('/solutions/automotive-electronics')); ?>">Automotive Electronics</a></li>
                </ul>
            </div>

            <!-- Column 3: Company -->
            <div class="footer-col">
                <h4 class="footer-heading">Company</h4>
                <ul class="footer-menu">
                    <li><a href="<?php echo esc_url(home_url('/about')); ?>">About Us</a></li>
                    <li><a href="<?php echo esc_url(home_url('/case-studies')); ?>">Case Studies</a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a></li>
                </ul>
            </div>

            <!-- Column 4: Quick Links -->
            <div class="footer-col">
                <h4 class="footer-heading">Resources</h4>
                <ul class="footer-menu">
                    <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Free Tech Review</a></li>
                    <li><a href="<?php echo get_post_type_archive_link('solutions'); ?>">All Solutions</a></li>
                    <li><a href="<?php echo get_post_type_archive_link('case-studies'); ?>">Case Studies Archive</a></li>
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
    /* Local Critical CSS for Footer */
    .site-footer {
        background-color: var(--wq-black);
        border-top: 1px solid var(--wq-border);
        padding: var(--space-16) 0 var(--space-8);
        font-size: var(--text-sm);
        color: var(--wq-text-grey);
    }

    .footer-widgets-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: var(--space-12);
        margin-bottom: var(--space-16);
    }

    .footer-branding {
        margin-bottom: var(--space-6);
    }

    .site-title-footer {
        font-weight: 800;
        color: var(--wq-text-white);
        font-size: var(--text-xl);
        text-transform: uppercase;
    }

    .footer-desc {
        margin-bottom: var(--space-6);
        max-width: 300px;
        line-height: 1.6;
    }

    .footer-heading {
        color: var(--wq-text-white);
        text-transform: uppercase;
        margin-bottom: var(--space-6);
        font-size: var(--text-sm);
        letter-spacing: 0.1em;
    }

    .footer-menu {
        list-style: none;
        padding: 0;
    }

    .footer-menu li {
        margin-bottom: var(--space-4);
    }

    .footer-menu a {
        color: var(--wq-text-grey);
        transition: color 0.2s;
    }

    .footer-menu a:hover {
        color: var(--aitsc-primary);
        text-shadow: 0 0 10px rgba(0, 92, 178, 0.4);
    }

    .site-info {
        border-top: 1px solid var(--wq-border);
        padding-top: var(--space-8);
        display: flex;
        justify-content: space-between;
        font-size: var(--text-xs);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--wq-text-muted);
    }

    @media (max-width: 61.9375rem) {
        .footer-widgets-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 47.9375rem) {
        .footer-widgets-grid {
            grid-template-columns: 1fr;
        }

        .site-info {
            flex-direction: column;
            gap: var(--space-4);
            text-align: center;
        }
    }
</style>