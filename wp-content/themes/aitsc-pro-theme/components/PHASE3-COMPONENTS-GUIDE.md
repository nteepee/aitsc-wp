# Phase 3 Harrison.ai Components - Quick Reference

## Overview
Three new components inspired by Harrison.ai design patterns for the AITSC Pro Theme white theme migration.

## Component 1: Trust Bar

### Purpose
Display centered trust statements with cyan branding on white background.

### Usage in Templates
```php
aitsc_render_trust_bar([
    'text' => 'Trusted by leading transport safety organizations across Australia',
    'tag' => 'p',
    'class' => 'custom-class'
]);
```

### Shortcode Usage
```
[aitsc_trust_bar]
[aitsc_trust_bar text="Custom trust statement"]
[aitsc_trust_bar text="Certified experts" tag="h2"]
```

### Design Specs
- **Background**: White (`--aitsc-bg-primary`)
- **Text Color**: Cyan (`--aitsc-primary: #005cb2`)
- **Font Size**: 1.125rem (mobile) - 1.875rem (desktop)
- **Borders**: Top and bottom 1px solid
- **Padding**: Responsive (2rem - 3rem vertical)

### CSS Classes
- `.aitsc-trust-bar` - Outer section
- `.aitsc-trust-bar__container` - Inner wrapper (max-width)
- `.aitsc-trust-bar__text` - Text element

---

## Component 2: Logo Carousel

### Purpose
Horizontal auto-scrolling carousel with grayscale partner logos.

### Usage in Templates
```php
aitsc_render_logo_carousel([
    'title' => 'Our Partners',
    'speed' => 30, // seconds
    'logos' => [
        ['name' => 'Company A', 'image' => 'url-to-logo.png', 'url' => 'https://example.com'],
        ['name' => 'Company B', 'image' => 'url-to-logo.png', 'url' => 'https://example.com'],
        // Add more logos...
    ]
]);
```

### Shortcode Usage
```
[aitsc_logo_carousel]
[aitsc_logo_carousel title="Trusted Partners" speed="40"]
```

### With JSON Data
```
[aitsc_logo_carousel logos='[{"name":"Partner 1","image":"url","url":"link"}]']
```

### Design Specs
- **Background**: Light gray (`--aitsc-bg-secondary: #F8FAFC`)
- **Logo Effect**: Grayscale 100%, opacity 0.6
- **Hover Effect**: Full color, opacity 1
- **Animation**: CSS-only, linear infinite scroll
- **Pause**: On hover
- **Logo Size**: 140px - 200px width (responsive)

### Features
- ✅ CSS-only animation (no JavaScript)
- ✅ Seamless infinite loop
- ✅ Pause on hover
- ✅ Respects reduced motion (shows static grid)
- ✅ Edge fade gradient
- ✅ Text placeholders when no images

### CSS Classes
- `.aitsc-logo-carousel` - Outer section
- `.aitsc-logo-carousel__wrapper` - Masked container
- `.aitsc-logo-carousel__track` - Animated track
- `.aitsc-logo-carousel__item` - Individual logo container
- `.aitsc-logo-carousel__logo` - Logo image
- `.aitsc-logo-carousel__placeholder` - Text placeholder

---

## Component 3: Image Composition

### Purpose
Create dynamic overlapping image layouts with 3-4 images, absolute positioning, rounded corners.

### Usage in Templates
```php
aitsc_render_image_composition([
    'layout' => 'overlap', // overlap|grid|stack
    'height' => '500px',
    'images' => [
        ['url' => 'image1.jpg', 'alt' => 'Description', 'position' => 'primary'],
        ['url' => 'image2.jpg', 'alt' => 'Description', 'position' => 'secondary'],
        ['url' => 'image3.jpg', 'alt' => 'Description', 'position' => 'tertiary'],
        ['url' => 'image4.jpg', 'alt' => 'Description', 'position' => 'accent'],
    ]
]);
```

### Shortcode Usage
```
[aitsc_image_composition]
[aitsc_image_composition layout="grid" height="600px"]
```

### Layout Options

**Overlap Layout (default)**
- 4 images positioned absolutely with z-index stacking
- Primary: Top-left, largest (45% width, z-index 4)
- Secondary: Top-right (40% width, z-index 3)
- Tertiary: Bottom-left (35% width, z-index 2)
- Accent: Bottom-right, smallest (30% width, z-index 1)

**Grid Layout**
- 2x2 grid layout
- Equal size images
- Clean gap spacing

**Stack Layout**
- Vertical stacking
- Full-width images
- Good for mobile-first design

### Design Specs
- **Border Radius**: 12px - 16px (responsive)
- **Shadows**: `--aitsc-shadow-lg`
- **Hover Effect**: TranslateY(-8px) + scale(1.02)
- **Mobile**: Auto-stack below 768px
- **Tablet**: Simplified 3-image overlap
- **Desktop**: Full 4-image composition

### Image Positions
- `primary` - Main focal image
- `secondary` - Supporting image
- `tertiary` - Accent image
- `accent` - Additional detail
- `position-1` to `position-4` - Generic fallback positions

