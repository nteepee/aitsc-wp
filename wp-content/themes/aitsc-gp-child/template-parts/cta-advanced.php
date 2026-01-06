<?php
/**
 * Advanced Call-to-Action Sections Template Part
 *
 * Features multiple CTA layouts with animations, forms, and dynamic content
 * WorldQuant-inspired design with advanced conversion optimization
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

// Get customizer settings
$cta_type = get_theme_mod('aitsc_cta_type', 'standard'); // standard, split, fullwidth, countdown
$cta_background = get_theme_mod('aitsc_cta_background', 'gradient'); // solid, gradient, image, pattern
$cta_title = get_theme_mod('aitsc_cta_title', 'Enhance Your Transport Safety Compliance');
$cta_subtitle = get_theme_mod('aitsc_cta_subtitle', 'Schedule a free consultation with AITSC transport safety experts and discover how our NHVAS accreditation and Chain of Responsibility solutions can protect your business and ensure regulatory compliance.');
$cta_primary_text = get_theme_mod('aitsc_cta_primary_text', 'Get Started');
$cta_primary_url = get_theme_mod('aitsc_cta_primary_url', '#contact');
$cta_secondary_text = get_theme_mod('aitsc_cta_secondary_text', 'Learn More');
$cta_secondary_url = get_theme_mod('aitsc_cta_secondary_url', '/solutions/');

// Advanced CTA features
$cta_show_form = get_theme_mod('aitsc_cta_show_form', false);
$cta_form_type = get_theme_mod('aitsc_cta_form_type', 'simple'); // simple, contact, demo
$cta_show_testimonial = get_theme_mod('aitsc_cta_testimonial', false);
$cta_show_urgency = get_theme_mod('aitsc_cta_urgency', false);
$cta_countdown_date = get_theme_mod('aitsc_cta_countdown_date', '');

// Background settings
$cta_bg_color = get_theme_mod('aitsc_cta_bg_color', '#005cb2');
$cta_bg_image = get_theme_mod('aitsc_cta_bg_image');
$cta_bg_pattern = get_theme_mod('aitsc_cta_bg_pattern');
$cta_overlay_opacity = get_theme_mod('aitsc_cta_overlay_opacity', 0.9);

// Get testimonial content
$cta_testimonial_text = get_theme_mod('aitsc_cta_testimonial_text');
$cta_testimonial_author = get_theme_mod('aitsc_cta_testimonial_author');

$section_class = 'cta-advanced';
$section_class .= ' cta-' . $cta_type;
$section_class .= ' cta-bg-' . $cta_background;

// Urgency indicators
if ($cta_show_urgency) {
    $section_class .= ' cta-urgency';
}
?>

<section class="<?php echo esc_attr($section_class); ?> section"
         <?php if ($cta_bg_color && $cta_background === 'solid') : ?>
         style="background-color: <?php echo esc_attr($cta_bg_color); ?>;"
         <?php endif; ?>>

    <!-- Background Layer -->
    <div class="cta-background">
        <?php if ($cta_background === 'image' && $cta_bg_image) : ?>
        <div class="cta-bg-image"
             style="background-image: url(<?php echo esc_url($cta_bg_image); ?>);">
        </div>
        <?php endif; ?>

        <?php if ($cta_background === 'pattern' && $cta_bg_pattern) : ?>
        <div class="cta-bg-pattern"
             style="background-image: url(<?php echo esc_url($cta_bg_pattern); ?>);">
        </div>
        <?php endif; ?>

        <?php if ($cta_background === 'gradient') : ?>
        <div class="cta-bg-gradient"></div>
        <?php endif; ?>

        <!-- Overlay for image/pattern backgrounds -->
        <?php if (in_array($cta_background, ['image', 'pattern'])) : ?>
        <div class="cta-overlay" style="opacity: <?php echo esc_attr($cta_overlay_opacity); ?>;"></div>
        <?php endif; ?>
    </div>

    <div class="container">
        <?php if ($cta_type === 'standard') : ?>

            <!-- Standard CTA Layout -->
            <div class="cta-standard animate-fade-in-up">
                <div class="cta-content text-center">
                    <?php if ($cta_show_urgency) : ?>
                    <div class="cta-urgency-badge animate-pulse">
                        <span class="urgency-icon dashicons dashicons-clock"></span>
                        <span class="urgency-text">Limited Time Offer</span>
                    </div>
                    <?php endif; ?>

                    <h2 class="cta-title">
                        <?php echo wp_kses_post($cta_title); ?>
                    </h2>

                    <?php if ($cta_subtitle) : ?>
                    <p class="cta-subtitle">
                        <?php echo esc_html($cta_subtitle); ?>
                    </p>
                    <?php endif; ?>

                    <?php if ($cta_show_testimonial && $cta_testimonial_text) : ?>
                    <div class="cta-testimonial">
                        <blockquote class="testimonial-quote">
                            "<?php echo esc_html($cta_testimonial_text); ?>"
                            <?php if ($cta_testimonial_author) : ?>
                            <cite>— <?php echo esc_html($cta_testimonial_author); ?></cite>
                            <?php endif; ?>
                        </blockquote>
                    </div>
                    <?php endif; ?>

                    <div class="cta-buttons">
                        <a href="<?php echo esc_url($cta_primary_url); ?>"
                           class="btn btn-neon btn-lg cta-primary">
                            <?php echo esc_html($cta_primary_text); ?>
                            <span class="btn-arrow dashicons dashicons-arrow-right-alt"></span>
                        </a>
                        <?php if ($cta_secondary_text) : ?>
                        <a href="<?php echo esc_url($cta_secondary_url); ?>"
                           class="btn btn-outline btn-lg cta-secondary">
                            <?php echo esc_html($cta_secondary_text); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        <?php elseif ($cta_type === 'split') : ?>

            <!-- Split CTA Layout -->
            <div class="cta-split animate-fade-in-up">
                <div class="cta-content">
                    <div class="cta-left">
                        <?php if ($cta_show_urgency) : ?>
                        <div class="cta-urgency-badge animate-pulse">
                            <span class="urgency-icon dashicons dashicons-clock"></span>
                            <span class="urgency-text">Limited Time Offer</span>
                        </div>
                        <?php endif; ?>

                        <h2 class="cta-title">
                            <?php echo wp_kses_post($cta_title); ?>
                        </h2>

                        <?php if ($cta_subtitle) : ?>
                        <p class="cta-subtitle">
                            <?php echo esc_html($cta_subtitle); ?>
                        </p>
                        <?php endif; ?>

                        <div class="cta-buttons">
                            <a href="<?php echo esc_url($cta_primary_url); ?>"
                               class="btn btn-neon btn-lg cta-primary">
                                <?php echo esc_html($cta_primary_text); ?>
                                <span class="btn-arrow dashicons dashicons-arrow-right-alt"></span>
                            </a>
                            <?php if ($cta_secondary_text) : ?>
                            <a href="<?php echo esc_url($cta_secondary_url); ?>"
                               class="btn btn-outline btn-lg cta-secondary">
                                <?php echo esc_html($cta_secondary_text); ?>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="cta-right">
                        <?php if ($cta_show_form) : ?>
                            <?php get_template_part('template-parts/forms/cta', $cta_form_type); ?>
                        <?php elseif ($cta_show_testimonial && $cta_testimonial_text) : ?>
                        <div class="cta-testimonial-card">
                            <div class="testimonial-icon">
                                <span class="dashicons dashicons-format-quote"></span>
                            </div>
                            <blockquote class="testimonial-quote">
                                <?php echo esc_html($cta_testimonial_text); ?>
                                <?php if ($cta_testimonial_author) : ?>
                                <cite>— <?php echo esc_html($cta_testimonial_author); ?></cite>
                                <?php endif; ?>
                            </blockquote>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        <?php elseif ($cta_type === 'fullwidth') : ?>

            <!-- Fullwidth CTA Layout -->
            <div class="cta-fullwidth">
                <div class="cta-content animate-fade-in-up">
                    <div class="cta-header">
                        <?php if ($cta_show_urgency) : ?>
                        <div class="cta-urgency-badge animate-pulse">
                            <span class="urgency-icon dashicons dashicons-clock"></span>
                            <span class="urgency-text">Limited Time Offer</span>
                        </div>
                        <?php endif; ?>

                        <h2 class="cta-title">
                            <?php echo wp_kses_post($cta_title); ?>
                        </h2>
                    </div>

                    <div class="cta-body">
                        <div class="cta-row">
                            <div class="cta-col">
                                <?php if ($cta_subtitle) : ?>
                                <p class="cta-subtitle">
                                    <?php echo esc_html($cta_subtitle); ?>
                                </p>
                                <?php endif; ?>

                                <div class="cta-buttons">
                                    <a href="<?php echo esc_url($cta_primary_url); ?>"
                                       class="btn btn-neon btn-lg cta-primary">
                                        <?php echo esc_html($cta_primary_text); ?>
                                        <span class="btn-arrow dashicons dashicons-arrow-right-alt"></span>
                                    </a>
                                </div>
                            </div>

                            <div class="cta-col">
                                <?php if ($cta_show_form) : ?>
                                    <?php get_template_part('template-parts/forms/cta', $cta_form_type); ?>
                                <?php elseif ($cta_show_testimonial && $cta_testimonial_text) : ?>
                                <div class="cta-testimonial">
                                    <blockquote class="testimonial-quote">
                                        "<?php echo esc_html($cta_testimonial_text); ?>"
                                        <?php if ($cta_testimonial_author) : ?>
                                        <cite>— <?php echo esc_html($cta_testimonial_author); ?></cite>
                                        <?php endif; ?>
                                    </blockquote>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif ($cta_type === 'countdown') : ?>

            <!-- Countdown CTA Layout -->
            <div class="cta-countdown animate-fade-in-up">
                <div class="cta-content text-center">
                    <?php if ($cta_show_urgency) : ?>
                    <div class="cta-urgency-badge animate-pulse">
                        <span class="urgency-icon dashicons dashicons-clock"></span>
                        <span class="urgency-text">Offer Ends Soon</span>
                    </div>
                    <?php endif; ?>

                    <h2 class="cta-title">
                        <?php echo wp_kses_post($cta_title); ?>
                    </h2>

                    <?php if ($cta_subtitle) : ?>
                    <p class="cta-subtitle">
                        <?php echo esc_html($cta_subtitle); ?>
                    </p>
                    <?php endif; ?>

                    <!-- Countdown Timer -->
                    <?php if ($cta_countdown_date) : ?>
                    <div class="cta-countdown-timer" data-countdown="<?php echo esc_attr($cta_countdown_date); ?>">
                        <div class="countdown-item">
                            <div class="countdown-number days">00</div>
                            <div class="countdown-label">Days</div>
                        </div>
                        <div class="countdown-separator">:</div>
                        <div class="countdown-item">
                            <div class="countdown-number hours">00</div>
                            <div class="countdown-label">Hours</div>
                        </div>
                        <div class="countdown-separator">:</div>
                        <div class="countdown-item">
                            <div class="countdown-number minutes">00</div>
                            <div class="countdown-label">Minutes</div>
                        </div>
                        <div class="countdown-separator">:</div>
                        <div class="countdown-item">
                            <div class="countdown-number seconds">00</div>
                            <div class="countdown-label">Seconds</div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="cta-buttons">
                        <a href="<?php echo esc_url($cta_primary_url); ?>"
                           class="btn btn-neon btn-lg cta-primary animate-bounce">
                            <?php echo esc_html($cta_primary_text); ?>
                            <span class="btn-arrow dashicons dashicons-arrow-right-alt"></span>
                        </a>
                        <?php if ($cta_secondary_text) : ?>
                        <a href="<?php echo esc_url($cta_secondary_url); ?>"
                           class="btn btn-outline btn-lg cta-secondary">
                            <?php echo esc_html($cta_secondary_text); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        <?php endif; ?>

        <!-- Trust Indicators -->
        <?php if (get_theme_mod('aitsc_cta_trust_indicators', false)) : ?>
        <div class="cta-trust-indicators">
            <div class="trust-indicator">
                <span class="trust-icon dashicons dashicons-yes"></span>
                <span class="trust-text">30-Day Money Back Guarantee</span>
            </div>
            <div class="trust-indicator">
                <span class="trust-icon dashicons dashicons-lock"></span>
                <span class="trust-text">100% Secure & Confidential</span>
            </div>
            <div class="trust-indicator">
                <span class="trust-icon dashicons dashicons-admin-users"></span>
                <span class="trust-text">500+ Enterprise Clients</span>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Floating Elements for Visual Interest -->
    <?php if (get_theme_mod('aitsc_cta_floating_elements', false)) : ?>
    <div class="cta-floating-elements">
        <div class="floating-element cta-float-1" data-speed="0.3"></div>
        <div class="floating-element cta-float-2" data-speed="0.5"></div>
        <div class="floating-element cta-float-3" data-speed="0.4"></div>
    </div>
    <?php endif; ?>
</section>

<?php
/**
 * Inline styles for dynamic settings
 */
