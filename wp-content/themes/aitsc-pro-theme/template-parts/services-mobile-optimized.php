<?php
/**
 * Mobile-Optimized Services and Case Studies Template
 * Enhanced B2B service cards with mobile conversion optimization
 * Performance-optimized with lazy loading and micro-interactions
 *
 * @package AITSC_Pro_Theme
 * @since 2.0.0
 */

// Mobile-optimized services settings
$services_title = get_theme_mod('aitsc_services_title', 'Our Safety Solutions');
$services_subtitle = get_theme_mod('aitsc_services_subtitle', 'Comprehensive transport safety solutions tailored for Australian businesses');
$show_case_studies = get_theme_mod('aitsc_show_case_studies', true);
$case_studies_title = get_theme_mod('aitsc_case_studies_title', 'Success Stories');
$case_studies_subtitle = get_theme_mod('aitsc_case_studies_subtitle', 'Real results from our safety consulting partners');

// Get services from theme customizer or use defaults
$services = array();
for ($i = 1; $i <= 6; $i++) {
    if (get_theme_mod("aitsc_service_{$i}_title")) {
        $services[] = array(
            'title' => get_theme_mod("aitsc_service_{$i}_title"),
            'description' => get_theme_mod("aitsc_service_{$i}_desc"),
            'icon' => get_theme_mod("aitsc_service_{$i}_icon", 'shield-check'),
            'badge' => get_theme_mod("aitsc_service_{$i}_badge"),
            'link' => get_theme_mod("aitsc_service_{$i}_link", "#service-{$i}"),
            'featured' => get_theme_mod("aitsc_service_{$i}_featured", false)
        );
    }
}

// Get case studies if enabled
$case_studies = array();
if ($show_case_studies) {
    // Get recent case studies from custom post type
    $case_studies_query = new WP_Query(array(
        'post_type' => 'case_study',
        'posts_per_page' => 3,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    ));

    if ($case_studies_query->have_posts()) {
        while ($case_studies_query->have_posts()) {
            $case_studies_query->the_post();
            $case_studies[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'excerpt' => get_the_excerpt(),
                'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                'category' => get_the_terms(get_the_ID(), 'case_study_category'),
                'results' => get_post_meta(get_the_ID(), '_case_results', true),
                'client' => get_post_meta(get_the_ID(), '_case_client', true),
                'link' => get_permalink()
            );
        }
        wp_reset_postdata();
    }
}
?>

