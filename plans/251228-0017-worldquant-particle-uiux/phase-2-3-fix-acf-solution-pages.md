# Phase 2 & 3 Fix: ACF-Based Solution Landing Pages
**Plan ID**: 251228-0017-worldquant-particle-uiux (Phase 2/3 Remediation)
**Created**: 2025-12-28 14:30
**Status**: Ready for Implementation
**Estimated Effort**: 24 hours (Phase 2 rebuild + Phase 3 integration)

---

## Executive Summary

Current implementation has critical architectural flaw: all solution pages display identical hardcoded Fleet Safe Pro content instead of dynamic solution-specific pages.

**Solution**: Rebuild Phase 2 using ACF Flexible Content fields to create proper landing page architecture where each solution (Custom PCB Design, Embedded Systems, Sensor Integration, Automotive Electronics) gets its own dedicated page template powered by dynamic ACF content.

**Scope**:
- 4 solution post types with unique content
- ACF Flexible Content builder for flexible section layouts
- WorldQuant particle system integration on all pages
- Dynamic hero sections, features, specs, galleries
- Reusable component library (Phase 2 deliverable)
- Phase 3 integration: Fleet Safe Pro manual content → product-specific pages

---

## Current State Analysis

### What's Broken
```
❌ single-solutions.php: Hardcoded Fleet Safe Pro content
   - All 4 solutions use identical template
   - No dynamic content swapping
   - Title only is dynamic; everything else hardcoded (150+ lines)

❌ No ACF field groups configured
❌ No flexible content sections
❌ No component library (despite Phase 2 plan)
❌ Content system completely bypassed
```

### What's Good
- ✅ Phase 3 extracted 516 lines of Fleet Safe Pro manual text
- ✅ 62 product images extracted from PDF
- ✅ 58 product photos in gallery folder
- ✅ Particle system working (70 particles, correct colors)
- ✅ Base navigation structure functional
- ✅ Card component code written (but not used)

### Impact
- Users see wrong product on solution pages
- Cannot scale to more solutions without code changes
- Phase 3 content extraction wasted (no integration point)
- Brand dilution: solutions presented as single product

---

## Architecture Design

### 1. Post Type Structure

```php
// 4 Solution Post Types (existing, but need content strategy)
register_post_type('solutions', [
    'labels' => ['name' => 'Solutions'],
    'public' => true,
    'supports' => ['title', 'editor', 'thumbnail']
]);

// Solution Posts Required:
// 1. Custom PCB Design (post_name: custom-pcb-design)
// 2. Embedded Systems (post_name: embedded-systems)
// 3. Sensor Integration (post_name: sensor-integration)
// 4. Automotive Electronics (post_name: automotive-electronics)
```

### 2. ACF Field Group Structure

**Field Group**: "Solution Page Content"
**Applied to**: Post Type = Solutions
**Fields**:

```
├── Hero Section (Group)
│   ├── hero_title (Text) - "Custom PCB Design & Development"
│   ├── hero_subtitle (Textarea) - "From Concept to Production..."
│   ├── hero_image (Image) - Product/service hero image
│   └── hero_cta_text (Text) - Button text, default: "Get Started"
│
├── Solution Overview (WYSIWYG Editor)
│   └── overview_content - Rich text description of solution
│
├── Key Features (Repeater)
│   ├── feature_icon (Text) - Material icon name
│   ├── feature_title (Text) - "Rapid Prototyping"
│   └── feature_description (Textarea)
│
├── Technical Specifications (Group)
│   ├── specs_content (WYSIWYG) - HTML table or formatted specs
│   └── specs_pdf_link (File) - Optional: PDF download
│
├── Solution Gallery (Gallery)
│   └── gallery_images (Image Array) - Product photos
│
├── Solution Sections (Flexible Content)
│   ├── Layout: Text + Image (Left/Right toggle)
│   ├── Layout: Full-Width Video
│   ├── Layout: 3-Column Features
│   ├── Layout: Testimonials
│   └── Layout: Process Steps
│
├── Case Studies (Relationship)
│   └── Related case_studies posts
│
├── Call-to-Action (Group)
│   ├── cta_title (Text) - "Ready to Get Started?"
│   ├── cta_description (Textarea)
│   ├── cta_form_shortcode (Text) - Gravity Forms code
│   └── cta_button_text (Text) - "Request Quote"
│
└── SEO Metadata (Group)
    ├── meta_description (Textarea)
    ├── meta_keywords (Text)
    └── og_image (Image)
```

### 3. Template Architecture

