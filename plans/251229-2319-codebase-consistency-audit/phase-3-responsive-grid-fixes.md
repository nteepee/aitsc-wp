# Phase 3: Responsive Grid System

**Phase ID**: phase-3-responsive-grid-fixes
**Priority**: HIGH
**Estimated Effort**: 4-6 hours
**Dependencies**: Phase 1 (Breakpoint Standardization)
**Risk Level**: Medium

---

## Objectives

1. Create utility grid classes based on standard breakpoints
2. Standardize gap/spacing values across all grids
3. Migrate inline grid declarations to utility classes
4. Document grid system patterns

---

## Current State Analysis

### Grid Usage Audit

**Found**: 51+ grid declarations in `style.css`

**Common Patterns**:
```css
/* Pattern 1: Fixed columns */
display: grid;
grid-template-columns: repeat(3, 1fr);
gap: 2rem;

/* Pattern 2: Responsive columns */
@media (min-width: 768px) {
  grid-template-columns: repeat(2, 1fr);
}

/* Pattern 3: Auto-fit responsive */
grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
gap: 1.5rem;

/* Pattern 4: Mixed with flexbox fallback */
display: flex;
flex-wrap: wrap;
gap: 1rem; /* Doesn't work in older browsers */
```

### Gap Value Inconsistencies

**Values Found**:
- 16px (1rem)
- 20px (1.25rem)
- 24px (1.5rem)
- 32px (2rem)
- 40px (2.5rem)
- Custom values: 18px, 28px

**Issue**: No consistent spacing scale, makes layout unpredictable.

---

## Proposed Grid System

### Utility Class Naming Convention

**Pattern**: `.grid-{property}-{value}-{breakpoint}`

**Examples**:
```css
.grid                    /* Base grid display */
.grid-cols-2             /* 2 columns (mobile) */
.grid-cols-3-tablet      /* 3 columns from tablet+ */
.grid-gap-4              /* Gap of 1rem (4 * 0.25rem) */
.grid-auto-fit           /* Auto-fit columns */
```

---

### Spacing Scale (Based on 0.25rem = 4px)

```css
:root {
  --space-1: 0.25rem;  /* 4px */
  --space-2: 0.5rem;   /* 8px */
  --space-3: 0.75rem;  /* 12px */
  --space-4: 1rem;     /* 16px */
  --space-5: 1.25rem;  /* 20px */
  --space-6: 1.5rem;   /* 24px */
  --space-8: 2rem;     /* 32px */
  --space-10: 2.5rem;  /* 40px */
  --space-12: 3rem;    /* 48px */
}
```

**Rationale**: Consistent with Tailwind/Bootstrap spacing scales, predictable increments.

---

### Base Grid Classes

**File**: `assets/css/utilities/grid.css` (new file)

```css
/**
 * Grid Utility Classes
 * Mobile-first responsive grid system
 */

/* Base grid */
.grid {
  display: grid;
}

/* Column counts - Mobile (base) */
.grid-cols-1 { grid-template-columns: repeat(1, 1fr); }
.grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
.grid-cols-3 { grid-template-columns: repeat(3, 1fr); }
.grid-cols-4 { grid-template-columns: repeat(4, 1fr); }
.grid-cols-6 { grid-template-columns: repeat(6, 1fr); }
.grid-cols-12 { grid-template-columns: repeat(12, 1fr); }

/* Auto-fit responsive (no breakpoint needed) */
.grid-auto-fit-sm { grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); }
.grid-auto-fit { grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); }
.grid-auto-fit-lg { grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); }

/* Gap utilities */
.grid-gap-2 { gap: var(--space-2); }
.grid-gap-3 { gap: var(--space-3); }
.grid-gap-4 { gap: var(--space-4); }
.grid-gap-5 { gap: var(--space-5); }
.grid-gap-6 { gap: var(--space-6); }
.grid-gap-8 { gap: var(--space-8); }

/* Row gap */
.grid-row-gap-4 { row-gap: var(--space-4); }
.grid-row-gap-6 { row-gap: var(--space-6); }

/* Column gap */
.grid-col-gap-4 { column-gap: var(--space-4); }
.grid-col-gap-6 { column-gap: var(--space-6); }

/* Phablet: 576px+ */
@media (min-width: 36rem) {
  .grid-cols-1-phablet { grid-template-columns: repeat(1, 1fr); }
  .grid-cols-2-phablet { grid-template-columns: repeat(2, 1fr); }
  .grid-cols-3-phablet { grid-template-columns: repeat(3, 1fr); }
  .grid-gap-4-phablet { gap: var(--space-4); }
  .grid-gap-6-phablet { gap: var(--space-6); }
}

/* Tablet: 768px+ */
@media (min-width: 48rem) {
  .grid-cols-1-tablet { grid-template-columns: repeat(1, 1fr); }
  .grid-cols-2-tablet { grid-template-columns: repeat(2, 1fr); }
  .grid-cols-3-tablet { grid-template-columns: repeat(3, 1fr); }
  .grid-cols-4-tablet { grid-template-columns: repeat(4, 1fr); }
  .grid-gap-4-tablet { gap: var(--space-4); }
  .grid-gap-6-tablet { gap: var(--space-6); }
  .grid-gap-8-tablet { gap: var(--space-8); }
}

/* Desktop: 992px+ */
@media (min-width: 62rem) {
  .grid-cols-2-desktop { grid-template-columns: repeat(2, 1fr); }
  .grid-cols-3-desktop { grid-template-columns: repeat(3, 1fr); }
  .grid-cols-4-desktop { grid-template-columns: repeat(4, 1fr); }
  .grid-cols-5-desktop { grid-template-columns: repeat(5, 1fr); }
  .grid-gap-6-desktop { gap: var(--space-6); }
  .grid-gap-8-desktop { gap: var(--space-8); }
}

/* Wide: 1200px+ */
@media (min-width: 75rem) {
  .grid-cols-4-wide { grid-template-columns: repeat(4, 1fr); }
  .grid-cols-5-wide { grid-template-columns: repeat(5, 1fr); }
  .grid-cols-6-wide { grid-template-columns: repeat(6, 1fr); }
  .grid-gap-8-wide { gap: var(--space-8); }
  .grid-gap-10-wide { gap: var(--space-10); }
}
```

