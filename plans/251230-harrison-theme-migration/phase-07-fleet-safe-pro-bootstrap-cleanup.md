# Phase 7: Fleet Safe Pro - Bootstrap Cleanup & Component Standardization

**Plan**: 251230-harrison-theme-migration
**Created**: 2026-01-02 10:58
**Priority**: HIGH
**Status**: **COMPLETED ✅**

---

## Context

Fleet Safe Pro page (`page-fleet-safe-pro.php`) is a specialized pillar page with custom dark theme. Current audit shows:

**Bootstrap Grid Violations**:
- Line 40: `class="container h-100 d-flex flex-column justify-content-center"`
- Line 41: `class="row justify-content-center text-center"`
- Line 42: `class="col-lg-10"`
- Line 615: `style="margin-top: 3rem;"` on `.aitsc-grid`

**Mixed Component Usage**:
- Custom HTML hero (lines 39-87) - KEEP (specialized marketing)
- Universal components used elsewhere (lines 477, 952) - GOOD
- Inconsistent container classes

---

## Objectives

1. **Remove ALL Bootstrap classes** from template
2. **Standardize container usage** → `aitsc-container`
3. **Maintain custom hero styling** (dark theme, particles, ticker)
4. **Ensure visual parity** - layout must look identical
5. **Verify responsive behavior** across all breakpoints

---

## Implementation Plan

### Step 1: Hero Section Cleanup (Lines 39-87)

**Current Structure**:
```html
<section class="scroll-section hero-section fleet-safe-hero" style="padding-top: 15vh; padding-bottom: 10vh; min-height: 100vh; position: relative; display: flex; align-items: center;">
    <div class="container h-100 d-flex flex-column justify-content-center">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10">
                <!-- Content -->
            </div>
        </div>
    </div>
</section>
```

**Target Structure**:
```html
<section class="scroll-section hero-section fleet-safe-hero" style="padding-top: 15vh; padding-bottom: 10vh; min-height: 100vh; position: relative;">
    <div class="aitsc-container">
        <div style="max-width: 83.33%; margin: 0 auto; text-align: center;">
            <!-- Content (col-lg-10 = 83.33% width) -->
        </div>
    </div>
</section>
```

**Changes**:
- Replace `.container` → `.aitsc-container`
- Remove `.h-100 .d-flex .flex-column .justify-content-center` (Bootstrap utilities)
- Remove `.row .justify-content-center .text-center`
- Remove `.col-lg-10`
- Add inline wrapper for centering (83.33% max-width = 10/12 columns)
- Move flexbox alignment to `.fleet-safe-hero` CSS

**CSS Updates** (lines 91-94):
```css
.fleet-safe-hero {
    position: relative;
    overflow: visible;
    display: flex;
    align-items: center;
    justify-content: center;
}
```

---

### Step 2: Content Sections - Container Standardization

**Replace all instances**:
- `.container` → `.aitsc-container`

**Files to scan**: All sections in `page-fleet-safe-pro.php`

**Verification**:
```bash
grep -n "class=\"container\"" wp-content/themes/aitsc-pro-theme/page-fleet-safe-pro.php
```

---

### Step 3: Grid System Verification

**Check all grid usage**:
```bash
grep -n "aitsc-grid" wp-content/themes/aitsc-pro-theme/page-fleet-safe-pro.php
```

**Expected grids**:
- Line 341: `aitsc-grid--2-col` (Problem cards) ✅
- Line 421: `aitsc-grid--3-col` (Features) ✅
- Line 498: `aitsc-grid--2-col` (Specs) ✅
- Line 599: `aitsc-grid--3-col` (UI Config) ✅
- Line 615: `aitsc-grid--2-col` ⚠️ Has inline `style="margin-top: 3rem;"`
- Line 629: `aitsc-grid--3-col` (Color indicators) ✅
- Line 651: `aitsc-grid--4-col` (Smart features) ✅
- Line 856: `aitsc-grid--2-col` (Compliance) ✅
- Line 926: `aitsc-grid--4-col` (Exclusions) ✅

