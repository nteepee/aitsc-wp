# CSS Migration Strategy: Dark to White Theme

## Current State Analysis

**Files to Modify**:
- `style.css` (3,965 lines) - Main stylesheet
- `components/card/card-variants.css` (440 lines)
- `components/card/card-animations.css`
- `components/hero/hero-variants.css` (403 lines)
- `components/hero/hero-animations.css`
- `components/cta/cta-styles.css`
- `components/stats/stats-styles.css`
- `components/testimonial/carousel-styles.css`
- `header.php` inline styles (~100 lines)

---

## Variable Replacement Map

### Core Color Variables

| Old Variable | Old Value | New Variable | New Value |
|-------------|-----------|--------------|-----------|
| `--wq-black` | #000000 | `--aitsc-bg-primary` | #FFFFFF |
| `--wq-panel` | #111111 | `--aitsc-bg-secondary` | #F8FAFC |
| `--wq-text` | #ffffff | `--aitsc-text-primary` | #1E293B |
| `--wq-text-muted` | #888888 | `--aitsc-text-muted` | #64748B |
| `--wq-blue` | #005cb2 | `--aitsc-primary` | #005cb2 |
| `--wq-cyan` | #005cb2 | `--aitsc-primary` | #005cb2 |
| `--wq-border` | #333 | `--aitsc-border` | #E2E8F0 |
| `--wq-card-bg` | #111 | `--aitsc-card-bg` | #FFFFFF |
| `--wq-dark-grey` | #222 | `--aitsc-bg-tertiary` | #F1F5F9 |
| `--aitsc-bg-dark` | #000000 | REMOVE | - |
| `--aitsc-bg-panel` | rgba(20,20,20,0.6) | `--aitsc-bg-panel` | rgba(248,250,252,0.9) |

### New White Theme Variables

```css
:root {
    /* Backgrounds */
    --aitsc-bg-primary: #FFFFFF;
    --aitsc-bg-secondary: #F8FAFC;
    --aitsc-bg-tertiary: #F1F5F9;
    --aitsc-bg-panel: rgba(248, 250, 252, 0.9);

    /* Primary Brand */
    --aitsc-primary: #005cb2;
    --aitsc-primary-hover: #004a94;
    --aitsc-primary-light: #E0F2FE;

    /* Text */
    --aitsc-text-primary: #1E293B;
    --aitsc-text-secondary: #475569;
    --aitsc-text-muted: #64748B;
    --aitsc-text-light: #94A3B8;

    /* Borders */
    --aitsc-border: #E2E8F0;
    --aitsc-border-light: #F1F5F9;
    --aitsc-border-focus: #005cb2;

    /* Shadows (for white cards) */
    --aitsc-shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
    --aitsc-shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
    --aitsc-shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
    --aitsc-shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1);

    /* CTA */
    --aitsc-cta-bg: #005cb2;
    --aitsc-cta-bg-hover: #004a94;
    --aitsc-cta-text: #FFFFFF;

    /* States */
    --aitsc-success: #10B981;
    --aitsc-warning: #F59E0B;
    --aitsc-error: #EF4444;
}
```

---

## File-by-File Migration

### 1. style.css (Main)

**Section: :root variables (lines 1-116)**

Replace entire `:root` block with new white theme variables.

**Section: Utility classes (lines 117-500)**

Update color utilities:
```css
/* OLD */
.bg-black { background-color: #000; }
.text-white { color: #fff; }

/* NEW */
.bg-white { background-color: var(--aitsc-bg-primary); }
.bg-light { background-color: var(--aitsc-bg-secondary); }
.text-dark { color: var(--aitsc-text-primary); }
.text-muted { color: var(--aitsc-text-muted); }
```

**Section: Body/Global (search & replace)**

```css
/* OLD */
body { background: #000; color: #fff; }

/* NEW */
body { background: var(--aitsc-bg-primary); color: var(--aitsc-text-primary); }
```

### 2. card-variants.css

**Glass variant**: Keep for legacy, update colors
**Solid variant**: Primary white variant
**Solution variant**: Convert to white-feature

```css
/* OLD .aitsc-card--solution */
.aitsc-card--solution {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

/* NEW .aitsc-card--white-feature */
.aitsc-card--white-feature {
    background: var(--aitsc-bg-primary);
    border: 1px solid var(--aitsc-border);
    box-shadow: var(--aitsc-shadow-md);
}
```

