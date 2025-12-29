<?php
/**
 * Advanced Hero Section Template Part
 * Features video background support, animated text, and advanced styling
 * WorldQuant-inspired design with AITSC branding
 *
 * DEBUG: This template part is being loaded
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

// Get customizer settings
$hero_bg_type = get_theme_mod('aitsc_hero_bg_type', 'image'); // image, video, gradient
$hero_bg_image = get_theme_mod('aitsc_hero_bg_image');
$hero_bg_video = get_theme_mod('aitsc_hero_bg_video');
$hero_bg_video_poster = get_theme_mod('aitsc_hero_bg_video_poster');
$hero_gradient_start = get_theme_mod('aitsc_hero_gradient_start', '#005cb2');
$hero_gradient_end = get_theme_mod('aitsc_hero_gradient_end', '#003e80');
$hero_overlay_opacity = get_theme_mod('aitsc_hero_overlay_opacity', 0.8);

$hero_headline = get_theme_mod('aitsc_hero_headline', 'Excellence in Transport Safety & Compliance');
$hero_subheadline = get_theme_mod('aitsc_hero_subheadline', 'AITSC provides comprehensive transport safety consulting, NHVAS accreditation, Chain of Responsibility training, and compliance management solutions for Australian transport and logistics companies.');
$hero_cta_text = get_theme_mod('aitsc_hero_cta_text', 'Get Quote');
$hero_cta_url = get_theme_mod('aitsc_hero_cta_url', '#contact');
$hero_secondary_cta_text = get_theme_mod('aitsc_hero_secondary_cta_text', 'Explore Solutions');
$hero_secondary_cta_url = get_theme_mod('aitsc_hero_secondary_cta_url', '#solutions');

$hero_text_animation = get_theme_mod('aitsc_hero_text_animation', true);
$hero_parallax_effect = get_theme_mod('aitsc_hero_parallax_effect', true);
?>

<section class="hero-advanced"
         <?php if ($hero_parallax_effect) : ?>data-parallax="true"<?php endif; ?>
         <?php if ($hero_bg_type === 'gradient') : ?>
         style="background: linear-gradient(135deg, <?php echo esc_attr($hero_gradient_start); ?>, <?php echo esc_attr($hero_gradient_end); ?>);"
         <?php endif; ?>>

    <!-- Background Layer -->
    <div class="hero-background">
        <?php if ($hero_bg_type === 'image' && $hero_bg_image) : ?>
            <div class="hero-bg-image"
                 style="background-image: url(<?php echo esc_url($hero_bg_image); ?>);">
            </div>
        <?php endif; ?>

        <?php if ($hero_bg_type === 'video' && $hero_bg_video) : ?>
            <div class="hero-bg-video parallax" data-parallax="true">
                <video
                    autoplay
                    muted
                    loop
                    playsinline
                    <?php echo $hero_bg_video_poster ? 'poster="' . esc_url($hero_bg_video_poster) . '"' : ''; ?>
                    class="hero-video">
                    <source src="<?php echo esc_url($hero_bg_video); ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        <?php endif; ?>

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
            <div class="code-line">0.8472 1.2095 0.3341</div>
            <div class="code-line">ALPHA_BETA_7.23_CORR</div>
            <div class="code-line">return optimize(strategy)</div>
            <div class="code-line">dataset.quant_analysis()</div>
            <div class="code-line">std_dev = calc(portfolio)</div>
            <div class="code-line">signal_strength = abs(sharpe)</div>
            <div class="code-line">volatility_30d = measure()</div>
            <div class="code-line">max_drawdown = analyze()</div>
        </div>

        <div class="matrix-rain">
            <div class="matrix-column"></div>
            <div class="matrix-column"></div>
            <div class="matrix-column"></div>
            <div class="matrix-column"></div>
            <div class="matrix-column"></div>
            <div class="matrix-column"></div>
            <div class="matrix-column"></div>
            <div class="matrix-column"></div>
            <div class="matrix-column"></div>
            <div class="matrix-column"></div>
        </div>

        <div class="chart-overlay">
            <div class="chart-line"></div>
        </div>

        <!-- Overlay -->
        <div class="hero-overlay"
             style="opacity: <?php echo esc_attr($hero_overlay_opacity); ?>;">
        </div>
    </div>

    <!-- Content Layer -->
    <div class="hero-content-container">
        <div class="container">
            <div class="hero-content">
                <!-- Animated Headline -->
                <div class="hero-headline-container">
                    <h1 class="hero-headline <?php echo $hero_text_animation ? 'animate-text' : ''; ?>">
                        <?php if ($hero_text_animation) : ?>
                            <span class="animated-text" data-text="<?php echo esc_attr($hero_headline); ?>">
                                <?php echo wp_kses_post($hero_headline); ?>
                            </span>
                        <?php else : ?>
                            <?php echo wp_kses_post($hero_headline); ?>
                        <?php endif; ?>
                    </h1>
                </div>

                <!-- Subheadline -->
                <div class="hero-subheadline-container <?php echo $hero_text_animation ? 'animate-fade-in-up' : ''; ?>">
                    <div class="hero-subheadline">
                        <?php echo wp_kses_post($hero_subheadline); ?>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <?php if ($hero_cta_text) : ?>
                <div class="hero-cta-container <?php echo $hero_text_animation ? 'animate-fade-in-up delay-2' : ''; ?>">
                    <div class="hero-cta">
                        <a href="<?php echo esc_url($hero_cta_url); ?>"
                           class="btn btn-neon btn-lg btn-hero-primary">
                            <?php echo esc_html($hero_cta_text); ?>
                        </a>
                        <?php if ($hero_secondary_cta_text) : ?>
                            <a href="<?php echo esc_url($hero_secondary_cta_url); ?>"
                               class="btn btn-outline btn-lg btn-hero-secondary">
                                <?php echo esc_html($hero_secondary_cta_text); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Scroll Indicator -->
                <?php if (get_theme_mod('aitsc_hero_scroll_indicator', true)) : ?>
                <div class="hero-scroll-indicator <?php echo $hero_text_animation ? 'animate-bounce' : ''; ?>">
                    <div class="scroll-mouse">
                        <div class="scroll-wheel"></div>
                    </div>
                    <span class="scroll-text">Scroll to explore</span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Floating Elements for Visual Interest -->
    <?php if (get_theme_mod('aitsc_hero_floating_elements', false)) : ?>
    <div class="hero-floating-elements">
        <div class="floating-element floating-element-1" data-speed="0.5"></div>
        <div class="floating-element floating-element-2" data-speed="0.3"></div>
        <div class="floating-element floating-element-3" data-speed="0.7"></div>
    </div>
    <?php endif; ?>
</section>

<?php
/**
 * Inline styles for dynamic settings
 */
$hero_custom_styles = '';

// Custom overlay color if different from gradient
if ($hero_bg_type !== 'gradient' && get_theme_mod('aitsc_hero_overlay_color')) {
    $overlay_color = get_theme_mod('aitsc_hero_overlay_color');
    $hero_custom_styles .= ".hero-overlay { background-color: {$overlay_color}; }\n";
}

// Custom text colors
if (get_theme_mod('aitsc_hero_text_color')) {
    $text_color = get_theme_mod('aitsc_hero_text_color');
    $hero_custom_styles .= ".hero-advanced .hero-content { color: {$text_color}; }\n";
}

if (!empty($hero_custom_styles)) :
    wp_add_inline_style('aitsc-homepage-advanced', $hero_custom_styles);
endif;
?>