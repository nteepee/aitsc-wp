<?php
/**
 * Related Pages Navigation Component
 *
 * Auto-detects and displays related solution pages within same taxonomy
 * with interactive card grid and hover previews
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 3.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Related Pages Navigator
 *
 * @param array $args Component configuration
 *   - post_id (int): Current post ID
 *   - taxonomy (string): Taxonomy to query (default: 'solution_category')
 *   - max_posts (int): Maximum related posts to show (default: 6)
 *   - exclude_current (bool): Exclude current post (default: true)
 *   - title (string): Section title
 *   - subtitle (string): Section subtitle
 */
function aitsc_render_related_pages($args = array()) {
    $defaults = array(
        'post_id' => get_the_ID(),
        'taxonomy' => 'solution_category',
        'max_posts' => 6,
        'exclude_current' => true,
        'title' => 'Related Solutions',
        'subtitle' => 'Explore our complete passenger monitoring system'
    );

    $args = wp_parse_args($args, $defaults);

    // Get current post terms
    $terms = get_the_terms($args['post_id'], $args['taxonomy']);

    if (empty($terms) || is_wp_error($terms)) {
        return;
    }

    $term_ids = wp_list_pluck($terms, 'term_id');

    // Query related posts
    $query_args = array(
        'post_type' => 'solutions',
        'posts_per_page' => $args['max_posts'],
        'post__not_in' => $args['exclude_current'] ? array($args['post_id']) : array(),
        'tax_query' => array(
            array(
                'taxonomy' => $args['taxonomy'],
                'field' => 'term_id',
                'terms' => $term_ids,
            ),
        ),
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );

    $related_query = new WP_Query($query_args);

    if (!$related_query->have_posts()) {
        wp_reset_postdata();
        return;
    }

    ?>
    <!-- Related Pages Navigation -->
    <section class="aitsc-section aitsc-related-pages" data-scroll-trigger>
        <div class="aitsc-container">
            <div class="aitsc-section__header">
                <h2 class="aitsc-section__title"><?php echo esc_html($args['title']); ?></h2>
                <p class="aitsc-section__subtitle"><?php echo esc_html($args['subtitle']); ?></p>
            </div>

            <div class="aitsc-related-pages__grid">
                <?php
                $index = 0;
                while ($related_query->have_posts()):
                    $related_query->the_post();
                    $index++;

                    // Get post data
                    $post_id = get_the_ID();
                    $title = get_the_title();
                    $excerpt = get_the_excerpt();
                    $permalink = get_permalink();
                    $thumbnail = get_the_post_thumbnail_url($post_id, 'medium');

                    // Get post type label
                    $post_terms = get_the_terms($post_id, $args['taxonomy']);
                    $post_type_label = 'Solution';
                    if ($post_terms && !is_wp_error($post_terms)) {
                        // Determine type from title/slug
                        $title_lower = strtolower($title);
                        if (strpos($title_lower, 'installation') !== false) {
                            $post_type_label = 'Guide';
                        } elseif (strpos($title_lower, 'sensor') !== false || strpos($title_lower, 'display') !== false) {
                            $post_type_label = 'Component';
                        } elseif (strpos($title_lower, 'buses') !== false || strpos($title_lower, 'fleet') !== false || strpos($title_lower, 'rideshare') !== false) {
                            $post_type_label = 'Use Case';
                        } else {
                            $post_type_label = 'Product';
                        }
                    }
                    ?>
                    <article class="aitsc-related-card" data-animation-delay="<?php echo esc_attr($index * 100); ?>">
                        <a href="<?php echo esc_url($permalink); ?>" class="aitsc-related-card__link">
                            <div class="aitsc-related-card__badge">
                                <?php echo esc_html($post_type_label); ?>
                            </div>

                            <?php if ($thumbnail): ?>
                            <div class="aitsc-related-card__image">
                                <img src="<?php echo esc_url($thumbnail); ?>"
                                     alt="<?php echo esc_attr($title); ?>"
                                     loading="lazy">
                                <div class="aitsc-related-card__overlay"></div>
                            </div>
                            <?php endif; ?>

                            <div class="aitsc-related-card__content">
                                <h3 class="aitsc-related-card__title">
                                    <?php echo esc_html($title); ?>
                                    <span class="material-symbols-outlined">arrow_forward</span>
                                </h3>
                                <?php if ($excerpt): ?>
                                <p class="aitsc-related-card__excerpt">
                                    <?php echo wp_trim_words($excerpt, 15, '...'); ?>
                                </p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </article>
                    <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>

            <!-- View All CTA -->
            <div class="aitsc-related-pages__cta">
                <a href="<?php echo esc_url(home_url('/solutions')); ?>" class="aitsc-btn aitsc-btn--primary">
                    View All Solutions
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>
    <?php
}
