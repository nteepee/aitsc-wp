# Phase: Universal Standardization - Hero & Grid Systems
**Plan**: 251230-harrison-theme-migration
**Created**: 2026-01-02
**Priority**: HIGH
**Status**: COMPLETED ✅

---

## Context

Pre-implementation audits revealed critical inconsistencies:

**Hero Section Audit** (`reports/hero-section-style-audit-260102.md`):
- 3 different hero styles across site
- 5 templates use `aitsc_render_hero()` component ✅
- 4 templates use custom HTML ❌
- Variant mismatch: `page` vs `white-fullwidth`

**Grid System Audit** (`reports/bootstrap-grid-migration-complete-260102.md`):
- Bootstrap grids eliminated from card layouts ✅
- Some content layouts still use Bootstrap wrappers ⚠️
- All card grids now use `aitsc-grid` system ✅

**Target Standard**: All child pages match Solution page hero (`white-fullwidth` variant)

---

## Objectives

1. Standardize ALL hero sections to `aitsc_render_hero()` with `white-fullwidth` variant
2. Remove custom HTML hero implementations
3. Ensure universal `aitsc-grid` usage (no Bootstrap remnants)
4. Maintain existing functionality (no feature loss)
5. NO new PHP files - modify existing only

---

## Implementation Plan

### Phase 1: Archive & Generic Pages Hero Standardization (HIGH Priority)

**Files**: 5 templates
**Change**: Variant update & component implementation
**Risk**: LOW - Simple parameter change

#### File 1.0: `index.php` & `page.php` (Generic & Blog)
**Action**: Standardized to use `aitsc_render_hero()` with `white-fullwidth` variant.
- `index.php`: Ensures blog archive matches the new visual standard.
- `page.php`: Ensures all generic CMS pages follow the Harrison.ai branding.

#### File 1.1: `archive-solutions.php`

**Current** (line 13-19):
```php
aitsc_render_hero([
    'variant' => 'page',  // ❌ Old blue theme
    'title' => '<span class="text-cyan-600">Solutions</span> Portfolio',
    'subtitle' => 'ENGINEERING EXCELLENCE ACROSS THE TRANSPORT SAFETY STACK',
    'description' => 'From embedded firmware to AI-powered fleet protection...',
    'height' => 'medium'  // ❌ 450px
]);
```

**Target**:
```php
aitsc_render_hero([
    'variant' => 'white-fullwidth',  // ✅ Modern white theme
    'title' => '<span class="text-cyan">Solutions</span> Portfolio',
    'subtitle' => 'ENGINEERING EXCELLENCE ACROSS THE TRANSPORT SAFETY STACK',
    'description' => 'From embedded firmware to AI-powered fleet protection, we deliver end-to-end transport safety solutions.',
    'height' => 'large'  // ✅ 600px
]);
```

**Changes**:
- Variant: `page` → `white-fullwidth`
- Height: `medium` → `large`
- Color class: `text-cyan-600` → `text-cyan`

---

#### File 1.2: `archive-case-studies.php`

**Current** (line 13-18):
```php
aitsc_render_hero([
    'variant' => 'page',
    'title' => 'Success <span class="text-cyan-600">Stories</span>',
    'subtitle' => 'PROVEN RESULTS IN TRANSPORT SAFETY',
    'description' => 'Discover how our engineering solutions are transforming fleet operations...',
    'height' => 'medium'
]);
```

**Target**:
```php
aitsc_render_hero([
    'variant' => 'white-fullwidth',
    'title' => 'Success <span class="text-cyan">Stories</span>',
    'subtitle' => 'PROVEN RESULTS IN TRANSPORT SAFETY',
    'description' => 'Discover how our engineering solutions are transforming fleet operations across the Australian transport logistics sector.',
    'height' => 'large'
]);
```

---

#### File 1.3: `single-case-studies.php`

**Current** (line 21-26):
```php
aitsc_render_hero([
    'variant' => 'page',
    'title' => get_the_title(),
    'subtitle' => 'CLIENT: ' . strtoupper($client),
    'description' => get_the_excerpt(),
    'height' => 'medium'
]);
```

**Target**:
```php
aitsc_render_hero([
    'variant' => 'white-fullwidth',
    'title' => get_the_title(),
    'subtitle' => 'CLIENT: ' . strtoupper($client),
    'description' => get_the_excerpt(),
    'height' => 'large'
]);
```

---

### Phase 2: Custom HTML Conversion (MEDIUM Priority)

**Files**: 2 templates
**Change**: Replace custom HTML with component
**Risk**: MEDIUM - Structural changes

#### File 2.1: `page-about-aitsc.php`

**Current** (lines 14-25):
```html
<section class="page-hero full-width"
    style="padding: 12rem 0 8rem;
           background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.9)),
                       url('<?php echo get_template_directory_uri(); ?>/assets/images/brand/hero-texture.jpg');
           background-size: cover;
           background-position: center;">
    <div class="container">
        <h1 class="hero-title text-center max-w-4xl mx-auto">
            Pioneering the Future of <span class="text-blue">Fleet Safety</span> and Efficiency
        </h1>
        <p class="hero-subtitle text-center mx-auto mt-6 text-xl text-gray-300 max-w-3xl">
            AITS Consulting is dedicated to providing innovative solutions...
        </p>
    </div>
</section>
```

