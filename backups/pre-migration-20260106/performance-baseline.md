# Performance Baseline - AITSC Pro Theme

**Date:** 2026-01-06
**Environment:** Local MAMP
**Status:** Pre-Migration

---

## Theme Metrics

### File Statistics
```
Theme: aitsc-pro-theme
Location: /wp-content/themes/aitsc-pro-theme/
Size: 38 MB
PHP Files: 90
CSS Files: 19
JS Files: 9
```

### Core File Sizes
```
style.css:          4,318 lines (79 KB)
functions.php:         473 lines (18 KB)
Total PHP Lines:     ~15,000 lines
Total CSS Lines:      ~2,000 lines
```

### Backup Created
```
aitsc-pro-theme.tar.gz: 35 MB
Files in backup:         260 files
Date:                   2026-01-06
Location:               /backups/pre-migration-20260106/
```

---

## Template Inventory

### Root Templates (15 files)
- index.php
- single.php
- single-solutions.php
- single-case-studies.php
- page.php
- page-about-aitsc.php
- page-contact.php
- page-fleet-safe-pro.php
- front-page.php
- archive-solutions.php
- archive-case-studies.php
- taxonomy-solution_category.php
- taxonomy-solution_category-passenger-monitoring-systems.php
- header.php
- footer.php

### Components (16 files)
- card/card-base.php
- hero/hero-universal.php
- hero/hero-solution-page.php
- cta/cta-block.php
- stats/stats-counter.php
- testimonial/testimonial-carousel.php
- trust-bar/trust-bar.php
- logo-carousel/logo-carousel.php
- image-composition/image-composition.php
- steps/steps-block.php
- tabs/tabs-block.php
- gallery/gallery-slider.php
- problem-solution/problem-solution-block.php
- navigation/related-pages.php
- paper-stack/paper-stack.php
- [1 more]

### Includes (15 files)
- enqueue.php
- theme-options.php
- customizer.php
- customizer-callbacks.php
- template-tags.php
- custom-post-types.php
- aitsc-content-data.php
- components.php
- acf-fields.php
- acf-solution-fields.php
- acf-seo-fields.php
- paper-stack-config.php
- contact-ajax.php
- content-seeder.php

### Customizer Panels (8 files)
- colors.php
- typography.php
- header.php
- footer.php
- layout.php
- homepage.php
- homepage-advanced.php
- cpt.php

### Template Parts (22 files)
- content.php
- content-none.php
- content-solutions.php
- content-solutions-enhanced.php
- content-case-studies.php
- content-case-studies-enhanced.php
- single-solutions.php
- single-case-studies.php
- hero-advanced.php
- hero-mobile-optimized.php
- cta-advanced.php
- testimonials.php
- stats-section.php
- navigation.php
- global-background.php
- contact-form-advanced.php
- case-studies-preview.php
- solutions-showcase.php
- solution/* (14 files)
- services-mobile-optimized.php
- theme-toggle.php

---

## Custom Post Types

### Solutions CPT
- **Registered:** Yes
- **Public:** Yes
- **Has Archive:** Yes
- **Slug:** solutions
- **Taxonomy:** solution_category
- **Supports:** Title, Editor, Thumbnail, Excerpt, Custom Fields
- **Template:** single-solutions.php

### Case Studies CPT
- **Registered:** Yes
- **Public:** Yes
- **Has Archive:** Yes
- **Slug:** case-studies
- **Supports:** Title, Editor, Thumbnail, Excerpt, Custom Fields
- **Template:** single-case-studies.php

---

## ACF Field Groups

### Field Group Files
1. **acf-fields.php** - Main fields
2. **acf-solution-fields.php** - Solution-specific
3. **acf-seo-fields.php** - SEO fields

**Total Estimated ACF Fields:** 90+

---

## Component Shortcodes

**16 shortcodes registered**
- All via inc/components.php
- Used throughout templates
- Must preserve functionality

---

## Navigation Menus

**Registered Locations:**
1. Primary Menu
2. Footer Menu
3. Mobile Menu

---

## Theme Features

### Supported Features
- Custom logo
- Automatic feed links
- Title tag
- Post thumbnails
- HTML5 support
- Customizer selective refresh
- Responsive embeds
- Align-wide support
- Editor styles

### Custom Features
- Paper Stack scroll animations
- AJAX contact form
- Content seeder (dev)
- 16 component shortcodes
- Advanced customizer panels

---

## Dependencies Summary

### PHP Dependencies (12 files)
See [dependency-audit.md](./dependency-audit.md)

### Plugin Dependencies
- **ACF Pro:** Required for full functionality
- **WP:** WordPress 5.0+
- **PHP:** 7.4+ recommended

---

## Pre-Migration Status

### ✅ Complete
- [x] File inventory created (91 PHP files)
- [x] Theme backup created (35MB, 260 files)
- [x] Dependency audit documented

### 🔄 Pending
- [ ] Database backup
- [ ] Uploads backup
- [ ] Performance testing (PageSpeed)
- [ ] Screenshot inventory

---

## Migration Targets

### After GeneratePress Migration

**Expected Metrics:**
- PHP Files: 90 → ~35-40 files (-56%)
- Theme Size: 38MB → ~5MB (-87%)
- CSS Lines: 2,000 → ~750 (-63%)
- functions.php: 473 → ~150 lines (-68%)

**Performance Goals:**
- PageSpeed Mobile: 50-60 → 80-90 (+60%)
- PageSpeed Desktop: 70-80 → 95-100 (+25%)
- Load Time: 3-4s → 2-2.5s (-40%)

---

## Notes

**Unique Features to Preserve:**
- Paper Stack scroll animations (CSS Scroll-Driven Animations API)
- Component system architecture
- AJAX contact form with validation
- Advanced customizer integration

**Files to Monitor Closely:**
- single-solutions.php (complex CPT template)
- page-fleet-safe-pro.php (complex page, 1350 lines)
- components/paper-stack/paper-stack.php (unique animations)

---

**Baseline Complete:** 2026-01-06
**Next Phase:** GP Setup (Phase 02)
