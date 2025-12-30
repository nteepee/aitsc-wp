# Phase 3: Content Extraction & Fleet Safe Pro Integration

**Status**: Ready for Implementation (After Phase 2)
**Estimated Effort**: 20 hours (11 hours planned + 9 hours content extraction)
**Priority**: P0 - CRITICAL (Content extraction is HIGH PRIORITY)
**Dependencies**: Phase 2 Complete (Universal Components)

---

## ⚠️ ANTI-HALLUCINATION PROTOCOL - MANDATORY FOR THIS PHASE

**This phase requires CRITICAL content extraction from PDFs, DOCX, and images.**

**Based on**: "Building a Self-Awareness System for AI" (76% hallucination reduction using 7-point checklist)

**MANDATORY**: Follow self-awareness system from main plan.md:

### 7-Point Checklist (Before ANY Extraction Claim)

| # | Question | Check Before Claiming |
|---|----------|----------------------|
| 1 | **Did I verify what I claim?** | ✅ Read extraction output, confirmed content |
| 2 | **Is response concise?** | ✅ No verbosity compensation (no fluff) |
| 3 | **Uncertainty expressed?** | ✅ "Extracted X appears to be" not "Definitely is" |
| 4 | **Used actual source?** | ✅ Read PDF/DOCX directly, not from memory |
| 5 | **Reproducible?** | ✅ File paths, commands provided |
| 6 | **Double-checked?** | ✅ Verified with 2 different methods |
| 7 | **Error consideration?** | ✅ Noted gaps, provided manual spot-check results |

**If ANY fail** → STOP → RE-EXTRACT → RE-VERIFY

### For ALL Content Extraction:

1. **Extract content** using tool (pdftotext, pandoc, etc.)
2. **Verify extraction** by reading output
3. **Cross-check** with different method or manual spot-check
4. **Validate** key sections match source
5. **Document** extraction method and results

### For ALL Visual Claims:

1. **Take screenshot** of rendered page
2. **Read screenshot** to verify what's actually displayed
3. **Take second screenshot** for confirmation
4. **Compare** both screenshots match
5. **Report with evidence** (screenshot paths)

### For ALL Code Implementation:

1. **Write code** using Edit/Write tool
2. **Verify write** with ls + Read tool
3. **Cross-check** syntax and content
4. **Test functionality** (render if applicable)
5. **Visual verification** with screenshot

**Any failure in verification → STOP → INVESTIGATE → CORRECT → RE-VERIFY**

---

## 🎯 CRITICAL PRIORITY: Content Extraction from AITSC CONTENT Folder

**User Requirement**: *"The font in the manual, the graphics is what crucial to show for the fleet product"*

Content extraction from source documents is **HIGHEST PRIORITY**. Must preserve:
- ✅ **Fonts** from Fleet Safe Pro Manual.pdf (typography, headings, body text)
- ✅ **Graphics** from manual (diagrams, layouts, product images)
- ✅ **Layout** structure and visual hierarchy
- ✅ **Authentic product presentation** (not generic stock photos)

**EXTRACTION MUST BE VERIFIED TWICE BEFORE USE**

---

## Phase 3 Structure

### Part A: Content Extraction (9 hours) - **DO THIS FIRST**
1. Extract Fleet Safe Pro Manual.pdf content
2. Extract Case Studies from Case edits.docx
3. Select and optimize product photos
4. Map graphics to sections

### Part B: Page Building (11 hours) - **USE EXTRACTED CONTENT**
5. Build Fleet Safe Pro pillar page
6. Build category pages
7. Create sample blog posts

---

## PART A: CONTENT EXTRACTION (9 HOURS) - PRIORITY WORK

### Task 1: Extract Fleet Safe Pro Manual.pdf (4 hours)

**Source File**: `/Applications/MAMP/htdocs/aitsc-wp/AITSC CONTENT/AITSC 2/Fleet Safe Pro Manual.pdf` (6.7MB)

**Objective**: Extract ALL content preserving fonts, graphics, and layout hierarchy

#### Step 1.1: Extract Text Content with Structure

**Tools**:
- `pdftotext` (preserves layout): `pdftotext -layout "Fleet Safe Pro Manual.pdf" manual-text.txt`
- OR use Read tool to view PDF page by page
- OR `pdftohtml` for HTML conversion with images

**Extract Sections**:
```
Manual Structure (Expected):
1. Cover Page → Extract title, tagline
2. Table of Contents → Map sections
3. Product Overview → Extract hero messaging
4. Key Features → Extract feature list with icons/diagrams
5. Technical Specifications → Extract specs table
6. Installation Guide → Extract diagrams and steps
7. Display UI Documentation → Extract UI screenshots and descriptions
8. Compliance & Safety → Extract regulatory information
9. Troubleshooting → Extract common issues
10. Contact & Support → Extract support info
```

**Content Mapping**:
| Manual Section | Pillar Page Section | Priority |
|----------------|---------------------|----------|
| Cover + Product Overview | Hero Section 1 | P0 |
| Problem Statement (if exists) | Problem Definition Section 2 | P0 |
| Key Features | Features Section 4 | P0 |
| Technical Specifications | Technical Specs Section 5 | P0 |
| Installation Guide | N/A (optional download) | P2 |
| Display UI Screenshots | Visual Gallery Section 6 | P0 |
| Compliance | Industries/Compliance Section 9 | P1 |