$cta_custom_styles = '';

// Background gradient
if ($cta_background === 'gradient') {
    $cta_custom_styles .= '
    .cta-bg-gradient {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, ' . ($cta_bg_color ? esc_attr($cta_bg_color) : '#005cb2') . ', #003d7a);
        z-index: 1;
    }';
}

// Text colors for contrast
if (in_array($cta_background, ['image', 'pattern', 'gradient'])) {
    $cta_custom_styles .= '
    .cta-advanced {
        color: white;
    }
    .cta-advanced .cta-title {
        color: white;
    }
    .cta-advanced .cta-subtitle {
        color: rgba(255, 255, 255, 0.9);
    }
    .cta-advanced .btn-outline {
        border-color: white;
        color: white;
    }
    .cta-advanced .btn-outline:hover {
        background-color: white;
        color: ' . ($cta_bg_color ? esc_attr($cta_bg_color) : '#005cb2') . ';
    }';
}

// Layout-specific styles
switch ($cta_type) {
    case 'split':
        $cta_custom_styles .= '
        .cta-split .cta-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        @media (max-width: 61.9375rem) {
            .cta-split .cta-content {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
            }
        }';
        break;

    case 'fullwidth':
        $cta_custom_styles .= '
        .cta-fullwidth .cta-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        @media (max-width: 61.9375rem) {
            .cta-fullwidth .cta-row {
                grid-template-columns: 1fr;
                gap: 40px;
            }
        }';
        break;
}

