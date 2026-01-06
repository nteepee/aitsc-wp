# Phase 00: GeneratePress Migration Overview

**Date:** 2026-01-06
**Parent Plan:** [plan.md](./plan.md)
**Priority:** CRITICAL (Client Requirement)
**Status:** PLANNING
**Review Status:** Pending Approval

---

## Context Links

**Dependencies:**
- Research: [brainstorm-260106-generatepress-technical-migration-plan.md](./reports/brainstorm-260106-generatepress-technical-migration-plan.md)
- Structure Comparison: [brainstorm-260106-structure-comparison.md](./reports/brainstorm-260106-structure-comparison.md)
- Executive Summary: [brainstorm-260106-executive-summary.md](./reports/brainstorm-260106-executive-summary.md)

**Documentation:**
- Current Theme: `/wp-content/themes/aitsc-pro-theme/`
- Target: `/wp-content/themes/aitsc-gp-child/`
- GP Docs: https://docs.generatepress.com

---

## Overview

**Description:** Migrate AITSC Pro Theme (90 PHP files, 38 MB) to GeneratePress Premium hybrid architecture (~35-40 PHP files, ~5 MB) while preserving 100% functionality.

**Key Metrics:**
- Files to process: 90 PHP files
- Files to preserve: 7 core files
- Files to replace: 83 files (templates → blocks)
- Code reduction: 58%
- Performance gain: 60%
- Timeline: 35 working days

**Phases Breakdown:**
1. Phase 01: Preparation & Backup (2 days)
2. Phase 02: GP Setup (2 days)
3. Phase 03: CPTs & ACF (3 days)
4. Phase 04: Components Migration (7 days)
5. Phase 05: Layouts Migration (4 days)
6. Phase 06: Styling & Design System (3 days)
7. Phase 07: Paper Stack Integration (1 day)
8. Phase 08: Testing & QA (3 days)
9. Phase 09: Documentation & Handoff (3 days)
10. Phase 10: Launch & Monitoring (2 days)

---

## File Inventory Tracking

### All Theme Files (90 Total)

**Root Templates (15):**
```
01. index.php → GP Default
02. single.php → Content Template
03. single-solutions.php → Content Template
04. single-case-studies.php → Content Template
05. page.php → GP Default
06. page-about-aitsc.php → Layout Element
07. page-contact.php → Layout Element
08. page-fleet-safe-pro.php → Layout Element
09. front-page.php → Block Element
10. archive-solutions.php → Loop Template
11. archive-case-studies.php → Loop Template
12. taxonomy-solution_category.php → Loop Template
13. taxonomy-solution_category-passenger-monitoring-systems.php → Loop Template
14. header.php → Header Element
15. footer.php → Footer Element
```

**Components (16):**
```
16. components/card/card-base.php → Shortcode + GB Pattern
17. components/hero/hero-universal.php → Content Template
18. components/hero/hero-solution-page.php → Content Template
19. components/cta/cta-block.php → GB Pattern
20. components/stats/stats-counter.php → GB Pro Block
21. components/testimonial/testimonial-carousel.php → GB Pro Carousel
22. components/trust-bar/trust-bar.php → GB Grid + Query
23. components/logo-carousel/logo-carousel.php → GB Pro Carousel
24. components/image-composition/image-composition.php → GB Container
25. components/steps/steps-block.php → GB Container
26. components/tabs/tabs-block.php → GB Pro Tabs
27. components/gallery/gallery-slider.php → GB Pro Carousel
28. components/problem-solution/problem-solution-block.php → GB Container
29. components/navigation/related-pages.php → GB Query Loop
30. components/paper-stack/paper-stack.php → PRESERVE
31. components/cta/form-placeholder.php → Remove
32. components/logo-carousel/logo-carousel.php → GB Pro
33. components/gallery/gallery-slider.php → GB Pro
34. components/testimonial/testimonial-carousel.php → GB Pro
35. components/trust-bar/trust-bar.php → GB Grid
```

