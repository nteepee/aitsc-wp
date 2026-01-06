# Manual Image Assignment Guide
## Step-by-Step WordPress Admin Instructions

**For:** Image upload and ACF field assignment in WordPress admin
**Status:** Ready to execute
**Time Estimate:** 3-4 hours for complete allocation

---

## TABLE OF CONTENTS

1. [Quick Start](#quick-start)
2. [Accessing WordPress Admin](#accessing-wordpress-admin)
3. [Uploading Images](#uploading-images)
4. [Assigning Hero Images](#assigning-hero-images)
5. [Populating Galleries](#populating-galleries)
6. [Flexible Content Images](#flexible-content-images)
7. [Featured Images](#featured-images)
8. [Verification Checklist](#verification-checklist)

---

## QUICK START

**URL:** `http://localhost:8888/aitsc-wp/wp-admin/`

**Where images are stored:**
- `/wp-content/uploads/aitsc-images/heroes/` - Hero backgrounds
- `/wp-content/uploads/aitsc-images/galleries/` - Product photos
- `/wp-content/uploads/aitsc-images/graphics/` - Icons and decorative
- `/wp-content/uploads/aitsc-images/technical/` - Diagrams and maps

**What to do:**
1. Upload images to WordPress Media Library
2. Assign to ACF fields on solution pages
3. Set featured images for archives
4. Test on frontend

---

## ACCESSING WORDPRESS ADMIN

### Step 1: Login to WordPress
1. Open browser and navigate to: `http://localhost:8888/aitsc-wp/wp-admin/`
2. Enter your admin credentials
3. You should see the WordPress dashboard

### Step 2: Navigate to Media Library
1. In left sidebar, click **Media**
2. Click **Library**
3. You'll see existing media files

---

## UPLOADING IMAGES

### Option A: Bulk Upload via Media Library

**Step 1: Open Media Uploader**
1. Go to **Media** → **Add New**
2. You'll see the Upload area

**Step 2: Upload Images**
1. Click **Select Files** button
2. Navigate to `/wp-content/uploads/aitsc-images/` on your computer
3. Select first batch (e.g., all images from `heroes/fleet-safe-pro/`)
4. Click **Open** to upload

**Step 3: Wait for Upload**
- WordPress will process images
- You'll see progress for each file
- Once complete, images appear in Media Library

**Step 4: Repeat for Other Categories**
- Upload all `galleries/fleet-safe-pro/` images
- Upload all `graphics/` images
- Upload all `technical/` images
- Upload `heroes/` images for other solutions

### Option B: Drag & Drop Upload

**Step 1: Open Media Library**
1. Go to **Media** → **Library**

**Step 2: Drag Files**
1. Open file explorer/finder in another window
2. Navigate to `/wp-content/uploads/aitsc-images/`
3. Drag image files directly into Media Library page
4. WordPress uploads automatically

---

## ASSIGNING HERO IMAGES

### Fleet Safe Pro Solution Page

**Step 1: Navigate to Solution**
1. Go to **Solutions** in left sidebar
2. Click **All Solutions**
3. Find **Fleet Safe Pro** post
4. Click to edit

**Step 2: Locate Hero Section ACF Field**
1. Scroll down past the main editor
2. Look for section labeled **"Hero Section"** (ACF field group)
3. You'll see fields:
   - Background Image
   - Title
   - Subtitle
   - CTA Text
   - CTA Link

**Step 3: Assign Hero Image**
1. Click the **Background Image** field (shows "Add Image" button)
2. Click **"Add Image"** (or upload image icon)
3. Media Library opens
4. Search for: `display-ui-main.png`
5. Click image to select it
6. Image preview appears in field
7. Click **Select** to confirm

**Step 4: Save the Page**
1. Scroll to top
2. Click **Update** button (blue button, top-right)
3. Hero image is now assigned!

### PCB Design Solution Page

**Repeat same steps, but:**
1. Navigate to **PCB Design** solution post
2. In Hero Background Image field
3. Select: `PXL_20251120_050336202.jpg` (from November BB folder)
4. Update post

**Note:** You have 3 alternate November BB images for rotation:
- `PXL_20251120_050336202.jpg` (Primary)
- `PXL_20251120_050452968.jpg` (Alternate 1)
- `PXL_20251120_050627441.jpg` (Alternate 2)

### Embedded Systems & Automotive Solutions

**Follow same process:**
- **Embedded Systems:** Use `PXL_20251120_050713718.jpg`
- **Automotive:** Use `PXL_20251120_050909264.jpg`

---

## POPULATING GALLERIES

### Fleet Safe Pro Gallery (15 images)

**Step 1: Open Solution Post**
1. Go to **Solutions** → **All Solutions**
2. Click **Fleet Safe Pro** to edit

**Step 2: Locate Gallery Field**
1. Scroll down to find **"Product Gallery"** ACF field
2. You'll see "Add to Gallery" button

**Step 3: Select Images**
1. Click **"Add to Gallery"** button
2. Media Library opens showing all images
3. **Important:** Select MULTIPLE images at once:
   - Click first image: `1-PXL_20250915_010601218.jpg`
   - Hold **Ctrl** (Windows) or **Cmd** (Mac)
   - Click additional images from this list:
     - `10-PXL_20250915_011035196.jpg`
     - `13-PXL_20250915_011011902.jpg`
     - `15-PXL_20250915_010846203.jpg`
     - `19-PXL_20250915_010810481.jpg`
     - `22-PXL_20250915_010728653.jpg`
     - `25-PXL_20250915_005608441.jpg`
     - `27-PXL_20250915_005553814.jpg`
     - `31-PXL_20250915_005452852.jpg`
     - `35-PXL_20250915_005347929.jpg`
     - `39-PXL_20250915_005258264.jpg`
     - `42-PXL_20250915_005226960.jpg`
     - `48-PXL_20250915_005054468.jpg`
     - `52-PXL_20250915_005025440.jpg`
     - `56-PXL_20250915_004921069.jpg`

4. Once all 15 selected (you'll see checkmarks), click **Add to Gallery** button (bottom-right)

**Step 4: Arrange Images**
1. Back on edit page, gallery images appear with drag handles
2. Drag first image to position 1 (should be best quality)
3. Arrange others in visual order
4. Your first image becomes the gallery featured image

**Step 5: Save**
1. Click **Update** button
2. Gallery is complete!

### PCB Design Gallery (8 November BB Converted)

**Repeat same process:**
1. Open **PCB Design** solution post
2. In **Product Gallery** field
3. Select 8 images from `/galleries/november-bb/` folder:
   - Files: `10.png`, `12.png`, `14.png`, `16.png`, `18.png`, `20.png`, `22.png`, `24.png`
4. Arrange and update

### Embedded Systems Gallery (8 November BB Converted)

**Same process:**
1. Open **Embedded Systems** solution post
2. Select files: `11.png`, `13.png`, `15.png`, `17.png`, `19.png`, `21.png`, `23.png`, `25.png`
3. Update

### Automotive Gallery (8 Selected PXL Photos)

**Same process:**
1. Open **Automotive** solution post
2. Select 8 images from `/galleries/automotive/` folder
3. Choose best quality automotive-specific photos
4. Update

---

## FLEXIBLE CONTENT IMAGES

### Adding Text + Image Sections

**Step 1: Locate Flexible Content Field**
1. On solution edit page, scroll to **"Flexible Content Sections"**
2. You'll see **"Add Section"** button

**Step 2: Add Text + Image Section**
1. Click **"Add Section"** dropdown
2. Select **"Text + Image"**
3. New section appears with fields:
   - Title (text)
   - Content (WYSIWYG editor)
   - Image (image field)
   - Layout (select Left/Right)

**Step 3: Fill Section**
1. Enter title (e.g., "System Architecture")
2. Click content area → add description text
3. Click **Image** field → **"Add Image"**
4. Select appropriate image:
   - For PCB/Embedded/Automotive: Use `system-overview-diagram.png`
   - For partnership sections: Use `shake-hands.png`
   - For component details: Use `chair-seat-pad.png`
5. Select layout (Image Left or Right)

**Step 4: Add Multiple Sections**
1. Click **"Add Section"** again
2. Create 2-3 text+image sections per solution
3. Build depth and visual interest

**Step 5: Save**
1. Click **Update** when complete
2. Sections display on frontend with images

### Example for Fleet Safe Pro:
- Section 1: "System Architecture" + `system-diagram.png` (right)
- Section 2: "Configuration Options" + `800x480-v15---white-red.png` (left)
- Section 3: "Seat Sensor Details" + `chair-seat-pad.png` (right)

---

## FEATURED IMAGES

### What is a Featured Image?
- Thumbnail displayed on archive pages
- Shows in category listings
- WordPress native feature (not ACF)

### Setting Featured Image on Solution

**Step 1: Open Solution Post**
1. Go to **Solutions** → **All Solutions**
2. Click solution to edit

**Step 2: Set Featured Image**
1. Look at right sidebar
2. Find section labeled **"Featured Image"**
3. Click **"Set featured image"**
4. Media Library opens
5. Select appropriate image:
   - Fleet Safe Pro: `fleet-safe-pro-featured.png`
   - PCB Design: `PXL_20251120_050336202.jpg`
   - Embedded: `PXL_20251120_050713718.jpg`
   - Automotive: `PXL_20251120_050909264.jpg`
6. Click **Select** to set
7. Preview shows in sidebar

**Step 3: Save**
1. Click **Update**
2. Featured image is set!

### Featured Images for Blog Posts

If you have blog posts about solutions:
1. Go to **Posts** → select post
2. Same process: Right sidebar → **Featured Image**
3. Select from `/galleries/` folder
4. Update

---

## VERIFICATION CHECKLIST

### After Uploading & Assigning

Use this checklist to verify everything is working:

#### Images Uploaded ✓
- [ ] All images in Media Library (check count)
- [ ] No error messages during upload
- [ ] File sizes reasonable (not duplicated)

#### Hero Images Assigned ✓
- [ ] Homepage hero displays correctly
- [ ] Fleet Safe Pro hero shows on page
- [ ] PCB Design hero displays
- [ ] Embedded Systems hero displays
- [ ] Automotive hero displays
- [ ] All heroes responsive on mobile

#### Galleries Working ✓
- [ ] Fleet Safe Pro gallery shows 15 images
- [ ] PCB Design gallery shows 8 images
- [ ] Embedded Systems gallery shows 8 images
- [ ] Automotive gallery shows 8 images
- [ ] Lightbox opens when clicking images
- [ ] Gallery responsive on tablet/mobile

#### Featured Images Set ✓
- [ ] Fleet Safe Pro featured image visible in archive
- [ ] PCB Design featured image visible in archive
- [ ] Embedded Systems featured image visible in archive
- [ ] Automotive featured image visible in archive
- [ ] Homepage featured images show in blog section

#### Flexible Content ✓
- [ ] Text + Image sections display correctly
- [ ] Images align properly (left/right)
- [ ] Image sizes appropriate for layout
- [ ] All sections visible on mobile

#### Performance ✓
- [ ] Pages load in <3 seconds
- [ ] Images display without slowdown
- [ ] Gallery lightbox opens quickly
- [ ] No console errors in browser
- [ ] Lazy loading working (images load on scroll)

### If Issues Occur:

**Gallery not showing?**
1. Check image IDs in ACF field
2. Verify images are in Media Library
3. Try re-uploading image
4. Clear browser cache (Ctrl+Shift+Delete)

**Image not displaying?**
1. Check file format (JPG/PNG supported)
2. Verify file size <50MB
3. Check image permissions (should be 644)
4. Try uploading different image

**Featured image not showing?**
1. Make sure featured image is set in right sidebar
2. Regenerate thumbnails (plugin or manual)
3. Check image is not corrupted

**Lightbox not working?**
1. Verify gallery field is correctly populated
2. Check browser console for JavaScript errors
3. Try different browser
4. Disable plugins temporarily

---

## TIME TRACKING

Use this to track your progress:

| Task | Estimated Time | Actual Time | Status |
|------|---|---|---|
| Upload Fleet Safe Pro images | 30 min | | |
| Assign Fleet Safe Pro hero | 10 min | | |
| Populate Fleet Safe Pro gallery | 20 min | | |
| Add Fleet Safe Pro flexible content | 15 min | | |
| Set Fleet Safe Pro featured image | 5 min | | |
| Upload & assign PCB Design | 40 min | | |
| Upload & assign Embedded Systems | 40 min | | |
| Upload & assign Automotive | 40 min | | |
| Homepage hero & preview images | 30 min | | |
| Graphics/icons for sections | 20 min | | |
| Verification & QA | 30 min | | |
| **TOTAL** | **3-4 hours** | | |

---

## TIPS & BEST PRACTICES

1. **Upload in Batches**
   - Upload similar images together (e.g., all PXL photos at once)
   - Easier to find in Media Library
   - Faster upload process

2. **Use Media Library Search**
   - Use filename patterns to search: "PXL", "800x480", etc.
   - Saves time finding specific images

3. **Organize as You Go**
   - Note attachment IDs as you upload
   - Create a quick reference sheet
   - Helps with troubleshooting

4. **Test on Mobile**
   - After assignment, view pages on phone/tablet
   - Verify responsive design
   - Check image loading speed

5. **Backup Before Bulk Changes**
   - Take screenshot of current state
   - Export database backup
   - Allows rollback if needed

6. **Use Browser Inspector**
   - Press F12 to open inspector
   - Check image URLs in HTML
   - Verify images are loading (Network tab)

---

## TROUBLESHOOTING

### Common Issues & Solutions

**Issue: "You don't have permission to upload files"**
- **Solution:** Check user role has media upload capability
- Go to **Users** → your user → verify "Editor" or "Admin" role
- Refresh page and try again

**Issue: Images upload but don't appear in library**
- **Solution:** Refresh Media Library page
- Check upload folder has correct permissions (755)
- Try uploading smaller image first

**Issue: ACF field shows but image won't save**
- **Solution:** Check ACF field settings in admin
- Go to **Custom Fields** → edit field group
- Verify return format is set to "Image URL"
- Clear field and try re-assigning

**Issue: Gallery showing wrong number of images**
- **Solution:** Edit post and check gallery field
- Count images in array
- Re-arrange and save if needed
- Clear browser cache

**Issue: Hero image crops incorrectly**
- **Solution:** Image may be wrong aspect ratio
- For heroes: use 16:9 aspect ratio (1920x1080 ideal)
- Crop image before uploading if needed
- Try different image if one doesn't work

---

## NEXT STEPS AFTER ASSIGNMENT

1. **Test Frontend Display**
   - View each page in browser
   - Check responsive design on mobile
   - Test gallery lightbox functionality

2. **Perform QA**
   - Use checklist above
   - Take screenshots for documentation
   - Note any issues for fixes

3. **Optimize Performance**
   - Run Lighthouse audit (DevTools)
   - Check page load times
   - Enable lazy loading if not already

4. **Create Documentation**
   - Document image sources and purposes
   - Create backup of media library
   - Update team on image locations

---

**Document Status:** Ready for Execution
**Last Updated:** January 6, 2026
**Estimated Completion Time:** 3-4 hours
