<?php
/**
 * Image Composition Component
 *
 * 3-4 overlapping images with absolute positioning, rounded corners, and subtle shadows.
 * Creates a dynamic visual composition with responsive stacking on mobile.
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 4.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Image Composition Component
 *
 * @param array $args {
 *     @type array  $images Array of image data [['url' => '', 'alt' => '', 'position' => '']]
 *     @type string $layout Layout style (overlap|grid|stack) default: 'overlap'
 *     @type string $height Container height (default: '500px')
 *     @type string $class Additional CSS classes
 * }
 */
function aitsc_render_image_composition($args = []) {
    $defaults = [
        'images' => [],
        'layout' => 'overlap',
        'height' => '500px',
        'class' => '',
    ];

    $args = wp_parse_args($args, $defaults);

    // Default composition if no images provided
    if (empty($args['images'])) {
        // Check for content directory images
        $content_dir = get_template_directory() . '/ATISC CONTENT/AITSC 2/Photos/';
        $content_uri = get_template_directory_uri() . '/ATISC CONTENT/AITSC 2/Photos/';

        // Use placeholder structure with demo images if available
        $args['images'] = [
            [
                'url' => $content_uri . 'transport-safety-1.jpg',
                'alt' => 'Transport safety equipment in use',
                'position' => 'primary'
            ],
            [
                'url' => $content_uri . 'transport-safety-2.jpg',
                'alt' => 'Safety compliance inspection',
                'position' => 'secondary'
            ],
            [
                'url' => $content_uri . 'transport-safety-3.jpg',
                'alt' => 'Professional safety assessment',
                'position' => 'tertiary'
            ],
            [
                'url' => $content_uri . 'transport-safety-4.jpg',
                'alt' => 'Modern safety technology',
                'position' => 'accent'
            ],
        ];
    }

    $images = $args['images'];
    $layout = esc_attr($args['layout']);
    $height = esc_attr($args['height']);
    $class = esc_attr($args['class']);

    ?>
    <section class="aitsc-image-composition aitsc-image-composition--<?php echo esc_attr($layout); ?> <?php echo esc_attr($class); ?>"
             role="region"
             aria-label="Image composition">
        <div class="aitsc-image-composition__container" style="--composition-height: <?php echo esc_attr($height); ?>;">
            <?php foreach ($images as $index => $image): ?>
                <?php
                $position = !empty($image['position']) ? esc_attr($image['position']) : 'position-' . ($index + 1);
                $url = !empty($image['url']) ? esc_url($image['url']) : '';
                $alt = !empty($image['alt']) ? esc_attr($image['alt']) : 'Composition image ' . ($index + 1);
                ?>
                <div class="aitsc-image-composition__item aitsc-image-composition__item--<?php echo esc_attr($position); ?>"
                     data-index="<?php echo absint($index); ?>">
                    <?php if ($url): ?>
                        <img src="<?php echo $url; ?>"
                             alt="<?php echo $alt; ?>"
                             class="aitsc-image-composition__image"
                             loading="lazy">
                    <?php else: ?>
                        <!-- Placeholder when no image URL provided -->
                        <div class="aitsc-image-composition__placeholder">
                            <span class="aitsc-image-composition__placeholder-text">
                                <?php echo esc_html($alt); ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php
}

/**
 * Image Composition Shortcode Handler
 *
 * Usage: [aitsc_image_composition layout="overlap" height="500px" images="json_encoded_array"]
 */
function aitsc_image_composition_shortcode($atts) {
    $atts = shortcode_atts([
        'layout' => 'overlap',
        'height' => '500px',
        'images' => '',
        'class' => '',
    ], $atts);

    // Parse images JSON if provided
    if (!empty($atts['images'])) {
        $images_data = json_decode(urldecode($atts['images']), true);
        if (is_array($images_data)) {
            $atts['images'] = $images_data;
        }
    }

    ob_start();
    aitsc_render_image_composition($atts);
    return ob_get_clean();
}
add_shortcode('aitsc_image_composition', 'aitsc_image_composition_shortcode');
