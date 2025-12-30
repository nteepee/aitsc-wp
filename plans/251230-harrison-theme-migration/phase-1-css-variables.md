# Phase 1: CSS Variable Migration

**Status**: Not Started
**Priority**: Critical
**Dependencies**: None

---

## Context

Replace all dark theme CSS variables with white theme equivalents. This phase establishes the design foundation for all subsequent phases.

---

## Requirements

1. Replace `:root` variables in `style.css`
2. Update all component CSS files
3. Remove dark mode media queries
4. Verify contrast ratios (WCAG 2.1 AA)

---

## Files to Modify

| File | Lines | Changes |
|------|-------|---------|
| `style.css` | 3965 | :root block, global styles |
| `card-variants.css` | 440 | Card backgrounds, borders |
| `hero-variants.css` | 403 | Hero backgrounds, text |
| `cta-styles.css` | ~100 | Button colors |
| `stats-styles.css` | ~80 | Counter colors |
| `carousel-styles.css` | ~100 | Testimonial styles |
| `header.php` | inline | Navigation styles |

---

## Implementation Steps

### Step 1: Update :root in style.css

```css
:root {
    /* === WHITE THEME VARIABLES === */

    /* Backgrounds */
    --aitsc-bg-primary: #FFFFFF;
    --aitsc-bg-secondary: #F8FAFC;
    --aitsc-bg-tertiary: #F1F5F9;
    --aitsc-bg-panel: rgba(248, 250, 252, 0.95);

    /* Primary Brand - AITSC Cyan */
    --aitsc-primary: #005cb2;
    --aitsc-primary-hover: #004a94;
    --aitsc-primary-light: #E0F2FE;
    --aitsc-primary-dark: #003d75;

    /* Text */
    --aitsc-text-primary: #1E293B;
    --aitsc-text-secondary: #475569;
    --aitsc-text-muted: #64748B;
    --aitsc-text-light: #94A3B8;
    --aitsc-text-on-primary: #FFFFFF;

    /* Borders */
    --aitsc-border: #E2E8F0;
    --aitsc-border-light: #F1F5F9;
    --aitsc-border-focus: #005cb2;

    /* Shadows */
    --aitsc-shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
    --aitsc-shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1);
    --aitsc-shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1);
    --aitsc-shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);

    /* CTA Buttons */
    --aitsc-cta-bg: #005cb2;
    --aitsc-cta-bg-hover: #004a94;
    --aitsc-cta-text: #FFFFFF;
    --aitsc-cta-secondary-bg: transparent;
    --aitsc-cta-secondary-border: #005cb2;
    --aitsc-cta-secondary-text: #005cb2;

    /* States */
    --aitsc-success: #10B981;
    --aitsc-warning: #F59E0B;
    --aitsc-error: #EF4444;
    --aitsc-info: #3B82F6;

    /* Typography (keep existing) */
    --aitsc-font-main: 'Manrope', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    --aitsc-font-heading: 'Manrope', sans-serif;

    /* Spacing (keep existing) */
    --aitsc-container-width: 1400px;
    --aitsc-radius-sm: 4px;
    --aitsc-radius-md: 8px;
    --aitsc-radius-lg: 12px;
    --aitsc-radius-xl: 16px;

    /* Transitions */
    --aitsc-transition-fast: 0.15s ease;
    --aitsc-transition-normal: 0.3s cubic-bezier(0.4, 0, 0.2, 1);

    /* DEPRECATED - Remove after migration */
    /* --wq-black, --wq-panel, --wq-text, etc. */
}
```

### Step 2: Update Global Body Styles

```css
/* Before */
body {
    background: #000;
    color: #fff;
}

/* After */
body {
    background: var(--aitsc-bg-primary);
    color: var(--aitsc-text-primary);
    font-family: var(--aitsc-font-main);
    line-height: 1.6;
}
```

### Step 3: Update Utility Classes

```css
/* Background utilities */
.bg-primary { background-color: var(--aitsc-bg-primary); }
.bg-secondary { background-color: var(--aitsc-bg-secondary); }
.bg-tertiary { background-color: var(--aitsc-bg-tertiary); }
.bg-brand { background-color: var(--aitsc-primary); }

/* Text utilities */
.text-primary { color: var(--aitsc-text-primary); }
.text-secondary { color: var(--aitsc-text-secondary); }
.text-muted { color: var(--aitsc-text-muted); }
.text-brand { color: var(--aitsc-primary); }
.text-white { color: #FFFFFF; }

/* Border utilities */
.border-default { border-color: var(--aitsc-border); }
.border-light { border-color: var(--aitsc-border-light); }
.border-brand { border-color: var(--aitsc-primary); }
```

### Step 4: Remove Dark Mode Queries

Search and remove all instances of:
```css
@media (prefers-color-scheme: dark) { ... }
```

### Step 5: Remove body::before Pattern

In `header.php`, remove:
```css
body::before {
    content: "";
    background-image: url('...');
    /* dark pattern overlay - REMOVE */
}
```

---

## Todo List

- [ ] Backup current style.css
- [ ] Replace :root variables
- [ ] Update body/html base styles
- [ ] Update utility classes (.bg-*, .text-*)
- [ ] Remove @media (prefers-color-scheme: dark) blocks
- [ ] Remove body::before dark pattern
- [ ] Update card-variants.css colors
- [ ] Update hero-variants.css colors
- [ ] Update cta-styles.css colors
- [ ] Update stats-styles.css colors
- [ ] Update carousel-styles.css colors
- [ ] Remove header.php inline dark styles
- [ ] Contrast ratio verification
- [ ] Visual QA on local

---

## Success Criteria

1. All CSS variables reference new white theme tokens
2. No hardcoded dark colors (#000, #111, #222) in stylesheets
3. No `prefers-color-scheme: dark` media queries
4. All text meets WCAG 2.1 AA contrast (4.5:1)
5. Site renders with white background, dark text globally

---

## Rollback Plan

Keep backup of original files:
```bash
cp style.css style.css.dark-backup
cp -r components/ components-dark-backup/
```
