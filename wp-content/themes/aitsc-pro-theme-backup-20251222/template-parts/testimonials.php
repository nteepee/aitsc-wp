<?php
/**
 * Testimonials / Social Proof Section Template Part
 *
 * Features client testimonials, logos, awards, and social proof elements
 * WorldQuant-inspired design with carousel functionality
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

// Get customizer settings
$testimonials_title = get_theme_mod('aitsc_testimonials_title', 'Client Testimonials');
$testimonials_subtitle = get_theme_mod('aitsc_testimonials_subtitle', 'Transport safety improvements and client success stories from across Australia');
$testimonials_layout = get_theme_mod('aitsc_testimonials_layout', 'carousel'); // carousel, grid, mixed
$testimonials_count = get_theme_mod('aitsc_testimonials_count', 6);
$testimonials_autoplay = get_theme_mod('aitsc_testimonials_autoplay', true);
$testimonials_show_logos = get_theme_mod('aitsc_testimonials_logos', true);
$testimonials_show_awards = get_theme_mod('aitsc_testimonials_awards', true);

$section_class = 'testimonials-section';
$section_class .= ' testimonials-' . $testimonials_layout;

// Query testimonials (use a custom post type or fallback to pages/posts with specific meta)
$testimonials_args = array(
    'post_type'      => 'testimonials',
    'posts_per_page' => $testimonials_count,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'post_status'    => 'publish'
);

// If no testimonials CPT, get from posts with testimonial meta
$testimonials_query = new WP_Query($testimonials_args);
if (!$testimonials_query->have_posts()) {
    $testimonials_query = new WP_Query(array(
        'post_type'      => array('post', 'page'),
        'posts_per_page' => $testimonials_count,
        'meta_key'       => 'is_testimonial',
        'meta_value'     => '1',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_status'    => 'publish'
    ));
}

// Get client logos from customizer or options
$client_logos = array();
for ($i = 1; $i <= 8; $i++) {
    $logo = get_theme_mod("aitsc_client_logo_{$i}");
    $name = get_theme_mod("aitsc_client_name_{$i}");
    $url = get_theme_mod("aitsc_client_url_{$i}");

    if ($logo && $name) {
        $client_logos[] = array(
            'logo' => $logo,
            'name' => $name,
            'url'  => $url
        );
    }
}

// Get awards and certifications
$awards = array();
for ($i = 1; $i <= 4; $i++) {
    $award_icon = get_theme_mod("aitsc_award_icon_{$i}");
    $award_title = get_theme_mod("aitsc_award_title_{$i}");
    $award_description = get_theme_mod("aitsc_award_description_{$i}");

    if ($award_title) {
        $awards[] = array(
            'icon' => $award_icon,
            'title' => $award_title,
            'description' => $award_description
        );
    }
}
?>

<section class="<?php echo esc_attr($section_class); ?> section">
    <div class="container">
        <!-- Section Header -->
        <div class="testimonials-header">
            <h2 class="section-title animate-slide-up">
                <?php echo esc_html($testimonials_title); ?>
            </h2>
            <?php if ($testimonials_subtitle) : ?>
            <p class="section-subtitle animate-slide-up delay-1">
                <?php echo esc_html($testimonials_subtitle); ?>
            </p>
            <?php endif; ?>
        </div>

        <!-- Testimonials Content -->
        <?php if ($testimonials_query->have_posts()) : ?>

            <?php if ($testimonials_layout === 'carousel') : ?>
            <!-- Carousel Layout -->
            <div class="testimonials-carousel-container animate-fade-in-up delay-2">
                <div class="testimonials-carousel js-testimonials-carousel"
                     <?php echo $testimonials_autoplay ? 'data-autoplay="true"' : ''; ?>
                     data-speed="5000"
                     data-auto-rotate="5000">

                    <?php while ($testimonials_query->have_posts()) : $testimonials_query->the_post(); ?>

                        <?php
                        // Get testimonial metadata
                        $client_name = get_post_meta(get_the_ID(), 'testimonial_client_name', true);
                        $client_position = get_post_meta(get_the_ID(), 'testimonial_client_position', true);
                        $client_company = get_post_meta(get_the_ID(), 'testimonial_client_company', true);
                        $client_photo = get_post_meta(get_the_ID(), 'testimonial_client_photo', true);
                        $rating = get_post_meta(get_the_ID(), 'testimonial_rating', true);
                        ?>

                        <div class="testimonial-slide">
                            <div class="testimonial-card">
                                <!-- Rating -->
                                <?php if ($rating) : ?>
                                <div class="testimonial-rating">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <span class="star dashicons dashicons-star-filled <?php echo $i <= $rating ? 'active' : ''; ?>"></span>
                                    <?php endfor; ?>
                                </div>
                                <?php endif; ?>

                                <!-- Content -->
                                <div class="testimonial-content">
                                    <blockquote class="testimonial-text">
                                        <?php echo wp_kses_post(get_the_content()); ?>
                                    </blockquote>
                                </div>

                                <!-- Client Info -->
                                <div class="testimonial-client">
                                    <?php if ($client_photo) : ?>
                                    <div class="client-photo">
                                        <img src="<?php echo esc_url($client_photo); ?>"
                                             alt="<?php echo esc_attr($client_name); ?>"
                                             class="client-avatar">
                                    </div>
                                    <?php endif; ?>

                                    <div class="client-info">
                                        <div class="client-name"><?php echo esc_html($client_name); ?></div>
                                        <?php if ($client_position) : ?>
                                        <div class="client-position"><?php echo esc_html($client_position); ?></div>
                                        <?php endif; ?>
                                        <?php if ($client_company) : ?>
                                        <div class="client-company"><?php echo esc_html($client_company); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endwhile; wp_reset_postdata(); ?>

                </div>

                <!-- Carousel Controls -->
                <div class="testimonials-controls">
                    <button class="testimonial-prev js-testimonials-prev btn-prev" aria-label="Previous testimonial">
                        <span class="dashicons dashicons-arrow-left-alt2"></span>
                    </button>
                    <button class="testimonial-next js-testimonials-next btn-next" aria-label="Next testimonial">
                        <span class="dashicons dashicons-arrow-right-alt2"></span>
                    </button>
                </div>

                <!-- Carousel Indicators -->
                <div class="testimonials-indicators">
                    <?php for ($i = 0; $i < $testimonials_query->post_count; $i++) : ?>
                    <button class="testimonial-indicator <?php echo $i === 0 ? 'active' : ''; ?>"
                            data-slide="<?php echo $i; ?>"
                            aria-label="Go to testimonial <?php echo $i + 1; ?>"></button>
                    <?php endfor; ?>
                </div>
            </div>

            <?php elseif ($testimonials_layout === 'grid') : ?>
            <!-- Grid Layout -->
            <div class="testimonials-grid animate-fade-in-up delay-2">
                <?php while ($testimonials_query->have_posts()) : $testimonials_query->the_post(); ?>

                    <?php
                    $client_name = get_post_meta(get_the_ID(), 'testimonial_client_name', true);
                    $client_position = get_post_meta(get_the_ID(), 'testimonial_client_position', true);
                    $client_company = get_post_meta(get_the_ID(), 'testimonial_client_company', true);
                    $client_photo = get_post_meta(get_the_ID(), 'testimonial_client_photo', true);
                    $rating = get_post_meta(get_the_ID(), 'testimonial_rating', true);
                    $index = $testimonials_query->current_post;
                    ?>

                    <div class="testimonial-grid-item animate-fade-in-up"
                         style="--animation-delay: <?php echo ($index * 0.1); ?>s;">

                        <div class="testimonial-card">
                            <?php if ($rating) : ?>
                            <div class="testimonial-rating">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <span class="star dashicons dashicons-star-filled <?php echo $i <= $rating ? 'active' : ''; ?>"></span>
                                <?php endfor; ?>
                            </div>
                            <?php endif; ?>

                            <div class="testimonial-content">
                                <blockquote class="testimonial-text">
                                    <?php echo wp_trim_words(get_the_content(), 30, '...'); ?>
                                </blockquote>
                            </div>

                            <div class="testimonial-client">
                                <?php if ($client_photo) : ?>
                                <div class="client-photo">
                                    <img src="<?php echo esc_url($client_photo); ?>"
                                         alt="<?php echo esc_attr($client_name); ?>"
                                         class="client-avatar">
                                </div>
                                <?php endif; ?>

                                <div class="client-info">
                                    <div class="client-name"><?php echo esc_html($client_name); ?></div>
                                    <?php if ($client_position) : ?>
                                    <div class="client-position"><?php echo esc_html($client_position); ?></div>
                                    <?php endif; ?>
                                    <?php if ($client_company) : ?>
                                    <div class="client-company"><?php echo esc_html($client_company); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endwhile; wp_reset_postdata(); ?>
            </div>

            <?php else : ?>
            <!-- Mixed Layout (Featured + Grid) -->
            <div class="testimonials-mixed-container animate-fade-in-up delay-2">
                <!-- Featured Testimonial -->
                <?php if ($testimonials_query->have_posts()) : $testimonials_query->the_post(); ?>
                    <?php
                    $client_name = get_post_meta(get_the_ID(), 'testimonial_client_name', true);
                    $client_position = get_post_meta(get_the_ID(), 'testimonial_client_position', true);
                    $client_company = get_post_meta(get_the_ID(), 'testimonial_client_company', true);
                    $client_photo = get_post_meta(get_the_ID(), 'testimonial_client_photo', true);
                    $rating = get_post_meta(get_the_ID(), 'testimonial_rating', true);
                    ?>

                    <div class="testimonial-featured">
                        <div class="testimonial-card featured">
                            <?php if ($rating) : ?>
                            <div class="testimonial-rating">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <span class="star dashicons dashicons-star-filled <?php echo $i <= $rating ? 'active' : ''; ?>"></span>
                                <?php endfor; ?>
                            </div>
                            <?php endif; ?>

                            <div class="testimonial-content">
                                <blockquote class="testimonial-text">
                                    <?php echo wp_kses_post(get_the_content()); ?>
                                </blockquote>
                            </div>

                            <div class="testimonial-client">
                                <?php if ($client_photo) : ?>
                                <div class="client-photo">
                                    <img src="<?php echo esc_url($client_photo); ?>"
                                         alt="<?php echo esc_attr($client_name); ?>"
                                         class="client-avatar">
                                </div>
                                <?php endif; ?>

                                <div class="client-info">
                                    <div class="client-name"><?php echo esc_html($client_name); ?></div>
                                    <?php if ($client_position) : ?>
                                    <div class="client-position"><?php echo esc_html($client_position); ?></div>
                                    <?php endif; ?>
                                    <?php if ($client_company) : ?>
                                    <div class="client-company"><?php echo esc_html($client_company); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Grid Testimonials -->
                <div class="testimonials-grid secondary">
                    <?php while ($testimonials_query->have_posts()) : $testimonials_query->the_post(); ?>
                        <?php
                        $client_name = get_post_meta(get_the_ID(), 'testimonial_client_name', true);
                        $client_position = get_post_meta(get_the_ID(), 'testimonial_client_position', true);
                        $client_company = get_post_meta(get_the_ID(), 'testimonial_client_company', true);
                        $client_photo = get_post_meta(get_the_ID(), 'testimonial_client_photo', true);
                        $rating = get_post_meta(get_the_ID(), 'testimonial_rating', true);
                        $index = $testimonials_query->current_post;
                        ?>

                        <div class="testimonial-grid-item animate-fade-in-up"
                             style="--animation-delay: <?php echo (($index + 1) * 0.1); ?>s;">

                            <div class="testimonial-card">
                                <div class="testimonial-content">
                                    <blockquote class="testimonial-text">
                                        <?php echo wp_trim_words(get_the_content(), 25, '...'); ?>
                                    </blockquote>
                                </div>

                                <div class="testimonial-client">
                                    <div class="client-info">
                                        <div class="client-name"><?php echo esc_html($client_name); ?></div>
                                        <?php if ($client_company) : ?>
                                        <div class="client-company"><?php echo esc_html($client_company); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>

            <?php endif; ?>

        <?php else : ?>
            <div class="no-testimonials">
                <p><?php esc_html_e('No testimonials found.', 'aitsc-pro-theme'); ?></p>
            </div>
        <?php endif; ?>

        <!-- Client Logos -->
        <?php if ($testimonials_show_logos && !empty($client_logos)) : ?>
        <div class="client-logos-section animate-fade-in-up">
            <div class="logos-header">
                <h3 class="logos-title">Trusted By</h3>
                <p class="logos-subtitle">Industry leaders who rely on AITSC solutions</p>
            </div>

            <div class="client-logos-grid">
                <?php foreach ($client_logos as $index => $client) : ?>
                    <div class="client-logo-item animate-fade-in-up"
                         style="--animation-delay: <?php echo ($index * 0.05); ?>s;">
                        <?php if ($client['url']) : ?>
                        <a href="<?php echo esc_url($client['url']); ?>" target="_blank" rel="noopener">
                            <img src="<?php echo esc_url($client['logo']); ?>"
                                 alt="<?php echo esc_attr($client['name']); ?>"
                                 class="client-logo-image">
                        </a>
                        <?php else : ?>
                        <img src="<?php echo esc_url($client['logo']); ?>"
                             alt="<?php echo esc_attr($client['name']); ?>"
                             class="client-logo-image">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Awards & Certifications -->
        <?php if ($testimonials_show_awards && !empty($awards)) : ?>
        <div class="awards-section animate-fade-in-up">
            <div class="awards-header">
                <h3 class="awards-title">Awards & Certifications</h3>
            </div>

            <div class="awards-grid">
                <?php foreach ($awards as $index => $award) : ?>
                    <div class="award-item animate-fade-in-up"
                         style="--animation-delay: <?php echo ($index * 0.1); ?>s;">
                        <?php if ($award['icon']) : ?>
                        <div class="award-icon">
                            <span class="<?php echo esc_attr($award['icon']); ?>"></span>
                        </div>
                        <?php endif; ?>
                        <div class="award-content">
                            <h4 class="award-title"><?php echo esc_html($award['title']); ?></h4>
                            <?php if ($award['description']) : ?>
                            <p class="award-description"><?php echo esc_html($award['description']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php
/**
 * Inline styles for dynamic settings
 */
