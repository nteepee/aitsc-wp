# Phase 2: Card Component Consolidation

**Phase ID**: phase-2-card-consolidation
**Priority**: HIGH
**Estimated Effort**: 6-8 hours
**Dependencies**: Phase 1 (Breakpoint Standardization)
**Risk Level**: High (affects 23+ files)

---

## Objectives

1. Merge 4+ card implementations into single unified system
2. Create card base component with variant system
3. Migrate all card usages to new component API
4. Remove duplicate card styles and code

---

## Current State Analysis

### Card Implementations Found

#### 1. Glass Card (`.glass-card`)
**Location**: `style.css` (inline styles)
**Characteristics**:
- Glassmorphism aesthetic (backdrop-filter, blur)
- Semi-transparent background
- Border with subtle gradient
- Used in: Homepage features, solution highlights

**Example**:
```css
.glass-card {
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 16px;
  padding: 2rem;
}
```

---

#### 2. Solution Card (`.solution-card`)
**Location**: `archive-solutions.php`, `style.css`
**Characteristics**:
- Featured image at top
- Title + excerpt
- "Learn More" CTA button
- Hover: lift + shadow effect

**HTML Structure**:
```html
<div class="solution-card">
  <img src="..." alt="...">
  <h3>Solution Title</h3>
  <p>Excerpt text...</p>
  <a href="..." class="btn">Learn More</a>
</div>
```

---

#### 3. WorldQuant Blog Card (`.wq-blog-card`)
**Location**: `front-page.php`, `style.css`
**Characteristics**:
- Dark theme variant
- Category badge
- Read time indicator
- Horizontal layout option (featured post)

**Variants**:
- `.wq-blog-card--vertical` (default)
- `.wq-blog-card--horizontal` (featured)
- `.wq-blog-card--dark` (theme variant)

---

#### 4. PHP-Rendered Card (`aitsc_render_card()`)
**Location**: `components/card/card-base.php`
**Characteristics**:
- Function-based rendering
- Accepts associative array args
- More flexible (can add data attributes)
- Used in newer templates

**API**:
```php
aitsc_render_card([
  'title' => 'Card Title',
  'content' => 'Card content',
  'image' => 'image-url.jpg',
  'link' => '/permalink',
  'variant' => 'glass', // or 'solution', 'blog'
]);
```

---

### Overlap Analysis

**Common Patterns Across All 4**:
1. Container with padding
2. Border-radius (all use 12px-16px)
3. Box-shadow (all use similar elevation)
4. Hover states (transform: scale or translateY)
5. Responsive behavior (stack on mobile)

**Unique Features**:
- Glass: Backdrop blur (exclusive)
- Solution: Featured image dominance
- Blog: Metadata badges (category, time)
- PHP: Programmatic rendering

**Issue**: 70% code duplication, 30% unique features.

---

## Proposed Card System Architecture

### Component Structure

```
components/card/
├── card-base.php              [PHP rendering function]
├── card-variants.css          [Base + variant styles]
├── card-animations.css        [Hover/focus/active states]
└── README.md                  [Component documentation]
```

---

### BEM Naming Convention

```css
/* Block */
.card { }

/* Elements */
.card__image { }
.card__badge { }
.card__title { }
.card__content { }
.card__meta { }
.card__cta { }

/* Modifiers */
.card--glass { }
.card--solution { }
.card--blog { }
.card--featured { }
.card--horizontal { }
.card--dark { }
```

---

### Base Component (`.card`)

**File**: `components/card/card-variants.css`

```css
/**
 * Card Base Component
 * Shared foundation for all card variants
 */
.card {
  /* Layout */
  display: flex;
  flex-direction: column;

  /* Spacing */
  padding: var(--card-padding, 1.5rem);

  /* Appearance */
  background: var(--card-bg, #ffffff);
  border: var(--card-border, 1px solid rgba(0, 0, 0, 0.1));
  border-radius: var(--card-radius, 12px);
  box-shadow: var(--card-shadow, 0 2px 8px rgba(0, 0, 0, 0.08));

  /* Transitions */
  transition: transform 0.2s ease, box-shadow 0.2s ease;

  /* Reset */
  overflow: hidden;
}

/* Responsive padding */
@media (min-width: 48rem) {
  .card {
    --card-padding: 2rem;
  }
}

/* Elements */
.card__image {
  width: 100%;
  height: auto;
  object-fit: cover;
  margin: calc(var(--card-padding) * -1); /* Negative margin to bleed */
  margin-bottom: 1.5rem;
}

.card__badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  font-size: 0.875rem;
  font-weight: 600;
  background: var(--badge-bg, #007bff);
  color: var(--badge-color, #ffffff);
  border-radius: 4px;
  margin-bottom: 0.5rem;
}

.card__title {
  font-size: 1.25rem;
  font-weight: 700;
  margin: 0 0 0.75rem;
  color: var(--card-title-color, #1a1a1a);
}

.card__content {
  font-size: 1rem;
  line-height: 1.6;
  color: var(--card-content-color, #666);
  margin: 0 0 1rem;
  flex-grow: 1; /* Push CTA to bottom */
}

.card__meta {
  display: flex;
  gap: 1rem;
  font-size: 0.875rem;
  color: var(--card-meta-color, #999);
  margin-bottom: 1rem;
}

.card__cta {
  align-self: flex-start;
  margin-top: auto; /* Stick to bottom */
}
```

