# Phase 5: Slider/Carousel Improvements

**Phase ID**: phase-5-slider-improvements
**Priority**: MEDIUM
**Estimated Effort**: 4-6 hours
**Dependencies**: Phase 2 (Card Component System)
**Risk Level**: Medium

---

## Objectives

1. Audit existing slider/carousel implementations
2. Standardize on single carousel system
3. Add accessibility features (keyboard nav, ARIA)
4. Improve touch/swipe interactions
5. Implement lazy loading for carousel images

---

## Current State Analysis

### Slider Implementations Found

#### 1. Custom JS Slider
**Location**: `assets/js/scroll-animations.js`
**Characteristics**:
- Custom vanilla JS implementation
- Basic prev/next button functionality
- Unclear if touch/swipe enabled
- No visible accessibility features

**Code Review Needed**: Check if actively used or legacy.

---

#### 2. Legacy Homepage Animations
**Location**: `assets_legacy_backup/js/homepage-animations.js`
**Characteristics**:
- Backup file (possibly inactive)
- May contain old slider code
- Needs audit to determine if still enqueued

---

#### 3. Testimonial Carousel Component
**Location**: `components/testimonial/testimonial-carousel.php`
**Characteristics**:
- PHP-rendered carousel structure
- Registered in component system (`inc/components.php`)
- CSS likely in `components/testimonial/` (needs verification)

---

### Common Slider Use Cases

**Identified in Templates**:
1. **Testimonial Carousel**: Client quotes/reviews
2. **Case Study Slider**: Project showcases
3. **Image Gallery**: Solution page galleries
4. **Logo Carousel**: Partner/client logos (if exists)
5. **Featured Solutions**: Homepage highlights (if carousel)

---

### Issues Identified

#### 1. Multiple Implementations
- Custom slider JS + component carousel = duplication
- Inconsistent behavior across pages
- Maintenance nightmare (fix bug in 2 places)

#### 2. Accessibility Gaps
- Missing ARIA labels (`aria-label`, `role="region"`)
- No keyboard navigation (left/right arrow keys)
- No focus management (focus trap in carousel?)
- Missing live region announcements (`aria-live`)

#### 3. Touch/Swipe Inconsistencies
- Unknown if touch events implemented
- No gesture indicators (swipe hint)
- May not work on touch devices

#### 4. Performance Issues
- All images loaded immediately (not lazy)
- Large hero images blocking render
- No preconnect for external images

---

## Proposed Carousel System

### Technology Choice: Swiper.js

**Rationale**:
- Industry standard (10K+ GitHub stars)
- Fully accessible (WCAG 2.1 AA)
- Touch/swipe built-in
- Lazy loading built-in
- Modular (only load needed features)
- WordPress-friendly (no jQuery dependency)

**Alternative Considered**: Splide.js
- Lighter weight
- But less features, smaller community

**Decision**: Swiper.js for feature completeness.

---

### Swiper.js Integration Plan

#### Installation

**Option 1: CDN (Quick, for testing)**
```html
<!-- In header.php or enqueue.php -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
```

**Option 2: NPM + Build (Production)**
```bash
npm install swiper
# Then import in main JS file and bundle with webpack/vite
```

**Recommendation**: Start with CDN for Phase 5, move to NPM in Phase 6 cleanup.

---

### Base Carousel Component

**File**: `components/carousel/carousel-base.php`