**Deliverables**:
- `extraction/fleet-safe-pro-manual-text.txt` - Plain text extraction
- `extraction/fleet-safe-pro-sections.md` - Structured content by section
- `extraction/fonts-used.txt` - Font families identified (for matching)

#### Step 1.2: Extract Graphics & Diagrams (CRUCIAL)

**Objective**: Extract all images, diagrams, and visual assets from PDF

**Tools**:
- `pdfimages` (extract all images): `pdfimages -all "Fleet Safe Pro Manual.pdf" manual-images/img`
- OR `pdftoppm` (convert pages to images): `pdftoppm -png "Fleet Safe Pro Manual.pdf" manual-pages/page`
- OR use PDF reader to export images manually

**Expected Assets**:
```
Manual Graphics (Expected):
1. Product photos (hardware, installed systems)
2. Display UI screenshots (800x480 interface)
3. Wiring diagrams (connection schematics)
4. Feature icons/illustrations
5. Seating configuration diagrams
6. Installation flow diagrams
7. Compliance badges/logos (if any)
8. Before/After examples (if any)
```

**Extraction Process**:
```bash
# Create extraction directory
mkdir -p /Applications/MAMP/htdocs/aitsc-wp/extraction/fleet-safe-pro-manual/

# Extract images using pdfimages
pdfimages -all "Fleet Safe Pro Manual.pdf" extraction/fleet-safe-pro-manual/img

# OR convert each page to PNG for screenshot
pdftoppm -png -r 150 "Fleet Safe Pro Manual.pdf" extraction/fleet-safe-pro-manual/page

# Review extracted images
ls -lh extraction/fleet-safe-pro-manual/
```

**Deliverables**:
- `extraction/fleet-safe-pro-manual/` directory with all graphics
- `extraction/graphics-manifest.md` - List of all extracted graphics with usage notes

#### Step 1.3: Identify and Match Fonts (CRUCIAL)

**Objective**: Identify fonts used in manual to replicate typography on website

**Process**:
1. Open PDF in Adobe Reader/Preview
2. View Document Properties → Fonts tab
3. Note all font families used
4. Find web-safe alternatives or Google Fonts matches

**Expected Fonts** (typical technical documentation):
- Headings: Arial Bold, Helvetica Neue, Roboto Bold
- Body: Arial, Helvetica, Open Sans
- Technical specs: Courier, Consolas, Roboto Mono
- UI elements: System fonts

**Font Matching Strategy**:
```css
/* Map manual fonts to web fonts */
--font-heading-manual: 'Roboto', 'Arial', sans-serif; /* If manual uses Arial/Helvetica */
--font-body-manual: 'Open Sans', 'Arial', sans-serif;
--font-technical: 'Roboto Mono', 'Courier New', monospace;

/* Apply to Fleet Safe Pro sections only */
.fleet-safe-pro-pillar {
    font-family: var(--font-body-manual);
}

.fleet-safe-pro-pillar h1,
.fleet-safe-pro-pillar h2 {
    font-family: var(--font-heading-manual);
}
```

**Google Fonts to Include** (if matching manual):
```html
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Open+Sans:wght@400;600&family=Roboto+Mono&display=swap" rel="stylesheet">
```

**Deliverables**:
- `extraction/fonts-analysis.md` - Font families identified and web alternatives
- CSS variables for Fleet Safe Pro typography

---

### Task 2: Extract Technical Documentation.docx (1 hour)

**Source File**: `/Applications/MAMP/htdocs/aitsc-wp/AITSC CONTENT/AITSC 2/Technical Documentation - template (2)[1].docx`

**Objective**: Extract supplementary technical specs

**Process**:
```bash
# Extract DOCX to plain text (using pandoc or docx2txt)
pandoc "Technical Documentation - template (2)[1].docx" -o extraction/technical-docs.txt

# OR unzip DOCX and read document.xml
unzip "Technical Documentation - template (2)[1].docx" -d extraction/technical-docs/
cat extraction/technical-docs/word/document.xml | grep -o '<w:t>[^<]*' | sed 's/<w:t>//'
```

**Expected Content**:
- Detailed product specifications
- Installation requirements
- Compatibility information
- Certification details

**Deliverables**:
- `extraction/technical-specs.md` - Structured technical specifications

---

### Task 3: Extract Display UI.docx (1 hour)

**Source File**: `/Applications/MAMP/htdocs/aitsc-wp/AITSC CONTENT/AITSC 2/Display UI.docx` (264KB)

**Objective**: Extract UI/UX documentation and screenshots

**Process**: Same as Task 2 (pandoc or unzip)

**Expected Content**:
- UI screenshots (800x480 display)
- User interface flow
- Feature descriptions
- Alert system documentation

**Deliverables**:
- `extraction/display-ui-features.md` - UI feature descriptions
- `extraction/display-ui-screenshots/` - Extracted UI images

---

### Task 4: Extract Case Studies from Case edits.docx (2 hours)

