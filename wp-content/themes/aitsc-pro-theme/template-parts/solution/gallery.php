<?php
/**
 * Template Part: Solution Gallery
 * 
 * Displays the product gallery with a horizontal scroll slider.
 */

// Get all gallery images - scanning specific directory for Fleet Safe Pro
// Ideally this should be dynamic via ACF, but using file-scan to match original intent
$gallery_dir_rel = '/assets/images/fleet-safe-pro/gallery/';
$gallery_dir_abs = get_template_directory() . $gallery_dir_rel;
$gallery_url_base = get_template_directory_uri() . $gallery_dir_rel;

$gallery_images = array();
if (file_exists($gallery_dir_abs)) {
    $gallery_files = scandir($gallery_dir_abs);
    foreach ($gallery_files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'jpg' || pathinfo($file, PATHINFO_EXTENSION) === 'png') {
            $gallery_images[] = $gallery_url_base . $file;
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
                    $image_path = $gallery_images[$i];
                    $image_name = basename($image_path);
                    $image_title = ucwords(str_replace(array('-', '_', '.'), ' ', pathinfo($image_name, PATHINFO_FILENAME)));
                    ?>
                    <div class="aitsc-card aitsc-card--image aitsc-card--gallery aitsc-gallery-slide">
                        <div class="aitsc-card__image-wrapper">
                            <img src="<?php echo esc_url($image_path); ?>" alt="<?php echo esc_attr($image_title); ?>"
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