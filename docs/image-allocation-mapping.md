# AITSC Image Allocation Mapping
## Complete Guide to Image Placement in WordPress

**Generated:** January 6, 2026
**Total Images:** 126 organized images
**Status:** Ready for manual upload via WordPress admin

---

## OVERVIEW

| Component | Total Images | Priority | Status |
|-----------|--------------|----------|--------|
| Heroes | 20 | Critical | Ready |
| Galleries | 88 | Critical | Ready |
| Graphics | 7 | Recommended | Ready |
| Technical | 11 | Recommended | Ready |
| **TOTAL** | **126** | | **Ready** |

---

## DIRECTORY STRUCTURE

```
/wp-content/uploads/aitsc-images/
├── heroes/
│   ├── fleet-safe-pro/       → 1-2 hero images
│   ├── pcb-design/           → 5-10 November BB originals for rotation
│   ├── embedded-systems/     → 5-10 November BB originals for rotation
│   └── automotive/           → 1-2 from PXL series
├── galleries/
│   ├── fleet-safe-pro/       → 58 PXL numbered series (product photos)
│   ├── pcb-design/           → November BB converted PNGs
│   ├── embedded-systems/     → November BB converted PNGs
│   ├── automotive/           → Selected PXL installation photos
│   └── november-bb/          → 20 converted images for rotation
├── graphics/
│   ├── icons/                → bus.png, chair-seat-pad.png, shake-hands.png
│   ├── decorative/           → unnamed-*.png series
│   └── backgrounds/          → patterns and fills
├── technical/
│   ├── diagrams/             → system-overview-diagram.png
│   └── seating-maps/         → 800x480-v15-*.png configurations
└── brand/
    └── (existing brand assets)
```

---

## PAGE-BY-PAGE ALLOCATION

### 1. HOMEPAGE (8 images)

**Template File:** `/wp-content/themes/aitsc-pro-theme/front-page.php`

| Section | Image | ACF Field | Priority | Reasoning |
|---------|-------|-----------|----------|-----------|
| Hero Background | `fleet-safe-pro-featured.png` | `hero_section->image` | **Critical** | Main brand identity, professional hero display |
| Solution Card 1 | `bus.png` | `solution_sections[0]->text_image->image` | Recommended | Passenger transport visual, cleaner than photos |
| Solution Card 2 | `chair-seat-pad.png` | `solution_sections[1]->text_image->image` | Recommended | Component detail icon, technical credibility |
| Solution Card 3 | `system-overview-diagram.png` | `solution_sections[2]->text_image->image` | Recommended | System architecture, supports text content |
| Blog Preview 1 | `PXL_20250915_010601218.jpg` (highest res) | Featured Image | Recommended | Quality installation shot for blog carousel |
| Blog Preview 2 | `PXL_20250915_010407976.jpg` | Featured Image | Recommended | Different angle, visual variety |
| Blog Preview 3 | `PXL_20250915_005553814.jpg` | Featured Image | Optional | Completes blog section preview trio |

**Deliverable:** 8 images assigned, homepage fully image-rich

---

### 2. FLEET SAFE PRO SOLUTION PAGE (20 images)

**Template File:** `/wp-content/themes/aitsc-pro-theme/single-solutions.php` (Solution Post ID: TBD)

#### A. Hero Section
| Image | ACF Field | Priority |
|-------|-----------|----------|
| `display-ui-main.png` | `hero_section->image` | **Critical** |

**Reasoning:** Product-specific hero showing primary display interface. Already optimized for web.

#### B. Featured Image (for archive display)
| Image | ACF Field | Priority |
|-------|-----------|----------|
| `fleet-safe-pro-featured.png` | Featured Image (WordPress native) | **Critical** |

**Reasoning:** Consistent branding, archive listing visibility.

#### C. Product Gallery (15 best images)
| Images | ACF Field | Priority |
|--------|-----------|----------|
| Top 15 PXL photos (see selection below) | `gallery_images` array | **Critical** |

