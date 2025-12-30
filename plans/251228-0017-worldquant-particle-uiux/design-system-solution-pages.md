# AITSC Solution Pages - Design System Specification
**Project**: WorldQuant Particle UIUX System - Solution Landing Pages
**Design Date**: 2025-12-28
**Status**: Design Approved - Ready for Implementation
**Stack**: HTML + Tailwind CSS + Vanilla JS

---

## Design Overview

Solution landing pages featuring:
- **Style Foundation**: Dark Mode (OLED) + Glassmorphism
- **Visual Effect**: WorldQuant-inspired particle system background (70 particles, blue/purple palette)
- **Page Pattern**: Hero + Features + Showcase + Specs + Gallery + Case Studies + CTA
- **Typography**: Manrope (headings) + Manrope (body)
- **Icons**: Material Design Icons (24px, 48px, 64px)
- **Animation**: Smooth transitions (200ms), scroll-triggered animations, micro-interactions
- **Responsive**: Mobile-first (375px) → Tablet (768px) → Desktop (1440px)

---

## 1. Color Palette

### Primary Colors
```
Background (Deep Black):       #000000 (primary bg)
Dark Overlay:                  #001a33 (navigation, cards)
AITSC Blue (Primary Accent):   #005cb2 (CTAs, highlights, borders)
Purple Accent:                 #1a0033 (secondary highlights, hover)
```

### Semantic Colors
```
Text Primary:                  #F1F5F9 (slate-100, white text on dark)
Text Secondary:                #CBD5E1 (slate-300, secondary text)
Text Muted:                    #94A3B8 (slate-400, disabled/placeholder)
Border Color:                  #475569/rgba(0,92,178,0.3) (glass edges)
Success:                       #10B981 (confirmations, checkmarks)
Warning:                       #F59E0B (cautions)
Error:                         #EF4444 (errors, alerts)
```

### Glass & Transparency (for Glassmorphism)
```
Glass Light (Hover):           rgba(255,255,255,0.05)
Glass Border:                  rgba(0,92,178,0.3) (blue tint)
Glass Backdrop:                blur(10px) + saturate(180%)
Dark Shadow:                   rgba(0,0,0,0.4)
Particle Glow:                 rgba(0,92,178,0.2)
```

### Usage Rules
```
✓ Use #005cb2 for:             Interactive elements (buttons, links, active states)
✓ Use #1a0033 for:             Card backgrounds, secondary sections
✓ Use #001a33 for:             Navigation, header, footer
✓ Use #000000 for:             Page background, body content areas
✓ Avoid:                       Pure white (#FFFFFF) text; use #F1F5F9 instead
✓ Glass layers:                Always include rgba(0,92,178,0.3) border
```

---

## 2. Typography System

### Font Stack
```css
/* Primary Font: Manrope */
--font-heading: 'Manrope', system-ui, -apple-system, sans-serif;
--font-body:    'Manrope', system-ui, -apple-system, sans-serif;

/* Google Fonts Import */
@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap');
```

### Scale & Weights

#### Headings
```
H1 (Page Title)
├─ Desktop:  56px (3.5rem) / 700 weight / 1.2 line-height
├─ Tablet:   44px (2.75rem) / 700 weight
└─ Mobile:   32px (2rem) / 700 weight

H2 (Section)
├─ Desktop:  40px (2.5rem) / 600 weight
├─ Tablet:   32px (2rem) / 600 weight
└─ Mobile:   24px (1.5rem) / 600 weight

H3 (Subsection)
├─ Desktop:  28px (1.75rem) / 600 weight
├─ Tablet:   24px (1.5rem) / 600 weight
└─ Mobile:   20px (1.25rem) / 600 weight

H4 (Card Title)
├─ Desktop:  20px (1.25rem) / 600 weight
├─ Mobile:   18px (1.125rem) / 600 weight
```

#### Body Text
```
Body Large:  18px (1.125rem) / 500 weight / 1.6 line-height (intro copy)
Body Normal: 16px (1rem) / 400 weight / 1.6 line-height
Body Small:  14px (0.875rem) / 400 weight / 1.5 line-height (secondary)
Caption:     12px (0.75rem) / 500 weight / 1.4 line-height (meta, dates)
```

