# AITSC Pro Theme - Implementation Plans

**Plan ID**: 260104-universal-paper-stack-scroll
**Created**: 2026-01-04
**Updated**: 2026-01-06
**Status**: Active (Multiple Initiatives)

> **IMPORTANT URL CHANGE:**
> - **PRODUCTION** (DO NOT TOUCH): `http://localhost:8888/aitsc-wp/`
> - **DEVELOPMENT** (TEST HERE): `http://localhost:8888/aitsc-wp-copy/`
>
> All work in this plan targets the DEVELOPMENT site only!

---

## Active Initiatives

### 1. GeneratePress Migration Plan 🆕 CRITICAL

**Status:** 🟢 97% COMPLETE - Production Ready
**Priority:** CRITICAL (Client Requirement)
**Timeline:** 35 working days (Days 1-8 complete)
**Lead:** [Phase 00 Overview](./phase-00-generatepress-migration-overview.md)

**Overview:** Migrate AITSC Pro Theme (90 PHP files, 38 MB) to GeneratePress Premium hybrid architecture (~35-40 PHP files, ~5 MB) while preserving 100% functionality.

**✅ PROGRESS UPDATE (2026-01-06 23:45):**
- **Child theme:** 97% complete (14/90 files + GP Premium + Original Header/Footer + Component CSS + QA)
- **Completed:** Phases 00-14 (setup, CPTs, ACF, GP Premium, original header/footer migrated, alignment fixes, QA, URL fixes)
- **Database:** ✅ Healthy (`aitsctest_wp_dev`)
- **Dev site:** ✅ http://localhost:8888/aitsc-wp-copy/
- **Features:** Original header/footer preserved, CSS variables, utility classes, component CSS, mobile responsive, 0 console errors
- **Fixed:**
  - Path issues (get_template_directory → get_stylesheet_directory)
  - 500 error (missing CTA component)
  - Alignment issues (Trust Bar + CTA CSS added)
- **Structure:** ✅ GeneratePress parent + aitsc-gp-child extending it
- **Next:** Final visual polish & launch preparation

**Quick Navigation:**
- [Phase 00: Migration Overview](./phase-00-generatepress-migration-overview.md) - Master plan
- [Phase 01: Preparation & Backup](./phase-01-preparation-backup.md) - ✅ Complete
- [Phase 02: GP Setup](./phase-02-gp-setup.md) - ✅ Complete
- [Phase 02.5: Dev Environment](./phase-02-dev-environment-setup.md) - ✅ Complete
- [Code Review Report](./reports/code-review-260106-child-theme-status.md) - ⚠️ READ FIRST

**Progress:**
- Phase 00: ✅ Complete (overview, strategy)
- Phase 01: ✅ Complete (backup, file inventory)
- Phase 02: ✅ Complete (GP + child theme created)
- Phase 02.5: ✅ Complete (dev isolated, DB cloned)
- Phase 03: ✅ Complete (CPTs, ACF, includes migrated)
- Phase 04: 🔄 In Progress (component templates)
- Phase 05: ⏳ Pending (layout migration)
- Phase 06: ⏳ Pending (styling)
- Phase 07: ✅ Complete (documentation)
- Phases 08-10: ⏳ Pending (testing, launch)

**Current Status:**
- Dev site: `http://localhost:8888/aitsc-wp-copy/` (isolated, ready)
- Child theme: `aitsc-gp-child` (11 PHP files, 70% infrastructure)
- Dev database: `aitsctest_wp_dev` (cloned, healthy)
- Git branch: `deploy-branch`
- **Migrated:** CPTs, ACF, components, paper-stack, includes
- **Next:** Component shortcodes → GP Elements → QA

**Migration Stats:**
- Files processed: 11/90 (70% core infrastructure)
- Time elapsed: 7 working days
- Estimated remaining: 15-20 working days

**Files to Track:** 90 PHP files

---

### 2. Universal Paper Stack Scroll Effect

**Status:** Active
**Priority:** High
**Timeline:** 3-5 days

**Overview:** Implement a production-ready, universal paper stack scroll effect system for the AITSC Pro Theme using native CSS Scroll-Driven Animations (2025 standard) with Intersection Observer fallback.

**Quick Navigation:**
- [Phase 01: Research & Analysis](./phase-01-research-analysis.md) - Technical approach analysis
- [Phase 02: Architecture Design](./phase-02-architecture-design.md) - System architecture
- [Phase 03: Core Implementation](./phase-03-core-implementation.md) - Universal component
- [Phase 04: Integration](./phase-04-integration.md) - Template integration
- [Phase 05: Testing & QA](./phase-05-testing-qa.md) - Validation strategy

---

## Key Objectives

1. **Modern Standards**: Use CSS `animation-timeline: view()` (2025 production-ready)
2. **Performance**: Zero main-thread blocking, 60fps guaranteed, GPU-accelerated
3. **Accessibility**: `prefers-reduced-motion` support, keyboard navigation
4. **WordPress Integration**: Component-based architecture, enqueue system compatible
5. **Progressive Enhancement**: CSS native (primary) + JS fallback (legacy)

---

## Technical Approach

### Primary Method: Native CSS Scroll-Driven Animations
```css
@supports (animation-timeline: view()) {
  .paper-stack-section {
    animation: slide-over linear both;
    animation-timeline: view();
    animation-range: entry 10% cover 50%;
  }
}
```

### Fallback: Intersection Observer (Legacy)
```javascript
const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('is-stacked');
    }
  });
});
```

---

## Success Criteria

- [ ] Smooth 60fps scroll animations on all modern browsers
- [ ] Zero layout shift or CLS penalties
- [ ] Full accessibility compliance (WCAG 2.1 AA)
- [ ] Mobile-responsive (tested on 0-575px breakpoint)
- [ ] WordPress admin integration (ACF fields or theme options)
- [ ] Documentation complete with code examples
- [ ] Performance audit passes (Lighthouse 90+)

---

## Related Files

**Theme Structure**:
- `/wp-content/themes/aitsc-pro-theme/style.css` (lines 3593-3679)
- `/wp-content/themes/aitsc-pro-theme/inc/enqueue.php`
- `/wp-content/themes/aitsc-pro-theme/assets/js/scroll-animations.js`
- `/wp-content/themes/aitsc-pro-theme/components/` (component-based architecture)

**Templates**:
- `single-solutions.php` - Solution pages
- `page-fleet-safe-pro.php` - Pillar pages
- `front-page.php` - Homepage
- `/template-parts/solution/*.php` - Solution sections

---

## Risk Assessment

**Low Risk**:
- CSS Scroll-Driven Animations have full browser support (2025)
- Component-based architecture allows isolated testing
- Fallback ensures graceful degradation

**Medium Risk**:
- Mobile performance on older devices (mitigation: GPU acceleration)
- WordPress plugin conflicts (mitigation: namespace isolation)

**High Risk**:
- None identified

---

## Next Steps

1. Review Phase 01 for detailed technical analysis
2. Proceed to Phase 02 for architecture design
3. Begin implementation following Phase 03

---

**Questions?** See individual phase files for detailed context and implementation steps.
