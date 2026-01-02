# Project Overview & Product Development Requirements (PDR)

**Project**: Australian Integrated Transport Safety Consultants (AITSC) Website
**Theme**: AITSC Pro Theme v4.0.0 (Harrison.ai Migration)
**Status**: ✅ PRODUCTION READY
**Last Updated**: 2026-01-02

## 1. Project Purpose
The AITSC website serves as the digital front door for a specialized transport safety consulting company. It provides comprehensive information on NHVAS accreditation, Chain of Responsibility (CoR) compliance, and transport risk management services.

## 2. Product Development Requirements (PDR)

### 2.1 Functional Requirements
- **Content Management**: Support for custom post types: Solutions and Case Studies.
- **Interactive Forms**: Multi-step contact form with validation and progress tracking.
- **Service Showcase**: Dynamic filtering of transport safety solutions.
- **Case Study Portfolio**: Detailed presentation of project outcomes and client testimonials.
- **Global Components**: Standardized hero sections, trust bars, logo carousels, and image compositions.

### 2.2 Non-Functional Requirements
- **Design Aesthetic**: Harrison.ai-inspired white theme with AITSC Cyan (#005cb2) accents.
- **Accessibility**: WCAG 2.1 AA compliance across all components and templates.
- **Performance**: Mobile-first design with optimized assets and GPU-accelerated animations.
- **Security**: Robust input sanitization, nonce verification, and XSS prevention.
- **Responsive Design**: Support for 5 breakpoints:
  - Mobile: 0-575px
  - Phablet: 576-767px
  - Tablet: 768-991px
  - Desktop: 992-1199px
  - Large Desktop: 1200px+

## 3. Key Components
- **Universal Hero**: Versatile hero section with variants: `homepage`, `page`, `pillar`, and `white-fullwidth`.
- **Trust Bar**: Cyan-branded social proof statement bar.
- **Logo Carousel**: Auto-scrolling, CSS-animated partner logo display.
- **Image Composition**: Dynamic overlapping image layouts for visual interest.
- **Advanced Contact Form**: Secure, multi-step AJAX-powered lead generation tool.

## 4. Technology Stack
- **Platform**: WordPress 6.0+
- **Environment**: PHP 8.0+
- **Styling**: Tailwind CSS inspired utility classes + BEM-based component CSS.
- **Interactivity**: Vanilla JavaScript with Page Visibility API and Intersection Observer.
- **Data**: Advanced Custom Fields (ACF) for structured content.

## 5. Success Metrics
- 95%+ Accessibility score.
- 100% Mobile responsiveness pass rate.
- < 1.5s First Contentful Paint (FCP).
- Zero blocking security vulnerabilities.
