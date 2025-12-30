# AITSC Codebase Consistency Audit - Implementation Guide

**Plan Created**: 2025-12-29
**Status**: Ready for Implementation
**Total Effort**: 18-24 hours (2-3 weeks moderate pace)

---

## Quick Navigation

- **[Main Plan](./plan.md)** - Overview, budget, timeline, success criteria
- **[Phase 1: Breakpoints](./phase-1-breakpoint-standardization.md)** - 17→5 breakpoints, CSS custom properties
- **[Phase 2: Cards](./phase-2-card-consolidation.md)** - 4→1 card system, BEM naming
- **[Phase 3: Grids](./phase-3-responsive-grid-fixes.md)** - 51 grids→utility classes
- **[Phase 4: Typography](./phase-4-typography-unification.md)** - Fluid type, remove !important
- **[Phase 5: Sliders](./phase-5-slider-improvements.md)** - Swiper.js, accessibility

---

## Phase Summary

| Phase | Priority | Effort | Dependencies | Risk |
|-------|----------|--------|--------------|------|
| 1. Breakpoints | CRITICAL | 4-6h | None | Medium |
| 2. Cards | HIGH | 6-8h | Phase 1 | High |
| 3. Grids | HIGH | 4-6h | Phase 1 | Medium |
| 4. Typography | MEDIUM | 3-4h | Phase 1 | Medium |
| 5. Sliders | MEDIUM | 4-6h | Phase 2 | Medium |

**Total**: 21-30 hours

---

## Before You Start

### Prerequisites Checklist

- [ ] Full database backup created
- [ ] Full theme files backup created
- [ ] Staging environment configured
- [ ] Git repository clean (no uncommitted changes)
- [ ] Browser testing tools ready (Chrome DevTools, Firefox Dev Edition)
- [ ] Stakeholder approval received

### Required Tools

- **Code Editor**: VS Code, PhpStorm, or similar
- **Version Control**: Git (command line or GUI)
- **Local Server**: MAMP, Local by Flywheel, or similar (running)
- **Browser DevTools**: Chrome, Firefox, Safari dev tools
- **Optional**: Visual regression testing (Percy, BackstopJS)

---

## Execution Strategy

### Recommended Approach: Sequential Implementation

**Week 1**:
- Days 1-2: Phase 1 (Breakpoints)
- Days 3-5: Phase 2 (Cards)

**Week 2**:
- Days 1-2: Phase 3 (Grids)
- Days 3-4: Phase 4 (Typography)
- Day 5: Integration testing

**Week 3**:
- Days 1-3: Phase 5 (Sliders)
- Days 4-5: Final QA, documentation, client review

### Alternative: Parallel (Advanced)

**Only if multiple developers available**:
- Dev 1: Phase 1 + Phase 3 (both responsive, no conflicts)
- Dev 2: Phase 2 + Phase 5 (both components, sequential)
- Dev 3: Phase 4 (independent)

**Merge Strategy**: Phase 1 first, then 3, then 2, then 5, then 4.

---

## Daily Workflow

### Start of Day

```bash
# Pull latest changes
git pull origin main

# Create feature branch for phase
git checkout -b feature/phase-X-name

# Verify local environment running
# (MAMP, Local, etc.)
```

### During Implementation

```bash
# Commit frequently (hourly or after each subtask)
git add .
git commit -m "feat(phase-X): Descriptive message"

# Push to remote (backup + collaboration)
git push origin feature/phase-X-name
```

### End of Day

```bash
# Run tests (if applicable)
# Visual check all affected pages
# Push final commits
git push origin feature/phase-X-name

# Update progress tracking (optional)
# Post status update to team
```

---

## Testing Protocol

### Per-Phase Testing

After completing each phase:

1. **Visual Regression**:
   - Load all affected pages
   - Test at each breakpoint (375px, 768px, 992px, 1200px, 1920px)
   - Screenshot comparison (manual or tool)

2. **Functionality**:
   - Interactive elements work (buttons, links, hover states)
   - Animations smooth (no jank)
   - Forms submit correctly

3. **Cross-Browser**:
   - Chrome (latest)
   - Firefox (latest)
   - Safari (latest)
   - Edge (latest)

4. **Accessibility**:
   - Lighthouse audit (score 90+)
   - Keyboard navigation works
   - Screen reader test (NVDA/JAWS)

### Integration Testing (After All Phases)

**Full Site Audit**:
- All pages load without errors
- No visual regressions
- Performance maintained (Lighthouse 90+)
- Accessibility maintained (WCAG 2.1 AA)
- No broken links or 404s

---

## Commit Message Standards

### Format

```
<type>(scope): <description>

[optional body]

[optional footer]
```

### Types

