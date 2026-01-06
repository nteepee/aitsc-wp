# Phase 01: Preparation & Backup

**Date:** 2026-01-06
**Parent:** [phase-00-generatepress-migration-overview.md](./phase-00-generatepress-migration-overview.md)
**Priority:** CRITICAL (Blocker)
**Status:** PENDING
**Review Status:** Pending Approval

**Duration:** 2 days (16 hours)
**Dependencies:** None

---

## Context Links

**Parent Plan:** [plan.md](./plan.md)
**Previous:** None (First phase)
**Next:** [phase-02-gp-setup.md](./phase-02-gp-setup.md)

**References:**
- Current Theme: `/wp-content/themes/aitsc-pro-theme/`
- Backup Location: `/backups/pre-migration-[timestamp]/`
- Staging: `staging.aitsc.com` (or local)

---

## Overview

**Description:** Complete site backup, staging setup, and comprehensive audit before any migration work begins.

**Purpose:** Ensure safety net exists, baseline documented, and environment ready for migration work.

**Key Deliverables:**
1. Full site backup (files + database)
2. Staging environment functional
3. Complete file inventory
4. Performance baseline
5. Dependency audit
6. Migration checklist

---

## Key Insights

⚠️ **Critical Path:** Cannot proceed without completed backup
✅ **Quick Win:** File inventory reveals migration scope
🎯 **Focus:** Safety first, nothing else matters until backup verified

---

## Requirements

### Must Have
- [REQ-01] Full database export verified
- [REQ-02] All theme files backed up
- [REQ-03] Staging environment functional
- [REQ-04] Backup can be restored in <5 minutes
- [REQ-05] File inventory complete (90 files tracked)

### Should Have
- [REQ-06] Performance baseline documented
- [REQ-07] Screenshot inventory of all pages
- [REQ-08] Plugin list documented

### Nice to Have
- [REQ-09] Automated backup script
- [REQ-10] Staging sync automation

---

## Architecture

### Backup Architecture
```
Production Site
├── Database Export
│   ├── wp_posts (all content)
│   ├── wp_postmeta (all ACF fields)
│   ├── wp_terms (all taxonomies)
│   └── [All tables]
├── Theme Files
│   ├── aitsc-pro-theme/ (90 PHP files)
│   ├── assets/
│   └── [All theme files]
└── Uploads
    └── wp-content/uploads/

Backup Destination:
/backups/pre-migration-20260106/
├── database.sql
├── theme-files.tar.gz
├── uploads.tar.gz
└── restore-instructions.txt
```

### Staging Architecture
```
Staging Site (Clone of Production)
├── Same database
├── Same theme files
├── Same plugins
├── Same content
└── Isolated for testing
```

---

## Related Code Files

