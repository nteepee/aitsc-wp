# Phase 02: GeneratePress Setup

**Date:** 2026-01-06
**Parent:** [phase-00-generatepress-migration-overview.md](./phase-00-generatepress-migration-overview.md)
**Priority:** CRITICAL
**Status:** IN PROGRESS
**Review Status:** Pending Approval

**Duration:** 2 days (16 hours)
**Dependencies:** Phase 01 ✅ Complete

---

## Context Links

**Parent Plan:** [plan.md](./plan.md)
**Previous:** [phase-01-preparation-backup.md](./phase-01-preparation-backup.md) ✅ Complete
**Next:** [phase-03-cpt-acf-migration.md](./phase-03-cpt-acf-migration.md)

**References:**
- Current Theme: `/wp-content/themes/aitsc-pro-theme/`
- Backup: `/backups/pre-migration-20260106/`
- Target: `/wp-content/themes/aitsc-gp-child/`
- GP Docs: https://docs.generatepress.com

---

## Overview

**Description:** Install GeneratePress Premium, create child theme, and preserve core functionality (CPTs, ACF, components).

**Purpose:** Set up GP framework while maintaining all custom functionality.

**Key Deliverables:**
1. GP child theme created
2. functions.php with preserved code
3. CPT registration preserved
4. ACF fields preserved (merged)
5. Component shortcodes preserved
6. Paper Stack animations preserved

---

## Key Insights

⚠️ **Critical:** Cannot install GP without license - manual step required
✅ **Quick Win:** Child theme structure is simple
🎯 **Focus:** Preserve ALL PHP functionality in child theme

---

## Requirements

### Must Have
- [REQ-01] Child theme directory created
- [REQ-02] Child theme style.css with proper header
- [REQ-03] Child theme functions.php with preserved includes
- [REQ-04] CPT registration preserved
- [REQ-05] ACF fields preserved (merged from 3 files)
- [REQ-06] Component shortcodes preserved
- [REQ-07] Paper Stack animations preserved

### Should Have
- [REQ-08] GP Premium installed (manual step)
- [REQ-09] GB Pro installed (manual step)

### Nice to Have
- [REQ-10] GP modules configured

---

## Architecture

### Child Theme Structure
```
/wp-content/themes/aitsc-gp-child/
├── style.css (child theme header)
├── functions.php (simplified, preserved code)
├── inc/
│   ├── custom-post-types.php (preserved)
│   ├── acf-fields.php (merged from 3 files)
│   ├── components.php (preserved)
│   ├── paper-stack.php (preserved)
│   ├── contact-ajax.php (preserved)
│   └── template-tags.php (simplified)
├── components/
│   └── paper-stack/ (preserved from current)
└── assets/
    └── js/ (Paper Stack fallback only)
```

### Preserved Files Mapping
```
Current → Child Theme
inc/custom-post-types.php → inc/custom-post-types.php (KEEP)
inc/acf-fields.php → inc/acf-fields.php (MERGE others)
inc/acf-solution-fields.php → MERGE into acf-fields.php
inc/acf-seo-fields.php → MERGE into acf-fields.php
inc/components.php → inc/components.php (KEEP)
inc/paper-stack-config.php → inc/paper-stack.php (KEEP)
inc/contact-ajax.php → inc/contact-ajax.php (KEEP)
components/paper-stack/* → components/paper-stack/* (KEEP)
```

---

## Related Code Files

### Files to Read
1. `/wp-content/themes/aitsc-pro-theme/functions.php` - Dependencies
2. `/wp-content/themes/aitsc-pro-theme/inc/custom-post-types.php` - CPT logic
3. `/wp-content/themes/aitsc-pro-theme/inc/acf-fields.php` - ACF main
4. `/wp-content/themes/aitsc-pro-theme/inc/acf-solution-fields.php` - Merge target
5. `/wp-content/themes/aitsc-pro-theme/inc/acf-seo-fields.php` - Merge target

