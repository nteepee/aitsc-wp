# Testing Protocol

## Quick Reference

### Pre-Migration Checklist
- [ ] Backup all theme files
- [ ] Document current Lighthouse scores
- [ ] Screenshot key pages (dark theme reference)
- [ ] Export WordPress customizer settings

### Post-Phase Testing

**After Phase 1 (CSS Variables)**:
```bash
# Verify no PHP errors
php -l style.css  # N/A for CSS
grep -r "var(--wq-" wp-content/themes/aitsc-pro-theme/  # Should return 0
grep -r "#000000" wp-content/themes/aitsc-pro-theme/*.css  # Should return 0
```

**After Phase 2 (Component Variants)**:
- Load each new variant in isolation
- Verify shortcodes work: `[aitsc_card variant="white-feature"]`

**After Phase 3 (New Components)**:
- Trust bar renders with text
- Logo carousel animates
- Image composition positions correctly
- All respect `prefers-reduced-motion`

**After Phase 4 (Navigation)**:
- Header sticky works
- Mobile toggle works
- Dropdowns accessible
- CTA button prominent

**After Phase 5 (Templates)**:
- All pages load without 500 errors
- No dark backgrounds visible
- Cards use white variants

**After Phase 6 (Testing)**:
- All checklists completed
- Lighthouse scores meet targets
- Cross-browser verified

---

## Lighthouse Score Tracking

| Date | Page | Perf | A11y | BP | SEO |
|------|------|------|------|-----|-----|
| Pre-migration | Homepage | ___ | ___ | ___ | ___ |
| Post-Phase 1 | Homepage | ___ | ___ | ___ | ___ |
| Post-Phase 5 | Homepage | ___ | ___ | ___ | ___ |
| Final | Homepage | ___ | ___ | ___ | ___ |

---

## Critical Paths to Test

1. **User: Find Solutions**
   - Homepage > Solutions Grid > Single Solution > Contact

2. **User: View Case Studies**
   - Homepage > Case Studies > Single Case Study

3. **User: Contact**
   - Homepage > Header CTA > Contact Form > Submit

4. **Mobile User: Navigate**
   - Hamburger > Menu > Page > Back

---

## Accessibility Quick Tests

```javascript
// Run in browser console
document.querySelectorAll('img:not([alt])').length  // Should be 0
document.querySelectorAll('a:not([href])').length   // Should be 0
document.querySelectorAll('button:not([type])').length  // Should be 0
```

---

## Performance Quick Tests

```bash
# CSS stats
cat style.css | wc -l  # Target: < 3500 lines

# Unused CSS check
npx purifycss style.css index.html --out report.txt
```
