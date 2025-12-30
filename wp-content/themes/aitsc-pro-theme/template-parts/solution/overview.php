<?php
/**
 * Template Part: Overview Section
 * Clean centered text layout - Refactored to use standardized components
 */

$overview_text = get_field('overview_text');
if (!$overview_text) {
    return;
}
?>

<!-- OVERVIEW SECTION -->
<section class="py-24 bg-black">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <?php
        global $post;
        if ($post->post_name === 'fleet-safe-pro'):
            $overview_image = get_template_directory_uri() . '/assets/images/fleet-safe-overview.png';
            ?>
            <!-- Fleet Safe Pro 50/50 Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left: Text -->
                <div class="text-left">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-600/10 text-blue-400 text-xs font-bold uppercase tracking-wider mb-6">
                        <span class="material-symbols-outlined text-sm">description</span> Product Overview
                    </div>

                    <?php if (get_field('overview_title')): ?>
                        <h2 class="text-3xl md:text-5xl font-bold text-white mb-8 leading-tight">
                            <?php echo esc_html(get_field('overview_title')); ?>
                        </h2>
                    <?php endif; ?>

                    <div class="text-slate-300 leading-relaxed text-lg space-y-6">
                        <?php echo wp_kses_post(wpautop($overview_text)); ?>
                    </div>
                </div>

                <!-- Right: Image -->
                <div class="relative">
                    <div
                        class="absolute -inset-4 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-3xl blur-2xl opacity-50">
                    </div>
                    <img src="<?php echo esc_url($overview_image); ?>" alt="Fleet Safe Pro Overview"
                        class="relative rounded-2xl shadow-2xl border border-slate-700/50 w-full h-auto object-cover transform hover:scale-[1.02] transition-transform duration-500">
                </div>
            </div>

        <?php else: ?>
            <!-- Standard Centered Layout -->
            <div class="max-w-3xl mx-auto text-center">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-600/10 text-blue-400 text-xs font-bold uppercase tracking-wider mb-6">
                    <span class="material-symbols-outlined text-sm">description</span> Product Overview
                </div>

                <?php if (get_field('overview_title')): ?>
                    <h2 class="text-3xl md:text-4xl font-semibold text-white mb-8">
                        <?php echo esc_html(get_field('overview_title')); ?>
                    </h2>
                <?php endif; ?>

                <div class="text-slate-400 leading-relaxed text-lg space-y-6">
                    <?php echo wp_kses_post(wpautop($overview_text)); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>