# Phase 4: Header & Navigation Redesign

**Status**: Not Started
**Priority**: High
**Dependencies**: Phase 1

---

## Context

Transform navigation from dark glassmorphism style to Harrison.ai-inspired white navigation bar with horizontal menu and prominent CTA button.

---

## Current State

**header.php Analysis**:
- Dark glassmorphism inline styles
- Logo on left, menu centered/right
- Mobile hamburger toggle
- body::before dark pattern overlay

**Target State** (Harrison.ai style):
- Pure white background
- Subtle bottom border/shadow
- Horizontal menu: PRODUCTS, SOLUTIONS, RESOURCES, COMPANY, CONTACT
- Blue "Book a demo" CTA button (right)
- Optional: Globe icon for language

---

## Files to Modify

| File | Changes |
|------|---------|
| `header.php` | Remove inline dark styles, update structure |
| `style.css` | Update .site-header styles |
| `template-parts/navigation.php` | Update menu output |

---

## Implementation

### 1. Update header.php

**Remove inline `<style>` block** (lines 10-106):
- Remove `.aitsc-glass-card` styles
- Remove `.aitsc-ecosystem-card` styles
- Remove `.aitsc-cta-btn` styles (move to style.css)
- Remove `body::before` pattern

**Updated header.php structure**:

```php
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#primary">
            <?php esc_html_e('Skip to content', 'aitsc-pro-theme'); ?>
        </a>

        <header id="masthead" class="site-header">
            <div class="site-header__container">

                <!-- Logo -->
                <div class="site-header__logo">
                    <?php
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        $logo_url = get_template_directory_uri() . '/assets/images/brand/logo.png';
                        ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="site-logo">
                            <img src="<?php echo esc_url($logo_url); ?>" alt="AITSC" class="site-logo__image" />
                        </a>
                        <?php
                    }
                    ?>
                </div>

                <!-- Navigation -->
                <nav id="site-navigation" class="site-header__nav" aria-label="Primary navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id' => 'primary-menu',
                        'menu_class' => 'site-header__menu',
                        'container' => false,
                        'fallback_cb' => false,
                    ));
                    ?>
                </nav>

                <!-- CTA Button -->
                <div class="site-header__cta">
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="site-header__cta-btn">
                        <?php esc_html_e('Get a Quote', 'aitsc-pro-theme'); ?>
                    </a>
                </div>

                <!-- Mobile Toggle -->
                <button class="site-header__toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="material-symbols-outlined">menu</span>
                    <span class="screen-reader-text"><?php esc_html_e('Menu', 'aitsc-pro-theme'); ?></span>
                </button>

            </div>
        </header>
```

### 2. Update Navigation CSS

**Add to style.css** (replace existing .site-header):