```
wp-content/themes/aitsc-pro-theme/
├── single-solutions.php ← REWRITE: Dynamic template
├── template-parts/
│   ├── solution/
│   │   ├── hero.php ← ACF hero section
│   │   ├── overview.php ← ACF overview
│   │   ├── features.php ← ACF repeater loop
│   │   ├── specs.php ← ACF specs group
│   │   ├── gallery.php ← ACF gallery
│   │   ├── sections.php ← ACF flexible content renderer
│   │   ├── case-studies.php ← ACF relationship field
│   │   ├── cta.php ← ACF CTA group
│   │   └── particle-bg.php ← Particle system integration
│   └── components/
│       ├── card.php ← Reusable card component
│       ├── feature-box.php ← Feature component
│       ├── spec-table.php ← Specifications table
│       └── cta-section.php ← CTA block
└── components/ (NEW - Phase 2 deliverable)
    └── solution-components.php ← All components in one file
```

### 4. Content Data Model

**Solution: Custom PCB Design**
```json
{
  "hero_title": "Custom PCB Design & Development",
  "hero_subtitle": "From schematic to production-ready PCBs in weeks, not months",
  "key_features": [
    {
      "icon": "settings",
      "title": "Rapid Prototyping",
      "description": "Fast turnaround from design to physical prototype"
    },
    {
      "icon": "shield",
      "title": "Quality Assurance",
      "description": "IPC Class 2 compliance, rigorous testing"
    }
  ],
  "specs": {
    "content": "<table>...</table>",
    "pdf_link": "/assets/pdfs/pcb-specs.pdf"
  },
  "case_studies": [1245, 1246] // Post IDs
}
```

---

## Implementation Strategy

### Phase 2 Rebuild (12 hours)

**Step 1: ACF Setup** (2 hours)
- Install/configure ACF Pro (if not already)
- Create "Solution Page Content" field group
- Apply to 'solutions' post type
- Export field group to PHP (future-proof)

**Step 2: Rewrite Single Template** (3 hours)
- Rewrite `single-solutions.php` to read ACF fields
- Remove hardcoded content
- Create template-parts for each section
- Integrate particle system on all solution pages

**Step 3: Create Component Library** (4 hours)
- Reusable component functions
- Card component (from Phase 2 plan)
- Feature box component
- Spec table component
- CTA section component
- All exported as PHP module (`inc/components.php`)

**Step 4: Populate Solution Content** (3 hours)
- Create 4 solution posts if not exist
- Populate ACF fields with service descriptions
- Add solution-specific icons and metadata
- Assign featured images per solution

### Phase 3 Integration (12 hours)

**Step 5: Fleet Safe Pro Product Page** (4 hours)
- Create "Fleet Safe Pro" solution post
- Populate from extracted Phase 3 content (516 lines, 62 images)
- Gallery integration with extracted images
- PDF specs link integration

**Step 6: Case Studies Integration** (4 hours)
- Create case_studies posts from Bus4x4 scenario
- Link to solutions via ACF relationship field
- Create case study template
- Testimonials section

**Step 7: Gallery & Media Optimization** (2 hours)
- Optimize 58+ product photos (resize, WebP conversion)
- Lazy loading implementation
- Lightbox integration for galleries

**Step 8: Testing & Refinement** (2 hours)
- Test all 5 solution pages
- Verify particle system on each
- Mobile responsiveness check
- Performance testing (Lighthouse)

---

## Code Structure

### 1. ACF Field Group Export (PHP)
```php
// inc/acf-fields.php
if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group([
        'key' => 'group_solution_page',
        'title' => 'Solution Page Content',
        'fields' => [
            [
                'key' => 'field_hero_section',
                'label' => 'Hero Section',
                'name' => 'hero_section',
                'type' => 'group',
                'sub_fields' => [
                    [
                        'key' => 'field_hero_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                        'required' => 1
                    ],
                    // ... more fields
                ]
            ]
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'solutions'
                ]
            ]
        ]
    ]);
}
```

### 2. Rewritten Single Template
```php
// single-solutions.php
get_header();

$solution_id = get_the_ID();

// HERO - Dynamic from ACF
get_template_part('template-parts/solution/hero');

// OVERVIEW - Dynamic from ACF
get_template_part('template-parts/solution/overview');

// FEATURES - Loop through repeater
get_template_part('template-parts/solution/features');

// SPECS - From ACF group
get_template_part('template-parts/solution/specs');

// FLEXIBLE SECTIONS - ACF flexible content
get_template_part('template-parts/solution/sections');

// GALLERY - ACF gallery field
get_template_part('template-parts/solution/gallery');

// RELATED CASE STUDIES - ACF relationship
get_template_part('template-parts/solution/case-studies');

// CTA - From ACF group
get_template_part('template-parts/solution/cta');

get_footer();
```

