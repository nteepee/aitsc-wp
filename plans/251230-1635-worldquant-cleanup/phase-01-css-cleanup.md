# Phase 1: CSS Cleanup Strategy

**Objective**: Clean `style.css` of all WorldQuant remnants and dark mode legacy code.
**Dependencies**: None.
**Output**: A clean `style.css` file.

## Targets
- File: `wp-content/themes/aitsc-pro-theme/style.css`

## Action Items

1.  **Analyze `style.css`**
    *   Identify blocks containing `.wq-*`.
    *   Identify blocks containing `@media (prefers-color-scheme: dark)`.
    *   Identify usage of legacy variables (e.g., `--wq-black`, `--aitsc-bg-dark`).

2.  **Remove Legacy Classes**
    *   Remove all selectors starting with `.wq-`.
    *   Example: `.wq-section-title`, `.wq-blog-card`.

3.  **Remove Dark Mode Styles**
    *   Remove all `@media (prefers-color-scheme: dark)` blocks.
    *   Remove `:root` variable overrides for dark mode.
    *   Hardcode background to `#FFFFFF` and text to `#0f172a` (Slate 900) or `#334155` (Slate 700) where variable fallbacks were used.

4.  **Standardize Variables**
    *   Ensure all colors use the Harrison.ai palette:
        *   Primary: `#005cb2` (Cyan Blue)
        *   Secondary: `#004990`
        *   Text: `#333333`
        *   Background: `#FFFFFF`
    *   Remove unused variables.

5.  **Validation**
    *   Verify CSS syntax is valid.
    *   Check for regression in global layout.

## Execution Steps

```bash
# 1. Backup current style.css (just in case, separate from the backups we are deleting)
cp wp-content/themes/aitsc-pro-theme/style.css wp-content/themes/aitsc-pro-theme/style.css.cleanup-backup

# 2. Use Edit tool to remove sections
# (Details to be handled by agent)
```
