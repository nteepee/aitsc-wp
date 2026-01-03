# Phase B1: Image Integration

**Execution Group**: B (Parallel with B2, AFTER Group A)
**Agent Type**: fullstack-developer (with ai-multimodal skill)
**Estimated Time**: 2-3 hours
**File Ownership**: WP Media Library + ACF Image Fields (EXCLUSIVE WRITE)

---

## Objective

Upload 32 existing images from AITSC CONTENT folder to WordPress media library, generate 24 missing images using ai-multimodal skill, and populate ACF image fields for all 8 pages.

---

## Image Inventory Summary

**From image-manifest.json**:
- **Total Images Needed**: 56
- **Existing Images**: 32 (57% coverage)
- **Missing Images**: 24 (43% to generate)

**Breakdown**:
- Hero images: 8 exist ✅
- Gallery images: 13 exist ✅
- Feature images: 8 exist, 16 needed
- Spec diagrams: 3 exist, 5 needed
- CTA backgrounds: 0 exist, 3 needed

---

## Phase B1 Tasks

### Task 1: Upload Existing Images (32 files)

**Method**: WP-CLI batch upload

**Upload Groups**:

#### Group 1: Display Interface Screenshots (8 files)
```bash
cd "/Applications/MAMP/htdocs/aitsc-wp"

# Primary Product
wp media import "ATISC CONTENT/AITSC 2/Photos/800x480-v15---white-red.png" \
  --title="Seat Belt Display Interface Main" \
  --alt="Main display unit showing seat belt status" \
  --post_id=144

# Buses
wp media import "ATISC CONTENT/AITSC 2/Photos/800x480-v15---white-red---4-row.png" \
  --title="Buses Display 4-Row" \
  --alt="Display showing 4-row coach bus configuration" \
  --post_id=146

# Fleet
wp media import "ATISC CONTENT/AITSC 2/Photos/800x480-v15---white-red---right-hand-drive.png" \
  --title="Fleet Display Right-Hand Drive" \
  --alt="Display interface for right-hand drive fleet vehicles" \
  --post_id=147

# Rideshare
wp media import "ATISC CONTENT/AITSC 2/Photos/800x480-v15---white-red---no-last-row.png" \
  --title="Rideshare Display Compact" \
  --alt="Compact 4-seater display for rideshare vehicles" \
  --post_id=149

# Installation
wp media import "ATISC CONTENT/AITSC 2/Diagrams/wiring v3.png" \
  --title="Installation Wiring Diagram" \
  --alt="Complete system wiring schematic" \
  --post_id=145

# Buckle Sensor
wp media import "ATISC CONTENT/AITSC 2/Photos/November BB/Converted by Thinh/16.png" \
  --title="Buckle Sensor Component" \
  --alt="Seatbelt buckle sensor close-up view" \
  --post_id=148

# Seat Sensor
wp media import "ATISC CONTENT/AITSC 2/Photos/November BB/Converted by Thinh/21.png" \
  --title="Seat Sensor Component" \
  --alt="Seat occupancy sensor pressure pad" \
  --post_id=150

# Display Unit
wp media import "ATISC CONTENT/AITSC 2/Photos/800x480-v15---white-red.png" \
  --title="Display Unit Component" \
  --alt="Main display unit interface" \
  --post_id=151
```

