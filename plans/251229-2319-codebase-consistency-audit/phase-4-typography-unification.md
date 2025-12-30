# Phase 4: Typography System Unification

**Phase ID**: phase-4-typography-unification
**Priority**: MEDIUM
**Estimated Effort**: 3-4 hours
**Dependencies**: Phase 1 (Breakpoint Standardization)
**Risk Level**: Medium

---

## Objectives

1. Define type scale system with consistent ratios
2. Remove `!important` overrides in typography
3. Implement fluid typography (clamp-based scaling)
4. Create heading/body utility classes

---

## Current State Analysis

### Typography Issues Identified

#### 1. Desktop-First Overrides with !important

**Pattern Found**:
```css
/* Base (desktop assumed) */
h1 {
  font-size: 3rem;
  line-height: 1.2;
}

/* Mobile override */
@media (max-width: 768px) {
  h1 {
    font-size: 2rem !important;
    line-height: 1.3 !important;
  }
}
```

**Issues**:
- `!important` creates specificity wars
- Desktop-first contradicts mobile-first approach
- Hard to override for edge cases

---

#### 2. Inconsistent Scale Ratios

**Ratios Found**:
- H1→H2: 1.2x in some places, 1.5x in others
- H2→H3: 1.25x in some places, 1.33x in others
- Body text: 16px base, but 14px in some components

**Example**:
```css
/* Inconsistent scale */
h1 { font-size: 48px; }  /* 3rem */
h2 { font-size: 32px; }  /* 2rem - 1.5x ratio */
h3 { font-size: 24px; }  /* 1.5rem - 1.33x ratio */
h4 { font-size: 20px; }  /* 1.25rem - 1.2x ratio */
```

**Issue**: No predictable relationship between heading levels.

---

#### 3. Line-Height Inconsistencies

**Values Found**:
- Unitless: `1.2`, `1.5`, `1.6`
- Pixels: `24px`, `28px`
- Percentages: `120%`, `150%`

**Best Practice**: Use unitless values (scales with font-size).

---

#### 4. Letter-Spacing Inconsistencies

**Values Found**:
- `-0.02em`
- `0.02em`
- `0.5px`
- Normal (no value)

**Issue**: No system for when/why letter-spacing applied.

---

## Proposed Typography System

### Type Scale (Modular Scale: 1.25x Major Third)

**Rationale**: 1.25x ratio creates clear hierarchy without extreme jumps.

```css
:root {
  /* Base */
  --font-size-base: 1rem;        /* 16px */

  /* Scale */
  --font-size-xs: 0.75rem;       /* 12px */
  --font-size-sm: 0.875rem;      /* 14px */
  --font-size-md: 1rem;          /* 16px (base) */
  --font-size-lg: 1.125rem;      /* 18px */
  --font-size-xl: 1.25rem;       /* 20px */
  --font-size-2xl: 1.5rem;       /* 24px */
  --font-size-3xl: 1.875rem;     /* 30px */
  --font-size-4xl: 2.25rem;      /* 36px */
  --font-size-5xl: 3rem;         /* 48px */
  --font-size-6xl: 3.75rem;      /* 60px */

  /* Line heights */
  --line-height-tight: 1.2;
  --line-height-snug: 1.375;
  --line-height-normal: 1.5;
  --line-height-relaxed: 1.625;
  --line-height-loose: 2;

  /* Letter spacing */
  --letter-spacing-tight: -0.02em;
  --letter-spacing-normal: 0;
  --letter-spacing-wide: 0.02em;

  /* Font weights */
  --font-weight-normal: 400;
  --font-weight-medium: 500;
  --font-weight-semibold: 600;
  --font-weight-bold: 700;
}
```

---

### Semantic Heading Scale

**Mobile-First with Fluid Typography**:

```css
/* H1 - Hero headlines */
h1, .h1 {
  font-size: clamp(2.25rem, 5vw, 3.75rem);    /* 36px → 60px */
  line-height: var(--line-height-tight);
  font-weight: var(--font-weight-bold);
  letter-spacing: var(--letter-spacing-tight);
}

/* H2 - Section headings */
h2, .h2 {
  font-size: clamp(1.875rem, 4vw, 3rem);      /* 30px → 48px */
  line-height: var(--line-height-tight);
  font-weight: var(--font-weight-bold);
  letter-spacing: var(--letter-spacing-tight);
}

/* H3 - Subsection headings */
h3, .h3 {
  font-size: clamp(1.5rem, 3vw, 2.25rem);     /* 24px → 36px */
  line-height: var(--line-height-snug);
  font-weight: var(--font-weight-semibold);
  letter-spacing: var(--letter-spacing-normal);
}

/* H4 - Card titles, etc. */
h4, .h4 {
  font-size: clamp(1.25rem, 2.5vw, 1.875rem); /* 20px → 30px */
  line-height: var(--line-height-snug);
  font-weight: var(--font-weight-semibold);
  letter-spacing: var(--letter-spacing-normal);
}

/* H5 - Small headings */
h5, .h5 {
  font-size: clamp(1.125rem, 2vw, 1.5rem);    /* 18px → 24px */
  line-height: var(--line-height-normal);
  font-weight: var(--font-weight-medium);
}

/* H6 - Overline, labels */
h6, .h6 {
  font-size: clamp(1rem, 1.5vw, 1.25rem);     /* 16px → 20px */
  line-height: var(--line-height-normal);
  font-weight: var(--font-weight-medium);
  text-transform: uppercase;
  letter-spacing: var(--letter-spacing-wide);
}
```

**Benefits of `clamp()`**:
- Fluid scaling between breakpoints (no jumps)
- No media queries needed
- Respects user font-size preferences
- Browser support: 95%+ (IE11 excluded)

---

### Body Text Styles

```css
/* Body - Default */
body {
  font-size: var(--font-size-md);
  line-height: var(--line-height-normal);
  font-weight: var(--font-weight-normal);
  color: var(--color-text-body, #333);
}

/* Lead text (larger intro paragraphs) */
.text-lead {
  font-size: clamp(1.125rem, 2vw, 1.25rem);   /* 18px → 20px */
  line-height: var(--line-height-relaxed);
  color: var(--color-text-muted, #666);
}

/* Small text (captions, metadata) */
.text-sm {
  font-size: var(--font-size-sm);
  line-height: var(--line-height-normal);
}

/* Extra small text (fine print) */
.text-xs {
  font-size: var(--font-size-xs);
  line-height: var(--line-height-normal);
}
```

---

### Utility Classes

**File**: `assets/css/utilities/typography.css`

```css
/**
 * Typography Utility Classes
 */

/* Font sizes */
.text-xs { font-size: var(--font-size-xs); }
.text-sm { font-size: var(--font-size-sm); }
.text-md { font-size: var(--font-size-md); }
.text-lg { font-size: var(--font-size-lg); }
.text-xl { font-size: var(--font-size-xl); }
.text-2xl { font-size: var(--font-size-2xl); }
.text-3xl { font-size: var(--font-size-3xl); }
.text-4xl { font-size: var(--font-size-4xl); }
.text-5xl { font-size: var(--font-size-5xl); }

/* Font weights */
.font-normal { font-weight: var(--font-weight-normal); }
.font-medium { font-weight: var(--font-weight-medium); }
.font-semibold { font-weight: var(--font-weight-semibold); }
.font-bold { font-weight: var(--font-weight-bold); }

/* Line heights */
.leading-tight { line-height: var(--line-height-tight); }
.leading-snug { line-height: var(--line-height-snug); }
.leading-normal { line-height: var(--line-height-normal); }
.leading-relaxed { line-height: var(--line-height-relaxed); }
.leading-loose { line-height: var(--line-height-loose); }

/* Letter spacing */
.tracking-tight { letter-spacing: var(--letter-spacing-tight); }
.tracking-normal { letter-spacing: var(--letter-spacing-normal); }
.tracking-wide { letter-spacing: var(--letter-spacing-wide); }

/* Text transforms */
.uppercase { text-transform: uppercase; }
.lowercase { text-transform: lowercase; }
.capitalize { text-transform: capitalize; }

/* Text alignment */
.text-left { text-align: left; }
.text-center { text-align: center; }
.text-right { text-align: right; }

/* Text colors (placeholder - use theme colors) */
.text-body { color: var(--color-text-body); }
.text-muted { color: var(--color-text-muted); }
.text-heading { color: var(--color-text-heading); }
.text-white { color: #ffffff; }

/* Responsive text alignment */
@media (min-width: 48rem) {
  .tablet\:text-left { text-align: left; }
  .tablet\:text-center { text-align: center; }
  .tablet\:text-right { text-align: right; }
}
```