<!-- Mobile-Optimized Services Section -->
<section class="services-section-mobile section" id="services">
    <div class="container">
        <!-- Section Header with Mobile Optimization -->
        <div class="section-header-mobile" data-aos="fade-up" data-aos-duration="800">
            <h2 class="section-title-mobile"><?php echo esc_html($services_title); ?></h2>
            <p class="section-subtitle-mobile"><?php echo esc_html($services_subtitle); ?></p>

            <!-- Trust Indicators for Mobile -->
            <div class="trust-indicators-mobile">
                <div class="trust-indicator">
                    <span class="trust-icon-small">✓</span>
                    <span>NHVAS Accedited</span>
                </div>
                <div class="trust-indicator">
                    <span class="trust-icon-small">✓</span>
                    <span>ISO 9001:2015</span>
                </div>
                <div class="trust-indicator">
                    <span class="trust-icon-small">✓</span>
                    <span>Chain of Responsibility</span>
                </div>
            </div>
        </div>

        <!-- Mobile-Optimized Service Cards Grid -->
        <div class="services-grid-mobile">
            <?php foreach ($services as $index => $service) : ?>
                <div class="service-card-mobile"
                     data-aos="fade-up"
                     data-aos-duration="600"
                     data-aos-delay="<?php echo esc_attr($index * 100); ?>"
                     <?php if ($service['featured']) : ?>data-featured="true"<?php endif; ?>>

                    <!-- Featured Badge -->
                    <?php if ($service['featured'] || $service['badge']) : ?>
                        <div class="service-badge-mobile">
                            <?php if ($service['featured']) : ?>
                                <span class="badge-featured">FEATURED</span>
                            <?php endif; ?>
                            <?php if ($service['badge']) : ?>
                                <span class="badge-custom"><?php echo esc_html($service['badge']); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Service Icon with Animation -->
                    <div class="service-icon-container-mobile">
                        <div class="service-icon-mobile">
                            <?php
                            // Icon SVG or fallback
                            $icon_svg = $service['icon'] ? get_aitsc_icon_svg($service['icon']) : '';
                            if ($icon_svg) {
                                echo $icon_svg;
                            } else {
                                echo '<svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>';
                            }
                            ?>
                        </div>
                        <!-- Animated Background -->
                        <div class="service-icon-bg-mobile"></div>
                    </div>

                    <!-- Service Content -->
                    <div class="service-content-mobile">
                        <h3 class="service-title-mobile"><?php echo esc_html($service['title']); ?></h3>

                        <p class="service-description-mobile">
                            <?php echo esc_html($service['description']); ?>
                        </p>

                        <!-- Service Features (Mobile Optimized) -->
                        <?php $features = get_theme_mod("aitsc_service_{$index + 1}_features", array()); ?>
                        <?php if (!empty($features) && is_array($features)) : ?>
                            <ul class="service-features-mobile">
                                <?php foreach (array_slice($features, 0, 3) as $feature) : ?>
                                    <li class="service-feature-mobile">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span><?php echo esc_html($feature); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <!-- Mobile CTA -->
                        <div class="service-actions-mobile">
                            <a href="<?php echo esc_url($service['link']); ?>"
                               class="service-link-mobile"
                               data-ga-event="click"
                               data-ga-category="service_card"
                               data-ga-action="learn_more"
                               data-ga-label="<?php echo esc_attr($service['title']); ?>">
                                <span>Learn More</span>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 12h14m-7-7l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>

                            <!-- Quick Quote Button -->
                            <button class="service-quick-quote-mobile"
                                    data-service="<?php echo esc_attr($service['title']); ?>"
                                    data-ga-event="click"
                                    data-ga-category="service_card"
                                    data-ga-action="quick_quote"
                                    data-ga-label="<?php echo esc_attr($service['title']); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 12h8m-4-4v8m-4 7h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v12a2 2 0 002 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>Quote</span>
                            </button>
                        </div>
                    </div>

                    <!-- Service Hover Effect Indicator -->
                    <div class="service-card-indicator"></div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Mobile View More Button -->
        <div class="services-view-more-mobile" data-aos="fade-up" data-aos-duration="800">
            <button class="btn btn-outline view-more-services" data-count="6">
                <span class="view-more-text">View All Services</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12h14m-7-7l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </div>
</section>

