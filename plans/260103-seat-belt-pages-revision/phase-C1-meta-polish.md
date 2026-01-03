# Phase C1: Meta Tags & Final Polish

**Execution Group**: C (Sequential, AFTER Groups A + B)
**Agent Type**: fullstack-developer
**Estimated Time**: 1 hour
**File Ownership**: SEO Fields + header.php (EXCLUSIVE WRITE)

---

## Objective

Add SEO-optimized meta descriptions for all 8 pages, update header.php to output meta tags, perform final visual QA, and generate completion screenshots.

---

## SEO Meta Description Strategy

### Requirements
- **Length**: 150-160 characters (optimal for Google SERPs)
- **Content**: Include primary keyword, value proposition, CTA
- **Tone**: Professional, benefit-focused, action-oriented
- **Format**: Sentence case, no hashtags, ends with period

### Primary Keywords by Page
1. **Seat Belt Detection System**: "seat belt detection", "passenger monitoring"
2. **Buses**: "bus seatbelt compliance", "coach safety"
3. **Fleet**: "fleet safety compliance", "vehicle monitoring"
4. **Rideshare**: "rideshare safety", "uber lyft seatbelt"
5. **Installation**: "seat belt system installation", "plug and play"
6. **Buckle Sensor**: "seatbelt buckle sensor", "detection sensor"
7. **Seat Sensor**: "seat occupancy sensor", "pressure pad"
8. **Display Unit**: "safety display unit", "alert interface"

---

## Task 1: Create ACF SEO Field

**If field doesn't exist**, add to ACF configuration:

```php
<?php
// File: inc/acf-seo-fields.php (create if not exists)

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'group_seo_meta',
        'title' => 'SEO Meta Tags',
        'fields' => array(
            array(
                'key' => 'field_seo_meta_description',
                'label' => 'Meta Description',
                'name' => 'seo_meta_description',
                'type' => 'textarea',
                'instructions' => 'SEO meta description (150-160 characters). Appears in search results.',
                'required' => 0,
                'maxlength' => 160,
                'rows' => 3,
            ),
            array(
                'key' => 'field_seo_og_image',
                'label' => 'Open Graph Image',
                'name' => 'seo_og_image',
                'type' => 'image',
                'instructions' => 'Image for social media sharing (1200x630px recommended)',
                'return_format' => 'url',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'solutions',
                ),
            ),
        ),
    ));
}
```

**Register in functions.php**:
```php
require_once get_template_directory() . '/inc/acf-seo-fields.php';
```

---

## Task 2: Write Meta Descriptions (All 8 Pages)

### Page ID 144: Seat Belt Detection System
```
Real-time seat belt detection for buses and fleet vehicles. Automatic alerts, plug-and-play installation, zero programming. Ensure passenger safety compliance. Get a free demo today.
```
**Character Count**: 159 ✅

### Page ID 146: Seatbelt Alert System for Buses
```
Bus seatbelt compliance made simple. Instant alerts for 4-7 row coaches. Reduce liability, pass audits, protect passengers. Trusted by Australian transport operators. Learn more.
```
**Character Count**: 160 ✅

### Page ID 147: Fleet Seatbelt Compliance
```
Standardize fleet safety compliance across all vehicles. Automated monitoring, audit-ready reports, insurance savings. Manage 5-500 vehicles with one unified system. Request quote.
```
**Character Count**: 159 ✅

### Page ID 149: Rideshare Seatbelt Monitoring
```
Protect your rideshare ratings with passenger safety monitoring. Instant unbuckle alerts for Uber, Lyft drivers. Reduce liability, increase earnings. Professional safety system.
```
**Character Count**: 160 ✅

### Page ID 145: Seat Belt Installation Guide
```
Plug-and-play seat belt system installation guide. No programming required. Step-by-step wiring, sensor placement, testing. Install in hours, not days. Download installation manual.
```
**Character Count**: 160 ✅

### Page ID 148: Buckle Sensor Component
```
Durable seatbelt buckle sensor with instant detection. Replace individual sensors, not entire systems. 12-month warranty. Australian Consumer Law protected. Order replacement parts.
```
**Character Count**: 160 ✅

### Page ID 150: Seat Sensor Component
```
Seat occupancy pressure sensor for passenger detection. Plug-and-play replacement component. Works with 4-7 row configurations. Fast shipping Australia-wide. Order sensors today.
```
**Character Count**: 158 ✅