---

## Migration Strategy

### Step 1: Add CSS Custom Properties

**File**: `style.css` (`:root` section)

**Add**:
- Font size scale
- Line height scale
- Letter spacing values
- Font weights

**Commit**: `feat(typography): Add type scale CSS custom properties`

---

### Step 2: Refactor Heading Styles

**File**: `style.css` (base styles section)

**Before**:
```css
h1 {
  font-size: 48px;
  line-height: 1.2;
}

@media (max-width: 768px) {
  h1 {
    font-size: 32px !important;
  }
}
```

**After**:
```css
h1, .h1 {
  font-size: clamp(2.25rem, 5vw, 3.75rem);
  line-height: var(--line-height-tight);
  font-weight: var(--font-weight-bold);
  letter-spacing: var(--letter-spacing-tight);
}
```

**Process**:
1. Replace H1-H6 base styles
2. Remove all media query overrides for headings
3. Test on all pages
4. Commit: `refactor(typography): Convert headings to fluid type scale`

---

### Step 3: Refactor Body Text

**File**: `style.css`

**Before**:
```css
body {
  font-size: 16px;
  line-height: 24px; /* Should be unitless */
}

p {
  font-size: 16px;
  line-height: 1.6;
}
```

**After**:
```css
body {
  font-size: var(--font-size-md);
  line-height: var(--line-height-normal);
  font-weight: var(--font-weight-normal);
}

p {
  /* Inherits from body */
  margin-bottom: 1rem;
}
```

**Commit**: `refactor(typography): Standardize body text styles`

---

### Step 4: Remove !important Overrides

**Find All Typography !important**:
```bash
grep -n "font.*!important" style.css
grep -n "line-height.*!important" style.css
grep -n "letter-spacing.*!important" style.css
```

**Strategy**:
1. For each `!important`, understand why it was added
2. Usually: Desktop-first → mobile-first inversion makes `!important` unnecessary
3. Remove `!important`, test, adjust if needed

**Commit**: `refactor(typography): Remove !important from typography rules`

---

### Step 5: Create Typography Utilities

**Create**: `assets/css/utilities/typography.css`

**Add**:
- Font size utilities (`.text-xs` → `.text-5xl`)
- Font weight utilities (`.font-normal` → `.font-bold`)
- Line height utilities (`.leading-tight` → `.leading-loose`)
- Text alignment utilities

**Enqueue**:
```php
// inc/enqueue.php
wp_enqueue_style(
    'aitsc-utilities-typography',
    get_template_directory_uri() . '/assets/css/utilities/typography.css',
    array('aitsc-style'),
    AITSC_VERSION
);
```

**Commit**: `feat(utilities): Add typography utility classes`

---

### Step 6: Migrate Component Typography

**Components to Update**:
1. Cards (`.card__title`, `.card__content`)
2. Buttons (font-size, font-weight)
3. Forms (input labels, placeholders)
4. Navigation (menu items)

**Example - Card Title**:

**Before**:
```css
.card__title {
  font-size: 24px;
  font-weight: 700;
  line-height: 1.3;
}
```

**After**:
```css
.card__title {
  font-size: var(--font-size-2xl);
  font-weight: var(--font-weight-bold);
  line-height: var(--line-height-snug);
}
```

**Or use utility classes**:
```html
<h3 class="card__title text-2xl font-bold leading-snug">
  Card Title
</h3>
```

---

## Advanced Typography Features

### Feature 1: Responsive Font Sizes (Optional)

**Beyond fluid type, add breakpoint-specific utilities**:

```css
/* Responsive font sizes */
@media (min-width: 48rem) {
  .tablet\:text-lg { font-size: var(--font-size-lg); }
  .tablet\:text-xl { font-size: var(--font-size-xl); }
  .tablet\:text-2xl { font-size: var(--font-size-2xl); }
}

@media (min-width: 62rem) {
  .desktop\:text-2xl { font-size: var(--font-size-2xl); }
  .desktop\:text-3xl { font-size: var(--font-size-3xl); }
  .desktop\:text-4xl { font-size: var(--font-size-4xl); }
}
```

