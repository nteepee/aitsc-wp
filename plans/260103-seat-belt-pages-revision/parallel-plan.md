# Parallel Execution Plan - 8 Seat Belt Pages Optimization

**Created**: 2026-01-04 00:30
**Type**: Parallel Execution
**Estimated Total Time**: 6-8 hours (wall clock 3-4 hours with parallelism)

---

## Executive Summary

Optimize 8 passenger monitoring pages (IDs 144-151) with CRO content, design integration, images, and responsive polish. Execute in 3 parallel groups to minimize wall clock time.

**Baseline**: CRO Score 3/10 → **Target**: 8/10

---

## Dependency Graph

```
START
  │
  ├─[GROUP A - PARALLEL]────────────────┐
  │   ├─ Phase A1: Content CRO (3-4h)   │
  │   └─ Phase A2: Design Integration (2-3h)
  │                                      │
  ├─[WAIT: GROUP A COMPLETE]────────────┘
  │
  ├─[GROUP B - PARALLEL]────────────────┐
  │   ├─ Phase B1: Image Integration (2h)│
  │   └─ Phase B2: Responsive QA (2h)    │
  │                                      │
  ├─[WAIT: GROUP B COMPLETE]────────────┘
  │
  ├─[GROUP C - SEQUENTIAL]──────────────┐
  │   └─ Phase C1: Meta Tags + Polish (1h)
  │                                      │
  └─[COMPLETE]───────────────────────────┘
```

---

## Parallel Execution Strategy

### GROUP A (Run in Parallel - 3-4h wall clock)

**Phase A1: Content CRO Optimization**
- **Agent**: fullstack-developer
- **Files**: ACF field population via WP-CLI/PHP scripts
- **Pages**: All 8 pages (144-151)
- **Ownership**: Content layer only (no template changes)
- **Tasks**:
  - Write Problem-Solution content (4 problems per page)
  - Rewrite features as benefits (5→10 per page)
  - Add social proof elements
  - Optimize CTAs (urgency language)
  - Create highlight boxes

