# Codebase Summary

**Project**: AITSC WordPress Website
**Theme**: AITSC Pro Theme (v4.0.0)
**Primary Architecture**: Modular Component-Based WordPress Theme

## 1. Key Components
The theme is built around a "Universal Component" system that emphasizes reusability, consistency, and accessibility.

### 1.1 Hero System (`components/hero/`)
- **Universal Hero**: The main landing component supporting multiple variants.
- **Variants**:
  - `homepage`: Immersive, full-viewport hero with square particle animations.
  - `page`: Standardized internal page hero (White background, Cyan accents).
  - `white-fullwidth`: Photo-heavy hero with centered content box and glassmorphism.
  - `pillar`: Specialized product landing hero with left-aligned CTAs.

### 1.2 Card System (`components/card/`)
- **White Feature**: Icon-based cards for service grids.
- **White Product**: Image-heavy cards for solution or case study listings.
- **White Minimal**: Clean text cards for sidebars or secondary information.

### 1.3 Social Proof Components
- **Trust Bar**: Cyan-branded text bar for social proof statements.
- **Logo Carousel**: CSS-animated, auto-scrolling partner logo display.
- **Image Composition**: Multi-image overlapping layout system.

## 2. Core Logic & Infrastructure (`inc/`)
- **`components.php`**: Central registry for all theme components, handling logic inclusion and asset enqueuing.
- **`enqueue.php`**: Manages global scripts and styles, including integration with the design system.
- **`aitsc-content-data.php`**: Centralized repository for service content, pricing, and configuration.
- **`contact-ajax.php`**: Secure handler for multi-step form submissions.

## 3. Advanced Features
- **Multi-Step Contact Form**: A 4-step wizard with real-time validation and progress tracking (`template-parts/contact-form-advanced.php`).
- **Accessibility Manager**: Dedicated system for focus trapping, keyboard navigation, and ARIA live regions (`assets/js/accessibility.js`).
- **Design System**: A robust CSS variable-based system currently configured for the "Harrison.ai" white theme aesthetic.

## 4. Content Structure
- **Custom Post Types**:
  - `Solutions`: Categorized transport safety services (NHVAS, CoR, Engineering).
  - `Case Studies`: Project portfolio demonstrating results and client success.
- **ACF Integration**: Deep integration with Advanced Custom Fields for structured data population across all custom post types and landing pages.
