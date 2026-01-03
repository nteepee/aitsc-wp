# Universal Scroll Effects Research Report

**Date**: 2026-01-04
**Topic**: Paper Stack Scroll Effect & Scroll-Driven Animations
**Focus**: WordPress integration, performance, accessibility

---

## Executive Summary

Native CSS scroll-driven animations are production-ready in 2025 with full cross-browser support (Safari 26 completed coverage). For WordPress themes, **hybrid approach recommended**: native CSS for simple effects + Intersection Observer for complex triggers + GSAP only for advanced sequences.

---

## 1. Paper Stack Scroll Effect

### Implementation: Codrops 3D Stack Motion (2024)
- **Technique**: CSS `transform3d()` + `translateZ()` for 3D depth + Intersection Observer for scroll detection
- **Demo**: [tympanus.net/Development/3DStackMotion/](https://tympanus.net/Development/3DStackMotion/)
- **Code**: [github.com/codrops/3DStackMotion](https://github.com/codrops/3DStackMotion/)

**Core Pattern**:
```css
.stack-section {
  transform-style: preserve-3d;
  transition: transform 0.6s ease;
}
.stack-section.active {
  transform: translateZ(100px);
}
```

```javascript
// Intersection Observer for scroll trigger
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('active');
    }
  });
}, { threshold: 0.5 });
```

### Performance Notes
- Intersection Observer: Asynchronous, non-blocking, browser-optimized
- CSS 3D transforms: GPU-accelerated, runs on compositor thread
- Avoid scroll event listeners - cause layout thrashing

---

## 2. Native CSS Scroll-Driven Animations (2025)

### Browser Support
- Chrome 115+, Firefox 110+, Safari 16.4+ (Safari 26 completed support in 2025)
- **Production-ready** - no longer experimental
- Polyfill available: [github.com/flackr/scroll-timeline](https://github.com/flackr/scroll-timeline)

### Key Features

**view() Function** - Element visibility-based animations:
```css
@keyframes fade-in {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.element {
  animation: fade-in linear both;
  animation-timeline: view();  /* Driven by viewport visibility */
}
```

**scroll() Function** - Scroll position-based animations:
```css
.parallax-bg {
  animation: parallax linear both;
  animation-timeline: scroll(root block);
}

@keyframes parallax {
  to { transform: translateY(-100px); }
}
```

**scroll-timeline** - Named scrollable container:
```css
@scroll-timeline stack-scroll --source: selector(.stack-container);

.card {
  animation: stack-up linear both;
  animation-timeline: stack-scroll;
}
```

### Advantages
- **Zero JavaScript overhead** - pure CSS
- **60fps guaranteed** - runs on compositor thread
- **Declarative & maintainable** - no complex JS logic
- **No bundle bloat** - 0kb additional size

---

## 3. Library Comparison (2025)

| Solution         | Size      | Performance | Complexity | Best For                          |
|------------------|-----------|-------------|------------|-----------------------------------|
| Native CSS       | 0kb       | ⭐⭐⭐⭐⭐     | Low        | Simple scroll-triggered effects   |
| Lenis            | 3-5kb     | ⭐⭐⭐⭐       | Very Low   | Smooth scrolling momentum         |
| GSAP ScrollTrigger| 10-30kb   | ⭐⭐⭐        | Medium     | Complex sequences, pinning        |
| Intersection Observer | 0kb    | ⭐⭐⭐⭐⭐     | Low        | Viewport detection triggers       |

### Recommendations

**Use Native CSS when**:
- Fade-ins, parallax, progress bars
- Performance critical
- Zero JS dependencies preferred

**Use Lenis when**:
- Smooth scroll enhancement needed
- Simple UX improvement
- Works great with native CSS animations

**Use GSAP ScrollTrigger when**:
- Complex timeline sequences
- Pinning, scrubbing, precise timing
- Cross-browser legacy support crucial

---

## 4. WordPress Implementation

### Option A: Native CSS (Recommended for 2025)
```php
// functions.php - Enqueue scroll-animations.css
function theme_scroll_animations() {
  wp_enqueue_style('scroll-animations',
    get_template_directory_uri() . '/assets/css/scroll-animations.css',
    array(),
    '1.0.0'
  );
}
add_action('wp_enqueue_scripts', 'theme_scroll_animations');
```

```css
/* scroll-animations.css */
@supports (animation-timeline: view()) {
  .fade-in-on-scroll {
    animation: fade-in linear both;
    animation-timeline: view();
    animation-range: entry 10% cover 30%;
  }

  @keyframes fade-in {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }
}
```

### Option B: Intersection Observer (Fallback)
```javascript
// assets/js/scroll-observer.js
document.addEventListener('DOMContentLoaded', () => {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate-in');
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

  // Auto-observe elements with .scroll-animate class
  document.querySelectorAll('.scroll-animate').forEach(el => {
    observer.observe(el);
  });
});
```

```php
// functions.php
function theme_scroll_observer() {
  wp_enqueue_script('scroll-observer',
    get_template_directory_uri() . '/assets/js/scroll-observer.js',
    array(),
    '1.0.0',
    true
  );
}
add_action('wp_enqueue_scripts', 'theme_scroll_observer');
```

### Option C: Paper Stack Component
```php
// template-parts/scroll-stack.php
$stack_sections = have_rows('stack_sections') ? get_field('stack_sections') : [];
?>

<div class="paper-stack-container">
  <?php foreach ($stack_sections as $index => $section): ?>
    <section class="stack-section" style="--stack-index: <?php echo $index; ?>">
      <?php echo $section['content']; ?>
    </section>
  <?php endforeach; ?>
</div>
```

```css
/* assets/css/paper-stack.css */
.paper-stack-container {
  perspective: 1000px;
}

.stack-section {
  transform-style: preserve-3d;
  transform: translateZ(calc(var(--stack-index) * -50px));
  transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.stack-section.in-view {
  transform: translateZ(calc(var(--stack-index) * 50px));
}
```

---

## 5. Accessibility (CRITICAL)

### WCAG 2.3.3 Compliance
```css
/* MUST include in all scroll animations */
@media (prefers-reduced-motion: reduce) {
  /* Disable scroll-driven animations */
  * {
    animation-timeline: none !important;
    animation: none !important;
    transition: none !important;
  }

  /* Provide instant visibility */
  .scroll-animate,
  .fade-in-on-scroll,
  .stack-section {
    opacity: 1 !important;
    transform: none !important;
  }
}
```

**Requirements**:
- Respect `prefers-reduced-motion` setting
- Parallax & scroll-jacking must be disable-able
- Provide static content fallbacks
- Never hide essential content behind animations

**Health Considerations**:
- Vestibular disorders (dizziness, nausea)
- Migraines, epilepsy triggers
- ADHD (motion distractions)
- Low-end device performance

---

## 6. Performance Best Practices

### DO:
- Use native CSS scroll-driven animations (compositor thread)
- Use Intersection Observer (async, non-blocking)
- Implement `will-change: transform` sparingly for animated elements
- Test on real mobile devices (battery + CPU impact)
- Lazy load images below fold with Intersection Observer

### DON'T:
- Use scroll event listeners (main thread blocking)
- Animate layout properties (width, height, top, left)
- Overuse `will-change` (causes memory issues)
- Apply animations to large DOM trees
- Ignore `prefers-reduced-motion`

### Performance Testing
- Lighthouse Performance score (target 90+)
- Chrome DevTools Performance profiler (check main thread)
- Real device testing (iPhone, Android, low-end)
- Network throttling (3G, 4G scenarios)

---

## 7. Mobile Considerations

### Responsive Patterns
```css
/* Reduce animation complexity on mobile */
@media (max-width: 768px) {
  .stack-section {
    /* Simpler 2D fallback */
    transform: none;
    transition: opacity 0.4s ease;
  }

  .stack-section.in-view {
    opacity: 1;
  }
}

/* Touch device optimization */
@media (hover: none) and (pointer: coarse) {
  .parallax-bg {
    animation: none; /* Parallax can cause jank on touch */
  }
}
```

### Battery Awareness
- Reduce animation frequency on low-power mode
- Use `matchMedia('(prefers-reduced-motion: reduce)')` in JS
- Consider ambient light sensor for auto-reduction

---

## 8. Recommended Implementation Strategy

### Phase 1: Foundation (Week 1)
1. Add `prefers-reduced-motion` media queries to all CSS
2. Implement Intersection Observer fallback for older browsers
3. Create base `.scroll-animate` utility class

### Phase 2: Native CSS (Week 2)
1. Add `@supports (animation-timeline: view())` progressive enhancement
2. Implement fade-in, slide-up animations with `view()`
3. Test cross-browser (Chrome, Firefox, Safari)

### Phase 3: Paper Stack (Week 3)
1. Build Codrops-inspired 3D stack component
2. Add Intersection Observer trigger
3. Create WordPress template part
4. Mobile responsive fallback

### Phase 4: Polish (Week 4)
1. Performance testing + optimization
2. Accessibility audit
3. Documentation for content editors

---

## 9. Code Templates

### Universal Scroll Component
```php
<?php
// components/universal-scroll-section.php
/**
 * Universal scroll section with progressive enhancement
 * Supports: Native CSS, Intersection Observer, Reduced Motion
 */

$classes = ['scroll-section', 'scroll-animate'];
$style = '';

// Add inline styles for dynamic properties if needed
if ($animation_delay = get_sub_field('animation_delay')) {
  $style = "style='animation-delay: {$animation_delay}ms'";
}
?>

<section class="<?php echo esc_attr(implode(' ', $classes)); ?>" <?php echo $style; ?>>
  <?php the_content(); ?>
</section>
```

```css
/* assets/css/universal-scroll.css */

/* Base state */
.scroll-section {
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.6s ease, transform 0.6s ease;
}

/* JavaScript trigger */
.scroll-section.animate-in {
  opacity: 1;
  transform: translateY(0);
}

/* Progressive enhancement - native CSS */
@supports (animation-timeline: view()) {
  .scroll-section {
    animation: scroll-fade-in linear both;
    animation-timeline: view();
    animation-range: entry 10% cover 40%;
  }

  @keyframes scroll-fade-in {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
  .scroll-section {
    opacity: 1 !important;
    transform: none !important;
    animation: none !important;
  }
}
```

---

## 10. Sources

### Scroll-Driven Animations
- [MDN: Scroll-Driven Animations Guide](https://developer.mozilla.org/en-US/docs/Web/CSS/Guides/Scroll-driven_animations)
- [WebKit Blog: CSS Scroll-Driven Animations (June 2025)](https://webkit.org/blog/17101/a-guide-to-scroll-driven-animations-with-just-css/)
- [CSS-Tricks: Creating Scroll-Based Animations in Full view()](https://css-tricks.com/creating-scroll-based-animations-in-full-view/)
- [Design.dev: Complete CSS Scroll-Driven Animations Guide](https://design.dev/guides/scroll-timeline/)

### Paper Stack Effect
- [Codrops: On-Scroll 3D Stack Motion Effect (March 2024)](https://tympanus.net/codrops/2024/03/06/on-scroll-3d-stack-motion-effect/)
- [Codrops 3D Stack Motion Demo](https://tympanus.net/Development/3DStackMotion/)
- [GitHub: Codrops 3DStackMotion](https://github.com/codrops/3DStackMotion)

### Library Comparisons
- [Latest ScrollReveal Solutions (2024-2025)](https://portalzine.de/latest-scrollreveal-solutions-in-javascript-2024-2025/)
- [Smooth Scrolling Libraries Comparison](https://www.borndigital.be/blog/our-smooth-scrolling-libraries)

### WordPress + Intersection Observer
- [CL Creative: Intersection Observer vs GSAP](https://www.clcreative.co/blog/should-you-use-the-intersection-observer-api-or-gsap-for-scroll-animations)
- [freeCodeCamp: Scroll Animations with Intersection Observer](https://www.freecodecamp.org/news/scroll-animations-with-javascript-intersection-observer-api/)

### Accessibility
- [MDN: CSS Media Queries for Accessibility](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_media_queries/Using_media_queries_for_accessibility)
- [web.dev: prefers-reduced-motion](https://web.dev/articles/prefers-reduced-motion)
- [Smashing Magazine: Respecting Users' Motion Preferences](https://www.smashingmagazine.com/2021/10/respecting-users-motion-preferences)
- [Deque University: WCAG 2.3.3 Animations from Interactions](https://dequeuniversity.com/resources/wcag2.1/2.3.3-animations-from-interactions)

---

## Unresolved Questions

1. **Paper Stack Performance**: Need real-world testing of transform3d on mobile devices (GPU memory usage)
2. **Browser Fallbacks**: Optimal Intersection Observer threshold for paper stack sections
3. **WordPress ACF Integration**: Best field structure for content editors to configure scroll animations
4. **Lenis + Native CSS Hybrid**: Potential conflicts when combining smooth scroll with CSS animations
5. **SEO Impact**: Whether scroll-driven animations affect Core Web Vitals (LCP, CLS, FID)

---

## Conclusion

**2025 Recommendation**: Native CSS scroll-driven animations are production-ready and should be default choice. Use Intersection Observer as progressive enhancement fallback. GSAP only for complex sequences beyond CSS capabilities. Paper stack effect achievable with transform3d + IO. **Accessibility non-negotiable** - always implement prefers-reduced-motion.

WordPress implementation straightforward with wp_enqueue_scripts/hooks. Performance excellent when avoiding scroll event listeners. Mobile responsive with touch-specific optimizations.
