# Phase 1: Breakpoint Standardization

**Phase ID**: phase-1-breakpoint-standardization
**Priority**: CRITICAL
**Estimated Effort**: 4-6 hours
**Dependencies**: None
**Risk Level**: Medium

---

## Objectives

1. Reduce breakpoint count from 17 to 5 canonical values
2. Implement CSS custom properties for breakpoints
3. Migrate all media queries to standard breakpoints
4. Document breakpoint system for developers

---

## Current State Analysis

### Breakpoint Inventory

**Found in `style.css`** (3,745 lines, 34+ media queries):
```css
/* Common */
768px   (12 instances)
992px   (5 instances)
1024px  (6 instances)

/* Off-by-one */
767.98px (1 instance)
991px    (2 instances)

/* Special cases */
782px    (1 instance - WordPress admin bar?)
900px    (1 instance - unknown purpose)
1600px   (1 instance - ultra-wide displays)

/* Correct direction */
min-width: 768px  (mobile-first ✓)
max-width: 768px  (desktop-first ✗)
```

### Issues Identified

1. **Inconsistent Boundaries**: 767.98px vs 768px causes confusion
2. **Magic Numbers**: 782px, 900px lack documentation
3. **Direction Mix**: Both min-width and max-width used (should be mobile-first)
4. **Hard to Scale**: Adding new breakpoint requires global search/replace

---

## Proposed Breakpoint System

### Canonical Breakpoints (Mobile-First)

```css
/* Base: Mobile (0-575px) */
/* No media query needed - this is the default */

/* Phablet: 576px+ */
@media (min-width: 36rem) { /* 576px */ }

/* Tablet: 768px+ */
@media (min-width: 48rem) { /* 768px */ }

/* Desktop: 992px+ */
@media (min-width: 62rem) { /* 992px */ }

/* Wide Desktop: 1200px+ */
@media (min-width: 75rem) { /* 1200px */ }
```

### Rationale

- **576px (Phablet)**: Large phones (iPhone Pro Max, Pixel)
- **768px (Tablet)**: iPad Mini, small tablets
- **992px (Desktop)**: Small laptops, standard monitors
- **1200px (Wide)**: Large monitors, optimal content width

### Special Cases

```css
/* Only when absolutely necessary */

/* Reduce motion (accessibility) */
@media (prefers-reduced-motion: reduce) { }

/* Print styles */
@media print { }

/* High DPI displays */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) { }
```

---

## Implementation Steps

### Step 1: Create CSS Custom Properties

**File**: `style.css` (top of file, in `:root`)

```css
:root {
  /* Breakpoint values (for JavaScript access) */
  --breakpoint-phablet: 36rem;   /* 576px */
  --breakpoint-tablet: 48rem;    /* 768px */
  --breakpoint-desktop: 62rem;   /* 992px */
  --breakpoint-wide: 75rem;      /* 1200px */

  /* Container max-widths */
  --container-phablet: 540px;
  --container-tablet: 720px;
  --container-desktop: 960px;
  --container-wide: 1140px;
}
```

**Benefits**:
- JavaScript can read values via `getComputedStyle()`
- Single source of truth
- Easy to adjust globally

---

### Step 2: Document Breakpoint Usage

**File**: `docs/code-standards.md` (create section)

```markdown
## Responsive Breakpoints

### Standard Breakpoints

| Name     | Min-Width | Use Case                          |
|----------|-----------|-----------------------------------|
| Mobile   | 0         | Base styles (default)             |
| Phablet  | 576px     | Large phones, small tablets       |
| Tablet   | 768px     | iPads, medium tablets             |
| Desktop  | 992px     | Laptops, desktop monitors         |
| Wide     | 1200px    | Large monitors (1920x1080+)       |

### Usage Examples

#### Mobile-First (Correct)
```css
/* Base: mobile styles */
.element {
  font-size: 1rem;
}

