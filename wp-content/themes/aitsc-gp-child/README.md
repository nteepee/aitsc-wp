# AITSC GeneratePress Child Theme

**Version:** 1.0.0
**Author:** Antigravity
**Author URI:** https://antigravity.com
**Theme URI:** https://aitsc.com
**License:** GNU General Public License v2 or later
**Text Domain:** aitsc-gp

---

## Overview

AITSC GeneratePress Child Theme is a custom child theme built on top of the GeneratePress framework. It extends GeneratePress with custom functionality for the Australian Integrated Transport Safety Consultants (AITSC) website, including custom post types, ACF Pro fields, interactive components, and paper stack animations.

### What is GeneratePress?

GeneratePress is a lightweight, fast, and highly customizable WordPress theme focused on performance and usability. This child theme leverages GeneratePress's core features while adding AITSC-specific functionality.

### What This Child Theme Preserves

This child theme preserves all critical functionality from the original `aitsc-pro-theme`:

- **Custom Post Types:** Solutions and Case Studies
- **ACF Pro Fields:** 755 lines of field definitions
- **Component Shortcodes:** Hero, Cards, CTA, Trust Bar, Paper Stack
- **Paper Stack Animations:** Interactive scroll effects
- **AJAX Contact Form:** Secure form handling with validation
- **Fleet Safe Pro Page:** Complete product page with gallery
- **Template System:** Single and archive templates for CPTs

---

## Requirements

### Must-Have Plugins

1. **GeneratePress** (Parent Theme)
   - Version: 3.4.0 or higher
   - Download: https://generatepress.com
   - Status: FREE version sufficient for core functionality

2. **GP Premium** (Optional but Recommended)
   - Version: 2.5+ (if using premium modules)
   - License Key: `de485e6af6e7e30eb60dbe638d50e55f`
   - Modules Recommended:
     - ✅ Backgrounds
     - ✅ Elements (Critical!)
     - ✅ Typography
     - ✅ Colors
     - ✅ Spacing
   - Account: https://generatepress.com/account

3. **Advanced Custom Fields Pro**
   - Version: 6.0 or higher
   - Required for: Solutions and Case Studies custom fields
   - Must activate before child theme activation

4. **GenerateBlocks** (Optional)
   - For block-based page building
   - Works with GP Premium Elements module

### PHP Version

- **Minimum:** PHP 8.0
- **Recommended:** PHP 8.1 or higher

### WordPress Version

- **Minimum:** WordPress 6.0
- **Recommended:** WordPress 6.4 or higher

---

## Installation

### Step 1: Install Parent Theme (GeneratePress)