#### Group 2: Feature Images (8 files)
```bash
# Primary - 4-Seater Display
wp media import "ATISC CONTENT/AITSC 2/Photos/800x480-v15---white-red-4-seater.png" \
  --title="4-Seater Display Configuration" \
  --alt="Display showing 4-passenger seating layout" \
  --post_id=144

# Buses - Coach Seating
wp media import "ATISC CONTENT/AITSC 2/Photos/coach seating arrangement - small.png" \
  --title="Coach Seating Layout" \
  --alt="Seating arrangement diagram for coach buses" \
  --post_id=146

# Fleet - Hiace Layout
wp media import "ATISC CONTENT/AITSC 2/Photos/Hiace seating arrangement - small.png" \
  --title="Hiace Fleet Seating" \
  --alt="Toyota Hiace fleet vehicle seating configuration" \
  --post_id=147

# Rideshare - 4-Seater
wp media import "ATISC CONTENT/AITSC 2/Photos/800x480-v15---white-red-4-seater.png" \
  --title="Rideshare 4-Passenger Layout" \
  --alt="4-passenger configuration for rideshare vehicles" \
  --post_id=149

# Installation - Component Placement
wp media import "ATISC CONTENT/AITSC 2/Diagrams/PXL_20250626_031747843.png" \
  --title="Component Placement Diagram" \
  --alt="System component installation locations" \
  --post_id=145

# Installation - Steps 1-2
wp media import "ATISC CONTENT/AITSC 2/Photos/November BB/Converted by Thinh/10.png" \
  --title="Installation Step 1" \
  --alt="First step in system installation process" \
  --post_id=145

wp media import "ATISC CONTENT/AITSC 2/Photos/November BB/Converted by Thinh/11.png" \
  --title="Installation Step 2" \
  --alt="Second step in system installation process" \
  --post_id=145

# Buckle Sensor - Close-ups
wp media import "ATISC CONTENT/AITSC 2/Photos/November BB/Converted by Thinh/17.png" \
  --title="Buckle Sensor Close-Up" \
  --alt="Detailed view of buckle sensor mechanism" \
  --post_id=148
```

#### Group 3: Spec Diagrams (3 files)
```bash
# Primary - Wiring Diagram
wp media import "ATISC CONTENT/AITSC 2/Diagrams/wiring v3.png" \
  --title="System Wiring Diagram" \
  --alt="Complete electrical wiring schematic" \
  --post_id=144

# Buses - Seating Diagram
wp media import "ATISC CONTENT/AITSC 2/Photos/coach seating arrangement wide 2-simplified.png" \
  --title="Buses Seating Diagram" \
  --alt="Coach bus seating arrangement wide view" \
  --post_id=146

# Installation - Spec Diagram
wp media import "ATISC CONTENT/AITSC 2/Diagrams/PXL_20250626_031728699.jpg" \
  --title="Installation Specification Diagram" \
  --alt="System installation specifications" \
  --post_id=145
```

#### Group 4: Gallery Images (13 files)
```bash
# Primary Gallery (4 files)
wp media import "ATISC CONTENT/AITSC 2/Photos/1-PXL_20250915_011220751.jpg" \
  --title="Seat Belt System Gallery 1" --post_id=144
wp media import "ATISC CONTENT/AITSC 2/Photos/800x480-v14---white-red---4rows.png" \
  --title="Seat Belt System Gallery 2" --post_id=144
wp media import "ATISC CONTENT/AITSC 2/Photos/800x480-v15---white-red---left-hand-drive---row-5-removed.png" \
  --title="Seat Belt System Gallery 3" --post_id=144
wp media import "ATISC CONTENT/AITSC 2/Diagrams/PXL_20250626_031747843.png" \
  --title="Seat Belt System Gallery 4" --post_id=144

# Buses Gallery (2 files)
wp media import "ATISC CONTENT/AITSC 2/Photos/2-PXL_20250915_010542663.jpg" \
  --title="Buses System Gallery 1" --post_id=146
wp media import "ATISC CONTENT/AITSC 2/Photos/3-PXL_20250915_011201690.jpg" \
  --title="Buses System Gallery 2" --post_id=146

# Fleet Gallery (2 files)
wp media import "ATISC CONTENT/AITSC 2/Photos/4-PXL_20250915_010524962.jpg" \
  --title="Fleet System Gallery 1" --post_id=147
wp media import "ATISC CONTENT/AITSC 2/Photos/5-PXL_20250915_010414735.jpg" \
  --title="Fleet System Gallery 2" --post_id=147

# Rideshare Gallery (2 files)
wp media import "ATISC CONTENT/AITSC 2/Photos/6-PXL_20250915_010407976.jpg" \
  --title="Rideshare System Gallery 1" --post_id=149
wp media import "ATISC CONTENT/AITSC 2/Photos/7-PXL_20250915_010401553.jpg" \
  --title="Rideshare System Gallery 2" --post_id=149

# Installation Gallery (4 files)
wp media import "ATISC CONTENT/AITSC 2/Photos/November BB/Converted by Thinh/12.png" \
  --title="Installation Gallery 1" --post_id=145
wp media import "ATISC CONTENT/AITSC 2/Photos/November BB/Converted by Thinh/13.png" \
  --title="Installation Gallery 2" --post_id=145
wp media import "ATISC CONTENT/AITSC 2/Photos/November BB/Converted by Thinh/14.png" \
  --title="Installation Gallery 3" --post_id=145
wp media import "ATISC CONTENT/AITSC 2/Photos/November BB/Converted by Thinh/15.png" \
  --title="Installation Gallery 4" --post_id=145
```

