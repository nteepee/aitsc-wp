# Seat Belt Detection System Pages - Parallel Implementation Plan

**Project**: 8-Page WordPress Content Implementation
**Location**: `/Applications/MAMP/htdocs/aitsc-wp/`
**Theme**: `aitsc-pro-theme`
**Content Source**: `/plans/251229-2319-codebase-consistency-audit/content-pages/`
**Created**: 2025-12-30
**Status**: Ready for Execution

---

## Overview

Build 8 interlinked WordPress solution pages for seat belt detection system using existing `single-solutions.php` template and ACF field structure. All pages under `solutions` CPT, `passenger-monitoring-systems` category.

### Pages to Create

| # | Page Name | Slug | Type | Content File |
|---|-----------|------|------|--------------|
| 1 | Seat Belt Detection System | `seat-belt-detection-system` | Primary Product | 01-primary-product-*.md |
| 2 | Buses | `seatbelt-alert-system-buses` | Use Case | 02-use-case-buses.md |
| 3 | Fleet Compliance | `fleet-seatbelt-compliance` | Use Case | 03-use-case-fleet-compliance.md |
| 4 | Rideshare | `rideshare-seatbelt-monitoring` | Use Case | 04-use-case-rideshare.md |
| 5 | Installation | `seat-belt-installation-guide` | Guide | 05-installation-guide.md |
| 6 | Buckle Sensor | `buckle-sensor-component` | Component | 06-component-buckle-sensor.md |
| 7 | Seat Sensor | `seat-sensor-component` | Component | 07-component-seat-sensor.md |
| 8 | Display Unit | `display-unit-component` | Component | 08-component-display-unit.md |

---

## Architecture Analysis

### Existing Infrastructure

**Template**: `single-solutions.php`
- Renders solution posts using template parts
- No new templates needed

**ACF Fields Available** (Already configured):
```php
hero_section (group)
  - title, subtitle, image, cta_text, cta_link
overview_text (wysiwyg)
features (repeater)
  - feature_title, feature_description, feature_icon
specs (repeater)
  - spec_label, spec_value
gallery_images (gallery)
cta (group)
  - cta_section_title, cta_section_description, cta_button_text, cta_button_link
```

**Universal Components** (Functions available):
- `aitsc_render_hero()` - 4 variants
- `aitsc_render_card()` - 7 variants
- `aitsc_render_cta()` - 4 variants
- `aitsc_render_stats()`
- `aitsc_render_testimonials()`

**Template Parts**:
- `template-parts/solution/hero.php` or `hero-fleet.php`
- `template-parts/solution/overview.php`
- `template-parts/solution/features.php`
- `template-parts/solution/specs.php`
- `template-parts/solution/gallery.php`
- `template-parts/solution/cta.php`

### Cross-Linking Strategy

**Hub (Primary Product)**:
```
Primary (01) → Buses (02)
              → Fleet (03)
              → Rideshare (04)
              → Installation (05)
              → Buckle Sensor (06)
              → Seat Sensor (07)
              → Display Unit (08)
```

**Spoke (Use Cases)**:
- Link back to Primary
- Link to Installation
- Link to relevant Components
- Link to sibling use cases

**Component Pages**:
- Link to Primary
- Link to Installation
- Link to other components
- "Buy as system" link to Primary

---

## Dependency Graph

```
Phase 1 (Parallel): WordPress Post Creation
┌─────────────────────────────────────────────────────────────┐
│  Agent A: Posts 1-4  │  Agent B: Posts 5-8                 │
│  - Primary           │  - Installation                     │
│  - Buses             │  - Buckle Sensor                    │
│  - Fleet             │  - Seat Sensor                      │
│  - Rideshare         │  - Display Unit                     │
└─────────────────────────────────────────────────────────────┘
           ↓                    ↓
    (All posts created with slugs and categories)

Phase 2 (Parallel): Image Upload & Organization
┌─────────────────────────────────────────────────────────────┐
│  Agent A: Hero/Feature Images  │  Agent B: Gallery/Spec Images │
└─────────────────────────────────────────────────────────────┘
           ↓                    ↓
    (Images uploaded, URLs ready)

Phase 3 (Sequential): ACF Field Population
┌─────────────────────────────────────────────────────────────┐
│  Primary (01) ← Must be FIRST                              │
│  ↓                                                         │
│  Use Cases (02-04) ← Can parallel after Primary            │
│  ↓                                                         │
│  Installation (05) ← After Use Cases                       │
│  ↓                                                         │
│  Components (06-08) ← Can parallel after Installation      │
└─────────────────────────────────────────────────────────────┘
           ↓
Phase 4 (Sequential): Cross-Link Injection
           ↓
Phase 5 (Parallel): SEO Metadata & Verification
```