**Source File**: `/Applications/MAMP/htdocs/aitsc-wp/AITSC CONTENT/AITSC 2/Case/Case edits.docx` (6MB)

**Objective**: Extract 2-3 complete case studies with client stories, challenges, solutions, results

**Process**:
```bash
# Extract DOCX content
pandoc "Case edits.docx" -o extraction/case-studies-raw.txt

# Review and structure into individual case studies
```

**Case Study Template** (extract for each story):
```markdown
# Case Study: [Client Name or Industry]

## Client Background
- Industry: [Transport, Mining, School Bus, etc.]
- Fleet Size: [Number of vehicles]
- Challenge: [Compliance issues, safety concerns, manual processes]

## The Challenge
[Detailed problem description - 2-3 paragraphs]
- Specific pain points
- Previous attempts to solve
- Impact on operations

## The Solution
[Fleet Safe Pro implementation details - 2-3 paragraphs]
- What was installed
- How it was configured
- Implementation timeline
- Integration with existing systems

## The Results
[Quantified outcomes - bullet points]
- ✅ Compliance rate improved by X%
- ✅ Incidents prevented: X in first Y months
- ✅ Time saved on manual checks: X hours/week
- ✅ ROI achieved in X months

## Client Testimonial (if available)
> "[Quote from client about their experience]"
> — [Name, Title], [Company]

## Images
- Before/After photos (if available)
- Installation photos
- Dashboard screenshots
```

**Deliverables**:
- `extraction/case-study-01.md` - First case study
- `extraction/case-study-02.md` - Second case study
- `extraction/case-study-03.md` - Third case study (if available)

---

### Task 5: Select & Optimize Product Photos (1 hour)

**Source Directory**: `/Applications/MAMP/htdocs/aitsc-wp/AITSC CONTENT/AITSC 2/Photos/` (75 files)

**Objective**: Select best 10-15 photos for Fleet Safe Pro pillar page, optimize for web

**Selection Criteria**:
- High quality (sharp focus, good lighting)
- Shows product clearly (hardware, display, installation)
- Professional appearance (no messy backgrounds)
- Variety (closeups, wide shots, different angles)

**Photo Categories Needed**:
1. **Hero Image** (1 photo):
   - `800x480-v15---white-red.png` - Clean display UI screenshot

2. **Product Gallery** (8-10 photos):
   - Hardware closeups (transmitter, display unit)
   - Installed system views (dashboard, wiring)
   - Display UI in action (different configurations)
   - Seating diagrams (Hiace, coach arrangements)

3. **Installation Process** (2-3 photos):
   - Wiring/installation shots
   - Before/After (if available)

**Optimization Process**:
```bash
# Copy selected photos to theme assets
mkdir -p wp-content/themes/aitsc-pro-theme/assets/images/fleet-safe-pro/

# Optimize images (resize, compress)
# Target: Max width 1920px, quality 85%, WebP format

# Using ImageMagick
for img in selection/*.jpg; do
    convert "$img" -resize 1920x1920\> -quality 85 "optimized/$(basename "$img" .jpg).jpg"
done

# Convert to WebP for modern browsers
for img in optimized/*.jpg; do
    cwebp -q 85 "$img" -o "$(basename "$img" .jpg).webp"
done
```

**Deliverables**:
- `wp-content/themes/aitsc-pro-theme/assets/images/fleet-safe-pro/` - Optimized product photos
- `extraction/photo-manifest.md` - List of selected photos with usage notes

---

## PART B: PAGE BUILDING (11 HOURS) - USE EXTRACTED CONTENT

### Task 6: Build Fleet Safe Pro Pillar Page (6 hours)

**File**: `wp-content/themes/aitsc-pro-theme/page-fleet-safe-pro.php` (NEW)
**URL**: `/solutions/passenger-monitoring-systems/fleet-safe-pro/`

**Content Source**: **EXCLUSIVELY FROM EXTRACTION** (Tasks 1-5)

#### Section 1: Hero (Use Universal Hero Component)

**Content**: Extracted from manual cover + overview

```php
<?php
// Hero content from Fleet Safe Pro Manual
aitsc_render_hero([
    'variant' => 'pillar',
    'title' => 'Fleet Safe Pro™', // From manual cover
    'subtitle' => '[Extract tagline from manual]', // e.g., "The Most Advanced Passenger Monitoring Solution"
    'description' => '[Extract description from manual overview]',
    'cta_primary' => 'Request Demo',
    'cta_primary_link' => '#demo-form',
    'cta_secondary' => 'Download Specs',
    'cta_secondary_link' => get_template_directory_uri() . '/downloads/fleet-safe-pro-specs.pdf',
    'image' => get_template_directory_uri() . '/assets/images/fleet-safe-pro/hero-display-ui.png',
    'height' => 'large'
]);
?>
```

**Hero Image**: Use extracted display UI screenshot (800x480-v15---white-red.png)

#### Section 2: Problem Definition (Use Extracted Content)

**Content**: Extract from manual introduction or infer from features

