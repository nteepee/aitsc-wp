# Phase 02.5: Development Environment Setup & Codebase Review

**Date:** 2026-01-06
**Parent:** [phase-02-gp-setup.md](./phase-02-gp-setup.md)
**Status:** 🔄 IN PROGRESS
**Priority:** CRITICAL

---

## Environment Context

**Working Directory:** `/Applications/MAMP/htdocs/aitsc-wp copy/`
- This is a **copy** of `aitsc-wp` (created Jan 6, 02:37)
- **Production site:** `aitsc-wp` (untouched, safe)
- **Development site:** `aitsc-wp copy` (safe to test)

**Advantages:**
- ✅ No risk to production
- ✅ Can test theme switching safely
- ✅ Can break things during migration
- ✅ Rollback by re-copying if needed

---

## MAMP Database Setup

### Current Issue
- WordPress config points to MAMP MySQL socket
- MariaDB (Homebrew) is running instead
- Need to configure MAMP properly or update wp-config

### Option A: Use MAMP MySQL (Recommended)
1. Open MAMP application
2. Click "Start Servers"
3. MAMP MySQL runs on socket: `/Applications/MAMP/tmp/mysql/mysql.sock`
4. No config changes needed

### Option B: Use Homebrew MariaDB
Update `wp-config.php`:
```php
define('DB_HOST', '127.0.0.1:3306'); // TCP instead of socket
```

---

## Step 1: Verify Development Environment (15 min)

```bash
# 1.1 Check MAMP status
ps aux | grep -i mysqld | grep -v grep

# 1.2 Verify both installations exist
ls -la "/Applications/MAMP/htdocs/aitsc-wp/wp-content/themes/"
ls -la "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/"

# 1.3 Check child theme only exists in copy
diff "/Applications/MAMP/htdocs/aitsc-wp/wp-content/themes/" \
     "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/"
```

**Expected:**
- MAMP MySQL running
- Original has no aitsc-gp-child
- Copy has aitsc-gp-child

---

## Step 2: Codebase Deep Dive Review (2 hours)

### 2.1 Original Theme Architecture Review

**Files to Analyze:**
```
/wp-content/themes/aitsc-pro-theme/
├── Root templates (15 files)
├── Components (16 files)
├── Includes (15 files)
├── Customizer panels (8 files)
└── Template parts (22 files)
```

**Check:**
- [ ] Which templates are actually used?
- [ ] Which components are actively used?
- [ ] Are there custom page templates being used?
- [ ] What shortcodes are in content?
- [ ] Any hardcoded theme dependencies?

### 2.2 Database Content Audit

```sql
-- Check active theme
SELECT option_value FROM wp_options WHERE option_name = 'template';
SELECT option_value FROM wp_options WHERE option_name = 'stylesheet';

-- Check CPT usage
SELECT post_type, COUNT(*) FROM wp_posts GROUP BY post_type;

-- Check pages using custom templates
SELECT post_title, meta_value
FROM wp_posts p
JOIN wp_postmeta pm ON p.ID = pm.post_id
WHERE pm.meta_key = '_wp_page_template';

-- Check for shortcodes in content
SELECT post_type, COUNT(*) FROM wp_posts WHERE post_content LIKE '%[%' GROUP BY post_type;
```

### 2.3 Active Plugins Review

**Check:**
- [ ] ACF Pro installed?
- [ ] Any page builders active?
- [ ] CPT UI plugins?
- [ ] Caching plugins?
- [ ] Any theme-dependent plugins?

---

## Step 3: Dependency Mapping (1 hour)

### 3.1 Template Usage Map

Create mapping of:
```
Front Page → template: front-page.php (custom)
About → template: page-about-aitsc.php (custom)
Contact → template: page-contact.php (custom)
Fleet Safe Pro → template: page-fleet-safe-pro.php (custom)
Solutions → CPT archive
Case Studies → CPT archive
```

### 3.2 Component Usage Map

Scan content for shortcodes:
```bash
# Find all shortcodes in database
mysql -u root -proot aitsctest_wp -e "
SELECT DISTINCT SUBSTRING_INDEX(SUBSTRING_INDEX(post_content, '[', -1), ']', 1) as shortcode
FROM wp_posts
WHERE post_content LIKE '%[%'
GROUP BY shortcode
"
```