### Files to Create
1. `/wp-content/themes/aitsc-gp-child/style.css` - Child theme header
2. `/wp-content/themes/aitsc-gp-child/functions.php` - Preserved code
3. `/wp-content/themes/aitsc-gp-child/inc/*.php` - Preserved includes

---

## Implementation Steps

### Step 1: Create Child Theme Directory (5 min)

```bash
mkdir -p "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child"
mkdir -p "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/inc"
mkdir -p "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/components/paper-stack"
mkdir -p "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/assets/js"
```

**Checklist:**
- [ ] aitsc-gp-child directory created
- [ ] inc subdirectory created
- [ ] components subdirectory created
- [ ] assets subdirectory created

---

### Step 2: Create style.css (5 min)

**File:** `/wp-content/themes/aitsc-gp-child/style.css`

```css
/*
Theme Name: AITSC GeneratePress Child
Theme URI: https://aitsc.com
Description: AITSC child theme for GeneratePress
Author: Antigravity
Author URI: https://antigravity.com
Template: generatepress
Version: 1.0.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: aitsc-gp
*/

/* =Theme Variables
------------------------------------------- */

:root {
    /* GP will handle most colors via Customizer */
    /* Add custom variables here if needed */
}
```

**Checklist:**
- [ ] style.css created
- [ ] Template: generatepress specified
- [ ] All required fields present

---

### Step 3: Create functions.php (2 hours)

**Strategy:** Preserve only essential includes, remove GP handles

**File:** Read current first
```bash
cat /wp-content/themes/aitsc-pro-theme/functions.php
```

**File:** `/wp-content/themes/aitsc-gp-child/functions.php`

```php
<?php
/**
 * AITSC GeneratePress Child Theme
 *
 * @package AITSC_GP_Child
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Constants
define('AITSC_GP_VERSION', '1.0.0');
define('AITSC_GP_THEME_DIR', get_stylesheet_directory());
define('AITSC_GP_THEME_URI', get_stylesheet_directory_uri());

/**
 * Enqueue parent theme style
 */
function aitsc_gp_parent_enqueue() {
    wp_enqueue_style('generatepress-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'aitsc_gp_parent_enqueue');

/**
 * Load preserved modules
 */
require_once AITSC_GP_THEME_DIR . '/inc/custom-post-types.php';
require_once AITSC_GP_THEME_DIR . '/inc/acf-fields.php';
require_once AITSC_GP_THEME_DIR . '/inc/components.php';
require_once AITSC_GP_THEME_DIR . '/inc/paper-stack.php';
require_once AITSC_GP_THEME_DIR . '/inc/contact-ajax.php';
require_once AITSC_GP_THEME_DIR . '/inc/template-tags.php';

// Note: The following are NOT needed (handled by GP):
// - enqueue.php (GP handles)
// - theme-options.php (GP Customizer)
// - customizer.php (GP Customizer)
// - customizer-callbacks.php (GP Customizer)
// - customizer/panels/* (GP Customizer)
```

**Checklist:**
- [ ] functions.php created
- [ ] Parent theme style enqueued
- [ ] Preserved includes added
- [ ] Removed GP-handled includes
- [ ] No PHP errors

---

### Step 4: Copy & Preserve CPT Registration (1 hour)

**Source:** `/wp-content/themes/aitsc-pro-theme/inc/custom-post-types.php`
**Target:** `/wp-content/themes/aitsc-gp-child/inc/custom-post-types.php`

```bash
cp "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-pro-theme/inc/custom-post-types.php" \
   "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/inc/custom-post-types.php"

echo "✅ CPT registration copied"
```

**Verification:**
```bash
grep "register_post_type" "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/inc/custom-post-types.php"
```

**Checklist:**
- [ ] custom-post-types.php copied
- [ ] Solutions CPT registration present
- [ ] Case Studies CPT registration present
- [ ] No modifications needed

---

### Step 5: Merge ACF Fields (2 hours)