```php
<?php
/**
 * Universal Carousel Component
 * Powered by Swiper.js
 *
 * @param array $args {
 *   @type string   $id              Unique carousel ID (required)
 *   @type array    $slides          Array of slide data (required)
 *   @type string   $variant         Carousel variant (default, testimonial, gallery)
 *   @type bool     $autoplay        Enable autoplay (default: false)
 *   @type int      $autoplay_delay  Autoplay delay in ms (default: 3000)
 *   @type bool     $loop            Enable loop (default: true)
 *   @type bool     $navigation      Show prev/next buttons (default: true)
 *   @type bool     $pagination      Show pagination dots (default: true)
 *   @type int      $slides_per_view Number of slides visible (default: 1)
 *   @type int      $space_between   Space between slides in px (default: 16)
 *   @type bool     $lazy_load       Enable lazy loading (default: true)
 *   @type string   $classes         Additional CSS classes (default: '')
 * }
 * @return void
 */
function aitsc_render_carousel( $args = [] ) {
    // Defaults
    $defaults = [
        'id'              => 'carousel-' . uniqid(),
        'slides'          => [],
        'variant'         => 'default',
        'autoplay'        => false,
        'autoplay_delay'  => 3000,
        'loop'            => true,
        'navigation'      => true,
        'pagination'      => true,
        'slides_per_view' => 1,
        'space_between'   => 16,
        'lazy_load'       => true,
        'classes'         => '',
    ];

    $args = wp_parse_args( $args, $defaults );

    // Validate
    if ( empty( $args['slides'] ) ) {
        return; // No slides, no carousel
    }

    $carousel_id = esc_attr( $args['id'] );
    $variant_class = 'carousel--' . sanitize_html_class( $args['variant'] );

    // Build Swiper config (JSON for JS)
    $swiper_config = [
        'loop'           => $args['loop'],
        'slidesPerView'  => $args['slides_per_view'],
        'spaceBetween'   => $args['space_between'],
        'navigation'     => $args['navigation'] ? [
            'nextEl' => "#{$carousel_id} .swiper-button-next",
            'prevEl' => "#{$carousel_id} .swiper-button-prev",
        ] : false,
        'pagination'     => $args['pagination'] ? [
            'el'        => "#{$carousel_id} .swiper-pagination",
            'clickable' => true,
        ] : false,
        'a11y'           => [
            'enabled' => true,
        ],
    ];

    if ( $args['autoplay'] ) {
        $swiper_config['autoplay'] = [
            'delay' => $args['autoplay_delay'],
            'disableOnInteraction' => true,
        ];
    }

    if ( $args['lazy_load'] ) {
        $swiper_config['lazy'] = [
            'loadPrevNext' => true,
        ];
    }

    $swiper_config_json = json_encode( $swiper_config );
    ?>
    <div
        id="<?php echo $carousel_id; ?>"
        class="carousel <?php echo esc_attr( $variant_class . ' ' . $args['classes'] ); ?>"
        data-swiper-config='<?php echo $swiper_config_json; ?>'
        role="region"
        aria-label="<?php echo esc_attr( $args['variant'] . ' carousel' ); ?>"
    >
        <div class="swiper">
            <div class="swiper-wrapper">
                <?php foreach ( $args['slides'] as $index => $slide ) : ?>
                    <div class="swiper-slide">
                        <?php
                        // Render slide content based on variant
                        switch ( $args['variant'] ) {
                            case 'testimonial':
                                aitsc_render_testimonial_slide( $slide );
                                break;
                            case 'gallery':
                                aitsc_render_gallery_slide( $slide, $args['lazy_load'] );
                                break;
                            default:
                                aitsc_render_default_slide( $slide, $args['lazy_load'] );
                                break;
                        }
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ( $args['navigation'] ) : ?>
                <div class="swiper-button-prev" aria-label="Previous slide"></div>
                <div class="swiper-button-next" aria-label="Next slide"></div>
            <?php endif; ?>

            <?php if ( $args['pagination'] ) : ?>
                <div class="swiper-pagination" aria-label="Carousel pagination"></div>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

/**
 * Render Default Slide
 */
function aitsc_render_default_slide( $slide, $lazy = true ) {
    ?>
    <div class="carousel__slide">
        <?php if ( ! empty( $slide['image'] ) ) : ?>
            <img
                <?php if ( $lazy ) : ?>
                    data-src="<?php echo esc_url( $slide['image'] ); ?>"
                    class="swiper-lazy"
                <?php else : ?>
                    src="<?php echo esc_url( $slide['image'] ); ?>"
                <?php endif; ?>
                alt="<?php echo esc_attr( $slide['alt'] ?? '' ); ?>"
            >
            <?php if ( $lazy ) : ?>
                <div class="swiper-lazy-preloader"></div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ( ! empty( $slide['title'] ) || ! empty( $slide['content'] ) ) : ?>
            <div class="carousel__content">
                <?php if ( ! empty( $slide['title'] ) ) : ?>
                    <h3 class="carousel__title"><?php echo esc_html( $slide['title'] ); ?></h3>
                <?php endif; ?>

                <?php if ( ! empty( $slide['content'] ) ) : ?>
                    <p class="carousel__text"><?php echo wp_kses_post( $slide['content'] ); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Render Testimonial Slide
 */
function aitsc_render_testimonial_slide( $slide ) {
    ?>
    <blockquote class="testimonial">
        <p class="testimonial__quote"><?php echo wp_kses_post( $slide['quote'] ); ?></p>

        <footer class="testimonial__author">
            <?php if ( ! empty( $slide['avatar'] ) ) : ?>
                <img
                    src="<?php echo esc_url( $slide['avatar'] ); ?>"
                    alt="<?php echo esc_attr( $slide['name'] ?? '' ); ?>"
                    class="testimonial__avatar"
                >
            <?php endif; ?>

            <div class="testimonial__meta">
                <cite class="testimonial__name"><?php echo esc_html( $slide['name'] ?? '' ); ?></cite>
                <?php if ( ! empty( $slide['position'] ) ) : ?>
                    <span class="testimonial__position"><?php echo esc_html( $slide['position'] ); ?></span>
                <?php endif; ?>
            </div>
        </footer>
    </blockquote>
    <?php
}

/**
 * Render Gallery Slide
 */
function aitsc_render_gallery_slide( $slide, $lazy = true ) {
    ?>
    <figure class="gallery-slide">
        <img
            <?php if ( $lazy ) : ?>
                data-src="<?php echo esc_url( $slide['image'] ); ?>"
                class="swiper-lazy"
            <?php else : ?>
                src="<?php echo esc_url( $slide['image'] ); ?>"
            <?php endif; ?>
            alt="<?php echo esc_attr( $slide['alt'] ?? '' ); ?>"
        >
        <?php if ( $lazy ) : ?>
            <div class="swiper-lazy-preloader"></div>
        <?php endif; ?>

        <?php if ( ! empty( $slide['caption'] ) ) : ?>
            <figcaption class="gallery-slide__caption">
                <?php echo wp_kses_post( $slide['caption'] ); ?>
            </figcaption>
        <?php endif; ?>
    </figure>
    <?php
}
```

