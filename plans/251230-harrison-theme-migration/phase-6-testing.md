# Phase 6: Testing & QA

**Status**: Not Started
**Priority**: Critical
**Dependencies**: Phases 1-5

---

## Context

Comprehensive testing to validate white theme migration, accessibility compliance, performance, and cross-browser/device compatibility.

---

## Testing Categories

1. Visual Regression Testing
2. Accessibility Testing (WCAG 2.1 AA)
3. Performance Testing (Lighthouse)
4. Cross-Browser Testing
5. Responsive/Device Testing
6. Functional Testing

---

## 1. Visual Regression Testing

### Checklist

| Page | White BG | No Dark Remnants | Components Correct |
|------|----------|------------------|-------------------|
| Homepage | [ ] | [ ] | [ ] |
| About | [ ] | [ ] | [ ] |
| Contact | [ ] | [ ] | [ ] |
| Solutions Archive | [ ] | [ ] | [ ] |
| Single Solution | [ ] | [ ] | [ ] |
| Case Studies Archive | [ ] | [ ] | [ ] |
| Single Case Study | [ ] | [ ] | [ ] |
| Blog/Posts | [ ] | [ ] | [ ] |
| 404 Page | [ ] | [ ] | [ ] |

### Elements to Verify

- [ ] Header: White background, blue CTA
- [ ] Hero: Photo background with white text OR white split layout
- [ ] Cards: White background, subtle shadow
- [ ] Trust Bar: Centered text, light bg
- [ ] Logo Carousel: Grayscale logos, smooth scroll
- [ ] Stats: Blue numbers on white
- [ ] CTAs: Blue buttons, white secondary
- [ ] Footer: Light gray background
- [ ] Forms: White inputs, blue focus states
- [ ] Navigation: White dropdowns, blue hover

---

## 2. Accessibility Testing (WCAG 2.1 AA)

### Automated Tools

```bash
# Run axe-core via CLI
npx axe https://localhost/aitsc-wp --include "#primary"

# Lighthouse accessibility audit
lighthouse https://localhost/aitsc-wp --only-categories=accessibility
```

### Contrast Ratios (Manual Verification)

| Element | Foreground | Background | Ratio | Pass |
|---------|------------|------------|-------|------|
| Body text | #475569 | #FFFFFF | 7.0:1 | [x] |
| Muted text | #64748B | #FFFFFF | 4.6:1 | [x] |
| Primary CTA | #FFFFFF | #005cb2 | 5.4:1 | [x] |
| Links | #005cb2 | #FFFFFF | 5.4:1 | [x] |
| Card title | #1E293B | #FFFFFF | 12.6:1 | [x] |

### Keyboard Navigation

- [ ] Tab order is logical
- [ ] Focus states visible (3px outline)
- [ ] Skip links work
- [ ] Dropdown menus accessible
- [ ] Mobile menu accessible
- [ ] Forms keyboard operable
- [ ] Carousels pausable (if applicable)

### Screen Reader

- [ ] Landmarks properly defined
- [ ] Headings hierarchy correct (h1 > h2 > h3)
- [ ] Images have alt text
- [ ] Icons have aria-hidden or labels
- [ ] Form labels associated
- [ ] Error messages announced

### Motion Preferences

- [ ] Animations respect `prefers-reduced-motion`
- [ ] Logo carousel stops or provides alternative
- [ ] Hero animations disabled when reduced
- [ ] Image composition float disabled

---

## 3. Performance Testing

### Lighthouse Targets

| Metric | Target | Current |
|--------|--------|---------|
| Performance | > 85 | [ ] |
| Accessibility | > 95 | [ ] |
| Best Practices | > 90 | [ ] |
| SEO | > 90 | [ ] |

### Core Web Vitals

| Metric | Target | Current |
|--------|--------|---------|
| LCP (Largest Contentful Paint) | < 2.5s | [ ] |
| FID (First Input Delay) | < 100ms | [ ] |
| CLS (Cumulative Layout Shift) | < 0.1 | [ ] |

### CSS Analysis

```bash
# Check CSS file sizes
wc -c style.css
wc -c components/**/*.css

# Target: < 100KB total CSS (unminified)
```

### Image Optimization

