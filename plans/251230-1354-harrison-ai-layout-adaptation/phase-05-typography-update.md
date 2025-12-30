# Phase 5: Typography Update

**Parent**: [plan.md](./plan.md)
**Status**: Pending
**Priority**: Medium
**Estimated**: 4 hours
**Depends On**: Phase 1

---

## Context

Current AITSC theme uses Manrope for headings and Inter for body text. Harrison.ai research suggests Lexend/Poppins (headings) and Source Sans Pro/Open Sans (body) for healthcare readability.

### Current Typography
```css
--aitsc-font-main: 'Manrope', -apple-system, BlinkMacSystemFont, sans-serif;
--aitsc-font-heading: 'Manrope', sans-serif;
```

### Target Typography (Harrison.ai)
| Element | Font | Weight | Notes |
|---------|------|--------|-------|
| Headings | Lexend or Poppins | 600-700 | Clean, modern |
| Body | Source Sans Pro | 400-500 | Medical readability |
| Data/Numbers | Inter | 600 | Tabular numerals |
| Labels | System Font | 500 | UI elements |

---

## Overview

Add healthcare typography as optional font stack. Allow theme switching between existing Manrope/Inter and new Lexend/Source Sans Pro. Maintain backward compatibility.

---

## Key Insights

1. **Optional Migration** - Don't force font change
2. **Font Loading Strategy** - Use font-display: swap for performance
3. **Subset Loading** - Latin subset only (smaller files)
4. **Variable Fonts** - Consider for future optimization
5. **Fallback Chain** - System fonts as ultimate fallback

---

## Requirements

### Functional
- [ ] Add Lexend and Source Sans Pro font imports
- [ ] Create --hai-font-* CSS variables
- [ ] Healthcare theme uses new fonts automatically
- [ ] Dark theme continues using Manrope/Inter

### Non-Functional
- [ ] Font file size < 100KB total
- [ ] FOUT minimized with font-display: swap
- [ ] No CLS from font loading
- [ ] Preload critical fonts

---

## Architecture

### Font Stack Strategy
```
Dark Theme (existing):
  Headings: Manrope → system-ui
  Body: Inter → system-ui

Light Theme (healthcare):
  Headings: Lexend → Poppins → system-ui
  Body: Source Sans Pro → Open Sans → system-ui
```

### File Changes
| File | Action | Description |
|------|--------|-------------|
| `style.css` | MODIFY | Add --hai-font-* variables |
| `inc/enqueue.php` | MODIFY | Add Google Fonts preconnect + import |
| `header.php` | MODIFY | Add font preload links |

---

## Implementation Steps

### Step 1: Google Fonts Import (1h)
Update `inc/enqueue.php`:

```php
/**
 * Enqueue Healthcare Typography
 */
function aitsc_enqueue_healthcare_fonts() {
    // Only load if light theme is active
    $theme_mode = get_theme_mod('aitsc_theme_mode', 'dark');

    if ($theme_mode === 'light') {
        // Preconnect to Google Fonts
        echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';

        // Google Fonts CSS
        wp_enqueue_style(
            'aitsc-healthcare-fonts',
            'https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700&family=Source+Sans+3:wght@400;500;600&display=swap',
            array(),
            null
        );
    }
}
add_action('wp_enqueue_scripts', 'aitsc_enqueue_healthcare_fonts', 5);
```

### Step 2: CSS Variables (1h)
Add to `style.css`:

```css
/* Healthcare Typography Variables */
:root {
    /* Healthcare Font Stack */
    --hai-font-heading: 'Lexend', 'Poppins', system-ui, -apple-system, sans-serif;
    --hai-font-body: 'Source Sans 3', 'Open Sans', system-ui, -apple-system, sans-serif;
    --hai-font-mono: 'JetBrains Mono', 'Fira Code', monospace;

    /* Typography Scale (healthcare-optimized) */
    --hai-text-xs: 0.75rem;      /* 12px */
    --hai-text-sm: 0.875rem;     /* 14px */
    --hai-text-base: 1rem;       /* 16px */
    --hai-text-lg: 1.125rem;     /* 18px */
    --hai-text-xl: 1.25rem;      /* 20px */
    --hai-text-2xl: 1.5rem;      /* 24px */
    --hai-text-3xl: 2rem;        /* 32px */
    --hai-text-4xl: 2.5rem;      /* 40px */
    --hai-text-5xl: 3rem;        /* 48px */
    --hai-text-6xl: 4rem;        /* 64px */

    /* Line Heights (optimized for readability) */
    --hai-leading-tight: 1.2;
    --hai-leading-snug: 1.35;
    --hai-leading-normal: 1.5;
    --hai-leading-relaxed: 1.65;
    --hai-leading-loose: 1.8;

    /* Letter Spacing */
    --hai-tracking-tight: -0.025em;
    --hai-tracking-normal: 0;
    --hai-tracking-wide: 0.025em;
    --hai-tracking-wider: 0.05em;
}

/* Apply Healthcare Typography */
[data-theme="light"] {
    font-family: var(--hai-font-body);
}

[data-theme="light"] h1,
[data-theme="light"] h2,
[data-theme="light"] h3,
[data-theme="light"] h4,
[data-theme="light"] h5,
[data-theme="light"] h6,
[data-theme="light"] .aitsc-hero__title,
[data-theme="light"] .aitsc-card__title,
[data-theme="light"] .aitsc-cta__title,
[data-theme="light"] .aitsc-layout__title {
    font-family: var(--hai-font-heading);
    letter-spacing: var(--hai-tracking-tight);
}

/* Heading Styles */
[data-theme="light"] h1 {
    font-size: var(--hai-text-5xl);
    font-weight: 700;
    line-height: var(--hai-leading-tight);
}

[data-theme="light"] h2 {
    font-size: var(--hai-text-4xl);
    font-weight: 700;
    line-height: var(--hai-leading-tight);
}

[data-theme="light"] h3 {
    font-size: var(--hai-text-2xl);
    font-weight: 600;
    line-height: var(--hai-leading-snug);
}

[data-theme="light"] h4 {
    font-size: var(--hai-text-xl);
    font-weight: 600;
    line-height: var(--hai-leading-snug);
}

/* Body Text */
[data-theme="light"] p,
[data-theme="light"] li,
[data-theme="light"] .aitsc-card__description,
[data-theme="light"] .aitsc-layout__description {
    font-size: var(--hai-text-base);
    line-height: var(--hai-leading-relaxed);
    letter-spacing: var(--hai-tracking-normal);
}

/* Large Body Text */
[data-theme="light"] .text-lg,
[data-theme="light"] .aitsc-hero__description {
    font-size: var(--hai-text-lg);
    line-height: var(--hai-leading-relaxed);
}
```

