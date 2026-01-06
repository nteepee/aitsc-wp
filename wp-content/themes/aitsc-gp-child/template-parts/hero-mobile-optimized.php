<?php
/**
 * Mobile-Optimized Hero Section Template
 * Enhanced B2B hero with mobile conversion optimization
 * Performance-optimized with lazy loading and animations
 *
 * @package AITSC_Pro_Theme
 * @since 2.0.0
 */

// Mobile-optimized hero settings
$hero_title = get_theme_mod('aitsc_hero_title', 'Excellence in Transport Safety & Compliance');
$hero_subtitle = get_theme_mod('aitsc_hero_subtitle', 'Professional transport safety consulting, NHVAS accreditation, and compliance management for Australian transport companies.');
$hero_primary_text = get_theme_mod('aitsc_hero_primary_text', 'Get Free Consultation');
$hero_secondary_text = get_theme_mod('aitsc_hero_secondary_text', 'Call 1300 AITSC');
$hero_primary_url = get_theme_mod('aitsc_hero_primary_url', '#contact');
$hero_secondary_url = get_theme_mod('aitsc_hero_secondary_url', 'tel:1300000000');
$hero_background_image = get_theme_mod('aitsc_hero_background_image');
$hero_cta_subtitle = get_theme_mod('aitsc_hero_cta_subtitle', 'Trusted by 500+ Australian Companies');
$hero_stats_enabled = get_theme_mod('aitsc_hero_stats_enabled', true);
$hero_mobile_video = get_theme_mod('aitsc_hero_mobile_video');
?>