```html
<section class="problem-definition container">
    <h2>The Challenge in Passenger Transport Safety</h2>

    <!-- Extract problem statements from manual -->
    <div class="problems-grid">
        <div class="problem-card">
            <span class="material-symbols-outlined">gavel</span>
            <h3>Compliance Requirements</h3>
            <p>[Extract compliance challenges from manual]</p>
        </div>

        <div class="problem-card">
            <span class="material-symbols-outlined">warning</span>
            <h3>Passenger Safety Risks</h3>
            <p>[Extract safety risks from manual]</p>
        </div>

        <div class="problem-card">
            <span class="material-symbols-outlined">schedule</span>
            <h3>Manual Monitoring Inefficiency</h3>
            <p>[Extract manual process issues from manual]</p>
        </div>
    </div>
</section>
```

#### Section 3: Solution Architecture

**Content**: Extract from manual "How It Works" or features section

```html
<section class="solution-architecture container">
    <h2>How Fleet Safe Pro Solves These Challenges</h2>

    <div class="architecture-pillars">
        <!-- Extract 3 key pillars from manual -->
        <div class="pillar">
            <span class="material-symbols-outlined">bolt</span>
            <h3>[Pillar 1 from manual - e.g., "Real-Time Monitoring"]</h3>
            <p>[Extract description]</p>
        </div>

        <div class="pillar">
            <span class="material-symbols-outlined">integration_instructions</span>
            <h3>[Pillar 2 from manual - e.g., "Seamless Integration"]</h3>
            <p>[Extract description]</p>
        </div>

        <div class="pillar">
            <span class="material-symbols-outlined">analytics</span>
            <h3>[Pillar 3 from manual - e.g., "Compliance Reporting"]</h3>
            <p>[Extract description]</p>
        </div>
    </div>
</section>
```

#### Section 4: Key Features (Use Extracted Graphics)

**Content**: Extract feature list from manual

```html
<section class="key-features container">
    <h2>Key Features</h2>

    <div class="features-grid">
        <!-- Extract each feature from manual -->
        <?php
        $features = [
            [
                'icon' => 'visibility',
                'title' => '[Feature 1 from manual]',
                'description' => '[Extract description]',
                'image' => get_template_directory_uri() . '/assets/images/fleet-safe-pro/feature-1.jpg' // Use extracted graphic
            ],
            // ... more features from manual
        ];

        foreach ($features as $feature) {
            aitsc_render_card([
                'variant' => 'glass',
                'icon' => $feature['icon'],
                'title' => $feature['title'],
                'description' => $feature['description']
            ]);
        }
        ?>
    </div>

    <!-- Feature graphics from manual -->
    <div class="feature-visuals">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/fleet-safe-pro/seating-diagram.png"
             alt="Seating Configuration Diagram" />
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/fleet-safe-pro/wiring-diagram.png"
             alt="Wiring Diagram" />
    </div>
</section>
```

**Graphics**: Use extracted diagrams from manual (seating configs, wiring diagrams)

#### Section 5: Technical Specifications (Use Extracted Specs)

**Content**: Extract from manual technical specifications section

```html
<section class="technical-specifications container">
    <h2>Technical Specifications</h2>

    <div class="specs-grid">
        <!-- Extract specs table from manual -->
        <div class="spec-category">
            <h3>Display Unit</h3>
            <table class="specs-table">
                <tr>
                    <td>Resolution</td>
                    <td>[Extract from manual - e.g., "800x480 pixels"]</td>
                </tr>
                <tr>
                    <td>Display Type</td>
                    <td>[Extract from manual]</td>
                </tr>
                <!-- More specs from manual -->
            </table>
        </div>

        <div class="spec-category">
            <h3>Monitoring System</h3>
            <table class="specs-table">
                <tr>
                    <td>Seating Capacity</td>
                    <td>[Extract from manual - e.g., "4-48 passengers"]</td>
                </tr>
                <tr>
                    <td>Configuration Options</td>
                    <td>[Extract from manual]</td>
                </tr>
                <!-- More specs from manual -->
            </table>
        </div>

        <div class="spec-category">
            <h3>Compatibility</h3>
            <table class="specs-table">
                <tr>
                    <td>Vehicle Types</td>
                    <td>[Extract from manual - e.g., "HiAce, Coach, Bus"]</td>
                </tr>
                <!-- More specs from manual -->
            </table>
        </div>
    </div>
</section>
```

**Typography**: Use manual fonts identified in Task 1.3

#### Section 6: Visual Gallery (Use Product Photos)

**Content**: Selected product photos from Photos/ directory (Task 5)

```html
<section class="visual-gallery container">
    <h2>Fleet Safe Pro in Action</h2>

    <div class="gallery-grid">
        <!-- Selected photos from Photos directory -->
        <?php
        $gallery_images = [
            'hero-display-ui.png' => 'Fleet Safe Pro Display Interface',
            'installation-1.jpg' => 'Professional Installation',
            'dashboard-view.jpg' => 'Driver Dashboard View',
            'seating-config-4row.png' => '4-Row Seating Configuration',
            'hardware-closeup.jpg' => 'Hardware Unit Closeup',
            'coach-layout.png' => 'Coach Seating Layout',
            // ... more selected photos
        ];

        foreach ($gallery_images as $image => $caption) {
            echo '<figure class="gallery-item">';
            echo '<img src="' . get_template_directory_uri() . '/assets/images/fleet-safe-pro/' . $image . '" alt="' . esc_attr($caption) . '" loading="lazy" />';
            echo '<figcaption>' . esc_html($caption) . '</figcaption>';
            echo '</figure>';
        }
        ?>
    </div>
</section>
```