### Files to Audit (All 90)
**Complete file list:** See [phase-00](./phase-00-generatepress-migration-overview.md#file-inventory-tracking)

### Files to Create
1. `/backups/pre-migration-20260106/file-inventory.csv`
2. `/backups/pre-migration-20260106/performance-baseline.txt`
3. `/backups/pre-migration-20260106/plugin-list.txt`
4. `/backups/pre-migration-20260106/active-plugins.txt`

---

## Implementation Steps

### Step 1: File Inventory (2 hours)

**Create comprehensive tracking document:**

```bash
# File: inventory-create.sh
#!/bin/bash

# Create inventory
THEME_PATH="/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-pro-theme"
OUTPUT="/backups/pre-migration-20260106/file-inventory.csv"

echo "File,Lines,Size,Type,Action" > $OUTPUT

# List all PHP files
find $THEME_PATH -name "*.php" -type f | while read file; do
    lines=$(wc -l < "$file")
    size=$(du -h "$file" | cut -f1)
    echo "$file,$lines,$size,PHP," >> $OUTPUT
done

# List CSS files
find $THEME_PATH -name "*.css" -type f | while read file; do
    lines=$(wc -l < "$file")
    size=$(du -h "$file" | cut -f1)
    echo "$file,$lines,$size,CSS," >> $OUTPUT
done

# List JS files
find $THEME_PATH -name "*.js" -type f | while read file; do
    lines=$(wc -l < "$file")
    size=$(du -h "$file" | cut -f1)
    echo "$file,$lines,$size,JS," >> $OUTPUT
done
```

**Output:** `file-inventory.csv` with all files tracked

**Checklist:**
- [ ] All 90 PHP files listed
- [ ] All CSS files listed
- [ ] All JS files listed
- [ ] File sizes recorded
- [ ] Line counts recorded
- [ ] Action column empty (to be filled during migration)

---

### Step 2: Database Backup (2 hours)

**Complete database export:**

```bash
# File: backup-database.sh
#!/bin/bash

BACKUP_DIR="/backups/pre-migration-20260106"
TIMESTAMP=$(date +%Y%m%d-%H%M%S)
DB_NAME="your_database_name"
DB_USER="your_db_user"
DB_PASS="your_db_password"

# Create backup directory
mkdir -p $BACKUP_DIR

# Export database
mysqldump -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" \
    > "$BACKUP_DIR/database-$TIMESTAMP.sql"

# Compress
gzip "$BACKUP_DIR/database-$TIMESTAMP.sql"

# Verify
if [ -f "$BACKUP_DIR/database-$TIMESTAMP.sql.gz" ]; then
    echo "✅ Database backup successful"
    ls -lh "$BACKUP_DIR/database-$TIMESTAMP.sql.gz"
else
    echo "❌ Database backup FAILED"
    exit 1
fi
```

**WordPress CLI alternative:**

```bash
wp db export /backups/pre-migration-20260106/database.sql --path=/Applications/MAMP/htdocs/aitsc-wp\ copy/
gzip /backups/pre-migration-20260106/database.sql
```

**Checklist:**
- [ ] Database export complete
- [ ] File size reasonable (>5MB expected)
- [ ] Compression successful
- [ ] Can open and view SQL file
- [ ] All tables present
- [ ] No error messages in export

**Verify:**
```bash
# Check table count
zcat /backups/pre-migration-20260106/database.sql.gz | grep "CREATE TABLE" | wc -l
# Should match: SHOW TABLES count
```

---

### Step 3: Theme Files Backup (1 hour)

**Backup entire theme directory:**

```bash
# File: backup-theme.sh
#!/bin/bash

BACKUP_DIR="/backups/pre-migration-20260106"
THEME_PATH="/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes/aitsc-pro-theme"

# Create tarball
tar -czf "$BACKUP_DIR/aitsc-pro-theme.tar.gz" \
    -C "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/themes" \
    "aitsc-pro-theme"

# Verify
if [ -f "$BACKUP_DIR/aitsc-pro-theme.tar.gz" ]; then
    echo "✅ Theme backup successful"
    tar -tzf "$BACKUP_DIR/aitsc-pro-theme.tar.gz" | head -20
    echo "..."
    echo "Total files:"
    tar -tzf "$BACKUP_DIR/aitsc-pro-theme.tar.gz" | wc -l
else
    echo "❌ Theme backup FAILED"
    exit 1
fi
```

**Checklist:**
- [ ] Theme tarball created
- [ ] File size reasonable (~38MB)
- [ ] Contains all 90 PHP files
- [ ] Contains all assets
- [ ] Can list contents
- [ ] Can extract (test)

---

### Step 4: Uploads Backup (1 hour)

**Backup all uploaded media:**

```bash
# File: backup-uploads.sh
#!/bin/bash

BACKUP_DIR="/backups/pre-migration-20260106"
UPLOADS_PATH="/Applications/MAMP/htdocs/aitsc-wp copy/wp-content/uploads"

# Create tarball
tar -czf "$BACKUP_DIR/uploads.tar.gz" \
    -C "/Applications/MAMP/htdocs/aitsc-wp copy/wp-content" \
    "uploads"

# Verify
if [ -f "$BACKUP_DIR/uploads.tar.gz" ]; then
    echo "✅ Uploads backup successful"
    echo "Size:"
    ls -lh "$BACKUP_DIR/uploads.tar.gz"
else
    echo "❌ Uploads backup FAILED"
    exit 1
fi
```

**Checklist:**
- [ ] Uploads tarball created
- [ ] All 2026/01/ images included
- [ ] File size reasonable
- [ ] Can list contents

---

### Step 5: Staging Environment Setup (4 hours)

**Create staging site:**

```bash
# Option 1: Clone to staging server
rsync -avz /Applications/MAMP/htdocs/aitsc-wp\ copy/ user@staging-server:/path/to/staging/

# Option 2: Local staging (if using MAMP)
# Duplicate database
# Create new vhost
# Copy files to staging directory
```

**Staging Setup Checklist:**
- [ ] Database cloned to staging
- [ ] Theme files copied to staging
- [ ] Uploads copied (or symlinked)
- [ ] wp-config.php updated (staging URL)
- [ ] Search & Replace URLs (production → staging)
- [ ] .htaccess configured for staging
- [ ] SSL configured (if needed)
- [ ] Staging accessible via URL
- [ ] All pages loading correctly
- [ ] No console errors
- [ ] Forms functional
- [ ] CPTs displaying

**Search & Replace:**
```bash
# Use WP CLI
wp search-replace 'https://aitsc.com' 'https://staging.aitsc.com' \
    --path=/Applications/MAMP/htdocs/aitsc-wp-staging/
```

---

### Step 6: Dependency Audit (2 hours)

**Document all dependencies:**

**Create:** `dependency-audit.txt`

```bash
# File: audit-dependencies.sh
#!/bin/bash

OUTPUT="/backups/pre-migration-20260106/dependency-audit.txt"

echo "=== DEPENDENCY AUDIT ===" > $OUTPUT
echo "Date: $(date)" >> $OUTPUT
echo "" >> $OUTPUT

echo "=== ACTIVE PLUGINS ===" >> $OUTPUT
wp plugin list --path=/Applications/MAMP/htdocs/aitsc-wp\ copy/ >> $OUTPUT

echo "" >> $OUTPUT
echo "=== THEME DEPENDENCIES ===" >> $OUTPUT
echo "From functions.php:" >> $OUTPUT
grep "require_once\|include_once" \
    /Applications/MAMP/htdocs/aitsc-wp\ copy/wp-content/themes/aitsc-pro-theme/functions.php \
    >> $OUTPUT

echo "" >> $OUTPUT
echo "=== ACTIVE THEME ===" >> $OUTPUT
wp theme list --path=/Applications/MAMP/htdocs/aitsc-wp\ copy/ >> $OUTPUT

echo "" >> $OUTPUT
echo "=== PHP VERSION ===" >> $OUTPUT
php -v >> $OUTPUT

echo "" >> $OUTPUT
echo "=== WORDPRESS VERSION ===" >> $OUTPUT
wp core version --path=/Applications/MAMP/htdocs/aitsc-wp\ copy/ >> $OUTPUT

echo "" >> $OUTPUT
echo "=== ACF STATUS ===" >> $OUTPUT
wp plugin status advanced-custom-fields-pro \
    --path=/Applications/MAMP/htdocs/aitsc-wp\ copy/ >> $OUTPUT
```

**Checklist:**
- [ ] All active plugins listed
- [ ] Theme dependencies documented
- [ ] ACF Pro confirmed active
- [ ] PHP version noted (should be 8.0+)
- [ ] WordPress version noted
- [ ] Any conflicts identified

---

### Step 7: Performance Baseline (2 hours)

**Document current performance:**

```bash
# File: baseline-performance.sh
#!/bin/bash

OUTPUT="/backups/pre-migration-20260106/performance-baseline.txt"

echo "=== PERFORMANCE BASELINE ===" > $OUTPUT
echo "Date: $(date)" >> $OUTPUT
echo "" >> $OUTPUT

echo "=== THEME SIZE ===" >> $OUTPUT
du -sh /Applications/MAMP/htdocs/aitsc-wp\ copy/wp-content/themes/aitsc-pro-theme/ >> $OUTPUT

echo "" >> $OUTPUT
echo "=== FILE COUNTS ===" >> $OUTPUT
echo "PHP files:" >> $OUTPUT
find /Applications/MAMP/htdocs/aitsc-wp\ copy/wp-content/themes/aitsc-pro-theme/ \
    -name "*.php" | wc -l >> $OUTPUT

echo "CSS files:" >> $OUTPUT
find /Applications/MAMP/htdocs/aitsc-wp\ copy/wp-content/themes/aitsc-pro-theme/ \
    -name "*.css" | wc -l >> $OUTPUT

echo "JS files:" >> $OUTPUT
find /Applications/MAMP/htdocs/aitsc-wp\ copy/wp-content/themes/aitsc-pro-theme/ \
    -name "*.js" | wc -l >> $OUTPUT

echo "" >> $OUTPUT
echo "=== CSS SIZE ===" >> $OUTPUT
wc -l /Applications/MAMP/htdocs/aitsc-wp\ copy/wp-content/themes/aitsc-pro-theme/style.css >> $OUTPUT

echo "" >> $OUTPUT
echo "=== FUNCTIONS.PHP SIZE ===" >> $OUTPUT
wc -l /Applications/MAMP/htdocs/aitsc-wp\ copy/wp-content/themes/aitsc-pro-theme/functions.php >> $OUTPUT
```

**Manual PageSpeed Testing:**
1. Run PageSpeed Insights on homepage
2. Run PageSpeed Insights on solutions page
3. Run PageSpeed Insights on case studies page
4. Document scores in `performance-baseline.txt`

**Checklist:**
- [ ] Theme size documented (38MB)
- [ ] File counts documented (90 PHP files)
- [ ] CSS size documented (79KB, ~2000 lines)
- [ ] functions.php size documented (~400 lines)
- [ ] PageSpeed Mobile score documented (~50-60)
- [ ] PageSpeed Desktop score documented (~70-80)
- [ ] Load time documented (~3-4s)

---

### Step 8: Screenshot Inventory (2 hours)

**Capture all page layouts:**

**Pages to screenshot:**
1. Homepage
2. About AITSC
3. Contact
4. Fleet Safe Pro
5. Solutions Archive
6. Case Studies Archive
7. Sample Solution (single)
8. Sample Case Study (single)
9. Each solution category taxonomy

**Tool:** Use browser DevTools or automated script

**Checklist:**
- [ ] Homepage screenshot (desktop + mobile)
- [ ] About page screenshot
- [ ] Contact page screenshot
- [ ] Fleet Safe Pro page screenshot
- [ ] Solutions archive screenshot
- [ ] Case studies archive screenshot
- [ ] Single solution screenshot
- [ ] Single case study screenshot
- [ ] All taxonomy pages screenshot
- [ ] Header screenshot
- [ ] Footer screenshot
- [ ] Mobile navigation screenshot

**Save to:** `/backups/pre-migration-20260106/screenshots/`

---

### Step 9: Create Migration Checklist (1 hour)

**Create tracking spreadsheet:**

**File:** `migration-checklist.md`

```markdown
# Migration Checklist

## Files to Process (90 Total)

### Root Templates (15)
- [ ] index.php → Action: Remove (use GP default)
- [ ] single.php → Action: Replace with Content Template
- [ ] single-solutions.php → Action: Replace with Content Template
- [ ] single-case-studies.php → Action: Replace with Content Template
- [ ] page.php → Action: Remove (use GP default)
- [ ] page-about-aitsc.php → Action: Replace with Layout Element
- [ ] page-contact.php → Action: Replace with Layout Element
- [ ] page-fleet-safe-pro.php → Action: Replace with Layout Element
- [ ] front-page.php → Action: Replace with Block Element
- [ ] archive-solutions.php → Action: Replace with Loop Template
- [ ] archive-case-studies.php → Action: Replace with Loop Template
- [ ] taxonomy-solution_category.php → Action: Replace with Loop Template
- [ ] taxonomy-solution_category-passenger-monitoring-systems.php → Action: Replace with Loop Template
- [ ] header.php → Action: Replace with Header Element
- [ ] footer.php → Action: Replace with Footer Element

[... Continue for all 90 files ...]
```

**Checklist:**
- [ ] All 90 files listed
- [ ] Action specified for each
- [ ] Target GP element specified
- [ ] Priority assigned
- [ ] Estimated time per file

---

### Step 10: Rollback Test (1 hour)

**Verify rollback works:**

```bash
# Test restore procedures

# 1. Test database restore
gunzip -c /backups/pre-migration-20260106/database.sql.gz | \
    mysql -u test_user -p test_database

# 2. Test theme restore
mkdir -p /tmp/test-restore
tar -xzf /backups/pre-migration-20260106/aitsc-pro-theme.tar.gz \
    -C /tmp/test-restore

# 3. Verify file integrity
ls -la /tmp/test-restore/aitsc-pro-theme/
# Should show all 90 PHP files present

# 4. Test uploads restore
mkdir -p /tmp/test-uploads
tar -xzf /backups/pre-migration-20260106/uploads.tar.gz \
    -C /tmp/test-uploads

# 5. Cleanup
rm -rf /tmp/test-restore /tmp/test-uploads
```

**Checklist:**
- [ ] Database can be restored
- [ ] Theme files can be extracted
- [ ] All 90 PHP files present in backup
- [ ] Uploads can be extracted
- [ ] Restore time <5 minutes
- [ ] Rollback procedure documented

**Create:** `rollback-procedure.md`

---

## Todo List

### Step 1: File Inventory
- [ ] Run inventory script
- [ ] Verify 90 PHP files listed
- [ ] Verify CSS files listed
- [ ] Verify JS files listed
- [ ] Save inventory CSV

### Step 2: Database Backup
- [ ] Run database export
- [ ] Compress SQL file
- [ ] Verify file integrity
- [ ] Document table count

### Step 3: Theme Files Backup
- [ ] Create theme tarball
- [ ] Verify file size (~38MB)
- [ ] Test extraction
- [ ] Verify all files present

### Step 4: Uploads Backup
- [ ] Create uploads tarball
- [ ] Verify file size
- [ ] Test extraction

### Step 5: Staging Setup
- [ ] Clone database
- [ ] Copy theme files
- [ ] Copy uploads
- [ ] Update wp-config.php
- [ ] Search & replace URLs
- [ ] Verify staging accessible
- [ ] Test all page types
- [ ] Test CPTs
- [ ] Test forms

### Step 6: Dependency Audit
- [ ] List active plugins
- [ ] Document theme dependencies
- [ ] Verify ACF Pro active
- [ ] Check PHP version
- [ ] Check WP version

### Step 7: Performance Baseline
- [ ] Document theme size
- [ ] Count file types
- [ ] Measure CSS size
- [ ] Run PageSpeed tests
- [ ] Document load times

### Step 8: Screenshots
- [ ] Capture homepage
- [ ] Capture all page templates
- [ ] Capture CPT pages
- [ ] Capture taxonomies
- [ ] Capture header/footer
- [ ] Capture mobile views

### Step 9: Migration Checklist
- [ ] List all 90 files
- [ ] Specify action for each
- [ ] Assign priorities
- [ ] Estimate times

### Step 10: Rollback Test
- [ ] Test database restore
- [ ] Test theme restore
- [ ] Test uploads restore
- [ ] Verify all files present
- [ ] Document rollback procedure

---

## Success Criteria

### Phase Success
- [ ] All backups complete and verified
- [ ] Staging environment functional
- [ ] File inventory complete (90 files tracked)
- [ ] Performance baseline documented
- [ ] Rollback procedure tested
- [ ] Migration checklist created

### Quality Gates
- [ ] Backup size reasonable (DB >5MB, Theme ~38MB)
- [ ] Staging matches production
- [ ] All page types load on staging
- [ ] Rollback time <5 minutes
- [ ] Zero data loss risk

---

## Risk Assessment

### Critical Risks
- [R-01] Backup corruption → **Mitigation:** Verify all backups, test restore
- [R-02] Staging mismatch → **Mitigation:** Clone exact copy, verify URLs
- [R-03] Insufficient disk space → **Mitigation:** Check space before backup (need ~50GB free)

### Medium Risks
- [R-04] Staging URL conflicts → **Mitigation:** Use subdomain, test thoroughly
- [R-05] Missing files in backup → **Mitigation:** Verify file counts match inventory

### Low Risks
- [R-06] Automated script failure → **Mitigation:** Manual backup methods available

---

## Security Considerations

- [ ] Backups stored securely (encrypted if production)
- [ ] Database credentials not in scripts
- [ ] Backup files not web-accessible
- [ ] Staging site protected (password/IP)
- [ ] No indexing of staging (robots.txt disallow)
- [ ] SSL on staging (if production uses SSL)

---

## Context Tracking

### How to Track Progress

**1. File Inventory Spreadsheet**
```
File: /backups/pre-migration-20260106/file-inventory.csv
Columns: File, Lines, Size, Type, Current Action, GP Replacement, Status, Notes

Example:
index.php,50,2KB,PHP,Remove,GP Default,PENDING,
single-solutions.php,420,15KB,PHP,Replace,Content Template,PENDING,
```

**2. Migration Checklist**
```
File: /backups/pre-migration-20260106/migration-checklist.md
Track each of 90 files through migration phases
```

**3. Phase Tracking**
```
File: /plans/260104-universal-paper-stack-scroll/migration-progress.md
- Phase 01: [ ] 0/10 steps complete
- Phase 02: [ ] 0/8 steps complete
...
```

### How to Keep Context

**1. Before Each Phase**
```bash
# Read phase file
cat phase-XX-phase-name.md

# Review checklist
cat migration-checklist.md

# Check inventory
grep "PENDING" file-inventory.csv
```

**2. During Migration**
```bash
# Update file status
# In migration-checklist.md, mark as complete:
- [x] index.php → Removed, replaced with GP Default
- [x] single-solutions.php → Replaced with Content Template

# Update inventory CSV
# Change Status: PENDING → COMPLETE
```

**3. After Each Phase**
```bash
# Update phase file
# Change Status: PENDING → COMPLETE

# Update master plan
# Change phase status in phase-00
```

### Code Context Preservation

**1. Function Mapping**
```
File: /backups/pre-migration-20260106/function-map.md

aitsc_hero_shortcode() → [aitsc_hero] shortcode → GB Pattern
→ Still works as shortcode
→ Also available as visual block pattern
```

**2. Template Mapping**
```
File: /backups/pre-migration-20260106/template-map.md

single-solutions.php → Content Template Element
→ Displays: {{post_title}}, {{featured_image}}, {{post_content}}
→ ACF Fields: {{post_meta key:solution_features}}
```

**3. Style Mapping**
```
File: /backups/pre-migration-20260106/style-map.md

--aitsc-primary: #005cb2 → GP Customizer > Primary Color
--aitsc-bg-primary: #FFFFFF → GP Customizer > Body Background
```

---

## Next Steps

**Immediate:**
1. ✅ Review this phase plan
2. ✅ Approve or request revisions
3. ✅ Execute Step 1: File Inventory
4. ✅ Execute Steps 2-10 sequentially
5. ✅ Verify all success criteria

**After Phase 01 Complete:**
→ Proceed to [Phase 02: GP Setup](./phase-02-gp-setup.md)

**Cannot Proceed Until:**
- [ ] All backups complete and verified
- [ ] Staging functional
- [ ] Rollback tested

---

## File Tracking Summary

**Files Created in Phase 01:**
1. `/backups/pre-migration-20260106/file-inventory.csv`
2. `/backups/pre-migration-20260106/database.sql.gz`
3. `/backups/pre-migration-20260106/aitsc-pro-theme.tar.gz`
4. `/backups/pre-migration-20260106/uploads.tar.gz`
5. `/backups/pre-migration-20260106/dependency-audit.txt`
6. `/backups/pre-migration-20260106/performance-baseline.txt`
7. `/backups/pre-migration-20260106/screenshots/*` (multiple files)
8. `/backups/pre-migration-20260106/migration-checklist.md`
9. `/backups/pre-migration-20260106/function-map.md`
10. `/backups/pre-migration-20260106/rollback-procedure.md`

**Files Read in Phase 01:**
1. `/wp-content/themes/aitsc-pro-theme/functions.php`
2. `/wp-content/themes/aitsc-pro-theme/[All 90 PHP files]` (inventory)

**Total Files to Track:** 90 PHP files + associated CSS/JS assets

---

**Phase Status:** PENDING
**Estimated Hours:** 16 hours (2 days)
**Confidence Level:** HIGH (standard procedures)

**Ready to execute:** Yes, pending approval
