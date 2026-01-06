<?php
/**
 * Template Part: Flexible Content Sections
 *
 * Renders ACF flexible content layouts.
 *
 * @package AITSC_Pro_Theme
 */

if (!have_rows('solution_sections')) {
    return;
}
?>

<!-- FLEXIBLE CONTENT SECTIONS -->
<?php while (have_rows('solution_sections')): the_row(); ?>

    <?php if (get_row_layout() == 'text_image'): ?>
        <!-- Text + Image Layout -->
        <?php
        $title = get_sub_field('title');
        $content = get_sub_field('content');
        $image = get_sub_field('image');
        $layout = get_sub_field('layout') ?? 'right';
        $image_first = ($layout === 'left');
        ?>

        <section class="section full-width bg-slate-950/30 py-16 md:py-20" data-aos="fade-up">
            <div class="container max-w-7xl mx-auto px-4 md:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center <?php echo $image_first ? 'lg:grid-flow-dense' : ''; ?>">
                    <!-- Text Content -->
                    <div class="<?php echo $image_first ? 'lg:col-start-2' : ''; ?>">
                        <?php if ($title): ?>
                            <h2 class="text-3xl font-bold text-white mb-6"><?php echo esc_html($title); ?></h2>
                        <?php endif; ?>
                        <div class="prose prose-invert prose-lg max-w-none">
                            <?php echo wp_kses_post($content); ?>
                        </div>
                    </div>

                    <!-- Image -->
                    <?php if ($image): ?>
                        <div class="<?php echo $image_first ? 'lg:col-start-1 lg:row-start-1' : ''; ?>">
                            <img src="<?php echo esc_url($image['url']); ?>"
                                 alt="<?php echo esc_attr($image['alt'] ?? $title); ?>"
                                 class="w-full rounded-xl shadow-2xl">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

    <?php elseif (get_row_layout() == 'three_columns'): ?>
        <!-- 3-Column Features Layout -->
        <?php
        $title = get_sub_field('title');
        $items = get_sub_field('items');
        ?>

        <section class="section full-width bg-black py-16 md:py-20" data-aos="fade-up">
            <div class="container max-w-7xl mx-auto px-4 md:px-8">
                <?php if ($title): ?>
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-12 text-center"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <?php foreach ($items as $item): ?>
                        <div class="bg-white/5 border border-blue-600/20 rounded-xl p-8 text-center">
                            <?php if (!empty($item['icon'])): ?>
                                <div class="w-16 h-16 bg-blue-600/20 rounded-xl flex items-center justify-center mx-auto mb-6">
                                    <span class="material-symbols-outlined text-4xl text-blue-400"><?php echo esc_html($item['icon']); ?></span>
                                </div>
                            <?php endif; ?>

                            <h3 class="text-xl font-bold text-white mb-3"><?php echo esc_html($item['title']); ?></h3>
                            <p class="text-slate-400"><?php echo esc_html($item['content']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

    <?php elseif (get_row_layout() == 'video'): ?>
        <!-- Video Section Layout -->
        <?php
        $title = get_sub_field('title');
        $video_url = get_sub_field('video_url');
        ?>

        <section class="section full-width bg-slate-950/50 py-16 md:py-20" data-aos="fade-up">
            <div class="container max-w-7xl mx-auto px-4 md:px-8">
                <?php if ($title): ?>
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-12 text-center"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if ($video_url): ?>
                    <div class="relative aspect-video rounded-xl overflow-hidden shadow-2xl">
                        <?php echo wp_oembed_get($video_url); ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

    <?php endif; ?>

<?php endwhile; ?>