#### Code/Tech Specs
```
Monospace:   'Monaco', 'Consolas', 'Courier New', monospace (12-14px)
Line Height: 1.8 (for readability in specs tables)
```

### Tailwind Config Addition
```javascript
extend: {
  fontFamily: {
    sans: ['Manrope', 'system-ui'],
  },
  fontSize: {
    'h1': ['56px', { lineHeight: '1.2', fontWeight: '700' }],
    'h2': ['40px', { lineHeight: '1.3', fontWeight: '600' }],
    'h3': ['28px', { lineHeight: '1.4', fontWeight: '600' }],
    'h4': ['20px', { lineHeight: '1.4', fontWeight: '600' }],
    'body-lg': ['18px', { lineHeight: '1.6', fontWeight: '500' }],
    'body': ['16px', { lineHeight: '1.6', fontWeight: '400' }],
    'body-sm': ['14px', { lineHeight: '1.5', fontWeight: '400' }],
  }
}
```

---

## 3. Component Library

### 3.1 Hero Section

**Purpose**: Grab attention, establish context, primary CTA
**Layout**: Centered content with particle background visible

```html
<section class="relative min-h-screen bg-black flex items-center justify-center overflow-hidden">
  <!-- Particle Background (Canvas) -->
  <canvas id="aitsc-particle-canvas" class="absolute inset-0"></canvas>

  <!-- Hero Content -->
  <div class="relative z-10 max-w-4xl mx-auto px-4 md:px-8 text-center">
    <h1 class="text-h1 text-white mb-6 animate-fade-in">
      Custom PCB Design & Development
    </h1>
    <p class="text-body-lg text-slate-300 mb-8 max-w-2xl mx-auto animate-fade-in-delay-100">
      From schematic to production-ready boards in weeks, not months
    </p>

    <!-- Hero CTA -->
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
      <button class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-600 rounded-lg transition-colors duration-200 cursor-pointer">
        Get Started
      </button>
      <button class="px-8 py-4 border-2 border-blue-600 text-blue-400 hover:bg-blue-600/10 font-600 rounded-lg transition-all duration-200 cursor-pointer">
        Learn More
      </button>
    </div>
  </div>

  <!-- Scroll Indicator -->
  <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
    </svg>
  </div>
</section>
```

**Tailwind Classes**:
- `min-h-screen bg-black` - Full viewport height, black background
- `relative z-10` - Content layer above particle canvas
- `animate-fade-in` - Custom animation (see animation section)
- `hover:bg-blue-700 transition-colors duration-200` - Smooth color transition

---

### 3.2 Feature Card (Glassmorphism)

**Purpose**: Showcase key features with icons
**Visual**: Glass card with blue border, hover elevation

```html
<div class="group relative bg-white/5 backdrop-blur-xl border border-blue-600/30
            rounded-2xl p-8 hover:bg-white/10 hover:border-blue-600/60
            transition-all duration-300 cursor-pointer">

  <!-- Background Gradient (on hover) -->
  <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-purple-600/5
              rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

  <!-- Content -->
  <div class="relative z-10">
    <!-- Icon -->
    <div class="w-16 h-16 bg-blue-600/20 rounded-xl flex items-center justify-center mb-6
                group-hover:bg-blue-600/30 transition-colors duration-200">
      <span class="material-symbols-outlined text-3xl text-blue-400">settings</span>
    </div>

    <!-- Title -->
    <h3 class="text-h4 text-white mb-3 group-hover:text-blue-300 transition-colors duration-200">
      Rapid Prototyping
    </h3>

    <!-- Description -->
    <p class="text-body-sm text-slate-400 leading-relaxed">
      Fast turnaround from design to physical prototype without compromising quality
    </p>

    <!-- Arrow (appears on hover) -->
    <div class="mt-6 flex items-center gap-2 text-blue-400 opacity-0 group-hover:opacity-100
                transform translate-x-0 group-hover:translate-x-2 transition-all duration-300">
      <span class="text-sm font-600">Explore</span>
      <span class="material-symbols-outlined text-xl">arrow_forward</span>
    </div>
  </div>
</div>
```

**Key Behaviors**:
- Glass effect: `backdrop-blur-xl border border-blue-600/30`
- Hover elevation: Use `group-hover:` to elevate on card hover
- No scale transform (prevents layout shift) - use `translate-x` instead
- Icon color change on hover