// Trust indicators
if (get_theme_mod('aitsc_cta_trust_indicators', false)) {
    $cta_custom_styles .= '
    .cta-trust-indicators {
        display: flex;
        justify-content: center;
        gap: 40px;
        margin-top: 40px;
        flex-wrap: wrap;
    }
    .trust-indicator {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.875rem;
        opacity: 0.9;
    }
    .trust-icon {
        font-size: 16px;
    }
    @media (max-width: 47.9375rem) {
        .cta-trust-indicators {
            gap: 24px;
        }
        .trust-indicator {
            flex-direction: column;
            text-align: center;
            gap: 4px;
        }
    }';
}

// Floating elements
if (get_theme_mod('aitsc_cta_floating_elements', false)) {
    $cta_custom_styles .= '
    .cta-floating-elements {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
        overflow: hidden;
    }
    .cta-float-1, .cta-float-2, .cta-float-3 {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        animation: float 20s infinite ease-in-out;
    }
    .cta-float-1 {
        width: 100px;
        height: 100px;
        top: 10%;
        left: 10%;
    }
    .cta-float-2 {
        width: 150px;
        height: 150px;
        top: 60%;
        right: 10%;
        animation-delay: 5s;
    }
    .cta-float-3 {
        width: 80px;
        height: 80px;
        bottom: 10%;
        left: 30%;
        animation-delay: 10s;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-30px) rotate(180deg); }
    }';
}

if (!empty($cta_custom_styles)) :
    wp_add_inline_style('aitsc-homepage-advanced', $cta_custom_styles);
endif;
?>