**Task:** Merge 3 ACF files into 1

**Files to merge:**
1. `inc/acf-fields.php` (base)
2. `inc/acf-solution-fields.php` (merge into base)
3. `inc/acf-seo-fields.php` (merge into base)

**Process:**
```bash
# Create merged file
cat "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-pro-theme/inc/acf-fields.php" > \
    "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/inc/acf-fields.php"

echo "" >> "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/inc/acf-fields.php"
echo "" >> "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/inc/acf-fields.php"
echo "// Merged from acf-solution-fields.php" >> "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/inc/acf-fields.php"
cat "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-pro-theme/inc/acf-solution-fields.php" >> \
    "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/inc/acf-fields.php"

echo "" >> "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/inc/acf-fields.php"
echo "" >> "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/inc/acf-fields.php"
echo "// Merged from acf-seo-fields.php" >> "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/inc/acf-fields.php"
cat "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-pro-theme/inc/acf-seo-fields.php" >> \
    "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/inc/acf-fields.php"

echo "✅ ACF fields merged (3 files → 1)"
```

**Checklist:**
- [ ] acf-fields.php created (merged)
- [ ] Contains content from all 3 files
- [ ] Section comments added
- [ ] No PHP errors

---

### Step 6: Copy Components (1 hour)

**Source:** `/wp-content/themes/aitsc-pro-theme/inc/components.php`
**Target:** `/wp-content/themes/aitsc-gp-child/inc/components.php`

```bash
cp "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-pro-theme/inc/components.php" \
   "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/inc/components.php"

echo "✅ Components registration copied"
```

**Verification:**
```bash
grep "add_shortcode" "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/inc/components.php" | wc -l
# Should show 16 shortcodes
```

**Checklist:**
- [ ] components.php copied
- [ ] 16 shortcodes present
- [ ] aitsc_load_components() present

---

### Step 7: Copy Paper Stack (30 min)

**Files:**
1. `inc/paper-stack-config.php` → `inc/paper-stack.php`
2. `components/paper-stack/paper-stack.php` → `components/paper-stack/paper-stack.php`
3. `assets/js/paper-stack-fallback.js` → `assets/js/paper-stack-fallback.js`

```bash
# Copy PHP config
cp "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-pro-theme/inc/paper-stack-config.php" \
   "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/inc/paper-stack.php"

# Copy component PHP
mkdir -p "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/components/paper-stack"
cp "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-pro-theme/components/paper-stack/paper-stack.php" \
   "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/components/paper-stack/paper-stack.php"

# Copy JS if exists
if [ -f "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-pro-theme/assets/js/paper-stack-fallback.js" ]; then
    cp "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-pro-theme/assets/js/paper-stack-fallback.js" \
       "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/assets/js/paper-stack-fallback.js"
fi

echo "✅ Paper Stack copied"
```

**Checklist:**
- [ ] paper-stack.php copied
- [ ] paper-stack component copied
- [ ] JS fallback copied (if exists)

---

### Step 8: Copy Contact AJAX (30 min)

**Source:** `/wp-content/themes/aitsc-pro-theme/inc/contact-ajax.php`
**Target:** `/wp-content/themes/aitsc-gp-child/inc/contact-ajax.php`

```bash
cp "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-pro-theme/inc/contact-ajax.php" \
   "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/inc/contact-ajax.php"

echo "✅ Contact AJAX copied"
```

**Checklist:**
- [ ] contact-ajax.php copied
- [ ] AJAX handlers present

---

### Step 9: Copy Template Tags (30 min)

**Source:** `/wp-content/themes/aitsc-pro-theme/inc/template-tags.php`
**Target:** `/wp/content/themes/aitsc-gp-child/inc/template-tags.php`

```bash
cp "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-pro-theme/inc/template-tags.php" \
   "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/inc/template-tags.php"

echo "✅ Template tags copied"
```

**Checklist:**
- [ ] template-tags.php copied
- [ ] Helper functions present