### Page ID 151: Display Unit Component
```
LED display unit with visual and audible alerts. Color-coded seat status (red, white, black). Easy installation, clear visibility. 12-month warranty coverage. Replace display unit.
```
**Character Count**: 160 ✅

---

## Task 3: Populate Meta Descriptions

**Method 1: WP-CLI**
```bash
# Page 144 - Primary Product
wp post meta update 144 seo_meta_description "Real-time seat belt detection for buses and fleet vehicles. Automatic alerts, plug-and-play installation, zero programming. Ensure passenger safety compliance. Get a free demo today."

# Page 146 - Buses
wp post meta update 146 seo_meta_description "Bus seatbelt compliance made simple. Instant alerts for 4-7 row coaches. Reduce liability, pass audits, protect passengers. Trusted by Australian transport operators. Learn more."

# Page 147 - Fleet
wp post meta update 147 seo_meta_description "Standardize fleet safety compliance across all vehicles. Automated monitoring, audit-ready reports, insurance savings. Manage 5-500 vehicles with one unified system. Request quote."

# Page 149 - Rideshare
wp post meta update 149 seo_meta_description "Protect your rideshare ratings with passenger safety monitoring. Instant unbuckle alerts for Uber, Lyft drivers. Reduce liability, increase earnings. Professional safety system."

# Page 145 - Installation
wp post meta update 145 seo_meta_description "Plug-and-play seat belt system installation guide. No programming required. Step-by-step wiring, sensor placement, testing. Install in hours, not days. Download installation manual."

# Page 148 - Buckle Sensor
wp post meta update 148 seo_meta_description "Durable seatbelt buckle sensor with instant detection. Replace individual sensors, not entire systems. 12-month warranty. Australian Consumer Law protected. Order replacement parts."

# Page 150 - Seat Sensor
wp post meta update 150 seo_meta_description "Seat occupancy pressure sensor for passenger detection. Plug-and-play replacement component. Works with 4-7 row configurations. Fast shipping Australia-wide. Order sensors today."

# Page 151 - Display Unit
wp post meta update 151 seo_meta_description "LED display unit with visual and audible alerts. Color-coded seat status (red, white, black). Easy installation, clear visibility. 12-month warranty coverage. Replace display unit."
```

**Method 2: PHP Script** (if WP-CLI fails)
```php
<?php
require_once('wp-load.php');

$meta_descriptions = array(
    144 => "Real-time seat belt detection for buses and fleet vehicles. Automatic alerts, plug-and-play installation, zero programming. Ensure passenger safety compliance. Get a free demo today.",
    146 => "Bus seatbelt compliance made simple. Instant alerts for 4-7 row coaches. Reduce liability, pass audits, protect passengers. Trusted by Australian transport operators. Learn more.",
    147 => "Standardize fleet safety compliance across all vehicles. Automated monitoring, audit-ready reports, insurance savings. Manage 5-500 vehicles with one unified system. Request quote.",
    149 => "Protect your rideshare ratings with passenger safety monitoring. Instant unbuckle alerts for Uber, Lyft drivers. Reduce liability, increase earnings. Professional safety system.",
    145 => "Plug-and-play seat belt system installation guide. No programming required. Step-by-step wiring, sensor placement, testing. Install in hours, not days. Download installation manual.",
    148 => "Durable seatbelt buckle sensor with instant detection. Replace individual sensors, not entire systems. 12-month warranty. Australian Consumer Law protected. Order replacement parts.",
    150 => "Seat occupancy pressure sensor for passenger detection. Plug-and-play replacement component. Works with 4-7 row configurations. Fast shipping Australia-wide. Order sensors today.",
    151 => "LED display unit with visual and audible alerts. Color-coded seat status (red, white, black). Easy installation, clear visibility. 12-month warranty coverage. Replace display unit.",
);

foreach ($meta_descriptions as $post_id => $description) {
    update_field('seo_meta_description', $description, $post_id);
    echo "Updated meta description for post $post_id\n";
}

echo "All meta descriptions populated successfully!\n";
?>
```

**Verify**:
```bash
wp post meta get 144 seo_meta_description
wp post meta get 146 seo_meta_description
# ... verify all 8
```