---

## Phase Breakdown

### Phase 1: WordPress Post Creation (PARALLEL)

**Duration**: 1-2 hours
**Agents**: 2 (Agent A, Agent B)
**Parallelizable**: YES (100%)

**Agent A Tasks** (Posts 1-4):
1. Create post: "Seat Belt Detection System"
   - Post type: `solutions`
   - Slug: `seat-belt-detection-system`
   - Category: `passenger-monitoring-systems`
   - Status: `draft`

2. Create post: "Buses"
   - Post type: `solutions`
   - Slug: `seatbelt-alert-system-buses`
   - Category: `passenger-monitoring-systems`
   - Status: `draft`

3. Create post: "Fleet Compliance"
   - Post type: `solutions`
   - Slug: `fleet-seatbelt-compliance`
   - Category: `passenger-monitoring-systems`
   - Status: `draft`

4. Create post: "Rideshare"
   - Post type: `solutions`
   - Slug: `rideshare-seatbelt-monitoring`
   - Category: `passenger-monitoring-systems`
   - Status: `draft`

**Agent B Tasks** (Posts 5-8):
1. Create post: "Installation"
   - Post type: `solutions`
   - Slug: `seat-belt-installation-guide`
   - Category: `passenger-monitoring-systems`
   - Status: `draft`

2. Create post: "Buckle Sensor"
   - Post type: `solutions`
   - Slug: `buckle-sensor-component`
   - Category: `passenger-monitoring-systems`
   - Status: `draft`

3. Create post: "Seat Sensor"
   - Post type: `solutions`
   - Slug: `seat-sensor-component`
   - Category: `passenger-monitoring-systems`
   - Status: `draft`

4. Create post: "Display Unit"
   - Post type: `solutions`
   - Slug: `display-unit-component`
   - Category: `passenger-monitoring-systems`
   - Status: `draft`

**Verification**:
```bash
# Verify all posts created
wp post list --post_type=solutions --fields=ID,post_title,post_name --format=table
```

---

### Phase 2: Image Upload & Organization (PARALLEL)

**Duration**: 1-2 hours
**Agents**: 2 (can run during Phase 1)
**Parallelizable**: YES (100%)

**Image Requirements** (from implementation guide):

| Section | Dimensions | Format | Count per Page |
|---------|------------|--------|----------------|
| Hero | 1200x800px | PNG/JPG | 1 |
| Feature | 600x400px | PNG/JPG | 3-6 |
| Spec Diagram | 1000x700px | PNG | 1 |
| Gallery | 800x600px | JPG | 4-8 |
| CTA Background | 1200x600px | JPG | 1 |

**Total Images Needed**: ~50-70 images across 8 pages

**Agent A Tasks**:
1. Upload hero images (8 images)
2. Upload feature images (~24 images)
3. Record image IDs/URLs in shared manifest

**Agent B Tasks**:
1. Upload spec diagrams (8 images)
2. Upload gallery images (~32 images)
3. Upload CTA backgrounds (8 images)
4. Record image IDs/URLs in shared manifest

**Shared Manifest Format**:
```json
{
  "seat-belt-detection-system": {
    "hero": "https://.../display-interface.png",
    "feature_1": "https://.../real-time-detection.jpg",
    "specs": "https://.../spec-diagram.png",
    "gallery": [123, 124, 125, 126]
  }
}
```

**Verification**:
```bash
# Count uploaded images
wp media list --fields=ID,post_name --format=csv | wc -l
```

---

### Phase 3: ACF Field Population (SEQUENTIAL)

**Duration**: 4-6 hours
**Agents**: 1-2 (see sequence below)
**Parallelizable**: PARTIAL (see groups)

#### Group 1: Primary Product (SEQUENTIAL - MUST BE FIRST)

**Agent**: Any
**File**: `01-primary-product-seat-belt-detection-system.md`

**ACF Fields to Populate**:
```php
// Hero Section
hero_section => [
    'title' => 'Protect Every Passenger. Instantly.',
    'subtitle' => 'Every time your bus moves...',
    'image' => [image_url],
    'cta_text' => 'Get MY Free Demo',
    'cta_link' => '/contact?subject=Demo'
]

// Overview
overview_text => [Full PAS content from doc]

// Features (4-6 features)
features => [
    0 => ['feature_title' => 'Real-Time Detection', ...],
    1 => ['feature_title' => 'Visual Dashboard', ...],
    // ...
]

// Specs (8-12 specs)
specs => [
    0 => ['spec_label' => 'Display', 'spec_value' => '7-inch LCD'],
    // ...
]

// Gallery
gallery_images => [array of IDs]

// CTA
cta => [
    'cta_section_title' => 'Protect Your Passengers...',
    'cta_section_description' => 'Get customized demo...',
    'cta_button_text' => 'Get MY Free Demo',
    'cta_button_link' => '/contact'
]
```