---

### Carousel Styles

**File**: `components/carousel/carousel-styles.css`

```css
/**
 * Carousel Component Styles
 * Built on Swiper.js
 */

/* Base carousel container */
.carousel {
  position: relative;
  width: 100%;
  overflow: hidden;
}

/* Swiper container */
.carousel .swiper {
  width: 100%;
  height: 100%;
}

/* Slide wrapper */
.carousel__slide {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
}

/* Slide image */
.carousel__slide img {
  width: 100%;
  height: auto;
  object-fit: cover;
  border-radius: var(--carousel-image-radius, 8px);
}

/* Slide content */
.carousel__content {
  padding: var(--space-6) var(--space-4);
}

.carousel__title {
  font-size: var(--font-size-2xl);
  font-weight: var(--font-weight-bold);
  margin-bottom: var(--space-4);
  color: var(--color-text-heading);
}

.carousel__text {
  font-size: var(--font-size-md);
  line-height: var(--line-height-relaxed);
  color: var(--color-text-muted);
}

/* Navigation buttons */
.carousel .swiper-button-prev,
.carousel .swiper-button-next {
  width: 48px;
  height: 48px;
  background: rgba(255, 255, 255, 0.9);
  border-radius: 50%;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  color: var(--color-primary, #007bff);
  transition: all 0.2s ease;
}

.carousel .swiper-button-prev:hover,
.carousel .swiper-button-next:hover {
  background: rgba(255, 255, 255, 1);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.carousel .swiper-button-prev::after,
.carousel .swiper-button-next::after {
  font-size: 20px;
  font-weight: bold;
}

/* Pagination */
.carousel .swiper-pagination {
  bottom: var(--space-4);
}

.carousel .swiper-pagination-bullet {
  width: 12px;
  height: 12px;
  background: rgba(255, 255, 255, 0.5);
  opacity: 1;
  transition: all 0.2s ease;
}

.carousel .swiper-pagination-bullet-active {
  background: var(--color-primary, #007bff);
  transform: scale(1.2);
}

/* Lazy loading preloader */
.swiper-lazy-preloader {
  width: 42px;
  height: 42px;
  border: 4px solid var(--color-primary, #007bff);
  border-top-color: transparent;
  border-radius: 50%;
  animation: swiper-preloader-spin 1s linear infinite;
}

@keyframes swiper-preloader-spin {
  100% {
    transform: rotate(360deg);
  }
}

/* Testimonial variant */
.carousel--testimonial .testimonial {
  max-width: 800px;
  margin: 0 auto;
  padding: var(--space-8) var(--space-6);
}

.testimonial__quote {
  font-size: var(--font-size-xl);
  font-style: italic;
  line-height: var(--line-height-relaxed);
  color: var(--color-text-body);
  margin-bottom: var(--space-6);
}

.testimonial__quote::before {
  content: '"';
  font-size: var(--font-size-3xl);
  color: var(--color-primary);
  margin-right: var(--space-2);
}

.testimonial__author {
  display: flex;
  align-items: center;
  gap: var(--space-4);
  justify-content: center;
}

.testimonial__avatar {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  object-fit: cover;
}

.testimonial__meta {
  text-align: left;
}

.testimonial__name {
  display: block;
  font-size: var(--font-size-lg);
  font-weight: var(--font-weight-semibold);
  font-style: normal;
  color: var(--color-text-heading);
}

.testimonial__position {
  display: block;
  font-size: var(--font-size-sm);
  color: var(--color-text-muted);
}

/* Gallery variant */
.carousel--gallery .gallery-slide img {
  width: 100%;
  height: 400px;
  object-fit: cover;
}

.gallery-slide__caption {
  padding: var(--space-4);
  font-size: var(--font-size-sm);
  color: var(--color-text-muted);
  text-align: center;
}

/* Responsive */
@media (min-width: 48rem) {
  .carousel .swiper-button-prev,
  .carousel .swiper-button-next {
    width: 56px;
    height: 56px;
  }

  .carousel--gallery .gallery-slide img {
    height: 500px;
  }
}

/* Reduced motion */
@media (prefers-reduced-motion: reduce) {
  .carousel .swiper-slide {
    transition: none !important;
  }

  .swiper-lazy-preloader {
    animation: none;
  }
}
```