---

## Task 4: Update header.php to Output Meta Tags

**Location**: `wp-content/themes/aitsc-pro-theme/header.php`

**Find the `<head>` section** (around line 10-30) and add:

```php
<?php
/**
 * Output SEO meta tags
 */
if (is_singular('solutions')) {
    $post_id = get_the_ID();

    // Meta Description
    $meta_desc = get_field('seo_meta_description', $post_id);
    if (empty($meta_desc)) {
        $meta_desc = get_the_excerpt($post_id);
        if (empty($meta_desc)) {
            $meta_desc = wp_trim_words(get_the_content(null, false, $post_id), 25, '...');
        }
    }

    // Open Graph Image
    $og_image = get_field('seo_og_image', $post_id);
    if (empty($og_image)) {
        $og_image = get_the_post_thumbnail_url($post_id, 'large');
    }
    if (empty($og_image)) {
        $og_image = get_template_directory_uri() . '/assets/images/default-og-image.jpg';
    }

    // Output meta tags
    if (!empty($meta_desc)) {
        echo '<meta name="description" content="' . esc_attr($meta_desc) . '">' . "\n";
    }

    // Open Graph tags
    echo '<meta property="og:type" content="article">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
    if (!empty($meta_desc)) {
        echo '<meta property="og:description" content="' . esc_attr($meta_desc) . '">' . "\n";
    }
    if (!empty($og_image)) {
        echo '<meta property="og:image" content="' . esc_url($og_image) . '">' . "\n";
    }
    echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";

    // Twitter Card tags
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
    if (!empty($meta_desc)) {
        echo '<meta name="twitter:description" content="' . esc_attr($meta_desc) . '">' . "\n";
    }
    if (!empty($og_image)) {
        echo '<meta name="twitter:image" content="' . esc_url($og_image) . '">' . "\n";
    }
}
?>
```

**Verify Meta Tags**:
```bash
# View source of page
curl http://localhost:8888/solutions/seat-belt-detection-system/ | grep -A 5 'meta name="description"'

# Or open in browser, right-click > View Page Source
# Search for <meta name="description"
```

---

## Task 5: Final Visual QA

**QA Checklist Per Page**:
- [ ] Hero section displays correctly (title, subtitle, CTA)
- [ ] Problem cards grid (4 cards, animated on scroll)
- [ ] Solution overview with highlight box
- [ ] Features grid (10 benefit-focused features)
- [ ] Technical specifications section
- [ ] Installation guide (if applicable)
- [ ] Gallery images (2-4 images minimum)
- [ ] Related pages navigation (shows 6 related posts)
- [ ] CTA section (with background image)
- [ ] No PHP errors in console
- [ ] No JS errors in console
- [ ] No broken images (404)
- [ ] No layout overflow (horizontal scroll)
- [ ] Animations smooth (scroll-triggered fade-in)

**Browser Console Checks**:
```javascript
// Open DevTools > Console
// Look for:
// ✅ No PHP warnings/errors
// ✅ No JavaScript errors
// ✅ Intersection Observer initialized
// ✅ ACF fields loaded

// Check network tab
// ✅ All images return 200
// ✅ CSS/JS files load
// ✅ No 404 errors
```

---

## Task 6: Generate Completion Screenshots

**Screenshot All 8 Pages** (Desktop 1200px viewport):

```bash
mkdir -p docs/screenshots/seat-belt-pages-260104

# Use Claude with Chrome or manual screenshots
# Save as:
# - seat-belt-detection-system-complete.png
# - seatbelt-alert-buses-complete.png
# - fleet-seatbelt-compliance-complete.png
# - rideshare-monitoring-complete.png
# - installation-guide-complete.png
# - buckle-sensor-complete.png
# - seat-sensor-complete.png
# - display-unit-complete.png
```

**Screenshot Naming Convention**:
```
{page-slug}-complete.png (full page)
{page-slug}-hero.png (hero section only)
{page-slug}-problem-cards.png (problem-solution section)
{page-slug}-related.png (related pages section)
```

---

## Task 7: SEO Validation

**Test with SEO Tools**:

### Google Search Console Preview
```
Title: Seat Belt Detection System | AITSC
Description: Real-time seat belt detection for buses and fleet vehicles...
URL: https://aitsc.com.au/solutions/seat-belt-detection-system/
```