**Output**: Record post ID for cross-linking

---

#### Group 2: Use Cases (PARALLEL - 2 Agents)

**Agent A**: Buses (02), Fleet (03)
**Agent B**: Rideshare (04)

**Each Use Case Page**:
```php
// Same ACF structure as Primary
// Content from respective .md files
// CTA tailored to audience
```

**Cross-Link Injection** (after ACF populate):
- Link back to Primary
- Link to other use cases
- Link to Installation

---

#### Group 3: Installation Guide (SEQUENTIAL)

**Agent**: Any
**File**: `05-installation-guide.md`

**Unique Fields**:
- Step-by-step installation process in `overview_text`
- Features as installation benefits
- Specs as requirements

**Cross-Links**:
- To all components
- To Primary
- CTA to contact form

---

#### Group 4: Component Pages (PARALLEL - 2 Agents)

**Agent A**: Buckle Sensor (06), Seat Sensor (07)
**Agent B**: Display Unit (08)

**Each Component Page**:
```php
// Heavy on specs (15-20 specs per component)
// Technical focus in overview
// "Buy as system" CTA to Primary
```

**Cross-Links**:
- To Primary
- To Installation
- To sibling components

---

### Phase 4: Cross-Link Injection (SEQUENTIAL)

**Duration**: 1-2 hours
**Agent**: 1 (must have all post IDs)

**Link Matrix**:

| From | To | Type |
|------|-----|------|
| Primary (01) | Buses, Fleet, Rideshare, Installation, All Components | CTA in features |
| Buses (02) | Primary, Installation, Buckle Sensor, Seat Sensor | "Learn More" |
| Fleet (03) | Primary, Installation, Display Unit | "Learn More" |
| Rideshare (04) | Primary, Installation, All Components | "Learn More" |
| Installation (05) | All Components, Primary | "Related Products" |
| Buckle Sensor (06) | Primary, Installation, Seat/Display Sensors | "Related" |
| Seat Sensor (07) | Primary, Installation, Buckle/Display Sensors | "Related" |
| Display Unit (08) | Primary, Installation, Buckle/Seat Sensors | "Related" |

**Implementation**:
```php
// Update overview_text or features with HTML links
// Use WordPress shortcodes or hard links
// Example: <a href="/solutions/passenger-monitoring-systems/seat-belt-detection-system/">Learn more about the complete system</a>
```

---

### Phase 5: SEO Metadata & Verification (PARALLEL)

**Duration**: 1-2 hours
**Agents**: 2

**Agent A**: SEO Metadata
1. Update Yoast SEO/Rank Math meta titles
2. Update meta descriptions
3. Update canonical URLs
4. Add Open Graph tags

**Agent B**: Verification
1. Visual inspection of all 8 pages
2. Mobile responsive test
3. Link validation (all cross-links work)
4. ACF field validation (no missing required fields)

**Verification Checklist**:
- [ ] All 8 pages load without errors
- [ ] Hero images display correctly
- [ ] Features render in grid
- [ ] Specs display in table
- [ ] Gallery images load
- [ ] CTA buttons work
- [ ] Cross-links navigate correctly
- [ ] Mobile layout stacks properly
- [ ] SEO meta tags present

---

## File Ownership Matrix

| Phase | Agent A | Agent B |
|-------|---------|---------|
| 1 (Posts) | Posts 1-4 | Posts 5-8 |
| 2 (Images) | Hero + Feature images | Specs + Gallery + CTA images |
| 3 (ACF) | Primary + Buses + Fleet | Rideshare + Installation + Buckle + Seat + Display |
| 4 (Links) | All cross-link injection | - |
| 5 (SEO) | SEO metadata | Verification testing |

---

## Parallel Execution Strategy

### Optimal Agent Configuration

**4 Agents Total** (can scale to 2 if needed):

**Agent A**: Post Creator (Phase 1)
- Creates all 8 posts via WP-CLI
- Records post IDs

**Agent B**: Image Uploader (Phase 2 - runs parallel with A)
- Uploads all images via WP-CLI
- Creates image manifest

**Agent C**: Content Populator - Use Cases (Phase 3)
- Populates Primary first
- Then Buses, Fleet, Rideshare

**Agent D**: Content Populator - Components (Phase 3)
- Waits for Primary
- Then Installation, Buckle, Seat, Display

**Single Agent** (Phase 4-5):
- Cross-link injection
- Final verification