- `feat`: New feature (e.g., `feat(carousel): Add Swiper.js integration`)
- `refactor`: Code restructuring (e.g., `refactor(cards): Consolidate card variants`)
- `fix`: Bug fix (e.g., `fix(grid): Correct gap spacing on mobile`)
- `docs`: Documentation (e.g., `docs(typography): Add type scale guide`)
- `test`: Testing (e.g., `test(carousel): Add accessibility tests`)
- `chore`: Maintenance (e.g., `chore(deps): Update Swiper to v11`)

### Examples

**Good**:
```
feat(breakpoints): Add CSS custom properties for responsive design

- Define 5 canonical breakpoints (mobile, phablet, tablet, desktop, wide)
- Add CSS custom properties to :root
- Document breakpoint usage in code-standards.md
```

**Bad**:
```
Update files
```

---

## Rollback Procedures

### Phase-Level Rollback

**If a phase introduces critical bugs**:

```bash
# Revert all commits in phase
git log --oneline --grep="phase-X"
git revert <commit-hash-1> <commit-hash-2> ...

# OR reset to before phase
git reset --hard <commit-before-phase-X>

# Force push (if already pushed)
git push origin feature/phase-X-name --force

# OR create rollback branch
git checkout -b rollback/phase-X
git push origin rollback/phase-X
```

### File-Level Rollback

**If only specific files broken**:

```bash
# Restore single file from previous commit
git checkout HEAD~1 -- path/to/file.php

# Commit restoration
git commit -m "revert: Restore file.php to previous state"
```

### Emergency Production Rollback

**If deployed and critical issue found**:

```bash
# Option 1: Revert last deployment commit
git revert HEAD
git push origin main

# Option 2: Restore from backup
# (Copy theme files from backup directory)

# Option 3: Restore WordPress from backup
# (Use hosting provider's backup tool)
```

---

## Communication Plan

### Stakeholder Updates

**After Each Phase**:
- Email summary of changes
- Link to staging environment
- Request feedback/approval
- Document any concerns

**Weekly Status**:
- Progress update (phases completed)
- Blockers identified
- ETA for remaining phases
- Budget vs actual time

### Team Communication

**Daily Standup** (if applicable):
- What I did yesterday
- What I'm doing today
- Any blockers

**Code Review**:
- Request review after each phase
- Address feedback promptly
- Document decisions

---

## Troubleshooting Guide

### Common Issues

#### Issue: Breakpoint Changes Break Layout

**Symptoms**: Elements overlap, text cutoff, weird spacing

**Diagnosis**:
```bash
# Check which breakpoint causing issue
# Test at 767px vs 768px (boundary)
```

**Solution**:
1. Review old vs new breakpoint values
2. Check for hardcoded pixel values in CSS
3. Ensure mobile-first approach (min-width not max-width)
4. Test edge cases (767px, 768px, 769px)

---

#### Issue: Card Component Not Rendering

**Symptoms**: Blank space where card should be, PHP errors

**Diagnosis**:
```bash
# Check debug.log
tail -f wp-content/debug.log

# Check browser console
# (Right-click → Inspect → Console)
```

**Solution**:
1. Verify `aitsc_render_card()` function loaded
2. Check function arguments (required fields present?)
3. Ensure component CSS enqueued
4. Clear WordPress cache (WP Rocket, W3 Total Cache, etc.)

---

#### Issue: Grid Utilities Not Applying

**Symptoms**: Grid classes in HTML but layout doesn't change

**Diagnosis**:
```bash
# Check if grid.css loaded
# Browser DevTools → Network tab → CSS
```

**Solution**:
1. Verify `grid.css` enqueued in `inc/enqueue.php`
2. Check CSS file path (correct URI?)
3. Clear browser cache (Ctrl+Shift+R)
4. Check for CSS specificity issues (use DevTools)

---

#### Issue: Swiper Carousel Not Initializing

**Symptoms**: Slides show as vertical list, no navigation

**Diagnosis**:
```javascript
// Browser console
console.log(window.Swiper); // Should be defined
```

**Solution**:
1. Verify Swiper.js loaded (check Network tab)
2. Check `carousel-init.js` enqueued AFTER Swiper
3. Ensure `data-swiper-config` attribute present
4. Check JS console for errors

---

## Performance Optimization

### Before/After Metrics

**Baseline** (before refactoring):
- `style.css`: 3,745 lines
- Media queries: 34+
- Card styles: ~300 lines duplicated
- Grid styles: 51+ declarations

**Target** (after refactoring):
- `style.css`: ~2,600 lines (-30%)
- Media queries: ~15 (only essential)
- Card styles: ~200 lines (unified)
- Grid utilities: ~150 lines (reusable)

### Measurement Tools

- **Lighthouse**: Performance, accessibility, best practices
- **WebPageTest**: Load time, render time, waterfall
- **Chrome DevTools**: Performance profiler, coverage
- **GTmetrix**: PageSpeed insights, recommendations