```css
/* ==========================================================================
   Site Header - White Theme
   ========================================================================== */

.site-header {
    position: sticky;
    top: 0;
    z-index: 100;
    background: var(--aitsc-bg-primary);
    border-bottom: 1px solid var(--aitsc-border);
    box-shadow: var(--aitsc-shadow-sm);
}

.site-header__container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: var(--aitsc-container-width);
    margin: 0 auto;
    padding: 0 1.5rem;
    height: 72px;
}

/* Logo */
.site-header__logo {
    flex-shrink: 0;
}

.site-logo {
    display: flex;
    align-items: center;
}

.site-logo__image {
    height: 40px;
    width: auto;
}

/* Navigation Menu */
.site-header__nav {
    display: none;
}

@media (min-width: 62rem) {
    .site-header__nav {
        display: flex;
        flex: 1;
        justify-content: center;
    }
}

.site-header__menu {
    display: flex;
    align-items: center;
    gap: 2rem;
    list-style: none;
    margin: 0;
    padding: 0;
}

.site-header__menu li {
    position: relative;
}

.site-header__menu a {
    display: block;
    padding: 0.5rem 0;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--aitsc-text-primary);
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.02em;
    transition: color 0.2s ease;
}

.site-header__menu a:hover,
.site-header__menu .current-menu-item a {
    color: var(--aitsc-primary);
}

/* Dropdown indicator */
.site-header__menu .menu-item-has-children > a::after {
    content: '';
    display: inline-block;
    width: 0;
    height: 0;
    margin-left: 0.5rem;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-top: 4px solid currentColor;
    vertical-align: middle;
}

/* Submenu */
.site-header__menu .sub-menu {
    position: absolute;
    top: 100%;
    left: 0;
    min-width: 200px;
    background: var(--aitsc-bg-primary);
    border: 1px solid var(--aitsc-border);
    border-radius: var(--aitsc-radius-md);
    box-shadow: var(--aitsc-shadow-lg);
    padding: 0.5rem 0;
    list-style: none;
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: all 0.2s ease;
}

.site-header__menu li:hover > .sub-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.site-header__menu .sub-menu a {
    padding: 0.75rem 1.25rem;
    font-size: 0.875rem;
    text-transform: none;
}

.site-header__menu .sub-menu a:hover {
    background: var(--aitsc-bg-secondary);
}

/* CTA Button */
.site-header__cta {
    display: none;
}

@media (min-width: 62rem) {
    .site-header__cta {
        display: block;
        flex-shrink: 0;
    }
}

.site-header__cta-btn {
    display: inline-flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--aitsc-text-on-primary);
    background: var(--aitsc-primary);
    border: none;
    border-radius: var(--aitsc-radius-md);
    text-decoration: none;
    transition: background 0.2s ease, transform 0.2s ease;
}

.site-header__cta-btn:hover {
    background: var(--aitsc-primary-hover);
    transform: translateY(-1px);
}

/* Mobile Toggle */
.site-header__toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    padding: 0;
    background: transparent;
    border: none;
    color: var(--aitsc-text-primary);
    cursor: pointer;
}

@media (min-width: 62rem) {
    .site-header__toggle {
        display: none;
    }
}

.site-header__toggle .material-symbols-outlined {
    font-size: 28px;
}

/* Mobile Menu Open State */
.site-header.menu-open .site-header__nav {
    display: block;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: var(--aitsc-bg-primary);
    border-bottom: 1px solid var(--aitsc-border);
    box-shadow: var(--aitsc-shadow-lg);
    padding: 1rem;
}

.site-header.menu-open .site-header__menu {
    flex-direction: column;
    align-items: stretch;
    gap: 0;
}

.site-header.menu-open .site-header__menu a {
    padding: 1rem;
    border-bottom: 1px solid var(--aitsc-border-light);
}

.site-header.menu-open .site-header__cta {
    display: block;
    padding: 1rem;
    border-top: 1px solid var(--aitsc-border);
}

.site-header.menu-open .site-header__cta-btn {
    display: block;
    width: 100%;
    text-align: center;
}
```

### 3. Mobile Toggle JavaScript

**Update assets/js/aitsc-interactive.js** (or add inline):

```javascript
// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.querySelector('.site-header__toggle');
    const header = document.querySelector('.site-header');

    if (toggle && header) {
        toggle.addEventListener('click', function() {
            header.classList.toggle('menu-open');
            const isOpen = header.classList.contains('menu-open');
            toggle.setAttribute('aria-expanded', isOpen);
            toggle.querySelector('.material-symbols-outlined').textContent = isOpen ? 'close' : 'menu';
        });
    }
});
```

---

## Menu Structure

Update WordPress menu to match Harrison.ai structure:

```
PRODUCTS (dropdown)
  - Fleet Safe Pro
  - Passenger Monitoring
  - Custom Solutions

SOLUTIONS (dropdown)
  - By Industry
  - By Use Case

RESOURCES (dropdown)
  - Case Studies
  - Documentation
  - Blog

COMPANY (dropdown)
  - About Us
  - Careers
  - Contact

CONTACT (direct link)
```

---

## Todo List

- [ ] Backup current header.php
- [ ] Remove inline <style> block from header.php
- [ ] Update header.php HTML structure
- [ ] Add white navigation CSS to style.css
- [ ] Update mobile toggle JavaScript
- [ ] Update WordPress menu structure
- [ ] Test sticky header behavior
- [ ] Test dropdown menus
- [ ] Test mobile menu toggle
- [ ] Test keyboard navigation (accessibility)
- [ ] Verify CTA button styling

---

## Success Criteria

1. Header has white background with subtle shadow
2. Menu items display horizontally on desktop
3. Blue CTA button visible on right
4. Mobile hamburger works correctly
5. Dropdowns animate smoothly
6. Sticky header works on scroll
7. Keyboard navigation functional
8. No JavaScript errors