---

## Migration Examples

### Example 1: Solutions Grid

**Before** (archive-solutions.php + style.css):
```php
<!-- archive-solutions.php -->
<div class="solutions-grid">
  <?php while (have_posts()) : the_post(); ?>
    <!-- solution card -->
  <?php endwhile; ?>
</div>
```

```css
/* style.css */
.solutions-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
}

@media (min-width: 768px) {
  .solutions-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
  }
}

@media (min-width: 992px) {
  .solutions-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}
```

**After**:
```php
<!-- archive-solutions.php -->
<div class="grid grid-cols-1 grid-cols-2-tablet grid-cols-3-desktop grid-gap-6 grid-gap-8-tablet">
  <?php while (have_posts()) : the_post(); ?>
    <!-- solution card -->
  <?php endwhile; ?>
</div>
```

```css
/* style.css - DELETE .solutions-grid styles */
```

**Benefits**:
- No custom CSS needed
- Reusable across templates
- Clear responsive behavior from class names

---

### Example 2: Feature Grid

**Before**:
```css
.features-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
}
```

**After**:
```html
<div class="grid grid-auto-fit-lg grid-gap-8">
  <!-- features -->
</div>
```

---

### Example 3: Complex Multi-Column Layout

**Before**:
```css
.stats-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1rem;
}

@media (min-width: 576px) {
  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 992px) {
  .stats-grid {
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
  }
}
```

**After**:
```html
<div class="grid grid-cols-1 grid-cols-2-phablet grid-cols-4-desktop grid-gap-4 grid-gap-8-desktop">
  <!-- stats -->
</div>
```

---

## Implementation Steps

### Step 1: Create Utilities File

**Create**: `assets/css/utilities/grid.css`

**Tasks**:
1. Add CSS custom properties for spacing scale
2. Write base grid classes
3. Add responsive variants for each breakpoint
4. Add gap utilities

**Commit**: `feat(utilities): Add responsive grid utility classes`

---

### Step 2: Enqueue Grid Utilities

**File**: `inc/enqueue.php`

```php
// Enqueue grid utilities
wp_enqueue_style(
    'aitsc-utilities-grid',
    get_template_directory_uri() . '/assets/css/utilities/grid.css',
    array('aitsc-style'), // After main stylesheet
    AITSC_VERSION
);
```

---

### Step 3: Audit & Migrate Grid Usages

**Find All Grid Declarations**:
```bash
grep -n "display: grid" style.css > grid-audit.txt
grep -n "grid-template-columns" style.css >> grid-audit.txt
```

**Categorize**:
| Line | Selector | Pattern | Migration Target |
|------|----------|---------|------------------|
| 150 | `.solutions-grid` | 1/2/3 cols responsive | `.grid .grid-cols-1 .grid-cols-2-tablet .grid-cols-3-desktop` |
| 300 | `.features-grid` | Auto-fit 300px | `.grid .grid-auto-fit-lg` |

---

### Step 4: Migrate Templates (Priority Order)