### CSS Classes
- `.aitsc-image-composition` - Outer section
- `.aitsc-image-composition--overlap` - Overlap layout modifier
- `.aitsc-image-composition--grid` - Grid layout modifier
- `.aitsc-image-composition--stack` - Stack layout modifier
- `.aitsc-image-composition__container` - Inner container
- `.aitsc-image-composition__item` - Image wrapper
- `.aitsc-image-composition__item--primary` - Position modifier
- `.aitsc-image-composition__image` - Image element
- `.aitsc-image-composition__placeholder` - Placeholder element

---

## Responsive Behavior

### Breakpoints
1. **Mobile**: 320px - 767px
   - Trust bar: Smaller font (1.125rem)
   - Logo carousel: Smaller logos (140px)
   - Image composition: Vertical stack

2. **Tablet**: 768px - 1023px
   - Trust bar: Medium font (1.25rem)
   - Logo carousel: Medium logos (160px)
   - Image composition: 3-image overlap

3. **Desktop**: 1024px - 1439px
   - Trust bar: Large font (1.5rem)
   - Logo carousel: Large logos (180px)
   - Image composition: Full 4-image overlap

4. **Large Desktop**: 1440px+
   - Trust bar: XL font (1.875rem)
   - Logo carousel: XL logos (200px)
   - Image composition: Enhanced spacing

---

## Accessibility Features

### All Components Include
- ✅ Semantic HTML5 elements
- ✅ ARIA labels and roles
- ✅ `prefers-reduced-motion` support
- ✅ `prefers-contrast: high` support
- ✅ Keyboard navigation
- ✅ Focus-visible styles
- ✅ Screen reader friendly

### Specific Accessibility
**Trust Bar**
- Role: region
- ARIA label: "Trust statement"

**Logo Carousel**
- Role: region
- ARIA label: "Partner logos"
- ARIA-live: off (non-disruptive)
- Links with proper labels
- Static grid for reduced motion

**Image Composition**
- Role: region
- ARIA label: "Image composition"
- Alt text for all images
- Focus indicators

---

## CSS Variables Used

All components use theme variables from `style.css`:

### Colors
- `--aitsc-primary` - Cyan brand color
- `--aitsc-bg-primary` - White background
- `--aitsc-bg-secondary` - Light gray
- `--aitsc-bg-tertiary` - Medium gray
- `--aitsc-text-primary` - Dark text
- `--aitsc-text-secondary` - Medium text
- `--aitsc-text-muted` - Light text
- `--aitsc-border` - Border color
- `--aitsc-border-focus` - Focus outline

### Spacing
- `--space-4` to `--space-12` - Spacing scale

### Typography
- `--font-size-sm` to `--font-size-3xl` - Font sizes
- `--line-height-*` - Line heights
- `--letter-spacing-*` - Letter spacing
- `--aitsc-font-main` - Primary font
- `--aitsc-font-heading` - Heading font

### Effects
- `--aitsc-shadow-sm` to `--aitsc-shadow-xl` - Shadows
- `--aitsc-transition-fast` - Fast transitions
- `--aitsc-transition-normal` - Normal transitions
- `--aitsc-radius-sm` - Small border radius

---

## File Locations

```
/wp-content/themes/aitsc-pro-theme/
├── components/
│   ├── trust-bar/
│   │   ├── trust-bar.php
│   │   └── trust-bar-styles.css
│   ├── logo-carousel/
│   │   ├── logo-carousel.php
│   │   └── logo-carousel-styles.css
│   └── image-composition/
│       ├── image-composition.php
│       └── image-composition-styles.css
└── inc/
    └── components.php (registration)
```

---

## Integration Checklist

When adding new component instances:

1. **Trust Bar**
   - [ ] Choose appropriate text content
   - [ ] Select semantic HTML tag (p, h2, span)
   - [ ] Position in page layout (full-width sections work best)

2. **Logo Carousel**
   - [ ] Gather partner logos (PNG, SVG preferred)
   - [ ] Optimize images (web-optimized, similar heights)
   - [ ] Set animation speed (20-40s recommended)
   - [ ] Add partner URLs (optional)
   - [ ] Include section title (optional)

3. **Image Composition**
   - [ ] Select 3-4 high-quality images
   - [ ] Choose layout (overlap recommended for hero sections)
   - [ ] Set container height based on content
   - [ ] Write descriptive alt text
   - [ ] Verify images work at all breakpoints

---

## Performance Notes

- Logo carousel uses CSS animations (no JavaScript overhead)
- Image composition uses `loading="lazy"` for images
- All components respect reduced motion preferences
- Minimal DOM footprint
- Efficient CSS with no redundant properties

---

## Browser Support

✅ Chrome/Edge (latest)
✅ Firefox (latest)
✅ Safari (latest)
✅ iOS Safari (iOS 12+)
✅ Android Chrome (latest)

---

## Future Enhancements

Potential improvements for future phases:

1. **Trust Bar**
   - Add icon support
   - Animated counter integration
   - Multi-line text variants

2. **Logo Carousel**
   - Touch/swipe support for mobile
   - Pause controls
   - Logo count indicator

3. **Image Composition**
   - Lightbox integration
   - Lazy loading optimization
   - More layout variants (masonry, diagonal)

---

## Support

For implementation questions or issues:
1. Review this guide
2. Check `/plans/reports/fullstack-dev-251230-phase-3-harrison-components.md`
3. Inspect component CSS files for customization options
4. Test components across all breakpoints