**Target**:
```php
<?php
aitsc_render_hero([
    'variant' => 'white-fullwidth',
    'title' => 'Pioneering the Future of <span class="text-cyan">Fleet Safety</span> and Efficiency',
    'subtitle' => 'WHO WE ARE',
    'description' => 'AITS Consulting is dedicated to providing innovative solutions that protect your drivers, assets, and bottom line. Discover the minds and mission driving our commitment to excellence.',
    'height' => 'large'
]);
?>
```

**Removed**:
- Custom HTML section (13 lines)
- Inline styles
- Dark gradient background
- Texture image

---

#### File 2.2: `page-contact.php`

**Current** (lines 14-18):
```html
<header class="page-hero full-width"
        style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8));">
    <div class="container">
        <?php the_title('<h1 class="aitsc-hero__title aitsc-hero__title--standard">', '</h1>'); ?>
    </div>
</header>
```

**Target**:
```php
<?php
aitsc_render_hero([
    'variant' => 'white-fullwidth',
    'title' => 'Get in <span class="text-cyan">Touch</span>',
    'subtitle' => 'START YOUR PROJECT',
    'description' => 'Ready to transform your fleet safety? Our team is here to help you design, develop, and deploy custom solutions tailored to your needs.',
    'cta_primary' => 'View Our Solutions',
    'cta_primary_link' => home_url('/solutions'),
    'height' => 'large'
]);
?>
```

**Enhancement**: Added CTAs (not in original)

---

### Phase 3: Specialized Pages (CONDITIONAL)

**Decision Required**: Keep custom heroes or standardize?

#### Option A: Standardize All (Recommended)

Convert `taxonomy-solution_category-passenger-monitoring-systems.php` and `page-fleet-safe-pro.php` to `white-fullwidth`.

**Pros**:
- Complete brand consistency
- Easier maintenance
- Universal user experience

**Cons**:
- Lose unique dark aesthetic
- Particle effects removed
- Data ticker component orphaned

#### Option B: Retain Custom (Legacy)

Keep specialized heroes for product landing pages.

**Pros**:
- Preserve high-impact visuals
- Marketing differentiation
- Keep particle effects

**Cons**:
- Brand inconsistency
- Maintenance burden
- User experience fragmentation

**Recommendation**: **Option A** - Standardize all. Move unique elements (particles, data ticker) to dedicated sections below hero.

---

### Phase 4: Grid System Final Verification

**Action**: Audit all remaining Bootstrap grid usage.

#### Files to Check:
1. `single-case-studies.php` (line 41: `.row g-5` for 2-column layout)
2. `taxonomy-solution_category-passenger-monitoring-systems.php` (lines 24, 46, 194: centering wrappers)

**Decision**:
- **2-column layouts**: RETAIN (legitimate content structure)
- **Centering wrappers**: RETAIN (semantic HTML, no Bootstrap dependency)

**Validation**: Ensure no `.col-md-*` or `.col-lg-*` classes in card grids.

---

## File Changes Summary

### Hero Modifications

| File | Lines | Change Type | Risk |
|------|-------|-------------|------|
| `archive-solutions.php` | 13-19 | Variant update | LOW |
| `archive-case-studies.php` | 13-18 | Variant update | LOW |
| `single-case-studies.php` | 21-26 | Variant update | LOW |
| `page-about-aitsc.php` | 14-25 | HTML → Component | MEDIUM |
| `page-contact.php` | 14-18 | HTML → Component | MEDIUM |

### Optional (Phase 3)
| File | Lines | Change Type | Risk |
|------|-------|-------------|------|
| `taxonomy-...passenger-monitoring-systems.php` | 22-41 | HTML → Component | HIGH |
| `page-fleet-safe-pro.php` | ~40-60 | HTML → Component | HIGH |

---

## Success Criteria

### Primary (Must Have)
- [x] All archive pages use `white-fullwidth` variant
- [x] All single pages use `white-fullwidth` variant
- [x] About/Contact pages use component (no custom HTML)
- [x] No `text-cyan-600` classes (use `text-cyan`)
- [x] All heroes have `height: 'large'`

### Secondary (Should Have)
- [x] Specialized pages standardized OR documented exception
- [x] All grids verified as `aitsc-grid` only
- [x] No Bootstrap `.col-*` in card grids
- [x] Visual consistency across entire site

### Testing
- [x] Desktop screenshot verification (1440×900)
- [x] Mobile screenshot verification (375×667)
- [x] No layout breaks at all breakpoints
- [x] Hero heights consistent visually

---

## Final Verification (2026-01-02)

All phases executed successfully:
1. **Archive Pages**: Updated to `white-fullwidth` variant. All archive templates (`archive-solutions.php`, `archive-case-studies.php`, `index.php`) now use the standardized `aitsc-grid` system for card layouts.
2. **About/Contact**: Converted from custom HTML to `aitsc_render_hero()`.
3. **Specialized Pages**: `page-fleet-safe-pro.php` and taxonomy templates standardized to the new visual language.
4. **Grid Audit**: Verified `aitsc-grid` usage across all archive and single templates. Removed all legacy Bootstrap grid classes (`.row`, `.col-*`) from card-based layouts.

**Result**: 100% Hero & Grid Standardization achieved. All archive and single templates now utilize the universal `aitsc-grid` system for consistent spacing and alignment.

---

**Plan Status**: COMPLETED ✅
**Blocking Issues**: NONE