### 3. Component Module
```php
// inc/components.php
/**
 * Solution Components Library
 * Reusable components for solution pages
 */

function aitsc_component_feature_box($args = []) {
    // Default: icon, title, description, variant (glass/solid)
}

function aitsc_component_spec_table($specs = []) {
    // Renders responsive specs table
}

function aitsc_component_cta_section($args = []) {
    // Renders CTA with form integration
}

function aitsc_component_case_study_card($post_id) {
    // Uses card component from Phase 2
}
```

### 4. Template Part Example
```php
// template-parts/solution/features.php
<?php
$features = get_field('key_features');
if ($features) {
    echo '<section class="solution-features">';
    foreach ($features as $feature) {
        aitsc_component_feature_box([
            'icon' => $feature['feature_icon'],
            'title' => $feature['feature_title'],
            'description' => $feature['feature_description'],
            'variant' => 'glass'
        ]);
    }
    echo '</section>';
}
```

---

## Solution Content Strategy

### Solution 1: Custom PCB Design & Development
**Post ID**: (To be created)
**Slug**: custom-pcb-design
**Content Source**: Use AITSC service description + technical docs extracted in Phase 3

Hero: "End-to-end PCB design from schematic to production"
Features:
- Rapid prototyping (weeks, not months)
- Multi-layer PCB design
- EasyEDA integration
- IPC Class 2 compliance
- Cost optimization

Specs: BOM management, signal integrity analysis, thermal management

---

### Solution 2: Embedded Systems & Firmware Development
**Post ID**: (To be created)
**Slug**: embedded-systems
**Content Source**: AITSC embedded systems services

Hero: "Firmware development for microcontrollers and SoC"
Features:
- Real-time OS integration
- Device drivers
- Protocol implementations
- Performance optimization
- Security hardening

---

### Solution 3: Sensor System Design & Integration
**Post ID**: (To be created)
**Slug**: sensor-integration
**Content Source**: AITSC sensor services

Hero: "Complete sensor system design and integration"
Features:
- Signal conditioning
- Data acquisition
- Wireless integration
- Calibration & testing
- Environmental monitoring

---

### Solution 4: Automotive Electronics Engineering
**Post ID**: (To be created)
**Slug**: automotive-electronics

Hero: "CAN bus, diagnostics, and functional safety"
Features:
- CAN/LIN protocol implementation
- OBD diagnostics
- ISO 26262 compliance
- Vehicle integration testing
- Production support

---

### Solution 5: Fleet Safe Pro (Phase 3 Product)
**Post ID**: (To be created)
**Slug**: fleet-safe-pro
**Content Source**: Extracted Phase 3 manual (516 lines + 62 images)

Hero: "Real-time seatbelt and door monitoring system"
Features: (From manual extraction)
- Real-time seatbelt detection
- Door status monitoring
- Visual & audio alerts
- Plug-and-play installation
- Fleet management dashboard

Gallery: 58 product photos + 62 manual images

Specs: System architecture, components, technical specifications (from extracted manual)

---

## File Changes Required

### New Files to Create
```
wp-content/themes/aitsc-pro-theme/
├── inc/acf-fields.php (NEW - Field group definitions)
├── inc/components.php (NEW - Component library)
├── template-parts/solution/ (NEW - Directory)
│   ├── hero.php (NEW)
│   ├── overview.php (NEW)
│   ├── features.php (NEW)
│   ├── specs.php (NEW)
│   ├── gallery.php (NEW)
│   ├── sections.php (NEW)
│   ├── case-studies.php (NEW)
│   ├── cta.php (NEW)
│   └── particle-bg.php (NEW)
```

### Files to Modify
```
wp-content/themes/aitsc-pro-theme/
├── single-solutions.php (REWRITE - ~250 lines → ~50 lines + includes)
├── functions.php (ADD - Include new inc/acf-fields.php, inc/components.php)
└── inc/enqueue.php (UPDATE - Add component CSS if needed)
```

### Files to Keep (No Changes)
```
✅ particle-system.js (already working)
✅ functions.php (base structure)
✅ style.css (base styles)
```

---

## Database/Content Setup

