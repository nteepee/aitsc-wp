# Phase 01: Research & Analysis

**Context**: [Plan Overview](./plan.md)
**Date**: 2026-01-04
**Priority**: High
**Status**: Complete

---

## Overview

Analyze technical approaches for implementing a universal paper stack scroll effect in WordPress theme architecture, evaluating modern CSS capabilities, fallback strategies, and integration patterns.

---

## Key Insights

### 1. Native CSS Scroll-Driven Animations (2025 Standard)

**Capability**: `animation-timeline: view()` links animations to scroll position
**Browser Support**: Full support (Chrome 115+, Safari 18.2+, Firefox 129+)
**Performance**: Runs on compositor thread, zero main-thread blocking
**Use Case**: Primary implementation method

```css
@supports (animation-timeline: view()) {
  .paper-stack-section {
    transform: translateY(100px);
    animation: paper-stack linear both;
    animation-timeline: view();
    animation-range: entry 10% cover 50%;
  }
}

@keyframes paper-stack {
  to {
    transform: translateY(0);
  }
}
```

### 2. Intersection Observer Fallback (Legacy)

**Capability**: Detect when elements enter viewport
**Browser Support**: Universal (IE11+ with polyfills)
**Performance**: Main-thread execution (mitigated by passive observers)
**Use Case**: Progressive enhancement fallback

```javascript
const stackObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('paper-stack-visible');
    }
  });
}, { threshold: 0.1 });
```

### 3. Hardware Acceleration Techniques

**3D Transforms**: `transform3d()` + `translateZ()` forces GPU layer
**Will-Change**: Hint browser for optimization (use sparingly)
**Containment**: `contain: layout style paint` isolates repaints

```css
.paper-stack-section {
  will-change: transform; /* Remove when not animating */
  contain: layout style paint;
  transform: translateZ(0); /* Force GPU layer */
}
```

---

## Requirements

### Functional Requirements
1. Universal component usable across all page templates
2. Configurable animation parameters (speed, distance, easing)
3. Enable/disable via WordPress admin or ACF fields
4. Mobile-responsive with touch-optimized behavior

### Non-Functional Requirements
1. Performance: 60fps on modern devices, 30fps minimum on older
2. Accessibility: Respect `prefers-reduced-motion`, provide skip links
3. SEO: No layout shift (CLS 0), maintain scroll position
4. Compatibility: WordPress 6.0+, PHP 8.0+, modern browsers

### Technical Constraints
1. Component-based architecture (`/components/` directory)
2. Enqueue system integration (`inc/enqueue.php`)
3. No external dependencies (use native APIs only)
4. Minimal JavaScript (YAGNI principle)

---

## Architecture Analysis

### Current Animation System

**Existing Files**:
- `/assets/js/scroll-animations.js` - Intersection Observer for fade-ins
- `/style.css` (lines 3593-3679) - Fade-in CSS classes
- AOS library enqueued but underutilized

**Current Approach**:
```javascript
// Simple fade-in observer
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('is-visible');
      observer.unobserve(entry.target);
    }
  });
});
```

**Limitations**:
- No scroll-position-based animations
- One-time trigger only (unobserved after first reveal)
- No depth or stacking effects
- No configuration options

### Component Structure

**Existing Components**:
- `/components/card/` - Card variants with animations
- `/components/hero/` - Hero sections with parallax
- `/components/problem-solution/` - Interactive problem-solution blocks
- `/components/steps/`, `/components/tabs/`, `/components/gallery/`

**Integration Points**:
- Single solution pages (`single-solutions.php`)
- Pillar pages (`page-fleet-safe-pro.php`)
- Homepage (`front-page.php`)
- Solution section templates (`/template-parts/solution/`)

---

## Technical Recommendations

### 1. Hybrid Approach (Primary + Fallback)

**Rationale**: Maximize browser support while leveraging modern APIs