**Selected Best Photos for Gallery:**
1. `1-PXL_20250915_010601218.jpg` (736KB, highest quality)
2. `10-PXL_20250915_011035196.jpg` (clean installation)
3. `13-PXL_20250915_011011902.jpg` (detail shot)
4. `15-PXL_20250915_010846203.jpg` (new angle)
5. `19-PXL_20250915_010810481.jpg` (system overview)
6. `22-PXL_20250915_010728653.jpg` (installation detail)
7. `25-PXL_20250915_005608441.jpg` (component focus)
8. `27-PXL_20250915_005553814.jpg` (unique perspective)
9. `31-PXL_20250915_005452852.jpg` (wiring detail)
10. `35-PXL_20250915_005347929.jpg` (assembly view)
11. `39-PXL_20250915_005258264.jpg` (testing phase)
12. `42-PXL_20250915_005226960.jpg` (final product)
13. `48-PXL_20250915_005054468.jpg` (mounted position)
14. `52-PXL_20250915_005025440.jpg` (dashboard integration)
15. `56-PXL_20250915_004921069.jpg` (complete system)

**Reasoning:** High-quality product photos showing complete system lifecycle from components through installation to final integration.

#### D. Flexible Content - Text + Image Sections

| Section | Image | Purpose | Priority |
|---------|-------|---------|----------|
| Architecture | `system-diagram.png` | Show system wiring | Recommended |
| Configuration | `800x480-v15---white-red.png` | Display UI config | Recommended |
| Components | `chair-seat-pad.png` | Seat sensor detail | Recommended |

**Reasoning:** Technical sections benefit from visual reinforcement of textual content.

**Deliverable:** 20 images fully allocated, Fleet Safe Pro complete

---

### 3. PCB DESIGN SOLUTION PAGE (12 images)

**Template File:** `/wp-content/themes/aitsc-pro-theme/single-solutions.php` (Solution Post ID: TBD)

#### A. Hero Section - ROTATE November BB Originals
| Images | ACF Field | Priority | Rotation |
|--------|-----------|----------|----------|
| `PXL_20251120_050336202.jpg` | `hero_section->image` | **Critical** | Primary |
| `PXL_20251120_050452968.jpg` | `hero_section->image` | **Critical** | Alt 1 |
| `PXL_20251120_050627441.jpg` | `hero_section->image` | **Critical** | Alt 2 |

**Note:** Use only one at a time. Rotate for freshness.

#### B. Featured Image
| Image | ACF Field | Priority |
|-------|-----------|----------|
| `PXL_20251120_050336202.jpg` | Featured Image | **Critical** |

#### C. Product Gallery (8 November BB Converted)
| Images | ACF Field | Priority |
|--------|-----------|----------|
| Top 8 from `Converted by Thinh/` folder | `gallery_images` array | **Critical** |

**Recommended Selection:**
- Files 10.png, 12.png, 14.png, 16.png, 18.png, 20.png, 22.png, 24.png

**Reasoning:** Optimized for web, clean backgrounds, professional appearance.

#### D. Flexible Content Images
| Image | Purpose | Priority |
|-------|---------|----------|
| `system-overview-diagram.png` | Architecture | Recommended |
| `shake-hands.png` | Partnership/custom section | Recommended |

**Deliverable:** 12 images allocated

---

### 4. EMBEDDED SYSTEMS SOLUTION PAGE (12 images)

**Template File:** `/wp-content/themes/aitsc-pro-theme/single-solutions.php` (Solution Post ID: TBD)

#### A. Hero Section - ROTATE November BB Originals
| Images | ACF Field | Priority |
|--------|-----------|----------|
| `PXL_20251120_050713718.jpg` | `hero_section->image` | **Critical** |
| `PXL_20251120_050837198.jpg` | `hero_section->image` | **Critical** |
| `PXL_20251120_050859562.jpg` | `hero_section->image` | **Critical** |

#### B. Featured Image
| Image | ACF Field | Priority |
|-------|-----------|----------|
| `PXL_20251120_050713718.jpg` | Featured Image | **Critical** |

#### C. Product Gallery (8 November BB Converted)
| Images | ACF Field | Priority |
|--------|-----------|----------|
| Files 11.png, 13.png, 15.png, 17.png, 19.png, 21.png, 23.png, 25.png | `gallery_images` array | **Critical** |