---

## Documentation Updates Required

### Code Documentation

- [ ] `docs/code-standards.md` - Breakpoint section
- [ ] `docs/design-guidelines.md` - Typography scale
- [ ] `docs/components/card.md` - Card API
- [ ] `docs/utilities/grid.md` - Grid classes
- [ ] `docs/components/carousel.md` - Carousel usage

### Migration Guides

- [ ] Breakpoint migration guide
- [ ] Card component migration guide
- [ ] Grid utility adoption guide
- [ ] Typography update guide

### README Updates

- [ ] Update project README with new component system
- [ ] Add component usage examples
- [ ] Link to new documentation

---

## Success Metrics

### Quantitative Goals

- [ ] Breakpoints: 17 → 5
- [ ] Card implementations: 4 → 1
- [ ] Grid declarations: 51 → ~10 custom + utilities
- [ ] CSS file size: -30%
- [ ] !important usage: -80%

### Qualitative Goals

- [ ] Developers can add features without creating new breakpoints
- [ ] Cards have consistent hover/focus states
- [ ] Grids align consistently
- [ ] Typography scales predictably
- [ ] Sliders have uniform UX

### Validation Criteria

- [ ] All pages render at 5 breakpoints
- [ ] No visual regressions (screenshot comparison)
- [ ] Lighthouse score maintained (90+)
- [ ] WCAG 2.1 AA compliance maintained
- [ ] Cross-browser tests pass

---

## Post-Implementation

### Cleanup Tasks

- [ ] Remove commented-out old code
- [ ] Delete `assets_legacy_backup/` (if confirmed unused)
- [ ] Archive plan documents
- [ ] Update WordPress theme version number
- [ ] Create changelog entry

### Knowledge Transfer

- [ ] Conduct code walkthrough with team
- [ ] Document new patterns in wiki
- [ ] Create video tutorial (optional)
- [ ] Update onboarding docs

### Monitoring

- [ ] Set up performance monitoring (New Relic, Sentry)
- [ ] Monitor error logs for 7 days
- [ ] Track user feedback/bug reports
- [ ] Schedule 30-day retrospective

---

## Questions & Support

### Before Starting

**Questions to resolve**:
1. Browser support: Drop IE11?
2. Legacy CSS: Delete or archive externally?
3. Design approval: Required for typography changes?
4. Testing budget: Allocate time for visual regression?
5. Staging: Environment ready for client previews?

### During Implementation

**Get help if**:
- Blocked for more than 2 hours
- Critical bug introduced
- Unclear how to proceed
- Deadline at risk

**Resources**:
- WordPress Codex: https://developer.wordpress.org/
- Swiper Docs: https://swiperjs.com/
- CSS Tricks: https://css-tricks.com/
- Stack Overflow: https://stackoverflow.com/

---

## Quick Reference

### File Locations

```
wp-content/themes/aitsc-pro-theme/
├── style.css                      # Main stylesheet
├── inc/
│   ├── components.php             # Component registration
│   ├── enqueue.php                # Script/style enqueuing
│   └── custom-post-types.php      # CPT definitions
├── components/
│   ├── card/
│   │   ├── card-base.php
│   │   ├── card-variants.css
│   │   └── card-animations.css
│   ├── carousel/
│   │   ├── carousel-base.php
│   │   └── carousel-styles.css
│   └── ...
├── assets/
│   ├── css/utilities/
│   │   ├── grid.css
│   │   └── typography.css
│   └── js/
│       ├── carousel-init.js
│       └── ...
└── docs/
    ├── code-standards.md
    ├── design-guidelines.md
    └── components/
```

### Key Commands

```bash
# Start local server
# (MAMP: start from GUI)

# Watch CSS changes (if using preprocessor)
npm run watch

# Flush WordPress rewrite rules
wp rewrite flush --hard

# Clear cache
wp cache flush

# Search files
grep -r "pattern" wp-content/themes/aitsc-pro-theme/

# Count lines
wc -l style.css
```

---

## Final Checklist

### Before Merging to Main

- [ ] All phases completed
- [ ] All tests passing
- [ ] Documentation updated
- [ ] Code reviewed and approved
- [ ] Stakeholder approval received
- [ ] Staging deployment successful
- [ ] Performance metrics validated
- [ ] Accessibility audit passed

### Before Production Deployment

- [ ] Database backup created
- [ ] Files backup created
- [ ] Rollback plan documented
- [ ] Deployment checklist prepared
- [ ] Monitoring configured
- [ ] Team notified of deployment
- [ ] Low-traffic deployment window scheduled

---

**Plan Owner**: Development Team
**Primary Contact**: [Your Name/Email]
**Last Updated**: 2025-12-29
**Version**: 1.0

---

*This is a living document. Update as implementation progresses and new information discovered.*
