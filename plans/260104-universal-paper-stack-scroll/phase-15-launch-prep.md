# Phase 15: Launch Preparation

**Date:** 2026-01-06
**Status:** READY TO START
**Priority:** CRITICAL
**Parent Plan:** [plan.md](./plan.md)

---

## Overview

Complete final tasks for production launch of AITSC GeneratePress child theme.

**Current Status:**
- 97% complete (Phases 00-14 done)
- Dev site: http://localhost:8888/aitsc-wp-copy/
- 0 console errors
- All core pages working

---

## Tasks (Can run in parallel)

### Task 1: Final QA & Testing
**Agent:** tester
**File:** `reports/final-qa-report-260106.md`
**Duration:** ~15 min

**Checklist:**
- [ ] Homepage fully loads (hero, trust bar, services, CTA, footer)
- [ ] Single Solution page working
- [ ] Solutions archive page working
- [ ] Contact page working
- [ ] Mobile responsive @ 375x667
- [ ] All navigation links functional
- [ ] No 500 errors in PHP logs
- [ ] 0 console errors

### Task 2: Clean Up Dev Files
**Agent:** fullstack-developer
**Duration:** ~10 min

**Files to Remove:**
- inc/aitsc-content-data.php (dev only)
- inc/content-seeder.php (dev only)
- template-parts/theme-toggle.php (not needed)
- Test files in root

**Files to Clean in functions.php:**
- Remove debug code
- Remove unused hooks
- Optimize enqueues

### Task 3: Documentation Update
**Agent:** docs-manager
**Duration:** ~10 min

**Documents to Update:**
- README.md in child theme
- SETUP-GUIDE.md (if exists)
- Create CHANGELOG.md

### Task 4: Git Commit & Push
**Agent:** git-manager
**Duration:** ~5 min

**Actions:**
- Stage all changes
- Commit with proper message
- Push to deploy-branch

---

## Execution Order

1. **Parallel (3 agents):** Task 1 (QA), Task 2 (Cleanup), Task 3 (Docs)
2. **Sequential:** Wait for all 3 to complete
3. **Sequential:** Task 4 (Git commit)
4. **Manual:** User review and approval

---

## Success Criteria

- [ ] All QA checks pass
- [ ] Dev files removed
- [ ] Documentation complete
- [ ] Git commit ready
- [ ] User approves for production deployment

---

## File Ownership

| Task | File | Owner |
|------|------|-------|
| QA | reports/final-qa-report-260106.md | tester |
| Cleanup | inc/, template-parts/, functions.php | fullstack-developer |
| Docs | README.md, CHANGELOG.md | docs-manager |
| Git | N/A | git-manager |