### 3.3 ACF Field Usage

Check which fields are populated:
```sql
SELECT pm.meta_key, COUNT(*) as usage_count
FROM wp_postmeta pm
WHERE pm.meta_key LIKE 'field_%' OR pm.meta_key LIKE '%hero%' OR pm.meta_key LIKE '%overview%'
GROUP BY pm.meta_key
ORDER BY usage_count DESC
LIMIT 50;
```

---

## Step 4: Risk Assessment (30 min)

### High Risk Areas
- [ ] Complex page templates (Fleet Safe Pro - 1350 lines)
- [ ] Custom database queries
- [ ] Hardcoded theme references
- [ ] Direct file includes
- [ ] Global variables

### Medium Risk Areas
- [ ] ACF field dependencies
- [ ] Taxonomy queries
- [ ] Custom image sizes
- [ ] Enqueue dependencies

### Low Risk Areas
- [ ] Standard WordPress functions
- [ ] ACF get_field() calls
- [ ] Standard loops

---

## Step 5: Test Activation (30 min)

### 5.1 Pre-Activation Checklist
- [ ] Backup current database
- [ ] Note active theme
- [ ] Note active plugins
- [ ] Check frontend loads

### 5.2 Activate Child Theme
1. **Via WordPress Admin:**
   - Appearance → Themes → Activate "AITSC GeneratePress Child"
   - Check for errors

2. **Via Database:**
   ```sql
   UPDATE wp_options SET option_value = 'generatepress' WHERE option_name = 'template';
   UPDATE wp_options SET option_value = 'aitsc-gp-child' WHERE option_name = 'stylesheet';
   ```

3. **Verify:**
   - Frontend loads
   - WP Admin accessible
   - No white screens
   - Check debug.log

### 5.3 Post-Activation Checks
- [ ] Homepage loads
- [ ] CPT archives accessible
- [ ] Single CPT pages load
- [ ] No PHP errors in debug.log
- [ ] CPTs still registered
- [ ] ACF fields still accessible

---

## Step 6: Rollback Plan (10 min)

### If Activation Fails

**Option A: Revert via Database**
```sql
UPDATE wp_options SET option_value = 'aitsc-pro-theme' WHERE option_name = 'template';
UPDATE wp_options SET option_value = 'aitsc-pro-theme' WHERE option_name = 'stylesheet';
```

**Option B: Re-copy from Original**
```bash
rm -rf "/Applications/MAMP/htdocs/aitsc-wp copy"
cp -R "/Applications/MAMP/htdocs/aitsc-wp" "/Applications/MAMP/htdocs/aitsc-wp copy"
```

---

## Expected Outcomes

### Success Criteria
- [ ] Child theme activated without errors
- [ ] CPTs visible in WP admin
- [ ] Frontend loads (may look wrong, expected)
- [ ] ACF fields still present
- [ ] No white screens
- [ ] Debug log clean

### Expected Issues (Acceptable)
- ⚠️ Styling broken (expected - no CSS yet)
- ⚠️ Layout wrong (expected - no templates yet)
- ⚠️ Components not rendering (expected - need GB blocks)

### Critical Issues (Must Fix)
- ❌ White screen of death
- ❌ PHP fatal errors
- ❌ CPTs disappeared
- ❌ Database errors
- ❌ Admin inaccessible

---

## Deliverables

1. **Codebase Review Report**
   - Active templates identified
   - Component usage mapped
   - Dependencies documented
   - Risks assessed

2. **Database Audit**
   - CPT usage confirmed
   - ACF data verified
   - Shortcode inventory

3. **Test Activation Results**
   - Screenshots of before/after
   - Debug log findings
   - Issues encountered

4. **Updated Migration Plan**
   - Adjust based on findings
   - Add any missing steps
   - Address discovered dependencies

---

## Next Phase

After successful activation:
→ Proceed to **Phase 03: CPT & ACF Migration**
→ Begin building GP Elements to replace templates

---

**Phase Status:** 🔄 IN PROGRESS
**Estimated Time:** 4 hours
**Risk Level:** LOW (development copy)