---

### Variant 1: Glass Card

**File**: `components/card/card-variants.css`

```css
/**
 * Glass Card Variant
 * Glassmorphism aesthetic with backdrop blur
 */
.card--glass {
  --card-bg: rgba(255, 255, 255, 0.1);
  --card-border: 1px solid rgba(255, 255, 255, 0.2);
  --card-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
  --card-radius: 16px;
  --card-title-color: #ffffff;
  --card-content-color: rgba(255, 255, 255, 0.9);

  backdrop-filter: blur(10px) saturate(180%);
  -webkit-backdrop-filter: blur(10px) saturate(180%);
}

/* Dark backgrounds for glass */
.card--glass::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg,
    rgba(255, 255, 255, 0.1) 0%,
    rgba(255, 255, 255, 0.05) 100%
  );
  border-radius: inherit;
  pointer-events: none;
}
```

---

### Variant 2: Solution Card

**File**: `components/card/card-variants.css`

```css
/**
 * Solution Card Variant
 * Featured image with call-to-action
 */
.card--solution {
  --card-padding: 0; /* Image bleeds to edges */
}

.card--solution .card__image {
  margin: 0;
  height: 200px;
  object-fit: cover;
}

.card--solution .card__title,
.card--solution .card__content,
.card--solution .card__cta {
  padding-left: 1.5rem;
  padding-right: 1.5rem;
}

.card--solution .card__title {
  padding-top: 1.5rem;
}

.card--solution .card__cta {
  padding-bottom: 1.5rem;
}

@media (min-width: 48rem) {
  .card--solution .card__image {
    height: 240px;
  }
}
```

---

### Variant 3: Blog Card

**File**: `components/card/card-variants.css`

```css
/**
 * Blog Card Variant
 * With category badge and metadata
 */
.card--blog {
  /* Inherits base styles */
}

/* Horizontal layout for featured posts */
.card--blog.card--horizontal {
  flex-direction: row;
  gap: 1.5rem;
}

.card--blog.card--horizontal .card__image {
  width: 40%;
  height: auto;
  min-height: 200px;
  margin: 0;
}

.card--blog.card--horizontal .card__body {
  flex: 1;
}

/* Dark theme variant */
.card--blog.card--dark {
  --card-bg: #1a1a1a;
  --card-border: 1px solid #333;
  --card-title-color: #ffffff;
  --card-content-color: #cccccc;
  --card-meta-color: #999999;
}

@media (max-width: 48rem) {
  .card--blog.card--horizontal {
    flex-direction: column; /* Stack on mobile */
  }

  .card--blog.card--horizontal .card__image {
    width: 100%;
  }
}
```

---

### Animations & Interactions

**File**: `components/card/card-animations.css`

```css
/**
 * Card Animations & Interactions
 * Hover, focus, and active states
 */

/* Hover: Lift effect */
.card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

/* Focus: Accessibility outline */
.card:focus-within {
  outline: 2px solid var(--focus-color, #007bff);
  outline-offset: 2px;
}

/* Active: Press effect */
.card:active {
  transform: translateY(-2px);
}

/* Glass card hover: Enhance blur */
.card--glass:hover {
  backdrop-filter: blur(15px) saturate(200%);
  --card-border: 1px solid rgba(255, 255, 255, 0.3);
}

/* Solution card hover: Scale image */
.card--solution:hover .card__image {
  transform: scale(1.05);
  transition: transform 0.3s ease;
}

/* Reduce motion for accessibility */
@media (prefers-reduced-motion: reduce) {
  .card,
  .card:hover,
  .card:active,
  .card__image {
    transform: none !important;
    transition: none !important;
  }
}
```

