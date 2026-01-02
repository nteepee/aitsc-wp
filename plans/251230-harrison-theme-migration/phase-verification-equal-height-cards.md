# Phase: Equal-Height Cards Verification
# Visual Testing & Documentation Update

**Plan**: 251230-harrison-theme-migration
**Phase**: Verification
**Created**: 2024-12-31
**Status**: READY FOR EXECUTION
**Priority**: MEDIUM

---

## Context

Pre-implementation verification revealed **equal-height fix ALREADY IMPLEMENTED** in codebase:
- ✅ `.h-100` utility class exists (style.css:266)
- ✅ Grid has `align-items: stretch` (style.css:912)
- ✅ Cards have `height: 100%` (card-variants.css:33)

Previous analysis report (`grid-card-height-analysis.md`) based on outdated codebase state.

**Current Task**: Visual verification to confirm implementation working correctly.

---

## Objectives

1. Visually verify equal-height cards working on homepage
2. Test responsive breakpoints (mobile/tablet/desktop)
3. Validate all card variants render correctly
4. Update documentation if discrepancies found
5. Archive or update outdated analysis report

---

## Implementation Plan

### Phase 1: Visual Verification (Primary)

#### Task 1.1: Homepage Screenshot (Desktop)

**Tool**: chrome-devtools skill
**Action**: Capture homepage at desktop resolution

```bash
cd ~/.claude/skills/chrome-devtools/scripts
node screenshot.js \
  --url http://localhost:8888/aitsc-wp/ \
  --viewport 1440x900 \
  --output ../../../docs/screenshots/equal-height-verification-desktop.png \
  --wait-until networkidle2
```

**Validation Criteria**:
- Services section (4-col grid): All cards same height
- Benefits section (3-col grid): All cards same height
- Blog posts section (3-col grid): All cards same height

**Success**: Cards in same row have identical heights
**Failure**: Unequal heights → investigate CSS conflicts

---

#### Task 1.2: Responsive Screenshots

**Mobile** (375×667):
```bash
node screenshot.js \
  --url http://localhost:8888/aitsc-wp/ \
  --viewport 375x667 \
  --output ../../../docs/screenshots/equal-height-verification-mobile.png
```

**Tablet** (768×1024):
```bash
node screenshot.js \
  --url http://localhost:8888/aitsc-wp/ \
  --viewport 768x1024 \
  --output ../../../docs/screenshots/equal-height-verification-tablet.png
```

**Validation**:
- Mobile: Single column (no height issues)
- Tablet: 2-column layout, equal heights
- Desktop: Full grid, equal heights

---

#### Task 1.3: Visual Inspection

**Read screenshots** using Read tool:
1. Verify card alignment
2. Check for "jagged" layouts
3. Confirm CTA buttons aligned at bottom
4. Validate spacing consistency

**Decision Point**:
- ✅ All equal → Task complete
- ❌ Unequal heights → Proceed to Phase 2 (debugging)

---

### Phase 2: Debugging (Conditional)

**Trigger**: Visual verification fails (unequal heights detected)

#### Task 2.1: Browser DevTools Inspection

```bash
node evaluate.js \
  --url http://localhost:8888/aitsc-wp/ \
  --script "
    const grid = document.querySelector('.aitsc-grid--4-col');
    const cards = grid.querySelectorAll('.aitsc-card');
    Array.from(cards).map(card => ({
      height: card.offsetHeight,
      computedHeight: getComputedStyle(card).height,
      parentHeight: card.parentElement.offsetHeight,
      hasH100: card.classList.contains('h-100')
    }));
  "
```

**Analyze**:
- Are cards using `.h-100` class?
- Does grid have `align-items: stretch`?
- Are card heights actually 100%?

---

#### Task 2.2: CSS Audit

**Check for conflicts**:
```bash
cd /Applications/MAMP/htdocs/aitsc-wp
grep -n "\.aitsc-card" wp-content/themes/aitsc-pro-theme/**/*.css
grep -n "align-items" wp-content/themes/aitsc-pro-theme/style.css
grep -n "\.h-100" wp-content/themes/aitsc-pro-theme/style.css
```

**Look for**:
- Overriding `height` rules
- Conflicting `align-items` values
- Media query edge cases

---

#### Task 2.3: Template Audit

**Verify `.h-100` usage in templates**:
```bash
grep -n "aitsc_render_card" wp-content/themes/aitsc-pro-theme/front-page.php
```

**Check**:
- All card calls include `'custom_class' => 'h-100'`
- No inline styles overriding height
- Grid wrappers properly structured

---

### Phase 3: Documentation Update

#### Task 3.1: Update Usage Guides

**Files**:
- `components/grid/GRID-USAGE-GUIDE.md`
- `components/card/CARD-USAGE-GUIDE.md`