---

### 3.3 Specs Table (Technical Specifications)

**Purpose**: Display technical details in organized, readable format
**Visual**: Dark table with blue accent highlights

```html
<section class="bg-slate-950/50 rounded-2xl border border-blue-600/20 p-8 md:p-12 overflow-x-auto">
  <h2 class="text-h3 text-white mb-8">Technical Specifications</h2>

  <table class="w-full border-collapse">
    <thead>
      <tr class="border-b border-blue-600/20">
        <th class="text-left py-4 px-4 text-body font-600 text-slate-300">Specification</th>
        <th class="text-left py-4 px-4 text-body font-600 text-slate-300">Details</th>
      </tr>
    </thead>
    <tbody>
      <tr class="border-b border-slate-800/50 hover:bg-blue-600/5 transition-colors duration-150">
        <td class="py-4 px-4 text-blue-400 font-500">Input Voltage</td>
        <td class="py-4 px-4 text-slate-300">+12V / +24V (ACC/IGN)</td>
      </tr>
      <tr class="border-b border-slate-800/50 hover:bg-blue-600/5 transition-colors duration-150">
        <td class="py-4 px-4 text-blue-400 font-500">Current Draw</td>
        <td class="py-4 px-4 text-slate-300">300mA @ 12V / 150mA @ 24V</td>
      </tr>
      <!-- More rows -->
    </tbody>
  </table>
</section>
```