$testimonials_custom_styles = '';

// Grid layout columns based on count
if ($testimonials_layout === 'grid') {
    $columns = min($testimonials_count, 3);
    $testimonials_custom_styles .= "
    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat({$columns}, 1fr);
        gap: 24px;
    }
    @media (max-width: 768px) {
        .testimonials-grid { grid-template-columns: 1fr; }
    }";
}

// Carousel layout
if ($testimonials_layout === 'carousel') {
    $testimonials_custom_styles .= '
    .testimonials-carousel-container {
        position: relative;
        overflow: hidden;
    }
    .testimonials-carousel {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }
    .testimonial-slide {
        min-width: 100%;
        padding: 0 24px;
    }';
}

// Mixed layout
if ($testimonials_layout === 'mixed') {
    $testimonials_custom_styles .= '
    .testimonials-mixed-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
    }
    @media (max-width: 1024px) {
        .testimonials-mixed-container { grid-template-columns: 1fr; }
        .testimonials-grid.secondary { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 768px) {
        .testimonials-grid.secondary { grid-template-columns: 1fr; }
    }';
}

// Client logos grid
if ($testimonials_show_logos) {
    $logo_columns = min(count($client_logos), 4);
    $testimonials_custom_styles .= "
    .client-logos-grid {
        display: grid;
        grid-template-columns: repeat({$logo_columns}, 1fr);
        gap: 40px;
        align-items: center;
    }
    @media (max-width: 768px) {
        .client-logos-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
    }";
}

