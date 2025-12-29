<?php
/**
 * Case Studies Preview Section Template Part
 *
 * Features featured case studies with metrics, client logos, and testimonials
 * WorldQuant-inspired design with advanced hover effects
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

// Get customizer settings
$case_studies_title = get_theme_mod('aitsc_case_studies_title', 'Transport Safety Projects');
$case_studies_subtitle = get_theme_mod('aitsc_case_studies_subtitle', 'Recent transport safety consulting projects and client success stories from across Australia');
$case_studies_layout = get_theme_mod('aitsc_case_studies_layout', 'featured'); // featured, grid, carousel
$case_studies_count = get_theme_mod('aitsc_case_studies_count', 3);
$case_studies_show_all = get_theme_mod('aitsc_case_studies_show_all', true);
$case_studies_all_url = get_theme_mod('aitsc_case_studies_all_url', '/case-studies/');
$case_studies_show_metrics = get_theme_mod('aitsc_case_studies_metrics', true);
$case_studies_show_testimonials = get_theme_mod('aitsc_case_studies_testimonials', true);

$section_class = 'case-studies-preview';
$section_class .= ' case-studies-' . $case_studies_layout;

// Query case studies
$case_studies_args = array(
    'post_type'      => 'case_studies',
    'posts_per_page' => $case_studies_count,
    'meta_key'       => 'case_study_featured',
    'meta_value'     => '1',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'post_status'    => 'publish'
);

// If no featured case studies, get latest ones
$featured_query = new WP_Query($case_studies_args);
if (!$featured_query->have_posts()) {
    $case_studies_args = array(
        'post_type'      => 'case_studies',
        'posts_per_page' => $case_studies_count,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_status'    => 'publish'
    );
}

$case_studies_query = new WP_Query($case_studies_args);
?>

<section class="<?php echo esc_attr($section_class); ?> section">
    <div class="container">
        <!-- Section Header -->
        <div class="case-studies-header">
            <h2 class="section-title animate-slide-up">
                <?php echo esc_html($case_studies_title); ?>
            </h2>
            <?php if ($case_studies_subtitle) : ?>
            <p class="section-subtitle animate-slide-up delay-1">
                <?php echo esc_html($case_studies_subtitle); ?>
            </p>
            <?php endif; ?>
        </div>

        <!-- Case Studies Content -->
        <div class="case-studies-container">
            <?php if ($case_studies_query->have_posts()) : ?>

                <?php while ($case_studies_query->have_posts()) : $case_studies_query->the_post(); ?>

                    <?php
                    // Get case study metadata
                    $client_name = get_post_meta(get_the_ID(), 'case_study_client', true);
                    $client_logo = get_post_meta(get_the_ID(), 'case_study_client_logo', true);
                    $industry = get_post_meta(get_the_ID(), 'case_study_industry', true);
                    $challenge = get_post_meta(get_the_ID(), 'case_study_challenge', true);
                    $solution = get_post_meta(get_the_ID(), 'case_study_solution', true);
                    $results = get_post_meta(get_the_ID(), 'case_study_results', true);
                    $testimonial = get_post_meta(get_the_ID(), 'case_study_testimonial', true);
                    $testimonial_author = get_post_meta(get_the_ID(), 'case_study_testimonial_author', true);
                    $metrics = get_post_meta(get_the_ID(), 'case_study_metrics', true);
                    ?>

                    <div class="case-study-item animate-fade-in-up"
                         style="--animation-delay: <?php echo (($case_studies_query->current_post - 1) * 0.15); ?>s;">

                        <div class="case-study-card animate-slide-up">
                            <!-- Card Header -->
                            <div class="case-study-header">
                                <?php if ($client_logo) : ?>
                                <div class="client-logo">
                                    <img src="<?php echo esc_url($client_logo); ?>"
                                         alt="<?php echo esc_attr($client_name ? $client_name : get_the_title()); ?>"
                                         class="logo-image">
                                </div>
                                <?php endif; ?>

                                <div class="case-study-meta">
                                    <?php if ($client_name) : ?>
                                    <div class="client-name">
                                        <?php echo esc_html($client_name); ?>
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($industry) : ?>
                                    <div class="client-industry">
                                        <span class="industry-label"><?php echo esc_html($industry); ?></span>
                                    </div>
                                    <?php endif; ?>

                                    <div class="case-study-date">
                                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                            <?php echo esc_html(get_the_date('F j, Y')); ?>
                                        </time>
                                    </div>
                                </div>
                            </div>

                            <!-- Featured Image -->
                            <?php if (has_post_thumbnail()) : ?>
                            <div class="case-study-featured-image case-study-image">
                                <?php the_post_thumbnail('aitsc-case-study', array('class' => 'featured-image')); ?>
                                <div class="case-study-overlay">
                                    <div class="case-study-meta">
                                        <?php if ($industry) : ?>
                                        <span class="case-category"><?php echo esc_html($industry); ?></span>
                                        <?php endif; ?>
                                        <span class="case-date"><?php echo esc_html(get_the_date('M j, Y')); ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Card Content -->
                            <div class="case-study-content">
                                <h3 class="case-study-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>

                                <!-- Challenge Summary -->
                                <?php if ($challenge) : ?>
                                <div class="case-study-challenge">
                                    <h4 class="challenge-label">Challenge</h4>
                                    <p class="challenge-text">
                                        <?php echo wp_trim_words($challenge, 20, '...'); ?>
                                    </p>
                                </div>
                                <?php endif; ?>

                                <!-- Solution Summary -->
                                <?php if ($solution) : ?>
                                <div class="case-study-solution">
                                    <h4 class="solution-label">Solution</h4>
                                    <p class="solution-text">
                                        <?php echo wp_trim_words($solution, 20, '...'); ?>
                                    </p>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- Results Metrics -->
                            <?php if ($case_studies_show_metrics && !empty($metrics)) : ?>
                            <div class="case-study-metrics">
                                <?php
                                $metrics_array = is_array($metrics) ? $metrics : json_decode($metrics, true);
                                $display_metrics = array_slice($metrics_array, 0, 3); // Show up to 3 metrics
                                ?>
                                <?php foreach ($display_metrics as $metric) : ?>
                                    <?php if (!empty($metric['label']) && !empty($metric['value'])) : ?>
                                    <div class="metric-item">
                                        <div class="metric-value">
                                            <?php echo esc_html($metric['value']); ?>
                                        </div>
                                        <div class="metric-label">
                                            <?php echo esc_html($metric['label']); ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>

                            <!-- Testimonial -->
                            <?php if ($case_studies_show_testimonials && $testimonial) : ?>
                            <div class="case-study-testimonial">
                                <blockquote class="testimonial-quote">
                                    <div class="quote-text">
                                        <?php echo esc_html($testimonial); ?>
                                    </div>
                                    <?php if ($testimonial_author) : ?>
                                    <cite class="testimonial-author">
                                        — <?php echo esc_html($testimonial_author); ?>
                                    </cite>
                                    <?php endif; ?>
                                </blockquote>
                            </div>
                            <?php endif; ?>

                            <!-- Card Footer -->
                            <div class="case-study-footer">
                                <a href="<?php the_permalink(); ?>" class="btn btn-neon">
                                    View Case Study
                                    <span class="btn-arrow dashicons dashicons-arrow-right-alt"></span>
                                </a>

                                <?php if (get_post_meta(get_the_ID(), 'case_study_demo_url', true)) : ?>
                                <a href="<?php echo esc_url(get_post_meta(get_the_ID(), 'case_study_demo_url', true)); ?>"
                                   class="btn btn-outline" target="_blank" rel="noopener">
                                    View Demo
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                <?php endwhile; wp_reset_postdata(); ?>

            <?php else : ?>
                <div class="no-case-studies">
                    <p><?php esc_html_e('No case studies found.', 'aitsc-pro-theme'); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Show All Button -->
        <?php if ($case_studies_show_all) : ?>
        <div class="case-studies-footer text-center animate-fade-in-up">
            <a href="<?php echo esc_url($case_studies_all_url); ?>"
               class="btn btn-neon btn-lg">
                View All Case Studies
                <span class="btn-arrow dashicons dashicons-arrow-right-alt"></span>
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php
/**
 * Inline styles for dynamic settings
 */
