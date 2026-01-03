<?php
/**
 * Problem-Solution Component
 *
 * Interactive Problem-Agitate-Solution (PAS) framework component
 * with animated problem cards and solution highlight box
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 3.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Problem-Solution Block
 *
 * @param array $args Component configuration
 *   - problems (array): Array of problem cards with icon, title, description
 *   - solution_title (string): Solution section title
 *   - solution_subtitle (string): Solution section subtitle
 *   - solution_text (string): Solution description text
 *   - highlight (array): Highlight box with title and text
 *   - variant (string): Component variant (default: 'default')
 */
function aitsc_render_problem_solution($args = array()) {
    $defaults = array(
        'problems' => array(),
        'solution_title' => 'The Solution',
        'solution_subtitle' => 'Intelligent monitoring with plug-and-play simplicity',
        'solution_text' => '',
        'highlight' => array(
            'title' => '',
            'text' => ''
        ),
        'variant' => 'default'
    );

    $args = wp_parse_args($args, $defaults);

    // Ensure problems is an array
    if (!is_array($args['problems'])) {
        $args['problems'] = array();
    }

    ?>
    <!-- Problem Definition Section -->
    <section class="aitsc-section aitsc-section--problem fade-in-section" data-scroll-trigger>
        <div class="aitsc-container">
            <div class="aitsc-section__header">
                <h2 class="aitsc-section__title">The Challenge</h2>
                <p class="aitsc-section__subtitle">Pain points in modern transport safety</p>
            </div>

            <div class="aitsc-grid aitsc-grid--2-col aitsc-problem-grid">
                <?php foreach ($args['problems'] as $index => $problem): ?>
                <div class="aitsc-problem-card" data-animation-delay="<?php echo esc_attr($index * 100); ?>">
                    <div class="aitsc-problem-card__icon-wrap">
                        <span class="material-symbols-outlined aitsc-problem-card__icon">
                            <?php echo esc_html($problem['icon'] ?? 'warning'); ?>
                        </span>
                        <div class="aitsc-problem-card__pulse"></div>
                    </div>
                    <h3 class="aitsc-problem-card__title">
                        <?php echo esc_html($problem['title'] ?? ''); ?>
                    </h3>
                    <p class="aitsc-problem-card__description">
                        <?php echo esc_html($problem['description'] ?? ''); ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Solution Overview Section -->
    <section class="aitsc-section aitsc-section--solution fade-in-section" data-scroll-trigger>
        <div class="aitsc-container">
            <div class="aitsc-section__header">
                <h2 class="aitsc-section__title"><?php echo esc_html($args['solution_title']); ?></h2>
                <p class="aitsc-section__subtitle"><?php echo esc_html($args['solution_subtitle']); ?></p>
            </div>

            <div class="aitsc-solution-overview">
                <?php if (!empty($args['solution_text'])): ?>
                <div class="aitsc-solution-overview__text">
                    <?php echo wp_kses_post($args['solution_text']); ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($args['highlight']['title']) || !empty($args['highlight']['text'])): ?>
                <div class="aitsc-highlight-box" data-animation="slide-up">
                    <?php if (!empty($args['highlight']['title'])): ?>
                    <div class="aitsc-highlight-box__header">
                        <span class="material-symbols-outlined">check_circle</span>
                        <h4><?php echo esc_html($args['highlight']['title']); ?></h4>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($args['highlight']['text'])): ?>
                    <p><?php echo esc_html($args['highlight']['text']); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}