### Yoast SEO (if plugin installed)
```bash
# Check SEO score
# ✅ Meta description length: 150-160 chars
# ✅ Focus keyword in description
# ✅ Title tag optimized
# ✅ URL slug optimized
# ✅ Images have alt text
# ✅ Readability score: Good
```

### Open Graph Preview
Test with: https://www.opengraph.xyz/
- Paste page URL
- Verify OG image displays
- Verify title and description correct

---

## Task 8: Performance Check

**Google Lighthouse Audit** (Desktop + Mobile):
```bash
# Run Lighthouse audit
# Target scores:
# - Performance: ≥90
# - Accessibility: ≥95
# - Best Practices: ≥90
# - SEO: ≥95
```

**Key Metrics**:
- First Contentful Paint: <1.5s
- Largest Contentful Paint: <2.5s
- Cumulative Layout Shift: <0.1
- Time to Interactive: <3.0s

**If Performance Low**:
- Optimize images (WebP format, lazy load)
- Minify CSS/JS
- Reduce particle animation density
- Enable caching

---

## Task 9: Cross-Browser Testing

**Quick Test** (if time permits):
- ✅ Chrome (primary)
- ✅ Safari (Mac/iOS)
- ⚠️ Firefox
- ⚠️ Edge

**Issues to Look For**:
- CSS Grid compatibility
- Intersection Observer polyfill needed
- 3D transforms performance
- Video/animation autoplay

---

## Final Deliverables Checklist

**Content** (from Phase A1):
- [ ] 8 pages have 4-problem cards each
- [ ] 8 pages have solution overview + highlight
- [ ] 8 pages have 10 benefit-focused features
- [ ] CTAs use urgency language

**Design** (from Phase A2):
- [ ] Problem-Solution component integrated
- [ ] Related Pages navigation integrated
- [ ] Visual consistency across pages

**Images** (from Phase B1):
- [ ] 32 existing images uploaded
- [ ] 24 generated images created
- [ ] All ACF image fields populated

**Responsive** (from Phase B2):
- [ ] Mobile (375px) tested
- [ ] Tablet (768px) tested
- [ ] Desktop (1200px) tested
- [ ] No layout errors at any breakpoint

**SEO** (Phase C1):
- [ ] 8 meta descriptions written (150-160 chars)
- [ ] header.php outputs meta tags
- [ ] Open Graph images set
- [ ] Twitter Card tags added

**Quality**:
- [ ] No PHP/JS errors
- [ ] No broken images (404)
- [ ] Animations smooth (60fps)
- [ ] Page load <3s
- [ ] Lighthouse SEO ≥95

---

## File Ownership Rules

**EXCLUSIVE WRITE ACCESS**:
- ✅ ACF SEO fields (`seo_meta_description`, `seo_og_image`)
- ✅ `header.php` (add meta tag output)
- ✅ `inc/acf-seo-fields.php` (new file)

**READ ONLY** (all other phases):
- ❌ ACF Content Fields (Phase A1)
- ❌ Template files (Phase A2)
- ❌ Media Library (Phase B1)
- ❌ Component CSS (Phase B2)

---

## Error Handling

**If ACF Field Creation Fails**:
```php
// Use WordPress post meta directly
update_post_meta(144, '_seo_meta_description', $description);
get_post_meta(144, '_seo_meta_description', true);
```

**If header.php Modification Breaks Site**:
- Revert changes via git
- Test meta tag code in test environment first
- Use PHP linter: `php -l header.php`

**If Meta Tags Don't Appear**:
```bash
# Clear cache
wp cache flush

# Check if meta output is conditional
# Verify is_singular('solutions') returns true
```

---

## Completion Report

**File**: `reports/fullstack-dev-260104-meta-polish.md`

**Report Should Include**:
1. All 8 meta descriptions (with character counts)
2. header.php code changes
3. Validation results (view source screenshots)
4. Final QA screenshots (8 pages × desktop view)
5. Lighthouse scores (desktop + mobile)
6. Issues found and fixed
7. Overall project completion summary

---

**EXCLUSIVE FILE OWNERSHIP**: SEO Fields + header.php ONLY
**DO NOT EDIT**: Content, Templates, Images, Component CSS
**RUN AFTER Groups A + B complete**