**Images**: Use 10-15 optimized photos from Task 5

#### Section 7: Case Studies (Use Extracted Case Studies)

**Content**: Extracted case studies from Case edits.docx (Task 4)

```html
<section class="case-studies-section container">
    <h2>Success Stories</h2>

    <div class="case-studies-grid">
        <?php
        // Use extracted case studies from Task 4
        $case_studies = [
            [
                'title' => '[Case Study 1 Title - from extraction]',
                'industry' => '[Industry - from extraction]',
                'challenge' => '[Challenge summary - from extraction]',
                'result' => '[Key result - from extraction]',
                'link' => home_url('/case-studies/case-study-1-slug/')
            ],
            // ... more case studies from extraction
        ];

        foreach ($case_studies as $case_study) {
            aitsc_render_card([
                'variant' => 'outlined',
                'title' => $case_study['title'],
                'description' => $case_study['challenge'],
                'link' => $case_study['link'],
                'cta_text' => 'Read Full Story'
            ]);
        }
        ?>
    </div>
</section>
```

#### Section 8: Building Your System (Progressive Commitment)

**Content**: Create based on SGESCO Max Safe model + manual info

```html
<section class="building-system container">
    <h2>Building Your Fleet Safe Pro System</h2>
    <p>Implement Fleet Safe Pro at your own pace with flexible deployment options.</p>

    <div class="deployment-tiers">
        <div class="tier">
            <h3>Starter Package</h3>
            <p>Single vehicle implementation</p>
            <ul>
                <li>1 display unit</li>
                <li>Seating configuration setup</li>
                <li>Training included</li>
            </ul>
            <a href="#demo-form" class="btn btn-outline">Get Started</a>
        </div>

        <div class="tier tier-recommended">
            <span class="badge">Recommended</span>
            <h3>Fleet Package</h3>
            <p>5-10 vehicle rollout</p>
            <ul>
                <li>Multiple display units</li>
                <li>Fleet management integration</li>
                <li>Compliance reporting</li>
                <li>Priority support</li>
            </ul>
            <a href="#demo-form" class="btn btn-primary">Request Demo</a>
        </div>

        <div class="tier">
            <h3>Enterprise Package</h3>
            <p>Full fleet integration</p>
            <ul>
                <li>Unlimited vehicles</li>
                <li>Custom configurations</li>
                <li>Advanced analytics</li>
                <li>Dedicated account manager</li>
            </ul>
            <a href="#demo-form" class="btn btn-outline">Contact Sales</a>
        </div>
    </div>
</section>
```

#### Section 9: Industries Served

**Content**: Extract from manual or infer from product capabilities

```html
<section class="industries container">
    <h2>Industries We Serve</h2>

    <div class="industries-grid">
        <div class="industry">
            <span class="material-symbols-outlined">directions_bus</span>
            <h3>Public Transport</h3>
            <p>Bus operators ensuring passenger compliance</p>
        </div>

        <div class="industry">
            <span class="material-symbols-outlined">school</span>
            <h3>School Bus Services</h3>
            <p>Student safety monitoring systems</p>
        </div>

        <div class="industry">
            <span class="material-symbols-outlined">tour</span>
            <h3>Charter & Tourism</h3>
            <p>Tour bus compliance and safety</p>
        </div>

        <div class="industry">
            <span class="material-symbols-outlined">factory</span>
            <h3>Mining Transport</h3>
            <p>Site personnel transport safety</p>
        </div>
    </div>
</section>
```

#### Section 10: Demo Request CTA (Use CTA Component)

**Content**: Simple form (native WordPress placeholder for HubSpot)

```php
<?php
aitsc_render_cta([
    'variant' => 'form',
    'title' => 'Request a Fleet Safe Pro Demo',
    'description' => 'See how real-time passenger monitoring can improve your fleet safety compliance',
    'form_id' => 'demo-request-form' // Native WordPress form placeholder
]);
?>
```

**Form Fields** (native WordPress):
- Name
- Company
- Fleet Size
- Email
- Phone
- Message
- Submit button

---

### Task 7: Build Solutions Landing Page (2 hours)

**File**: `page-solutions.php` (NEW)
**URL**: `/solutions/`

**Content**: Showcase all 6 solution categories + highlight Passenger Monitoring