---

### PHP Rendering Function

**File**: `components/card/card-base.php`

```php
<?php
/**
 * Universal Card Component
 * Renders a card with configurable variants
 *
 * @param array $args {
 *   @type string $variant      Card variant (glass, solution, blog). Default 'default'.
 *   @type string $layout       Layout orientation (vertical, horizontal). Default 'vertical'.
 *   @type string $theme        Theme variant (light, dark). Default 'light'.
 *   @type string $title        Card title. Required.
 *   @type string $content      Card content/excerpt. Optional.
 *   @type string $image        Image URL. Optional.
 *   @type string $image_alt    Image alt text. Default ''.
 *   @type string $badge        Badge text (e.g., category name). Optional.
 *   @type string $badge_color  Badge background color. Default '#007bff'.
 *   @type array  $meta         Metadata items (e.g., ['date' => '2024-01-01', 'author' => 'John']). Optional.
 *   @type string $link         Card link URL. Optional.
 *   @type string $cta_text     CTA button text. Default 'Learn More'.
 *   @type string $classes      Additional CSS classes. Default ''.
 * }
 * @return void
 */
function aitsc_render_card( $args = [] ) {
    // Defaults
    $defaults = [
        'variant'      => 'default',
        'layout'       => 'vertical',
        'theme'        => 'light',
        'title'        => '',
        'content'      => '',
        'image'        => '',
        'image_alt'    => '',
        'badge'        => '',
        'badge_color'  => '#007bff',
        'meta'         => [],
        'link'         => '',
        'cta_text'     => 'Learn More',
        'classes'      => '',
    ];

    $args = wp_parse_args( $args, $defaults );

    // Validate required fields
    if ( empty( $args['title'] ) ) {
        return; // Title is required
    }

    // Build classes
    $card_classes = ['card'];

    if ( ! empty( $args['variant'] ) && $args['variant'] !== 'default' ) {
        $card_classes[] = 'card--' . sanitize_html_class( $args['variant'] );
    }

    if ( $args['layout'] === 'horizontal' ) {
        $card_classes[] = 'card--horizontal';
    }

    if ( $args['theme'] === 'dark' ) {
        $card_classes[] = 'card--dark';
    }

    if ( ! empty( $args['classes'] ) ) {
        $card_classes[] = sanitize_html_class( $args['classes'] );
    }

    $card_class_string = implode( ' ', $card_classes );

    // Start output
    ?>
    <article class="<?php echo esc_attr( $card_class_string ); ?>">
        <?php if ( ! empty( $args['image'] ) ) : ?>
            <img
                src="<?php echo esc_url( $args['image'] ); ?>"
                alt="<?php echo esc_attr( $args['image_alt'] ); ?>"
                class="card__image"
                loading="lazy"
            >
        <?php endif; ?>

        <div class="card__body">
            <?php if ( ! empty( $args['badge'] ) ) : ?>
                <span class="card__badge" style="background-color: <?php echo esc_attr( $args['badge_color'] ); ?>">
                    <?php echo esc_html( $args['badge'] ); ?>
                </span>
            <?php endif; ?>

            <h3 class="card__title">
                <?php if ( ! empty( $args['link'] ) ) : ?>
                    <a href="<?php echo esc_url( $args['link'] ); ?>">
                        <?php echo esc_html( $args['title'] ); ?>
                    </a>
                <?php else : ?>
                    <?php echo esc_html( $args['title'] ); ?>
                <?php endif; ?>
            </h3>

            <?php if ( ! empty( $args['content'] ) ) : ?>
                <div class="card__content">
                    <?php echo wp_kses_post( $args['content'] ); ?>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $args['meta'] ) ) : ?>
                <div class="card__meta">
                    <?php foreach ( $args['meta'] as $key => $value ) : ?>
                        <span class="card__meta-item card__meta-<?php echo esc_attr( $key ); ?>">
                            <?php echo esc_html( $value ); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $args['link'] ) ) : ?>
                <a href="<?php echo esc_url( $args['link'] ); ?>" class="btn card__cta">
                    <?php echo esc_html( $args['cta_text'] ); ?>
                </a>
            <?php endif; ?>
        </div>
    </article>
    <?php
}
```

---

## Migration Strategy

### Step 1: Create New Component System

**Tasks**:
1. Create directory: `components/card/`
2. Create `card-base.php` (PHP function)
3. Create `card-variants.css` (base + variants)
4. Create `card-animations.css` (interactions)
5. Create `README.md` (documentation)