**Action**: Remove inline style from line 615 - add spacing class instead:
```html
<!-- Before -->
<div class="aitsc-grid aitsc-grid--2-col" style="margin-top: 3rem;">

<!-- After -->
<div class="aitsc-grid aitsc-grid--2-col mt-12">
```

---

### Step 4: Card Component Verification

**Current usage** (line 477):
```php
aitsc_render_card(array(
    'variant' => 'icon',
    'title' => $feature['title'],
    'description' => $feature['description'],
    'icon' => $feature['icon'],
    'size' => 'medium'
));
```

**Verification needed**:
- Check if `variant => 'icon'` exists in component system
- Verify `size => 'medium'` parameter support
- Ensure no custom CSS conflicts

---

### Step 5: Responsive CSS Updates

**Media Queries to Update** (lines 229-330):

**Remove Bootstrap-dependent styles**:
- Any `.container` specific styles
- Grid row/column adjustments

**Add if needed**:
```css
/* Ensure hero centering on mobile */
@media (max-width: 47.9375rem) {
    .fleet-safe-hero > .aitsc-container > div {
        max-width: 100%;
        padding: 0 1rem;
    }
}
```

---

## File Changes Summary

| Line Range | Change Type | Description |
|------------|-------------|-------------|
| 40 | Class replacement | `container` → `aitsc-container`, remove Bootstrap utilities |
| 41-42 | HTML restructure | Remove `.row` and `.col-lg-10`, add centering wrapper |
| 91-94 | CSS addition | Add flexbox to `.fleet-safe-hero` |
| 615 | Inline style removal | Replace with utility class |
| All sections | Container update | Ensure all use `aitsc-container` |

---

## Testing Checklist

### Visual Verification
- [x] Hero section centered correctly (desktop 1440×900)
- [x] Hero section centered correctly (tablet 768×1024)
- [x] Hero section centered correctly (mobile 375×667)
- [x] All grids maintain equal heights
- [x] Spacing consistent across sections
- [x] No layout shifts or breaks

### Technical Verification
- [x] Zero Bootstrap classes: `grep -r "class=\".*\(row\|col-\|d-flex\|justify-content\|h-100\).*\"" page-fleet-safe-pro.php`
- [x] All containers use `aitsc-container`
- [x] No inline `style=""` attributes (except specialized positioning)
- [x] Responsive breakpoints work correctly

### Functional Verification
- [x] Data ticker animation works
- [x] All links functional
- [x] Card hover states work
- [x] Gallery slider functional
- [x] Form submission works

---

## Rollback Plan

**Before changes**:
```bash
cp wp-content/themes/aitsc-pro-theme/page-fleet-safe-pro.php \
   wp-content/themes/aitsc-pro-theme/page-fleet-safe-pro.php.backup-260102
```

**Restore if needed**:
```bash
mv wp-content/themes/aitsc-pro-theme/page-fleet-safe-pro.php.backup-260102 \
   wp-content/themes/aitsc-pro-theme/page-fleet-safe-pro.php
```

---

## Success Criteria

**Primary (Must Have)**:
- [x] Zero Bootstrap grid classes remain
- [x] All containers use `aitsc-container`
- [x] Custom hero preserved (dark theme, ticker, particles)
- [x] Visual appearance identical to current
- [x] Responsive layouts work perfectly

**Secondary (Should Have)**:
- [x] No inline styles (except absolutely necessary)
- [x] Clean, maintainable code structure
- [x] Consistent spacing/utility class usage

---

## Notes

- Custom dark hero is **intentional** - specialized marketing feature per Phase 6 plan
- Do NOT convert hero to `aitsc_render_hero()` - keep custom HTML
- Focus: Remove Bootstrap, not redesign layout
- Maintain all visual fidelity - this is a cleanup, not a redesign

---

**Plan Status**: COMPLETED
**Estimated Complexity**: LOW-MEDIUM
**Files Modified**: 1 (`page-fleet-safe-pro.php`)

---

## Final Verification
- **Date**: 2026-01-02
- **Result**: 100% Bootstrap cleanup achieved. Visual layout verified on Desktop and Mobile.
- **Files**: `page-fleet-safe-pro.php` standardized.