```php
<?php
/**
 * Template Name: Solutions Landing
 */
get_header();

// Hero
aitsc_render_hero([
    'variant' => 'page',
    'title' => 'Comprehensive Electronics Solutions',
    'subtitle' => 'From PCB Design to AI Automation',
    'description' => 'Solving your most expensive infrastructure electronics and software problems',
    'height' => 'medium'
]);
?>

<section class="solutions-grid container">
    <h2>Our Solution Categories</h2>

    <div class="solutions-cards">
        <?php
        // 6 solution categories
        $solutions = [
            [
                'icon' => 'memory',
                'title' => 'Custom PCB Design & Development',
                'description' => 'End-to-end PCB design from schematic to production-ready layouts',
                'link' => home_url('/solutions/custom-pcb-design/'),
                'featured' => false
            ],
            [
                'icon' => 'developer_board',
                'title' => 'Embedded Systems & Firmware',
                'description' => 'Low-level software integrated seamlessly with custom hardware',
                'link' => home_url('/solutions/embedded-systems/'),
                'featured' => false
            ],
            [
                'icon' => 'sensors',
                'title' => 'Sensor System Design & Integration',
                'description' => 'Real-time data solutions including passenger monitoring systems',
                'link' => home_url('/solutions/sensor-integration/'),
                'featured' => false
            ],
            [
                'icon' => 'directions_car',
                'title' => 'Automotive Electronics Engineering',
                'description' => 'CAN bus systems, diagnostics, and ISO 26262 compliance',
                'link' => home_url('/solutions/automotive-electronics/'),
                'featured' => false
            ],
            [
                'icon' => 'psychology',
                'title' => 'AI & Automations',
                'description' => 'Workflow optimization reducing manual errors and operational costs',
                'link' => home_url('/solutions/ai-automations/'),
                'featured' => false
            ],
            [
                'icon' => 'verified_user',
                'title' => 'Functional Safety & Compliance',
                'description' => 'Certification assistance for automotive and industrial sectors',
                'link' => home_url('/solutions/compliance-support/'),
                'featured' => false
            ]
        ];

        foreach ($solutions as $solution) {
            aitsc_render_card([
                'variant' => 'glass',
                'icon' => $solution['icon'],
                'title' => $solution['title'],
                'description' => $solution['description'],
                'link' => $solution['link'],
                'cta_text' => 'Learn More',
                'size' => 'large'
            ]);
        }
        ?>
    </div>
</section>

<!-- Featured: Passenger Monitoring Systems -->
<section class="featured-solution container">
    <div class="featured-content">
        <h2>Featured Solution: Passenger Monitoring Systems</h2>
        <p>Our flagship Fleet Safe Pro product delivers real-time seatbelt monitoring, compliance reporting, and driver alerts for transport fleets.</p>
        <a href="<?php echo home_url('/solutions/passenger-monitoring-systems/'); ?>" class="btn btn-primary">
            Explore Passenger Monitoring
        </a>
    </div>
    <div class="featured-image">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/fleet-safe-pro/hero-display-ui.png"
             alt="Fleet Safe Pro Display" />
    </div>
</section>

<?php
// CTA
aitsc_render_cta([
    'variant' => 'banner',
    'title' => 'Need a Custom Solution?',
    'description' => 'Get a free onsite tech review to identify costly operational bottlenecks',
    'button_text' => 'Schedule Free Review',
    'button_link' => home_url('/contact/'),
    'background' => 'linear-gradient(135deg, #005cb2, #001a33)'
]);

get_footer();
?>
```

**No extraction needed** - Uses existing aitsc.au content

---

### Task 8: Build Passenger Monitoring Category Page (1 hour)

**File**: `page-passenger-monitoring-systems.php` (NEW)
**URL**: `/solutions/passenger-monitoring-systems/`

**Content**: Category landing page introducing passenger safety monitoring

```php
<?php
/**
 * Template Name: Passenger Monitoring Systems
 */
get_header();

// Hero
aitsc_render_hero([
    'variant' => 'page',
    'title' => 'Passenger Monitoring Systems',
    'subtitle' => 'Advanced Safety Solutions for Transport Fleets',
    'description' => 'Real-time seatbelt monitoring, compliance reporting, and driver alerts',
    'show_breadcrumb' => true,
    'height' => 'medium'
]);
?>

<section class="category-overview container">
    <h2>The Challenge in Passenger Transport Safety</h2>
    <p>Transport operators face increasing compliance requirements, passenger safety risks, and the inefficiency of manual seatbelt checks.</p>

    <div class="challenges-grid">
        <div class="challenge">
            <span class="material-symbols-outlined">gavel</span>
            <h3>Compliance Requirements</h3>
            <p>Regulatory bodies demand documented proof of seatbelt usage</p>
        </div>

        <div class="challenge">
            <span class="material-symbols-outlined">warning</span>
            <h3>Passenger Safety</h3>
            <p>Unbuckled passengers at risk during sudden stops or accidents</p>
        </div>

        <div class="challenge">
            <span class="material-symbols-outlined">schedule</span>
            <h3>Manual Monitoring</h3>
            <p>Drivers distracted by visual seatbelt checks, time-consuming manual logs</p>
        </div>
    </div>
</section>

<section class="solution-intro container">
    <h2>Our Passenger Monitoring Solutions</h2>
    <p>AITSC delivers comprehensive passenger safety monitoring systems that provide real-time visibility, automated compliance reporting, and instant driver alerts.</p>
</section>

<!-- Featured Product: Fleet Safe Pro -->
<section class="featured-product container">
    <div class="product-card-large">
        <div class="product-image">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/fleet-safe-pro/hero-display-ui.png"
                 alt="Fleet Safe Pro" />
        </div>
        <div class="product-details">
            <span class="badge badge-featured">Flagship Product</span>
            <h2>Fleet Safe Pro™</h2>
            <p class="product-tagline">The Most Advanced Passenger Monitoring Solution for Transport Fleets</p>

            <h3>Key Features:</h3>
            <ul class="features-list">
                <li>✅ Real-time seatbelt status monitoring (seat-by-seat)</li>
                <li>✅ 800x480 display with intuitive visual interface</li>
                <li>✅ Audio and visual driver alerts</li>
                <li>✅ Automated compliance data logging</li>
                <li>✅ Custom seating configurations (4-48 passengers)</li>
                <li>✅ Integration with fleet management systems</li>
            </ul>

            <div class="product-ctas">
                <a href="<?php echo home_url('/solutions/passenger-monitoring-systems/fleet-safe-pro/'); ?>"
                   class="btn btn-primary btn-large">
                    Learn More About Fleet Safe Pro
                </a>
                <a href="#demo-form" class="btn btn-outline btn-large">
                    Request Demo
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Industries Served -->
<section class="industries container">
    <h2>Industries We Serve</h2>
    <div class="industries-grid">
        <div class="industry">
            <span class="material-symbols-outlined">directions_bus</span>
            <h3>Public Transport Operators</h3>
        </div>
        <div class="industry">
            <span class="material-symbols-outlined">school</span>
            <h3>School Bus Services</h3>
        </div>
        <div class="industry">
            <span class="material-symbols-outlined">tour</span>
            <h3>Charter & Tour Companies</h3>
        </div>
        <div class="industry">
            <span class="material-symbols-outlined">factory</span>
            <h3>Mining Site Transport</h3>
        </div>
    </div>
</section>

<?php
// Demo CTA
aitsc_render_cta([
    'variant' => 'form',
    'title' => 'See Fleet Safe Pro in Action',
    'description' => 'Request a personalized demo to see how passenger monitoring can improve your fleet safety',
    'form_id' => 'category-demo-form'
]);

get_footer();
?>
```

