<?php
/**
 * Template Part: Latest Perspectives (Blog Insights)
 */

// Get latest 3 posts
$latest_posts = new WP_Query([
    'posts_per_page' => 3,
    'post_status' => 'publish',
]);

if (!$latest_posts->have_posts()) {
    return;
}
?>

<!-- LATEST PERSPECTIVES SECTION -->
<section class="py-24 bg-slate-950">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12">
            <div class="flex flex-col items-start text-left">
                <h2 class="text-3xl md:text-4xl font-normal text-white mb-2 text-left">Latest Perspectives</h2>
                <p class="text-blue-500 font-medium tracking-widest text-sm uppercase text-left">Insights from the
                    forefront</p>
            </div>
            <a class="hidden md:flex items-center text-sm font-bold text-white hover:text-blue-400 transition-colors"
                href="<?php echo esc_url(site_url('/blog')); ?>">
                View All Insights <span class="material-symbols-outlined text-sm ml-1" aria-hidden="true">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php while ($latest_posts->have_posts()):
                $latest_posts->the_post();

                // Prepare metadata for blog card
                $meta = [
                    'date' => get_the_date('M j, Y'),
                    'category' => '',
                    'read_time' => '',
                ];

                // Get first category
                $categories = get_the_category();
                if (!empty($categories)) {
                    $meta['category'] = $categories[0]->name;
                }

                // Calculate read time (optional)
                $content = get_post_field('post_content', get_the_ID());
                $word_count = str_word_count(strip_tags($content));
                $read_time = ceil($word_count / 200); // Assuming 200 words per minute
                $meta['read_time'] = $read_time . ' min read';

                // Render unified blog card
                aitsc_render_card([
                    'variant' => 'blog',
                    'title' => get_the_title(),
                    'description' => esc_html(wp_trim_words(get_the_excerpt(), 20)),
                    'link' => get_permalink(),
                    'image' => has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium') : '',
                    'cta_text' => 'Read Full Insight',
                    'size' => 'medium',
                    'custom_class' => 'group rounded-xl overflow-hidden',
                    'meta' => $meta
                ]);
            endwhile;
            wp_reset_postdata(); ?>
        </div>
    </div>
</section>