**Use Case**: Fine control when fluid type insufficient.

---

### Feature 2: Truncation & Clamping

**Utilities for text overflow**:

```css
/* Single line truncation */
.truncate {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

/* Multi-line clamp (3 lines) */
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Multi-line clamp (2 lines) */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
```

**Use Case**: Card excerpts, long titles.

---

### Feature 3: Balanced Text (Optional)

**Better text wrapping for headings**:

```css
h1, h2, h3 {
  text-wrap: balance; /* Experimental, Chrome 114+ */
}

/* Fallback for older browsers */
@supports not (text-wrap: balance) {
  h1, h2, h3 {
    /* Existing styles */
  }
}
```

**Benefit**: Prevents orphaned words, more balanced line breaks.

---

## Testing Checklist

### Visual Regression Tests

**Test All Typography Elements**:
- [ ] H1-H6 at all breakpoints
- [ ] Body text (paragraphs, lists)
- [ ] Lead text (intro paragraphs)
- [ ] Small text (captions, metadata)
- [ ] Card titles
- [ ] Button text
- [ ] Form labels

**Pages to Test**:
- [ ] Homepage (all heading levels)
- [ ] About Page (body copy-heavy)
- [ ] Solutions Archive (card titles)
- [ ] Single Solution (article content)
- [ ] Contact Page (form labels)

**Breakpoints to Test**:
- [ ] 375px (mobile)
- [ ] 768px (tablet)
- [ ] 992px (desktop)
- [ ] 1920px (large desktop)

**What to Check**:
- [ ] No text cutoff or overflow
- [ ] Clear hierarchy (H1 > H2 > H3)
- [ ] Readable line lengths (45-75 characters)
- [ ] Adequate line-height (not too tight/loose)
- [ ] Consistent spacing between paragraphs

---

### Accessibility Testing

**Tools**:
- Wave (browser extension)
- Axe DevTools
- Lighthouse accessibility audit

**Checks**:
- [ ] Color contrast ratio ≥ 4.5:1 (AA) for body text
- [ ] Color contrast ratio ≥ 3:1 (AA) for large text (18pt+)
- [ ] Headings in logical order (H1 → H2 → H3, no skips)
- [ ] Text scales with browser font-size setting (test at 200%)
- [ ] No information conveyed by font alone (use color/icons too)

---

### Performance Testing

**Before vs After**:

**Metrics**:
- [ ] CSS file size (should decrease after removing !important)
- [ ] Render time (fluid type adds minimal overhead)
- [ ] Layout shifts (CLS - should improve with consistent scale)

**Expected**:
- CSS size: -50-100 lines (removed media queries)
- No performance regression
- Improved CLS (predictable text sizes)

---

## Documentation

### Developer Guide

**File**: `docs/design-guidelines.md`

