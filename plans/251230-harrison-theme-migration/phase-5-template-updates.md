# Phase 5: Template Migration

**Status**: Not Started
**Priority**: Medium
**Dependencies**: Phases 1-4

---

## Context

Update 80 PHP template files to use white theme variants and new components. Focus on high-impact pages first, then systematic migration.

---

## Template Inventory

### Core Templates (8 files) - Priority: Critical

| File | Current State | Changes |
|------|---------------|---------|
| `front-page.php` | Dark hero, dark cards | White hero, white-feature cards |
| `header.php` | Dark glassmorphism | White nav (Phase 4) |
| `footer.php` | Dark background | White/light footer |
| `index.php` | Dark post list | White card layout |
| `page.php` | Dark page layout | White page layout |
| `single.php` | Dark article | White article |
| `archive.php` | Dark grid | White grid |
| `sidebar.php` | Dark widgets | White widgets |

### Custom Post Type Templates (6 files) - Priority: High

| File | Changes |
|------|---------|
| `single-solutions.php` | White hero, white-feature cards |
| `archive-solutions.php` | White grid layout |
| `single-case-studies.php` | White article layout |
| `archive-case-studies.php` | White grid layout |
| `taxonomy-solution_category.php` | White grid layout |
| `taxonomy-*.php` | White grid layout |

### Component Templates (16 files) - Priority: High

| Directory | Files | Changes |
|-----------|-------|---------|
| `components/card/` | card-base.php | Add white variants |
| `components/hero/` | hero-universal.php | Add white variants |
| `components/cta/` | cta-block.php | White CTA styles |
| `components/stats/` | stats-counter.php | White/inline variants |
| `components/testimonial/` | testimonial-carousel.php | White variant |

### Template Parts (20+ files) - Priority: Medium

| Directory | Key Files | Changes |
|-----------|-----------|---------|
| `template-parts/` | content.php | White card output |
| | content-solutions.php | White-feature cards |
| | content-case-studies.php | White cards |
| | hero-advanced.php | White hero |
| | solutions-showcase.php | White grid |
| | case-studies-preview.php | White layout |
| | cta-advanced.php | White CTA |
| | testimonials.php | White testimonials |
| | stats-section.php | White stats |

### Page Templates (10 files) - Priority: Medium

| File | Changes |
|------|---------|
| `page-about.php` | White layout |
| `page-contact.php` | White form |
| `page-fleet-safe-pro.php` | White product page |
| etc. | Systematic updates |

### Customizer & Include Files (20+ files) - Priority: Low

| Directory | Changes |
|-----------|---------|
| `customizer/panels/` | Update color defaults |
| `inc/` | Update function outputs |

---

## Implementation Strategy

### Phase 5.1: Core Templates

**front-page.php Migration**:

```php
<!-- BEFORE: Dark hero -->
<section class="scroll-section hero-slide" id="hero">
    <div class="hero-center-content text-center">
        <h1 class="wq-hero-title">...</h1>

<!-- AFTER: White fullwidth hero -->
<?php
aitsc_render_hero([
    'variant' => 'white-fullwidth',
    'title' => 'Custom Electronics & Safety Engineering',
    'subtitle' => 'From Concept to Deployment. Automotive Grade.',
    'cta_primary' => 'Explore Fleet Safe Pro',
    'cta_primary_link' => home_url('/solutions/fleet-safe-pro'),
    'cta_secondary' => 'Start Your Project',
    'cta_secondary_link' => home_url('/contact'),
    'image' => get_template_directory_uri() . '/assets/images/hero-bg.jpg',
    'height' => 'large'
]);
?>
```

**Card Grid Migration**:

```php
<!-- BEFORE: Solution variant (dark) -->
<?php
aitsc_render_card([
    'variant' => 'solution',
    'title' => 'Passenger Monitoring',
    ...
]);
?>

<!-- AFTER: White-feature variant -->
<?php
aitsc_render_card([
    'variant' => 'white-feature',
    'title' => 'Passenger Monitoring',
    'image' => get_template_directory_uri() . '/assets/images/pms.jpg',
    'icon' => 'airline_seat_recline_normal',
    ...
]);
?>
```

### Phase 5.2: Add New Components

**Trust Bar + Logo Carousel on Homepage**:

```php
<!-- After hero section -->
<?php
aitsc_render_trust_bar([
    'text' => 'Trusted by leading transport and safety organizations across Australia',
    'variant' => 'default',
    'bg' => 'light'
]);

$partner_logos = [
    ['src' => '...', 'alt' => 'Partner 1'],
    ['src' => '...', 'alt' => 'Partner 2'],
    // ...
];

aitsc_render_logo_carousel([
    'logos' => $partner_logos,
    'speed' => 30,
    'grayscale' => true
]);
?>
```

