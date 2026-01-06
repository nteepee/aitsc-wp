# Dependency Audit - AITSC Pro Theme

**Date:** 2026-01-06
**Backup:** pre-migration-20260106
**Theme:** aitsc-pro-theme (90 PHP files, 38MB)

---

## Theme Dependencies (from functions.php)

### Core Includes (12 files)

```php
1. inc/enqueue.php - Scripts/CSS loading
2. inc/theme-options.php - Theme settings
3. inc/customizer.php - Customizer registration
4. inc/customizer-callbacks.php - Customizer callbacks
5. customizer/panels/homepage-advanced.php - Homepage settings
6. inc/template-tags.php - Helper functions
7. inc/custom-post-types.php - CPT registration (Solutions, Case Studies)
8. inc/aitsc-content-data.php - Content seeder (dev only)
9. inc/components.php - Component shortcodes
10. inc/acf-fields.php - ACF field groups
11. inc/acf-solution-fields.php - Solution-specific ACF
12. inc/acf-seo-fields.php - SEO ACF fields
13. inc/paper-stack-config.php - Paper Stack animations
```

---

## Custom Post Types

### Solutions CPT
- **Slug:** solutions
- **Archive:** /solutions/
- **Taxonomy:** solution_category
- **ACF Fields:** 20+ fields
- **Templates:**
  - single-solutions.php
  - archive-solutions.php

### Case Studies CPT
- **Slug:** case-studies
- **Archive:** /case-studies/
- **ACF Fields:** 15+ fields
- **Templates:**
  - single-case-studies.php
  - archive-case-studies.php

---

## Taxonomies

### Solution Category
- **Hierarchical:** Yes
- **Templates:**
  - taxonomy-solution_category.php
  - taxonomy-solution_category-passenger-monitoring-systems.php (specific)

---

## Component Shortcodes (16 total)

1. **aitsc_card** - Card component
2. **aitsc_hero** - Hero section
3. **aitsc_cta** - Call to action
4. **aitsc_stats** - Stats counter
5. **aitsc_testimonials** - Testimonial carousel
6. **aitsc_trust_bar** - Trust badges
7. **aitsc_logo_carousel** - Logo slider
8. **aitsc_image_composition** - Image layout
9. **aitsc_steps** - Steps component
10. **aitsc_tabs** - Tabs component
11. **aitsc_gallery** - Gallery slider
12. **aitsc_problem_solution** - Problem/solution block
13. **aitsc_related_pages** - Related navigation
14. **paper_stack** - Scroll animations (preserve)
15. **contact_form** - AJAX contact form
16. **[various others]**

---

## ACF Field Groups

### Main Fields (inc/acf-fields.php)
- Global settings
- Page options
- Common fields

### Solution Fields (inc/acf-solution-fields.php)
- Solution-specific fields
- Features
- Specs
- Technical details

### SEO Fields (inc/acf-seo-fields.php)
- Meta titles
- Descriptions
- Open Graph

---

## Critical Dependencies

### Must Preserve (GP Migration)

**PHP Files:**
1. ✅ inc/custom-post-types.php - CPT registration
2. ✅ inc/acf-fields.php - All ACF fields (merged)
3. ✅ inc/acf-solution-fields.php - Merge into main
4. ✅ inc/acf-seo-fields.php - Merge into main
5. ✅ inc/components.php - All shortcodes
6. ✅ inc/paper-stack-config.php - Animations
7. ✅ inc/contact-ajax.php - AJAX handler
8. ✅ inc/template-tags.php - Helper functions

**Components:**
1. ✅ components/paper-stack/paper-stack.php - Unique feature

**Can Remove (Handled by GP):**
1. ❌ inc/enqueue.php - Simplify only
2. ❌ inc/theme-options.php - GP Customizer
3. ❌ inc/customizer.php - GP Customizer
4. ❌ inc/customizer-callbacks.php - GP Customizer
5. ❌ customizer/panels/* - All 8 files

---

## File Dependency Map

```
functions.php (root)
├─ inc/custom-post-types.php
│  ├─ single-solutions.php (depends on CPT)
│  └─ single-case-studies.php (depends on CPT)
│
├─ inc/acf-fields.php (merged from 3 files)
│  ├─ single-solutions.php (uses ACF)
│  ├─ single-case-studies.php (uses ACF)
│  └─ All CPT templates (use ACF)
│
├─ inc/components.php
│  └─ All templates (use shortcodes)
│
└─ inc/paper-stack-config.php
   └─ All pages (use animations)
```

---

## Migration Priority

### Phase 1: Core Foundation
1. functions.php - Simplify
2. inc/custom-post-types.php - Preserve
3. inc/acf-fields.php - Merge all 3 files

### Phase 2: Components
4. inc/components.php - Preserve
5. components/paper-stack/paper-stack.php - Preserve

### Phase 3: Templates
6. All 15 root templates → Replace with GP Elements
7. All 22 template parts → Replace with GB blocks

### Phase 4: Cleanup
8. Remove customizer files (8 files)
9. Remove dev-only files

---

## Backup Summary

**Backup Location:** /backups/pre-migration-20260106/

**Files Created:**
- ✅ aitsc-pro-theme.tar.gz (35MB, 260 files)
- ✅ file-inventory.csv (91 PHP files tracked)

**Verification:**
- [ ] Backup can be extracted
- [ ] All PHP files present
- [ ] No corruption

**Next:**
- Database backup
- Uploads backup
- Performance baseline
