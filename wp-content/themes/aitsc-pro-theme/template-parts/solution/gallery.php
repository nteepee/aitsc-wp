<?php
/**
 * Template Part: Solution Gallery
 *
 * Displays the product gallery with a horizontal scroll slider.
 */

$solution_id = get_the_ID();

// Try ACF gallery first
$gallery_images = array();
$acf_gallery = get_field('gallery', $solution_id);

if ($acf_gallery && is_array($acf_gallery)) {
    foreach ($acf_gallery as $attachment) {
        // Handle both ID format and array format
        if (is_numeric($attachment)) {
            // ID format
            $url = wp_get_attachment_url($attachment);
            $title = get_the_title($attachment);
            $alt = get_post_meta($attachment, '_wp_attachment_image_alt', true);
        } else {
            // Array format
            $url = $attachment['url'] ?? '';
            $title = $attachment['title'] ?? '';
            $alt = $attachment['alt'] ?? $title;
        }

        if ($url) {
            $gallery_images[] = array(
                'url' => $url,
                'title' => $title,
                'alt' => $alt ?: $title,
            );
        }
    }
}

// Fallback to file scan for backwards compatibility
if (empty($gallery_images)) {
    $gallery_dir_rel = '/assets/images/fleet-safe-pro/gallery/';
    $gallery_dir_abs = get_template_directory() . $gallery_dir_rel;
    $gallery_url_base = get_template_directory_uri() . $gallery_dir_rel;

    if (file_exists($gallery_dir_abs)) {
        $gallery_files = scandir($gallery_dir_abs);
        foreach ($gallery_files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'jpg' || pathinfo($file, PATHINFO_EXTENSION) === 'png') {
                $gallery_images[] = array(
                    'url' => $gallery_url_base . $file,
                    'title' => ucwords(str_replace(array('-', '_', '.'), ' ', pathinfo($file, PATHINFO_FILENAME))),
                    'alt' => ucwords(str_replace(array('-', '_', '.'), ' ', pathinfo($file, PATHINFO_FILENAME))),
                );
            }
        }
    }
}

if (empty($gallery_images)) {
    return;
}
?>

<!-- 8. VISUAL GALLERY (Restored & Sliderized) -->
<section class="aitsc-section aitsc-section--gallery">
    <div class="aitsc-container">
        <div class="aitsc-section__header">
            <h2 class="aitsc-section__title">Product Gallery</h2>
            <p class="aitsc-section__subtitle">Real installation photos and system components</p>
        </div>

        <div class="aitsc-gallery-slider-container">
            <div class="aitsc-gallery-track">
                <?php
                // Display first 24 gallery images
                $display_count = min(24, count($gallery_images));
                for ($i = 0; $i < $display_count; $i++) {
                    $img = $gallery_images[$i];
                    $image_url = is_array($img) ? $img['url'] : $img;
                    $image_title = is_array($img) ? $img['title'] : basename($img);
                    $image_alt = is_array($img) ? $img['alt'] : $image_title;
                    ?>
                    <div class="aitsc-card aitsc-card--image aitsc-card--gallery aitsc-gallery-slide">
                        <div class="aitsc-card__image-wrapper">
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>"
                                loading="lazy"
                                style="max-height: 600px; width: auto; object-fit: contain; margin: 0 auto; display: block;">
                        </div>
                        <div class="aitsc-card__content">
                            <h3 class="aitsc-card__title"><?php echo esc_html($image_title); ?></h3>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

            <!-- Slider Controls -->
            <?php if ($display_count > 3): ?>
                <div class="aitsc-slider-controls">
                    <button class="aitsc-slider-btn aitsc-slider-btn--prev" aria-label="Previous slide"
                        onclick="document.querySelector('.aitsc-gallery-track').scrollBy({left: -400, behavior: 'smooth'})">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <button class="aitsc-slider-btn aitsc-slider-btn--next" aria-label="Next slide"
                        onclick="document.querySelector('.aitsc-gallery-track').scrollBy({left: 400, behavior: 'smooth'})">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <?php if (count($gallery_images) > 24): ?>
            <div class="aitsc-gallery-more">
                <p>Showing 1-<?php echo min(24, count($gallery_images)); ?> of <?php echo count($gallery_images); ?> photos
                </p>
            </div>
        <?php endif; ?>
    </div>
</section>