1. **High Impact**: `archive-solutions.php`, `front-page.php`
2. **Medium Impact**: `taxonomy-solution_category.php`, `page-about.php`
3. **Low Impact**: Template parts in `template-parts/`

**Process Per Template**:
1. Replace custom grid class with utilities
2. Remove CSS from `style.css` (comment first, test, then delete)
3. Test at all breakpoints
4. Commit: `refactor(grid): Migrate [template-name] to grid utilities`

---

### Step 5: Clean Up Custom Grid CSS

**File**: `style.css`

**Search & Remove** (after testing):
```bash
# Find custom grid selectors
grep -n "\..*-grid" style.css
```

**Expected Removals**:
- `.solutions-grid`
- `.features-grid`
- `.stats-grid`
- `.team-grid`
- `.case-studies-grid`

**Expected Reduction**: ~150-200 lines from `style.css`

---

## Advanced Grid Patterns

### Pattern 1: Asymmetric Grids

**Use Case**: Featured item larger than others

```html
<div class="grid grid-cols-12 grid-gap-6">
  <div class="grid-col-span-12 tablet:grid-col-span-8">
    <!-- Featured item (2/3 width on tablet+) -->
  </div>
  <div class="grid-col-span-12 tablet:grid-col-span-4">
    <!-- Sidebar (1/3 width on tablet+) -->
  </div>
</div>
```

**CSS** (add to grid utilities):
```css
/* Column span utilities */
.grid-col-span-4 { grid-column: span 4; }
.grid-col-span-8 { grid-column: span 8; }
.grid-col-span-12 { grid-column: span 12; }

@media (min-width: 48rem) {
  .tablet\:grid-col-span-4 { grid-column: span 4; }
  .tablet\:grid-col-span-8 { grid-column: span 8; }
}
```

---

### Pattern 2: Dense Packing

**Use Case**: Masonry-style layout

```css
.grid-dense {
  grid-auto-flow: dense;
}
```

**Usage**:
```html
<div class="grid grid-auto-fit grid-dense">
  <!-- Items will pack tightly, filling gaps -->
</div>
```

---

### Pattern 3: Vertical Alignment

```css
/* Align items vertically */
.grid-items-start { align-items: start; }
.grid-items-center { align-items: center; }
.grid-items-end { align-items: end; }

/* Align content vertically */
.grid-content-start { align-content: start; }
.grid-content-center { align-content: center; }
.grid-content-end { align-content: end; }
```

---

## Fallback for Older Browsers

### IE11 Grid Support

**Issue**: IE11 has limited grid support (no auto-placement)

**Decision Options**:
1. Drop IE11 support (recommended, < 1% market share)
2. Add flexbox fallback with `@supports`

**Option 2 Example** (if IE11 support required):
```css
/* Flexbox fallback */
.grid {
  display: flex;
  flex-wrap: wrap;
  margin: calc(var(--space-4) * -0.5);
}

.grid > * {
  flex: 1 0 100%;
  margin: calc(var(--space-4) * 0.5);
}

/* Modern browsers: Use grid */
@supports (display: grid) {
  .grid {
    display: grid;
    margin: 0;
  }

  .grid > * {
    margin: 0;
  }
}
```

**Recommendation**: Drop IE11, simplify codebase.

---

## Testing Checklist

### Visual Regression Tests

**Test at Each Breakpoint**:
- [ ] 575px (mobile): 1 column
- [ ] 576px (phablet): 2 columns (if applicable)
- [ ] 767px (tablet max): Pre-tablet layout
- [ ] 768px (tablet): 2-3 columns
- [ ] 991px (desktop max): Pre-desktop layout
- [ ] 992px (desktop): 3-4 columns
- [ ] 1200px (wide): Max columns

**Pages to Test**:
- [ ] Solutions Archive (3-column grid)
- [ ] Homepage (multiple grids)
- [ ] Category Pages (2-3 column grids)
- [ ] About Page (team grid, if exists)

**What to Check**:
- [ ] Gap spacing consistent
- [ ] Columns wrap correctly
- [ ] No orphaned items (1 item alone on row)
- [ ] Aspect ratios maintained

---

### Cross-Browser Testing

- [ ] Chrome: Grid support excellent
- [ ] Firefox: Grid support excellent
- [ ] Safari: Grid support excellent (prefixes no longer needed)
- [ ] Edge: Chromium (grid support excellent)
- [ ] IE11: If supported, test flexbox fallback

---

### Performance Testing

**Metrics to Check**:
- [ ] CSS file size (should decrease)
- [ ] Render time (Lighthouse performance)
- [ ] Layout shift (CLS score)
- [ ] Repaints (DevTools performance profiler)

