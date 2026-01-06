# Codebase Deep Dive Review - AITSC Pro Theme

**Date:** 2026-01-06
**Environment:** Development Copy (`aitsc-wp copy`)
**Production:** Safe (untouched `aitsc-wp`)

---

## Environment Confirmed ✅

```
Original:    /Applications/MAMP/htdocs/aitsc-wp/     (PRODUCTION - SAFE)
Copy:        /Applications/MAMP/htdocs/aitsc-wp copy/ (DEVELOPMENT - TEST)
Copy Date:   January 6, 2026 02:37
```

**Database:** `aitsctest_wp`
**URL:** `http://localhost:8888/aitsc-wp`

---

## Theme Architecture Analysis

### File Inventory
```
aitsc-pro-theme/
├── Root Templates:    17 PHP files
├── Components:        16 PHP files
├── Includes:          15 PHP files
├── Customizer:        8 PHP files
├── Template Parts:    22 PHP files
├── Solution Parts:    14 PHP files
└── Total:             90 PHP files
```

### Component Shortcodes Registered (6 main)
1. `[aitsc_card]` - Card component
2. `[aitsc_hero]` - Hero sections
3. `[aitsc_cta]` - Call-to-action
4. `[aitsc_stats]` - Stats counter
5. `[aitsc_testimonials]` - Testimonials carousel
6. Helper functions: `aitsc_component_feature_box()`, `aitsc_component_spec_table()`, etc.

---

## ⚠️ CRITICAL FINDING: Hardcoded Theme References

### Issue: `AITSC_THEME_DIR` Constant

**Location:** `functions.php:17`
```php
define('AITSC_THEME_DIR', get_template_directory());
```

**Problem:**
- `get_template_directory()` returns **parent** theme path
- When switching to child theme (GP), this breaks ALL includes
- 636 references to `AITSC_THEME_DIR` in theme files
- 13 `require_once` statements use this constant

**Impact:**
- ❌ All includes will fail
- ❌ CPTs won't register
- ❌ Components won't load
- ❌ ACF fields won't register
- ❌ Paper Stack won't load

**Fix Required in Child Theme:**
```php
// In aitsc-gp-child/functions.php
define('AITSC_THEME_DIR', get_stylesheet_directory()); // Use child theme path
define('AITSC_THEME_URI', get_stylesheet_directory_uri());
```

---

## Template Dependencies Map

### Root Templates → Dependencies

| Template | Includes | Risk |
|----------|----------|------|
| `page-fleet-safe-pro.php` | global-background, 14+ solution parts | HIGH |
| `single-solutions.php` | overview, features, sections, specs, gallery, etc. | HIGH |
| `single-case-studies.php` | enhanced content template | MEDIUM |
| `page-contact.php` | contact-form-advanced | LOW |
| `page-about-aitsc.php` | Standard page template | LOW |
| `front-page.php` | hero-advanced, cta-advanced | MEDIUM |

### Solution Template Parts (14 files)
```
template-parts/solution/
├── overview.php           (9.5 KB)
├── features.php           (3.5 KB)
├── specs.php              (3.5 KB)
├── sections.php           (4.5 KB)
├── hero.php               (7.7 KB)
├── hero-fleet.php         (8.9 KB)
├── gallery.php            (4.9 KB)
├── cta.php                (9.5 KB)
├── case-studies.php       (3.4 KB)
├── related-pages.php      (2.1 KB)
├── ecosystem.php          (2.2 KB)
├── tech-solutions.php     (2.6 KB)
├── science.php            (2.1 KB)
└── blog-insights.php      (2.8 KB)
```

---

## CPT Architecture

### Solutions CPT
- **Slug:** `solutions`
- **Archive:** `archive-solutions.php` (130 lines)
- **Single:** `single-solutions.php` (420 lines)
- **Taxonomy:** `solution_category`
- **Template Parts:** 14 specialized files

### Case Studies CPT
- **Slug:** `case_studies`
- **Archive:** `archive-case-studies.php` (95 lines)
- **Single:** `single-case-studies.php` (180 lines)
- **Enhanced:** `template-parts/content-case-studies-enhanced.php` (320 lines)

---

## Custom Page Templates

### Fleet Safe Pro Page (COMPLEX)
- **File:** `page-fleet-safe-pro.php`
- **Lines:** 1,350 (largest template)
- **Complexity:** HIGH
- **Dependencies:** 14+ solution parts
- **Content:** Multiple sections, tabs, galleries

**Migration Strategy:** Use GP Block Element with GB Pro blocks

---

## Database-Content Dependencies

### Shortcodes in Content (Need Verification)
Expected in database:
- `[aitsc_hero]` - Used on landing pages
- `[aitsc_card]` - Feature cards
- `[aitsc_cta]` - Call-to-action sections
- `[aitsc_stats]` - Statistics counters
- `[aitsc_testimonials]` - Testimonials