### Step 3: Font Preload (0.5h)
Update `header.php`:

```php
<?php
$theme_mode = get_theme_mod('aitsc_theme_mode', 'dark');
if ($theme_mode === 'light'):
?>
<link rel="preload" href="https://fonts.gstatic.com/s/lexend/v19/wlptgwvFAVdoq2_FKCCt1EJI.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="https://fonts.gstatic.com/s/sourcesans3/v15/nwpBtKy2OAdR1K-IwhWudF-R9QMylBJAV3Bo8Ky462EM.woff2" as="font" type="font/woff2" crossorigin>
<?php endif; ?>
```

### Step 4: Responsive Typography (1h)
Add fluid typography scaling:

```css
/* Fluid Typography for Healthcare Theme */
[data-theme="light"] {
    /* Fluid heading sizes */
    --hai-text-5xl: clamp(2.5rem, 5vw + 1rem, 4rem);
    --hai-text-4xl: clamp(2rem, 4vw + 0.5rem, 3rem);
    --hai-text-3xl: clamp(1.5rem, 3vw + 0.5rem, 2.5rem);
    --hai-text-2xl: clamp(1.25rem, 2vw + 0.5rem, 1.75rem);
}

/* Responsive adjustments */
@media (max-width: 767px) {
    [data-theme="light"] h1 {
        font-size: var(--hai-text-4xl);
    }

    [data-theme="light"] h2 {
        font-size: var(--hai-text-3xl);
    }

    [data-theme="light"] h3 {
        font-size: var(--hai-text-xl);
    }

    [data-theme="light"] p,
    [data-theme="light"] li {
        font-size: var(--hai-text-sm);
        line-height: var(--hai-leading-relaxed);
    }
}
```

### Step 5: Utility Classes (0.5h)
Add typography utility classes:

```css
/* Healthcare Typography Utilities */
.hai-heading-1 { font-size: var(--hai-text-5xl); font-weight: 700; }
.hai-heading-2 { font-size: var(--hai-text-4xl); font-weight: 700; }
.hai-heading-3 { font-size: var(--hai-text-3xl); font-weight: 600; }
.hai-heading-4 { font-size: var(--hai-text-2xl); font-weight: 600; }

.hai-body-lg { font-size: var(--hai-text-lg); line-height: var(--hai-leading-relaxed); }
.hai-body { font-size: var(--hai-text-base); line-height: var(--hai-leading-relaxed); }
.hai-body-sm { font-size: var(--hai-text-sm); line-height: var(--hai-leading-normal); }

.hai-label {
    font-size: var(--hai-text-sm);
    font-weight: 600;
    letter-spacing: var(--hai-tracking-wider);
    text-transform: uppercase;
}
```

---

## Todo Checklist

- [ ] Add Google Fonts import in inc/enqueue.php
- [ ] Add font preconnect links
- [ ] Add --hai-font-* variables to style.css
- [ ] Add --hai-text-* size scale
- [ ] Add --hai-leading-* line heights
- [ ] Apply fonts to [data-theme="light"] elements
- [ ] Add heading styles for light theme
- [ ] Add body text styles for light theme
- [ ] Add font preload links to header.php
- [ ] Add fluid typography scaling
- [ ] Add typography utility classes
- [ ] Test font loading (no FOUT)
- [ ] Verify dark theme fonts unchanged

---

## Success Criteria

1. **Fonts Load** - Lexend and Source Sans Pro load correctly
2. **Theme Switch** - Light theme uses new fonts, dark uses old
3. **No FOUT** - font-display: swap minimizes flash
4. **Performance** - < 100KB total font files
5. **Responsive** - Fluid sizing works on all devices
6. **Fallbacks** - System fonts work if Google fails

---

## Risk Assessment

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|------------|
| FOUT on slow connections | Medium | Low | Preload critical fonts |
| Google Fonts unavailable | Low | Medium | System font fallbacks |
| Font file size | Low | Medium | Latin subset only |
| Dark theme regression | Low | High | Scope all changes to [data-theme="light"] |

---

## Rollback Procedure

1. Remove healthcare font enqueue from inc/enqueue.php
2. Remove font preload from header.php
3. Remove [data-theme="light"] typography CSS
4. Keep --hai-font-* variables (harmless)

---

## Dependencies

- Phase 1 (Design System) must be complete for [data-theme] selector

---

## Font License Notes

- Lexend: OFL (Open Font License) - Free for commercial use
- Source Sans Pro: OFL - Free for commercial use
- Google Fonts: No additional licensing required
