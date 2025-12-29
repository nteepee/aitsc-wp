<?php
/**
 * Template Part: Solution Hero Section
 *
 * Modern hero with split layout and prominent product showcase.
 *
 * @package AITSC_Pro_Theme
 */

// Try to get group field first, fallback to individual fields
$hero = get_field('hero_section');
if ($hero && is_array($hero)) {
    $title = $hero['title'] ?? get_the_title();
    $subtitle = $hero['subtitle'] ?? '';
    $cta_text = $hero['cta_text'] ?? 'Get Started';
    $cta_link = $hero['cta_link'] ?? '#contact';
    $bg_image = $hero['image'] ?? '';
} else {
    // Access sub-fields directly
    $title = get_field('hero_section_title') ?: get_the_title();
    $subtitle = get_field('hero_section_subtitle') ?: '';
    $cta_text = get_field('hero_section_cta_text') ?: 'Get Started';
    $cta_link = get_field('hero_section_cta_link') ?: '#contact';
    $bg_image_value = get_field('hero_section_image');
    // Handle both ID and URL formats
    if (is_numeric($bg_image_value)) {
        $bg_image = wp_get_attachment_image_url($bg_image_value, 'full');
    } else {
        $bg_image = $bg_image_value; // Already a URL
    }
}

// Don't return early - show hero even if some fields are empty
if (!$title && !$subtitle) {
    return;
}
?>

<!-- HERO SECTION -->
<section class="relative min-h-screen bg-black flex items-center overflow-hidden">
    <!-- Particle Background Canvas -->
    <canvas id="aitsc-particle-canvas" class="absolute inset-0 w-full h-full"></canvas>

    <!-- Dark Gradient Overlay for Better Text Contrast -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/70 to-black/90 z-[1]"></div>

    <!-- Hero Content Container -->
    <div class="aitsc-hero-split">

        <!-- Left Column: Text Content -->
        <div class="text-content">


            <!-- Overline Badge -->
            <div
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600/20 border border-blue-600/30 rounded-full backdrop-blur-sm">
                <span class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></span>
                <span class="text-sm font-medium text-blue-300">Advanced Safety Technology</span>
            </div>

            <!-- Main Title -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight">
                <?php echo wp_kses_post($title); ?>
            </h1>

            <!-- Subtitle -->
            <?php if ($subtitle): ?>
                <p class="text-lg md:text-xl text-slate-300 leading-relaxed max-w-xl">
                    <?php echo esc_html($subtitle); ?>
                </p>
            <?php endif; ?>

            <!-- Key Features Quick List -->
            <div class="flex flex-wrap gap-6 text-sm text-slate-400">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-400 text-xl">check_circle</span>
                    <span>Real-Time Monitoring</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-400 text-xl">check_circle</span>
                    <span>Plug & Play Setup</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-400 text-xl">check_circle</span>
                    <span>Instant Alerts</span>
                </div>
            </div>

            <!-- CTAs -->
            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <a href="<?php echo esc_url($cta_link); ?>"
                    class="group inline-flex items-center justify-center gap-2 px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50">
                    <span><?php echo esc_html($cta_text); ?></span>
                    <span
                        class="material-symbols-outlined text-xl group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
                <a href="#features"
                    class="inline-flex items-center justify-center gap-2 px-8 py-4 border-2 border-slate-600 hover:border-blue-600 text-slate-300 hover:text-white font-semibold rounded-xl transition-all duration-200 hover:bg-blue-600/10">
                    <span>Learn More</span>
                    <span class="material-symbols-outlined text-xl">expand_more</span>
                </a>
            </div>
        </div>

        <!-- Right Column: Product Image -->
        <div class="image-content">
            <?php if ($bg_image): ?>
                <!-- Product Image with Glow Effect -->
                <div class="relative group w-full">
                    <!-- Glow Background -->
                    <div
                        class="absolute -inset-4 bg-gradient-to-r from-blue-600/20 via-purple-600/20 to-blue-600/20 rounded-3xl blur-2xl opacity-50 group-hover:opacity-75 transition-opacity duration-500">
                    </div>

                    <!-- Main Image -->
                    <div
                        class="relative bg-gradient-to-br from-slate-800/50 to-slate-900/50 backdrop-blur-sm rounded-2xl border border-blue-600/20 p-4 md:p-8 overflow-hidden max-w-full">
                        <img src="<?php echo esc_url($bg_image); ?>" alt="<?php echo esc_attr($title); ?>"
                            class="w-full h-auto max-w-full rounded-lg shadow-2xl transform group-hover:scale-105 transition-transform duration-500 object-contain">

                        <!-- Floating Stats Badge -->
                        <div
                            class="absolute top-4 right-4 bg-black/80 backdrop-blur-md border border-blue-600/30 rounded-xl px-4 py-3 shadow-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-600/20 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-blue-400">verified</span>
                                </div>
                                <div>
                                    <div class="text-xs text-slate-400">Trusted By</div>
                                    <div class="text-sm font-bold text-white">Bus4x4 + More</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Fallback: Icon Grid Pattern -->
                <div
                    class="relative h-96 bg-gradient-to-br from-slate-800/30 to-slate-900/30 backdrop-blur-sm rounded-2xl border border-blue-600/20 flex items-center justify-center">
                    <div class="text-center space-y-4">
                        <div class="w-24 h-24 mx-auto bg-blue-600/20 rounded-2xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-6xl text-blue-400">monitoring</span>
                        </div>
                        <p class="text-slate-400">Product Image</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10 animate-bounce">
        <div
            class="flex flex-col items-center gap-2 text-slate-400 hover:text-blue-400 transition-colors cursor-pointer">
            <span class="text-xs font-medium uppercase tracking-wider">Scroll Down</span>
            <span class="material-symbols-outlined text-2xl">expand_more</span>
        </div>
    </div>
</section>