/* Enhance for tablet+ */
@media (min-width: 48rem) {
  .element {
    font-size: 1.25rem;
  }
}
```

#### Desktop-First (Avoid)
```css
/* Don't do this */
@media (max-width: 767.98px) {
  .element {
    font-size: 1rem !important; /* !important = code smell */
  }
}
```

### When to Add New Breakpoints

**Short answer**: Don't.

**Longer answer**: Only if absolutely necessary and approved by tech lead. Consider using:
- Flexbox/Grid auto-layout (no media query needed)
- Container queries (when supported)
- Fluid typography (clamp, calc)

### Exceptions

- Accessibility media queries allowed: `prefers-reduced-motion`, `prefers-color-scheme`
- Print styles allowed: `@media print`
```

---

### Step 3: Audit Existing Media Queries

**Script to Find All Media Queries**:

```bash
cd /Applications/MAMP/htdocs/aitsc-wp/wp-content/themes/aitsc-pro-theme
grep -n "@media" style.css > media-queries-audit.txt
```

**Manual Categorization**:
Create spreadsheet with columns:
- Line number
- Current breakpoint
- Direction (min-width/max-width)
- Target breakpoint (after migration)
- Notes

**Example**:
| Line | Current                | Direction | Target   | Notes |
|------|------------------------|-----------|----------|-------|
| 550  | min-width: 768px       | mobile-first | 48rem    | ✓ Correct |
| 641  | max-width: 767.98px    | desktop-first | Convert to min-width 48rem | Needs inversion |
| 1424 | max-width: 782px       | desktop-first | Research: WP admin bar? | Special case? |

---

### Step 4: Migration Strategy

#### Pattern 1: Simple Conversion (min-width)

**Before**:
```css
@media (min-width: 768px) {
  .element { ... }
}
```

**After**:
```css
@media (min-width: 48rem) {
  .element { ... }
}
```

#### Pattern 2: Desktop-First Inversion (max-width)

**Before**:
```css
/* Base (assumed desktop) */
.element {
  font-size: 2rem;
}

/* Mobile override */
@media (max-width: 768px) {
  .element {
    font-size: 1.5rem !important;
  }
}
```

**After**:
```css
/* Base (mobile-first) */
.element {
  font-size: 1.5rem;
}

/* Tablet+ enhancement */
@media (min-width: 48rem) {
  .element {
    font-size: 2rem;
  }
}
```

**Note**: Removes `!important`, inverts logic.

#### Pattern 3: Special Case Breakpoints

**Case 3a: 782px (WordPress Admin Bar)**

**Research First**:
```css
@media screen and (max-width: 782px) {
  /* Line 1424 - what is this for? */
}
```

**Options**:
- If admin bar related: Keep (WordPress core breakpoint)
- If layout related: Migrate to 768px (48rem)
- If unknown: Test removal, check for regressions

**Case 3b: 900px (Unknown Purpose)**

**Research First**:
```css
@media (max-width: 900px) {
  /* Line 2925 - investigate context */
}
```

**Options**:
- Migrate to 768px (tablet) or 992px (desktop) based on context
- Add comment explaining why if kept

**Case 3c: 1600px (Ultra-Wide)**

**Current**:
```css
@media (min-width: 1600px) {
  /* Line 1339 - ultra-wide monitors */
}
```

**Decision**:
- If critical: Migrate to 1200px (wide) or keep with comment
- If enhancement: Remove, test for regressions

---

### Step 5: Batch Migration Process

#### Safest Approach (Recommended)

**For Each Breakpoint**:

1. **Create feature branch**:
   ```bash
   git checkout -b refactor/breakpoint-768px-to-48rem
   ```

2. **Find all instances**:
   ```bash
   grep -n "768px" style.css
   ```

3. **Replace one breakpoint at a time**:
   ```bash
   # Backup first
   cp style.css style.css.backup

   # Replace (macOS)
   sed -i '' 's/min-width: 768px/min-width: 48rem/g' style.css

   # OR manual find-replace in editor (safer)
   ```

4. **Test thoroughly**:
   - Load homepage at 767px (should be mobile)
   - Load homepage at 768px (should be tablet)
   - Check all pages at breakpoint boundaries

5. **Commit**:
   ```bash
   git add style.css
   git commit -m "refactor(responsive): Standardize 768px to 48rem breakpoint"
   ```

6. **Repeat for next breakpoint**

---

### Step 6: Handle Edge Cases

