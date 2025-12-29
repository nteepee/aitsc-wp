<?php
/**
 * Enhanced Case Studies Content Template
 * WorldQuant-inspired professional layout with advanced filtering
 *
 * @package AITSCProTheme
 * @since 3.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Get all case studies with advanced filtering
$case_studies = get_posts(array(
    'post_type' => 'case_study',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC'
));

if (!empty($case_studies)):
?>

<section class="case-studies-section" id="case-studies">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header animate-fade-in" data-animation="fadeInUp">
            <h2 class="section-title" data-text-animation="words" data-word-delay="120">
                <?php echo esc_html(get_theme_mod('case_studies_title', 'Success Stories')); ?>
            </h2>
            <p class="section-subtitle" data-animation="fadeInUp" data-delay="400">
                <?php echo esc_html(get_theme_mod('case_studies_subtitle', 'Discover how we\'ve helped businesses achieve their goals through innovative solutions')); ?>
            </p>
        </div>

        <!-- Advanced Filter System -->
        <div class="case-studies-filter animate-slide-up" data-animation="slideUp" data-delay="500">
            <div class="filter-container">
                <div class="filter-main">
                    <div class="filter-buttons" role="group" aria-label="<?php esc_attr_e('Filter case studies', 'aitsc-pro'); ?>">
                        <button class="filter-btn active" data-filter="all" role="button" aria-pressed="true">
                            <span><?php esc_html_e('All Projects', 'aitsc-pro'); ?></span>
                            <span class="filter-count" data-count="all">0</span>
                        </button>

                        <?php
                        $categories = get_terms(array(
                            'taxonomy' => 'case_study_category',
                            'hide_empty' => true
                        ));

                        foreach ($categories as $category):
                        ?>
                            <button class="filter-btn" data-filter="<?php echo esc_attr($category->slug); ?>" role="button" aria-pressed="false">
                                <span><?php echo esc_html($category->name); ?></span>
                                <span class="filter-count" data-count="<?php echo esc_attr($category->slug); ?>"><?php echo $category->count; ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <div class="filter-controls">
                        <button class="filter-toggle" id="advanced-filter-toggle" aria-expanded="false" aria-controls="advanced-filters">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M3 4h18M7 12h10m-7 8h4"/>
                            </svg>
                            <span><?php esc_html_e('Advanced Filters', 'aitsc-pro'); ?></span>
                        </button>

                        <button class="view-toggle" id="grid-view-toggle" aria-label="<?php esc_attr_e('Switch view', 'aitsc-pro'); ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="view-grid">
                                <rect x="3" y="3" width="7" height="7"/>
                                <rect x="14" y="3" width="7" height="7"/>
                                <rect x="14" y="14" width="7" height="7"/>
                                <rect x="3" y="14" width="7" height="7"/>
                            </svg>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="view-list" style="display: none;">
                                <line x1="8" y1="6" x2="21" y2="6"/>
                                <line x1="8" y1="12" x2="21" y2="12"/>
                                <line x1="8" y1="18" x2="21" y2="18"/>
                                <line x1="3" y1="6" x2="3.01" y2="6"/>
                                <line x1="3" y1="12" x2="3.01" y2="12"/>
                                <line x1="3" y1="18" x2="3.01" y2="18"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="advanced-filters" id="advanced-filters" hidden>
                    <div class="filter-row">
                        <!-- Industry Filter -->
                        <div class="filter-group">
                            <label for="industry-filter" class="filter-label"><?php esc_html_e('Industry', 'aitsc-pro'); ?></label>
                            <select id="industry-filter" class="filter-select" multiple>
                                <option value="automotive"><?php esc_html_e('Automotive', 'aitsc-pro'); ?></option>
                                <option value="industrial"><?php esc_html_e('Industrial', 'aitsc-pro'); ?></option>
                                <option value="aerospace"><?php esc_html_e('Aerospace', 'aitsc-pro'); ?></option>
                                <option value="transportation"><?php esc_html_e('Transportation', 'aitsc-pro'); ?></option>
                                <option value="manufacturing"><?php esc_html_e('Manufacturing', 'aitsc-pro'); ?></option>
                                <option value="healthcare"><?php esc_html_e('Healthcare', 'aitsc-pro'); ?></option>
                            </select>
                        </div>

                        <!-- Team Size Filter -->
                        <div class="filter-group">
                            <label for="team-size-filter" class="filter-label"><?php esc_html_e('Team Size', 'aitsc-pro'); ?></label>
                            <select id="team-size-filter" class="filter-select">
                                <option value=""><?php esc_html_e('Any', 'aitsc-pro'); ?></option>
                                <option value="small"><?php esc_html_e('Small (1-5)', 'aitsc-pro'); ?></option>
                                <option value="medium"><?php esc_html_e('Medium (6-15)', 'aitsc-pro'); ?></option>
                                <option value="large"><?php esc_html_e('Large (16+)', 'aitsc-pro'); ?></option>
                            </select>
                        </div>

                        <!-- Duration Filter -->
                        <div class="filter-group">
                            <label for="duration-filter" class="filter-label"><?php esc_html_e('Duration', 'aitsc-pro'); ?></label>
                            <select id="duration-filter" class="filter-select">
                                <option value=""><?php esc_html_e('Any', 'aitsc-pro'); ?></option>
                                <option value="1-3-months"><?php esc_html_e('1-3 months', 'aitsc-pro'); ?></option>
                                <option value="3-6-months"><?php esc_html_e('3-6 months', 'aitsc-pro'); ?></option>
                                <option value="6-12-months"><?php esc_html_e('6-12 months', 'aitsc-pro'); ?></option>
                                <option value="1-year-plus"><?php esc_html_e('1+ year', 'aitsc-pro'); ?></option>
                            </select>
                        </div>

                        <!-- Technology Filter -->
                        <div class="filter-group">
                            <label for="technology-filter" class="filter-label"><?php esc_html_e('Technology', 'aitsc-pro'); ?></label>
                            <input type="text" id="technology-filter" class="filter-input" placeholder="<?php esc_attr_e('Search technologies...', 'aitsc-pro'); ?>">
                        </div>
                    </div>

                    <div class="filter-actions">
                        <button type="button" class="btn btn-secondary apply-filters">
                            <?php esc_html_e('Apply Filters', 'aitsc-pro'); ?>
                        </button>
                        <button type="button" class="btn btn-outline clear-filters">
                            <?php esc_html_e('Clear All', 'aitsc-pro'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sort Controls -->
        <div class="case-studies-sort animate-fade-in" data-animation="fadeInUp" data-delay="600">
            <div class="sort-container">
                <label for="sort-case-studies" class="sort-label"><?php esc_html_e('Sort by:', 'aitsc-pro'); ?></label>
                <select id="sort-case-studies" class="sort-select">
                    <option value="date-desc"><?php esc_html_e('Most Recent', 'aitsc-pro'); ?></option>
                    <option value="date-asc"><?php esc_html_e('Oldest First', 'aitsc-pro'); ?></option>
                    <option value="title-asc"><?php esc_html_e('Title A-Z', 'aitsc-pro'); ?></option>
                    <option value="title-desc"><?php esc_html_e('Title Z-A', 'aitsc-pro'); ?></option>
                    <option value="duration"><?php esc_html_e('Project Duration', 'aitsc-pro'); ?></option>
                    <option value="team-size"><?php esc_html_e('Team Size', 'aitsc-pro'); ?></option>
                </select>

                <div class="results-count">
                    <span id="results-number"><?php echo count($case_studies); ?></span>
                    <?php esc_html_e('projects found', 'aitsc-pro'); ?>
                </div>
            </div>
        </div>

        <!-- Case Studies Grid -->
        <div class="case-studies-container">
            <div class="case-studies-grid stagger-grid">
                <?php foreach ($case_studies as $index => $case_study): ?>
                    <?php
                    $thumbnail = get_the_post_thumbnail_url($case_study->ID, 'large');
                    $category = get_the_terms($case_study->ID, 'case_study_category');
                    $category_name = !empty($category) ? $category[0]->name : '';
                    $category_slug = !empty($category) ? $category[0]->slug : '';
                    $category_slugs = !empty($category) ? wp_list_pluck($category, 'slug') : array();

                    // Get case study meta
                    $client_name = get_post_meta($case_study->ID, '_case_study_client', true);
                    $client_industry = get_post_meta($case_study->ID, '_case_study_client_industry', true);
                    $project_title = get_post_meta($case_study->ID, '_case_study_project_title', true);
                    $duration = get_post_meta($case_study->ID, '_case_study_duration', true);
                    $team_size = get_post_meta($case_study->ID, '_case_study_team_size', true);
                    $project_budget = get_post_meta($case_study->ID, '_case_study_project_budget', true);
                    $technologies = get_post_meta($case_study->ID, '_case_study_technologies', true);
                    $challenge = get_post_meta($case_study->ID, '_case_study_challenge', true);
                    $results = get_post_meta($case_study->ID, '_case_study_results', true);
                    $gallery_ids = get_post_meta($case_study->ID, '_case_study_gallery', true);

                    // Process technologies
                    $tech_array = is_array($technologies) ? $technologies : explode(',', $technologies);
                    $tech_array = array_filter(array_map('trim', $tech_array));

                    $delay = $index * 100;
                    ?>
                    <article class="case-study-card animate-fade-in hover-lift magnetic-btn"
                             data-category="<?php echo esc_attr($category_slug); ?>"
                             data-categories="<?php echo esc_attr(implode(',', $category_slugs)); ?>"
                             data-client="<?php echo esc_attr(strtolower(str_replace(' ', '-', $client_name ?: ''))); ?>"
                             data-industry="<?php echo esc_attr(strtolower(str_replace(' ', '-', $client_industry ?: ''))); ?>"
                             data-duration="<?php echo esc_attr($duration); ?>"
                             data-team-size="<?php echo esc_attr($team_size); ?>"
                             data-technologies="<?php echo esc_attr(implode(',', $tech_array)); ?>"
                             data-animation="fadeInUp"
                             data-delay="<?php echo esc_attr($delay); ?>"
                             style="animation-delay: <?php echo esc_attr($delay); ?>ms">

                        <!-- Card Image with Overlay -->
                        <div class="case-study-image-container tilt-image">
                            <?php if ($thumbnail): ?>
                                <img src="<?php echo esc_url($thumbnail); ?>"
                                     alt="<?php echo esc_attr($case_study->post_title); ?>"
                                     loading="lazy"
                                     class="case-study-image">
                                <div class="image-overlay">
                                    <div class="overlay-content">
                                        <span class="view-project"><?php esc_html_e('View Project', 'aitsc-pro'); ?></span>
                                        <div class="project-quick-stats">
                                            <?php if ($duration): ?>
                                                <span class="quick-stat">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <path d="M12 2v20m-9-11h18"/>
                                                    </svg>
                                                    <?php echo esc_html($duration); ?>
                                                </span>
                                            <?php endif; ?>

                                            <?php if ($team_size): ?>
                                                <span class="quick-stat">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                                        <circle cx="9" cy="7" r="4"/>
                                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                                    </svg>
                                                    <?php echo esc_html($team_size); ?>
                                                </span>
                                            <?php endif; ?>

                                            <?php if ($gallery_ids): ?>
                                                <span class="quick-stat">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                                        <polyline points="21 15 16 10 5 21"/>
                                                    </svg>
                                                    <?php echo count(explode(',', $gallery_ids)); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($category_name): ?>
                                    <div class="case-study-category">
                                        <?php echo esc_html($category_name); ?>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="placeholder-image">
                                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                        <polyline points="21 15 16 10 5 21"/>
                                    </svg>
                                </div>
                            <?php endif; ?>

                            <!-- Client Badge -->
                            <?php if ($client_name): ?>
                                <div class="client-badge">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                        <circle cx="8.5" cy="7" r="4"/>
                                        <path d="M20 8v6M23 11h-6"/>
                                    </svg>
                                    <span><?php echo esc_html($client_name); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Card Content -->
                        <div class="case-study-content">
                            <h3 class="case-study-title">
                                <a href="<?php echo esc_url(get_permalink($case_study->ID)); ?>" class="case-study-link">
                                    <?php echo esc_html($case_study->post_title); ?>
                                </a>
                            </h3>

                            <?php if ($project_title): ?>
                                <div class="case-study-project-title">
                                    <?php echo esc_html($project_title); ?>
                                </div>
                            <?php endif; ?>

                            <div class="case-study-excerpt">
                                <?php echo esc_html(wp_trim_words($case_study->post_content, 20)); ?>
                            </div>

                            <!-- Project Meta -->
                            <div class="case-study-meta">
                                <?php if ($client_name): ?>
                                    <div class="meta-item">
                                        <svg class="meta-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                            <circle cx="8.5" cy="7" r="4"/>
                                            <path d="M20 8v6M23 11h-6"/>
                                        </svg>
                                        <span><?php esc_html_e('Client:', 'aitsc-pro'); ?></span>
                                        <strong><?php echo esc_html($client_name); ?></strong>
                                    </div>
                                <?php endif; ?>

                                <?php if ($client_industry): ?>
                                    <div class="meta-item">
                                        <svg class="meta-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M3 21h18M5 21V7l8-4v18M13 21V11l8-4v14M9 9v4M12 9v4"/>
                                        </svg>
                                        <span><?php echo esc_html($client_industry); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if ($duration): ?>
                                    <div class="meta-item">
                                        <svg class="meta-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M12 2v20m-9-11h18"/>
                                        </svg>
                                        <span><?php echo esc_html($duration); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Technologies -->
                            <?php if (!empty($tech_array)): ?>
                                <div class="technologies">
                                    <?php foreach (array_slice($tech_array, 0, 3) as $tech): ?>
                                        <?php if (!empty($tech)): ?>
                                            <span class="tech-tag"><?php echo esc_html($tech); ?></span>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php if (count($tech_array) > 3): ?>
                                        <span class="tech-tag">+<?php echo count($tech_array) - 3; ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Card Footer -->
                        <div class="case-study-footer">
                            <?php if ($project_budget): ?>
                                <div class="project-budget">
                                    <span class="budget-label"><?php esc_html_e('Budget:', 'aitsc-pro'); ?></span>
                                    <span class="budget-value"><?php echo esc_html($project_budget); ?></span>
                                </div>
                            <?php endif; ?>

                            <div class="case-study-actions">
                                <a href="<?php echo esc_url(get_permalink($case_study->ID)); ?>"
                                   class="btn btn-primary btn-small ripple-btn">
                                    <?php esc_html_e('View Case Study', 'aitsc-pro'); ?>
                                    <svg class="btn-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M5 12h14m-7-7l7 7-7 7"/>
                                    </svg>
                                </a>

                                <button class="btn btn-secondary btn-small quick-view-btn"
                                        data-case-study-id="<?php echo esc_attr($case_study->ID); ?>"
                                        data-case-study-title="<?php echo esc_attr($case_study->post_title); ?>">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Hidden Data for JavaScript -->
                        <div class="case-study-hidden-data" style="display: none;">
                            <?php
                            $data = array(
                                'id' => $case_study->ID,
                                'title' => $case_study->post_title,
                                'project_title' => $project_title,
                                'excerpt' => wp_trim_words($case_study->post_content, 20),
                                'permalink' => get_permalink($case_study->ID),
                                'thumbnail' => $thumbnail,
                                'client' => $client_name,
                                'client_industry' => $client_industry,
                                'duration' => $duration,
                                'team_size' => $team_size,
                                'project_budget' => $project_budget,
                                'technologies' => $tech_array,
                                'challenge' => $challenge,
                                'results' => $results,
                                'gallery_count' => $gallery_ids ? count(explode(',', $gallery_ids)) : 0,
                                'categories' => !empty($category) ? array_map(function($cat) { return $cat->name; }, $category) : array(),
                                'category_slugs' => $category_slugs
                            );
                            echo '<script type="application/json">' . json_encode($data) . '</script>';
                            ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- List View (Hidden by default) -->
            <div class="case-studies-list" style="display: none;">
                <?php foreach ($case_studies as $case_study): ?>
                    <?php
                    $thumbnail = get_the_post_thumbnail_url($case_study->ID, 'medium');
                    $category = get_the_terms($case_study->ID, 'case_study_category');
                    $client_name = get_post_meta($case_study->ID, '_case_study_client', true);
                    $project_title = get_post_meta($case_study->ID, '_case_study_project_title', true);
                    $duration = get_post_meta($case_study->ID, '_case_study_duration', true);
                    ?>
                    <div class="case-study-list-item animate-fade-in" data-id="<?php echo esc_attr($case_study->ID); ?>">
                        <div class="list-item-image">
                            <?php if ($thumbnail): ?>
                                <img src="<?php echo esc_url($thumbnail); ?>"
                                     alt="<?php echo esc_attr($case_study->post_title); ?>"
                                     loading="lazy">
                            <?php else: ?>
                                <div class="list-item-placeholder">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                        <polyline points="21 15 16 10 5 21"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="list-item-content">
                            <h3 class="list-item-title">
                                <a href="<?php echo esc_url(get_permalink($case_study->ID)); ?>">
                                    <?php echo esc_html($case_study->post_title); ?>
                                </a>
                            </h3>

                            <?php if ($project_title): ?>
                                <div class="list-item-subtitle"><?php echo esc_html($project_title); ?></div>
                            <?php endif; ?>

                            <div class="list-item-meta">
                                <?php if ($client_name): ?>
                                    <span class="meta-tag">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                            <circle cx="8.5" cy="7" r="4"/>
                                        </svg>
                                        <?php echo esc_html($client_name); ?>
                                    </span>
                                <?php endif; ?>

                                <?php if ($category && !empty($category[0])): ?>
                                    <span class="meta-tag category">
                                        <?php echo esc_html($category[0]->name); ?>
                                    </span>
                                <?php endif; ?>

                                <?php if ($duration): ?>
                                    <span class="meta-tag">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M12 2v20m-9-11h18"/>
                                        </svg>
                                        <?php echo esc_html($duration); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="list-item-actions">
                            <a href="<?php echo esc_url(get_permalink($case_study->ID)); ?>"
                               class="btn btn-primary btn-small">
                                <?php esc_html_e('View Details', 'aitsc-pro'); ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Load More Button -->
        <?php if (count($case_studies) > 6): ?>
            <div class="load-more-container animate-fade-in" data-animation="fadeInUp" data-delay="800">
                <button class="btn btn-secondary btn-large" id="load-more-case-studies">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M12 5v14m-7-7h14"/>
                    </svg>
                    <span><?php esc_html_e('Load More Projects', 'aitsc-pro'); ?></span>
                </button>
            </div>
        <?php endif; ?>

        <!-- No Results Message -->
        <div class="no-results" id="no-case-studies-results" style="display: none;">
            <div class="no-results-content animate-scale-in">
                <svg class="no-results-icon" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.35-4.35"/>
                </svg>
                <h3><?php esc_html_e('No case studies found', 'aitsc-pro'); ?></h3>
                <p><?php esc_html_e('Try adjusting your filters or browse all projects.', 'aitsc-pro'); ?></p>
                <div class="no-results-actions">
                    <button class="btn btn-secondary clear-filters">
                        <?php esc_html_e('Clear Filters', 'aitsc-pro'); ?>
                    </button>
                    <a href="#contact" class="btn btn-primary">
                        <?php esc_html_e('Contact Us', 'aitsc-pro'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>