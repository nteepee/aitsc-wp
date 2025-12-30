# Phase 3: Template Refactoring Strategy

**Objective**: Update PHP templates to remove `.wq-*` classes and use standardized `.aitsc-*` components.
**Dependencies**: None (can be done while CSS is being cleaned, but visual verification requires CSS).
**Output**: PHP files with clean semantic HTML.

## Targets
- `wp-content/themes/aitsc-pro-theme/template-parts/content-solutions.php`
- `wp-content/themes/aitsc-pro-theme/index.php`
- `wp-content/themes/aitsc-pro-theme/page.php`
- `wp-content/themes/aitsc-pro-theme/taxonomy-solution_category.php` (and similar taxonomies)

## Action Items

1.  **`content-solutions.php` Refactor**
    *   Change `.wq-blog-card` to `.aitsc-solution-card`.
    *   Change `.wq-blog-header` to `.aitsc-card-header`.
    *   Change `.wq-read-more` to `.aitsc-button-link`.
    *   Ensure structure matches the new Card Component API.

2.  **`index.php` Refactor**
    *   Change `.wq-section-title` to `.aitsc-section-title`.
    *   Change `.wq-subtitle` to `.aitsc-section-subtitle`.
    *   Update grid layout classes if they are WQ specific.

3.  **`page.php` Refactor**
    *   Check for inline styles or classes using WQ variables.
    *   Ensure default page container uses `.aitsc-container`.

4.  **Taxonomy Templates**
    *   Apply same logic as `index.php` and `content-solutions.php`.

5.  **Validation**
    *   Check "Solutions" archive page.
    *   Check standard Page template.
    *   Check Blog index.

## Execution Steps

Use `Edit` tool to replace classes in PHP files.