**Commit**: `feat(components): Add unified card component system`

---

### Step 2: Migrate Template Files (One at a Time)

#### Migration Priority Order:

1. **Low-Risk**: `taxonomy-solution_category.php` (simple grid of solution cards)
2. **Medium-Risk**: `archive-solutions.php` (solutions archive)
3. **High-Risk**: `front-page.php` (homepage, multiple card types)

---

#### Example Migration: `archive-solutions.php`

**Before**:
```php
<div class="solution-card">
  <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
  <h3><?php the_title(); ?></h3>
  <p><?php the_excerpt(); ?></p>
  <a href="<?php the_permalink(); ?>" class="btn">Learn More</a>
</div>
```

**After**:
```php
<?php
aitsc_render_card([
    'variant'   => 'solution',
    'title'     => get_the_title(),
    'content'   => get_the_excerpt(),
    'image'     => get_the_post_thumbnail_url( get_the_ID(), 'medium' ),
    'image_alt' => get_the_title(),
    'link'      => get_the_permalink(),
    'cta_text'  => 'Learn More',
]);
?>
```

**Benefits**:
- Consistent markup
- Centralized styling
- Easier to update globally

---

### Step 3: Update Component Registration

**File**: `inc/components.php`

**Before**:
```php
require_once $component_dir . '/card/card-base.php';
```

**After** (add CSS enqueuing):
```php
// Load card component
require_once $component_dir . '/card/card-base.php';

// Enqueue card styles
wp_enqueue_style(
    'aitsc-component-card-variants',
    $component_dir . '/card/card-variants.css',
    array(),
    AITSC_VERSION
);

wp_enqueue_style(
    'aitsc-component-card-animations',
    $component_dir . '/card/card-animations.css',
    array('aitsc-component-card-variants'),
    AITSC_VERSION
);
```

---

### Step 4: Remove Old Card Styles

**File**: `style.css`

**Search & Remove**:
```bash
# Find all old card classes
grep -n "\.glass-card\|\.solution-card\|\.wq-blog-card" style.css
```