### WP-CLI Commands

**Phase 1: Create Posts**
```bash
wp post create --post_type=solutions --post_title='Seat Belt Detection System' --post_name='seat-belt-detection-system' --post_status=draft
wp post term add {post_id} solution_category passenger-monitoring-systems
```

**Phase 2: Upload Images**
```bash
wp media import /path/to/image.png --title="Display Interface"
```

**Phase 3: Populate ACF**
```bash
wp post meta update {post_id} hero_section '{json}'
# Or use ACF's native WP-CLI integration
```

---

## Testing Checklist

### Pre-Launch

**Content Validation**:
- [ ] All 8 pages created with correct slugs
- [ ] All posts in `passenger-monitoring-systems` category
- [ ] ACF fields populated (no empty required fields)
- [ ] Hero images uploaded and assigned
- [ ] Gallery images uploaded (4-8 per page)
- [ ] Feature icons specified

**Link Validation**:
- [ ] Primary links to all 7 other pages
- [ ] Each page links back to Primary
- [ ] Component pages link to each other
- [ ] Use case pages link to each other
- [ ] Installation page links to all components

**SEO Validation**:
- [ ] Meta titles (50-60 chars)
- [ ] Meta descriptions (150-160 chars)
- [ ] Canonical URLs set
- [ ] Open Graph images set

**Mobile Validation**:
- [ ] Hero sections stack vertically
- [ ] Feature grids single column
- [ ] CTA buttons in thumb zone
- [ ] No horizontal scroll

### Post-Launch

**Performance**:
- [ ] Page load <3s
- [ ] Lighthouse score >90
- [ ] Mobile-friendly test pass

**Analytics**:
- [ ] GA4 tracking installed
- [ ] CTA click events configured
- [ ] Page view tracking active

---

## Success Criteria

### Functional Requirements
- ✅ All 8 pages accessible at correct URLs
- ✅ Single template (`single-solutions.php`) renders all
- ✅ ACF fields populate correctly
- ✅ Cross-links navigate without 404s
- ✅ Images display properly

### Content Requirements
- ✅ All content from .md files imported
- ✅ SEO metadata matches spec
- ✅ CTA buttons configured with tracking
- ✅ Technical specifications accurate

### Design Requirements
- ✅ Hero sections follow template
- ✅ Features render in 3-column grid (desktop)
- ✅ Specs in table format
- ✅ Gallery images display
- ✅ Mobile responsive (stacks to single column)

### Performance Requirements
- ✅ Page load time <3s
- ✅ No console errors
- ✅ No missing images (404s)
- ✅ All links validate

---

## Risk Mitigation

| Risk | Impact | Mitigation |
|------|--------|------------|
| Post ID conflicts | High | Use sequential creation, record IDs |
| Image upload failures | Medium | Batch upload, validate URLs |
| ACF field key mismatch | High | Verify field keys exist before populate |
| Cross-link 404s | Medium | Verify all slugs before linking |
| Template rendering issues | High | Test with one page before batch |
| Content import errors | Medium | Validate JSON before update |

---

## Rollback Strategy

**If Phase 3 Fails**:
```bash
# Delete all posts
wp post delete $(wp post list --post_type=solutions --format=ids) --force

# Start over with verified content files
```

**If Images Fail**:
```bash
# Delete all media
wp media list --format=ids | xargs wp media delete --force

# Re-upload from backup
```

---

## Execution Timeline

| Phase | Duration | Parallel? | Dependencies |
|-------|----------|-----------|--------------|
| 1: Post Creation | 1-2h | Yes (2 agents) | None |
| 2: Image Upload | 1-2h | Yes (2 agents) | None |
| 3: ACF Populate | 4-6h | Partial (groups) | 1→2,3→4 |
| 4: Cross-Link | 1-2h | No | Phase 3 |
| 5: SEO + Verify | 1-2h | Yes (2 agents) | Phase 4 |
| **Total** | **8-14h** | **Avg 3 agents** | - |

---

## Unresolved Questions

1. **Image Source**: Where are the actual image files located? Need source path for upload.
2. **Existing Images**: Are any of the required images already uploaded? Check media library.
3. **Yoast/Rank Math**: Which SEO plugin is active? Affects metadata population.
4. **Shortcodes**: Any custom shortcodes for cross-links or need hard URLs?
5. **Featured Images**: Should featured image be set separately from hero image?
6. **Gallery Images**: Specific images for each page or generic set?
7. **Testimonial Data**: Are testimonials real or placeholders?
8. **Video URLs**: Video modals mentioned in content - where are videos hosted?

---

*Plan ready for execution. Assign agents and begin Phase 1.*
