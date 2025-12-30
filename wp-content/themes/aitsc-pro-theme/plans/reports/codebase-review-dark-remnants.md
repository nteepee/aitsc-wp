# Codebase Review: Dark Theme Remnants & Fragmentation Analysis

**Date**: 2025-12-30
**Scope**: Codebase audit for dark theme remnants and class fragmentation
**Target**: Complete transition to White Theme (Harrison.ai style)

---

## 1. Dark Theme Remnants Analysis

Despite previous migration efforts, significant dark theme code persists.

### A. Hardcoded Dark Backgrounds
The following files contain hardcoded black (`#000`) or dark backgrounds that must be removed:

1.  **`style.css`**:
    *   Line 776, 2270, 2301, 3523, 3728: Usage of undefined `var(--aitsc-bg-dark)`.
    *   Line 398: `#page { background-color: #000; }` (Root cause of dark page background).
    *   Line 1589: `.hero-section { background: #000; }`.
    *   Line 2100: Explicit comment `/* Force dark background */`.

2.  **`page.php`**:
    *   `background-color: var(--wq-black);` - Legacy WorldQuant variable usage.

3.  **Components**:
    *   `stats-styles.css`: Uses dark gradients (`linear-gradient(135deg, #1a1a1a...`).
    *   `card-variants.css`: Contains `@media (prefers-color-scheme: dark)` blocks that override white styles.

### B. "Dark Mode" Logic
The theme still attempts to support system dark mode, which conflicts with the requirement for a "100% white theme".
*   **Media Queries**: Found in `card-variants.css`, `logo-carousel-styles.css`, and `stats-styles.css`.
*   **Variables**: `var(--aitsc-bg-dark)` is used but often falls back to browser defaults or inherited dark styles.

---

## 2. Class Fragmentation & Universality Check

The codebase suffers from "Design System Schizophrenia"—the simultaneous existence of three competing systems.

### A. The Three Systems (Conflict Source)

| System | Identifier | Status | Action Required |
| :--- | :--- | :--- | :--- |
| **1. WorldQuant Legacy** | `.wq-*`, `.btn-neon`, `.glass-panel` | **DEPRECATED** | Delete or map to new system. |
| **2. Transition Phase** | `.btn-primary`, `.section-title`, `.card` | **FRAGMENTED** | Consolidate into BEM components. |
| **3. Harrison Universal** | `.aitsc-*` (e.g., `.aitsc-card`) | **TARGET** | Standardize everything to this. |

### B. Specific Fragmentation Findings

1.  **Cards (High Fragmentation)**
    *   **Legacy**: `.wq-blog-card` (found in `template-parts/content-solutions.php`).
    *   **Legacy**: `.solution-card`.
    *   **Target**: `.aitsc-card` with variants (`--white-feature`, `--white-minimal`).
    *   *Issue*: `front-page.php` uses new components, but `content-solutions.php` still uses legacy `.wq-blog-card`.

2.  **Buttons**
    *   **Legacy**: `.btn-primary`, `.btn-outline`, `.wq-btn-mini-neon`.
    *   **Target**: `.aitsc-cta__button`.
    *   *Issue*: Inconsistent padding, hover states, and border radiuses across different button classes.

3.  **Headings**
    *   **Legacy**: `.wq-hero-title`, `.wq-section-title`.
    *   **Utility**: Tailwind-like classes (`text-4xl`, `font-bold`).
    *   **Target**: Semantic HTML (`h1`, `h2`) styled via base typography or BEM component headers.

4.  **Sections**
    *   **Legacy**: `.scroll-section`.
    *   **Target**: `<section class="aitsc-section">` (Standardized spacing/padding).

---

## 3. Action Plan: Phase 6 - Standardization & Cleanup

To fix "how this happened" (incomplete migration) and ensure universality:

### Step 1: Nuclear Option on Dark Mode (Priority: Critical)
1.  **Delete** all `@media (prefers-color-scheme: dark)` blocks from components.
2.  **Remove** `#page { background-color: #000; }` from `style.css`.
3.  **Find & Replace** all `var(--aitsc-bg-dark)` with `var(--aitsc-bg-primary)` (White).
4.  **Remove** `wp-content/themes/aitsc-pro-theme/style.css.dark-backup`.

### Step 2: Component Universalization (Priority: High)
1.  **Refactor `content-solutions.php`**: Replace `.wq-blog-card` structure with `aitsc_render_card()`.
2.  **Refactor `taxonomy-solution_category.php`**: Replace `.wq-huge-title` and `.wq-body-text` with standard HTML tags and universal utility classes.

### Step 3: CSS Cleanup (Priority: Medium)
1.  **Delete** the `/* WorldQuant Legacy Styles */` section from `style.css`.
2.  **Consolidate Buttons**: Map `.btn-primary` to extend `.aitsc-cta__button` styles, then delete duplicate CSS.