<!-- Mobile-Optimized Hero Section -->
<section class="hero-section-mobile" id="hero">
    <!-- Background with Performance Optimization -->
    <div class="hero-background">
        <?php if ($hero_background_image) : ?>
            <!-- Mobile-optimized background image with lazy loading -->
            <div class="hero-image-container">
                <picture>
                    <!-- Mobile-first image sources -->
                    <source
                        media="(max-width: 480px)"
                        srcset="<?php echo esc_url(wp_get_attachment_image_src($hero_background_image, 'medium')[0]); ?>"
                        data-srcset="<?php echo esc_url(wp_get_attachment_image_src($hero_background_image, 'medium')[0]); ?>"
                    >
                    <source
                        media="(max-width: 768px)"
                        srcset="<?php echo esc_url(wp_get_attachment_image_src($hero_background_image, 'large')[0]); ?>"
                        data-srcset="<?php echo esc_url(wp_get_attachment_image_src($hero_background_image, 'large')[0]); ?>"
                    >
                    <!-- Fallback for larger screens -->
                    <img
                        class="hero-background-image lazyload"
                        src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1 1'%3E%3C/svg%3E"
                        data-src="<?php echo esc_url(wp_get_attachment_image_url($hero_background_image, 'full')); ?>"
                        alt="<?php esc_attr_e('Transport Safety Background', 'aitsc-pro-theme'); ?>"
                        loading="lazy"
                        decoding="async"
                        width="1920"
                        height="1080"
                    >
                </picture>

                <!-- Overlay gradient for text readability -->
                <div class="hero-overlay"></div>
            </div>
        <?php else : ?>
            <!-- Gradient background fallback -->
            <div class="hero-gradient-background"></div>
        <?php endif; ?>

        <!-- Optional mobile video background -->
        <?php if ($hero_mobile_video && wp_is_mobile()) : ?>
            <div class="hero-video-container">
                <video
                    class="hero-video-mobile lazyload"
                    autoplay
                    muted
                    loop
                    playsinline
                    poster="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1 1'%3E%3C/svg%3E"
                    data-poster="<?php echo esc_url(wp_get_attachment_image_src($hero_background_image, 'large')[0] ?? ''); ?>"
                >
                    <source
                        type="video/mp4"
                        data-src="<?php echo esc_url($hero_mobile_video); ?>"
                    >
                </video>
                <div class="hero-video-overlay"></div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Hero Content Container -->
    <div class="container">
        <div class="hero-content-mobile">

            <!-- Trust Badge for Mobile Conversion -->
            <div class="hero-trust-badge">
                <span class="trust-icon">✓</span>
                <span class="trust-text"><?php echo esc_html($hero_cta_subtitle); ?></span>
            </div>

            <!-- Mobile-Optimized Headlines -->
            <div class="hero-headlines">
                <h1 class="hero-title-mobile" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                    <?php
                    // Split long titles for better mobile readability
                    $title_parts = preg_split('/\s+/', $hero_title, 3, PREG_SPLIT_NO_EMPTY);
                    if (count($title_parts) > 2) : ?>
                        <span class="hero-title-line-1"><?php echo esc_html(implode(' ', array_slice($title_parts, 0, 2))); ?></span>
                        <span class="hero-title-line-2"><?php echo esc_html(implode(' ', array_slice($title_parts, 2))); ?></span>
                    <?php else : ?>
                        <?php echo esc_html($hero_title); ?>
                    <?php endif; ?>
                </h1>

                <p class="hero-subtitle-mobile" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    <?php echo esc_html($hero_subtitle); ?>
                </p>
            </div>

            <!-- Mobile-Optimized CTA Buttons -->
            <div class="hero-cta-mobile" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                <!-- Primary CTA with enhanced mobile styling -->
                <a href="<?php echo esc_url($hero_primary_url); ?>"
                   class="btn btn-neon btn-lg hero-cta-primary"
                   aria-label="<?php esc_attr_e('Get Free Consultation', 'aitsc-pro-theme'); ?>"
                   data-ga-event="click"
                   data-ga-category="hero_cta"
                   data-ga-action="click_primary"
                   data-ga-label="free_consultation">
                    <span class="btn-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 12h18m-9-9l9 9-9 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="btn-text"><?php echo esc_html($hero_primary_text); ?></span>
                </a>

                <!-- Secondary CTA with click-to-call optimization -->
                <a href="<?php echo esc_url($hero_secondary_url); ?>"
                   class="btn btn-outline btn-lg hero-cta-secondary"
                   aria-label="<?php esc_attr_e('Call for Immediate Assistance', 'aitsc-pro-theme'); ?>"
                   data-ga-event="click"
                   data-ga-category="hero_cta"
                   data-ga-action="click_secondary"
                   data-ga-label="call_now">
                    <span class="btn-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="btn-text"><?php echo esc_html($hero_secondary_text); ?></span>
                </a>
            </div>

            <!-- Quick Stats for Trust Building -->
            <?php if ($hero_stats_enabled) : ?>
                <div class="hero-stats-mobile" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                    <div class="stat-item">
                        <div class="stat-number" data-count="500">0</div>
                        <div class="stat-label">Companies Trust</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-count="15">0</div>
                        <div class="stat-label">Years Experience</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-count="98">0</div>
                        <div class="stat-label">Client Satisfaction %</div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Mobile Quick Actions -->
            <div class="hero-quick-actions" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
                <a href="#contact" class="quick-action" data-ga-event="click" data-ga-category="quick_action" data-ga-action="click" data-ga-label="quick_quote">
                    <span class="quick-action-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="quick-action-text">Quick Quote</span>
                </a>

                <a href="#services" class="quick-action" data-ga-event="click" data-ga-category="quick_action" data-ga-action="click" data-ga-label="view_services">
                    <span class="quick-action-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="quick-action-text">Services</span>
                </a>

                <a href="tel:1300000000" class="quick-action call-action" data-ga-event="click" data-ga-category="quick_action" data-ga-action="call" data-ga-label="call_mobile">
                    <span class="quick-action-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="quick-action-text">Call Now</span>
                </a>
            </div>

            <!-- Mobile Compliance Badges -->
            <div class="hero-compliance-badges" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">
                <div class="compliance-badge">
                    <span class="badge-icon">NHVAS</span>
                    <span class="badge-text">Accredited</span>
                </div>
                <div class="compliance-badge">
                    <span class="badge-icon">ISO</span>
                    <span class="badge-text">9001:2015</span>
                </div>
                <div class="compliance-badge">
                    <span class="badge-icon">CoR</span>
                    <span class="badge-text">Compliant</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator for Mobile -->
    <div class="hero-scroll-indicator">
        <div class="scroll-Indicator-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 5v14M19 12l-7 7-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <span class="scroll-indicator-text">Scroll to explore</span>
    </div>