// Awards grid
if ($testimonials_show_awards) {
    $award_columns = min(count($awards), 2);
    $testimonials_custom_styles .= "
    .awards-grid {
        display: grid;
        grid-template-columns: repeat({$award_columns}, 1fr);
        gap: 32px;
    }
    @media (max-width: 768px) {
        .awards-grid { grid-template-columns: 1fr; }
    }";
}

// Common testimonial card styles
$testimonials_custom_styles .= '
.testimonial-card {
    background: var(--aitsc-color-white, #ffffff);
    border-radius: 12px;
    padding: 32px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    height: 100%;
    display: flex;
    flex-direction: column;
}
.testimonial-card.featured {
    padding: 48px;
    background: linear-gradient(135deg, var(--aitsc-color-primary, #005cb2), var(--aitsc-color-primary-dark, #003d7a));
    color: white;
}
.testimonial-rating {
    margin-bottom: 16px;
}
.star {
    color: #ddd;
    font-size: 18px;
    margin-right: 4px;
}
.star.active {
    color: var(--aitsc-color-neon, #00e128);
}
.client-photo {
    margin-right: 16px;
}
.client-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
}
.client-info .client-name {
    font-weight: 700;
    font-size: 1.125rem;
    margin-bottom: 4px;
}
.client-info .client-position {
    color: var(--aitsc-color-gray, #666);
    font-size: 0.875rem;
}
.client-info .client-company {
    color: var(--aitsc-color-primary, #005cb2);
    font-weight: 500;
    font-size: 0.875rem;
}';

if (!empty($testimonials_custom_styles)) :
    wp_add_inline_style('aitsc-homepage-advanced', $testimonials_custom_styles);
endif;
?>