**Expected**:
- CSS size: -150-200 lines
- No performance regression
- Improved CLS (consistent gap values)

---

## Documentation

### Developer Guide

**File**: `docs/utilities/grid.md`

```markdown
# Grid Utility System

## Basic Usage

```html
<div class="grid grid-cols-3 grid-gap-6">
  <div>Item 1</div>
  <div>Item 2</div>
  <div>Item 3</div>
</div>
```

## Responsive Grids

Mobile-first approach:

```html
<!-- 1 col on mobile, 2 on tablet, 3 on desktop -->
<div class="grid grid-cols-1 grid-cols-2-tablet grid-cols-3-desktop grid-gap-4">
  <!-- items -->
</div>
```

## Available Classes

### Column Counts
- `.grid-cols-{1-12}` (mobile base)
- `.grid-cols-{1-4}-phablet` (576px+)
- `.grid-cols-{1-4}-tablet` (768px+)
- `.grid-cols-{2-5}-desktop` (992px+)
- `.grid-cols-{4-6}-wide` (1200px+)

### Auto-Fit
- `.grid-auto-fit-sm` (min 200px)
- `.grid-auto-fit` (min 250px)
- `.grid-auto-fit-lg` (min 300px)

### Gap Spacing
- `.grid-gap-{2,3,4,5,6,8}` (mobile base)
- `.grid-gap-{4,6,8}-{breakpoint}` (responsive)

## Common Patterns

### Solution Cards (3-column)
```html
<div class="grid grid-cols-1 grid-cols-2-tablet grid-cols-3-desktop grid-gap-6 grid-gap-8-desktop">
```

### Feature Grid (auto-fit)
```html
<div class="grid grid-auto-fit-lg grid-gap-8">
```

### Stats Grid (4-column)
```html
<div class="grid grid-cols-2 grid-cols-4-desktop grid-gap-4 grid-gap-6-desktop">
```
```

---

## Rollback Plan

### Per-Template Rollback

**If grid utilities break a page**:

1. Revert template:
   ```bash
   git checkout HEAD -- archive-solutions.php
   ```

2. Restore custom grid CSS:
   ```bash
   # Uncomment .solutions-grid in style.css
   ```

---

### Full Phase Rollback

```bash
# Remove grid utilities file
rm assets/css/utilities/grid.css

# Revert enqueue changes
git checkout HEAD -- inc/enqueue.php

# Revert template changes
git log --oneline --grep="grid utilities"
git revert <commit-hash>
```

---

## Success Criteria

### Quantitative
- [ ] Grid declarations reduced from 51 to ~10 custom (+ utility classes)
- [ ] Gap values standardized to spacing scale (6 values: 2,3,4,5,6,8)
- [ ] CSS reduction: 150-200 lines from `style.css`
- [ ] Zero duplicate grid styles

### Qualitative
- [ ] Developers can create grids without writing CSS
- [ ] Consistent spacing across all grid layouts
- [ ] Responsive behavior predictable from class names
- [ ] Easier to prototype layouts

---

## Time Breakdown

**Hour 1**: Create grid utilities
- Write `grid.css` with base classes
- Add responsive variants
- Add gap utilities
- Register in enqueue

**Hour 2**: Audit existing grids
- Find all grid declarations (grep)
- Categorize patterns
- Create migration spreadsheet

**Hour 3-4**: Migrate templates
- `archive-solutions.php`
- `front-page.php`
- Template parts
- Test each migration

**Hour 5**: Clean up CSS
- Remove custom grid classes from `style.css`
- Test for regressions
- Optimize remaining custom grids

**Hour 6**: Documentation & review
- Write developer guide
- Create usage examples
- Code review
- Final testing

---

## Dependencies for Next Phases

### Phase 4: Typography
- Typography utilities may include responsive variants
- Grid + typography utilities work together

### Phase 5: Slider
- Sliders may use grid for thumbnail/preview layouts

---

## Open Questions

1. **IE11 Support**: Drop completely or add flexbox fallback?
   - **Recommendation**: Drop (< 1% market share, adds complexity)
   - **Decision**: Confirm with stakeholder

2. **Grid Line Utilities**: Add `.grid-col-start-2`, `.grid-row-span-2`, etc.?
   - **Recommendation**: Add only if needed (YAGNI principle)
   - **Decision**: Wait for use case

3. **Subgrid Support**: Use CSS subgrid for nested grids?
   - **Status**: Limited browser support (Safari 16+, Firefox 71+)
   - **Decision**: Monitor, add when Chrome supports (~2024)

---

**Phase Owner**: Development Team
**Reviewer**: Tech Lead
**Approval Required**: After cross-browser testing
**Estimated Completion**: 1.5 days (6 working hours)