**Mission Section with Image Composition**:

```php
<section class="mission-section">
    <div class="container">
        <div class="mission-grid">
            <div class="mission-images">
                <?php
                aitsc_render_image_composition([
                    'images' => [
                        ['src' => '...', 'position' => 'top-left', 'size' => 'large'],
                        ['src' => '...', 'position' => 'bottom-right', 'size' => 'medium'],
                    ],
                    'layout' => 'stacked',
                    'animate' => true
                ]);
                ?>
            </div>
            <div class="mission-content">
                <h2>On a mission to improve transport safety</h2>
                <p>With over <strong>3,500</strong> vehicles equipped...</p>
            </div>
        </div>
    </div>
</section>
```

### Phase 5.3: Systematic Template Updates

**Search and Replace Patterns**:

```php
// Find and update all variant='solution' to variant='white-feature'
// Find and update all variant='glass' to variant='solid' (or keep for specific uses)

// Replace dark inline styles
// style="background: #000" -> Remove or use classes
// style="color: #fff" -> Remove or use classes

// Update class names
// 'wq-' prefix -> 'aitsc-' prefix where applicable
// 'glass-panel' -> 'aitsc-card--solid' or white variants
```

### Phase 5.4: Footer Update

**footer.php Migration**:

```php
<!-- BEFORE: Dark footer -->
<footer class="site-footer" style="background: #000;">

<!-- AFTER: White footer -->
<footer class="site-footer">
    <div class="site-footer__container">
        <div class="site-footer__grid">
            <div class="site-footer__brand">
                <!-- Logo and tagline -->
            </div>
            <div class="site-footer__links">
                <!-- Navigation links -->
            </div>
            <div class="site-footer__contact">
                <!-- Contact info -->
            </div>
        </div>
        <div class="site-footer__bottom">
            <p>&copy; <?php echo date('Y'); ?> AITSC. All rights reserved.</p>
        </div>
    </div>
</footer>
```

**Footer CSS**:

```css
.site-footer {
    background: var(--aitsc-bg-secondary);
    border-top: 1px solid var(--aitsc-border);
    padding: 4rem 0 2rem;
}

.site-footer__container {
    max-width: var(--aitsc-container-width);
    margin: 0 auto;
    padding: 0 1.5rem;
}

.site-footer__grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 2rem;
    margin-bottom: 3rem;
}

.site-footer__bottom {
    padding-top: 2rem;
    border-top: 1px solid var(--aitsc-border);
    text-align: center;
    color: var(--aitsc-text-muted);
    font-size: 0.875rem;
}

@media (max-width: 47.9375rem) {
    .site-footer__grid {
        grid-template-columns: 1fr;
    }
}
```

---

## Files Requiring Updates (Prioritized)

### Batch 1: Core (Day 1)
- [ ] front-page.php
- [ ] footer.php
- [ ] page.php
- [ ] index.php

### Batch 2: CPT Singles (Day 2)
- [ ] single-solutions.php
- [ ] single-case-studies.php
- [ ] template-parts/single-solutions.php
- [ ] template-parts/single-case-studies.php

### Batch 3: Archives (Day 3)
- [ ] archive-solutions.php
- [ ] archive-case-studies.php
- [ ] taxonomy-solution_category.php

### Batch 4: Template Parts (Day 4)
- [ ] template-parts/content.php
- [ ] template-parts/content-solutions.php
- [ ] template-parts/content-case-studies.php
- [ ] template-parts/hero-advanced.php
- [ ] template-parts/solutions-showcase.php
- [ ] template-parts/cta-advanced.php

### Batch 5: Solution Subpages (Day 5)
- [ ] template-parts/solution/*.php (14 files)

### Batch 6: Remaining Pages (Day 6)
- [ ] page-about.php
- [ ] page-contact.php
- [ ] page-fleet-safe-pro.php
- [ ] Customizer files

---

## Todo List

- [ ] Backup all template files
- [ ] Migrate front-page.php to white theme
- [ ] Update footer.php to white theme
- [ ] Migrate single-solutions.php
- [ ] Migrate archive-solutions.php
- [ ] Update all content-*.php template parts
- [ ] Add trust bar to homepage
- [ ] Add logo carousel to homepage
- [ ] Migrate solution subpage templates
- [ ] Update customizer color defaults
- [ ] Remove all inline dark styles
- [ ] Replace wq-* classes with aitsc-* where needed
- [ ] Full site visual QA

---

## Success Criteria

1. All pages render with white theme
2. No dark background remnants
3. All components use white variants
4. New components (trust bar, logo carousel) functional
5. Responsive across all breakpoints
6. No PHP errors or warnings
7. Performance maintained (Lighthouse > 85)
