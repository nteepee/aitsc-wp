<?php
/**
 * Template Part: Related Case Studies
 *
 * Displays related case study cards.
 *
 * @package AITSC_Pro_Theme
 */

$case_studies = get_field('related_case_studies');
if (!$case_studies) {
    return;
}
?>

<!-- RELATED CASE STUDIES SECTION -->
<section class="section full-width bg-slate-950/30 py-16 md:py-20" data-aos="fade-up" data-aos-duration="1000">
    <div class="container max-w-7xl mx-auto px-4 md:px-8">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-12 text-center">Related Case Studies</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($case_studies as $post_id): ?>
                <?php
                $title = get_the_title($post_id);
                $excerpt = get_the_excerpt($post_id);
                $permalink = get_permalink($post_id);
                $thumbnail = get_the_post_thumbnail_url($post_id, 'medium');
                $client = get_post_meta($post_id, '_case_study_client', true);
                $industry = get_post_meta($post_id, '_case_study_client_industry', true);
                ?>

                <div class="bg-gradient-to-br from-blue-600/10 to-purple-600/10 border border-blue-600/20 rounded-xl overflow-hidden hover:border-blue-600/60 transition-all duration-300 group">
                    <?php if ($thumbnail): ?>
                        <div class="relative h-48 overflow-hidden">
                            <img src="<?php echo esc_url($thumbnail); ?>"
                                 alt="<?php echo esc_attr($title); ?>"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                    <?php endif; ?>

                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-blue-300 transition-colors">
                            <?php echo esc_html($title); ?>
                        </h3>

                        <?php if ($excerpt): ?>
                            <p class="text-sm text-slate-400 mb-4 line-clamp-3">
                                <?php echo esc_html($excerpt); ?>
                            </p>
                        <?php endif; ?>

                        <!-- Metadata -->
                        <div class="flex items-center justify-between pt-4 border-t border-blue-600/20 text-sm">
                            <?php if ($client): ?>
                                <span class="text-blue-400"><?php echo esc_html($client); ?></span>
                            <?php endif; ?>
                            <?php if ($industry): ?>
                                <span class="text-slate-400"><?php echo esc_html($industry); ?></span>
                            <?php endif; ?>
                        </div>

                        <a href="<?php echo esc_url($permalink); ?>"
                           class="mt-4 inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 transition-colors">
                            <span class="text-sm font-semibold">View Case Study</span>
                            <span class="material-symbols-outlined text-xl">arrow_forward</span>
                        </a>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
</section>
