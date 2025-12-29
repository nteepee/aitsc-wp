<?php
/**
 * Template Part: Key Features
 * Clean, professional design
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
                $icon = $feature['feature_icon'] ?? 'check_circle';
                $title = $feature['feature_title'] ?? '';
                $description = $feature['feature_description'] ?? '';
                ?>

                <div class="bg-slate-900/50 backdrop-blur-sm border border-slate-800 hover:border-blue-600/30 rounded-xl p-8 transition-all duration-300"
                    data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">

                    <!-- Icon -->
                    <div
                        class="w-14 h-14 bg-blue-600/10 border border-blue-600/20 rounded-lg flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-3xl text-blue-400">
                            <?php echo esc_html($icon); ?>
                        </span>
                    </div>

                    <!-- Title -->
                    <h3 class="text-xl font-bold text-white mb-3">
                        <?php echo esc_html($title); ?>
                    </h3>

                    <!-- Description -->
                    <p class="text-slate-400 leading-relaxed">
                        <?php echo esc_html($description); ?>
                    </p>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
</section>