---

### Step 10: Verify Child Theme (30 min)

```bash
# List all child theme files
find "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child" -type f

# Count PHP files
find "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child" -name "*.php" | wc -l

# Verify structure
ls -la "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/inc/"
ls -la "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-gp-child/components/"
```

**Checklist:**
- [ ] style.css exists with correct header
- [ ] functions.php exists
- [ ] inc/ directory has 7 PHP files
- [ ] components/paper-stack/ exists
- [ ] Total PHP files: 8+

---

## Todo List

### Step 1: Create Directory Structure
- [ ] aitsc-gp-child created
- [ ] inc/ created
- [ ] components/paper-stack/ created
- [ ] assets/js/ created

### Step 2: style.css
- [ ] Created with proper header
- [ ] Template: generatepress

### Step 3: functions.php
- [ ] Created with preserved includes
- [ ] Parent theme enqueued
- [ ] GP includes removed

### Step 4: CPT Registration
- [ ] custom-post-types.php copied
- [ ] Solutions CPT present
- [ ] Case Studies CPT present

### Step 5: Merge ACF Fields
- [ ] Merged 3 files into 1
- [ ] acf-fields.php created
- [ ] All sections present

### Step 6: Components
- [ ] components.php copied
- [ ] 16 shortcodes present

### Step 7: Paper Stack
- [ ] paper-stack.php copied
- [ ] Component copied
- [ ] JS copied

### Step 8: Contact AJAX
- [ ] contact-ajax.php copied

### Step 9: Template Tags
- [ ] template-tags.php copied

### Step 10: Verification
- [ ] All files present
- [ ] Structure correct
- [ ] No PHP errors

---

## Success Criteria

### Phase Success
- [ ] Child theme created
- [ ] All preserved files copied
- [ ] ACF fields merged (3→1)
- [ ] No PHP errors in includes
- [ ] Structure matches plan

### Quality Gates
- [ ] style.css has Template: generatepress
- [ ] functions.php enqueues parent
- [ ] All 7 preserved files present
- [ ] CPT registration intact
- [ ] Component shortcodes intact

---

## Risk Assessment

### Medium Risk
- [R-01] ACF merge may have conflicts → **Mitigation:** Add section comments, test individually

### Low Risk
- [R-02] Missing dependencies → **Mitigation:** Verification step catches this
- [R-03] Paper Stack breaks → **Mitigation:** No changes to code, just location

---

## Security Considerations

- [ ] All PHP files start with `if (!defined('ABSPATH'))`
- [ ] No sensitive data in backups
- [ ] Child theme cannot be activated directly (needs GP parent)

---

## File Tracking

### Files Created in Phase 02

| File | Source | Purpose | Status |
|------|--------|---------|--------|
| style.css | New | Child theme header | 🔄 |
| functions.php | Simplified from original | Core setup | 🔄 |
| inc/custom-post-types.php | Preserved | CPTs | 🔄 |
| inc/acf-fields.php | Merged from 3 files | ACF fields | 🔄 |
| inc/components.php | Preserved | Shortcodes | 🔄 |
| inc/paper-stack.php | Preserved | Animations | 🔄 |
| inc/contact-ajax.php | Preserved | AJAX | 🔄 |
| inc/template-tags.php | Preserved | Helpers | 🔄 |

### Status Legend
- 🔄 TODO - Not started
- 🟡 IN_PROGRESS - Working on it
- ✅ COMPLETE - Done

---

## Next Steps

**After Phase 02 Complete:**
→ Review codebase changes
→ Update migration-tracking.md
→ Proceed to Phase 03 (CPT & ACF Migration)

**Cannot Proceed Until:**
- [ ] All 8 preserved files copied
- [ ] Child theme structure verified
- [ ] No PHP errors

---

**Phase Status:** IN PROGRESS
**Estimated Hours:** 8 hours
**Confidence Level:** HIGH (straightforward file copies)
