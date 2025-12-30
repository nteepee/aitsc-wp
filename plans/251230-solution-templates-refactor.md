# Solution Templates Component Standardization Refactor

**Date**: 2025-12-30
**Objective**: Increase component compliance from 65% to 95%+ by refactoring solution templates

## Current State

**Compliance Score**: 65%
- Core Theme: 90% ✓
- Component Definitions: 100% ✓
- Template Implementation: 40% ✗

## Non-Compliant Files (8 files)

### Solution Template Parts (Priority: HIGH)
1. `template-parts/solution/hero.php` - Hardcoded hero HTML
2. `template-parts/solution/overview.php` - Custom overview sections
3. `template-parts/solution/features.php` - Custom feature boxes
4. `template-parts/solution/specs.php` - Custom spec tables
5. `template-parts/solution/ecosystem.php` - Custom ecosystem grid
6. `template-parts/solution/case-studies.php` - Manual card structures

### Other Template Parts (Priority: MEDIUM)
7. `template-parts/single-case-studies.php` - Custom case study layout
8. `template-parts/navigation.php` - Custom nav HTML

## Refactoring Strategy

### Phase 1: Solution Template Standardization (HIGH PRIORITY)

**Files to Refactor**: hero.php, overview.php, features.php, specs.php, ecosystem.php, case-studies.php

**Approach**:
1. Identify hardcoded HTML patterns in each file
2. Map to existing `aitsc_render_*` functions in `inc/components.php`
3. Replace hardcoded HTML with function calls
4. Preserve ACF field mappings and dynamic content
5. Maintain visual consistency with Harrison.ai design

**Expected Functions to Use**:
- `aitsc_render_card()` - For card-based layouts
- `aitsc_component_feature_box()` - For feature sections
- `aitsc_component_spec_table()` - For technical specs
- `aitsc_render_hero()` - For hero sections (if compatible)

### Phase 2: Navigation & Case Studies (MEDIUM PRIORITY)

**Files**: navigation.php, single-case-studies.php

**Approach**:
- Extract reusable navigation patterns into component function
- Refactor case study layout to use card components
- Ensure ARIA compliance maintained

## Success Criteria

✓ All 8 non-compliant files refactored to use `aitsc_render_*` functions
✓ Visual regression test passes (screenshots match pre-refactor)
✓ Component compliance score reaches 95%+
✓ No hardcoded HTML in solution templates
✓ ACF fields properly mapped to component parameters

## Execution Plan

**Approach**: Parallel execution in 2 phases

### Phase 1 Execution (Solution Templates)
- Spawn fullstack-developer agent to refactor 6 solution template parts simultaneously
- Focus: Replace hardcoded HTML with component function calls
- Constraint: Preserve exact visual output and ACF field mappings

### Phase 2 Execution (Navigation & Case Studies)
- Sequential refactor after Phase 1 verification
- Lower priority, can be deferred if time constrained

## Risk Assessment

**Low Risk**: Refactoring uses existing, tested component functions
**Mitigation**: Screenshot comparison before/after to catch visual regressions
**Rollback**: Git allows easy revert if issues arise

## Time Estimate

**Phase 1**: 6 files × parallel execution = ~15 minutes
**Phase 2**: 2 files × sequential = ~10 minutes
**Testing**: Visual regression + compliance check = ~5 minutes
**Total**: ~30 minutes

## Next Steps

1. Spawn fullstack-developer agent for Phase 1 refactoring
2. Verify visual output with screenshot comparison
3. Run component compliance check (should reach 95%+)
4. Proceed to final testing once compliance verified
