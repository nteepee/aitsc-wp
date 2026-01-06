<?php
/**
 * Template Part: Key Features
 * Clean, professional design - Refactored to use standardized card component
 */

$features = get_field('features') ?: get_field('key_features');
if (!$features) {
    return;
}
?>

<!-- KEY FEATURES SECTION -->
<section id="features"
    class="relative py-20 md:py-28 bg-gradient-to-b from-black via-slate-950 to-black overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0"
            style="background-image: radial-gradient(circle at 2px 2px, rgb(59, 130, 246) 1px, transparent 0); background-size: 40px 40px;">
        </div>
    </div>

    <div class="container relative max-w-7xl mx-auto px-6 md:px-12">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <span
                class="inline-block px-4 py-2 bg-blue-600/10 border border-blue-600/20 rounded-full text-blue-400 text-xs font-semibold tracking-wider uppercase mb-6">
                Key Features
            </span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">
                Advanced Monitoring<br />
                <span class="text-slate-300">Made Simple</span>
            </h2>
            <p class="text-lg text-slate-400 max-w-2xl mx-auto">
                Industry-leading technology designed for seamless integration and reliable performance
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($features as $index => $feature): ?>
                <?php
                // Map ACF fields to card component parameters
                $icon = $feature['feature_icon'] ?? 'check_circle';
                $title = $feature['feature_title'] ?? '';
                $description = $feature['feature_description'] ?? '';

                // Render standardized card component with dark theme overrides
                aitsc_render_card(array(
                    'variant' => 'icon',
                    'icon' => $icon,
                    'title' => $title,
                    'description' => $description,
                    'size' => 'large',
                    'custom_class' => 'bg-slate-900/50 backdrop-blur-sm border-slate-800 hover:border-blue-600/30',
                    'custom_attrs' => array(
                        'data-aos' => 'fade-up',
                        'data-aos-delay' => $index * 100
                    )
                ));
                ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
/* Dark theme icon styling override for solution templates */
.aitsc-card--icon.bg-slate-900\/50 {
    background: rgba(15, 23, 42, 0.5) !important;
}

.aitsc-card--icon.bg-slate-900\/50 .aitsc-card__icon {
    width: 56px;
    height: 56px;
    background: rgba(37, 99, 235, 0.1);
    border: 1px solid rgba(37, 99, 235, 0.2);
    border-radius: 0.5rem;
    color: rgb(96, 165, 250);
    font-size: 1.875rem;
}

.aitsc-card--icon.bg-slate-900\/50 .aitsc-card__icon .material-symbols-outlined {
    font-size: inherit;
}

.aitsc-card--icon.bg-slate-900\/50 .aitsc-card__title {
    color: white;
    font-size: 1.25rem;
    font-weight: 700;
}

.aitsc-card--icon.bg-slate-900\/50 .aitsc-card__description {
    color: rgb(148, 163, 184);
}

.aitsc-card--icon.bg-slate-900\/50:hover .aitsc-card__icon {
    transform: none;
}
</style>