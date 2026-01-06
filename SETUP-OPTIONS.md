# Development Setup Options - AITSC Migration

**Current Situation:**
- ✅ Production: `aitsc-wp` folder → `http://localhost:8888/aitsc-wp/`
- ✅ File Copy: `aitsc-wp copy` folder exists (same config)
- ❌ Separate dev site: NOT YET CONFIGURED

---

## Option A: Swap Folders (QUICKEST - 5 min)

**How:** Temporarily rename original, use copy as active

```bash
# Step 1: Backup original
cd /Applications/MAMP/htdocs/
mv aitsc-wp aitsc-wp-original-backup

# Step 2: Rename copy to be active
mv "aitsc-wp copy" aitsc-wp

# Step 3: Test at http://localhost:8888/aitsc-wp/wp-admin/

# Rollback if needed:
mv aitsc-wp "aitsc-wp copy"
mv aitsc-wp-original-backup aitsc-wp
```

**Pros:** Fast, no config changes needed
**Cons:** Can't test both simultaneously

---

## Option B: Set Up Separate Virtual Host (RECOMMENDED - 15 min)

### Step 1: Edit MAMP Apache config
```bash
# Edit: /Applications/MAMP/conf/apache/httpd.conf
# Add at bottom:

<VirtualHost *:8888>
    DocumentRoot "/Applications/MAMP/htdocs/aitsc-wp copy"
    ServerName aitsc-wp-copy.localhost
</VirtualHost>
```

### Step 2: Edit hosts file
```bash
# Edit: /etc/hosts
# Add line:
127.0.0.1 aitsc-wp-copy.localhost
```

### Step 3: Update wp-config in copy
```php
// In: aitsc-wp copy/wp-config.php
define('WP_HOME', 'http://aitsc-wp-copy.localhost:8888');
define('WP_SITEURL', 'http://aitsc-wp-copy.localhost:8888');
```

### Step 4: Restart MAMP
1. Stop MAMP servers
2. Start MAMP servers
3. Access: `http://aitsc-wp-copy.localhost:8888/wp-admin/`

**Pros:** Both sites accessible simultaneously
**Cons:** Requires config changes

---

## Option C: Use Different Port (ALTERNATIVE - 10 min)

### Step 1: Configure MAMP to use port 8889 for dev
1. Open MAMP
2. Preferences → Ports
3. Set Apache port to 8889

### Step 2: Update wp-config in copy
```php
define('WP_HOME', 'http://localhost:8889/aitsc-wp');
define('WP_SITEURL', 'http://localhost:8889/aitsc-wp');
```

### Step 3: Access at `http://localhost:8889/aitsc-wp/wp-admin/`

**Pros:** Separate port, both accessible
**Cons:** Might conflict with other MAMP settings

---

## Option D: Use Subdirectory (NEVER MIND - COMPLEX)

Would require moving copy inside original - too complex for migration.

---

## Recommended: Option A (Swap) for Testing

**Quick Test Workflow:**
```bash
# 1. Safe backup
cd /Applications/MAMP/htdocs/
mv aitsc-wp aitsc-wp-prod-backup

# 2. Make copy active
mv "aitsc-wp copy" aitsc-wp

# 3. Start MAMP and test
# Access: http://localhost:8888/aitsc-wp/wp-admin/

# 4. When done testing, restore:
mv aitsc-wp "aitsc-wp copy"
mv aitsc-wp-prod-backup aitsc-wp
```

---

## Current Status

- ✅ Child theme created in copy folder
- ✅ Critical fixes applied
- ✅ Ready to test
- ⏳ Need to choose setup option above

---

**Which option would you like to use?**