$case_studies_custom_styles = '';

// Layout-specific styles
switch ($case_studies_layout) {
    case 'featured':
        $case_studies_custom_styles .= '
        .case-studies-preview.case-studies-featured .case-studies-container {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }
        .case-studies-preview.case-studies-featured .case-study-card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }
        @media (max-width: 47.9375rem) {
            .case-studies-preview.case-studies-featured .case-study-card {
                grid-template-columns: 1fr;
                gap: 24px;
            }
        }';
        break;

    case 'grid':
        $case_studies_custom_styles .= '
        .case-studies-preview.case-studies-grid .case-studies-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }
        @media (max-width: 61.9375rem) {
            .case-studies-preview.case-studies-grid .case-studies-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 47.9375rem) {
            .case-studies-preview.case-studies-grid .case-studies-container {
                grid-template-columns: 1fr;
            }
        }';
        break;

    case 'carousel':
        $case_studies_custom_styles .= '
        .case-studies-preview.case-studies-carousel .case-studies-container {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            gap: 24px;
            padding-bottom: 20px;
        }
        .case-studies-preview.case-studies-carousel .case-study-item {
            min-width: 350px;
            scroll-snap-align: start;
        }';
        break;
}

// Metrics grid layout
if ($case_studies_show_metrics) {
    $case_studies_custom_styles .= '
    .case-study-metrics {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        gap: 16px;
        margin: 24px 0;
        padding: 20px;
        background-color: rgba(0, 92, 178, 0.1);
        border-radius: 8px;
    }
    .metric-item {
        text-align: center;
    }
    .metric-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--aitsc-color-primary, #005cb2);
        margin-bottom: 4px;
    }
    .metric-label {
        font-size: 0.875rem;
        color: var(--aitsc-color-gray, #666);
    }';
}

// Testimonial styling
if ($case_studies_show_testimonials) {
    $case_studies_custom_styles .= '
    .case-study-testimonial {
        padding: 20px;
        background-color: var(--aitsc-color-light, #f5f5f5);
        border-left: 4px solid var(--aitsc-color-primary, #005cb2);
        margin: 20px 0;
    }
    .testimonial-quote {
        margin: 0;
        font-style: italic;
    }
    .quote-text {
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 12px;
    }
    .testimonial-author {
        font-style: normal;
        font-weight: 600;
        color: var(--aitsc-color-primary, #005cb2);
    }';
}

// Animation delays for case study items
$animation_delays = '';
$max_items = min($case_studies_count, $case_studies_query->post_count);
for ($i = 0; $i < $max_items; $i++) {
    $delay = $i * 0.15;
    $animation_delays .= ".case-studies-preview .case-study-item:nth-child(" . ($i + 1) . ") { animation-delay: {$delay}s; }\n";
}

if (!empty($animation_delays)) {
    $case_studies_custom_styles .= $animation_delays;
}

if (!empty($case_studies_custom_styles)) :
    wp_add_inline_style('aitsc-homepage-advanced', $case_studies_custom_styles);
endif;
?>