### WordPress Posts to Create
```sql
-- Solution 1: Custom PCB Design
INSERT INTO wp_posts (post_title, post_type, post_name, post_status)
VALUES ('Custom PCB Design & Development', 'solutions', 'custom-pcb-design', 'publish');

-- Solution 2: Embedded Systems
VALUES ('Embedded Systems & Firmware Development', 'solutions', 'embedded-systems', 'publish');

-- Solution 3: Sensor Integration
VALUES ('Sensor System Design & Integration', 'solutions', 'sensor-integration', 'publish');

-- Solution 4: Automotive Electronics
VALUES ('Automotive Electronics Engineering', 'solutions', 'automotive-electronics', 'publish');

-- Solution 5: Fleet Safe Pro
VALUES ('Fleet Safe Pro System', 'solutions', 'fleet-safe-pro', 'publish');
```

### ACF Field Population
- Each solution post gets hero section, features, specs populated
- Featured images assigned (from extracted assets)
- Case studies linked via relationship field

---

## Testing Strategy

### Unit Tests
- ACF field retrieval (get_field() functions)
- Component rendering (each template part)
- Particle system integration on all pages

### Integration Tests
- Page load (all 5 solution pages)
- Navigation to/from solutions
- Form submission on CTA
- Image lazy loading
- Responsive breakpoints

### Browser Tests
- Desktop (1344x795 - tested)
- Tablet (768px)
- Mobile (375px)
- Particle performance on each

### Accessibility Tests
- WCAG 2.1 Level AA
- Keyboard navigation
- Screen reader compatibility
- Color contrast ratios

---

## Deployment Strategy

### Pre-Deployment
1. Backup current `single-solutions.php`
2. Export current post data
3. Test on staging environment
4. Performance benchmark

### Deployment Order
1. Deploy ACF field group export (inc/acf-fields.php)
2. Deploy component library (inc/components.php)
3. Deploy template parts (template-parts/solution/)
4. Deploy rewritten single-solutions.php
5. Update functions.php to include new files
6. Create/populate solution posts
7. Verify all pages load
8. Performance test (Lighthouse)

### Rollback Plan
- Keep backup of original single-solutions.php
- If ACF fields cause issues, can delete and restore original
- No database migrations (only post content)

---

## Success Criteria

### Phase 2 Completion
- ✅ 4 solution pages load dynamically (no hardcoded content)
- ✅ Component library created and reusable
- ✅ ACF field group exported as PHP
- ✅ Particle system visible on all solution pages
- ✅ Mobile responsive (tested at 375px, 768px, 1344px)
- ✅ Page load time < 3 seconds (Lighthouse target)
- ✅ Lighthouse score > 90

### Phase 3 Completion
- ✅ Fleet Safe Pro manual content integrated (516 lines)
- ✅ Product images gallery populated (58 + 62 images)
- ✅ PDF specs downloadable
- ✅ Related case studies linked
- ✅ CTA form functional (Gravity Forms)

---

## Risk Mitigation

**Risk**: ACF fields not populating correctly
**Mitigation**: Test field group export → manual verification → PHP export backup

**Risk**: Page load performance degradation
**Mitigation**: Lazy load images, cache ACF fields, optimize gallery

**Risk**: Particle system conflicts with ACF sections
**Mitigation**: Test particle z-index, pointer-events on each section

**Risk**: Form integration fails
**Mitigation**: Test Gravity Forms integration pre-deployment

---

## Dependencies

### Required
- ACF Pro (or free version)
- WordPress 6.0+
- PHP 8.0+
- Gravity Forms (for CTA)
- Existing: particle-system.js

### Optional
- WP Rocket (caching)
- Smush (image optimization)
- Elementor (if expanding builder later)

---

## Unresolved Questions

1. Should solutions also be available in blog/archive view? (Currently only single pages)
2. How many case studies per solution? (Recommend 2-3)
3. Should testimonials use separate CPT or ACF repeater?
4. Need product videos embedded? (Phase 3 didn't extract)
5. Should specification PDFs be versioned? (Current approach: single file link)

---

## Deliverables Checklist

- [ ] ACF field group PHP export
- [ ] Rewritten single-solutions.php
- [ ] Component library (inc/components.php)
- [ ] 9 template parts (hero, overview, features, specs, gallery, sections, case-studies, cta, particle-bg)
- [ ] 5 populated solution posts
- [ ] Updated functions.php
- [ ] Updated enqueue.php (if CSS added)
- [ ] Testing report
- [ ] Performance report (Lighthouse)
- [ ] Deployment checklist

---

**Plan prepared by**: Planning Skill
**Ready for**: Fullstack Developer (Implementation Phase)
**Next Steps**: Use /cook skill to implement or delegation to fullstack-developer agent