**Changes**:
- Add troubleshooting section if issues found
- Update examples with verified patterns
- Add screenshot references
- Document any edge cases discovered

---

#### Task 3.2: Archive Analysis Report

**File**: `plans/251230-harrison-theme-migration/reports/grid-card-height-analysis.md`

**Options**:
1. **Archive**: Move to `reports/archive/` with timestamp
2. **Update**: Add "IMPLEMENTED" stamp at top
3. **Delete**: If no longer relevant

**Recommended**: Archive with implementation date

---

### Phase 4: Documentation

#### Task 4.1: Create Verification Report

**File**: `plans/251230-harrison-theme-migration/reports/visual-verification-251231.md`

**Contents**:
- Screenshot results
- Responsive testing outcomes
- Card variant validation
- Issues found (if any)
- Resolution steps taken
- Final status

---

## File Changes

### Files to Read
- `wp-content/themes/aitsc-pro-theme/style.css` (verify grid styles)
- `wp-content/themes/aitsc-pro-theme/components/card/card-variants.css` (verify card styles)
- `wp-content/themes/aitsc-pro-theme/front-page.php` (verify template usage)

### Files to Write
- `docs/screenshots/equal-height-verification-desktop.png`
- `docs/screenshots/equal-height-verification-mobile.png`
- `docs/screenshots/equal-height-verification-tablet.png`
- `plans/251230-harrison-theme-migration/reports/visual-verification-251231.md`

### Files to Potentially Update
- `components/grid/GRID-USAGE-GUIDE.md` (if issues found)
- `components/card/CARD-USAGE-GUIDE.md` (if issues found)
- `plans/251230-harrison-theme-migration/reports/grid-card-height-analysis.md` (archive/update)

---

## Dependencies

### Required Tools
- ✅ chrome-devtools skill (screenshot.js, evaluate.js)
- ✅ Read tool (screenshot inspection)
- ✅ Grep tool (code searches)
- ✅ Bash tool (script execution)

### Prerequisites
- ✅ Local dev server running (http://localhost:8888/aitsc-wp/)
- ✅ Homepage accessible
- ✅ All card variants present on homepage

---

## Success Criteria

### Primary Success
- [ ] Desktop screenshot shows equal-height cards
- [ ] Mobile screenshot shows proper single-column layout
- [ ] Tablet screenshot shows equal-height 2-column cards
- [ ] All card variants (white-feature, white-minimal, blog) working

### Secondary Success
- [ ] Documentation updated with findings
- [ ] Troubleshooting guide added (if needed)
- [ ] Analysis report archived/updated
- [ ] Verification report created

---

## Risk Assessment

### Low Risk
- Visual verification only (no code changes)
- Read-only operations
- Screenshot generation safe

### Medium Risk
- Implementation might have edge cases not visible on homepage
- Responsive testing limited to 3 breakpoints
- Other pages might have different card usage patterns

### Mitigation
- Test multiple pages if homepage passes
- Document any edge cases for future reference
- Add troubleshooting guide to usage docs

---

## Timeline Estimate

- **Phase 1** (Visual Verification): 10-15 min
- **Phase 2** (Debugging, if needed): 20-30 min
- **Phase 3** (Documentation): 10-15 min
- **Phase 4** (Reporting): 5-10 min

**Total**: 15-30 min (if verification passes) or 45-70 min (if debugging needed)

---

## Execution Steps

1. Verify local dev server running
2. Execute Task 1.1 (desktop screenshot)
3. Read screenshot, inspect visually
4. If equal heights confirmed:
   - Execute Task 1.2 (responsive screenshots)
   - Read and validate
   - Skip Phase 2 (debugging)
   - Proceed to Phase 3 (documentation)
5. If unequal heights found:
   - Execute Phase 2 (debugging)
   - Fix identified issues
   - Re-run Phase 1 (verification)
6. Create verification report (Phase 4)
7. Update documentation (Phase 3)
8. Mark task complete

---

## Rollback Plan

**If verification fails and debugging doesn't resolve**:

1. Revert to known-good commit (if applicable)
2. Re-apply original analysis recommendations:
   - Add `.h-100` class
   - Add `align-items: stretch` to grid
   - Add `height: 100%` to card base
3. Test incrementally
4. Document findings

---

## Next Phase

**After verification completes**:

1. **If passes**: Mark equal-height task as COMPLETE
2. **If fails**: Create bug fix task with findings
3. **Always**: Update project documentation

---

## Unresolved Questions

1. Should we test all pages or just homepage?
2. Should we add automated visual regression tests?
3. Should we create a dedicated test page with all card variants?
4. How should we handle future card variant additions?

---

**Plan Created**: 2024-12-31
**Ready for Execution**: YES
**Blocking Issues**: NONE