<!-- Mobile-Optimized Case Studies Section -->
<?php if ($show_case_studies && !empty($case_studies)) : ?>
<section class="case-studies-section-mobile section" id="case-studies">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header-mobile" data-aos="fade-up" data-aos-duration="800">
            <h2 class="section-title-mobile"><?php echo esc_html($case_studies_title); ?></h2>
            <p class="section-subtitle-mobile"><?php echo esc_html($case_studies_subtitle); ?></p>
        </div>

        <!-- Mobile-Optimized Case Studies Grid -->
        <div class="case-studies-grid-mobile">
            <?php foreach ($case_studies as $index => $case_study) : ?>
                <article class="case-study-card-mobile"
                         data-aos="fade-up"
                         data-aos-duration="600"
                         data-aos-delay="<?php echo esc_attr($index * 100); ?>"
                         itemscope
                         itemtype="https://schema.org/CaseStudy">

                    <!-- Case Study Image with Lazy Loading -->
                    <div class="case-study-image-container-mobile">
                        <picture class="case-study-picture">
                            <source
                                media="(max-width: 480px)"
                                data-srcset="<?php echo esc_url($case_study['thumbnail']); ?>"
                            >
                            <img class="case-study-image-mobile lazyload"
                                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1 1'%3E%3C/svg%3E"
                                 data-src="<?php echo esc_url($case_study['thumbnail']); ?>"
                                 alt="<?php echo esc_attr($case_study['title']); ?>"
                                 loading="lazy"
                                 decoding="async"
                                 itemprop="image">
                        </picture>

                        <!-- Case Study Category Badge -->
                        <?php if (!empty($case_study['category'])) : ?>
                            <div class="case-study-category-mobile">
                                <?php echo esc_html($case_study['category'][0]->name); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Results Overlay -->
                        <?php if (!empty($case_study['results'])) : ?>
                            <div class="case-study-results-mobile">
                                <span class="results-label">Results</span>
                                <span class="results-text"><?php echo esc_html($case_study['results']); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Case Study Content -->
                    <div class="case-study-content-mobile">
                        <!-- Client Information -->
                        <?php if (!empty($case_study['client'])) : ?>
                            <div class="case-study-client-mobile">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                                    <path d="m22 21-3-3m0 0a5 5 0 0 0-7-7 5 5 0 0 0-7 7m7-7v.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span><?php echo esc_html($case_study['client']); ?></span>
                            </div>
                        <?php endif; ?>

                        <!-- Case Study Title -->
                        <h3 class="case-study-title-mobile" itemprop="headline">
                            <a href="<?php echo esc_url($case_study['link']); ?>"
                               class="case-study-link-mobile"
                               itemprop="url">
                                <?php echo esc_html($case_study['title']); ?>
                            </a>
                        </h3>

                        <!-- Case Study Excerpt -->
                        <p class="case-study-excerpt-mobile" itemprop="description">
                            <?php echo esc_html($case_study['excerpt']); ?>
                        </p>

                        <!-- Case Study Actions -->
                        <div class="case-study-actions-mobile">
                            <a href="<?php echo esc_url($case_study['link']); ?>"
                               class="case-study-read-more-mobile"
                               data-ga-event="click"
                               data-ga-category="case_study"
                               data-ga-action="read_more"
                               data-ga-label="<?php echo esc_attr($case_study['title']); ?>"
                               itemprop="url">
                                <span>Read Case Study</span>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 12h14m-7-7l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>

                            <!-- Share Button -->
                            <button class="case-study-share-mobile"
                                    data-title="<?php echo esc_attr($case_study['title']); ?>"
                                    data-url="<?php echo esc_url($case_study['link']); ?>"
                                    data-ga-event="click"
                                    data-ga-category="case_study"
                                    data-ga-action="share"
                                    data-ga-label="<?php echo esc_attr($case_study['title']); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="18" cy="5" r="3" stroke="currentColor" stroke-width="2"/>
                                    <circle cx="6" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                                    <circle cx="18" cy="19" r="3" stroke="currentColor" stroke-width="2"/>
                                    <path d="m8.59 13.51 6.83 3.98M15.41 6.51l-6.82 3.98" stroke="currentColor" stroke-width="2"/>
                                </svg>
                                <span>Share</span>
                            </button>
                        </div>
                    </div>

                    <!-- Schema.org metadata -->
                    <meta itemprop="datePublished" content="<?php echo get_the_date('c', $case_study['id']); ?>">
                </article>
            <?php endforeach; ?>
        </div>

        <!-- View More Case Studies -->
        <div class="case-studies-view-more-mobile" data-aos="fade-up" data-aos-duration="800">
            <a href="/case-studies/" class="btn btn-primary">
                <span>View All Case Studies</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12h14m-7-7l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Mobile Services & Case Studies Specific Styles -->
<style>
/* Mobile Services Section */
.services-section-mobile {
    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%);
    position: relative;
    overflow: hidden;
}