1. Navigate to **Appearance > Themes > Add New**
2. Search for "GeneratePress"
3. Click **Install** on "GeneratePress"
4. Do NOT activate yet (we'll activate the child theme)

### Step 2: Install Child Theme

**Option A: Via WordPress Admin (Recommended)**

1. Download the `aitsc-gp-child` folder
2. Create a ZIP file of the folder
3. Navigate to **Appearance > Themes > Add New > Upload Theme**
4. Choose the ZIP file and click **Install Now**
5. Click **Activate**

**Option B: Via FTP/SFTP**

1. Upload the `aitsc-gp-child` folder to: `/wp-content/themes/`
2. Navigate to **Appearance > Themes** in WordPress admin
3. Find "AITSC GeneratePress Child" and click **Activate**

### Step 3: Install Required Plugins

1. Navigate to **Plugins > Add New**
2. Search for and install:
   - Advanced Custom Fields Pro (upload from plugin file)
   - GP Premium (upload from plugin file)
3. Activate both plugins

### Step 4: Activate GP Premium License (If Using)

1. Navigate to **Appearance > GeneratePress > License**
2. Enter license key: `de485e6af6e7e30eb60dbe638d50e55f`
3. Click **Activate License**
4. Verify "Lifetime" license shows as active

### Step 5: Flush Permalinks

1. Navigate to **Settings > Permalinks**
2. Click **Save Changes** (without making any changes)
3. This registers the Custom Post Types properly

---

## File Structure

```
aitsc-gp-child/
├── style.css                          # Theme metadata + CSS variables + utility classes
├── functions.php                      # Theme setup + asset loading + module includes
├── README.md                          # This file
├── CHANGELOG.md                       # Version history
├── screenshot.png                     # Theme screenshot (for admin)
│
├── inc/                               # Core functionality
│   ├── custom-post-types.php          # CPT registration (Solutions, Case Studies)
│   ├── acf-fields.php                 # ACF field definitions (755 lines)
│   ├── components.php                 # Component shortcodes registration
│   ├── paper-stack.php                # Paper stack animation system
│   ├── contact-ajax.php               # AJAX contact form handler
│   └── template-tags.php              # Helper functions
│
├── components/                        # Reusable components
│   ├── hero/
│   │   ├── hero-universal.php         # Universal hero component
│   │   └── hero-solution-page.php     # Solution page hero
│   ├── card/
│   │   └── card-base.php              # Base card component
│   ├── cta/
│   │   └── cta-block.php              # Call-to-action block
│   ├── trust-bar/
│   │   └── trust-bar.php              # Trust bar component
│   └── paper-stack/
│       ├── paper-stack.php            # Paper stack component
│       └── paper-stack.css            # Paper stack styles
│
├── template-parts/                    # Template partials
│   ├── content-solutions.php          # Solution content display
│   ├── services-mobile-optimized.php  # Mobile-optimized services
│   └── stats-section.php              # Statistics section
│
├── assets/                            # Frontend assets
│   ├── css/
│   │   └── single-blog-style.css      # Blog post styles
│   ├── js/
│   │   ├── theme-core.js              # Core theme JS
│   │   ├── navigation.js              # Mobile navigation
│   │   ├── forms.js                   # Form validation
│   │   ├── scroll-animations.js       # Scroll effects
│   │   ├── particle-system.js         # Particle animations
│   │   └── paper-stack-fallback.js    # Fallback for paper stack
│   └── images/
│       ├── fleet-safe-pro/            # Fleet Safe Pro images
│       │   ├── hero/                  # Hero section images
│       │   ├── gallery/               # Product gallery (56 images)
│       │   └── diagrams/              # System diagrams
│       └── [other images]
│
├── single-solutions.php               # Single solution template
├── single-case-studies.php            # Single case study template
├── archive-solutions.php              # Solutions archive template
├── archive-case-studies.php           # Case studies archive template
├── page-contact.php                   # Contact page template
├── page-fleet-safe-pro.php            # Fleet Safe Pro page template
├── header.php                         # Custom header (from original theme)
├── footer.php                         # Custom footer (from original theme)
└── index.php                          # Fallback template
```

---

## Features

### 1. Custom Post Types

#### Solutions
- **Slug:** `solutions`
- **Features:** Title, Editor, Thumbnail, Excerpt
- **ACF Fields:**
  - Hero section (title, subtitle, background)
  - Overview (description, key benefits)
  - Features list
  - Pricing information
  - Related solutions

#### Case Studies
- **Slug:** `case-studies`
- **Features:** Title, Editor, Thumbnail, Excerpt
- **ACF Fields:**
  - Client information
  - Challenge description
  - Solution implemented
  - Results metrics
  - Testimonial quote

### 2. Components

Available as shortcodes or PHP functions:

- **`[aitsc_hero]`** - Universal hero section
- **`[aitsc_hero_solution]`** - Solution-specific hero
- **`[aitsc_card]`** - Feature card component
- **`[aitsc_cta]`** - Call-to-action block
- **`[aitsc_trust_bar]`** - Trust indicators bar
- **`[aitsc_paper_stack]`** - Animated paper stack effect

### 3. Paper Stack Animations

Interactive scroll effects that create a "paper stack" visual effect:
- GPU-accelerated CSS transforms
- Smooth scroll-triggered animations
- Mobile-optimized (degraded on low-end devices)
- Falls back gracefully without JavaScript

### 4. AJAX Contact Form

Secure contact form with:
- Multi-step validation
- Honeypot bot protection
- AJAX submission (no page reload)
- Sanitized inputs (XSS prevention)
- Nonce verification (CSRF protection)
- Custom error messages

### 5. Fleet Safe Pro Page

Complete product showcase page:
- Hero section with animations
- Feature highlights
- Image gallery (56 product images)
- System diagrams
- Technical specifications
- CTA sections

---

## Customization

### Theme Constants

Define these in `wp-config.php` to override defaults:

```php
// Child theme paths (auto-defined, but can override)
define('AITSC_GP_VERSION', '1.0.0');
define('AITSC_GP_THEME_DIR', get_stylesheet_directory());
define('AITSC_GP_THEME_URI', get_stylesheet_directory_uri());
```

### CSS Variables

All colors and spacing use CSS custom properties (variables). Override in child theme or Customizer:

```css
:root {
  --aitsc-primary: #005cb2;           /* Primary brand color */
  --aitsc-secondary: #475569;         /* Secondary text color */
  --aitsc-container-width: 1400px;    /* Max container width */
  --aitsc-radius-lg: 8px;             /* Border radius */
}
```

### Adding Custom Functions

Add custom code to `functions.php` or create a new file in `/inc/` and include it:

```php
// In functions.php
require_once AITSC_GP_THEME_DIR . '/inc/my-custom-file.php';
```

### Modifying Templates

To override GeneratePress templates:
1. Copy template from parent theme to child theme
2. Modify as needed
3. Child theme version takes precedence

---

## Shortcodes

### Hero Component

```php
// Universal hero
do_action('aitsc_hero_universal', array(
  'title' => 'Your Title',
  'subtitle' => 'Your Subtitle',
  'background' => 'image-url.jpg'
));

// Shortcode
[aitsc_hero title="Your Title" subtitle="Your Subtitle"]
```

### Card Component

```php
// Feature card
do_action('aitsc_card', array(
  'title' => 'Card Title',
  'content' => 'Card content...',
  'icon' => 'icon-name'
));

// Shortcode
[aitsc_card title="Card Title" content="Card content..."]
```

### CTA Block

```php
// Call-to-action
do_action('aitsc_cta', array(
  'title' => 'Get Started Today',
  'button_text' => 'Contact Us',
  'button_url' => '/contact'
));

// Shortcode
[aitsc_cta title="Get Started Today" button_url="/contact"]
```

### Trust Bar

```php
// Trust indicators
do_action('aitsc_trust_bar', array(
  'text' => 'Trusted by 500+ companies'
));

// Shortcode
[aitsc_trust_bar text="Trusted by 500+ companies"]
```

### Paper Stack

```php
// Animated paper stack
do_action('aitsc_paper_stack', array(
  'count' => 5,
  'color' => '#005cb2'
));

// Shortcode
[aitsc_paper_stack count="5" color="#005cb2"]
```

---

## Performance Optimization

### Built-in Optimizations

1. **Conditional Loading:** Scripts/styles only load on pages that need them
2. **Hardware Acceleration:** CSS transforms use GPU for smooth animations
3. **Lazy Loading:** Images load as they enter viewport
4. **Minified Assets:** Production-ready CSS and JS
5. **Debounced Events:** Scroll and resize handlers optimized

### Recommended Plugins

- **WP Rocket** or **W3 Total Cache** - Caching
- **ShortPixel** or **Smush** - Image optimization
- **Autoptimize** - CSS/JS minification (if not using WP Rocket)

---

## Troubleshooting

### White Screen After Activation

**Cause:** PHP fatal error
**Solution:**
1. Check `debug.log` in `/wp-content/`
2. Verify PHP version is 8.0+
3. Ensure all parent theme files exist
4. Disable all plugins, re-enable one by one

### Custom Post Types Not Appearing

**Cause:** Permalinks not flushed
**Solution:**
1. Go to **Settings > Permalinks**
2. Click **Save Changes**
3. Check that CPTs appear in admin sidebar

### ACF Fields Not Showing

**Cause:** ACF Pro not active or fields not loaded
**Solution:**
1. Verify ACF Pro plugin is active
2. Check `/inc/acf-fields.php` is being loaded
3. Look for PHP errors in debug log

### Styling Issues

**Cause:** Parent theme not active or cache
**Solution:**
1. Verify GeneratePress is installed and active
2. Clear browser cache
3. Clear WordPress cache (if using caching plugin)
4. Check browser console for CSS loading errors

### Paper Stack Not Working

**Cause:** JavaScript not loading or device not supported
**Solution:**
1. Check browser console for JS errors
2. Verify `paper-stack-fallback.js` is enqueued
3. Test on different device (may be disabled on mobile)

---

## Security

### Built-in Security Features

1. **Input Sanitization:** All user inputs sanitized via WordPress functions
2. **Nonce Verification:** CSRF protection on all forms
3. **Output Escaping:** XSS prevention on all output
4. **Capability Checks:** User permissions verified before actions
5. **Honeypot Fields:** Bot protection on contact form

### Best Practices

- Keep WordPress, plugins, and theme updated
- Use strong admin passwords
- Enable SSL/HTTPS
- Regular backups (use UpdraftPlus or similar)
- Security plugin (Wordfence or iThemes Security)

---

## Accessibility

### WCAG 2.1 AA Compliance

- Semantic HTML5 elements
- ARIA labels on dynamic content
- Keyboard navigation support
- Color contrast ratios met (WCAG AA)
- Focus indicators visible
- Alt text on all images
- Skip links for navigation

### Screen Reader Support

- Proper heading hierarchy (h1-h6)
- ARIA landmarks defined
- Form labels associated
- Error messages announced

---

## Browser Support

### Desktop

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

### Mobile

- iOS Safari 14+
- Chrome Mobile 90+
- Samsung Internet 14+
- Firefox Mobile 88+

### Graceful Degradation

Older browsers receive basic styling without animations. Core functionality remains intact.

---

## Migration from aitsc-pro-theme

This child theme preserves 100% of functionality from the original theme:

### What's Preserved

✅ Custom Post Types (Solutions, Case Studies)
✅ ACF Pro Fields (755 lines)
✅ Component Shortcodes (6 components)
✅ Paper Stack Animations
✅ AJAX Contact Form
✅ Fleet Safe Pro Page
✅ Header & Footer Design
✅ All JavaScript Functionality
✅ CSS Variables & Design System

### What's Changed

🔄 Parent theme: Custom → GeneratePress (lighter, faster)
🔄 Template structure: Simplified (leverages GP templates)
🔄 CSS: Utility classes added for GP compatibility
🔄 Asset loading: Conditional loading for better performance

### Migration Path

If migrating from `aitsc-pro-theme`:

1. Backup current site (files + database)
2. Install GeneratePress parent theme
3. Upload and activate `aitsc-gp-child`
4. Flush permalinks
5. Test all CPTs and shortcodes
6. Check frontend display
7. Remove old theme (only after confirming everything works)

---

## Support

### Documentation

- **Setup Guide:** `/SETUP-GUIDE.md` (project root)
- **Migration Guide:** `/plans/260104-universal-paper-stack-scroll/migration-guide-complete.md`
- **Changelog:** `CHANGELOG.md` (in theme folder)

### GeneratePress Resources

- **Documentation:** https://docs.generatepress.com
- **Support Forums:** https://generatepress.com/forums
- **Premium Support:** Available with GP Premium license

### ACF Resources

- **Documentation:** https://www.advancedcustomfields.com/resources/
- **Support:** https://www.advancedcustomfields.com/support/

---

## Credits

### Core Framework

- **GeneratePress** by Tom Usborne
- **GenerateBlocks** by Tom Usborne
- **ACF Pro** by Elliot Condon

### Original Theme

- **aitsc-pro-theme** by Antigravity
- Migrated to GeneratePress child theme in 2026

### Special Features

- **Paper Stack Animations:** Custom GPU-accelerated scroll effects
- **AJAX Contact Form:** Secure, validated form handling
- **Fleet Safe Pro:** Complete product showcase implementation

---

## License

This theme is licensed under the GNU General Public License v2 or later.

```
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
```

---

## Changelog

See `CHANGELOG.md` for version history.

---

## Version History

### 1.0.0 (January 6, 2026)
- Initial release as GeneratePress child theme
- Migrated from aitsc-pro-theme v2.0.1
- All core functionality preserved
- Performance improvements via GeneratePress framework
- PHP 8.0+ compatibility
- WordPress 6.0+ compatibility

---

**End of README.md**

For questions or support, refer to the documentation files or contact the development team.
