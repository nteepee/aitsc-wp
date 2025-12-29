# AITSC Pro Theme - Design System Reference

**Date**: 2025-12-24
**Theme**: AITSC Pro Theme v2.0.1 (WorldQuant Implementation)
**Status**: Post-Consolidation (181 duplicate lines removed)
**File**: `style.css` (2619 lines)

---

## Overview

This is the authoritative design system reference for AITSC Pro Theme v2.0.1. All CSS classes documented here are **approved for use** with **no duplicates**. The design system follows **WorldQuant-inspired** aesthetics with modern gradients, professional typography, and consistent spacing.

### Design Principles

1. **WorldQuant Aesthetic**: Professional financial/tech-inspired design with blue gradients
2. **Modern Variables**: Uses `--font-*`, `--space-*` naming convention (not legacy `--aitsc-*`)
3. **No Duplicates**: Every class has exactly one definition
4. **Responsive First**: Mobile-first approach with fluid typography
5. **Accessibility**: WCAG AA compliant with proper focus states
6. **Dark Theme Support**: Includes `@media (prefers-color-scheme: dark)` for automatic dark mode

---

## Table of Contents

1. [CSS Variables (Design Tokens)](#1-css-variables)
2. [Typography](#2-typography)
3. [Layout & Grid](#3-layout--grid)
4. [Buttons](#4-buttons)
5. [Navigation](#5-navigation)
6. [Hero Section](#6-hero-section)
7. [Cards](#7-cards)
8. [Forms](#8-forms)
9. [Footer](#9-footer)
10. [Animations](#10-animations)
11. [Background & Gradient Utilities](#11-background--gradient-utilities)
12. [Utility Classes](#12-utility-classes)

---

## 1. CSS Variables

### Color Palette

```css
/* Primary Colors */
--primary-dark: #1a3a52;
--primary-darker: #0d1f2d;
--secondary-dark: #2c5282;
--tertiary-dark: #2a4a6a;

/* Text Colors */
--text-primary: #1a1a1a;
--text-secondary: #4a5568;
--text-muted: #718096;
--text-inverse: #ffffff;

/* Accent Colors */
--accent-primary: #2563eb;
--accent-hover: #1d4ed8;
--accent-light: #eff6ff;
--accent-success: #10b981;
--accent-warning: #f59e0b;
--accent-error: #ef4444;

/* Background Colors */
--background-primary: #ffffff;
--background-secondary: #f9fafb;
--background-dark: #1a1a1a;
--background-light: #f3f4f6;

/* Gradients */
--aitsc-gradient-primary: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
--aitsc-gradient-hero: linear-gradient(135deg, #1a3a52 0%, #2563eb 50%, #0891b2 100%);
--aitsc-gradient-card: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(249,250,251,0.95) 100%);
```

### Typography Scale (Fluid)

```css
/* Font Sizes - Fluid with clamp() */
--font-size-xs: clamp(0.75rem, 2vw, 0.875rem);    /* 12-14px */
--font-size-sm: clamp(0.875rem, 2.5vw, 1rem);   /* 14-16px */
--font-size-base: clamp(1rem, 3vw, 1.125rem);   /* 16-18px */
--font-size-lg: clamp(1.125rem, 3.5vw, 1.25rem); /* 18-20px */
--font-size-xl: clamp(1.25rem, 4vw, 1.5rem);    /* 20-24px */
--font-size-2xl: clamp(1.5rem, 5vw, 2rem);      /* 24-32px */
--font-size-3xl: clamp(2rem, 6vw, 2.5rem);      /* 32-40px */
--font-size-4xl: clamp(2.5rem, 7vw, 3rem);      /* 40-48px */
--font-size-5xl: clamp(3rem, 8vw, 4rem);        /* 48-64px */
```

### Spacing Scale

```css
--space-0: 0;
--space-1: 0.25rem;  /* 4px */
--space-2: 0.5rem;   /* 8px */
--space-3: 0.75rem;  /* 12px */
--space-4: 1rem;     /* 16px */
--space-5: 1.25rem;  /* 20px */
--space-6: 1.5rem;   /* 24px */
--space-8: 2rem;     /* 32px */
--space-10: 2.5rem;  /* 40px */
--space-12: 3rem;    /* 48px */
--space-16: 4rem;    /* 64px */
--space-20: 5rem;    /* 80px */
--space-24: 6rem;    /* 96px */
--space-32: 8rem;    /* 128px */
```

### Border Radius

```css
--aitsc-radius-sm: 0.25rem;  /* 4px */
--aitsc-radius-md: 0.5rem;   /* 8px */
--aitsc-radius-lg: 0.75rem;  /* 12px */
--aitsc-radius-xl: 1rem;     /* 16px */
--aitsc-radius-2xl: 1.5rem;  /* 24px */
```

**Note**: Border radius variables retain `--aitsc-radius-*` naming for compatibility with existing components.

### Font Weights

```css
--font-weight-light: 300;
--font-weight-normal: 400;
--font-weight-medium: 500;
--font-weight-semibold: 600;
--font-weight-bold: 700;
--font-weight-extrabold: 800;
```

### Line Heights

```css
--line-height-tight: 1.1;
--line-height-snug: 1.25;
--line-height-normal: 1.5;
--line-height-relaxed: 1.625;
--line-height-loose: 2;
```

### Letter Spacing

```css
--letter-spacing-tight: -0.025em;
--letter-spacing-normal: 0;
--letter-spacing-wide: 0.025em;
--letter-spacing-wider: 0.05em;
--letter-spacing-widest: 0.1em;
```

### Transitions

```css
--aitsc-transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
--aitsc-transition-normal: 300ms cubic-bezier(0.4, 0, 0.2, 1);
--aitsc-transition-slow: 500ms cubic-bezier(0.4, 0, 0.2, 1);
```

### Z-Index Scale

```css
--aitsc-z-dropdown: 1000;
--aitsc-z-sticky: 1020;
--aitsc-z-fixed: 1030;
--aitsc-z-modal-backdrop: 1040;
--aitsc-z-modal: 1050;
--aitsc-z-popover: 1060;
--aitsc-z-tooltip: 1070;
```

### Shadows

```css
--aitsc-shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
--aitsc-shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
--aitsc-shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
--aitsc-shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.1);
--aitsc-shadow-2xl: 0 25px 50px rgba(0, 0, 0, 0.15);
--aitsc-shadow-neon: 0 0 20px rgba(0, 102, 204, 0.6);
```

---

## 2. Typography

### Classes

| Class | Use Case | Font Size | Weight | Line Height |
|-------|----------|-----------|--------|-------------|
| `.text-hero` | Main hero titles | `var(--font-size-5xl)` | Bold (700) | Tight (1.1) |
| `.text-headline` | Section headings | `var(--font-size-4xl)` | Semibold (600) | Snug (1.25) |
| `.text-subheadline` | Subsection titles | `var(--font-size-3xl)` | Medium (500) | Snug (1.25) |
| `.text-display` | Large display text | `var(--font-size-5xl)` | Light (300) | Tight (1.1) |
| `.text-heading` | Page headings | `var(--font-size-4xl)` | Semibold (600) | Normal (1.2) |
| `.text-subheading` | Subheadings | `var(--font-size-2xl)` | Medium (500) | Relaxed (1.3) |
| `.text-body` | Body text | `var(--font-size-base)` | Normal | Relaxed (1.7) |
| `.text-small` | Small text | `var(--font-size-sm)` | Normal | Normal (1.5) |
| `.text-caption` | Captions/labels | `var(--font-size-sm)` | Normal | Normal (1.5) |

### HTML Headings

```css
h1 { font-size: var(--aitsc-font-6xl); font-weight: 700; }  /* Aliases to --font-size-5xl */
h2 { font-size: var(--aitsc-font-5xl); font-weight: 700; }  /* Aliases to --font-size-5xl */
h3 { font-size: var(--aitsc-font-4xl); font-weight: 700; }  /* Aliases to --font-size-4xl */
h4 { font-size: var(--aitsc-font-3xl); font-weight: 700; }  /* Aliases to --font-size-3xl */
h5 { font-size: var(--aitsc-font-2xl); font-weight: 700; }  /* Aliases to --font-size-2xl */
h6 { font-size: var(--aitsc-font-xl); font-weight: 700; }   /* Aliases to --font-size-xl */
```

### Usage Example

```html
<h1 class="text-hero">Main Page Title</h1>
<h2 class="text-headline">Section Title</h2>
<p class="text-body">Body paragraph text with proper line height.</p>
<span class="text-caption">Form label or caption</span>
```

---

## 3. Layout & Grid

### Container Classes

| Class | Max Width | Use Case |
|-------|-----------|----------|
| `.container` | 1200px | Standard page container |
| `.container-fluid` | 100% | Full-width container |
| `.container-sm` | 640px | Small content |
| `.container-md` | 768px | Medium content |
| `.container-lg` | 1024px | Large content |
| `.container-xl` | 1280px | Extra large content |

### Grid System

```css
.grid { display: grid; gap: var(--aitsc-space-lg); }
.grid-cols-1 { grid-template-columns: repeat(1, 1fr); }
.grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
.grid-cols-3 { grid-template-columns: repeat(3, 1fr); }
.grid-cols-4 { grid-template-columns: repeat(4, 1fr); }
.grid-cols-12 { grid-template-columns: repeat(12, 1fr); }

.col-span-1 { grid-column: span 1; }
.col-span-2 { grid-column: span 2; }
.col-span-3 { grid-column: span 3; }
.col-span-4 { grid-column: span 4; }
.col-span-6 { grid-column: span 6; }
.col-span-8 { grid-column: span 8; }
.col-span-12 { grid-column: span 12; }
```

### Flexbox Utilities

```css
.flex { display: flex; }
.flex-col { flex-direction: column; }
.flex-wrap { flex-wrap: wrap; }

.items-center { align-items: center; }
.items-start { align-items: flex-start; }
.items-end { align-items: flex-end; }

.justify-center { justify-content: center; }
.justify-between { justify-content: space-between; }
.justify-start { justify-content: flex-start; }
.justify-end { justify-content: flex-end; }
```

### Section Spacing

```css
.section { padding: var(--aitsc-space-4xl) 0; }      /* 96px vertical */
.section-sm { padding: var(--aitsc-space-3xl) 0; }   /* 64px vertical */
.section-lg { padding: var(--aitsc-space-5xl) 0; }   /* 128px vertical */
```

### Usage Example

```html
<div class="container">
  <div class="grid grid-cols-3">
    <div class="col-span-2">Main content</div>
    <div class="col-span-1">Sidebar</div>
  </div>
</div>

<section class="section-lg">
  <div class="container">
    <h2 class="text-headline">Section Title</h2>
  </div>
</section>
```

---

## 4. Buttons

### Base Button

```css
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: var(--space-3) var(--space-6);
  font-size: var(--font-size-base);
  font-weight: var(--font-weight-medium);
  border: 2px solid transparent;
  border-radius: 6px;
  transition: all 0.2s ease;
}
```

### Button Variants

| Class | Style | Hover |
|-------|-------|-------|
| `.btn-primary` | Blue gradient | Darker gradient + translateY(-2px) |
| `.btn-secondary` | Transparent + blue border | Light blue background |
| `.btn-outline` | Transparent + blue border | Solid blue fill |
| `.btn-ghost` | Transparent | Gray background |
| `.btn-neon` | Blue gradient + glow | Enhanced glow |

### Button Sizes

| Class | Padding | Font Size |
|-------|---------|-----------|
| `.btn-sm` | `var(--space-2) var(--space-4)` | `var(--font-size-sm)` |
| `.btn-small` | Same as `.btn-sm` - header-specific | Same |
| `.btn` (default) | `var(--space-3) var(--space-6)` | `var(--font-size-base)` |
| `.btn-lg` | `var(--space-4) var(--space-8)` | `var(--font-size-lg)` |
| `.btn-xl` | `var(--space-5) var(--space-10)` | `var(--font-size-xl)` |
| `.btn-large` | Same as `.btn-xl` - hero-specific | Same |

### Usage Example

```html
<a href="#" class="btn btn-primary">Primary Action</a>
<button class="btn btn-secondary">Secondary</button>
<button class="btn btn-outline">Outline Button</button>
<button class="btn btn-neon">Neon Effect</button>

<!-- Sizes -->
<button class="btn btn-primary btn-sm">Small</button>
<button class="btn btn-primary">Default</button>
<button class="btn btn-primary btn-lg">Large</button>
<button class="btn btn-primary btn-xl">Extra Large</button>
```

---

## 5. Navigation

### Header Classes

| Class | Purpose |
|-------|---------|
| `.site-header` | Fixed header container |
| `.site-header.header-scrolled` | Header state when scrolled |
| `.header-content` | Flex container for logo + nav |
| `.site-branding` | Logo container |
| `.custom-logo-link` | Logo image link |
| `.site-logo-text` | Text-based logo |

### Desktop Navigation

| Class | Purpose |
|-------|---------|
| `.desktop-navigation` | Desktop nav container (hidden < 768px) |
| `.primary-menu` | Main menu `ul` |
| `.primary-menu a` | Menu link styling |
| `.current-menu-item > a` | Active menu item |

### Mobile Navigation

| Class | Purpose |
|-------|---------|
| `.mobile-menu-toggle` | Hamburger button (shown < 768px) |
| `.hamburger-line` | Animated hamburger lines |
| `.mobile-navigation` | Mobile menu overlay |
| `.mobile-navigation.menu-open` | Open state |
| `.mobile-primary-menu` | Mobile menu `ul` |
| `.social-link` | Social media icon link |

### Usage Example

```html
<header class="site-header">
  <div class="container header-content">
    <div class="site-branding">
      <a href="#" class="custom-logo-link">
        <img src="logo.svg" alt="AITSC" class="custom-logo">
      </a>
    </div>
    <nav class="desktop-navigation">
      <ul class="primary-menu">
        <li><a href="#">Home</a></li>
        <li class="current-menu-item"><a href="#">Services</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </nav>
    <button class="mobile-menu-toggle" aria-label="Toggle menu">
      <span class="hamburger-line"></span>
      <span class="hamburger-line"></span>
      <span class="hamburger-line"></span>
    </button>
  </div>
</header>
```

---

## 6. Hero Section

### Hero Classes

| Class | Purpose |
|-------|---------|
| `.hero-section` | Main hero container |
| `.hero-background` | Background layer (video/image) |
| `.hero-overlay` | Dark overlay for contrast |
| `.hero-video` | Video background element |
| `.hero-gradient` | Gradient overlay |
| `.hero-container` | Content container |
| `.hero-content` | Main content wrapper |
| `.hero-title` | Main title (`h1`) |
| `.hero-word` | Animated word in title |
| `.hero-word-primary` | Primary colored word |
| `.hero-subtitle` | Subtitle text |
| `.hero-actions` | Button container |
| `.scroll-indicator` | Scroll down indicator |

### Usage Example

```html
<section class="hero-section">
  <div class="hero-background">
    <div class="hero-overlay"></div>
    <div class="hero-gradient"></div>
  </div>
  <div class="container hero-container">
    <div class="hero-content">
      <h1 class="hero-title">
        <span class="hero-word">Professional</span>
        <span class="hero-word hero-word-primary">Safety</span>
        <span class="hero-word">Solutions</span>
      </h1>
      <p class="hero-subtitle">Leading provider of workplace safety training and consulting</p>
      <div class="hero-actions">
        <a href="#" class="btn btn-primary btn-large">Get Started</a>
        <a href="#" class="btn btn-outline btn-large">Learn More</a>
      </div>
    </div>
  </div>
  <div class="scroll-indicator">
    <span class="scroll-text">Scroll to explore</span>
  </div>
</section>
```

---

## 7. Cards

### Card Base

| Class | Purpose |
|-------|---------|
| `.card` | Base card container |
| `.card-header` | Card header section |
| `.card-title` | Card title (`h3`) |
| `.card-subtitle` | Card subtitle |
| `.card-content` | Main card content |
| `.card-footer` | Card footer |

### Card Variants

| Class | Style |
|-------|-------|
| `.card-interactive` | Hover effects with transform |
| `.card-compact` | Reduced padding |
| `.card-spacious` | Increased padding |
| `.card-elevated` | Enhanced shadow |

### Service/Solution Cards

| Class | Purpose |
|-------|---------|
| `.service-icon` | Icon container |
| `.service-title` | Service card title |
| `.service-description` | Service description |
| `.service-link` | CTA link |
| `.services-grid` | 3-column grid |
| `.case-studies-grid` | 2-column grid |
| `.case-study-card` | Case study specific card |

### Usage Example

```html
<div class="grid grid-cols-3 services-grid">
  <div class="card card-interactive">
    <div class="card-header">
      <div class="service-icon">
        <svg>...</svg>
      </div>
      <h3 class="service-title">Service Name</h3>
    </div>
    <div class="card-content">
      <p class="service-description">Service description text</p>
    </div>
    <div class="card-footer">
      <a href="#" class="service-link">Learn More →</a>
    </div>
  </div>
</div>

<!-- Elevated card -->
<div class="card card-elevated">
  <div class="card-header">
    <h3 class="card-title">Card Title</h3>
    <span class="card-subtitle">Subtitle</span>
  </div>
  <div class="card-content">
    <p>Card content goes here</p>
  </div>
  <div class="card-footer">
    <button class="btn btn-primary btn-sm">Action</button>
  </div>
</div>
```

---

## 8. Forms

### Form Classes

| Class | Purpose |
|-------|---------|
| `.form-group` | Input group container |
| `.form-label` | Label styling |
| `.form-input` | Text input styling (shared with textarea/select) |
| `.form-select` | Select dropdown |
| `.form-textarea` | Textarea |
| `.form-row` | Row with multiple inputs |
| `.form-submit` | Submit button container |

### Usage Example

```html
<form>
  <div class="form-group">
    <label for="name" class="form-label">Full Name</label>
    <input type="text" id="name" class="form-input" placeholder="Enter your name">
  </div>

  <div class="form-group">
    <label for="email" class="form-label">Email Address</label>
    <input type="email" id="email" class="form-input" placeholder="you@example.com">
  </div>

  <div class="form-group">
    <label for="message" class="form-label">Message</label>
    <textarea id="message" class="form-textarea" rows="5"></textarea>
  </div>

  <div class="form-submit">
    <button type="submit" class="btn btn-primary">Send Message</button>
  </div>
</form>
```

---

## 9. Footer

### Footer Classes

| Class | Purpose |
|-------|---------|
| `.site-footer` | Main footer container |
| `.footer-main` | Footer top section |
| `.footer-grid` | Grid layout for footer |
| `.footer-section` | Individual footer column |
| `.footer-title` | Section heading |
| `.footer-branding` | Brand info section |
| `.footer-logo` | Logo in footer |
| `.footer-tagline` | Tagline text |
| `.footer-contact` | Contact info |
| `.contact-item` | Individual contact item |
| `.contact-icon` | Contact icon |
| `.footer-links` | Links list |
| `.footer-bottom` | Footer bar |
| `.footer-bottom-content` | Bottom container |
| `.newsletter-description` | Newsletter text |
| `.newsletter-signup` | Newsletter form |
| `.social-title` | Social links heading |

### Usage Example

```html
<footer class="site-footer">
  <div class="footer-main">
    <div class="container footer-grid">
      <div class="footer-section footer-branding">
        <div class="footer-logo">AITSC</div>
        <p class="footer-tagline">Professional Safety Solutions</p>
      </div>
      <div class="footer-section">
        <h4 class="footer-title">Quick Links</h4>
        <ul class="footer-links">...</ul>
      </div>
      <div class="footer-section">
        <h4 class="footer-title">Contact</h4>
        <div class="footer-contact">...</div>
      </div>
      <div class="footer-section">
        <h4 class="footer-title">Newsletter</h4>
        <p class="newsletter-description">Subscribe for updates</p>
        <div class="newsletter-signup">...</div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container footer-bottom-content">...</div>
  </div>
</footer>
```

---

## 10. Animations

### Animation Classes

| Class | Effect |
|-------|--------|
| `.animate-fade-in` | Fade in (opacity) |
| `.animate-slide-up` | Slide up from bottom |
| `.animate-bounce` | Bounce animation |
| `.animate-fadeInUp` | Fade + slide up |
| `.animate-fadeInDown` | Fade + slide down |
| `.animate-fadeInLeft` | Fade + slide from left |
| `.animate-fadeInRight` | Fade + slide from right |
| `.animate-pulse` | Pulse effect |
| `.animate-float` | Floating animation |

### Keyframes Available

- `@keyframes fadeIn`
- `@keyframes slideUp`
- `@keyframes slideDown`
- `@keyframes slideLeft`
- `@keyframes slideRight`
- `@keyframes bounce`
- `@keyframes pulse`
- `@keyframes float`
- `@keyframes countUp` (for stats animations)
- `@keyframes spin` (for loading spinner)
- `@keyframes loading` (for skeleton screens)

### Special Animations

| Class | Purpose |
|-------|---------|
| `.loading-spinner` | Animated spinner for loading states |
| `.skeleton` | Skeleton placeholder for content loading |

**Note**: Reduced motion support is included via `@media (prefers-reduced-motion: reduce)`.

### Usage Example

```html
<div class="animate-fade-in">Fades in on load</div>
<div class="animate-slide-up">Slides up from bottom</div>
<div class="animate-float">Floats continuously</div>

<div class="loading-spinner">Loading...</div>
<div class="skeleton">Placeholder</div>
```

---

## 11. Background & Gradient Utilities

### Gradient Classes

| Class | Purpose |
|-------|---------|
| `.gradient-bg` | Full-page gradient background |
| `.gradient-card` | Subtle gradient for card backgrounds |
| `.gradient-primary` | Primary blue gradient |
| `.gradient-accent` | Accent teal gradient |
| `.particle-effect` | Animated particle background effect |

### Usage Example

```html
<div class="gradient-bg">Full page gradient</div>
<div class="card gradient-card">Card with gradient</div>
<div class="gradient-primary">Primary gradient section</div>
```

**Note**: These gradients work with the `--aitsc-gradient-*` CSS variables documented in Section 1.

---

## 12. Utility Classes

### Text Alignment

```css
.text-center { text-align: center; }
.text-left { text-align: left; }
.text-right { text-align: right; }
```

### Text Colors

```css
.text-primary { color: var(--aitsc-primary); }
.text-secondary { color: var(--aitsc-text-secondary); }
.text-muted { color: var(--aitsc-text-muted); }
.text-light { color: var(--aitsc-text-light); }
.text-danger { color: var(--aitsc-danger); }
.text-warning { color: var(--aitsc-warning); }
.text-success { color: var(--aitsc-success); }
```

### Background Colors

```css
.bg-primary { background-color: var(--aitsc-primary); }
.bg-secondary { background-color: var(--aitsc-bg-secondary); }
.bg-dark { background-color: var(--aitsc-bg-dark); }
.bg-card { background-color: var(--aitsc-bg-card); }
```

### Shadows

```css
.shadow-sm { box-shadow: var(--aitsc-shadow-sm); }
.shadow-md { box-shadow: var(--aitsc-shadow-md); }
.shadow-lg { box-shadow: var(--aitsc-shadow-lg); }
.shadow-xl { box-shadow: var(--aitsc-shadow-xl); }
.shadow-2xl { box-shadow: var(--aitsc-shadow-2xl); }
```

### Border Radius

```css
.rounded-sm { border-radius: var(--aitsc-radius-sm); }
.rounded-md { border-radius: var(--aitsc-radius-md); }
.rounded-lg { border-radius: var(--aitsc-radius-lg); }
.rounded-xl { border-radius: var(--aitsc-radius-xl); }
.rounded-2xl { border-radius: var(--aitsc-radius-2xl); }
```

### Padding (p-0 to p-24)

```css
.p-0 { padding: var(--space-0); }
.p-1 { padding: var(--space-1); }
.p-2 { padding: var(--space-2); }
/* ... up to p-24 */
```

### Margin (m-0 to m-6)

```css
.m-0 { margin: var(--space-0); }
.m-1 { margin: var(--space-1); }
.m-2 { margin: var(--space-2); }
/* ... up to m-6 */

/* Margin bottom specific */
.mb-0 { margin-bottom: 0; }
.mb-1 { margin-bottom: var(--aitsc-space-xs); }
.mb-2 { margin-bottom: var(--aitsc-space-sm); }
.mb-3 { margin-bottom: var(--aitsc-space-md); }
.mb-4 { margin-bottom: var(--aitsc-space-lg); }
.mb-5 { margin-bottom: var(--aitsc-space-xl); }
.mb-6 { margin-bottom: var(--aitsc-space-2xl); }
```

### Accessibility

```css
.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}
```

### Usage Example

```html
<div class="bg-card shadow-lg rounded-lg p-6">
  <h3 class="text-headline text-primary mb-4">Card Title</h3>
  <p class="text-body mb-4">Card content with proper spacing</p>
  <button class="btn btn-primary">Action</button>
</div>
```

---

## Removed Classes (Consolidated)

The following duplicate definitions were **removed** during consolidation (181 lines total across 8 blocks). Use the primary versions listed above:

| Removed | Use Instead |
|---------|-------------|
| `.text-body` (duplicate) | `.text-body` (primary) |
| `.btn-primary` (AITSC version) | `.btn-primary` (WorldQuant version) |
| `.btn-secondary` (AITSC version) | `.btn-secondary` (WorldQuant version) |
| `.btn-outline` (AITSC version) | `.btn-outline` (WorldQuant version) |
| `.btn-sm` (AITSC version) | `.btn-sm` (WorldQuant version) |
| `.btn-lg` (AITSC version) | `.btn-lg` (WorldQuant version) |
| `.btn-xl` (AITSC version) | `.btn-xl` (WorldQuant version) |
| `.skip-link` (nav section) | `.skip-link` (accessibility section) |
| `.hero-stats` (original) | Enhanced version with animations |
| `.form-group` (footer) | `.form-group` (forms section) |
| `.social-link` (footer) | `.social-link` (navigation section) |
| `.hero-container` (AITSC) | `.hero-container` (WorldQuant version) |
| `.hero-content` (AITSC) | `.hero-content` (WorldQuant version) |
| `.hero-title` (AITSC) | `.hero-title` (WorldQuant version) |
| `.hero-subtitle` (AITSC) | `.hero-subtitle` (WorldQuant version) |
| `h1` (redefinition) | `h1` (primary definition) |

---

## Best Practices

### 1. Use Semantic HTML
```html
<!-- Good -->
<h1 class="text-hero">Page Title</h1>

<!-- Avoid -->
<div class="text-hero">Fake Heading</div>
```

### 2. Combine Utilities Judiciously
```html
<!-- Good: Semantic class + utility for spacing -->
<div class="card mb-4">...</div>

<!-- Acceptable: Utility-only for quick layouts -->
<div class="flex items-center justify-between p-4">...</div>

<!-- Avoid: Over-utility usage -->
<div class="bg-white shadow-lg rounded-lg p-4 m-2 border border-gray-200">...</div>
```

### 3. Use CSS Variables for Customization
```css
/* Instead of hardcoding values */
.custom-element {
  color: #2563eb;
  padding: 16px;
}

/* Use design tokens */
.custom-element {
  color: var(--accent-primary);
  padding: var(--space-4);
}
```

### 4. Responsive Typography
The theme uses fluid typography with `clamp()`. Use the provided classes instead of fixed font sizes:

```css
/* Good */
.text-hero { font-size: var(--font-size-5xl); } /* 48-64px fluid */

/* Avoid */
.custom-hero { font-size: 60px; } /* Fixed size */
```

### 5. Focus States for Accessibility
All interactive elements inherit proper focus states from base classes:

```css
/* Automatic focus outline from .btn */
<a href="#" class="btn btn-primary">Has focus state</a>
```

---

## File Structure

```
style.css (2619 lines)
├── 1.0 CSS Reset (lines 40-67)
├── 2.0 Variables (lines 99-272)
├── 3.0 Typography (lines 289-380)
├── 4.0 Layout (lines 385-493)
├── 5.0 Components (lines 498-583)
├── 6.0 Buttons (lines 587-723)
├── 7.0 Navigation (lines 727-1280)
├── 8.0 Hero (lines 1285-1458)
├── 9.0 Cards (lines 1567-1700)
├── 10.0 Forms (lines 1727-1855)
├── 11.0 Animations (lines 1864-1888)
├── 12.0 Backgrounds (lines 1904-1916)
├── 13.0 Responsive (lines 1920-2619)
└── 14.0 Utilities (lines 2219-2619)
```

---

## Version History

| Date | Version | Changes |
|------|---------|---------|
| 2025-12-24 | 2.0.1 | Removed 181 duplicate lines (8 blocks), consolidated design system |
| 2025-12-24 | 2.0.0 | WorldQuant-inspired redesign |
| Earlier | 1.x | Legacy AITSC theme |

---

## Support

For questions or issues with the design system:
1. Check this reference first
2. Review `docs/design-system-phase2.md` for consolidation details
3. Check the main plan at `/Users/phuc/plans/251224-comprehensive-aitsc-fix/plan.md`

**Document Created**: 2025-12-24
**Author**: AITSC Development Team
**Status**: ✅ Current (Post-Consolidation)
