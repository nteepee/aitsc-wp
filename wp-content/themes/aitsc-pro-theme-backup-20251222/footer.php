<?php
/**
 * The footer template for AITSC Pro Theme
 *
 * Contains the closing of the #content div and all content after
 *
 * @package AITSCProTheme
 */

?>

<!-- Footer -->
<footer class="site-footer" id="colophon">
    <!-- Main Footer Content -->
    <div class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <!-- Company Information -->
                <div class="footer-section company-info">
                    <div class="footer-branding">
                        <?php
                        if (function_exists('the_custom_logo') && has_custom_logo()):
                            the_custom_logo();
                        else:
                            ?>
                            <h3 class="footer-logo"><?php echo esc_html(get_bloginfo('name')); ?></h3>
                        <?php endif; ?>
                        <p class="footer-tagline"><?php echo esc_html(get_bloginfo('description')); ?></p>
                    </div>

                    <div class="footer-description">
                        <p><?php echo wp_kses_post(get_theme_mod('footer_description', 'Professional technology solutions for modern businesses.')); ?></p>
                    </div>

                    <div class="footer-contact">
                        <?php if (get_theme_mod('footer_email', '')): ?>
                        <div class="contact-item">
                            <svg class="contact-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:<?php echo esc_attr(antispambot(get_theme_mod('footer_email', ''))); ?>">
                                <?php echo esc_html(get_theme_mod('footer_email', '')); ?>
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if (get_theme_mod('footer_phone', '')): ?>
                        <div class="contact-item">
                            <svg class="contact-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
                            </svg>
                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', get_theme_mod('footer_phone', ''))); ?>">
                                <?php echo esc_html(get_theme_mod('footer_phone', '')); ?>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-section">
                    <h3 class="footer-title"><?php echo esc_html(get_theme_mod('footer_links_title', 'Quick Links')); ?></h3>
                    <nav class="footer-menu">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'container'      => false,
                            'menu_class'     => 'footer-links',
                            'depth'          => 1,
                            'fallback_cb'    => false,
                        ));
                        ?>
                    </nav>
                </div>

                <!-- Services -->
                <div class="footer-section">
                    <h3 class="footer-title"><?php echo esc_html(get_theme_mod('footer_services_title', 'Services')); ?></h3>
                    <ul class="footer-links">
                        <?php
                        $services = get_theme_mod('footer_services', array());
                        if (!empty($services) && is_array($services)):
                            foreach ($services as $service):
                                if (!empty($service['title']) && !empty($service['link'])):
                                    ?>
                                    <li>
                                        <a href="<?php echo esc_url($service['link']); ?>">
                                            <?php echo esc_html($service['title']); ?>
                                        </a>
                                    </li>
                                    <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </ul>
                </div>

                <!-- Newsletter & Social -->
                <div class="footer-section newsletter-section">
                    <h3 class="footer-title"><?php echo esc_html(get_theme_mod('footer_newsletter_title', 'Stay Connected')); ?></h3>

                    <?php if (get_theme_mod('show_newsletter', true)): ?>
                    <div class="newsletter-form">
                        <p class="newsletter-description">
                            <?php echo esc_html(get_theme_mod('newsletter_description', 'Get the latest updates and insights delivered to your inbox.')); ?>
                        </p>
                        <form class="newsletter-signup" action="<?php echo esc_url(get_theme_mod('newsletter_action', '#')); ?>" method="POST">
                            <div class="form-group">
                                <input type="email" name="email" placeholder="<?php esc_attr_e('Your email address', 'aitsc-pro'); ?>" required>
                                <button type="submit" class="btn btn-primary btn-small">
                                    <?php esc_html_e('Subscribe', 'aitsc-pro'); ?>
                                </button>
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>

                    <?php if (get_theme_mod('show_social_links', true)): ?>
                    <div class="footer-social">
                        <h4 class="social-title"><?php esc_html_e('Follow Us', 'aitsc-pro'); ?></h4>
                        <div class="social-links">
                            <?php if (get_theme_mod('linkedin_url', '')): ?>
                            <a href="<?php echo esc_url(get_theme_mod('linkedin_url', '#')); ?>"
                               class="social-link" aria-label="LinkedIn">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                </svg>
                            </a>
                            <?php endif; ?>

                            <?php if (get_theme_mod('twitter_url', '')): ?>
                            <a href="<?php echo esc_url(get_theme_mod('twitter_url', '#')); ?>"
                               class="social-link" aria-label="Twitter">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>
                            <?php endif; ?>

                            <?php if (get_theme_mod('github_url', '')): ?>
                            <a href="<?php echo esc_url(get_theme_mod('github_url', '#')); ?>"
                               class="social-link" aria-label="GitHub">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <div class="copyright">
                    <p>&copy; <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>. <?php esc_html_e('All rights reserved.', 'aitsc-pro'); ?></p>
                </div>

                <div class="footer-bottom-links">
                    <?php if (get_theme_mod('show_privacy', true)): ?>
                    <a href="<?php echo esc_url(get_privacy_policy_url()); ?>"><?php esc_html_e('Privacy Policy', 'aitsc-pro'); ?></a>
                    <?php endif; ?>

                    <?php if (get_theme_mod('show_terms', true)): ?>
                    <a href="<?php echo esc_url(get_theme_mod('terms_link', '#')); ?>"><?php esc_html_e('Terms of Service', 'aitsc-pro'); ?></a>
                    <?php endif; ?>

                    <?php if (get_theme_mod('show_sitemap', true)): ?>
                    <a href="<?php echo esc_url(get_theme_mod('sitemap_link', '#')); ?>"><?php esc_html_e('Sitemap', 'aitsc-pro'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</footer>

</div><!-- #content -->

<?php wp_footer(); ?>

</body>
</html>