---

### Carousel Initialization JS

**File**: `assets/js/carousel-init.js`

```javascript
/**
 * Carousel Initialization
 * Initializes all Swiper carousels on page
 */
document.addEventListener('DOMContentLoaded', function() {
  // Find all carousels
  const carousels = document.querySelectorAll('[data-swiper-config]');

  carousels.forEach(function(carouselEl) {
    // Get config from data attribute
    const config = JSON.parse(carouselEl.getAttribute('data-swiper-config'));

    // Find swiper container
    const swiperEl = carouselEl.querySelector('.swiper');

    if (!swiperEl) {
      console.warn('Swiper container not found for carousel:', carouselEl);
      return;
    }

    // Initialize Swiper
    const swiper = new Swiper(swiperEl, {
      ...config,
      // Add keyboard navigation
      keyboard: {
        enabled: true,
        onlyInViewport: true,
      },
      // Accessibility improvements
      a11y: {
        enabled: true,
        prevSlideMessage: 'Previous slide',
        nextSlideMessage: 'Next slide',
        firstSlideMessage: 'This is the first slide',
        lastSlideMessage: 'This is the last slide',
        paginationBulletMessage: 'Go to slide {{index}}',
      },
      // Touch/swipe settings
      touchRatio: 1,
      threshold: 10, // Minimum px to trigger swipe
      // Performance
      watchSlidesProgress: true,
      watchSlidesVisibility: true,
    });

    // Pause autoplay on hover (accessibility)
    if (config.autoplay) {
      carouselEl.addEventListener('mouseenter', function() {
        swiper.autoplay.stop();
      });

      carouselEl.addEventListener('mouseleave', function() {
        swiper.autoplay.start();
      });
    }

    // Live region announcements for accessibility
    const liveRegion = document.createElement('div');
    liveRegion.setAttribute('aria-live', 'polite');
    liveRegion.setAttribute('aria-atomic', 'true');
    liveRegion.className = 'sr-only'; // Screen reader only
    carouselEl.appendChild(liveRegion);

    swiper.on('slideChange', function() {
      const activeIndex = swiper.activeIndex + 1;
      const totalSlides = swiper.slides.length;
      liveRegion.textContent = `Slide ${activeIndex} of ${totalSlides}`;
    });
  });
});
```