**Phase A2: Design Integration**
- **Agent**: fullstack-developer
- **Files**: Template files (single-solutions.php, template-parts/*)
- **Pages**: Template applies to all 8
- **Ownership**: Template layer only (no content)
- **Tasks**:
  - Integrate Problem-Solution component into single-solutions.php
  - Integrate Related Pages component
  - Update template structure
  - Add wrapper sections
  - Ensure component rendering

**NO CONFLICTS**: A1 edits ACF data, A2 edits templates

---

### GROUP B (Run in Parallel - 2h wall clock, AFTER Group A)

**Phase B1: Image Integration**
- **Agent**: fullstack-developer
- **Files**: WP media library, ACF image fields
- **Ownership**: Media uploads + ACF image field updates
- **Tasks**:
  - Upload 32 existing images from manifest
  - Generate 24 missing images with ai-multimodal skill
  - Update ACF gallery/hero image fields
  - Verify image rendering

**Phase B2: Responsive QA**
- **Agent**: fullstack-developer (with ui-ux-designer skill)
- **Files**: CSS files (component styles, responsive fixes)
- **Ownership**: CSS layer only
- **Tasks**:
  - Test 5 breakpoints (375px, 576px, 768px, 992px, 1200px+)
  - Fix layout issues
  - Optimize mobile CTAs (thumb zone)
  - Fix text sizes, spacing
  - Add CSS patches if needed

**NO CONFLICTS**: B1 edits media/ACF fields, B2 edits CSS

---

### GROUP C (Run Sequential - 1h, AFTER Group B)

**Phase C1: Meta Tags & Final Polish**
- **Agent**: fullstack-developer
- **Files**: ACF fields (meta_description), header.php
- **Ownership**: SEO layer + final verification
- **Tasks**:
  - Add ACF seo_meta_description field
  - Write 160-char descriptions for all 8 pages
  - Update header.php to output meta tags
  - Final visual QA
  - Generate screenshots

---

## File Ownership Matrix

| File/Layer | Group A1 | Group A2 | Group B1 | Group B2 | Group C1 |
|------------|----------|----------|----------|----------|----------|
| ACF Content Fields | ✅ WRITE | ❌ READ | ❌ READ | ❌ READ | ❌ READ |
| ACF Image Fields | ❌ - | ❌ - | ✅ WRITE | ❌ READ | ❌ READ |
| ACF SEO Fields | ❌ - | ❌ - | ❌ - | ❌ - | ✅ WRITE |
| single-solutions.php | ❌ READ | ✅ WRITE | ❌ READ | ❌ READ | ❌ READ |
| template-parts/* | ❌ - | ✅ WRITE | ❌ - | ❌ READ | ❌ READ |
| Component CSS | ❌ READ | ❌ READ | ❌ READ | ✅ WRITE | ❌ READ |
| header.php | ❌ - | ❌ - | ❌ - | ❌ - | ✅ WRITE |
| WP Media Library | ❌ - | ❌ - | ✅ WRITE | ❌ READ | ❌ READ |

**Legend**: ✅ WRITE (exclusive), ❌ READ (safe), ❌ - (no access)

---

## Phase Files

- `phase-A1-content-cro.md` - Content optimization for 8 pages
- `phase-A2-design-integration.md` - Template integration of components
- `phase-B1-image-integration.md` - Image upload + generation
- `phase-B2-responsive-qa.md` - Responsive testing + fixes
- `phase-C1-meta-polish.md` - SEO meta tags + final polish

---

## Execution Commands

### GROUP A (Launch 2 agents in parallel)
```bash
# Agent A1 - Content CRO
fullstack-developer phase=plans/260103-seat-belt-pages-revision/phase-A1-content-cro.md

# Agent A2 - Design Integration (PARALLEL)
fullstack-developer phase=plans/260103-seat-belt-pages-revision/phase-A2-design-integration.md
```

**Wait for both A1 + A2 to complete**

### GROUP B (Launch 2 agents in parallel)
```bash
# Agent B1 - Image Integration
fullstack-developer phase=plans/260103-seat-belt-pages-revision/phase-B1-image-integration.md

# Agent B2 - Responsive QA (PARALLEL)
fullstack-developer phase=plans/260103-seat-belt-pages-revision/phase-B2-responsive-qa.md
```

**Wait for both B1 + B2 to complete**

### GROUP C (Launch 1 agent sequentially)
```bash
# Agent C1 - Meta Tags + Polish
fullstack-developer phase=plans/260103-seat-belt-pages-revision/phase-C1-meta-polish.md
```

---

## Success Criteria

**Content**:
- [ ] All 8 pages have 4-problem grids
- [ ] All 8 pages have 10 benefit-focused features
- [ ] All 8 pages have solution highlight boxes
- [ ] CTAs use urgency language ("Get MY Free Demo")

**Design**:
- [ ] Problem-Solution component integrated in all pages
- [ ] Related Pages navigation at bottom of all pages
- [ ] Visual consistency across pages
- [ ] No layout errors

**Images**:
- [ ] 32 existing images uploaded to media library
- [ ] 24 missing images generated/sourced
- [ ] All ACF image fields populated
- [ ] No broken images (404)

**Responsive**:
- [ ] Mobile (375px): Text ≥16px, CTAs in thumb zone
- [ ] Tablet (768px): Grids stack properly
- [ ] Desktop (1200px+): Full layout displays
- [ ] No horizontal overflow at any breakpoint

**SEO**:
- [ ] All 8 pages have 160-char meta descriptions
- [ ] header.php outputs <meta name="description">
- [ ] Open Graph images set

**Performance**:
- [ ] No PHP/JS errors in console
- [ ] Page load <3s
- [ ] Animations smooth (60fps)

---

## Risk Mitigation

| Risk | Probability | Impact | Mitigation |
|------|------------|--------|------------|
| WP-CLI fails (DB connection) | Medium | High | Use PHP eval-file as fallback |
| Parallel agents conflict on files | Low | Critical | Strict file ownership matrix enforced |
| Image generation slow (ai-multimodal) | Medium | Medium | Generate subset first, test, then batch |
| Responsive CSS breaks existing | Low | High | Scope CSS to .solution-page class only |
| ACF fields missing/renamed | Low | High | Verify field names before bulk update |

---

## Rollback Strategy

**If Group A fails**:
- Revert ACF field changes via WP-CLI
- Revert template changes via git
- No downstream impact (B, C not started)

**If Group B fails**:
- Images: Delete uploaded media
- CSS: Revert responsive patches
- Content/templates from A still intact

**If Group C fails**:
- Revert header.php changes
- Remove SEO fields
- Everything else functional

---

## Testing Strategy

**Per Phase Testing** (within each agent):
- A1: Verify ACF data via WP-CLI queries
- A2: PHP syntax check, visual inspection
- B1: Check media library, test image URLs
- B2: Screenshot at 5 breakpoints
- C1: View source for meta tags

**Integration Testing** (after all phases):
- Load all 8 pages, verify no errors
- Test responsive at all breakpoints
- Check cross-links navigate correctly
- Lighthouse SEO score >95

---

## Output Artifacts

**Reports** (in `plans/260103-seat-belt-pages-revision/reports/`):
- `fullstack-dev-260104-content-cro.md`
- `fullstack-dev-260104-design-integration.md`
- `fullstack-dev-260104-image-integration.md`
- `fullstack-dev-260104-responsive-qa.md`
- `fullstack-dev-260104-meta-polish.md`

**Screenshots** (in `docs/screenshots/seat-belt-pages-260104/`):
- `{page-slug}-mobile.png`
- `{page-slug}-tablet.png`
- `{page-slug}-desktop.png`

**Git Commits**:
- `feat: Content CRO optimization for 8 seat belt pages`
- `feat: Design integration - Problem-Solution + Related Pages`
- `feat: Image integration - 56 images uploaded/generated`
- `feat: Responsive QA - 5 breakpoints verified`
- `feat: Meta tags + final polish`

---

## Timeline

**Wall Clock Time** (with parallelism):
- GROUP A: 3-4 hours (A1 + A2 in parallel)
- GROUP B: 2 hours (B1 + B2 in parallel)
- GROUP C: 1 hour (sequential)
- **Total**: 6-7 hours wall clock

**Sequential Time** (without parallelism):
- 12-14 hours total

**Time Saved**: 5-7 hours (42-50% reduction)

---

**Plan ready for parallel execution. Launch Group A agents simultaneously.**
