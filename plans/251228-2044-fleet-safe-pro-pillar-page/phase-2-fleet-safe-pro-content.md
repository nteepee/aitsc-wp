# Phase 2: Fleet Safe Pro Content Population

**Phase ID**: phase-2-fleet-safe-pro-content
**Status**: READY
**Priority**: HIGH
**Estimated Time**: 2 hours

---

## Content Source

**Extracted From**: `/Applications/MAMP/htdocs/aitsc-wp/extraction/fleet-safe-pro-sections.md`
**Manual Photos**: `/Applications/MAMP/htdocs/aitsc-wp/wp-content/themes/aitsc-pro-theme/assets/images/fleet-safe-pro/gallery/` (58 photos)
**Manual Graphics**: `/Applications/MAMP/htdocs/aitsc-wp/extraction/fleet-safe-pro-manual/` (62 images)

---

## ACF Fields to Populate

### 1. Hero Section
```php
Field Group: hero_section
Post ID: 115 (Fleet Safe Pro)
```

**Content**:
```
Title: "Fleet Safe Pro Passenger Monitoring System"
Subtitle: "Real-time seat belt detection system that installs easily with seamless hardware integration and smart alerts."
CTA Text: "Request a Demo"
CTA Link: "#hubspot-form"
Image: img-001.png (Main display UI - 668K)
```

### 2. Overview Section
```php
Field: overview_text (WYSIWYG)
```

**Content**:
```html
<h2>Complete Passenger Safety Solution for Transport Fleets</h2>

<p>Fleet Safe Pro monitors seat occupancy, seatbelt status, and door state in real-time on passenger transport vehicles. Designed specifically for Bus4x4 and commercial fleet operators, it provides accurate audible and visual alerts when passengers are unbuckled or doors are open.</p>

<p>Smart algorithms enable automatic recognition of vehicle layout changes and sensor configurations, supporting true plug-and-play installation with zero programming required. The system displays buckled, unbuckled, and idle seats with color-coded indicators (red, white, or black), and the vehicle outline turns red if any passenger is unbuckled or the door is open.</p>

<p><strong>Supports 4-row and 7-row configurations, left-hand and right-hand drive vehicles</strong>. Installation involves placing sensors, connecting them to modules, and linking to the display—no complex setup or configuration needed.</p>
```

### 3. Features Section
```php
Field: features (repeater)
```

**9 Features** (from manual):

#### Feature 1
- **Title**: "Real-Time Seat Occupancy Monitoring"
- **Description**: "Detects passenger presence instantly using pressure-sensitive seat sensor pads placed under each monitored seat."
- **Icon**: "🪑"

#### Feature 2
- **Title**: "Seatbelt Status Detection"
- **Description**: "Specialized buckle sensors detect whether seatbelts are fastened, providing instant visual and audible alerts for unbuckled passengers."
- **Icon**: "🔒"

#### Feature 3
- **Title**: "Door State Monitoring"
- **Description**: "Real-time door monitoring ensures vehicle safety by alerting when doors are open during operation."
- **Icon**: "🚪"

#### Feature 4
- **Title**: "Plug-and-Play Installation"
- **Description**: "No programming or complex setup required. Smart algorithms automatically recognize vehicle layout and sensor configurations for seamless installation."
- **Icon**: "🔌"

#### Feature 5
- **Title**: "Visual & Audible Alerts"
- **Description**: "Color-coded seat indicators (red=unbuckled, white=buckled, black=idle) with audible alerts ensure drivers are immediately notified of non-compliance."
- **Icon**: "🔔"

#### Feature 6
- **Title**: "Multi-Row Support"
- **Description**: "Supports both 4-row and 7-row vehicle configurations with modular row modules that connect seamlessly together."
- **Icon**: "📊"

#### Feature 7
- **Title**: "Left & Right-Hand Drive Compatible"
- **Description**: "Flexible configuration supports both left-hand and right-hand drive vehicles without hardware changes."
- **Icon**: "🚗"

#### Feature 8
- **Title**: "Modular Design for Easy Maintenance"
- **Description**: "Replace only faulty components, not the entire system. Reduces maintenance costs and minimizes downtime."
- **Icon**: "🔧"

#### Feature 9
- **Title**: "Bus4x4 Custom Solution"
- **Description**: "Custom-designed technology solution specifically addressing Bus4x4's unique operational requirements for passenger transport safety."
- **Icon**: "🎯"

### 4. Specifications Section
```php
Field: specs (repeater)
```

**Technical Specifications**:

#### Hardware Specs
- **Spec Label**: "Seat Sensor", **Value**: "Pressure-sensitive pad, installed under each monitored seat"
- **Spec Label**: "Buckle Sensor", **Value**: "Integrated seatbelt buckle with detection sensor"
- **Spec Label**: "Row Module", **Value**: "Per-row controller unit with sensor connections"
- **Spec Label**: "Display Unit", **Value**: "800x480 color display with vehicle outline visualization"
- **Spec Label**: "Supported Rows", **Value**: "4-row or 7-row configurations"
- **Spec Label**: "Drive Configuration", **Value**: "Left-hand drive and right-hand drive compatible"

#### System Specs
- **Spec Label**: "Installation", **Value**: "Plug-and-play, no programming required"
- **Spec Label**: "Alert Types", **Value**: "Visual (color-coded) + Audible alerts"
- **Spec Label**: "Auto-Configuration", **Value**: "Smart algorithms detect layout automatically"
- **Spec Label**: "Indicator Colors", **Value**: "Red (unbuckled), White (buckled), Black (idle)"
- **Spec Label**: "Maintenance", **Value**: "Modular component replacement"
- **Spec Label**: "Target Application", **Value**: "Passenger transport vehicles, commercial fleets"

### 5. Gallery Section
```php
Field: gallery_images (gallery)
```

**Images to Upload** (Top 15 photos + 5 manual graphics):

**Photos** (from `/wp-content/themes/aitsc-pro-theme/assets/images/fleet-safe-pro/gallery/`):
1. Display unit installed view
2. Dashboard mounting example
3. Seat sensor installation
4. Buckle sensor closeup
5. Row module mounting
6. Wiring example
7. Complete system view
8. Red alert state screen
9. White buckled state screen
10. 4-row configuration
11. 7-row configuration
12. Component array
13. Installation process
14. Driver view
15. Fleet vehicle installation

**Manual Graphics** (from extraction folder):
1. img-001.png - Main display UI
2. img-002.png - System diagram
3. img-003.png - Seating configuration
4. img-006.png - Installation diagram
5. img-008.png - Component illustration

### 6. Case Studies Section
```php
Field: related_case_studies (relationship)
```

**Content**: Link to Bus4x4 case study post (create if doesn't exist)

### 7. CTA Section
```php
Field: cta (group)
```

**Content**:
```
CTA Title: "Ready to Enhance Your Fleet Safety?"
CTA Description: "<p>Join Bus4x4 and other leading transport operators who trust Fleet Safe Pro for passenger safety compliance. Request a demo and see how our plug-and-play system can transform your fleet operations.</p>"
CTA Button Text: "Request a Demo"
CTA Button Link: "#hubspot-form"
```

---

## Implementation Method

**Use WP-CLI to populate ACF fields**:

```bash
# Hero Section
wp post meta update 115 hero_section '{"title":"Fleet Safe Pro Passenger Monitoring System","subtitle":"Real-time seat belt detection system that installs easily with seamless hardware integration and smart alerts.","cta_text":"Request a Demo","cta_link":"#hubspot-form","image":"URL_TO_IMG_001"}'

# Overview
wp post meta update 115 overview_text '<h2>Complete Passenger Safety Solution...</h2>...'

# Features (repeat for each feature)
wp post meta update 115 features_0_feature_title "Real-Time Seat Occupancy Monitoring"
wp post meta update 115 features_0_feature_description "Detects passenger presence..."
wp post meta update 115 features_0_feature_icon "🪑"
...

# Specs (repeat for each spec)
wp post meta update 115 specs_0_spec_label "Seat Sensor"
wp post meta update 115 specs_0_spec_value "Pressure-sensitive pad..."
...
```

**Or use WordPress admin interface** to populate all fields manually.

---

## HubSpot Form Integration

**Location**: CTA section at bottom of page
**Form Embed Code** (placeholder):

```html
<!--[if lte IE 8]>
<script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2-legacy.js"></script>
<![endif]-->
<script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>
<script>
  hbspt.forms.create({
    region: "na1",
    portalId: "YOUR_PORTAL_ID",
    formId: "YOUR_FORM_ID"
  });
</script>
```

**Action**: User must provide HubSpot Portal ID and Form ID, or create form in HubSpot first.

---

## Success Criteria

✅ All ACF fields populated with real content from manual
✅ Hero section shows main display UI image
✅ 9 features listed with descriptions
✅ 12 technical specifications displayed
✅ Gallery shows 15-20 images (photos + graphics)
✅ HubSpot form embedded in CTA section
✅ No placeholder or dummy content
✅ All images optimized and loading correctly

---

## Next Steps

1. Upload images to WordPress media library
2. Get image URLs
3. Populate ACF fields via admin or WP-CLI
4. Test page rendering
5. Verify all sections display correctly
