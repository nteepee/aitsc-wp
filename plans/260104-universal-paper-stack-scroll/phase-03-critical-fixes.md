# Phase 03: Critical Fixes & Template Migration

**Status:** 🔄 IN PROGRESS
**Priority:** CRITICAL
**Dependencies:** Phase 02.5 Complete
**Estimated Time:** 4-6 hours

---

## Objective

Fix all critical blockers preventing child theme activation and migrate essential templates.

---

## Critical Issues to Fix

### 1. Missing index.php (BLOCKER)
**Issue:** WordPress requires index.php fallback
**Fix:** Copy from GeneratePress parent theme

### 2. Component Loading No Guards (BLOCKER)
**Issue:** 14 component requires have no file_exists() checks
**Fix:** Add guards to inc/components.php

### 3. Missing Helper Functions (BLOCKER)
**Issue:** Contact form calls undefined functions
**Fix:** Add placeholder functions to inc/template-tags.php

### 4. Activation Hook Wrong Context (BLOCKER)
**Issue:** CPT flush won't fire (__FILE__ wrong)
**Fix:** Move to functions.php

### 5. No Theme Setup (HIGH)
**Issue:** No after_setup_theme, menus, widgets
**Fix:** Add theme setup to functions.php

---

## Implementation Steps

### Step 1: Copy index.php (5 min)
```bash
cp /Applications/MAMP/htdocs/aitsc-wp-copy/wp-content/themes/generatepress/index.php \
   /Applications/MAMP/htdocs/aitsc-wp-copy/wp-content/themes/aitsc-gp-child/
```

### Step 2: Fix Component Guards (1 hour)
**File:** inc/components.php
**Lines:** 27-62
**Action:** Wrap all require_once with file_exists()

### Step 3: Add Helper Functions (30 min)
**File:** inc/template-tags.php
**Action:** Add aitsc_get_service_categories(), aitsc_get_contact_info()

### Step 4: Fix Activation Hook (30 min)
**File:** functions.php
**Action:** Move CPT activation hook, fix __FILE__ context

### Step 5: Add Theme Setup (1 hour)
**File:** functions.php
**Action:** Add after_setup_theme hook, register menus, theme support

### Step 6: Copy Essential Templates (2 hours)
**Templates to copy:**
- single-solutions.php
- single-case-studies.php
- archive-solutions.php
- archive-case-studies.php
- page-fleet-safe-pro.php
- page-contact.php

### Step 7: Verify Activation (30 min)
- Activate child theme
- Check frontend loads
- Verify CPTs accessible
- Check ACF fields display

---

## Success Criteria

- [ ] Child theme activates without errors
- [ ] Frontend loads (styling may be wrong)
- [ ] CPT archives accessible
- [ ] Single CPT pages load
- [ ] ACF fields display in admin
- [ ] No PHP fatal errors

---

## Post-Phase 03

If successful:
→ Proceed to Phase 04: Component Migration
→ Build GP Elements for remaining templates

If blocked:
→ Reassess strategy (GP Elements vs. Hybrid)
