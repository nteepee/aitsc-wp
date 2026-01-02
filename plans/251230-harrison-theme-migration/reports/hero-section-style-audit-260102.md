# Hero Section Style Audit Report
**Date**: 2026-01-02
**Status**: ⚠️ INCONSISTENT - Requires Standardization

---

## 📊 Summary Table

| Page | Implementation | Variant/Class | Height | Background | Theme Style |
|------|---------------|---------------|--------|------------|-------------|
| **Homepage** | `aitsc_render_hero()` | `white-fullwidth` | `large` (600px min) | Full-width image w/ overlay | ✅ Modern White Theme |
| **Solutions Archive** | `aitsc_render_hero()` | `page` | `medium` (450px min) | Gradient (#f5f7fa → white) | ⚠️ Old Blue Theme |
| **Case Studies Archive** | `aitsc_render_hero()` | `page` | `medium` (450px min) | Gradient (#f5f7fa → white) | ⚠️ Old Blue Theme |
| **Single Solution** | `aitsc_render_hero()` | `white-fullwidth` | `large` (600px min) | ACF dynamic image | ✅ Modern White Theme |
| **Single Case Study** | `aitsc_render_hero()` | `page` | `medium` (450px min) | Gradient (#f5f7fa → white) | ⚠️ Old Blue Theme |
| **About Us** | Custom HTML | `.page-hero.full-width` | `padding: 12rem 0 8rem` | Dark gradient + `hero-texture.jpg` | ❌ Legacy Dark Theme |
| **Contact** | Custom HTML | `.page-hero.full-width` | CSS-dependent (minimal) | Dark gradient `rgba(0,0,0,0.7-0.8)` | ❌ Legacy Dark Theme |
| **Passenger Monitoring** | Custom HTML | `.hero-section` | `padding: 200px 0 150px` | Dark background (global) | ❌ WorldQuant Dark Style |
| **Fleet Safe Pro** | Custom HTML | `.fleet-safe-hero` | `padding: 15vh 0 10vh`, `min-h: 100vh` | Dark + particles | ❌ Custom High-Impact Dark |

---

## 🔍 Detailed Analysis

### ✅ **Modern White Theme (Target Standard)**
**Files**: `front-page.php`, `single-solutions.php`

**Implementation**:
```php
aitsc_render_hero([
    'variant' => 'white-fullwidth',
    'title' => 'Custom Electronics & <span class="text-cyan">Safety</span> Engineering',
    'subtitle' => 'FROM CONCEPT TO DEPLOYMENT. AUTOMOTIVE GRADE.',
    'description' => '...',
    'cta_primary' => 'Explore Fleet Safe Pro',
    'cta_primary_link' => home_url('/solutions/fleet-safe-pro'),
    'cta_secondary' => 'Start Your Project',
    'cta_secondary_link' => home_url('/contact'),
    'height' => 'large'
]);
```

**Visual Characteristics**:
- Full-width hero with glassmorphism blur card overlay
- Large, fluid typography using `clamp()`
- 600px minimum height
- High-contrast white background with image overlay
- Dual CTAs (primary cyan, secondary outline)
- Modern Harrison.ai brand aesthetic

---

### ⚠️ **Old Blue Theme (Archive Pages)**
**Files**: `archive-solutions.php`, `archive-case-studies.php`, `single-case-studies.php`

**Implementation**:
```php
aitsc_render_hero([
    'variant' => 'page',
    'title' => '<span class="text-cyan-600">Solutions</span> Portfolio',
    'subtitle' => 'ENGINEERING EXCELLENCE ACROSS THE TRANSPORT SAFETY STACK',
    'description' => 'From embedded firmware to AI-powered fleet protection...',
    'height' => 'medium'
]);
```

**Visual Characteristics**:
- Gradient background: `linear-gradient(#f5f7fa, #ffffff)`
- Medium height (450px minimum)
- Centered text layout
- Uses older `text-cyan-600` class (Tailwind syntax)
- Subtitle in uppercase tracking-wide
- **Inconsistency**: Doesn't match modern white theme aesthetic

---

### ❌ **Legacy Dark Theme (Custom HTML)**

#### **About Us** (`page-about-aitsc.php`)
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

**Issues**:
- ❌ Manual inline styles (not maintainable)
- ❌ Dark background conflicts with white theme
- ❌ Fixed padding (`12rem`) doesn't scale responsively
- ❌ Uses old utility classes (`text-gray-300`, `max-w-4xl`)
- ❌ No component consistency

---

#### **Contact** (`page-contact.php`)
```html
<header class="page-hero full-width"
        style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8));">
    <div class="container">
        <?php the_title('<h1 class="aitsc-hero__title aitsc-hero__title--standard">', '</h1>'); ?>
    </div>
</header>
```

**Issues**:
- ❌ Minimal hero (title only, no subtitle/description/CTA)
- ❌ Dark gradient background
- ❌ No height control (CSS-dependent)
- ❌ Inconsistent with modern component structure

---

#### **Passenger Monitoring** (`taxonomy-solution_category-passenger-monitoring-systems.php`)
```html
<section class="scroll-section hero-section"
         style="padding-top: 200px; padding-bottom: 150px;">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10">
                <h1 class="aitsc-hero__title animate-title">
                    PASSENGER<br>MONITORING SYSTEMS
                </h1>
                <p class="aitsc-hero__subtitle animate-fade-in delay-1">
                    Real-Time Seat Belt Detection System
                </p>
                <p class="aitsc-hero__description mt-5 animate-fade-in delay-2"
                    style="max-width: 50rem; margin-left: auto; margin-right: auto;">
                    A safety solution designed for buses...
                </p>
            </div>
        </div>
    </div>
</section>
```

**Issues**:
- ❌ "WorldQuant" dark style (outdated)
- ❌ Fixed pixel padding (`200px`)
- ❌ Custom animations (`animate-title`, `delay-1`)
- ❌ Bootstrap grid (`row`, `col-lg-10`)
- ❌ Inline max-width styles
- ❌ Relies on global dark background template part

---

#### **Fleet Safe Pro** (`page-fleet-safe-pro.php`)
**Custom implementation with**:
- ❌ `min-height: 100vh`
- ❌ Particle.js background
- ❌ Data ticker component at bottom
- ❌ Viewport-based padding (`15vh 0 10vh`)
- ❌ Complex custom animations

---

## 🎯 Inconsistencies Summary

### Implementation Methods
| Method | Count | Files |
|--------|-------|-------|
| `aitsc_render_hero()` component | 5 | ✅ Preferred |
| Custom HTML | 4 | ❌ Legacy |

### Visual Themes
| Theme | Count | Status |
|-------|-------|--------|
| Modern White Theme | 2 | ✅ Target standard |
| Old Blue Theme | 3 | ⚠️ Needs migration |
| Legacy Dark Theme | 4 | ❌ Conflicts with brand |

### Height Settings
- `large` (600px min): 2 pages
- `medium` (450px min): 3 pages
- Fixed padding (`12rem`, `200px`, `15vh`): 3 pages
- CSS-dependent: 1 page

### Background Styles
- Full-width image w/ overlay: 2 pages
- Blue/grey gradient: 3 pages
- Dark gradient: 2 pages
- Dark texture + gradient: 1 page
- Custom particle.js: 1 page

---

## 🛠 Recommended Standardization

### Phase 1: Migrate Archive Pages to White Theme
**Files**: `archive-solutions.php`, `archive-case-studies.php`, `single-case-studies.php`

**Change**:
```php
// FROM:
'variant' => 'page',
'height' => 'medium'

// TO:
'variant' => 'white-fullwidth',
'height' => 'large'
```

---

### Phase 2: Convert Custom HTML to Components

#### **About Us** (`page-about-aitsc.php`)
```php
aitsc_render_hero([
    'variant' => 'white-fullwidth',
    'title' => 'Pioneering the Future of <span class="text-cyan">Fleet Safety</span> and Efficiency',
    'subtitle' => 'WHO WE ARE',
    'description' => 'AITS Consulting is dedicated to providing innovative solutions that protect your drivers, assets, and bottom line.',
    'height' => 'large'
]);
```

#### **Contact** (`page-contact.php`)
```php
aitsc_render_hero([
    'variant' => 'page',
    'title' => 'Get in <span class="text-cyan">Touch</span>',
    'subtitle' => 'START YOUR PROJECT',
    'description' => 'Ready to transform your fleet safety? Our team is here to help.',
    'height' => 'medium'
]);
```

---

### Phase 3: Specialized Pages Decision

**Passenger Monitoring & Fleet Safe Pro**: Two options:

1. **Option A**: Extend `aitsc_render_hero()` to support:
   - Dark variant (`variant => 'dark-fullwidth'`)
   - Particle background (`particles => true`)
   - Custom child components (`hero_footer => 'data-ticker'`)

2. **Option B**: Keep custom HTML but modernize:
   - Replace Bootstrap grid with semantic divs
   - Use CSS variables for spacing
   - Add reusable CSS classes instead of inline styles

---

## 📋 Next Steps

1. **Decide on standardization approach** (all white vs. variant support)
2. **Migrate archive pages first** (low risk, high visibility)
3. **Convert About/Contact** (medium priority)
4. **Handle specialized pages** (requires UX decision)

---

**Unresolved Questions:**
- Should all pages use `white-fullwidth` variant for brand consistency?
- Do specialized product pages need custom dark variants, or should they align with white theme?
- Should the `page` variant be deprecated entirely?