---

## Migration Strategy

### Step 1: Install Swiper.js

**Enqueue via CDN** (quick setup):

**File**: `inc/enqueue.php`

```php
// Enqueue Swiper CSS
wp_enqueue_style(
    'swiper',
    'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
    array(),
    '11.0.0'
);

// Enqueue Swiper JS
wp_enqueue_script(
    'swiper',
    'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
    array(),
    '11.0.0',
    true
);

// Enqueue carousel init script
wp_enqueue_script(
    'aitsc-carousel-init',
    get_template_directory_uri() . '/assets/js/carousel-init.js',
    array('swiper'),
    AITSC_VERSION,
    true
);

// Enqueue carousel component styles
wp_enqueue_style(
    'aitsc-component-carousel',
    get_template_directory_uri() . '/components/carousel/carousel-styles.css',
    array('swiper'),
    AITSC_VERSION
);
```

**Commit**: `feat(carousel): Add Swiper.js library and init script`

---

### Step 2: Create Carousel Component

**Tasks**:
1. Create `components/carousel/carousel-base.php`
2. Create `components/carousel/carousel-styles.css`
3. Register in `inc/components.php`

**Commit**: `feat(carousel): Add universal carousel component`

---

### Step 3: Migrate Existing Sliders

#### Example: Testimonial Carousel

**Before** (custom implementation):
```php
<!-- Unknown structure, needs audit -->
<div class="testimonial-slider">
  <!-- Custom HTML + JS -->
</div>
```

**After**:
```php
<?php
$testimonials = [
    [
        'quote'    => 'AITSC transformed our fleet safety program...',
        'name'     => 'John Smith',
        'position' => 'Fleet Manager, ABC Transport',
        'avatar'   => get_template_directory_uri() . '/assets/images/testimonials/john.jpg',
    ],
    [
        'quote'    => 'Outstanding service and expertise...',
        'name'     => 'Jane Doe',
        'position' => 'Operations Director, XYZ Logistics',
        'avatar'   => get_template_directory_uri() . '/assets/images/testimonials/jane.jpg',
    ],
];

aitsc_render_carousel([
    'id'       => 'testimonials-carousel',
    'variant'  => 'testimonial',
    'slides'   => $testimonials,
    'autoplay' => true,
    'autoplay_delay' => 5000,
]);
?>
```

---

#### Example: Gallery Slider

**Before** (inline implementation):
```php
<!-- Solution gallery -->
<div class="gallery">
  <?php foreach ($gallery_images as $image) : ?>
    <img src="<?php echo $image; ?>">
  <?php endforeach; ?>
</div>
```

**After**:
```php
<?php
$gallery_slides = [];
foreach ($gallery_images as $image) {
    $gallery_slides[] = [
        'image'   => $image['url'],
        'alt'     => $image['alt'],
        'caption' => $image['caption'] ?? '',
    ];
}

aitsc_render_carousel([
    'id'             => 'solution-gallery-' . get_the_ID(),
    'variant'        => 'gallery',
    'slides'         => $gallery_slides,
    'slides_per_view' => 1,
    'space_between'  => 0,
    'lazy_load'      => true,
]);
?>
```