#### Edge Case 1: Ranges (min-width AND max-width)

**Before**:
```css
@media (min-width: 768px) and (max-width: 991px) {
  /* Tablet only */
}
```

**After**:
```css
@media (min-width: 48rem) and (max-width: 61.9375rem) {
  /* 768px - 991px range */
}
```

**Better Approach** (if possible):
```css
/* Avoid ranges, use mobile-first layering instead */
@media (min-width: 48rem) {
  /* Tablet+ */
}
@media (min-width: 62rem) {
  /* Desktop+ overrides tablet */
}
```

#### Edge Case 2: Print Styles

**Keep as-is**:
```css
@media print {
  /* No change needed */
}
```

#### Edge Case 3: Accessibility Queries

**Keep as-is**:
```css
@media (prefers-reduced-motion: reduce) {
  /* No change needed */
}
```

---

### Step 7: JavaScript Breakpoint Access

**Problem**: JS may hardcode breakpoint values

**Find JS Breakpoint Usage**:
```bash
cd assets/js
grep -r "768\|992\|1024" .
```

**Solution**: Create JS module to read CSS custom properties

**File**: `assets/js/breakpoints.js`

```javascript
/**
 * Breakpoint Utilities
 * Reads breakpoint values from CSS custom properties
 */
export const breakpoints = {
  phablet: parseInt(getComputedStyle(document.documentElement).getPropertyValue('--breakpoint-phablet')),
  tablet: parseInt(getComputedStyle(document.documentElement).getPropertyValue('--breakpoint-tablet')),
  desktop: parseInt(getComputedStyle(document.documentElement).getPropertyValue('--breakpoint-desktop')),
  wide: parseInt(getComputedStyle(document.documentElement).getPropertyValue('--breakpoint-wide')),
};

/**
 * Check if viewport is at or above breakpoint
 * @param {string} breakpoint - 'phablet', 'tablet', 'desktop', 'wide'
 * @returns {boolean}
 */
export function isBreakpoint(breakpoint) {
  return window.innerWidth >= (breakpoints[breakpoint] * 16); // Convert rem to px
}

/**
 * Watch for breakpoint changes
 * @param {string} breakpoint
 * @param {function} callback
 */
export function onBreakpoint(breakpoint, callback) {
  const mql = window.matchMedia(`(min-width: ${breakpoints[breakpoint]}rem)`);
  mql.addListener(callback);
  callback(mql); // Call immediately
}
```

**Usage**:
```javascript
import { isBreakpoint, onBreakpoint } from './breakpoints.js';

if (isBreakpoint('tablet')) {
  // Do tablet-specific thing
}

onBreakpoint('desktop', (mql) => {
  if (mql.matches) {
    console.log('Desktop breakpoint reached');
  }
});
```

---

## Testing Checklist

### Visual Testing (All Pages)

Test at each breakpoint boundary:
- [ ] 575px (mobile max)
- [ ] 576px (phablet min)
- [ ] 767px (tablet max)
- [ ] 768px (tablet min)
- [ ] 991px (desktop max)
- [ ] 992px (desktop min)
- [ ] 1199px (wide max)
- [ ] 1200px (wide min)

### Pages to Test
- [ ] Homepage (`front-page.php`)
- [ ] Solutions Archive (`archive-solutions.php`)
- [ ] Single Solution (`single-solutions.php`)
- [ ] Category Archive (`taxonomy-solution_category.php`)
- [ ] About Page (`page-about.php`)
- [ ] Contact Page (if exists)

### What to Look For
- [ ] No layout breaks (overlapping elements)
- [ ] Text remains readable (no cutoffs)
- [ ] Images scale correctly
- [ ] Navigation behaves correctly
- [ ] Grids collapse at correct breakpoints
- [ ] Typography scales smoothly

### Browser Testing
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)
- [ ] Mobile Safari (iOS)
- [ ] Chrome Mobile (Android)

---

## Rollback Plan

### If Critical Issues Found

**Option 1: Revert Single Commit**
```bash
git log --oneline  # Find commit hash
git revert <commit-hash>
git push
```

**Option 2: Restore Backup**
```bash
cp style.css.backup style.css
git add style.css
git commit -m "rollback(responsive): Restore original breakpoints"
```

