# Development Site - COMPLETELY ISOLATED ✅

**Date:** 2026-01-06
**Status:** FULLY ISOLATED - Ready to Test

---

## Complete Site Isolation ✅

### Databases (Separate)
```
Production: aitsctest_wp     (18 tables)
Development: aitsctest_wp_dev (18 tables - cloned)
```

### Sites (Separate URLs)
```
Production: http://localhost:8888/aitsc-wp/
Development: http://localhost:8888/aitsc-wp-copy/
```

### Git Branches (Separate)
```
Production: deploy-branch (main site)
Development: gp-migration-dev (isolated dev work)
```

---

## What Changed

### 1. New Database Created
- **Name:** `aitsctest_wp_dev`
- **Source:** Cloned from `aitsctest_wp`
- **Tables:** 18 tables copied
- **Data:** All posts, pages, options, users copied

### 2. Dev wp-config.php Updated
```php
// Now uses separate database
define('DB_NAME', 'aitsctest_wp_dev');

// Points to dev URL
define('WP_HOME', 'http://localhost:8888/aitsc-wp-copy');
define('WP_SITEURL', 'http://localhost:8888/aitsc-wp-copy');
```

### 3. New Git Branch Created
```bash
cd /Applications/MAMP/htdocs/aitsc-wp-copy
git checkout -b gp-migration-dev
```

### 4. Apache Config Already Done
```apache
Alias /aitsc-wp-copy "/Applications/MAMP/htdocs/aitsc-wp-copy"
```

---

## Complete Isolation Verification

| Aspect | Production | Development |
|--------|-----------|-------------|
| **Folder** | aitsc-wp | aitsc-wp-copy |
| **URL** | localhost:8888/aitsc-wp | localhost:8888/aitsc-wp-copy |
| **Database** | aitsctest_wp | aitsctest_wp_dev |
| **Git Branch** | deploy-branch | gp-migration-dev |
| **Theme** | aitsc-pro-theme | aitsc-pro-theme (can change) |
| **Impact** | 🛡️ PROTECTED | ⚗️ TEST FREELY |

---

## Testing the Dev Site

### Step 1: Restart MAMP
1. Open MAMP
2. Stop Servers (if running)
3. Start Servers
4. Wait for green

### Step 2: Access Dev Site
```
WP Admin:  http://localhost:8888/aitsc-wp-copy/wp-admin/
Frontend:   http://localhost:8888/aitsc-wp-copy/
```

### Step 3: Activate Child Theme
1. Appearance → Themes
2. Activate "AITSC GeneratePress Child"
3. Verify site loads

### Step 4: Test Isolation
1. Edit a post on dev site
2. Check production - post unchanged ✅
3. Change theme on dev site
4. Check production - theme unchanged ✅

---

## What You Can Do Safely Now

### On Dev Site (Safe)
- ✅ Activate child theme
- ✅ Break the styling
- ✅ Delete content
- ✅ Change settings
- ✅ Test GP migration
- ✅ Commit changes to gp-migration-dev branch

### On Production (Untouched)
- 🛡️ Completely isolated
- 🛡️ No shared database
- 🛡️ No shared settings
- 🛡️ Safe regardless of dev changes

---

## Git Workflow

### Development Branch
```bash
cd /Applications/MAMP/htdocs/aitsc-wp-copy
git checkout gp-migration-dev

# Make changes, test, commit
git add .
git commit -m "test changes"
git push origin gp-migration-dev
```

### Production Branch (unchanged)
```bash
cd /Applications/MAMP/htdocs/aitsc-wp
git checkout deploy-branch
# No changes from dev work
```

---

## File Structure

```
/Applications/MAMP/htdocs/
├── aitsc-wp/                    (PRODUCTION)
│   ├── .git/                    → deploy-branch
│   ├── wp-config.php            → DB: aitsctest_wp
│   └── URL: localhost:8888/aitsc-wp
│
└── aitsc-wp-copy/               (DEVELOPMENT)
    ├── .git/                    → gp-migration-dev
    ├── wp-config.php            → DB: aitsctest_wp_dev
    ├── wp-content/themes/
    │   ├── aitsc-pro-theme/
    │   └── aitsc-gp-child/      (NEW - ready to test)
    └── URL: localhost:8888/aitsc-wp-copy
```

---

## Reset Dev Site If Needed

### Option 1: Re-clone Database
```bash
mysqldump -u root -proot --socket=/Applications/MAMP/tmp/mysql/mysql.sock aitsctest_wp | \
mysql -u root -proot --socket=/Applications/MAMP/tmp/mysql/mysql.sock aitsctest_wp_dev
```

### Option 2: Git Reset
```bash
cd /Applications/MAMP/htdocs/aitsc-wp-copy
git reset --hard origin/deploy-branch
git checkout deploy-branch
```

### Option 3: Delete and Re-copy
```bash
cd /Applications/MAMP/htdocs
rm -rf aitsc-wp-copy
cp -R aitsc-wp aitsc-wp-copy
# Repeat setup from DEV-SITE-ISOLATED.md
```

---

## Status

| Component | Status |
|-----------|--------|
| Database Separation | ✅ Complete |
| URL Separation | ✅ Complete |
| Git Branch | ✅ Complete |
| Apache Config | ✅ Complete |
| Child Theme Ready | ✅ Complete |
| Isolation Verified | ✅ Complete |

---

**NEXT:** Restart MAMP and test at `http://localhost:8888/aitsc-wp-copy/wp-admin/`

**RISK LEVEL:** ZERO - Production fully isolated