```markdown
## Typography System

### Type Scale

We use a modular scale with 1.25x ratio (Major Third):

| Token      | Size   | Pixels | Use Case                  |
|------------|--------|--------|---------------------------|
| `xs`       | 0.75rem | 12px  | Fine print                |
| `sm`       | 0.875rem | 14px | Captions, metadata        |
| `md`       | 1rem   | 16px  | Body text (base)          |
| `lg`       | 1.125rem | 18px | Lead paragraphs           |
| `xl`       | 1.25rem | 20px  | Small headings            |
| `2xl`      | 1.5rem | 24px  | H4, card titles           |
| `3xl`      | 1.875rem | 30px | H3, subsection headings   |
| `4xl`      | 2.25rem | 36px  | H2, section headings      |
| `5xl`      | 3rem   | 48px  | H1, hero headlines        |
| `6xl`      | 3.75rem | 60px  | Display headings          |

### Fluid Typography

All headings use `clamp()` for fluid scaling:

```css
h1 {
  font-size: clamp(2.25rem, 5vw, 3.75rem); /* 36px → 60px */
}
```

**Benefits**:
- Smooth scaling between breakpoints
- No media queries needed
- Respects user preferences

### Usage Examples

#### Headings
```html
<h1>Hero Headline</h1>           <!-- 36px → 60px -->
<h2>Section Heading</h2>         <!-- 30px → 48px -->
<h3>Subsection Heading</h3>      <!-- 24px → 36px -->
```

#### Utility Classes
```html
<p class="text-lead">Large intro paragraph</p>
<p class="text-sm text-muted">Small caption text</p>
<h3 class="text-2xl font-bold">Custom heading</h3>
```

### Best Practices

1. **Use semantic HTML**: `<h1>`, `<h2>`, `<p>` over `<div class="h1">`
2. **Logical heading order**: Don't skip levels (H1 → H3)
3. **Utility classes for exceptions**: Use `.h2` class sparingly
4. **Respect user preferences**: Never set fixed font sizes in `px`

### Line Height Guidelines

| Token       | Value | Use Case                        |
|-------------|-------|---------------------------------|
| `tight`     | 1.2   | Large headings (H1, H2)         |
| `snug`      | 1.375 | Small headings (H3, H4)         |
| `normal`    | 1.5   | Body text, paragraphs           |
| `relaxed`   | 1.625 | Lead text, long-form content    |
| `loose`     | 2.0   | Poetry, special layouts         |

### Letter Spacing Guidelines

| Token       | Value   | Use Case                      |
|-------------|---------|-------------------------------|
| `tight`     | -0.02em | Large headings (>36px)        |
| `normal`    | 0       | Default (most text)           |
| `wide`      | 0.02em  | Uppercase text, small caps    |
```

---

## Rollback Plan

### Revert Heading Styles

**If fluid type causes issues**:

```bash
# Revert to fixed sizes
git checkout HEAD~1 -- style.css

# Or manually replace clamp() with fixed font-size
# h1 { font-size: 3rem; } /* Fixed instead of clamp() */
```

---

### Restore !important (Not Recommended)

**Only if absolutely necessary**:

```css
/* Emergency rollback pattern */
@media (max-width: 48rem) {
  h1 {
    font-size: 2rem !important;
  }
}
```

**Better Solution**: Debug why fluid type not working, fix root cause.

---

## Success Criteria

### Quantitative
- [ ] Type scale uses 10 consistent sizes (xs → 6xl)
- [ ] Zero `!important` in typography rules
- [ ] All headings use `clamp()` for fluid scaling
- [ ] 50-100 lines removed from `style.css` (media queries)

### Qualitative
- [ ] Clear visual hierarchy on all pages
- [ ] Smooth font scaling from mobile to desktop (no jumps)
- [ ] Developers can apply typography without writing CSS
- [ ] Consistent line-height and letter-spacing

---

## Time Breakdown

**Hour 1**: Setup & Planning
- Add CSS custom properties (type scale)
- Research current typography usage
- Create migration checklist

**Hour 2**: Heading Migration
- Convert H1-H6 to fluid type (clamp)
- Remove desktop-first media queries
- Remove `!important` overrides
- Test heading hierarchy

**Hour 3**: Body & Utilities
- Standardize body text styles
- Create typography utilities file
- Migrate component typography
- Test across templates

**Hour 4**: Documentation & Polish
- Write developer guide
- Create usage examples
- Accessibility audit
- Final review & commit

---

## Dependencies for Next Phases

### Phase 5: Slider/Carousel
- Slider text (titles, captions) will use typography utilities

### Phase 6: Legacy Cleanup
- May find old typography overrides in legacy CSS files

---

## Open Questions

1. **Custom Font Loading**: Do we need web fonts (Google Fonts, etc.)?
   - **Current**: Assumes system fonts
   - **Action**: Check design requirements

2. **Dark Mode**: Typography adjustments needed for dark theme?
   - **Consideration**: Lighter font weights often better on dark backgrounds
   - **Decision**: Out of scope for this phase, add in dark mode feature

3. **Internationalization**: Support for non-Latin scripts?
   - **Current**: English only
   - **Future**: May need different line-heights for CJK languages

---

**Phase Owner**: Development Team
**Reviewer**: Tech Lead + Designer
**Approval Required**: After visual regression tests
**Estimated Completion**: 1 day (4 working hours)
