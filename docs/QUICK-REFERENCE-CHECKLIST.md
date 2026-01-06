# Quick Reference Checklist
## Copy & Paste for Image Assignment

**Use this quick reference while uploading images to WordPress admin**

---

## WORDPRESS ADMIN URL
```
http://localhost:8888/aitsc-wp/wp-admin/
```

---

## ORGANIZED IMAGE FOLDERS
```
/wp-content/uploads/aitsc-images/
├── heroes/
│   ├── fleet-safe-pro/
│   ├── pcb-design/
│   ├── embedded-systems/
│   └── automotive/
├── galleries/
│   ├── fleet-safe-pro/
│   ├── november-bb/
│   ├── pcb-design/
│   ├── embedded-systems/
│   └── automotive/
├── graphics/
│   ├── icons/
│   └── decorative/
└── technical/
    ├── diagrams/
    └── seating-maps/
```

---

## ASSIGNMENT QUICK GUIDE

### HOMEPAGE
**Hero:** `fleet-safe-pro-featured.png` → hero_section->image
**Cards:** bus.png, chair-seat-pad.png, system-diagram.png → solution_sections[]->image
**Blog:** 3 best PXL photos → Featured Image

### FLEET SAFE PRO
**Hero:** `display-ui-main.png` → hero_section->image
**Featured:** `fleet-safe-pro-featured.png` → Featured Image
**Gallery:** Top 15 PXL photos → gallery_images
**Sections:** system-diagram.png, seating-maps, chair-seat-pad.png

### PCB DESIGN
**Hero:** `PXL_20251120_050336202.jpg` → hero_section->image
**Featured:** `PXL_20251120_050336202.jpg` → Featured Image
**Gallery:** 8 November BB converted (10.png, 12.png, 14.png, 16.png, 18.png, 20.png, 22.png, 24.png)
**Sections:** system-diagram.png, shake-hands.png

### EMBEDDED SYSTEMS
**Hero:** `PXL_20251120_050713718.jpg` → hero_section->image
**Featured:** `PXL_20251120_050713718.jpg` → Featured Image
**Gallery:** 8 November BB converted (11.png, 13.png, 15.png, 17.png, 19.png, 21.png, 23.png, 25.png)
**Sections:** bus.png, chair-seat-pad.png

### AUTOMOTIVE
**Hero:** `PXL_20251120_050909264.jpg` → hero_section->image
**Featured:** `PXL_20251120_050909264.jpg` → Featured Image
**Gallery:** 8 automotive PXL photos
**Sections:** shake-hands.png, system-diagram.png

### ABOUT PAGE
**Hero:** `fleet-safe-hero.png` → hero_section->image

---

## ARCHIVE FEATURED IMAGES
- Fleet Safe Pro: `fleet-safe-pro-featured.png`
- PCB Design: `PXL_20251120_050336202.jpg`
- Embedded Systems: `PXL_20251120_050713718.jpg`
- Automotive: `PXL_20251120_050909264.jpg`

---

## TOP 15 FLEET SAFE PRO GALLERY IMAGES
(In order of quality)
```
1-PXL_20250915_010601218.jpg
10-PXL_20250915_011035196.jpg
13-PXL_20250915_011011902.jpg
15-PXL_20250915_010846203.jpg
19-PXL_20250915_010810481.jpg
22-PXL_20250915_010728653.jpg
25-PXL_20250915_005608441.jpg
27-PXL_20250915_005553814.jpg
31-PXL_20250915_005452852.jpg
35-PXL_20250915_005347929.jpg
39-PXL_20250915_005258264.jpg
42-PXL_20250915_005226960.jpg
48-PXL_20250915_005054468.jpg
52-PXL_20250915_005025440.jpg
56-PXL_20250915_004921069.jpg
```

---

## ACF FIELD PATHS
```
hero_section->image
gallery_images
solution_sections[0]->text_image->image
solution_sections[1]->text_image->image
Featured Image (WordPress native, right sidebar)
```

---

## UPLOAD ORDER (Priority)
1. ✓ All heroes (20 images)
2. ✓ Fleet Safe Pro gallery (15 images)
3. ✓ November BB converted (20 images)
4. ✓ Graphics/icons (7 images)
5. ✓ Seating maps (11 images)
6. ✓ Remaining PXL photos (for future)

---

## TIME TRACKING
- Upload heroes: 30 min
- Fleet Safe Pro: 50 min
- PCB Design: 40 min
- Embedded Systems: 40 min
- Automotive: 40 min
- Graphics & technical: 20 min
- Testing/QA: 30 min
- **TOTAL: 4 hours**

---

## VERIFICATION CHECKLIST

### After Each Solution:
- [ ] Hero displays on page
- [ ] Gallery shows correct number of images
- [ ] Lightbox opens when clicking gallery images
- [ ] Featured image shows in archive
- [ ] All responsive on mobile
- [ ] No broken images (404 errors)

### Final QA (All Complete):
- [ ] All 7+ pages have correct images
- [ ] Homepage complete with 8 images
- [ ] All 4 solutions fully allocated
- [ ] Archive category images showing
- [ ] Mobile responsive verified
- [ ] Page load <3 seconds
- [ ] Gallery lightbox working
- [ ] No console errors (F12 to check)

---

## IF SOMETHING GOES WRONG

**Hero not showing?**
→ Check: Image assigned to hero_section->image field
→ Solution: Delete and re-assign image

**Gallery blank?**
→ Check: gallery_images array has image IDs
→ Solution: Re-populate with correct image IDs

**Image 404 error?**
→ Check: File exists in /wp-content/uploads/aitsc-images/
→ Solution: Upload image again to Media Library

**ACF field empty?**
→ Refresh page
→ Clear browser cache (Ctrl+Shift+Delete)
→ Try assigning again

---

## IMPORTANT PATHS

**Images are organized in:**
```
/Applications/MAMP/htdocs/aitsc-wp/wp-content/uploads/aitsc-images/
```

**Documentation:**
- Detailed Guide: `docs/manual-image-assignment-guide.md`
- Full Mapping: `docs/image-allocation-mapping.md`
- Project Summary: `docs/IMAGE-PROJECT-SUMMARY.md`

**WordPress Admin:**
```
http://localhost:8888/aitsc-wp/wp-admin/
```

---

## SCREENSHOTS TO TAKE
Document your work:
- [ ] Screenshot of each populated hero
- [ ] Screenshot of each gallery
- [ ] Screenshot of mobile view (each page)
- [ ] Screenshot of archive with featured images
- [ ] Screenshot of final pages (for approval)

---

## DOCUMENT REFERENCES

**Full step-by-step guide:**
👉 `/docs/manual-image-assignment-guide.md`

**Complete image mapping:**
👉 `/docs/image-allocation-mapping.md`

**Project overview:**
👉 `/docs/IMAGE-PROJECT-SUMMARY.md`

---

## TIME STAMP
Started: ___________
Completed: ___________
Total Duration: ___________

---

**Print this page and check off items as you complete them.**