</section>

<!-- Mobile Hero Specific Styles -->
<style>
/* Mobile Hero Layout */
.hero-section-mobile {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
}

/* Hero Background with Performance Optimization */
.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

.hero-image-container {
    position: relative;
    width: 100%;
    height: 100%;
}

.hero-background-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(
        135deg,
        rgba(0, 92, 178, 0.85) 0%,
        rgba(0, 70, 145, 0.9) 50%,
        rgba(0, 225, 40, 0.8) 100%
    );
    opacity: 0.9;
}

.hero-gradient-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(
        135deg,
        #f8fafc 0%,
        #e2e8f0 50%,
        #005cb2 100%
    );
}

/* Mobile Video Optimization */
.hero-video-container {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: none; /* Hidden by default, shown on mobile */
}

@media (max-width: 47.9375rem) {
    .hero-video-container {
        display: block;
    }
}

.hero-video-mobile {
    position: absolute;
    top: 50%;
    left: 50%;
    min-width: 100%;
    min-height: 100%;
    width: auto;
    height: auto;
    transform: translateX(-50%) translateY(-50%);
    object-fit: cover;
}

.hero-video-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(
        135deg,
        rgba(0, 92, 178, 0.7) 0%,
        rgba(0, 70, 145, 0.8) 50%,
        rgba(0, 225, 40, 0.6) 100%
    );
}

/* Hero Content Mobile */
.hero-content-mobile {
    position: relative;
    z-index: 10;
    padding: 2rem 0;
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
}

/* Trust Badge */
.hero-trust-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background-color: rgba(0, 225, 40, 0.15);
    border: 1px solid rgba(0, 225, 40, 0.3);
    border-radius: 50px;
    padding: 0.5rem 1rem;
    margin-bottom: 1.5rem;
    backdrop-filter: blur(10px);
}

.trust-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
    background-color: #00e128;
    color: #000;
    border-radius: 50%;
    font-size: 0.75rem;
    font-weight: bold;
}

.trust-text {
    font-size: 0.875rem;
    font-weight: 600;
    color: #00e128;
}

/* Mobile Headlines */
.hero-headlines {
    margin-bottom: 2rem;
}

.hero-title-mobile {
    font-size: clamp(2rem, 8vw, 3.5rem);
    font-weight: 800;
    line-height: 1.1;
    color: #ffffff;
    margin-bottom: 1rem;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.hero-title-line-1,
.hero-title-line-2 {
    display: block;
}

.hero-title-line-2 {
    color: #00e128;
}

.hero-subtitle-mobile {
    font-size: clamp(1rem, 4vw, 1.25rem);
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 2rem;
    font-weight: 400;
}

/* Mobile CTA Buttons */
.hero-cta-mobile {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 2rem;
    max-width: 320px;
    margin-left: auto;
    margin-right: auto;
}

.hero-cta-primary,
.hero-cta-secondary {
    width: 100%;
    min-height: 52px;
    border-radius: 12px;
    font-size: 1.125rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    text-decoration: none;
    position: relative;
    overflow: hidden;
}

.hero-cta-primary {
    background: linear-gradient(135deg, #00e128 0%, #00c41f 100%);
    color: #000;
    border: 2px solid #00e128;
    box-shadow: 0 8px 25px rgba(0, 225, 40, 0.3);
}

.hero-cta-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(0, 225, 40, 0.4);
}

.hero-cta-secondary {
    background-color: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    border: 2px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
}

.hero-cta-secondary:hover {
    background-color: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-1px);
}

.btn-icon svg {
    width: 20px;
    height: 20px;
}

/* Mobile Stats */
.hero-stats-mobile {
    display: flex;
    justify-content: space-around;
    margin-bottom: 2rem;
    padding: 1.5rem 1rem;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.8);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Quick Actions */