**Verification After Upload**:
```bash
# Check media library count
wp media list --post_type=attachment --format=count

# Get attachment IDs for ACF field population
wp media list --post_type=attachment --fields=ID,title --format=table
```

---

### Task 2: Generate Missing Images with ai-multimodal (24 files)

**Skill Invocation**: `/ai-multimodal`

**Generation Strategy**:
1. Use Google Gemini Imagen 4 for professional product photography style
2. Match WorldQuant dark theme aesthetic
3. Technical diagrams use clean vector style
4. CTA backgrounds use abstract/atmospheric style

#### Missing Feature Images (16)

**Primary Product (3 missing)**:
```
Prompt 1: "Professional dashboard interface showing real-time vehicle occupancy monitoring. Dark theme with blue accents, data visualization charts, seat status indicators in red/white/black. Modern automotive UI design. Photorealistic, high-tech aesthetic, 16:9 aspect ratio."

Prompt 2: "Alert notification system interface for vehicle safety. Red warning indicators, sound wave visualization, modern dashboard design. Dark background with blue and red accent colors. Clean, professional automotive UI. 16:9 aspect ratio."

Prompt 3: "Close-up of professional bus driver monitoring dashboard display while driving. Focus on hands on steering wheel and dashboard screen. Interior bus lighting, professional transport setting. Photorealistic, shallow depth of field, 16:9 aspect ratio."
```

**Buses (2 missing)**:
```
Prompt 4: "Interior of modern coach bus with passengers seated, visible seat belts. Aisle view showing multiple rows. Natural lighting, professional transport photography. Clean, safe, professional atmosphere. 16:9 aspect ratio, photorealistic."

Prompt 5: "Bus driver dashboard view from driver's seat. Steering wheel, instrument cluster, road ahead through windshield. Professional cockpit photography, coach bus interior. Natural lighting, sharp focus on instruments. 16:9 aspect ratio."
```

**Fleet (2 missing)**:
```
Prompt 6: "Fleet management software dashboard interface. Multiple vehicle cards showing status indicators, compliance metrics, real-time monitoring data. Dark theme with blue and green accents. Modern SaaS design, clean UI. 16:9 aspect ratio."

Prompt 7: "Safety compliance report document on screen. Charts showing seatbelt usage rates, incident reduction statistics, regulatory compliance metrics. Professional business dashboard design. Clean, data-driven layout. 16:9 aspect ratio."
```

**Rideshare (2 missing)**:
```
Prompt 8: "Rideshare driver using smartphone app while in driver's seat. Focus on phone screen showing ride details. Interior car lighting, professional uber/lyft style. Modern sedan interior. Shallow depth of field, 16:9 aspect ratio."

Prompt 9: "Passenger notification screen mockup showing seatbelt reminder. Clean mobile UI design, red warning icon, simple message. Modern app interface design, dark theme. Professional UX design, 16:9 aspect ratio."
```