### 3. hero-variants.css

**Homepage variant**: Convert gradient
**Page variant**: Already light-ish, refine

```css
/* OLD */
.aitsc-hero--homepage {
    background: linear-gradient(135deg, #001a33 0%, #005cb2 100%);
    color: #ffffff;
}

/* NEW - For photo bg hero */
.aitsc-hero--white-fullwidth {
    background-size: cover;
    background-position: center;
    color: #ffffff;
}

.aitsc-hero--white-fullwidth .aitsc-hero__overlay {
    background: linear-gradient(180deg, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.5) 100%);
}
```

### 4. header.php Inline Styles

**Remove**: Glassmorphism dark styles
**Add**: White navigation bar styles

```css
/* OLD (remove) */
.aitsc-glass-card {
    background-color: rgba(15, 23, 42, 0.5);
    border: 1px solid rgba(30, 41, 59, 1);
}

/* NEW */
.site-header {
    background: var(--aitsc-bg-primary);
    border-bottom: 1px solid var(--aitsc-border);
    box-shadow: var(--aitsc-shadow-sm);
}
```

---

## Contrast Verification (WCAG 2.1 AA)

All text must meet 4.5:1 contrast ratio.

| Combination | Ratio | Pass |
|-------------|-------|------|
| #1E293B on #FFFFFF | 12.6:1 | Yes |
| #475569 on #FFFFFF | 7.0:1 | Yes |
| #64748B on #FFFFFF | 4.6:1 | Yes |
| #94A3B8 on #FFFFFF | 3.0:1 | NO - Large text only |
| #005cb2 on #FFFFFF | 5.4:1 | Yes |
| #FFFFFF on #005cb2 | 5.4:1 | Yes |

**Action**: Use `--aitsc-text-muted` (#64748B) minimum for body text.

---

## Search & Replace Patterns

Execute in order:

```bash
# 1. Background colors
s/background:\s*#000/background: var(--aitsc-bg-primary)/g
s/background:\s*#111/background: var(--aitsc-bg-secondary)/g
s/background-color:\s*#000/background-color: var(--aitsc-bg-primary)/g

# 2. Text colors
s/color:\s*#fff/color: var(--aitsc-text-primary)/g
s/color:\s*#ffffff/color: var(--aitsc-text-primary)/g
s/color:\s*#888/color: var(--aitsc-text-muted)/g

# 3. Border colors
s/border-color:\s*#333/border-color: var(--aitsc-border)/g
s/border:\s*1px\s*solid\s*rgba\(255,\s*255,\s*255,\s*0\.1\)/border: 1px solid var(--aitsc-border)/g

# 4. Variable references
s/var\(--wq-black\)/var(--aitsc-bg-primary)/g
s/var\(--wq-panel\)/var(--aitsc-bg-secondary)/g
s/var\(--wq-text\)/var(--aitsc-text-primary)/g
```

---

## Dark Mode Removal Checklist

- [ ] Remove `prefers-color-scheme: dark` media queries
- [ ] Remove `.dark-mode` class toggles
- [ ] Remove theme toggle component (`theme-toggle.php`)
- [ ] Remove any JS theme switching logic
- [ ] Remove body::before dark pattern overlay
- [ ] Update glassmorphism to white-morphism

---

## Typography Adjustments

Keep Manrope/Inter fonts but adjust for white backgrounds:

```css
/* Headlines - slightly darker weight for white bg */
h1, h2, h3 {
    font-family: var(--aitsc-font-heading);
    color: var(--aitsc-text-primary);
    font-weight: 700; /* Was 600-800 for dark */
}

/* Body - standard weight */
body {
    font-family: var(--aitsc-font-main);
    color: var(--aitsc-text-secondary);
    font-weight: 400;
    line-height: 1.6;
}

/* Hero headlines - larger for Harrison.ai style */
.aitsc-hero__title {
    font-size: clamp(2.5rem, 5vw, 4.5rem);
    font-weight: 700;
    line-height: 1.1;
}
```

---

## CSS File Size Optimization

After migration:
1. Remove unused dark-mode-only styles (~200 lines estimated)
2. Consolidate duplicate utility classes
3. Remove vendor prefixes handled by autoprefixer
4. Target: <3500 lines (from 3965)