.services-section-mobile::before {
    content: '';
    position: absolute;
    top: 0;
    left: -50%;
    width: 200%;
    height: 100%;
    background: radial-gradient(circle, rgba(0, 92, 178, 0.05) 0%, transparent 70%);
    animation: float 25s ease-in-out infinite;
}

/* Section Header Mobile */
.section-header-mobile {
    text-align: center;
    margin-bottom: 3rem;
    position: relative;
    z-index: 1;
}

.section-title-mobile {
    font-size: clamp(2rem, 8vw, 2.5rem);
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.section-subtitle-mobile {
    font-size: clamp(1rem, 4vw, 1.125rem);
    color: #4a5568;
    line-height: 1.6;
    max-width: 600px;
    margin: 0 auto 2rem;
}

/* Trust Indicators Mobile */
.trust-indicators-mobile {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
    margin-top: 2rem;
}

.trust-indicator {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background-color: rgba(0, 92, 178, 0.08);
    border: 1px solid rgba(0, 92, 178, 0.15);
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
    color: #005cb2;
}

.trust-icon-small {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
    background-color: #005cb2;
    color: white;
    border-radius: 50%;
    font-size: 0.625rem;
    font-weight: bold;
}

/* Mobile Services Grid */
.services-grid-mobile {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    position: relative;
    z-index: 1;
}

/* Service Card Mobile */
.service-card-mobile {
    background-color: #ffffff;
    border: 2px solid #e2e8f0;
    border-radius: 16px;
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
}

.service-card-mobile[data-featured="true"] {
    border-color: #00e128;
    box-shadow: 0 0 25px rgba(0, 225, 40, 0.15);
}

.service-card-mobile:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    border-color: #005cb2;
}

/* Service Badge */
.service-badge-mobile {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    z-index: 2;
}