**Buckle Sensor (1 missing)**:
```
Prompt 10: "Technical CAD drawing of seatbelt buckle sensor component. Isometric view, engineering diagram style. Clean lines, dimensional annotations, professional technical illustration. White background, black line art with blue accents. 16:9 aspect ratio."
```

**Seat Sensor (1 missing)**:
```
Prompt 11: "Wiring schematic diagram for seat occupancy sensor. Circuit diagram showing connections between pressure pad, controller, and display. Professional electrical diagram style. Clean vector illustration, labeled components. White background. 16:9 aspect ratio."
```

**Display Unit (1 missing)**:
```
Prompt 12: "Technical specification diagram of LED display unit. Dimensional drawing showing front and side views, connector locations, mounting points. Engineering blueprint style. Clean technical illustration with measurements. White background. 16:9 aspect ratio."
```

**Installation (0 missing)** ✅

#### Missing Spec Diagrams (5)

**Fleet System Architecture**:
```
Prompt 13: "System architecture diagram showing fleet management structure. Multiple vehicles connected to central monitoring platform. Network topology diagram style. Clean vector illustration, blue and white color scheme. Professional IT infrastructure diagram. 16:9 aspect ratio."
```

**Rideshare Integration Diagram**:
```
Prompt 14: "Integration diagram showing rideshare vehicle system connecting to Uber/Lyft platforms. Data flow arrows, API connections, cloud services. Modern system architecture diagram. Clean vector illustration, professional tech diagram style. 16:9 aspect ratio."
```

**Buckle Sensor Spec**:
```
Prompt 15: "Reuse existing chair-seat-pad.png with annotations. Technical specifications overlay showing sensor placement on seat. Engineering diagram style with labels and measurements."
```

**Seat Sensor Spec**:
```
Prompt 16: "Reuse existing chair-seat-pad.png. Technical diagram showing pressure sensor pad placement under seat cushion. Cross-section view, engineering illustration style with dimensional callouts."
```

**Display Spec**:
```
Prompt 17: "Reuse existing PXL_20250626_031747843.png. Add technical annotations showing display unit dimensions, mounting specifications, and connection points. Engineering diagram style."
```

#### Missing CTA Backgrounds (3)

**Primary Product CTA**:
```
Prompt 18: "Abstract modern bus interior background. Blurred passengers in seats, soft bokeh lighting. Professional transport atmosphere, dark moody lighting with blue accent colors. Cinematic wide shot, atmospheric, 21:9 ultrawide ratio."
```

**Buses/Fleet CTA**:
```
Prompt 19: "Fleet of modern coach buses parked in organized lot. Aerial perspective, professional fleet operations. Clean, organized, corporate aesthetic. Golden hour lighting, atmospheric haze. Cinematic wide shot, 21:9 ultrawide ratio."
```

**Rideshare CTA**:
```
Prompt 20: "Modern sedan interior from rear passenger view. Focus on safety features, clean professional rideshare environment. Soft natural lighting, premium vehicle interior. Shallow depth of field, cinematic, 21:9 ultrawide ratio."
```

**Additional Fallback Images (4)**:
```
Prompt 21: "Professional installer working on vehicle electronics. Hands holding tools, wiring harness visible. Clean workshop environment, professional automotive technician. Natural lighting, close-up shot, 16:9 aspect ratio."

Prompt 22: "Data analytics dashboard showing safety metrics improving over time. Line charts trending upward, green success indicators. Modern SaaS interface design, dark theme. Professional business intelligence visualization. 16:9 aspect ratio."

Prompt 23: "Seatbelt buckle mechanism close-up. Metallic finish, precise engineering details. Isolated on dark gradient background. Product photography style, studio lighting, sharp focus. 16:9 aspect ratio."

Prompt 24: "Vehicle safety compliance certificate or badge. Professional certification emblem design, trust symbols, regulatory approval marks. Clean modern design, blue and white colors. Corporate graphic design style. 16:9 aspect ratio."
```

---

### Task 3: Populate ACF Image Fields