- [ ] Hero images WebP format
- [ ] Logo carousel images optimized
- [ ] Lazy loading implemented
- [ ] Responsive images (srcset)

---

## 4. Cross-Browser Testing

### Desktop Browsers

| Browser | Version | Windows | macOS |
|---------|---------|---------|-------|
| Chrome | Latest | [ ] | [ ] |
| Firefox | Latest | [ ] | [ ] |
| Safari | Latest | N/A | [ ] |
| Edge | Latest | [ ] | [ ] |

### Mobile Browsers

| Browser | iOS | Android |
|---------|-----|---------|
| Safari | [ ] | N/A |
| Chrome | [ ] | [ ] |
| Samsung Internet | N/A | [ ] |

### Known Issues to Check

- [ ] CSS Grid support
- [ ] Backdrop-filter (Safari)
- [ ] Sticky positioning
- [ ] CSS custom properties

---

## 5. Responsive Testing

### Breakpoints

| Breakpoint | Width | Status |
|------------|-------|--------|
| Mobile | 375px | [ ] |
| Phablet | 576px | [ ] |
| Tablet | 768px | [ ] |
| Desktop | 992px | [ ] |
| Large Desktop | 1200px | [ ] |
| Ultra-wide | 1400px+ | [ ] |

### Device Specific Tests

| Device | Resolution | Status |
|--------|------------|--------|
| iPhone SE | 375x667 | [ ] |
| iPhone 14 | 390x844 | [ ] |
| iPhone 14 Pro Max | 430x932 | [ ] |
| iPad | 768x1024 | [ ] |
| iPad Pro | 1024x1366 | [ ] |
| Samsung Galaxy S21 | 360x800 | [ ] |

### Responsive Elements

- [ ] Header collapses to hamburger < 992px
- [ ] Cards stack on mobile
- [ ] Hero text resizes appropriately
- [ ] Logo carousel wraps or stacks
- [ ] Image compositions reposition
- [ ] Footer grid stacks
- [ ] Forms remain usable

---

## 6. Functional Testing

### Component Functionality

| Component | Test | Status |
|-----------|------|--------|
| Header | Mobile toggle works | [ ] |
| Header | Dropdowns open/close | [ ] |
| Header | Sticky on scroll | [ ] |
| Logo Carousel | Auto-scrolls | [ ] |
| Logo Carousel | Pauses on hover | [ ] |
| Cards | Hover states work | [ ] |
| Cards | Links functional | [ ] |
| CTAs | Click/tap works | [ ] |
| Forms | Validation works | [ ] |
| Forms | Submit works | [ ] |

### WordPress Functionality

- [ ] Customizer preview works
- [ ] Menu editing works
- [ ] Theme switching works
- [ ] Custom post types display
- [ ] Shortcodes render
- [ ] Widgets display correctly

---

## Testing Tools

### Automated

```bash
# Lighthouse CLI
npm install -g lighthouse
lighthouse https://localhost/aitsc-wp --view

# Pa11y (accessibility)
npm install -g pa11y
pa11y https://localhost/aitsc-wp

# axe-core
npx axe https://localhost/aitsc-wp
```

### Manual

- Chrome DevTools Device Mode
- Firefox Responsive Design Mode
- BrowserStack (cross-browser)
- WAVE Browser Extension (accessibility)
- ColorZilla (contrast checking)

---

## Bug Tracking

### Critical (Blockers)
- [ ] _No issues_

### High
- [ ] _No issues_

### Medium
- [ ] _No issues_

### Low
- [ ] _No issues_

---

## Sign-off Checklist

Before deployment approval:

- [ ] All visual regression tests pass
- [ ] Lighthouse Performance > 85
- [ ] Lighthouse Accessibility > 95
- [ ] All WCAG 2.1 AA requirements met
- [ ] All breakpoints tested
- [ ] Cross-browser testing complete
- [ ] All functional tests pass
- [ ] No critical/high bugs open
- [ ] Client preview approval received

---

## Rollback Plan

If critical issues found post-deployment:

1. Restore backup files:
   ```bash
   cp -r style.css.dark-backup style.css
   cp -r components-dark-backup/ components/
   cp -r templates-dark-backup/ ./
   ```

2. Clear caches (browser, CDN, WordPress)

3. Verify dark theme renders

4. Document issues for fix iteration