**Action:** Query database to confirm usage

---

## ACF Field Groups

### Main Fields (acf-fields.php)
- Solution Page Content (group_solution_page)
- Hero Section
- Overview Content
- Key Features (repeater)
- Technical Specifications
- Product Gallery
- Flexible Content Sections (3 layouts)
- Related Case Studies
- CTA Section

### Solution Fields (acf-solution-fields.php)
- Solution Hero Section
- Solution Overview
- Solution Features
- Solution Specifications
- Solution Gallery
- Solution Case Studies
- Solution CTA Section

### SEO Fields (acf-seo-fields.php)
- SEO Meta Tags (meta description, OG image)

**Total Field Groups:** 12+
**Total Fields:** 90+

---

## Paper Stack Animations

### Implementation
- **Config:** `inc/paper-stack-config.php` (336 lines)
- **Component:** `components/paper-stack/paper-stack.php`
- **Technology:** CSS Scroll-Driven Animations API
- **Fallback:** Intersection Observer

**Preservation:** ✅ Already copied to child theme

---

## AJAX Contact Form

### File: `inc/contact-ajax.php` (419 lines)
- AJAX form submission
- Form validation
- CAPTCHA support
- Email sending

**Preservation:** ✅ Already copied to child theme

---

## Migration Risk Assessment

### Critical Risks (Must Fix)
1. ❌ `AITSC_THEME_DIR` constant breaks all includes
2. ❌ 636 references to theme constant
3. ❌ Template dependencies will break

### High Risk Areas
1. ⚠️ `page-fleet-safe-pro.php` (1,350 lines, complex)
2. ⚠️ `single-solutions.php` (420 lines, 14 template parts)
3. ⚠️ Custom template hierarchy

### Medium Risk Areas
1. ⚠️ Solution template parts (14 files)
2. ⚠️ Component shortcodes in content
3. ⚠️ ACF field dependencies

### Low Risk Areas
1. ✅ CPT registration (preserved)
2. ✅ ACF fields (preserved)
3. ✅ Paper Stack (preserved)
4. ✅ Contact AJAX (preserved)

---

## Required Fixes Before Activation

### Fix 1: Update Child Theme Constants

**File:** `aitsc-gp-child/functions.php`

```php
// REPLACE:
define('AITSC_GP_THEME_DIR', get_stylesheet_directory());
define('AITSC_GP_THEME_URI', get_stylesheet_directory_uri());

// WITH:
define('AITSC_GP_THEME_DIR', get_stylesheet_directory());
define('AITSC_GP_THEME_URI', get_stylesheet_directory_uri());

// ADD BACKWARDS COMPATIBILITY:
define('AITSC_THEME_DIR', AITSC_GP_THEME_DIR); // For legacy includes
define('AITSC_THEME_URI', AITSC_GP_THEME_URI); // For legacy includes
```

### Fix 2: Add Template Fallbacks

If template parts don't exist in child theme, fall back to original:

```php
// In child theme functions.php
function aitsc_gp_template_fallback($template) {
    // Try child theme first
    $child_template = get_stylesheet_directory() . '/' . basename($template);

    // Fall back to original theme if needed
    if (!file_exists($template) && file_exists($child_template)) {
        // Check original theme
        $original_template = get_template_directory() . '/' . basename($template);
        if (file_exists($original_template)) {
            return $original_template;
        }
    }

    return $template;
}
add_filter('template_include', 'aitsc_gp_template_fallback');
```

---

## Migration Strategy Update

### Phase 03 Revised Scope

**Before:** Activate child theme and verify CPTs
**After:** Apply constant fixes FIRST, then activate

**New Steps:**
1. Fix `AITSC_THEME_DIR` constant in child theme
2. Add backwards compatibility defines
3. Add template fallback function
4. Flush permalinks
5. Activate child theme
6. Verify CPTs still registered
7. Verify template parts still load
8. Proceed with GP Element creation

---

## Next Actions

### Immediate (Before Activation)
- [ ] Fix theme constants in child theme
- [ ] Add backwards compatibility layer
- [ ] Add template fallbacks
- [ ] Test includes work correctly

### After Activation
- [ ] Verify CPTs appear in admin
- [ ] Check single-solutions.php loads
- [ ] Check solution template parts load
- [ ] Verify ACF fields accessible
- [ ] Test frontend (expect broken styling)

---

## Conclusion

**Current Status:** Child theme created but **NOT READY** for activation
**Blocker:** Theme constant references will break all includes
**Fix Time:** 30 minutes
**Risk Level:** HIGH (but fixable)

**Recommendation:** Apply fixes before attempting activation

---

**Review Complete:** 2026-01-06
**Reviewer:** Claude Code
**Confidence:** HIGH