#### D. Flexible Content Images
| Image | Purpose | Priority |
|-------|---------|----------|
| `bus.png` | System integration | Recommended |
| `chair-seat-pad.png` | Component detail | Recommended |

**Deliverable:** 12 images allocated

---

### 5. AUTOMOTIVE ELECTRONICS SOLUTION PAGE (12 images)

**Template File:** `/wp-content/themes/aitsc-pro-theme/single-solutions.php` (Solution Post ID: TBD)

#### A. Hero Section - ROTATE November BB Originals
| Images | ACF Field | Priority |
|--------|-----------|----------|
| `PXL_20251120_050909264.jpg` | `hero_section->image` | **Critical** |
| `PXL_20251120_050927534.jpg` | `hero_section->image` | **Critical** |
| `PXL_20251120_050934673.jpg` | `hero_section->image` | **Critical** |

#### B. Featured Image
| Image | ACF Field | Priority |
|-------|-----------|----------|
| `PXL_20251120_050909264.jpg` | Featured Image | **Critical** |

#### C. Product Gallery (8 Selected PXL Automotive Photos)
| Images | ACF Field | Priority |
|--------|-----------|----------|
| Selected automotive-focused PXL images | `gallery_images` array | **Critical** |

**Recommended Selection from automotive/ folder:**
- Various installation shots showing vehicle integration, dashboard mounting, cable routing

#### D. Flexible Content Images
| Image | Purpose | Priority |
|-------|---------|----------|
| `shake-hands.png` | Partnership message | Recommended |
| `system-diagram.png` | Technical spec | Recommended |

**Deliverable:** 12 images allocated

---

### 6. ABOUT PAGE (4 images)

**Template File:** `/wp-content/themes/aitsc-pro-theme/page-about-aitsc.php`

| Section | Image | ACF Field | Priority | Notes |
|---------|-------|-----------|----------|-------|
| Page Hero | `fleet-safe-hero.png` | `hero_section->image` | Recommended | Professional page introduction |
| Team Photos | *(Skip)* | *(Placeholders)* | Optional | Per user: keep gray circles |

**Deliverable:** 1 hero image assigned, team photos deferred

---

### 7. SOLUTIONS ARCHIVE PAGE (4 images)

**Template File:** `/wp-content/themes/aitsc-pro-theme/archive-solutions.php`

| Category | Featured Image | Source | Priority |
|----------|---|--------|----------|
| Fleet Safe Pro | `fleet-safe-pro-featured.png` | Direct | **Critical** |
| PCB Design | `PXL_20251120_050336202.jpg` | November BB | **Critical** |
| Embedded Systems | `PXL_20251120_050713718.jpg` | November BB | **Critical** |
| Automotive | `PXL_20251120_050909264.jpg` | November BB | **Critical** |

**Reasoning:** Category cards need thumbnail images for visual organization and user engagement.

**Deliverable:** 4 category images allocated

---

### 8. PASSENGER MONITORING HUB (Taxonomy Page)

**Template File:** `/wp-content/themes/aitsc-pro-theme/taxonomy-solution_category-passenger-monitoring-systems.php`

| Element | Image | Priority |
|---------|-------|----------|
| Page Hero | `display-ui-main.png` | Recommended |
| Category Featured Image | `PXL_20251120_050336202.jpg` | Recommended |

**Reasoning:** Hub page needs distinctive visuals to show monitoring system capabilities.

**Deliverable:** 2 images allocated

---

## TECHNICAL SPECIFICATIONS

### Hero Images
- **Dimensions:** 1920x1080px minimum (landscape)
- **Recommended Sources:** November BB originals (1.1-1.6MB, high quality)
- **Fallback:** Fleet Safe Pro PNG heroes
- **Optimization:** Keep as-is for quality

### Gallery Images
- **Dimensions:** 1200x800px recommended, variable accepted
- **Sources:**
  - Fleet Safe Pro: PXL series (58 photos)
  - Other solutions: November BB converted (20 PNGs)
- **Optimization:** Already optimized (232KB-1MB each)
- **Lightbox:** Enable for enhanced viewing

### Graphics/Icons
- **Dimensions:** 400-1024px
- **Sources:** Graphics folder (8 files)
- **Format:** PNG with transparency preferred
- **Usage:** Feature sections, decorative elements