.badge-featured,
.badge-custom {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.625rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-featured {
    background: linear-gradient(135deg, #00e128 0%, #00c41f 100%);
    color: #000;
}

.badge-custom {
    background-color: rgba(0, 92, 178, 0.1);
    color: #005cb2;
    border: 1px solid rgba(0, 92, 178, 0.2);
}

/* Service Icon Container */
.service-icon-container-mobile {
    position: relative;
    margin-bottom: 1.5rem;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 80px;
}

.service-icon-mobile {
    position: relative;
    z-index: 2;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #005cb2 0%, #004691 100%);
    color: white;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.service-card-mobile:hover .service-icon-mobile {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 12px 35px rgba(0, 92, 178, 0.3);
}

.service-icon-mobile svg {
    width: 28px;
    height: 28px;
}

.service-icon-bg-mobile {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, rgba(0, 92, 178, 0.1) 0%, rgba(0, 225, 40, 0.05) 100%);
    border-radius: 50%;
    opacity: 0;
    transition: all 0.3s ease;
}

.service-card-mobile:hover .service-icon-bg-mobile {
    opacity: 1;
    transform: translate(-50%, -50%) scale(1.2);
}

/* Service Content */
.service-content-mobile {
    text-align: center;
}

.service-title-mobile {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 1rem;
    line-height: 1.3;
}

.service-description-mobile {
    font-size: 0.875rem;
    color: #4a5568;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

/* Service Features */
.service-features-mobile {
    list-style: none;
    padding: 0;
    margin: 0 0 1.5rem 0;
    text-align: left;
}

.service-feature-mobile {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
    font-size: 0.813rem;
    color: #4a5568;
}

.service-feature-mobile svg {
    width: 16px;
    height: 16px;
    color: #00e128;
    flex-shrink: 0;
}

/* Service Actions */
.service-actions-mobile {
    display: flex;
    gap: 0.75rem;
    justify-content: center;
    align-items: center;
}

.service-link-mobile {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #005cb2;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    padding: 0.75rem 1rem;
    border: 2px solid #005cb2;
    border-radius: 8px;
    background-color: transparent;
}

.service-link-mobile:hover {
    background-color: #005cb2;
    color: white;
    transform: translateX(4px);
}

.service-quick-quote-mobile {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background-color: #00e128;
    color: #000;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.service-quick-quote-mobile:hover {
    background-color: #00c41f;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 225, 40, 0.3);
}

/* View More Button */
.services-view-more-mobile {
    text-align: center;
    margin-top: 3rem;
}

.view-more-services {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

/* Case Studies Section Mobile */
.case-studies-section-mobile {
    background-color: #f8fafc;
}

/* Mobile Case Studies Grid */
.case-studies-grid-mobile {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
}

/* Case Study Card Mobile */
.case-study-card-mobile {
    background-color: #ffffff;
    border: 2px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
}

.case-study-card-mobile:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    border-color: #005cb2;
}

/* Case Study Image Container */
.case-study-image-container-mobile {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.case-study-picture {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.case-study-image-mobile {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.case-study-card-mobile:hover .case-study-image-mobile {
    transform: scale(1.1);
}

/* Case Study Category */
.case-study-category-mobile {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background-color: rgba(0, 92, 178, 0.9);
    color: white;
    padding: 0.375rem 0.75rem;
    border-radius: 50px;
    font-size: 0.625rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    backdrop-filter: blur(10px);
}

/* Case Study Results */
.case-study-results-mobile {
    position: absolute;
    bottom: 1rem;
    right: 1rem;
    background-color: rgba(0, 225, 40, 0.9);
    color: #000;
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.75rem;
    backdrop-filter: blur(10px);
}

.results-label {
    display: block;
    font-size: 0.625rem;
    opacity: 0.8;
    margin-bottom: 0.125rem;
}

/* Case Study Content */
.case-study-content-mobile {
    padding: 1.5rem;
}

.case-study-client-mobile {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #4a5568;
    font-size: 0.813rem;
    margin-bottom: 0.75rem;
    font-weight: 600;
}

.case-study-client-mobile svg {
    width: 16px;
    height: 16px;
    color: #005cb2;
}

.case-study-title-mobile {
    margin-bottom: 1rem;
}

.case-study-link-mobile {
    color: #1a1a1a;
    text-decoration: none;
    font-size: 1.125rem;
    font-weight: 700;
    line-height: 1.3;
    transition: color 0.3s ease;
}

.case-study-link-mobile:hover {
    color: #005cb2;
}

.case-study-excerpt-mobile {
    font-size: 0.875rem;
    color: #4a5568;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

/* Case Study Actions */
.case-study-actions-mobile {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

.case-study-read-more-mobile {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #005cb2;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.case-study-read-more-mobile:hover {
    color: #004691;
    transform: translateX(4px);
}

.case-study-share-mobile {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    color: #4a5568;
    font-size: 0.813rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.case-study-share-mobile:hover {
    background-color: #005cb2;
    color: white;
    border-color: #005cb2;
}

/* Mobile Responsive Optimizations */
@media (max-width: 30rem) {
    .section-header-mobile {
        margin-bottom: 2rem;
    }

    .services-grid-mobile {
        gap: 1.5rem;
    }

    .service-card-mobile {
        padding: 1.25rem;
    }

    .service-actions-mobile {
        flex-direction: column;
        gap: 0.75rem;
    }

    .service-link-mobile,
    .service-quick-quote-mobile {
        width: 100%;
        justify-content: center;
    }

    .case-studies-grid-mobile {
        gap: 1.5rem;
    }

    .case-study-content-mobile {
        padding: 1.25rem;
    }

    .case-study-actions-mobile {
        flex-direction: column;
        gap: 0.75rem;
    }

    .case-study-read-more-mobile,
    .case-study-share-mobile {
        width: 100%;
        justify-content: center;
        padding: 0.75rem 1rem;
    }

    .trust-indicators-mobile {
        gap: 0.75rem;
    }

    .trust-indicator {
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
    }
}

/* Performance Optimizations */
@media (prefers-reduced-motion: reduce) {
    .service-card-mobile:hover,
    .case-study-card-mobile:hover {
        transform: none;
    }

    .service-card-mobile:hover .service-icon-mobile,
    .case-study-card-mobile:hover .case-study-image-mobile {
        transform: none;
    }
}
</style>

<!-- Mobile Services & Case Studies JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lazy load images in service and case study cards
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazyload');
                        observer.unobserve(img);
                    }
                }
            });
        }, {
            rootMargin: '50px 0px',
            threshold: 0.01
        });

        document.querySelectorAll('.lazyload').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Mobile touch interactions for service cards
    if ('ontouchstart' in window) {
        const serviceCards = document.querySelectorAll('.service-card-mobile');
        const caseStudyCards = document.querySelectorAll('.case-study-card-mobile');

        [...serviceCards, ...caseStudyCards].forEach(card => {
            card.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.98)';
            });

            card.addEventListener('touchend', function() {
                this.style.transform = '';
            });
        });
    }

    // View More Services functionality
    const viewMoreButton = document.querySelector('.view-more-services');
    if (viewMoreButton) {
        viewMoreButton.addEventListener('click', function() {
            const currentCount = parseInt(this.dataset.count);
            const hiddenServices = document.querySelectorAll('.service-card-mobile[style*="display: none"]');

            if (hiddenServices.length > 0) {
                for (let i = 0; i < Math.min(3, hiddenServices.length); i++) {
                    hiddenServices[i].style.display = 'block';
                }

                if (document.querySelectorAll('.service-card-mobile[style*="display: none"]').length === 0) {
                    this.querySelector('.view-more-text').textContent = 'All Services Shown';
                    this.disabled = true;
                    this.style.opacity = '0.6';
                }
            }
        });
    }

    // Quick Quote functionality
    document.querySelectorAll('.service-quick-quote-mobile').forEach(button => {
        button.addEventListener('click', function() {
            const serviceName = this.dataset.service;

            // Open modal or navigate to contact page
            if (window.innerWidth <= 768) {
                // On mobile, navigate to contact page with pre-filled service
                window.location.href = `/contact/?service=${encodeURIComponent(serviceName)}`;
            } else {
                // On desktop, open modal (if available)
                console.log('Opening quote modal for:', serviceName);
            }
        });
    });

    // Share functionality for case studies
    document.querySelectorAll('.case-study-share-mobile').forEach(button => {
        button.addEventListener('click', function() {
            const title = this.dataset.title;
            const url = this.dataset.url;

            if (navigator.share && window.innerWidth <= 768) {
                // Native sharing on mobile
                navigator.share({
                    title: title,
                    url: url
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(url).then(() => {
                    // Show feedback
                    const originalText = this.querySelector('span').textContent;
                    this.querySelector('span').textContent = 'Link Copied!';
                    setTimeout(() => {
                        this.querySelector('span').textContent = originalText;
                    }, 2000);
                });
            }
        });
    });

    // Analytics tracking for mobile
    if (window.ga && window.innerWidth <= 768) {
        document.querySelectorAll('[data-ga-event="click"]').forEach(element => {
            element.addEventListener('click', function() {
                const category = this.dataset.gaCategory;
                const action = this.dataset.gaAction;
                const label = this.dataset.gaLabel;

                window.ga('send', 'event', category, action, label, {
                    nonInteraction: false,
                    transport: 'beacon'
                });
            });
        });
    }

    // Performance monitoring for mobile
    if ('PerformanceObserver' in window && window.innerWidth <= 768) {
        const perfObserver = new PerformanceObserver((list) => {
            for (const entry of list.getEntries()) {
                console.log('Mobile Performance:', entry.name, entry.duration);
            }
        });

        perfObserver.observe({ entryTypes: ['measure', 'navigation'] });
    }
});

// Utility function for SVG icons
function get_aitsc_icon_svg(icon_name) {
    // This would be implemented in the theme's functions.php
    return ''; // Placeholder
}
</script>