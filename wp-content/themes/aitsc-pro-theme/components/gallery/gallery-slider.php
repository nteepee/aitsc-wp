<?php
/**
 * Gallery Component
 *
 * Renders a responsive horizontal scroll slider for product galleries.
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 3.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Gallery Slider
 *
 * @param array $args {
 *     @type string $title       Section title
 *     @type string $subtitle    Section subtitle
 *     @type array  $images      Array of image URLs
 * }
 */
function aitsc_render_gallery($args = array())
{
    $defaults = array(
        'title' => '',
        'subtitle' => '',
        'images' => array()
    );

    $args = wp_parse_args($args, $defaults);

    if (empty($args['images'])) {
        return;
    }

    // Ensure all items are strings (image URLs)
    $gallery_images = array_filter($args['images'], function ($item) {
        return is_string($item) && !empty($item);
    });

    if (empty($gallery_images)) {
        return;
    }
    ?>

    <div class="aitsc-gallery-component">
        <?php if (!empty($args['title']) || !empty($args['subtitle'])): ?>
            <div class="aitsc-container">
                <div class="aitsc-section__header">
                    <?php if (!empty($args['title'])): ?>
                        <h2 class="aitsc-section__title">
                            <?php echo esc_html($args['title']); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if (!empty($args['subtitle'])): ?>
                        <p class="aitsc-section__subtitle">
                            <?php echo esc_html($args['subtitle']); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="aitsc-gallery-slider">
            <div class="aitsc-gallery-track">
                <?php foreach ($gallery_images as $index => $image_url): ?>
                    <div class="aitsc-gallery-slide">
                        <img src="<?php echo esc_url($image_url); ?>" alt="Gallery image <?php echo esc_attr($index + 1); ?>"
                            loading="lazy">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php
}
