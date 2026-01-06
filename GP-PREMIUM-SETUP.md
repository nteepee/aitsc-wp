# GP Premium Setup & Elements Strategy Guide

**Project:** AITSC GeneratePress Migration
**Date:** January 6, 2026
**Environment:** Development (localhost:8888)
**License:** Lifetime (Premium)
**Version:** GP Premium 2.5+

---

## Quick Reference

- **Dev URL:** `http://localhost:8888/aitsc-wp-copy/`
- **License Key:** `de485e6af6e7e30eb60dbe638d50e55f`
- **Child Theme:** `aitsc-gp-child`
- **Parent Theme:** GeneratePress (free)

---

## Table of Contents

1. [Installation](#installation)
2. [License Activation](#license-activation)
3. [Module Configuration](#module-configuration)
4. [Elements Strategy](#elements-strategy)
5. [Creating First Block Element](#creating-first-block-element)
6. [Display Conditions Setup](#display-conditions-setup)
7. [Activation Checklist](#activation-checklist)
8. [Troubleshooting](#troubleshooting)
9. [Next Steps](#next-steps)

---

## Installation

### Step 1: Download GP Premium

**Option A: From GeneratePress Account**
1. Go to: https://generatepress.com/account
2. Log in with your account credentials
3. Download "GP Premium" plugin zip file
4. License: `de485e6af6e7e30eb60dbe638d50e55f` (Lifetime)

**Option B: Manual Upload**
1. Download zip file from account page
2. Extract to temporary location
3. Upload via FTP/SFTP to: `/wp-content/plugins/gp-premium/`

### Step 2: Install Plugin via WordPress Admin

**Method 1: Upload Zip**
1. Navigate to: `http://localhost:8888/aitsc-wp-copy/wp-admin/`
2. Go to: **Plugins > Add New**
3. Click: **Upload Plugin**
4. Choose: Downloaded `gp-premium.zip` file
5. Click: **Install Now**
6. Wait for installation to complete

**Method 2: Manual Upload (if Method 1 fails)**
1. Extract zip file locally
2. Via FTP/SFTP, upload folder to: `/wp-content/plugins/gp-premium/`
3. Navigate to: **Plugins > Installed Plugins**
4. Find "GP Premium" in list
5. Click **Activate**

### Step 3: Verify Installation

**Check Plugin List:**
- Go to: **Plugins > Installed Plugins**
- Look for: "GP Premium" with version number
- Status: Should be "Active"

**Check GeneratePress Menu:**
- Go to: **Appearance > GeneratePress**
- Should see new tabs: Modules, License, etc.

---

## License Activation

### Step 1: Access License Settings

1. Navigate to: **Appearance > GeneratePress**
2. Click **License** tab
3. You'll see license key input field

### Step 2: Enter License Key

1. Copy license key: `de485e6af6e7e30eb60dbe638d50e55f`
2. Paste into license key field
3. Click **Activate License**
4. Wait for verification

### Step 3: Verify Activation

**Success Indicators:**
- ✅ License status shows "Active"
- ✅ License type shows "Lifetime"
- ✅ Expiration date shows "Lifetime"
- ✅ No error messages displayed

**If Activation Fails:**
1. Double-check license key (no extra spaces)
2. Verify internet connection
3. Try deactivating and reactivating
4. Contact GP Support if issue persists

---

## Module Configuration

### Step 1: Access Modules

1. Navigate to: **Appearance > GeneratePress > Modules**
2. You'll see list of available modules
3. Each module has toggle switch

### Step 2: Recommended Modules for AITSC

**CRITICAL MODULES (Enable All):**

#### 1. **Elements Module** ⭐ CRITICAL
**Purpose:** Build custom headers, footers, templates with blocks
**Why:** Replaces PHP template files with visual block editor
**Features:**
- Block Elements (Content Templates, Loop Templates)
- Header Elements
- Footer Elements
- Layout Elements
- Hook Elements
**Enable:** ✅ YES

#### 2. **Backgrounds Module**
**Purpose:** Custom background images and colors per page
**Why:** AITSC needs custom hero backgrounds
**Features:**
- Per-page backgrounds
- Parallax effects
- Overlay colors
**Enable:** ✅ YES

#### 3. **Typography Module**
**Purpose:** Advanced typography management
**Why:** Custom font integration for branding
**Features:**
- Google Fonts integration
- Custom font sizes
- Font weights
- Line heights
**Enable:** ✅ YES

#### 4. **Colors Module**
**Purpose:** Custom color palette management
**Why:** AITSC brand colors
**Features:**
- Global color palette
- Per-page color overrides
- Dark mode support (future)
**Enable:** ✅ YES

#### 5. **Spacing Module**
**Purpose:** Margin and padding control
**Why:** Fine-tune layout spacing
**Features:**
- Content padding
- Widget spacing
- Mobile spacing adjustments
**Enable:** ✅ YES

#### 6. **Secondary Nav Module**
**Purpose:** Add secondary navigation menu
**Why:** AITSC may need top utility bar
**Features:**
- Top bar navigation
- Social menu
- Phone/email links
**Enable:** ⚠️ OPTIONAL (enable if needed)

#### 7. **Menu Plus Module**
**Purpose:** Enhanced navigation features
**Why:** Mobile menu improvements
**Features:**
- Mobile menu toggle
- Mega menus
- Off-canvas menu
- Sticky navigation
**Enable:** ⚠️ OPTIONAL (enable if needed)

#### 8. **Sticky Module**
**Purpose:** Sticky headers/navigation
**Why:** Keep navigation visible on scroll
**Features:**
- Sticky header
- Sticky navigation
- Transition effects
**Enable:** ⚠️ OPTIONAL (enable if needed)

### Step 3: Module Activation Order

**Recommended Order:**
1. Elements (first - most important)
2. Backgrounds
3. Typography
4. Colors
5.Spacing
6. Secondary Nav (if needed)
7. Menu Plus (if needed)
8. Sticky (if needed)

### Step 4: Save Changes

1. After toggling modules, click **Save**
2. Wait for modules to activate
3. Refresh page to see new options

---

## Elements Strategy

### Overview

GeneratePress Elements replaces PHP template files with visual block-based templates. This is the core of the migration strategy.

### Element Types & AITSC Usage

#### 1. **Block Elements** (Most Powerful)

**Content Templates**
- **Purpose:** Display single CPT posts (Solutions, Case Studies)
- **AITSC Replaces:**
  - `single-solutions.php`
  - `single-case-studies.php`
- **How:**
  - Create Element > Block Element > Content Template
  - Add dynamic blocks with ACF data
  - Set display rules to CPT
- **Example:** Solution single post with hero, features, testimonials

**Loop Templates**
- **Purpose:** Display lists of posts (archives)
- **AITSC Replaces:**
  - `archive-solutions.php`
  - `archive-case-studies.php`
  - `taxonomy-solution_category.php`
- **How:**
  - Create Element > Block Element > Loop Template
  - Add Query Loop block
  - Style individual items
  - Set display rules to archives
- **Example:** Solution archive grid with filters

**Page Hero Elements**
- **Purpose:** Custom hero sections
- **AITSC Replaces:**
  - `template-parts/hero-advanced.php`
  - `template-parts/hero-mobile-optimized.php`
- **How:**
  - Create Element > Block Element > Page Hero
  - Build hero with blocks
  - Set display rules per page
- **Example:** Fleet Safe Pro hero with parallax background

#### 2. **Header Elements**

**Purpose:** Custom site headers
**AITSC Replaces:** `header.php`
**Strategy:**
1. Create Header Element
2. Build with blocks (logo, nav, CTA)
3. Set display rules:
   - Global: Entire site
   - Exclude: Specific landing pages if needed
4. Use GenerateBlocks for layout

#### 3. **Footer Elements**

**Purpose:** Custom site footers
**AITSC Replaces:** `footer.php`
**Strategy:**
1. Create Footer Element
2. Build multi-column layout
3. Add: copyright, links, social, contact
4. Set display rules to global

#### 4. **Layout Elements**

**Purpose:** Control page layout structure
**AITSC Replaces:** Template file layout logic
**Strategy:**
1. Create Layout Element for landing pages
2. Settings:
   - Content Width: Full width
   - Sidebar: None
3. Set display rules:
   - Page: Fleet Safe Pro
   - Page: Contact
   - Page: About

#### 5. **Hook Elements**

**Purpose:** Insert content at specific locations
**AITSC Uses:**
- Load CSS/JS assets
- Add tracking codes
- Insert shortcodes globally
**Strategy:** Use sparingly, prefer Block Elements

### AITSC Element Priority List

**Phase 1: Core Structure (Critical)**
1. ✅ Header Element (replace `header.php`)
2. ✅ Footer Element (replace `footer.php`)
3. ✅ Layout Elements (page templates)

**Phase 2: CPT Templates (Critical)**
4. ✅ Content Template: Solutions (replace `single-solutions.php`)
5. ✅ Content Template: Case Studies (replace `single-case-studies.php`)
6. ✅ Loop Template: Solutions Archive (replace `archive-solutions.php`)
7. ✅ Loop Template: Case Studies Archive (replace `archive-case-studies.php`)

**Phase 3: Components (High Priority)**
8. ✅ Page Hero: Fleet Safe Pro
9. ✅ Page Hero: About AITSC
10. ✅ Page Hero: Contact

**Phase 4: Enhancements (Medium Priority)**
11. Hook Element: Paper Stack assets
12. Hook Element: Analytics/tracking
13. Hook Element: Custom scripts

---

## Creating First Block Element

### Step 1: Access Elements

1. Navigate to: **Appearance > GeneratePress > Elements**
2. Click: **Add New Element**
3. Select element type

### Step 2: Create Header Element (Example)

**1. Create Element**
- Click: **Add New Element**
- Choose: **Header**
- Click: **Confirm**

**2. Build Header with Blocks**
```
Header Structure:
├── Container (GenerateBlocks)
│   ├── Grid (2 columns)
│   │   ├── Column 1: Site Logo
│   │   │   └── Image Block / Site Title
│   │   └── Column 2: Navigation + CTA
│   │       ├── Navigation Block (Primary Menu)
│   │       └── Button Block (Contact CTA)
```

**3. Configure Blocks**
- **Logo:**
  - Add Image block or Site Title block
  - Link to home page
  - Set dimensions: 200x80px

- **Navigation:**
  - Add Navigation block
  - Select menu: "Primary Menu"
  - Set mobile menu toggle

- **CTA Button:**
  - Add Button block (GenerateBlocks)
  - Text: "Get Started"
  - Link: `/contact/`
  - Style: Primary color

**4. Set Display Rules**
- **Location:** Entire Site
- **Exclude:** (leave empty for now)
- **User Roles:** All Users

**5. Publish Element**
- Click: **Publish**
- Check: "Set as default header" (if prompted)

**6. Test Header**
- Visit: `http://localhost:8888/aitsc-wp-copy/`
- Verify header displays correctly
- Check mobile responsive
- Test navigation links

### Step 3: Create Footer Element (Example)

**1. Create Element**
- Click: **Add New Element**
- Choose: **Footer**
- Click: **Confirm**

**2. Build Footer with Blocks**
```
Footer Structure:
├── Container (GenerateBlocks)
│   ├── Grid (4 columns)
│   │   ├── Column 1: About
│   │   │   ├── Logo
│   │   │   └── About text
│   │   ├── Column 2: Services
│   │   │   └── Navigation menu
│   │   ├── Column 3: Company
│   │   │   └── Navigation menu
│   │   └── Column 4: Contact
│   │       ├── Address
│   │       ├── Phone
│   │       └── Email
│   ├── Bottom Bar
│   │   ├── Copyright
│   │   └── Social links
```

**3. Set Display Rules**
- **Location:** Entire Site
- **Publish**

---

## Display Conditions Setup

### Understanding Display Rules

Display rules determine when and where Elements appear on your site.

### Rule Types

**Location Rules:**
- **Posts:** All posts, specific posts, post categories
- **Pages:** All pages, specific pages, page ancestors
- **Custom Post Types:** Solutions, Case Studies
- **Taxonomies:** Categories, tags, custom taxonomies
- **Archives:** Blog archive, CPT archives
- **Special:** 404 page, search results

**Exclude Rules:**
- Invert any location rule
- Example: Show everywhere EXCEPT front page

**User Roles:**
- All users
- Logged in users
- Logged out users
- Specific roles (Administrator, Editor, etc.)

### Common Display Rule Scenarios

**Scenario 1: Global Header**
```
Location: Entire Site
Exclude: [None]
User Roles: All Users
```

**Scenario 2: Custom Landing Page Header**
```
Location: Page > Fleet Safe Pro
Exclude: [None]
User Roles: All Users
```

**Scenario 3: Solution Single Post Template**
```
Location: Solutions > All Solutions
Exclude: [None]
User Roles: All Users
```

**Scenario 4: Admin Notice (Hook Element)**
```
Location: Entire Site
Exclude: [None]
User Roles: Administrator
```

**Scenario 5: Mobile-Specific Element**
```
Location: Entire Site
Exclude: [None]
User Roles: All Users
+ Custom PHP check for mobile
```

### Advanced Display Rules

**Multiple Conditions (AND Logic):**
```
Location:
  - Post Type: Solutions
  - Taxonomy: Service Category > "Safety Consulting"
Result: Shows ONLY for solutions in "Safety Consulting" category
```

**Exclude Rules (NOT Logic):**
```
Location: Entire Site
Exclude:
  - Front Page
  - Page: Contact
Result: Shows everywhere EXCEPT front page and contact
```

**User Role Logic:**
```
Location: Entire Site
User Roles: Logged in users
Result: Only shows to logged-in users
```

---

## Activation Checklist

### Pre-Activation Checklist

- [ ] Backup entire site (files + database)
- [ ] Verify GeneratePress (free) is installed and active
- [ ] Verify child theme `aitsc-gp-child` exists
- [ ] Download GP Premium zip file
- [ ] Copy license key: `de485e6af6e7e30eb60dbe638d50e55f`

### Installation Checklist

- [ ] Upload GP Premium plugin
- [ ] Activate GP Premium
- [ ] Verify plugin appears in "Installed Plugins" list
- [ ] Navigate to Appearance > GeneratePress
- [ ] Verify new tabs appear (Modules, License)

### License Activation Checklist

- [ ] Go to Appearance > GeneratePress > License
- [ ] Paste license key
- [ ] Click "Activate License"
- [ ] Verify "Active" status
- [ ] Verify "Lifetime" license type
- [ ] Check no error messages

### Module Activation Checklist

- [ ] Go to Appearance > GeneratePress > Modules
- [ ] Enable Elements module ⭐
- [ ] Enable Backgrounds module
- [ ] Enable Typography module
- [ ] Enable Colors module
- [ ] Enable Spacing module
- [ ] Enable Secondary Nav (if needed)
- [ ] Enable Menu Plus (if needed)
- [ ] Enable Sticky (if needed)
- [ ] Click Save
- [ ] Wait for activation
- [ ] Refresh page

### First Element Creation Checklist

**Header Element:**
- [ ] Go to Appearance > GeneratePress > Elements
- [ ] Click "Add New Element"
- [ ] Select "Header"
- [ ] Build header with blocks:
  - [ ] Add logo
  - [ ] Add navigation
  - [ ] Add CTA button
- [ ] Set display rules: Entire Site
- [ ] Publish
- [ ] Test on frontend

**Footer Element:**
- [ ] Click "Add New Element"
- [ ] Select "Footer"
- [ ] Build footer with blocks:
  - [ ] Add about column
  - [ ] Add services column
  - [ ] Add company column
  - [ ] Add contact column
  - [ ] Add copyright bar
- [ ] Set display rules: Entire Site
- [ ] Publish
- [ ] Test on frontend

### Verification Checklist

**Frontend Verification:**
- [ ] Visit homepage
- [ ] Verify custom header displays
- [ ] Verify custom footer displays
- [ ] Check mobile responsive
- [ ] Check tablet responsive
- [ ] Check desktop responsive
- [ ] Test navigation links
- [ ] Test footer links
- [ ] Check browser console for errors

**Backend Verification:**
- [ ] Check Elements list (should show 2 elements)
- [ ] Edit header element (should open block editor)
- [ ] Edit footer element (should open block editor)
- [ ] Verify display rules saved correctly
- [ ] Check GeneratePress settings (all modules active)

**Functionality Verification:**
- [ ] Mobile menu works
- [ ] Dropdown menus work (if applicable)
- [ ] All links functional
- [ ] No PHP errors in debug.log
- [ ] No JavaScript errors in console
- [ ] Performance acceptable (load time <3s)

---

## Troubleshooting

### Common Issues & Solutions

**Issue 1: License Activation Fails**

**Symptoms:**
- Error message "Invalid license key"
- License shows "Inactive"

**Solutions:**
1. ✅ Verify license key copied correctly (no extra spaces)
2. ✅ Check internet connection
3. ✅ Deactivate and reactivate license
4. ✅ Clear browser cache
5. ✅ Check if license already activated on another site (lifetime = unlimited sites)
6. ✅ Contact GP Support: https://generatepress.com/support

**Issue 2: Elements Module Not Working**

**Symptoms:**
- Elements menu item missing
- Can't create new elements
- Elements not displaying on frontend

**Solutions:**
1. ✅ Verify Elements module is activated
2. ✅ Deactivate and reactivate Elements module
3. ✅ Clear all caches:
   - Browser cache
   - WordPress cache (if using caching plugin)
   - Server cache (if applicable)
4. ✅ Check for plugin conflicts:
   - Deactivate all plugins except GP Premium
   - Reactivate one by one
   - Identify conflicting plugin
5. ✅ Verify GenerateBlocks is installed (required for dynamic features)

**Issue 3: Header/Footer Not Displaying**

**Symptoms:**
- Header element published but not visible
- Footer element published but not visible
- Default GP header/footer still showing

**Solutions:**
1. ✅ Check display rules:
   - Must have at least one location rule
   - Check if "Exclude" rules too broad
2. ✅ Verify element is "Published" (not Draft)
3. ✅ Check for PHP errors in debug.log
4. ✅ Test with different display rules (e.g., specific page)
5. ✅ Check if another element overriding (priority issues)
6. ✅ Clear all caches
7. �] Test in different browsers

**Issue 4: Block Editor Not Loading**

**Symptoms:**
- Can't edit element with block editor
- Classic editor showing instead
- Editor blank/crashed

**Solutions:**
1. ✅ Verify WordPress version 5.0+ (block editor required)
2. ✅ Check browser console for JavaScript errors
3. ✅ Deactivate conflicting plugins:
   - Classic Editor
   - Other page builders (Elementor, Divi)
4. ✅ Switch to different browser (Chrome, Firefox)
5. ✅ Increase PHP memory limit in wp-config.php:
   ```php
   define( 'WP_MEMORY_LIMIT', '256M' );
   ```
6. ✅ Check for theme conflicts

**Issue 5: Dynamic Data Not Showing (ACF)**

**Symptoms:**
- ACF fields showing as blank
- Dynamic tags not working
- `{{post_meta}}` tags showing as text

**Solutions:**
1. ✅ Verify ACF Pro is installed and activated
2. ✅ Verify GenerateBlocks Pro is installed (free version insufficient)
3. ✅ Check field names exactly (case-sensitive)
4. ✅ Test ACF field in regular post editor (works there?)
5. ✅ Verify field group location rules (correct post type?)
6. ✅ Check dynamic tag syntax:
   - Correct: `{{post_meta key:field_name}}`
   - Wrong: `{{field_name}}`
7. ✅ Clear all caches
8. ✅ Check PHP errors in debug.log

**Issue 6: Mobile Menu Not Working**

**Symptoms:**
- Mobile menu not opening
- Menu not responsive
- Menu overlaps content

**Solutions:**
1. ✅ Enable Menu Plus module
2. ✅ Configure mobile menu in Customizer:
   - Appearance > Customize > Layout > Primary Navigation
   - Check "Mobile menu toggle" settings
3. ✅ Verify navigation assigned to mobile location
4. ✅ Check for CSS conflicts (custom styles)
5. ✅ Test on actual mobile device (not just browser resize)
6. ✅ Clear browser cache

**Issue 7: Performance Degradation**

**Symptoms:**
- Site slower after GP Premium activation
- PageSpeed scores decreased
- Load time increased

**Solutions:**
1. ✅ Enable caching (WP Rocket recommended)
2. ✅ Optimize images (Smush, ShortPixel)
3. ✅ Minimize PHP in Hook Elements
4. ✅ Use lazy loading for images
5. ✅ Deactivate unused modules
6. ✅ Minify CSS/JS
7. ✅ Use CDN for static assets
8. ✅ Check for plugin conflicts

**Issue 8: White Screen After Activation**

**Symptoms:**
- Blank white screen
- PHP fatal error
- Can't access WP Admin

**Solutions:**
1. ✅ Check debug.log for error:
   - `/wp-content/debug.log`
2. ✅ Via FTP/SFTP, rename plugin folder:
   - `gp-premium` → `gp-premium-backup`
3. ✅ Access WP Admin again
4. ✅ Check PHP version (requires 7.4+)
5. ✅ Verify WordPress version (requires 5.8+)
6. ✅ Reinstall plugin fresh download
7. ✅ Check for memory limit issues

---

## Next Steps

### Immediate Next Steps (Phase 06 Complete)

1. ✅ GP Premium installed and activated
2. ✅ License activated (Lifetime)
3. ✅ Modules enabled (Elements, Backgrounds, Typography, Colors, Spacing)
4. ✅ First Block Element created (Header)
5. ✅ Display rules configured
6. ✅ Frontend verified

### Phase 07: Migration Planning

**Next Actions:**
1. Audit existing PHP templates (90 files)
2. Map templates to Block Elements
3. Plan CPT migration strategy
4. Plan component migration strategy
5. Create migration timeline

**See:**
- `/plans/260104-universal-paper-stack-scroll/phase-00-generatepress-migration-overview.md`
- Phase files for detailed implementation

### Phase 08: CPT Templates

**Planned Elements:**
1. Content Template: Solutions (replace `single-solutions.php`)
2. Content Template: Case Studies (replace `single-case-studies.php`)
3. Loop Template: Solutions Archive (replace `archive-solutions.php`)
4. Loop Template: Case Studies Archive (replace `archive-case-studies.php`)

### Phase 09: Component Migration

**Planned Elements:**
1. Page Hero: Fleet Safe Pro
2. Page Hero: About AITSC
3. Page Hero: Contact
4. Hook Element: Paper Stack assets
5. Block Elements: All reusable components

### Phase 10: Styling & Design System

**Planned Tasks:**
1. Configure global colors in GP Colors module
2. Configure typography in GP Typography module
3. Migrate critical CSS to child theme
4. Test responsive design
5. Optimize performance

---

## Resources

### Official Documentation
- **GeneratePress Docs:** https://docs.generatepress.com
- **Elements Module:** https://docs.generatepress.com/article/elements-overview/
- **Block Elements:** https://docs.generatepress.com/article/block-element-overview/
- **Display Rules:** https://docs.generatepress.com/article/display-rules/
- **Hooks List:** https://docs.generatepress.com/collection/hooks/

### Video Tutorials
- **GP Theme Builder:** https://generatepress.com/introducing-the-gp-theme-builder
- **Dynamic Data:** https://generatepress.com/build-dynamic-wordpress-with-generatepress
- **GenerateBlocks:** https://generateblocks.com/documentation/

### Community Support
- **GP Forums:** https://generatepress.com/forums/
- **GP Facebook Group:** https://www.facebook.com/groups/generatepress/
- **GP Discord:** https://discord.gg/generatepress

### AITSC Project Resources
- **Setup Guide:** `/SETUP-GUIDE.md`
- **Migration Overview:** `/plans/260104-universal-paper-stack-scroll/phase-00-generatepress-migration-overview.md`
- **Child Theme:** `/wp-content/themes/aitsc-gp-child/`
- **Research Report:** `/plans/260104-universal-paper-stack-scroll/reports/researcher-260106-generatepress-premium-comprehensive.md`

---

## Summary

**Phase 06 Status:** ✅ READY FOR EXECUTION

**Completed:**
- ✅ GP Premium setup guide created
- ✅ Installation steps documented
- ✅ License activation steps documented
- ✅ Module configuration strategy defined
- ✅ Elements strategy mapped
- ✅ First Element creation guide written
- ✅ Display conditions explained
- ✅ Activation checklist created
- ✅ Troubleshooting guide included

**Next:**
- Execute manual installation steps
- Verify activation
- Create first Block Element
- Proceed to Phase 07 (Migration Planning)

**Estimated Time for Manual Setup:** 30-45 minutes

---

**Document Version:** 1.0
**Last Updated:** January 6, 2026
**Author:** Claude Code Assistant
**Project:** AITSC GeneratePress Migration

---

## Appendices

### Appendix A: Quick Command Reference

**Access WP Admin:**
```
URL: http://localhost:8888/aitsc-wp-copy/wp-admin/
```

**GP Premium Settings:**
```
Path: Appearance > GeneratePress
```

**Elements Management:**
```
Path: Appearance > GeneratePress > Elements
URL: /wp-admin/admin.php?page=generatepress_elements
```

**License Activation:**
```
Key: de485e6af6e7e30eb60dbe638d50e55f
Type: Lifetime
```

### Appendix B: Module Quick Toggle

**Critical Modules (Enable First):**
```
Elements: ✅ CRITICAL
Backgrounds: ✅ YES
Typography: ✅ YES
Colors: ✅ YES
Spacing: ✅ YES
```

**Optional Modules (Enable As Needed):**
```
Secondary Nav: ⚠️ OPTIONAL
Menu Plus: ⚠️ OPTIONAL
Sticky: ⚠️ OPTIONAL
```

### Appendix C: Element Creation URL

**Direct Link to Create Element:**
```
/wp-admin/admin.php?page=generatepress_elements&action=add
```

**Edit Specific Element:**
```
/wp-admin/admin.php?page=generatepress_elements&action=edit&element_id={ID}
```

### Appendix D: Debug Information

**Enable WP_DEBUG:**
```php
// In wp-config.php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
```

**Debug Log Location:**
```
/wp-content/debug.log
```

**Check via Terminal:**
```bash
tail -f /Applications/MAMP/htdocs/aitsc-wp-copy/wp-content/debug.log
```

---

**END OF GP PREMIUM SETUP GUIDE**