**After Upload + Generation**, populate ACF fields:

**ACF Field Structure**:
- `hero_section['background_image']` - Hero background
- `gallery` (repeater) - Multiple images
- `features` (repeater) - Each feature may have image
- `specs_diagram` - Technical diagram
- `cta_background` - CTA section background

**Population Script** (PHP):
```php
<?php
require_once('wp-load.php');

// Get attachment ID by title
function get_attachment_id_by_title($title) {
    $query = new WP_Query(array(
        'post_type' => 'attachment',
        'title' => $title,
        'posts_per_page' => 1,
        'fields' => 'ids'
    ));
    return $query->posts[0] ?? null;
}

// Page ID 144 - Primary Product
$primary_gallery = array(
    get_attachment_id_by_title('Seat Belt System Gallery 1'),
    get_attachment_id_by_title('Seat Belt System Gallery 2'),
    get_attachment_id_by_title('Seat Belt System Gallery 3'),
    get_attachment_id_by_title('Seat Belt System Gallery 4'),
);
update_field('gallery', $primary_gallery, 144);

// Repeat for all 8 pages...
// Page 146, 147, 149, 145, 148, 150, 151

echo "ACF image fields populated successfully!\n";
?>
```

**Alternative WP-CLI Method**:
```bash
# Get attachment IDs
PRIMARY_HERO=$(wp media list --title="Seat Belt Display Interface Main" --field=ID)

# Update ACF field
wp post meta update 144 hero_section_background_image $PRIMARY_HERO
```

---

## Validation Checklist

**Per Page**:
- [ ] Hero image displays correctly (no broken URLs)
- [ ] Gallery has 2-4 images minimum
- [ ] Feature images (if used) display in feature grid
- [ ] Spec diagram visible in specs section
- [ ] CTA background image loaded (no white gaps)
- [ ] All images have proper alt text
- [ ] Images optimized for web (not >500KB)

**Overall**:
- [ ] 32 existing images uploaded to media library
- [ ] 24 new images generated and uploaded
- [ ] All ACF image fields populated
- [ ] No 404 errors on any page
- [ ] Images responsive at all breakpoints
- [ ] No layout breaks from images

---

## File Ownership Rules

**EXCLUSIVE WRITE ACCESS**:
- ✅ WP Media Library (upload new images)
- ✅ ACF Image Fields (`gallery`, `hero_section`, `specs_diagram`, etc.)

**READ ONLY** (owned by A1):
- ❌ ACF Content Fields (`problem_cards`, `solution_overview`, `features`)

**READ ONLY** (owned by A2):
- ❌ Template files (`single-solutions.php`)

**READ ONLY** (owned by B2):
- ❌ Component CSS files

---

## Error Handling

**If WP-CLI Upload Fails**:
```bash
# Check file exists
ls -la "ATISC CONTENT/AITSC 2/Photos/800x480-v15---white-red.png"

# Try manual upload via WordPress admin
# Or use wp media regenerate command
```

**If Image Generation Fails**:
- Use Unsplash fallback URLs
- Reuse existing similar images
- Create placeholder with text overlay

**If ACF Fields Don't Exist**:
```php
// Check if field exists
$field = get_field_object('gallery', 144);
if (!$field) {
    error_log('Gallery field not registered for post 144');
}
```

---

## Deliverables

1. 32 existing images uploaded to WP media library
2. 24 generated images uploaded
3. All ACF image fields populated for 8 pages
4. Verification screenshots (before/after)
5. Report: `reports/fullstack-dev-260104-image-integration.md`

**Report Should Include**:
- Upload success rate (X/32 existing)
- Generation success rate (X/24 generated)
- ACF field population status
- Any fallback images used
- Image optimization metrics
- Issues encountered and solutions

---

**EXCLUSIVE FILE OWNERSHIP**: Media Library + ACF Image Fields ONLY
**DO NOT EDIT**: Content Fields, Templates, CSS
**RUN in parallel with Phase B2**
