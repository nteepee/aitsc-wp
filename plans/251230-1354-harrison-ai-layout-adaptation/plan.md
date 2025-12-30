# Harrison.ai Layout Adaptation Plan

**Plan ID**: 251230-1354-harrison-ai-layout-adaptation
**Created**: 2025-12-30
**Status**: PLANNING
**Complexity**: High (6 phases, ~40 tasks)

---

## Executive Summary

Adapt Harrison.ai's healthcare/AI aesthetic to AITSC WordPress theme while maintaining existing universal component architecture. Transform from WorldQuant-inspired dark tech to clean, professional medical/safety aesthetic.

---

## Current State Analysis

| Aspect | Current (WorldQuant) | Target (Harrison.ai) |
|--------|---------------------|----------------------|
| Background | #000000 dark panels | Clean white/light gray |
| Accent | Blue #1863F7 | Medical Blue #3B82F6 |
| Typography | Manrope/Inter | Lexend/Poppins |
| Hero | Centered text, particles | Full-width imagery + overlay |
| Layout | Grid-based dark | Two/three-column asymmetric |
| Components | 7 card, 4 hero, 4 CTA | Add: Logo carousel, Product UI |

---

## Phase Overview

| Phase | Document | Status | Est. Effort |
|-------|----------|--------|-------------|
| 1 | [Design System Update](./phase-01-design-system-update.md) | Pending | 8h |
| 2 | [Hero Component Evolution](./phase-02-hero-component-evolution.md) | Pending | 6h |
| 3 | [Layout Patterns](./phase-03-layout-patterns.md) | Pending | 8h |
| 4 | [Component Enhancement](./phase-04-component-enhancement.md) | Pending | 10h |
| 5 | [Typography Update](./phase-05-typography-update.md) | Pending | 4h |
| 6 | [Trust Signals](./phase-06-trust-signals.md) | Pending | 6h |

**Total Estimated**: 42 hours

---

## Key Constraints

1. **Backward Compatible** - Must not break existing templates
2. **Component Reuse** - Extend, don't replace existing components
3. **Theme Switching** - Support both dark (legacy) and light (new) modes
4. **Mobile-First** - Maintain 5 breakpoint responsive system
5. **WCAG 2.1 AA** - Preserve accessibility compliance

---

## Risk Summary

| Risk | Impact | Mitigation |
|------|--------|------------|
| CSS variable conflicts | High | Namespace with `--hai-*` prefix |
| Component API changes | High | Version components, deprecation warnings |
| Typography metric shifts | Medium | Test all templates post-migration |
| Performance regression | Medium | CSS-in-CSS loading, no JS overhead |

---

## Success Criteria

- [ ] All 6 phases completed with verification
- [ ] Zero regression in existing page templates
- [ ] Lighthouse Performance score > 85
- [ ] WCAG 2.1 AA accessibility maintained
- [ ] Component documentation updated

---

## Quick Links

- [Phase 1: Design System](./phase-01-design-system-update.md)
- [Phase 2: Hero Evolution](./phase-02-hero-component-evolution.md)
- [Phase 3: Layout Patterns](./phase-03-layout-patterns.md)
- [Phase 4: Components](./phase-04-component-enhancement.md)
- [Phase 5: Typography](./phase-05-typography-update.md)
- [Phase 6: Trust Signals](./phase-06-trust-signals.md)