**Option 3: Feature Branch (if not merged)**
```bash
git checkout main
git branch -D refactor/breakpoint-standardization
```

---

## Success Criteria

### Quantitative
- [ ] Breakpoint count reduced from 17 to 5 (+ accessibility)
- [ ] All media queries use `min-width` (mobile-first)
- [ ] Zero instances of `!important` in media queries
- [ ] All breakpoints in `rem` units (accessibility)

### Qualitative
- [ ] Developers can find breakpoint values in one place (`:root`)
- [ ] New features use standard breakpoints
- [ ] Documentation clear and concise
- [ ] No visual regressions

### Validation
- [ ] `grep "@media" style.css | wc -l` returns expected count
- [ ] `grep "!important" style.css` in media queries returns 0
- [ ] `grep "px" style.css` in breakpoints returns 0 (all rem)
- [ ] Visual regression tests pass (screenshot comparison)

---

## Documentation Artifacts

### Created Documents
1. `docs/code-standards.md` (breakpoint section)
2. `media-queries-audit.txt` (audit log)
3. `phase-1-migration-log.md` (this file's companion tracking sheet)

### Updated Files
1. `style.css` (all media queries)
2. `assets/js/breakpoints.js` (new file)
3. Any component CSS files with media queries

---

## Time Breakdown

### Hour-by-Hour Estimate

**Hour 1-2: Audit & Planning**
- Run grep to find all media queries
- Categorize breakpoints (standard vs special)
- Create migration spreadsheet
- Research special cases (782px, 900px)

**Hour 3-4: Migration Execution**
- Add CSS custom properties to `:root`
- Migrate 768px → 48rem (most common, ~12 instances)
- Test at 768px breakpoint
- Commit

**Hour 5: Remaining Breakpoints**
- Migrate 992px → 62rem (~5 instances)
- Migrate 1024px → 62rem or 75rem (~6 instances, decide based on context)
- Handle off-by-one (767.98px, 991px)
- Test at each migrated breakpoint

**Hour 6: Edge Cases & Documentation**
- Handle special cases (782px, 900px, 1600px)
- Invert desktop-first queries to mobile-first
- Create `breakpoints.js` module
- Update `docs/code-standards.md`
- Final full-site test
- Commit and push

---

## Dependencies for Next Phases

### Phase 2: Card Consolidation (Depends on This)
- Cards use breakpoints for responsive behavior
- Standardizing breakpoints first ensures cards use correct values

### Phase 3: Grid System (Depends on This)
- Grid utilities need breakpoint variants (e.g., `.grid-cols-2-tablet`)
- Can't create utilities without knowing breakpoint names

### Phase 4: Typography (Depends on This)
- Fluid typography may use breakpoints as boundaries
- Type scale adjustments happen at breakpoints

---

## Open Questions

1. **WordPress Admin Bar (782px)**: Keep or migrate?
   - **Action**: Test with WP admin bar visible, check if layout breaks at 768px
   - **Decision**: If admin-specific, keep. If theme layout, migrate.

2. **Ultra-Wide (1600px)**: Is this enhancement or critical?
   - **Action**: Test on 1920x1080 monitor, check if 1200px breakpoint sufficient
   - **Decision**: If no visual difference, remove. If significant, keep with comment.

3. **900px Breakpoint**: What is this for?
   - **Action**: Check surrounding code context (line 2925)
   - **Decision**: Migrate to nearest standard (768px or 992px)

4. **Off-by-One (767.98px)**: Why 0.02px difference?
   - **Research**: Bootstrap uses this to avoid overlap (767px vs 768px both matching)
   - **Decision**: Migrate to 48rem (768px) since we're mobile-first (no overlap)

---

## Next Steps After Phase 1

1. **Merge to main** (after testing)
2. **Deploy to staging** (client preview)
3. **Monitor for 24-48 hours** (no reported issues)
4. **Begin Phase 2: Card Consolidation**

---

**Phase Owner**: Development Team
**Reviewer**: Tech Lead
**Approval Required**: After full-site testing
**Estimated Start**: After plan approval
**Estimated Completion**: 1-2 days (6 working hours)