**Includes (15):**
```
36. inc/enqueue.php → Simplify
37. inc/theme-options.php → GP Customizer
38. inc/customizer.php → GP Customizer
39. inc/customizer-callbacks.php → GP Customizer
40. inc/template-tags.php → PRESERVE (simplify)
41. inc/custom-post-types.php → PRESERVE
42. inc/aitsc-content-data.php → Remove (dev only)
43. inc/components.php → PRESERVE
44. inc/acf-fields.php → PRESERVE
45. inc/acf-solution-fields.php → Merge
46. inc/acf-seo-fields.php → Merge
47. inc/paper-stack-config.php → PRESERVE
48. inc/contact-ajax.php → PRESERVE
49. inc/content-seeder.php → Remove (dev only)
50. customizer/panels/colors.php → GP Customizer
51. customizer/panels/typography.php → GP Typography
52. customizer/panels/header.php → GP Customizer
53. customizer/panels/footer.php → GP Customizer
54. customizer/panels/layout.php → GP Layout Meta
55. customizer/panels/homepage.php → Block Element
56. customizer/panels/homepage-advanced.php → Block Element
57. customizer/panels/cpt.php → GP Layout Meta
```

**Template Parts (22):**
```
58. template-parts/content.php → GP Default
59. template-parts/content-none.php → GP Default
60. template-parts/content-solutions.php → Content Template
61. template-parts/content-solutions-enhanced.php → Content Template
62. template-parts/content-case-studies.php → Content Template
63. template-parts/content-case-studies-enhanced.php → Content Template
64. template-parts/single-solutions.php → Content Template
65. template-parts/single-case-studies.php → Content Template
66. template-parts/hero-advanced.php → Block Element
67. template-parts/hero-mobile-optimized.php → Block Element
68. template-parts/cta-advanced.php → GB Pattern
69. template-parts/testimonials.php → GB Pro Carousel
70. template-parts/stats-section.php → GB Pro
71. template-parts/navigation.php → GP Navigation
72. template-parts/global-background.php → GP Backgrounds
73. template-parts/contact-form-advanced.php → PRESERVE
74. template-parts/case-studies-preview.php → Query Loop
75. template-parts/solutions-showcase.php → Query Loop
76-89. template-parts/solution/* (14 files) → Block Element sections
90. template-parts/services-mobile-optimized.php → Block Element
91. template-parts/theme-toggle.php → Remove
```

**Assets (CSS/JS):**
```
92. style.css (79 KB) → Simplify to GP variables
93-94. assets/css/* → Simplify
95-96. assets/js/* → Keep only paper-stack
```

**Tests (1):**
```
97. tests/test-rate-limiting.php → Keep
```

---

## Requirements

### Functional Requirements
- [FR-01] All Custom Post Types must work (Solutions, Case Studies)
- [FR-02] All 90+ ACF fields must display correctly
- [FR-03] All 16 component shortcodes must work
- [FR-04] Paper Stack animations must function
- [FR-05] AJAX contact form must work
- [FR-06] All taxonomies must work
- [FR-07] Mobile navigation must work
- [FR-08] Responsive design must be maintained

### Non-Functional Requirements
- [NFR-01] PageSpeed Mobile: 80+ (current: 50-60)
- [NFR-02] PageSpeed Desktop: 95+ (current: 70-80)
- [NFR-03] Load time: <3s (current: 3-4s)
- [NFR-04] Zero data loss
- [FR-05] Client can edit content visually
- [NFR-06] Rollback time: <5 minutes

### Client Requirements
- [CR-01] Theme must be GeneratePress-based
- [CR-02] Performance improvement required
- [CR-03] Easier content management
- [CR-04] Future-proof architecture

---

## Architecture

### Current Architecture
```
aitsc-pro-theme/
├── 90 PHP files (100% custom)
├── 22 template files
├── 16 component PHP files
├── 22 template-part files
├── 15 include files
├── 8 customizer files
└── 38 MB total size
```

