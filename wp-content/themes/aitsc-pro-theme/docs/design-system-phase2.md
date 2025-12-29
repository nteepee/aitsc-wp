# Design System Phase 2: CSS Audit Complete (Lines 1000-2800)

**Date:** 2025-12-24
**File:** `/Applications/MAMP/htdocs/aitsc-wp/wp-content/themes/aitsc-pro-theme/style.css`
**Lines Audited:** 1-2800 (COMPLETE)
**Status:** ⚠️ ADDITIONAL DUPLICATES FOUND

---

## Executive Summary

**Phase 1** found 7 duplicates (lines 1-1000).
**Phase 2** found **11 additional duplicates** (lines 1000-2800).

**Total: 18 duplicate class definitions** causing unpredictable rendering.

---

## Complete Duplicate Registry (Lines 1-2800)

### Previously Known (from Phase 1)
| Class | First | Second | Conflict |
|-------|-------|--------|----------|
| `.btn-primary` | 640 | 718 | Gradient vs solid |
| `.btn-secondary` | 653 | 729 | Outline vs solid bg |
| `.btn-outline` | 664 | 742 | Different hover |
| `.btn-sm` | 686 | 702 | Different padding vars |
| `.btn-lg` | 691 | 707 | Different padding vars |
| `.btn-xl` | 696 | 712 | Different padding vars |
| `.text-body` | 339 | 374 | Line-height 1.7 vs 1.625 |

### Newly Found (Phase 2)
| Class | First | Second | Conflict |
|-------|-------|--------|----------|
| `.hero-stats` | 1277 | 2529 | Gap 2rem vs var(--space-12) |
| `.stat-item` | 1284 | 2537 | Min-width undefined vs 120px |
| `.stat-number` | 1288 | 2542 | Font-size var(--font-size-4xl) vs 2.5rem |
| `.stat-label` | 1296 | 2552 | Font-size var(--font-size-sm) vs 0.875rem |
| `.hero-container` | 1225 | 1658 | Duplicate definitions |
| `.hero-content` | 1233 | 1667 | Duplicate definitions |
| `.hero-title` | 1239 | 1672 | Font var(--font-size-5xl) vs var(--aitsc-font-5xl) |
| `.hero-subtitle` | 1266 | 1682 | Different color values |
| `.social-link` | 1006 | 1577 | Duplicate in footer section |
| `.form-group` | 1542 | 1906 | Margin-bottom undefined vs var(--aitsc-space-lg) |
| `.skip-link` | 1039 | 2379 | Duplicate definitions |

---

## Section-by-Section Analysis (Lines 1000-2800)

### Lines 1000-1500: Navigation, Hero, Footer
**Status:** ⚠️ Minor duplicates
- `.social-link` (1006) = same as footer version (1577)
- `.hero-*` classes (1225-1275) = duplicated later (1658-1688)
- `.skip-link` (1039) = duplicated in accessibility section (2379)

### Lines 1500-2000: Footer, Cards, Forms
**Status:** ⚠️ Minor duplicates
- `.hero-*` duplicates from earlier (1658-1688)
- `.form-group` first definition (1542)
- `.card-*` components (1746-1822) - clean, no duplicates

### Lines 2000-2500: Animations, Backgrounds, Responsive
**Status:** ✅ Clean
- Animations keyframes (1978-2041)
- Background effects (2083-2115)
- Responsive breakpoints (2148-2260)
- No new duplicates found

### Lines 2500-2800: Hero Stats, Widgets
**Status:** ⚠️ Hero stats duplicates
- `.hero-stats` second definition (2529)
- `.stat-item`, `.stat-number`, `.stat-label` duplicates (2537-2559)
- Widget styles (2687-2788) - clean
- h1 redefinition (2791) - overrides earlier

---

## Critical Observations

### 1. Hero Section Chaos
The hero section is defined **3 times** with conflicting values:
- Lines 1173-1325: WorldQuant hero (modern, uses `var(--font-size-*)`)
- Lines 1658-1700: AITSC hero (legacy, uses `var(--aitsc-font-*)`)
- Lines 2529-2674: Stats enhancement (hardcoded values)

### 2. Variable Inconsistency
Two naming conventions create conflicts:
- WorldQuant system: `--font-size-*`, `--space-*`
- AITSC system: `--aitsc-font-*`, `--aitsc-space-*`

### 3. h1 Override
Line 2791 redefines `h1` which was already defined at line 297.

---

## Recommendations

### Immediate Actions (Phase 2: Consolidation)

#### Remove Lines 701-752 (AITSC Button System)
```css
/* DELETE lines 701-752 */
701-715: .btn-sm, .btn-lg, .btn-xl (AITSC)
718-727: .btn-primary (AITSC)
729-740: .btn-secondary (AITSC)
742-752: .btn-outline (AITSC)
```

#### Remove Lines 374-379
```css
/* DELETE line 374-379 */
.text-body duplicate
```

#### Remove Hero Duplicates (Lines 1658-1700)
```css
/* DELETE lines 1658-1700 */
.hero-container, .hero-content, .hero-title, .hero-subtitle
(Wait - these use AITSC variables, WorldQuant versions at 1173-1325 should be KEPT)
```
**DECISION:** Keep WorldQuant hero (1173-1325), remove AITSC hero (1658-1700).

#### Remove Hero Stats Duplicate (Lines 1277-1302 OR 2529-2559)
```css
/* Lines 2529-2559 are newer enhancements with animations
   Lines 1277-1302 are from original hero section
   KEEP lines 2529-2559 (with animations), DELETE 1277-1302 */
```

#### Remove Other Duplicates
```css
/* DELETE: Line 1039-1053 (.skip-link in nav section) - keep 2379 version */
/* DELETE: Line 1577-1595 (.social-link in footer) - keep 1006 version */
/* DELETE: Line 1542-1562 (.form-group in footer) - keep 1906 version */
```

---

## Consolidation Plan

### Keep These (Primary Definitions)
- Buttons: Lines 612-699 (WorldQuant system)
- Typography: Lines 289-387 (keep first `.text-body`)
- Navigation: Lines 787-1167 (mobile menu, etc.)
- Hero: Lines 1173-1325 (WorldQuant hero)
- Stats: Lines 2529-2674 (enhanced with animations)
- Forms: Lines 1906-1973 (form-group, inputs)
- Footer: Lines 1403-1656
- Cards: Lines 1705-1901

### Delete These (Duplicates)
- Lines 374-379: `.text-body` duplicate
- Lines 701-752: AITSC button system
- Lines 1039-1053: `.skip-link` in nav (keep accessibility section version)
- Lines 1277-1302: Old `.hero-stats` (keep enhanced version)
- Lines 1542-1562: Old `.form-group` in footer
- Lines 1577-1595: Footer `.social-link` duplicate
- Lines 1658-1700: AITSC hero duplicate
- Line 2791: `h1` redefinition

---

## File Size Impact

**Before:** ~2800 lines
**After consolidation:** ~2650 lines (delete ~150 lines)
**Reduction:** ~5%

---

## Next Steps

1. ✅ Phase 1 audit complete (lines 1-1000)
2. ✅ Phase 2 audit complete (lines 1000-2800)
3. ⏭️ Phase 2: Execute consolidation (delete ~150 lines)
4. ⏭️ Phase 3: Rate limiting
5. ⏭️ Phase 4: Framework decision
6. ⏭️ Phase 5: Testing

---

**Session Resume:** `/cook Phase 2 Consolidation`