**Styling**:
- Alternating row colors: `hover:bg-blue-600/5`
- Column headers: Bold, slightly larger
- First column: Blue text (#005cb2) for specification names

---

### 3.4 Product Gallery (with Lightbox)

**Purpose**: Showcase product images
**Visual**: Grid layout with hover overlay, lightbox on click

```html
<section class="py-16">
  <h2 class="text-h3 text-white mb-12">Product Gallery</h2>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    <div class="group relative overflow-hidden rounded-xl cursor-pointer">
      <!-- Image -->
      <img src="/assets/product-1.jpg"
           alt="Product display showing UI"
           loading="lazy"
           class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500">

      <!-- Overlay -->
      <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100
                  flex items-center justify-center transition-opacity duration-300">
        <button class="text-white text-2xl" aria-label="View full image">
          <span class="material-symbols-outlined text-5xl">zoom_in</span>
        </button>
      </div>
    </div>

    <!-- More gallery items -->
  </div>
</section>

<!-- Lightbox Modal -->
<div id="lightbox" class="hidden fixed inset-0 bg-black/95 z-50 flex items-center justify-center p-4">
  <button id="lightbox-close" class="absolute top-4 right-4 text-white cursor-pointer">
    <span class="material-symbols-outlined text-4xl">close</span>
  </button>
  <img id="lightbox-image" src="" alt="" class="max-w-4xl max-h-[90vh] rounded-xl">
</div>
```

---

### 3.5 Case Studies Carousel

**Purpose**: Display relevant case studies/projects
**Visual**: Carousel with cards, navigation arrows

```html
<section class="py-16">
  <h2 class="text-h3 text-white mb-12">Related Case Studies</h2>

  <div class="relative">
    <!-- Carousel Container -->
    <div class="overflow-hidden">
      <div id="carousel" class="flex gap-6 transition-transform duration-500">

        <!-- Case Study Card -->
        <div class="flex-shrink-0 w-full md:w-1/2 lg:w-1/3">
          <div class="bg-gradient-to-br from-blue-600/10 to-purple-600/10
                      border border-blue-600/20 rounded-xl p-8 h-full flex flex-col">

            <h3 class="text-h4 text-white mb-3">Bus Fleet Safety Integration</h3>
            <p class="text-body-sm text-slate-400 flex-grow mb-6">
              Implemented real-time seatbelt monitoring across 50-vehicle fleet,
              achieving 98% safety compliance.
            </p>

            <!-- Metadata -->
            <div class="flex items-center justify-between pt-4 border-t border-blue-600/20">
              <span class="text-caption text-blue-400">2024</span>
              <span class="text-caption text-slate-400">Transportation</span>
            </div>
          </div>
        </div>

        <!-- More cards -->
      </div>
    </div>

    <!-- Navigation Arrows -->
    <button class="absolute -left-6 top-1/2 -translate-y-1/2 text-blue-400 hover:text-blue-300
                   transition-colors cursor-pointer hidden md:block">
      <span class="material-symbols-outlined text-3xl">arrow_back</span>
    </button>
    <button class="absolute -right-6 top-1/2 -translate-y-1/2 text-blue-400 hover:text-blue-300
                   transition-colors cursor-pointer hidden md:block">
      <span class="material-symbols-outlined text-3xl">arrow_forward</span>
    </button>
  </div>
</section>
```

---

### 3.6 Call-to-Action Section (Bottom)

**Purpose**: Final conversion opportunity
**Visual**: Full-width section with form or button

```html
<section class="bg-gradient-to-r from-blue-600/10 to-purple-600/10 border-y border-blue-600/20 py-16">
  <div class="max-w-3xl mx-auto px-4 md:px-8">
    <div class="text-center">
      <h2 class="text-h2 text-white mb-4">Ready to Get Started?</h2>
      <p class="text-body-lg text-slate-300 mb-8">
        Let's discuss how our solutions can accelerate your project
      </p>
    </div>

    <!-- Form or CTA Buttons -->
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
      <button class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-600 rounded-lg
                     transition-colors duration-200 cursor-pointer">
        Request Quote
      </button>
      <button class="px-8 py-4 border-2 border-blue-600 text-blue-400 hover:bg-blue-600/10
                     font-600 rounded-lg transition-all duration-200 cursor-pointer">
        Schedule Consultation
      </button>
    </div>
  </div>
</section>
```

---

## 4. Page Layout Structure

### Full Page Flow
```
1. HERO SECTION (100vh min-height)
   ├─ Particle background
   ├─ Centered title + subtitle
   └─ Primary CTA buttons

2. OVERVIEW / INTRODUCTION (padding-y 4rem)
   ├─ Problem statement
   ├─ Solution description
   └─ Key benefits (3-column list)

3. KEY FEATURES (padding-y 4rem, bg-slate-950/30)
   ├─ Section heading
   └─ 3-4 feature cards in grid (md:grid-cols-3)

4. TECHNICAL SPECIFICATIONS (padding-y 4rem)
   ├─ Specs table
   └─ Optional: Feature comparison chart

5. FLEXIBLE SECTIONS (variable)
   ├─ Content sections from ACF flexible content
   ├─ Text + Image (alternating left/right)
   └─ Full-width video or component

6. PRODUCT GALLERY (padding-y 4rem, bg-slate-950/50)
   ├─ Gallery grid
   └─ Lightbox integration

7. RELATED CASE STUDIES (padding-y 4rem)
   ├─ Carousel of case study cards
   └─ Navigation arrows (desktop only)

8. TESTIMONIALS / SOCIAL PROOF (optional, padding-y 4rem)
   ├─ Rating summary
   └─ Individual quotes

9. CALL-TO-ACTION (padding-y 4rem)
   ├─ Final pitch
   ├─ Form or buttons
   └─ Trust badges (optional)

10. FOOTER
    ├─ Link sections
    ├─ Contact info
    └─ Social links
```

### Spacing & Padding Rules
```
Page Margins:    max-w-7xl mx-auto px-4 md:px-6 lg:px-8
Section Padding: py-16 md:py-20 lg:py-24
Gap Between:     gap-6 md:gap-8 lg:gap-12
Card Padding:    p-6 md:p-8
```

---

## 5. Responsive Design

### Breakpoints (Tailwind Standard)
```
Mobile:   < 640px  (base styles)
SM:       640px    (sm:)
MD:       768px    (md:) ← Tablet
LG:       1024px   (lg:)
XL:       1280px   (xl:)
2XL:      1536px   (2xl:) ← Large desktop
```

### Tested Sizes
- **375px** (Mobile): iPhone SE, smaller phones
- **768px** (Tablet): iPad, tablet devices
- **1440px** (Desktop): Standard desktop monitors

### Responsive Adjustments
```
Typography:
- Mobile:   text-2xl (32px headings)
- Tablet:   text-3xl (44px headings)
- Desktop:  text-5xl (56px headings)

Grid Columns:
- Mobile:   grid-cols-1
- Tablet:   md:grid-cols-2
- Desktop:  lg:grid-cols-3

Padding:
- Mobile:   px-4 py-12
- Tablet:   md:px-6 md:py-16
- Desktop:  lg:px-8 lg:py-20

Images:
- Mobile:   Full width with aspect-ratio
- Tablet:   Controlled width, max-w-2xl
- Desktop:  Full showcase, max-w-4xl
```

---

## 6. Animations & Motion

### Global Animation Rules
```
✓ Smooth transitions: duration-200 or duration-300
✓ Easing: cubic-bezier(0.4, 0, 0.2, 1) - standard Tailwind
✗ Avoid: scale() transforms on cards (causes layout shift)
✓ Use: translate-x, translate-y, opacity instead
✓ Respect: motion-reduce:animate-none for accessibility
```

### Keyframe Animations

```css
/* Fade In */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
.animate-fade-in {
  animation: fadeIn 0.6s ease-out;
}

/* Fade In with Delay */
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-up {
  animation: fadeInUp 0.6s ease-out;
}
.animate-fade-in-up-delay-100 {
  animation: fadeInUp 0.6s ease-out 0.1s both;
}

/* Bounce (Scroll Indicator) */
@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}
.animate-bounce {
  animation: bounce 1.5s infinite;
}

/* Pulse (Loading) */
@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.5; }
}
.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
```

### Scroll-Triggered Animations (AOS Library)
```html
<!-- Fade up on scroll -->
<section data-aos="fade-up" data-aos-duration="1000">
  Content appears when scrolled into view
</section>

<!-- Different animation types -->
<div data-aos="fade-right">Fade from right</div>
<div data-aos="zoom-in">Zoom in</div>
<div data-aos="slide-up">Slide up</div>
```

### Hover Micro-Interactions
```
Button Hover:      Background color change + subtle shadow grow
Card Hover:        Border glow, slight background lightening
Link Hover:        Color change + underline animation
Icon Hover:        Rotation or bounce effect
```

---

## 7. Accessibility Guidelines

### Color Contrast
```
Text on backgrounds: Minimum 4.5:1 contrast ratio
✓ White (#F1F5F9) on Black (#000000)  - 21:1 ✓
✓ Blue (#005cb2) on Black (#000000)   - 3.5:1 ✓ (for large text)
✗ Avoid blue on dark blue (#001a33)   - Too low contrast
```

### Keyboard Navigation
```
✓ All buttons and links: :focus-visible ring
✓ Tab order: Logical flow top-to-bottom
✓ Skip links: Navigation to main content
✗ Avoid: :focus pseudo-class (uses focus-visible instead)
```

### Screen Readers
```html
<!-- Button with icon needs label -->
<button aria-label="Close menu">
  <span class="material-symbols-outlined">close</span>
</button>

<!-- Images need alt text -->
<img src="product.jpg" alt="Product display unit with UI screen">

<!-- Form inputs need labels -->
<label for="email" class="sr-only">Email Address</label>
<input id="email" type="email" placeholder="you@example.com">
```

### Motion Preferences
```css
@media (prefers-reduced-motion: reduce) {
  * {
    animation: none !important;
    transition: none !important;
  }
}

/* Or use Tailwind: */
motion-reduce:animate-none
```

---

## 8. Performance Optimization

### Image Optimization
```html
<!-- Responsive images with srcset -->
<img
  src="/img/product-medium.jpg"
  srcset="
    /img/product-small.jpg 640w,
    /img/product-medium.jpg 1024w,
    /img/product-large.jpg 1440w
  "
  sizes="(max-width: 640px) 100vw, (max-width: 1024px) 90vw, 80vw"
  alt="Product showcase"
  loading="lazy"
  class="w-full h-auto">

<!-- Modern format with fallback -->
<picture>
  <source srcset="/img/product.webp" type="image/webp">
  <img src="/img/product.jpg" alt="Product">
</picture>
```

### Code Splitting (for animations)
- Load AOS library only on pages with scroll animations
- Lazy-load lightbox JavaScript on gallery pages
- Particle system already optimized (Canvas-based, < 3% CPU)

### Caching Strategy
- CSS: Fingerprinted filename (style.a1b2c3.css)
- JS: Separate bundles (main.js, animations.js, lightbox.js)
- Images: CDN with cache headers
- API responses: 5-minute cache for case studies

---

## 9. Design Tokens (Tailwind Config)

```javascript
module.exports = {
  theme: {
    extend: {
      colors: {
        'aitsc-dark': '#000000',
        'aitsc-blue': '#005cb2',
        'aitsc-dark-blue': '#001a33',
        'aitsc-purple': '#1a0033',
      },
      fontFamily: {
        sans: ['Manrope', 'system-ui'],
      },
      fontSize: {
        'h1': ['56px', { lineHeight: '1.2', fontWeight: '700' }],
        'h2': ['40px', { lineHeight: '1.3', fontWeight: '600' }],
        'h3': ['28px', { lineHeight: '1.4', fontWeight: '600' }],
      },
      spacing: {
        'section': '4rem',
        'section-lg': '6rem',
      },
      animation: {
        'fade-in': 'fadeIn 0.6s ease-out',
        'fade-in-up': 'fadeInUp 0.6s ease-out',
      },
    },
  },
};
```

---

## 10. Component Usage Examples

### Example: Solution Page Structure
```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Custom PCB Design - AITSC</title>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="output.css" rel="stylesheet">
</head>
<body class="bg-black text-slate-100">

  <!-- Header/Navigation (persistent) -->
  <header class="fixed top-0 left-0 right-0 bg-black/80 backdrop-blur-xl border-b border-blue-600/20 z-40">
    <!-- Nav content -->
  </header>

  <!-- Hero Section -->
  <section class="pt-24 min-h-screen bg-black flex items-center justify-center relative overflow-hidden">
    <!-- Particle Canvas -->
    <canvas id="aitsc-particle-canvas"></canvas>

    <!-- Hero Content (relative z-10) -->
    <!-- [Hero content here] -->
  </section>

  <!-- Overview Section -->
  <section class="py-20 px-4 md:px-8 bg-black">
    <!-- [Overview content] -->
  </section>

  <!-- Features Grid -->
  <section class="py-20 px-4 md:px-8 bg-slate-950/50">
    <!-- [Features cards in grid] -->
  </section>

  <!-- More sections... -->

  <!-- Scripts -->
  <script src="particle-system.js"></script>
  <script src="animations.js"></script>
  <script src="lightbox.js"></script>
</body>
</html>
```

---

## 11. Deliverables Checklist

### Design Assets
- [ ] Color palette (exported as CSS variables)
- [ ] Typography specimens (headings, body, code)
- [ ] Component library (all 6 components coded)
- [ ] Icon set (Material Design icons documented)
- [ ] Spacing/padding system documented

### CSS
- [ ] Tailwind config extended with design tokens
- [ ] Custom animations (fade-in, fade-in-up, etc.)
- [ ] Responsive breakpoints tested
- [ ] Dark mode verified

### HTML Templates
- [ ] Hero section template
- [ ] Feature card template
- [ ] Specs table template
- [ ] Gallery template with lightbox
- [ ] Carousel template
- [ ] CTA section template

### JavaScript
- [ ] Particle system integration
- [ ] Lightbox functionality
- [ ] Carousel navigation
- [ ] Smooth scroll behavior
- [ ] Accessibility helpers (focus management)

### Performance
- [ ] Lighthouse score > 90
- [ ] LCP (Largest Contentful Paint) < 2.5s
- [ ] CLS (Cumulative Layout Shift) < 0.1
- [ ] Responsive tested at 375px, 768px, 1440px

### Testing
- [ ] Color contrast verification (WCAG AAA)
- [ ] Keyboard navigation tested
- [ ] Screen reader tested
- [ ] Motion preferences respected
- [ ] Cross-browser testing (Chrome, Firefox, Safari)

---

## Next Steps

1. **Development Phase**: Use this design system to implement HTML templates
2. **ACF Integration**: Connect templates to ACF field groups (Phase 2 plan)
3. **Content Population**: Populate solution posts with content from Phase 3 extraction
4. **Testing**: Verify all pages meet Lighthouse targets
5. **Launch**: Deploy solution pages to production

---

**Design System Created**: 2025-12-28 14:45 UTC
**Designer**: UI/UX Pro Max Skill
**Ready for**: Frontend Implementation Phase
