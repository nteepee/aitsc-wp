# Phase 1: Design System Update

**Parent**: [plan.md](./plan.md)
**Status**: Pending
**Priority**: Critical (Foundation)
**Estimated**: 8 hours

---

## Context

Current AITSC theme uses WorldQuant-inspired dark mode with `--wq-*` and `--aitsc-*` CSS variables. Harrison.ai requires clean, professional healthcare aesthetic with light backgrounds and medical blue accents.

### Current Variables (style.css:8-116)
```css
--wq-black: #000000;
--wq-panel: #111111;
--aitsc-primary: #1863F7;
--aitsc-secondary: #1841C5;
--aitsc-bg-dark: #000000;
```

### Target Variables (Harrison.ai)
```css
--hai-bg-primary: #FFFFFF;
--hai-bg-secondary: #F8FAFC;
--hai-accent-primary: #3B82F6;
--hai-accent-cta: #059669;
--hai-text-primary: #1E293B;
```

---

## Overview

Introduce dual-theme CSS variable system supporting both legacy dark mode and new Harrison.ai light mode via CSS custom property layering.

---

## Key Insights

1. **No Breaking Changes** - Layer new variables, don't replace old ones
2. **Theme Toggle** - Use `[data-theme="light"]` selector for new mode
3. **Component Override** - Components check theme context for styling
4. **Gradual Migration** - Templates can opt-in to new theme

---

## Requirements

### Functional
- [ ] Add Harrison.ai color palette as `--hai-*` variables
- [ ] Create theme toggle mechanism (data attribute based)
- [ ] Update component base styles to support both themes
- [ ] Add smooth theme transition (0.3s CSS transition)

### Non-Functional
- [ ] No JS required for theme switching (CSS only)
- [ ] CSS file size increase < 15KB
- [ ] Zero flicker on page load

---

## Architecture

```
style.css
  |-- :root (existing dark theme variables)
  |-- :root (new --hai-* variables)
  |
  +-- [data-theme="light"]
       |-- Override --aitsc-* with --hai-* values
       |-- Component-specific light mode styles
```

### File Changes
| File | Action | Description |
|------|--------|-------------|
| `style.css` | MODIFY | Add --hai-* variables at :root level |
| `style.css` | ADD | [data-theme="light"] ruleset |
| `header.php` | MODIFY | Add data-theme attribute to body |
| `customizer/panels/colors.php` | MODIFY | Add light/dark toggle |

---

## Implementation Steps

### Step 1: Add Harrison.ai Variables (2h)
Add to style.css after existing :root block:

```css
/* Harrison.ai Healthcare Theme Variables */
:root {
  /* Backgrounds */
  --hai-bg-primary: #FFFFFF;
  --hai-bg-secondary: #F8FAFC;
  --hai-bg-tertiary: #F1F5F9;
  --hai-bg-dark: #0F172A;

  /* Brand Colors */
  --hai-brand-blue: #3B82F6;
  --hai-brand-cyan: #0891B2;
  --hai-brand-green: #059669;
  --hai-brand-purple: #7C3AED;

  /* Text Colors */
  --hai-text-primary: #1E293B;
  --hai-text-secondary: #475569;
  --hai-text-muted: #94A3B8;
  --hai-text-inverted: #FFFFFF;

  /* Borders & Shadows */
  --hai-border: #E2E8F0;
  --hai-shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
  --hai-shadow-md: 0 4px 6px rgba(0,0,0,0.07);
  --hai-shadow-lg: 0 10px 25px rgba(0,0,0,0.1);
}
```

### Step 2: Light Theme Override (2h)
Add [data-theme="light"] block:

```css
[data-theme="light"] {
  /* Background Overrides */
  --aitsc-bg-dark: var(--hai-bg-primary);
  --aitsc-bg-panel: var(--hai-bg-secondary);
  --wq-black: var(--hai-bg-primary);
  --wq-panel: var(--hai-bg-secondary);

  /* Text Overrides */
  --aitsc-text-main: var(--hai-text-primary);
  --aitsc-text-light: var(--hai-text-secondary);
  --wq-text: var(--hai-text-primary);
  --wq-text-muted: var(--hai-text-secondary);

  /* Accent Overrides */
  --aitsc-primary: var(--hai-brand-blue);
  --wq-cyan: var(--hai-brand-cyan);

  /* Border Overrides */
  --aitsc-border-color: var(--hai-border);
  --wq-border: var(--hai-border);

  /* Transitions */
  color: var(--hai-text-primary);
  background-color: var(--hai-bg-primary);
  transition: background-color 0.3s ease, color 0.3s ease;
}
```

### Step 3: Header Theme Attribute (1h)
Modify header.php to include theme attribute:

```php
<body <?php body_class(); ?> data-theme="<?php echo get_theme_mod('aitsc_theme_mode', 'dark'); ?>">
```

### Step 4: Customizer Integration (2h)
Add to customizer/panels/colors.php:

```php
$wp_customize->add_setting('aitsc_theme_mode', [
    'default' => 'dark',
    'transport' => 'refresh',
]);

$wp_customize->add_control('aitsc_theme_mode', [
    'label' => __('Theme Mode', 'aitsc-pro-theme'),
    'section' => 'aitsc_colors',
    'type' => 'select',
    'choices' => [
        'dark' => __('Dark (WorldQuant)', 'aitsc-pro-theme'),
        'light' => __('Light (Healthcare)', 'aitsc-pro-theme'),
    ],
]);
```

### Step 5: Component Light Mode Styles (1h)
Add component-specific light mode overrides:

```css
/* Card Light Mode */
[data-theme="light"] .aitsc-card {
  background: var(--hai-bg-primary);
  border: 1px solid var(--hai-border);
  box-shadow: var(--hai-shadow-sm);
}

[data-theme="light"] .aitsc-card:hover {
  box-shadow: var(--hai-shadow-md);
}

/* Hero Light Mode */
[data-theme="light"] .aitsc-hero {
  background: var(--hai-bg-secondary);
}

[data-theme="light"] .aitsc-hero__title {
  color: var(--hai-text-primary);
}
```

---

## Todo Checklist

- [ ] Add --hai-* CSS variables to :root
- [ ] Create [data-theme="light"] override block
- [ ] Update header.php with data-theme attribute
- [ ] Add theme mode customizer control
- [ ] Add card component light mode styles
- [ ] Add hero component light mode styles
- [ ] Add CTA component light mode styles
- [ ] Test theme switching (no flicker)
- [ ] Verify dark mode unchanged
- [ ] Performance audit (CSS size)

---

## Success Criteria

1. **Theme Toggle Works** - Switching data-theme changes all colors
2. **No Dark Mode Regression** - Existing pages unchanged when dark
3. **Smooth Transition** - 0.3s ease transition between themes
4. **Customizer Control** - Admin can select theme mode
5. **CSS Size** - Increase < 15KB gzipped

---

## Risk Assessment

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|------------|
| Variable name collision | Low | High | Use --hai-* prefix |
| Specificity conflicts | Medium | Medium | Use [data-theme] selector |
| Flash of wrong theme | Medium | Low | Set theme in <head> |
| Component visual breaks | Low | High | Visual regression testing |

---

## Rollback Procedure

1. Remove [data-theme="light"] block from style.css
2. Remove data-theme attribute from header.php
3. Remove customizer control
4. Keep --hai-* variables (harmless, may use later)

---

## Dependencies

- None (foundation phase)

## Blocks

- Phase 2-6 all depend on this phase completion
