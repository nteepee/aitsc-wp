<?php
/**
 * Enhanced Solutions Content Template
 * WorldQuant-inspired professional layout with advanced features
 *
 * @package AITSCProTheme
 * @since 3.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Get all solutions with advanced filtering
$solutions = get_posts(array(
    'post_type' => 'solution',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC'
));

if (!empty($solutions)):
?>

<section class="solutions-section" id="solutions">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header animate-fade-in" data-animation="fadeInUp">
            <h2 class="section-title" data-text-animation="words" data-word-delay="100">
                <?php echo esc_html(get_theme_mod('solutions_title', 'Our Solutions')); ?>
            </h2>
            <p class="section-subtitle" data-animation="fadeInUp" data-delay="300">
                <?php echo esc_html(get_theme_mod('solutions_subtitle', 'Comprehensive technology solutions designed for modern businesses')); ?>
            </p>
        </div>

        <!-- Solution Filter -->
        <div class="solutions-filter animate-slide-up" data-animation="slideUp" data-delay="400">
            <div class="filter-container">
                <div class="filter-buttons" role="group" aria-label="<?php esc_attr_e('Filter solutions by category', 'aitsc-pro'); ?>">
                    <button class="filter-btn active" data-filter="all" role="button" aria-pressed="true">
                        <span><?php esc_html_e('All Solutions', 'aitsc-pro'); ?></span>
                    </button>

                    <?php
                    $categories = get_terms(array(
                        'taxonomy' => 'solution_category',
                        'hide_empty' => true
                    ));

                    foreach ($categories as $category):
                    ?>
                        <button class="filter-btn" data-filter="<?php echo esc_attr($category->slug); ?>" role="button" aria-pressed="false">
                            <span><?php echo esc_html($category->name); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <div class="filter-controls">
                    <button class="filter-toggle" id="filter-toggle" aria-expanded="false" aria-controls="filter-options">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M3 4h18M7 12h10m-7 8h4"/>
                        </svg>
                        <span><?php esc_html_e('Filters', 'aitsc-pro'); ?></span>
                    </button>
                </div>

                <div class="filter-options" id="filter-options" hidden>
                    <div class="filter-group">
                        <label><?php esc_html_e('Sort by:', 'aitsc-pro'); ?></label>
                        <select id="sort-solutions" class="sort-select">
                            <option value="menu_order"><?php esc_html_e('Default', 'aitsc-pro'); ?></option>
                            <option value="title"><?php esc_html_e('Name', 'aitsc-pro'); ?></option>
                            <option value="date"><?php esc_html_e('Date', 'aitsc-pro'); ?></option>
                            <option value="complexity"><?php esc_html_e('Complexity', 'aitsc-pro'); ?></option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label><?php esc_html_e('Industry:', 'aitsc-pro'); ?></label>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" class="industry-filter" value="automotive">
                                <span class="checkmark"></span>
                                <?php esc_html_e('Automotive', 'aitsc-pro'); ?>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" class="industry-filter" value="industrial">
                                <span class="checkmark"></span>
                                <?php esc_html_e('Industrial', 'aitsc-pro'); ?>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" class="industry-filter" value="aerospace">
                                <span class="checkmark"></span>
                                <?php esc_html_e('Aerospace', 'aitsc-pro'); ?>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" class="industry-filter" value="transportation">
                                <span class="checkmark"></span>
                                <?php esc_html_e('Transportation', 'aitsc-pro'); ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Solutions Grid -->
        <div class="solutions-grid stagger-grid">
            <?php foreach ($solutions as $index => $solution): ?>
                <?php
                $thumbnail = get_the_post_thumbnail_url($solution->ID, 'large');
                $icon = get_post_meta($solution->ID, '_solution_icon', true);
                $features = get_post_meta($solution->ID, '_solution_features', true);
                $technologies = get_post_meta($solution->ID, '_solution_technologies', true);
                $complexity = get_post_meta($solution->ID, '_solution_complexity', true);
                $industry_focus = get_post_meta($solution->ID, '_solution_industry_focus', true) ?: array();
                $categories = get_the_terms($solution->ID, 'solution_category');
                $category_slugs = !empty($categories) ? wp_list_pluck($categories, 'slug') : array();

                $delay = $index * 100;
                ?>
                <article class="solution-card animate-scale-in hover-lift magnetic-btn"
                         data-categories="<?php echo esc_attr(implode(',', $category_slugs)); ?>"
                         data-industries="<?php echo esc_attr(implode(',', $industry_focus)); ?>"
                         data-complexity="<?php echo esc_attr($complexity); ?>"
                         data-animation="scaleIn"
                         data-delay="<?php echo esc_attr($delay); ?>"
                         style="animation-delay: <?php echo esc_attr($delay); ?>ms">

                    <!-- Card Header with Image -->
                    <div class="card-header">
                        <?php if ($thumbnail): ?>
                            <div class="solution-image-container tilt-image">
                                <img src="<?php echo esc_url($thumbnail); ?>"
                                     alt="<?php echo esc_attr($solution->post_title); ?>"
                                     loading="lazy"
                                     class="solution-image">
                                <div class="solution-image-overlay">
                                    <div class="overlay-content">
                                        <span class="view-details"><?php esc_html_e('Quick View', 'aitsc-pro'); ?></span>
                                        <svg class="overlay-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Icon and Title -->
                        <div class="solution-icon">
                            <?php if ($icon): ?>
                                <?php echo wp_kses_post($icon); ?>
                            <?php else: ?>
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            <?php endif; ?>
                        </div>

                        <h3 class="solution-title">
                            <a href="<?php echo esc_url(get_permalink($solution->ID)); ?>" class="solution-link">
                                <?php echo esc_html($solution->post_title); ?>
                            </a>
                        </h3>

                        <!-- Category Badges -->
                        <?php if (!empty($categories)): ?>
                            <div class="solution-categories">
                                <?php foreach (array_slice($categories, 0, 2) as $category): ?>
                                    <span class="category-badge"><?php echo esc_html($category->name); ?></span>
                                <?php endforeach; ?>
                                <?php if (count($categories) > 2): ?>
                                    <span class="category-badge">+<?php echo count($categories) - 2; ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Card Content -->
                    <div class="card-content">
                        <div class="solution-description">
                            <?php echo wp_kses_post(wpautop($solution->post_content)); ?>
                        </div>

                        <!-- Key Features -->
                        <?php if (!empty($features) && is_array($features)): ?>
                            <div class="solution-features">
                                <?php foreach (array_slice($features, 0, 3) as $feature): ?>
                                    <?php if (!empty($feature['title'])): ?>
                                        <div class="feature-item">
                                            <svg class="feature-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                            </svg>
                                            <span><?php echo esc_html($feature['title']); ?></span>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php if (count($features) > 3): ?>
                                    <div class="feature-item">
                                        <svg class="feature-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 4v16m8-8H4"/>
                                        </svg>
                                        <span><?php echo esc_html(sprintf('+%d more', count($features) - 3)); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Technologies -->
                        <?php if (!empty($technologies)): ?>
                            <div class="solution-technologies">
                                <?php
                                $tech_array = is_array($technologies) ? $technologies : explode(',', $technologies);
                                $tech_array = array_filter(array_map('trim', $tech_array));
                                $display_tech = array_slice($tech_array, 0, 4);
                                foreach ($display_tech as $tech):
                                    if (!empty($tech)):
                                        ?>
                                        <span class="tech-tag"><?php echo esc_html($tech); ?></span>
                                        <?php
                                    endif;
                                endforeach;

                                if (count($tech_array) > 4):
                                    ?>
                                    <span class="tech-tag">+<?php echo count($tech_array) - 4; ?></span>
                                    <?php
                                endif;
                                ?>
                            </div>
                        <?php endif; ?>

                        <!-- Complexity Indicator -->
                        <?php if ($complexity): ?>
                            <div class="complexity-indicator">
                                <span class="complexity-label"><?php esc_html_e('Timeline:', 'aitsc-pro'); ?></span>
                                <div class="complexity-bar complexity-<?php echo esc_attr($complexity); ?>">
                                    <div class="complexity-fill"></div>
                                </div>
                                <span class="complexity-text">
                                    <?php
                                    $complexity_labels = array(
                                        'standard' => __('1-3 months', 'aitsc-pro'),
                                        'complex' => __('3-6 months', 'aitsc-pro'),
                                        'enterprise' => __('6+ months', 'aitsc-pro')
                                    );
                                    echo esc_html($complexity_labels[$complexity] ?? $complexity);
                                    ?>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer">
                        <a href="<?php echo esc_url(get_permalink($solution->ID)); ?>"
                           class="btn btn-primary ripple-btn">
                            <?php esc_html_e('Learn More', 'aitsc-pro'); ?>
                            <svg class="btn-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M5 12h14m-7-7l7 7-7 7"/>
                            </svg>
                        </a>

                        <button class="btn btn-secondary quick-view-btn"
                                data-solution-id="<?php echo esc_attr($solution->ID); ?>"
                                data-solution-title="<?php echo esc_attr($solution->post_title); ?>">
                            <?php esc_html_e('Quick View', 'aitsc-pro'); ?>
                        </button>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <!-- Statistics Section -->
        <?php if (get_theme_mod('show_solutions_stats', true)): ?>
            <div class="solutions-stats animate-fade-in"
                 data-animation="fadeInUp"
                 data-delay="600">
                <?php
                $stats = array(
                    'clients' => array(
                        'number' => get_theme_mod('stat_clients', '500'),
                        'label' => get_theme_mod('stat_clients_label', 'Happy Clients'),
                        'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>'
                    ),
                    'projects' => array(
                        'number' => get_theme_mod('stat_projects', '1200'),
                        'label' => get_theme_mod('stat_projects_label', 'Projects Completed'),
                        'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>'
                    ),
                    'experience' => array(
                        'number' => get_theme_mod('stat_years', '15'),
                        'label' => get_theme_mod('stat_years_label', 'Years Experience'),
                        'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>'
                    ),
                    'expertise' => array(
                        'number' => get_theme_mod('stat_expertise', '24/7'),
                        'label' => get_theme_mod('stat_expertise_label', 'Expert Support'),
                        'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>'
                    )
                );
                ?>

                <div class="stats-grid">
                    <?php foreach ($stats as $key => $stat): ?>
                        <div class="stat-item hover-scale">
                            <div class="stat-icon">
                                <?php echo wp_kses_post($stat['icon']); ?>
                            </div>
                            <div class="stat-number"
                                 data-count="<?php echo esc_attr(preg_replace('/[^0-9]/', '', $stat['number'])); ?>"
                                 data-prefix="<?php echo esc_attr(preg_replace('/[0-9]/', '', $stat['number'])); ?>"
                                 data-duration="2000">
                                <?php echo esc_html($stat['number']); ?>
                            </div>
                            <div class="stat-label">
                                <?php echo esc_html($stat['label']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- CTA Section -->
        <?php if (get_theme_mod('show_solutions_cta', true)): ?>
            <div class="solutions-cta animate-slide-up"
                 data-animation="slideUp"
                 data-delay="800">
                <div class="cta-content">
                    <h3 class="cta-title" data-text-animation="words" data-word-delay="150">
                        <?php echo esc_html(get_theme_mod('solutions_cta_title', 'Ready to transform your business?')); ?>
                    </h3>
                    <p class="cta-description" data-animation="fadeInUp" data-delay="300">
                        <?php echo esc_html(get_theme_mod('solutions_cta_description', 'Let\'s discuss how our solutions can help you achieve your goals.')); ?>
                    </p>
                    <div class="cta-actions">
                        <a href="<?php echo esc_url(get_theme_mod('solutions_primary_cta_link', '#contact')); ?>"
                           class="btn btn-primary btn-large ripple-btn magnetic-btn">
                            <?php echo esc_html(get_theme_mod('solutions_primary_cta_text', 'Get Started')); ?>
                            <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M5 12h14m-7-7l7 7-7 7"/>
                            </svg>
                        </a>
                        <a href="<?php echo esc_url(get_theme_mod('solutions_secondary_cta_link', '#contact')); ?>"
                           class="btn btn-secondary btn-large">
                            <?php echo esc_html(get_theme_mod('solutions_secondary_cta_text', 'Schedule a Consultation')); ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- No Results Message -->
        <div class="no-results" id="no-solutions-results" style="display: none;">
            <div class="no-results-content">
                <svg class="no-results-icon" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.35-4.35"/>
                </svg>
                <h3><?php esc_html_e('No solutions found', 'aitsc-pro'); ?></h3>
                <p><?php esc_html_e('Try adjusting your filters or browse all solutions.', 'aitsc-pro'); ?></p>
                <button class="btn btn-secondary clear-filters">
                    <?php esc_html_e('Clear Filters', 'aitsc-pro'); ?>
                </button>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>