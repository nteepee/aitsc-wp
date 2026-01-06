# Development Site Setup - COMPLETE ✅

**Date:** 2026-01-06
**Status:** READY TO TEST

---

## Setup Completed ✅

### 1. Apache Virtual Directory Created
```
URL:  http://localhost:8888/aitsc-wp-copy/
Path: /Applications/MAMP/htdocs/aitsc-wp-copy/
```

**Added to:** `/Applications/MAMP/conf/apache/httpd.conf`
```apache
Alias /aitsc-wp-copy "/Applications/MAMP/htdocs/aitsc-wp-copy"
<Directory "/Applications/MAMP/htdocs/aitsc-wp-copy">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

### 2. wp-config.php Updated
```php
define('WP_HOME', 'http://localhost:8888/aitsc-wp-copy');
define('WP_SITEURL', 'http://localhost:8888/aitsc-wp-copy');
```

### 3. Folder Structure
```
/Applications/MAMP/htdocs/
├── aitsc-wp/           (PRODUCTION - DO NOT TOUCH)
│   └── → http://localhost:8888/aitsc-wp/
└── aitsc-wp-copy/      (DEVELOPMENT - SAFE TO TEST)
    └── → http://localhost:8888/aitsc-wp-copy/
```

---

## Activation Steps

### Step 1: Restart MAMP Servers
1. Open MAMP application
2. Click **Stop Servers** (if running)
3. Click **Start Servers**
4. Wait for green status

### Step 2: Access Development Site
1. Open browser
2. Go to: **`http://localhost:8888/aitsc-wp-copy/wp-admin/`**
3. Log in with WordPress admin credentials

### Step 3: Activate Child Theme
1. Navigate to: **Appearance → Themes**
2. Find: **"AITSC GeneratePress Child"**
3. Click **Activate**

### Step 4: Verify
- ✅ Site loads (styling will be broken - expected)
- ✅ WP Admin accessible
- ✅ CPTs visible in sidebar
- ✅ No white screen

---

## URLs Summary

| Purpose | URL |
|---------|-----|
| Production (NO TOUCH) | `http://localhost:8888/aitsc-wp/wp-admin/` |
| Development (TEST HERE) | `http://localhost:8888/aitsc-wp-copy/wp-admin/` |

---

## Child Theme Details

**Location:** `/wp-content/themes/aitsc-gp-child/`
**Files Preserved:**
- functions.php (with backwards compatibility)
- inc/custom-post-types.php
- inc/acf-fields.php (merged 3→1 files)
- inc/components.php
- inc/paper-stack.php
- inc/contact-ajax.php
- inc/template-tags.php
- components/paper-stack/paper-stack.php

**Critical Fixes Applied:**
- ✅ ACF fields merge syntax fixed
- ✅ Theme constants backwards compatible
- ✅ All PHP syntax validated

---

## Expected After Activation

### ✅ Good Signs (Success)
- Site loads (looks broken - OK!)
- No white screen
- CPTs in admin menu
- ACF fields present
- Can edit Solution posts

### ⚠️ Expected Issues (Normal)
- Styling completely broken
- Layout wrong
- Header/footer missing
- Components not rendering

### ❌ Bad Signs (Problem)
- White screen of death
- PHP fatal errors
- Cannot access admin
- CPTs disappeared

---

## Rollback Plan

### If Something Breaks

**Option 1: Deactivate Child Theme**
1. Via database:
   ```sql
   UPDATE wp_options SET option_value = 'aitsc-pro-theme'
   WHERE option_name = 'stylesheet' OR option_name = 'template';
   ```

**Option 2: Revert Apache Changes**
```bash
# Edit: /Applications/MAMP/conf/apache/httpd.conf
# Remove the Alias section at the end
```

**Option 3: Rename Folder**
```bash
cd /Applications/MAMP/htdocs/
mv aitsc-wp-copy "broken-atsc-wp-copy"
# Original is still safe at aitsc-wp
```

---

## Cleanup Files (Delete After Testing)

⚠️ **DELETE THESE FILES AFTER SUCCESS:**
- `/activate-theme.php`
- `/activate-child-now.php`
- `/gp-setup-guide.php`

---

**Status:** ✅ READY FOR TESTING
**Next:** Restart MAMP, then activate child theme
**Risk:** LOW (production untouched)