**Graphics**: Use Fleet Safe Pro display UI screenshot

---

### Task 9: Create Sample Blog Posts (2 hours)

**Content Source**: marketing_stack_plan.md (lines 76-93)

**Create 5 sample blog posts** based on content calendar:

#### Blog Post 1: "Hidden Compliance Risks in Passenger Transport Fleets"

**File**: Create as WordPress post
**Category**: Safety & Compliance
**Content** (800-1000 words):

```markdown
# Hidden Compliance Risks in Passenger Transport Fleets

Transport operators face a complex web of compliance requirements that extend far beyond vehicle maintenance and driver licensing. Passenger seatbelt compliance, in particular, represents a growing area of regulatory focus—and hidden operational risk.

## The Compliance Landscape

[Write 2-3 paragraphs about compliance requirements, regulations, and penalties]

## Hidden Risks Most Operators Miss

1. **Incomplete Documentation**: Manual seatbelt logs...
2. **Driver Distraction During Checks**: Visual verification...
3. **Inconsistent Enforcement**: Varying driver practices...

## The Cost of Non-Compliance

[Write 2-3 paragraphs about financial, reputational, and operational costs]

## Technology Solutions

Modern passenger monitoring systems like Fleet Safe Pro provide automated, real-time compliance documentation...

[Link to Fleet Safe Pro pillar page]

## Conclusion

[Summary and CTA]
```

#### Blog Post 2: "How Real-Time Passenger Monitoring Works"

**Content** (800-1000 words): Technical explanation of seatbelt monitoring systems

#### Blog Post 3: "Case Study – Improving Fleet Safety Compliance"

**Content**: Use extracted case study from Task 4

#### Blog Post 4: "Why Seatbelt Monitoring is the Future of Passenger Safety"

**Content** (800-1000 words): Industry trends, technology evolution

#### Blog Post 5: "5 Ways Real-Time Alerts Protect Drivers and Passengers"

**Content** (800-1000 words): Benefits breakdown with examples

**Deliverables**:
- 5 blog posts created as WordPress posts
- Featured images for each post (use Fleet Safe Pro photos)
- Internal links to Fleet Safe Pro pillar page

---

## Files to Create (Summary)

### Extraction Outputs (9 files):
```
extraction/
├── fleet-safe-pro-manual-text.txt ✅
├── fleet-safe-pro-sections.md ✅
├── fonts-used.txt ✅
├── graphics-manifest.md ✅
├── fleet-safe-pro-manual/ (directory with extracted images) ✅
├── technical-specs.md ✅
├── display-ui-features.md ✅
├── case-study-01.md ✅
├── case-study-02.md ✅
└── case-study-03.md ✅
```

### Theme Files (3 pages):
```
wp-content/themes/aitsc-pro-theme/
├── page-fleet-safe-pro.php ✅ (Fleet Safe Pro pillar page)
├── page-solutions.php ✅ (Solutions landing)
└── page-passenger-monitoring-systems.php ✅ (Category page)
```

### Assets (Optimized photos):
```
wp-content/themes/aitsc-pro-theme/assets/images/fleet-safe-pro/
├── hero-display-ui.png ✅
├── gallery/ (10-15 product photos) ✅
├── diagrams/ (seating, wiring) ✅
└── features/ (feature graphics) ✅
```