.hero-quick-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.quick-action {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background-color: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50px;
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 600;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.quick-action:hover {
    background-color: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.4);
    color: #ffffff;
    transform: translateY(-2px);
}

.quick-action-icon svg {
    width: 16px;
    height: 16px;
}

.call-action {
    background-color: rgba(0, 225, 40, 0.2);
    border-color: rgba(0, 225, 40, 0.4);
    color: #00e128;
}

.call-action:hover {
    background-color: rgba(0, 225, 40, 0.3);
    border-color: rgba(0, 225, 40, 0.6);
}

/* Compliance Badges */
.hero-compliance-badges {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.compliance-badge {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
    padding: 0.5rem;
    background-color: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    min-width: 60px;
}

.badge-icon {
    font-size: 0.75rem;
    font-weight: 800;
    color: #ffffff;
}

.badge-text {
    font-size: 0.625rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.8);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Scroll Indicator */
.hero-scroll-indicator {
    position: absolute;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    color: rgba(255, 255, 255, 0.7);
    z-index: 10;
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); }
    40% { transform: translateX(-50%) translateY(-10px); }
    60% { transform: translateX(-50%) translateY(-5px); }
}

.scroll-Indicator-icon svg {
    width: 24px;
    height: 24px;
}

.scroll-indicator-text {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Responsive Optimizations */
@media (max-width: 30rem) {
    .hero-content-mobile {
        padding: 1rem 0;
    }

    .hero-stats-mobile {
        flex-direction: column;
        gap: 1rem;
    }

    .stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-align: left;
    }

    .hero-quick-actions {
        gap: 0.5rem;
    }

    .quick-action {
        padding: 0.5rem 0.75rem;
        font-size: 0.75rem;
    }

    .compliance-badge {
        min-width: 50px;
        padding: 0.375rem;
    }
}

/* Performance Optimizations */
@media (prefers-reduced-motion: reduce) {
    .hero-scroll-indicator {
        animation: none;
    }

    .hero-cta-primary:hover,
    .hero-cta-secondary:hover,
    .quick-action:hover {
        transform: none;
    }
}
</style>

<!-- Mobile Hero Performance Scripts -->
<script>
// Mobile-specific performance optimizations
document.addEventListener('DOMContentLoaded', function() {
    // Optimize image loading for mobile
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazyload');
                        observer.unobserve(img);
                    }
                }
            });
        });

        document.querySelectorAll('.lazyload').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Animate stats counter on mobile
    if (window.innerWidth <= 768) {
        const animateCounter = (element, target, duration = 2000) => {
            let start = 0;
            const increment = target / (duration / 16);
            const timer = setInterval(() => {
                start += increment;
                if (start >= target) {
                    element.textContent = target + (element.parentElement.querySelector('.stat-label').textContent.includes('%') ? '%' : '+');
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(start);
                }
            }, 16);
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                    const target = parseInt(entry.target.dataset.count);
                    animateCounter(entry.target, target);
                    entry.target.classList.add('animated');
                }
            });
        });

        document.querySelectorAll('.stat-number').forEach(stat => {
            observer.observe(stat);
        });
    }

    // Mobile touch optimizations
    if ('ontouchstart' in window) {
        document.querySelectorAll('.btn, .quick-action').forEach(element => {
            element.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.98)';
            });

            element.addEventListener('touchend', function() {
                this.style.transform = '';
            });
        });
    }

    // Preload critical resources for mobile
    if ('serviceWorker' in navigator && window.innerWidth <= 768) {
        // You can add service worker registration here
        console.log('Mobile optimizations loaded');
    }
});

// Mobile-specific analytics
if (window.ga && window.innerWidth <= 768) {
    document.querySelectorAll('[data-ga-event="click"]').forEach(element => {
        element.addEventListener('click', function() {
            const category = this.dataset.gaCategory;
            const action = this.dataset.gaAction;
            const label = this.dataset.gaLabel;

            window.ga('send', 'event', category, action, label, {
                nonInteraction: false,
                transport: 'beacon'
            });
        });
    });
}
</script>