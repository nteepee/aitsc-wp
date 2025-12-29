<?php
/**
 * Template Part: Technical Specifications
 * Bordered grid layout following wireframe
 */

$specs = get_field('specs');
if (!$specs || empty($specs)) {
    return;
}
?>

<!-- TECHNICAL SPECIFICATIONS SECTION -->
<section class="py-24 bg-[#0a0f1d] relative border-y border-white/5">
    <div class="absolute inset-0 bg-grid-pattern opacity-[0.07] pointer-events-none"
        style="mask-image: linear-gradient(to bottom, transparent, black 10%, black 90%, transparent);"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <div
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-600/20 text-blue-400 text-xs font-bold uppercase tracking-wider mb-4 border border-blue-600/20">
                <span class="material-symbols-outlined text-sm">settings_suggest</span> Technical Specifications
            </div>
            <h2 class="text-3xl md:text-4xl font-semibold text-white mb-4">
                Precision Engineering Down to the Details
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-0 border-t border-l border-white/10">
            <?php foreach ($specs as $index => $spec): ?>
                <?php
                $label = $spec['spec_label'] ?? '';
                $value = $spec['spec_value'] ?? '';
                ?>
                <div class="p-8 border-r border-b border-white/10 hover:bg-white/[0.02] transition-colors">
                    <span class="text-blue-500/60 font-mono text-sm mb-2 block">
                        <?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?>
                    </span>
                    <h4 class="text-lg font-medium text-white mb-2">
                        <?php echo esc_html($label); ?>
                    </h4>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        <?php echo esc_html($value); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-16 text-center">
            <p class="text-slate-400 mb-6 text-sm">Need detailed specifications?</p>
            <a href="<?php echo esc_url(site_url('/contact')); ?>"
                class="inline-flex items-center gap-2 bg-blue-600/10 hover:bg-blue-600/20 text-blue-400 border border-blue-500/50 px-6 py-3 rounded-md text-sm font-medium transition-colors">
                <span class="material-symbols-outlined text-sm">download</span> Request Datasheet
            </a>
        </div>
    </div>
</section>