### Target Architecture
```
generatepress/ (parent theme - automatic updates)
├── Managed by GP team
├── Core functionality
└── Performance optimized

aitsc-gp-child/ (child theme - your code)
├── functions.php (simplified)
├── inc/
│   ├── custom-post-types.php (preserved)
│   ├── acf-fields.php (merged from 3 files)
│   ├── components.php (preserved)
│   ├── paper-stack.php (preserved)
│   ├── contact-ajax.php (preserved)
│   └── template-tags.php (simplified)
├── components/paper-stack/ (preserved)
├── assets/js/paper-stack-fallback.js (preserved)
└── style.css (minimal - variables only)
```

---

## Related Code Files

### Files to Read & Understand
1. `/wp-content/themes/aitsc-pro-theme/functions.php` - All dependencies
2. `/wp-content/themes/aitsc-pro-theme/inc/custom-post-types.php` - CPT logic
3. `/wp-content/themes/aitsc-pro-theme/inc/acf-fields.php` - Field groups
4. `/wp-content/themes/aitsc-pro-theme/inc/components.php` - Shortcodes
5. `/wp-content/themes/aitsc-pro-theme/inc/paper-stack-config.php` - Animations

### Files to Create
1. `/wp-content/themes/aitsc-gp-child/style.css` - Child theme header
2. `/wp-content/themes/aitsc-gp-child/functions.php` - Simplified
3. `/wp-content/themes/aitsc-gp-child/inc/*.php` - Preserved functionality

---

## Implementation Steps

**Step 1:** Review all research reports
**Step 2:** Approve master plan
**Step 3:** Execute Phase 01 (Preparation)
**Step 4:** Execute remaining phases sequentially
**Step 5:** Testing & validation
**Step 6:** Launch

**See detailed phase files for specific steps.**

---

## Todo List

- [ ] Review research reports
- [ ] Approve master migration plan
- [ ] Set up staging environment
- [ ] Complete Phase 01: Preparation
- [ ] Complete Phase 02: GP Setup
- [ ] Complete Phase 03: CPTs & ACF
- [ ] Complete Phase 04: Components
- [ ] Complete Phase 05: Layouts
- [ ] Complete Phase 06: Styling
- [ ] Complete Phase 07: Paper Stack
- [ ] Complete Phase 08: Testing
- [ ] Complete Phase 09: Documentation
- [ ] Complete Phase 10: Launch

---

## Success Criteria

### Phase Success
- [ ] All phases completed in order
- [ ] Each phase validated before next
- [ ] No skipped steps
- [ ] Full documentation maintained

### Project Success
- [ ] All 90 files processed correctly
- [ ] All functional requirements met
- [ ] Performance targets achieved
- [ ] Client trained and satisfied
- [ ] Zero data loss
- [ ] Rollback tested

---

## Risk Assessment

### High Risk
- [R-01] CPT templates not displaying → **Mitigation:** Create Content/Loop Templates first, test thoroughly
- [R-02] ACF fields not working → **Mitigation:** Verify field names, test each type
- [R-03] Paper Stack breaks → **Mitigation:** Keep as-is, no changes to code

### Medium Risk
- [R-04] Shortcode conflicts → **Mitigation:** Preserve all functions
- [R-05] Styling issues → **Mitigation:** Use browser dev tools, test thoroughly
- [R-06] Timeline overrun → **Mitigation:** Buffer time included, prioritize critical path

### Low Risk
- [R-07] Performance regression → **Mitigation:** Benchmark before/after, use caching
- [R-08] Browser compatibility → **Mitigation:** Test all major browsers

---

## Security Considerations

- [ ] Backup full site before starting
- [ ] Work on staging environment
- [ ] Test rollback procedure
- [ ] No production changes until approved
- [ ] Verify all PHP security
- [ ] Check ACF field access controls
- [ ] Validate AJAX handlers
- [ ] Review file permissions

---

## Next Steps

**Immediate Actions:**
1. Review this phase overview
2. Read [Phase 01: Preparation](./phase-01-preparation-backup.md)
3. Approve or request revisions
4. Set up staging environment
5. Begin Phase 01

**Dependencies:**
- Staging site required
- GP Premium license required
- GB Pro license required
- Backup solution verified
- Team availability confirmed

---

**Status:** Ready for phase-by-phase execution
**Next Phase:** [Phase 01: Preparation & Backup](./phase-01-preparation-backup.md)
