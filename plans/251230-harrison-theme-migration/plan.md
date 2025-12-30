# Harrison.ai Theme Migration Plan

**Project**: AITSC WordPress Theme - Dark to White Theme Transformation
**Date**: 2025-12-30
**Status**: Planning Complete

---

## Executive Summary

Transform AITSC WordPress theme from WorldQuant-inspired dark design to Harrison.ai-inspired white/light healthcare aesthetic while preserving universal component architecture (80 PHP templates, 5 components).

**Key Constraints**:
- Primary: #005cb2 (AITSC Cyan) - NOT medical blue #3B82F6
- 100% white theme - NO dark mode toggle
- Background: Pure white #FFFFFF
- Maintain component API compatibility

---

## Phase Overview

| Phase | Focus | Est. Files | Priority |
|-------|-------|------------|----------|
| [Phase 1](./phase-1-css-variables.md) | CSS Variable Migration | 8 CSS files | Critical |
| [Phase 2](./phase-2-component-variants.md) | White Component Variants | 5 components | Critical |
| [Phase 3](./phase-3-new-components.md) | New Harrison.ai Components | 3 new | High |
| [Phase 4](./phase-4-navigation.md) | Header/Nav Redesign | 2 files | High |
| [Phase 5](./phase-5-template-updates.md) | Template Migration | 80 PHP files | Medium |
| [Phase 6](./phase-6-testing.md) | Testing & QA | N/A | Critical |

---

## Architecture Documents

- [Component Mapping](./component-mapping.md) - Harrison.ai to AITSC component map
- [CSS Migration Strategy](./css-migration-strategy.md) - Variable replacement guide
- [Testing Protocol](./testing-protocol.md) - QA checklist

---

## Critical Success Metrics

1. Lighthouse Performance > 85
2. WCAG 2.1 AA Compliance (4.5:1 contrast)
3. Zero component API breaking changes
4. All 5 breakpoints verified
5. No dark mode remnants in production CSS
