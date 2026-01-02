# Code Standards and Development Best Practices

## 1. General Principles
- **DRY (Don't Repeat Yourself)**: Use components and template parts for reusable UI elements.
- **KISS (Keep It Simple, Stupid)**: Favor clear, maintainable code over complex optimizations.
- **Security First**: Always sanitize inputs and escape outputs.

## 2. Component Standards

### 2.1 Universal Components
All components must follow the Universal Component System pattern:
- PHP template function in `components/[name]/[name].php`.
- Dedicated CSS file in `components/[name]/[name]-styles.css`.
- Registered and enqueued via `inc/components.php`.
- Support for default parameters and configuration arrays.

### 2.2 Naming Conventions
- **CSS**: Follow BEM (Block Element Modifier) convention.
  - Block: `.aitsc-hero`
  - Element: `.aitsc-hero__title`
  - Modifier: `.aitsc-hero--page`
- **PHP Functions**: Prefix with `aitsc_` (e.g., `aitsc_render_hero()`).
- **CSS Variables**: Prefix with `--aitsc-` (e.g., `--aitsc-primary`).

## 3. Hero Component Implementation Standard
The hero component (`aitsc_render_hero`) is the standardized way to implement top-of-page content.

### 3.1 Variants
- `homepage`: Large hero with particle background.
- `page`: Standard page hero with light gradient and cyan accents. Used for child pages, archives, and standard internal pages.
- `pillar`: Product pillar pages with left-aligned content and prominent CTA.
- `white-fullwidth`: Full-width image background with a centered, blurred content box.

### 3.2 Required Arguments
```php
aitsc_render_hero([
    'variant' => 'page', // homepage|page|pillar|white-fullwidth
    'title'   => 'Page Title', // Supports HTML for branding spans
]);
```

### 3.3 Child Page Standardization
All child pages (About, Contact, etc.) and archives (Solutions, Case Studies) must use the `page` variant with `height => 'medium'` for consistency across the site.

## 4. Accessibility (WCAG 2.1 AA)
- Use semantic HTML5 elements.
- Provide descriptive `aria-label` attributes for interactive elements.
- Ensure all images have `alt` text.
- Maintain a minimum color contrast ratio of 4.5:1.
- Support `prefers-reduced-motion` for all animations.

## 5. Security Protocols
- **Sanitization**: Use `sanitize_text_field()`, `esc_url_raw()`, etc., for all inputs.
- **Escaping**: Use `esc_html()`, `esc_attr()`, `esc_url()`, and `wp_kses_post()` for all outputs.
- **Nonces**: Use nonces for all form submissions and AJAX requests.
- **Permissions**: Verify user capabilities using `current_user_can()`.
