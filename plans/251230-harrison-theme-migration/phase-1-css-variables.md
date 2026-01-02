# Phase 1: CSS Variable Migration

**Status**: ⚠️ Partially Complete (85%)
**Priority**: Critical
**Dependencies**: None
**Last Review**: 2025-12-31 (Code Review Complete)

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

- [x] Backup current style.css (style.css.dark-backup created)
- [x] Replace :root variables (45+ variables defined)
- [x] Update body/html base styles (using CSS variables)
- [x] Update utility classes (.bg-*, .text-*) (CSS variables in use)
- [x] Remove @media (prefers-color-scheme: dark) blocks (0 found)
- [x] Add @media (prefers-reduced-motion) support (COMPLETE)
- [x] Fix WCAG contrast violations (footer: phone=.text-slate-900, email=.text-cyan-700)
- [x] Migrate grid layouts (Engineering Services, Why Choose Us, Latest Insights)
- [x] Replace 7 dark theme colors in card-variants.css (COMPLETE)
- [ ] **CRITICAL: Define --aitsc-card-bg variable** (missing, blocks 3 card variants)
- [ ] **CRITICAL: Remove Bootstrap grid classes** (65+ instances across 15 files - see report-260102-bootstrap-grid-violations.md)
- [ ] **HIGH: Remove duplicate grid rules** (lines 3772-3806 duplicate 882-939)
- [ ] **HIGH: Escape category output** (front-page.php:193 XSS risk)
- [ ] Update card-variants.css colors (12 hardcoded values remain - 88% complete)
- [ ] Remove body::before dark pattern (needs verification in header.php)
- [ ] Update hero-variants.css colors (11 hardcoded values remain)
- [ ] Update cta-styles.css colors (16 hardcoded values remain)
- [ ] Update stats-styles.css colors (3 hardcoded values remain)
- [ ] Update carousel-styles.css colors (15 hardcoded values remain)
- [ ] Remove header.php inline dark styles
- [ ] Visual QA on local

### Hero Component Migration (2026-01-02)
- [x] Migrate page-about-aitsc.php to aitsc_render_hero()
- [x] Migrate page-contact.php to aitsc_render_hero()
- [x] Migrate archive-solutions.php to aitsc_render_hero()
- [x] Migrate archive-case-studies.php to aitsc_render_hero()
- [x] Verify hero component sanitization (XSS protection)
- [x] Verify hero component ARIA labels (WCAG 2.1 AA)
- [ ] Migrate page.php to aitsc_render_hero() (generic template)
- [ ] Document 'white-fullwidth' variant in hero-universal.php PHPDoc

### Phase 7: Fleet Safe Pro Bootstrap Cleanup (2026-01-02)
- [x] Remove Bootstrap grid classes from page-fleet-safe-pro.php (8 classes eliminated)
- [x] Replace with AITSC standardized classes (.aitsc-container, .aitsc-grid)
- [x] Verify zero Bootstrap remnants (pattern search confirmed)
- [x] Code review completed (see reports/code-reviewer-260102-phase7-fleet-safe-pro.md)

**Code Review Findings (2026-01-02 - UPDATED)**:
- ✅ Font standardization: 100% complete (all use CSS variables)
- ✅ Reduced-motion support: 100% complete (comprehensive implementation)
- ✅ WCAG compliance: 100% complete (footer contrast fixed)
- ✅ Hero component migration: 87.5% complete (7/8 instances migrated)
- ✅ Hero security: All input sanitized (esc_attr, wp_kses_post, esc_url)
- ✅ Hero accessibility: WCAG 2.1 AA compliant (ARIA labels, semantic HTML)
- ✅ DRY compliance: 61% LOC reduction (44 lines eliminated from templates)
- ✅ Phase 7 (Fleet Safe Pro): 100% complete (0 Bootstrap classes, AITSC-compliant)
- ⚠️ Color standardization: 88% complete (12 hardcoded colors remain in card-variants.css)
- ⚠️ Grid migration: IN PROGRESS - 1/15 files migrated (page-fleet-safe-pro.php complete)
- ⚠️ page.php not migrated to hero component (inconsistency with custom templates)
- ⚠️ 'white-fullwidth' variant undocumented in hero-universal.php PHPDoc
- 🔴 CRITICAL: Missing `--aitsc-card-bg` variable definition in style.css
- 🔴 CRITICAL: Bootstrap grid violations (14 files remaining, NO Bootstrap CSS loaded = non-functional)
- 🟠 HIGH: Duplicate grid CSS rules (lines 882-939 vs 3772-3806)
- 🟠 HIGH: Category output not escaped (front-page.php:193)

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