**Process**:
1. Copy old styles to `style.css.backup`
2. Comment out old card styles (don't delete yet)
3. Test pages for regressions
4. If all tests pass, delete commented code
5. Commit: `refactor(cards): Remove duplicate card styles`

**Expected Reduction**: ~200-300 lines from `style.css`

---

## Migration Checklist

### Files to Update

#### High Priority (Card Usage)
- [ ] `front-page.php` (homepage cards)
- [ ] `archive-solutions.php` (solution grid)
- [ ] `taxonomy-solution_category.php` (category archive)
- [ ] `single-solutions.php` (related solutions)
- [ ] `page-about.php` (team cards, if any)

#### Medium Priority (Component System)
- [ ] `inc/components.php` (registration)
- [ ] `functions.php` (check for card-related code)

#### Low Priority (Legacy)
- [ ] `assets_legacy_backup/*.php` (check for old card usage)

---

### Testing Matrix

#### Visual Regression Testing

**Test Each Card Variant**:
- [ ] Glass card (homepage features)
- [ ] Solution card (solutions archive)
- [ ] Blog card vertical (blog posts)
- [ ] Blog card horizontal (featured posts)
- [ ] Dark theme variant

**Test Responsive Behavior**:
- [ ] Mobile (375px): Cards stack vertically
- [ ] Tablet (768px): Cards in 2-column grid
- [ ] Desktop (992px): Cards in 3-column grid
- [ ] Wide (1200px): Cards in 4-column grid (if applicable)

**Test Interactions**:
- [ ] Hover: Lift effect works
- [ ] Focus: Outline appears (keyboard nav)
- [ ] Click: Link navigates correctly
- [ ] Reduced motion: Animations disabled

---

### Browser Testing

- [ ] Chrome (latest): All variants render
- [ ] Firefox (latest): Backdrop-filter support (glass)
- [ ] Safari (latest): WebKit prefix for backdrop-filter
- [ ] Edge (latest): Chromium engine
- [ ] Mobile Safari: Touch interactions
- [ ] Chrome Mobile: Performance on Android

---

## Performance Considerations

### Before vs After

**Before** (4 implementations):
- `style.css`: ~300 lines of card styles
- Inline styles scattered across templates
- Multiple HTTP requests for component CSS

**After** (1 unified system):
- `card-variants.css`: ~150 lines (50% reduction)
- `card-animations.css`: ~50 lines (separated for lazy load)
- Single component system

**Expected Improvements**:
- **CSS Size**: -40% (200 lines removed)
- **Maintainability**: +300% (1 place to update vs 4)
- **Consistency**: 100% (all cards use same base)

---

### Lazy Loading Animations

**Optimization**: Defer animation CSS until interaction

**Strategy**:
```php
// Only load animations if user can hover (not touch-only devices)
if ( ! wp_is_mobile() ) {
    wp_enqueue_style( 'aitsc-component-card-animations' );
}
```

**Savings**: ~50 lines of CSS for mobile users (no hover capability)

---

## Rollback Plan

### Per-Template Rollback

**If migration breaks a page**:

1. **Revert template file**:
   ```bash
   git checkout HEAD -- archive-solutions.php
   ```

2. **Restore old card styles**:
   ```bash
   # Uncomment in style.css
   ```

3. **Test reverted page**

---

### Full Rollback

**If entire system needs reverting**:

```bash
# Revert all card component commits
git log --oneline --grep="card"  # Find commit hashes
git revert <commit-hash-1> <commit-hash-2> ...

# OR reset to before Phase 2
git checkout <commit-before-phase-2>
git checkout -b rollback/card-consolidation
```

---

## Documentation Requirements

### Component README

**File**: `components/card/README.md`

```markdown
# Card Component

Universal card component with multiple variants.

## Usage

```php
aitsc_render_card([
    'variant' => 'solution',
    'title' => 'Card Title',
    'content' => 'Card description',
    'image' => 'https://example.com/image.jpg',
    'link' => '/permalink',
]);
```

## Variants

- `default`: Basic card
- `glass`: Glassmorphism style
- `solution`: Featured image card
- `blog`: Blog post card with metadata

## Parameters

See `card-base.php` for full parameter list.

## Examples

[Include screenshots or CodePen examples]
```

---

### Developer Guide

**File**: `docs/components/card.md`

[Include]:
- When to use each variant
- How to add new variants
- Customization options (CSS custom properties)
- Accessibility considerations

---

## Success Criteria

### Quantitative
- [ ] Card implementations reduced from 4 to 1 unified system
- [ ] Files using cards: 23+ files migrated
- [ ] CSS reduction: 200-300 lines removed from `style.css`
- [ ] No performance regression (Lighthouse score maintained)

### Qualitative
- [ ] All cards have consistent hover states
- [ ] Developers can add card with 5 lines of PHP
- [ ] New card variants can be added without touching templates
- [ ] Visual consistency across all pages

---

## Time Breakdown

**Hour 1-2**: Create component system
- Write `card-base.php`
- Write `card-variants.css`
- Write `card-animations.css`
- Register in `inc/components.php`

**Hour 3-4**: Migrate templates (batch 1)
- `archive-solutions.php`
- `taxonomy-solution_category.php`
- Test at all breakpoints

**Hour 5-6**: Migrate templates (batch 2)
- `front-page.php`
- `single-solutions.php`
- Test interactions

**Hour 7**: Cleanup & optimization
- Remove old card styles from `style.css`
- Optimize CSS (merge duplicate rules)
- Final testing

**Hour 8**: Documentation & review
- Write component README
- Update developer docs
- Create migration guide
- Code review

---

## Dependencies for Next Phases

### Phase 3: Grid System
- Cards will use grid utilities for layout
- Example: `<div class="grid grid-cols-3-desktop">` + cards inside

### Phase 5: Slider/Carousel
- Testimonial cards use card component
- Carousel will wrap cards, not duplicate styles

---

## Open Questions

1. **Backward Compatibility**: Support old class names temporarily?
   - **Option**: Add CSS aliases (`.glass-card` → `.card--glass`)
   - **Decision**: Clean break better long-term (aliases = tech debt)

2. **Card Link Behavior**: Whole card clickable or just CTA button?
   - **Current**: CTA button only
   - **Alternative**: Wrap entire card in `<a>` (accessibility concerns)
   - **Decision**: Keep CTA only, better for keyboard nav

3. **Image Aspect Ratios**: Enforce consistent ratios or auto-crop?
   - **Current**: Auto-crop with `object-fit: cover`
   - **Consideration**: Add aspect ratio variants (`.card--16x9`, `.card--1x1`)

---

**Phase Owner**: Development Team
**Reviewer**: Tech Lead + Designer
**Approval Required**: After visual regression tests pass
**Estimated Completion**: 2 days (8 working hours)
