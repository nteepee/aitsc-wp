<?php
/**
 * Steps Component
 *
 * Renders a step-by-step guide, either as a simple list or a vertical scroll slider.
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 3.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Steps Block
 *
 * @param array $args {
 *     @type string $title       Section title
 *     @type string $subtitle    Section subtitle
 *     @type string $variant     'slider' (vertical scroll) or 'list' (default)
 *     @type string $id          Section ID
 *     @type array  $steps       Array of step items:
 *         @type string $title       Step title
 *         @type string $description Step description
 *         @type string $icon        Material Symbol icon name
 *         @type array  $tags        Array of tag strings
 * }
 */
function aitsc_render_steps($args = array())
{
    $defaults = array(
        'title' => '',
        'subtitle' => '',
        'variant' => 'slider', // slider, list
        'id' => '',
        'steps' => array()
    );

    $args = wp_parse_args($args, $defaults);

    if (empty($args['steps'])) {
        return;
    }

    $container_id = !empty($args['id']) ? 'id="' . esc_attr($args['id']) . '"' : '';
    $wrapper_class = 'aitsc-steps-wrapper aitsc-steps--' . $args['variant'];
    ?>

    <div <?php echo $container_id; ?> class="<?php echo esc_attr($wrapper_class); ?>">
        <?php if (!empty($args['title']) || !empty($args['subtitle'])): ?>
            <div class="aitsc-steps__header">
                <?php if (!empty($args['title'])): ?>
                    <h3 class="aitsc-steps__title"><?php echo esc_html($args['title']); ?></h3>
                <?php endif; ?>

                <?php if (!empty($args['subtitle'])): ?>
                    <p class="aitsc-steps__subtitle"><?php echo esc_html($args['subtitle']); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($args['variant'] === 'slider'): ?>
            <div class="aitsc-vertical-slider">
                <?php foreach ($args['steps'] as $index => $step):
                    $step_num = sprintf('%02d', $index + 1);
                    $step_id = 'step-' . ($index + 1) . '-' . uniqid();
                    ?>
                    <div class="aitsc-vslide" id="<?php echo esc_attr($step_id); ?>">
                        <div class="aitsc-vslide__visual">
                            <div class="aitsc-vslide__icon">
                                <span class="material-symbols-outlined"><?php echo esc_html($step['icon']); ?></span>
                            </div>
                            <div class="aitsc-vslide__number"><?php echo esc_html($step_num); ?></div>
                        </div>
                        <div class="aitsc-vslide__content">
                            <h4><?php echo esc_html($step['title']); ?></h4>
                            <p><?php echo wp_kses_post($step['description']); ?></p>

                            <?php if (!empty($step['tags'])): ?>
                                <div class="aitsc-vslide__tags">
                                    <?php foreach ($step['tags'] as $tag): ?>
                                        <span class="aitsc-tag"><?php echo esc_html($tag); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Scroll Indicator -->
            <div class="aitsc-vslide-nav">
                <?php foreach ($args['steps'] as $index => $step): ?>
                    <!-- Note: In a real implementation, we'd need JS to handle the anchor links dynamically if multiple sliders exist. 
                         For now, we rely on the CSS scroll-snap. -->
                    <span class="aitsc-vslide-dot" title="<?php echo esc_attr($step['title']); ?>"></span>
                <?php endforeach; ?>
            </div>

        <?php else:  // Simple List Variant ?>
            <div class="aitsc-steps-list">
                <?php foreach ($args['steps'] as $index => $step):
                    $step_num = $index + 1;
                    ?>
                    <div class="aitsc-step-item">
                        <div class="aitsc-step__number"><?php echo esc_html($step_num); ?></div>
                        <div class="aitsc-step__content">
                            <h4><?php echo esc_html($step['title']); ?></h4>
                            <p><?php echo wp_kses_post($step['description']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
}
