# GP Premium Activation - Quick Reference Card

**Print this or keep open during activation**

---

## Environment Info
- **Dev URL:** `http://localhost:8888/aitsc-wp-copy/`
- **License:** `de485e6af6e7e30eb60dbe638d50e55f` (Lifetime)
- **Child Theme:** `aitsc-gp-child`

---

## 5-Minute Quick Start

### Step 1: Install Plugin (2 min)
1. Go to: **Plugins > Add New > Upload Plugin**
2. Upload: `gp-premium.zip`
3. Click: **Install Now**
4. Click: **Activate**

### Step 2: Activate License (1 min)
1. Go to: **Appearance > GeneratePress > License**
2. Paste: `de485e6af6e7e30eb60dbe638d50e55f`
3. Click: **Activate License**
4. Verify: "Active - Lifetime"

### Step 3: Enable Modules (1 min)
1. Go to: **Appearance > GeneratePress > Modules**
2. Enable:
   - ✅ Elements ⭐
   - ✅ Backgrounds
   - ✅ Typography
   - ✅ Colors
   - ✅ Spacing
3. Click: **Save**

### Step 4: Test (1 min)
1. Visit: `http://localhost:8888/aitsc-wp-copy/`
2. Check: No errors, loads correctly

---

## Module Toggle List

```
┌─────────────────────────────────────┐
│ CRITICAL - ENABLE ALL               │
├─────────────────────────────────────┤
│ [ ] Elements ⭐ (MOST IMPORTANT)    │
│ [ ] Backgrounds                     │
│ [ ] Typography                      │
│ [ ] Colors                          │
│ [ ] Spacing                         │
├─────────────────────────────────────┤
│ OPTIONAL - ENABLE AS NEEDED         │
├─────────────────────────────────────┤
│ [ ] Secondary Nav                   │
│ [ ] Menu Plus                       │
│ [ ] Sticky                          │
└─────────────────────────────────────┘
```

---

## First Action Checklist

After activation, do these in order:

- [ ] **Create Header Element**
  - Appearance > GeneratePress > Elements > Add New
  - Type: Header
  - Build with blocks
  - Display rules: Entire Site

- [ ] **Create Footer Element**
  - Appearance > GeneratePress > Elements > Add New
  - Type: Footer
  - Build with blocks
  - Display rules: Entire Site

- [ ] **Test Frontend**
  - Visit homepage
  - Check header displays
  - Check footer displays
  - Check mobile responsive

---

## Quick Troubleshooting

| Problem | Quick Fix |
|---------|-----------|
| License won't activate | Check key (no spaces), retry |
| Elements not showing | Clear cache, verify module active |
| White screen | Check debug.log for errors |
| Header/footer missing | Check display rules, publish status |
| Editor crashes | Deactivate Classic Editor plugin |

---

## Important URLs

**WP Admin:**
```
http://localhost:8888/aitsc-wp-copy/wp-admin/
```

**GP Settings:**
```
Appearance > GeneratePress
```

**Elements:**
```
Appearance > GeneratePress > Elements
```

**Direct to Elements:**
```
/wp-admin/admin.php?page=generatepress_elements
```

---

## License Key (Copy This)

```
de485e6af6e7e30eb60dbe638d50e55f
```

**Type:** Lifetime
**Sites:** Unlimited

---

## Progress Tracker

**Phase 06: GP Premium Setup**

```
Installation:      [ ] Not Started [ ] In Progress [ ] Complete
License:           [ ] Not Started [ ] In Progress [ ] Complete
Modules:           [ ] Not Started [ ] In Progress [ ] Complete
First Element:     [ ] Not Started [ ] In Progress [ ] Complete
Verification:      [ ] Not Started [ ] In Progress [ ] Complete
```

**When all = [✓] Complete, move to Phase 07**

---

## Next Steps After Activation

1. **Read full guide:** `GP-PREMIUM-SETUP.md`
2. **Review migration plan:** `plans/260104-universal-paper-stack-scroll/phase-00-generatepress-migration-overview.md`
3. **Start Phase 07:** Migration planning

---

## Emergency Rollback

If activation breaks site:

```bash
# Via terminal
cd /wp-content/plugins/
mv gp-premium gp-premium-backup

# Site should work immediately
# Then check debug.log for errors
```

---

**Estimated Time:** 5-10 minutes
**Difficulty:** Beginner
**Status:** Ready to execute

---

**Keep this open during activation!**