### Seating Maps
- **Dimensions:** 800x480px (standardized)
- **Format:** PNG
- **Usage:** Technical specs, configuration documentation
- **Count:** 11 total configurations

---

## UPLOAD PRIORITY ORDER

**Phase 1 - Critical (Upload First):**
1. Fleet Safe Pro heroes (2 images)
2. Fleet Safe Pro gallery (15 images)
3. Featured images for all pages (4 images)
4. Homepage hero (1 image)
5. November BB originals for solution heroes (15 images)

**Phase 2 - Recommended:**
6. November BB converted galleries (20 images)
7. Graphics/icons (8 images)
8. Technical diagrams (2 images)

**Phase 3 - Optional:**
9. Seating maps (11 images)
10. Decorative images (remaining)

---

## ACF FIELD PATHS

### Solution Hero Section
**Field Name:** `hero_section`
**Sub-fields:**
- `image` (type: Image, return format: URL)
- `title` (type: Text)
- `subtitle` (type: Textarea)
- `cta_text` (type: Text)
- `cta_link` (type: URL)

### Product Gallery
**Field Name:** `gallery_images`
**Type:** Gallery field
**Return Format:** Array of image objects
**Recommended Images Per Gallery:** 3-15

### Flexible Content - Text + Image
**Field Name:** `solution_sections`
**Layout:** text_image
**Sub-fields:**
- `title` (type: Text)
- `content` (type: WYSIWYG)
- `image` (type: Image array)
- `layout` (type: Select: left/right)

### WordPress Featured Image
**Field:** Post thumbnail
**Return Format:** URL
**Dimensions:** 800x600px recommended

---

## STATUS TRACKING

### Images Ready for Upload
- ✅ Heroes: 20 images organized
- ✅ Galleries: 88 images organized
- ✅ Graphics: 7 images organized
- ✅ Technical: 11 images organized

### Allocation Complete
- ✅ Homepage: 8 images mapped
- ✅ Fleet Safe Pro: 20 images mapped
- ✅ PCB Design: 12 images mapped
- ✅ Embedded Systems: 12 images mapped
- ✅ Automotive: 12 images mapped
- ✅ About Page: 1 image mapped
- ✅ Archives: 4 images mapped
- ✅ Passenger Monitoring Hub: 2 images mapped

**Total Allocated:** 71 images
**Remaining:** 55 images (for future pages, blog posts, case studies, backups, rotation)

---

## NEXT STEPS

1. **Manual Upload via WordPress Admin**
   - See `docs/manual-image-assignment-guide.md` for step-by-step instructions
   - Upload images in priority order (Phase 1 first)
   - Note attachment IDs as you upload

2. **ACF Field Assignment**
   - Navigate to each solution page
   - Use media library IDs to assign images
   - Test hero display and gallery lightbox

3. **Quality Assurance**
   - Verify all images display correctly
   - Check responsive design on mobile
   - Test gallery lightbox functionality
   - Validate page load performance

---

## IMAGE SOURCES REFERENCE

| Folder | Count | Type | Best For |
|--------|-------|------|----------|
| `/galleries/fleet-safe-pro/` | 58 | Product Photos | Primary gallery |
| `/galleries/november-bb/` | 20 | Optimized Photos | Secondary galleries |
| `/galleries/pcb-design/` | 5 | Converted Images | PCB gallery |
| `/galleries/embedded-systems/` | 5 | Converted Images | Embedded gallery |
| `/galleries/automotive/` | ~20 | Installation Photos | Automotive gallery |
| `/heroes/pcb-design/` | 10 | November BB Originals | Solution heroes |
| `/heroes/embedded-systems/` | 10 | November BB Originals | Solution heroes |
| `/heroes/automotive/` | 2 | PXL Images | Solution hero |
| `/graphics/icons/` | 3 | Vector Icons | Feature cards |
| `/graphics/decorative/` | 4 | Graphics | Sections |
| `/technical/seating-maps/` | 11 | Diagrams | Specs |
| `/technical/diagrams/` | 1 | System Diagram | Architecture |

---

**Document Status:** Complete and Ready for Use
**Prepared For:** Manual WordPress Admin Upload
**Last Updated:** January 6, 2026