---

### Step 4: Remove Old Slider Code

**Files to Clean**:
1. `assets/js/scroll-animations.js` (if slider code exists)
2. Old carousel CSS in `style.css`
3. Legacy slider HTML in templates

**Process**:
1. Comment out old code first
2. Test pages with new Swiper carousel
3. If tests pass, delete commented code
4. Commit: `refactor(carousel): Remove legacy slider implementations`

---

## Testing Checklist

### Functionality Tests

- [ ] Testimonial carousel: Slides auto-advance
- [ ] Gallery carousel: Images lazy load
- [ ] Prev/Next buttons: Navigate correctly
- [ ] Pagination dots: Jump to specific slide
- [ ] Loop mode: Returns to start after last slide
- [ ] Autoplay: Pauses on hover (accessibility)

### Touch/Swipe Tests

- [ ] Mobile: Swipe left/right works
- [ ] Tablet: Touch navigation works
- [ ] Desktop: Mouse drag works (if enabled)
- [ ] Gesture hints: Visible on touch devices

### Keyboard Navigation Tests

- [ ] Tab: Focuses carousel region
- [ ] Arrow keys: Navigate slides (when focused)
- [ ] Escape: Exits focus (returns to page flow)
- [ ] Enter/Space: Activates pagination dots

### Accessibility Tests

- [ ] ARIA labels: Present on all interactive elements
- [ ] Screen reader: Announces slide changes
- [ ] Keyboard: All functionality accessible
- [ ] Focus indicators: Visible on nav elements
- [ ] Reduced motion: Disables animations

### Performance Tests

- [ ] Lazy loading: Only visible images load
- [ ] Large gallery: No layout shift (CLS)
- [ ] Autoplay: No memory leaks (long session)
- [ ] Multiple carousels: All initialize correctly

---

## Success Criteria

### Quantitative
- [ ] Slider implementations reduced from 3+ to 1 (Swiper)
- [ ] All carousels have ARIA labels
- [ ] All carousels support keyboard navigation
- [ ] Lazy loading reduces initial page weight by 30%+

### Qualitative
- [ ] Consistent swipe/touch behavior across all carousels
- [ ] Clear visual feedback for interactions
- [ ] Smooth animations (60 FPS)
- [ ] Accessible to screen reader users

---

## Time Breakdown

**Hour 1**: Setup
- Install Swiper.js (CDN)
- Create `carousel-init.js`
- Enqueue scripts/styles
- Test basic Swiper demo

**Hour 2-3**: Component creation
- Build `carousel-base.php`
- Create variant renderers (testimonial, gallery)
- Write `carousel-styles.css`
- Register in component system

**Hour 4-5**: Migration
- Audit existing sliders
- Migrate testimonial carousel
- Migrate gallery slider
- Test each migration

**Hour 6**: Accessibility & Polish
- Add keyboard navigation
- Add ARIA live regions
- Test with screen reader
- Performance audit (lazy loading)
- Documentation

---

## Rollback Plan

**If Swiper.js causes issues**:

```bash
# Remove Swiper enqueues
git checkout HEAD -- inc/enqueue.php

# Restore old slider code
# (Depends on what was replaced)
git checkout HEAD -- assets/js/scroll-animations.js

# Revert templates
git checkout HEAD -- [template-with-carousel.php]
```

---

## Open Questions

1. **Swiper Version**: Use v11 (latest) or v10 (more stable)?
   - **Decision**: v11 (smaller bundle, better a11y)

2. **Thumbnail Navigation**: Add thumbnail previews for galleries?
   - **Consideration**: Swiper has built-in thumbs module
   - **Decision**: Add if client requests

3. **Video Slides**: Support embedded videos (YouTube, Vimeo)?
   - **Consideration**: Swiper supports video slides
   - **Decision**: Out of scope, add later if needed

---

**Phase Owner**: Development Team
**Reviewer**: Tech Lead + Accessibility Specialist
**Approval Required**: After accessibility audit
**Estimated Completion**: 1.5 days (6 working hours)