### WordPress Posts (5 blog posts):
```
Blog posts created via WordPress admin:
- Post 1: Hidden Compliance Risks
- Post 2: How Real-Time Monitoring Works
- Post 3: Case Study (from extraction)
- Post 4: Why Seatbelt Monitoring is the Future
- Post 5: 5 Ways Real-Time Alerts Protect
```

---

## Typography Implementation (Crucial)

**File**: `wp-content/themes/aitsc-pro-theme/assets/css/fleet-safe-pro-typography.css` (NEW)

```css
/* Fleet Safe Pro Typography - Matching Manual Fonts */

/* Import Google Fonts matching manual (if identified in Task 1.3) */
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Open+Sans:wght@400;600&family=Roboto+Mono&display=swap');

/* CSS Variables for Fleet Safe Pro typography */
:root {
    --font-heading-fleet: 'Roboto', 'Arial', sans-serif; /* Match manual headings */
    --font-body-fleet: 'Open Sans', 'Arial', sans-serif; /* Match manual body */
    --font-technical-fleet: 'Roboto Mono', 'Courier New', monospace; /* Match manual tech specs */
}

/* Apply only to Fleet Safe Pro pillar page */
.page-fleet-safe-pro,
.fleet-safe-pro-pillar {
    font-family: var(--font-body-fleet);
    line-height: 1.6;
}

/* Headings match manual typography */
.page-fleet-safe-pro h1,
.page-fleet-safe-pro h2,
.page-fleet-safe-pro h3,
.fleet-safe-pro-pillar h1,
.fleet-safe-pro-pillar h2,
.fleet-safe-pro-pillar h3 {
    font-family: var(--font-heading-fleet);
    font-weight: 700;
}

/* Technical specifications use monospace (if manual uses monospace) */
.specs-table,
.technical-specifications {
    font-family: var(--font-technical-fleet);
    font-size: 0.95em;
}

/* Hero title - extra large, bold (match manual cover) */
.fleet-safe-pro-pillar .hero h1 {
    font-size: clamp(2.5rem, 6vw, 4rem);
    font-weight: 700;
    letter-spacing: -0.02em;
}

/* Section headings - match manual section headers */
.fleet-safe-pro-pillar h2 {
    font-size: clamp(1.75rem, 4vw, 2.5rem);
    margin-bottom: var(--space-8);
}

/* Subsection headings */
.fleet-safe-pro-pillar h3 {
    font-size: clamp(1.25rem, 3vw, 1.75rem);
    margin-bottom: var(--space-4);
}

/* Body text - readable, matches manual body */
.fleet-safe-pro-pillar p {
    font-size: 1.125rem;
    line-height: 1.7;
    margin-bottom: var(--space-6);
}

/* Lists - match manual list styling */
.fleet-safe-pro-pillar ul,
.fleet-safe-pro-pillar ol {
    margin-left: var(--space-8);
    margin-bottom: var(--space-6);
}

.fleet-safe-pro-pillar li {
    margin-bottom: var(--space-4);
    line-height: 1.6;
}
```

**Enqueue**:
```php
// In inc/enqueue.php
wp_enqueue_style(
    'aitsc-fleet-safe-pro-typography',
    get_template_directory_uri() . '/assets/css/fleet-safe-pro-typography.css',
    array('aitsc-style'),
    AITSC_VERSION
);
```

---

## Testing Requirements

### Content Extraction Validation

- [ ] All manual sections extracted and mapped correctly
- [ ] Graphics extracted and optimized (verify quality)
- [ ] Fonts identified and matched with web alternatives
- [ ] Case studies extracted with complete information
- [ ] Photos selected and optimized (verify <500KB each)

### Page Testing

- [ ] Fleet Safe Pro pillar page displays all 10 sections correctly
- [ ] Typography matches manual fonts (visual comparison)
- [ ] Graphics render correctly (seating diagrams, wiring diagrams)
- [ ] Product photos load optimized (WebP with JPG fallback)
- [ ] Case study links functional
- [ ] Demo form displays (native WordPress placeholder)
- [ ] Solutions landing page shows all 6 categories
- [ ] Category page (Passenger Monitoring) displays correctly
- [ ] Blog posts display with featured images

### Typography Testing

- [ ] Fleet Safe Pro page uses manual-matched fonts
- [ ] Headings match manual hierarchy (h1, h2, h3)
- [ ] Technical specs use appropriate monospace font
- [ ] Typography responsive across breakpoints
- [ ] Font loading optimized (no FOUT/FOIT)

---

## Success Criteria

- [ ] All AITSC CONTENT folder materials extracted (manual, docs, photos, graphics)
- [ ] Fleet Safe Pro pillar page built with extracted content (fonts, graphics, layout preserved)
- [ ] Typography matches manual presentation
- [ ] 10-15 product photos optimized and integrated
- [ ] 2-3 case studies extracted and published
- [ ] Solutions landing + category page built
- [ ] 5 sample blog posts created
- [ ] All pages use universal components from Phase 2
- [ ] All links functional (zero 404s)
- [ ] Content extraction documentation complete

---

**Next Phase**: Phase 4 - Mobile Responsiveness & Performance Optimization