```css
/* Progressive enhancement pattern */
@supports (animation-timeline: view()) {
  /* Native CSS Scroll-Driven Animations */
  .paper-stack-section {
    animation: slide-over linear both;
    animation-timeline: view();
    animation-range: entry 10% cover 50%;
  }
}

@supports not (animation-timeline: view()) {
  /* Intersection Observer fallback */
  .paper-stack-section {
    opacity: 0;
    transform: translateY(100px);
    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
  }

  .paper-stack-section.is-visible {
    opacity: 1;
    transform: translateY(0);
  }
}
```

### 2. Component-Based Architecture

**Rationale**: Reusable, testable, maintainable

```
/components/paper-stack/
├── paper-stack.php           # Component template
├── paper-stack.css           # Component styles
├── paper-stack.js            # Fallback JS
└── README.md                 # Documentation
```

**Usage Pattern**:
```php
// In template files
get_template_part('components/paper-stack/paper-stack', null, [
  'enabled' => true,
  'distance' => '100px',
  'duration' => '0.6s'
]);
```

### 3. Performance Optimization

**GPU Acceleration**:
```css
.paper-stack-section {
  transform: translate3d(0, 100px, 0); /* Force GPU */
  will-change: transform; /* Hint optimization */
}

.paper-stack-section.is-animating {
  /* Animation in progress */
}

.paper-stack-section.animation-complete {
  will-change: auto; /* Remove hint after animation */
}
```

**Containment**:
```css
.paper-stack-section {
  contain: layout style paint; /* Isolate repaints */
}
```

**Intersection Observer Optimization**:
```javascript
// Use passive listeners
const observer = new IntersectionObserver(callback, {
  threshold: 0.1,
  rootMargin: '50px' // Trigger before viewport entry
});

// Unobserve after animation
observer.unobserve(element);
```

---

## Implementation Steps

### Step 1: Research CSS Scroll-Driven Animations
- [ ] Review MDN documentation for `animation-timeline`
- [ ] Test browser compatibility (Chrome, Safari, Firefox)
- [ ] Analyze performance characteristics
- [ ] Document best practices

### Step 2: Analyze Existing Codebase
- [ ] Map current animation system
- [ ] Identify integration points
- [ ] Review component architecture
- [ ] Assess performance baseline

### Step 3: Design Fallback Strategy
- [ ] Implement Intersection Observer fallback
- [ ] Test on older browsers
- [ ] Verify graceful degradation
- [ ] Document browser support matrix

### Step 4: Performance Validation
- [ ] Run Lighthouse audits
- [ ] Measure frame rates (Chrome DevTools Performance)
- [ ] Test on mobile devices
- [ ] Optimize bottlenecks

---

## Success Criteria

- [ ] CSS Scroll-Driven Animations verified working in Chrome 115+, Safari 18.2+, Firefox 129+
- [ ] Intersection Observer fallback tested and functional
- [ ] Performance audit shows 60fps on modern devices
- [ ] Component architecture designed and documented
- [ ] Integration points identified and validated

---

## Risk Assessment

**Low Risk**:
- CSS Scroll-Driven Animations are production-ready (2025)
- Extensive documentation and community support
- Progressive enhancement pattern proven

**Medium Risk**:
- Mobile performance on older devices (mitigation: GPU acceleration)
- WordPress plugin conflicts (mitigation: namespace isolation)

**High Risk**:
- None identified

---

## Security Considerations

- No external dependencies (reduces attack surface)
- Native browser APIs (no third-party scripts)
- Output escaping in WordPress templates
- Nonce verification for admin settings

---

## Next Steps

Proceed to **[Phase 02: Architecture Design](./phase-02-architecture-design.md)** for detailed system architecture and component design.

---

## Related Code Files

- `/wp-content/themes/aitsc-pro-theme/style.css` (lines 3593-3679)
- `/wp-content/themes/aitsc-pro-theme/assets/js/scroll-animations.js`
- `/wp-content/themes/aitsc-pro-theme/inc/enqueue.php`
- `/wp-content/themes/aitsc-pro-theme/components/`
- `/wp-content/themes/aitsc-pro-theme/single-solutions.php`
- `/wp-content/themes/aitsc-pro-theme/page-fleet-safe-pro.php`
