# Phase 2: Component Dark Mode Removal Strategy

**Objective**: Remove dark mode support from specific component CSS files.
**Dependencies**: None.
**Output**: Component CSS files with only light mode styles.

## Targets
- `wp-content/themes/aitsc-pro-theme/components/card/card-variants.css`
- `wp-content/themes/aitsc-pro-theme/components/stats/stats-styles.css`
- `wp-content/themes/aitsc-pro-theme/components/logo-carousel/logo-carousel-styles.css`
- `wp-content/themes/aitsc-pro-theme/components/hero/hero-variants.css`
- `wp-content/themes/aitsc-pro-theme/components/cta/cta-styles.css`

## Action Items

1.  **Iterate through Component CSS Files**
    *   For each file listed above:
        *   Find `@media (prefers-color-scheme: dark)` blocks.
        *   Delete the entire block.
        *   Find any `.wq-*` classes creeping into components.
        *   Rename to `.aitsc-*` if necessary or remove if redundant.

2.  **Specific Fixes**
    *   **Card Variants**: Ensure cards always have white backgrounds (`#FFFFFF`) and proper shadows.
    *   **Stats**: Ensure text is always dark on white/light backgrounds.
    *   **Logo Carousel**: Ensure logos are visible (no white logos on white background logic).

3.  **Validation**
    *   Verify components render correctly in browser (simulate light mode only).

## Execution Steps

```bash
# Example for one file
# sed -i '/@media (prefers-color-scheme: dark)/,+10d' filename
# (Better to use Edit tool for precision)
```
