# Fix Category Page 404 Error

**Plan ID**: 251228-2202-fix-category-404
**Created**: 2025-12-28 22:02
**Status**: Ready for implementation
**Estimated Time**: 15 minutes

## Problem Statement

Category archive pages return 404 errors:
- URL: `/solutions/passenger-monitoring-systems/`
- Status: 404 Not Found
- Expected: Category archive page showing all posts in category

### Root Cause Analysis

**Current Configuration** (wp-content/themes/aitsc-pro-theme/inc/custom-post-types.php:150):
```php
register_taxonomy( 'solution_category', array( 'solutions' ), array(
    'rewrite' => array( 'slug' => 'solution-category' ),
    // ...
));
```

**Post Type Configuration** (line 51):
```php
register_post_type( 'solutions', array(
    'rewrite' => array( 'slug' => 'solutions' ),
    // ...
));
```

**The Conflict**:
- Post type slug: `solutions` → Creates URLs like `/solutions/fleet-safe-pro/`
- Taxonomy slug: `solution-category` → Would create `/solution-category/passenger-monitoring-systems/`
- User expects: `/solutions/passenger-monitoring-systems/` (hierarchical under post type)

**Why It's Failing**:
1. Taxonomy rewrite slug doesn't match post type slug
2. WordPress can't resolve `/solutions/passenger-monitoring-systems/` because:
   - It looks for a post named "passenger-monitoring-systems" in post type "solutions"
   - It doesn't check taxonomy "solution_category" with slug "solution-category"
3. Rewrite rules were flushed but with wrong configuration

### Current State

**Categories Exist**:
- ID: 49, Name: "Passenger Monitoring Systems", Slug: "passenger-monitoring-systems"
- ID: 50, Name: "PCB & Embedded Engineering", Slug: "16"
- ID: 51, Name: "Automotive Electronics", Slug: "15"

**Template Exists**:
- `taxonomy-solution_category.php` is present and ready

**URLs Expected**:
- `/solutions/passenger-monitoring-systems/`
- `/solutions/pcb-embedded-engineering/` (after fixing slug)
- `/solutions/automotive-electronics/` (after fixing slug)

## Solution Design

### Option 1: Hierarchical Taxonomy URLs (Recommended)

**Change**: Update taxonomy rewrite slug from `solution-category` to `solutions`

**Pros**:
- Clean, logical URL structure: `/solutions/{category-slug}/`
- Matches user expectations
- Consistent with post type URLs
- SEO-friendly (category is clearly under solutions)

**Cons**:
- Potential conflict if category slug matches post slug
  - Mitigation: WordPress prioritizes post types over taxonomies by default
  - We control both slugs, can ensure no conflicts

**Implementation**:
```php
// Change from:
'rewrite' => array( 'slug' => 'solution-category' ),

// To:
'rewrite' => array( 'slug' => 'solutions' ),
```

### Option 2: Prefixed Taxonomy URLs

**Change**: Keep separate taxonomy slug with prefix

**Example URLs**:
- `/solutions-category/passenger-monitoring-systems/`
- `/solution-cat/passenger-monitoring-systems/`

**Pros**:
- No URL conflicts with post type
- Clear differentiation

**Cons**:
- URLs don't match user expectations
- Less clean, less SEO-friendly
- Not the desired URL structure

### Option 3: Custom Rewrite Rules

**Approach**: Manually add rewrite rules for category pages

**Pros**:
- Full control over URL structure
- Can create any desired pattern

**Cons**:
- Complex to maintain
- Fragile (breaks on WordPress updates)
- Overkill for this use case
- Not following WordPress conventions

## Selected Solution: Option 1

**Rationale**:
- Matches user expectations perfectly
- Follows WordPress best practices for hierarchical post type/taxonomy URLs
- Simplest implementation
- Most maintainable long-term
- SEO-optimized

## Implementation Plan

### Phase 1: Fix Taxonomy Registration

**File**: `wp-content/themes/aitsc-pro-theme/inc/custom-post-types.php`

**Changes**:
1. Line 150: Change taxonomy rewrite slug
   ```php
   // Before
   'rewrite' => array( 'slug' => 'solution-category' ),

   // After
   'rewrite' => array( 'slug' => 'solutions' ),
   ```

### Phase 2: Fix Category Slugs

**Issue**: Two categories have numeric slugs (16, 15) instead of descriptive slugs

**Fix via WP-CLI**:
```bash
# Update category 50 slug
wp term update solution_category 50 --slug=pcb-embedded-engineering

# Update category 51 slug
wp term update solution_category 51 --slug=automotive-electronics
```

**Verify**:
```bash
wp term list solution_category --fields=term_id,name,slug,count
```

### Phase 3: Flush Rewrite Rules

**Method 1 - WP-CLI (Recommended)**:
```bash
wp rewrite flush --hard
```

**Method 2 - Programmatic**:
```php
// Add to functions.php temporarily, visit any page, then remove
flush_rewrite_rules();
```

**Method 3 - Admin UI**:
- Navigate to Settings → Permalinks
- Click "Save Changes" (regenerates rewrite rules)

### Phase 4: Verification

**Test URLs** (expected 200 status):
```
http://localhost:8888/aitsc-wp/solutions/passenger-monitoring-systems/
http://localhost:8888/aitsc-wp/solutions/pcb-embedded-engineering/
http://localhost:8888/aitsc-wp/solutions/automotive-electronics/
```

**Test Post URL** (should still work):
```
http://localhost:8888/aitsc-wp/solutions/fleet-safe-pro/
```

**Verify Template**:
- Category pages should use `taxonomy-solution_category.php`
- Should display category name, description, and post grid

## Potential Conflicts & Mitigation

### Conflict: Category Slug = Post Slug

**Scenario**: If category "fleet-safe-pro" exists, which URL wins?

**WordPress Resolution Order**:
1. Check if it's a post in post type "solutions"
2. If not, check taxonomies registered to "solutions"

**Mitigation**:
- We control all slugs
- Use descriptive category slugs: `passenger-monitoring-systems`, `automotive-electronics`, `pcb-embedded-engineering`
- Use specific product names for posts: `fleet-safe-pro`, `custom-pcb-design`, etc.
- No overlap expected

### Edge Case: Direct Category Access

**Scenario**: User bookmarked old URL `/solution-category/passenger-monitoring-systems/`

**Result**: 404 (expected, slug changed)

**Mitigation**: If needed, add redirect in .htaccess or functions.php
```php
// Optional: Redirect old URLs to new structure
add_action('template_redirect', function() {
    if (is_404()) {
        $url = $_SERVER['REQUEST_URI'];
        if (strpos($url, '/solution-category/') !== false) {
            $new_url = str_replace('/solution-category/', '/solutions/', $url);
            wp_redirect($new_url, 301);
            exit;
        }
    }
});
```

## Testing Checklist

- [ ] Category pages load (all 3 categories)
- [ ] Category names display correctly
- [ ] Category descriptions render
- [ ] Posts listed in correct categories
- [ ] Post URLs still work (`/solutions/fleet-safe-pro/`)
- [ ] Navigation links work
- [ ] Archive page (`/solutions/`) still works
- [ ] No PHP errors in debug.log

## Rollback Plan

If issues occur:

1. **Revert taxonomy registration**:
   ```php
   'rewrite' => array( 'slug' => 'solution-category' ),
   ```

2. **Flush rewrite rules**:
   ```bash
   wp rewrite flush --hard
   ```

3. **Restore from git**:
   ```bash
   git checkout HEAD -- wp-content/themes/aitsc-pro-theme/inc/custom-post-types.php
   ```

## Success Criteria

✅ All category URLs return 200 status
✅ Taxonomy template renders correctly
✅ Category posts are listed
✅ Post URLs unchanged and working
✅ Archive page unchanged and working
✅ Navigation works end-to-end
✅ No 404 errors
✅ No PHP errors

## Files to Modify

1. `wp-content/themes/aitsc-pro-theme/inc/custom-post-types.php` (1 line change)
2. Category term slugs (via WP-CLI, 2 updates)

## Estimated Risk

**Risk Level**: Low

**Justification**:
- Simple 1-line configuration change
- WordPress handles rewrite rules automatically
- Easy rollback if needed
- Tested approach (standard WP practice)
- No data modification (only configuration)

## Dependencies

- None (self-contained fix)

## Related Issues

- ✅ Hero image loading (fixed in previous commit)
- ✅ Gallery images (fixed in previous commit)
- ✅ Solutions page UI/UX (fixed in previous commit)
- ⏳ Category page 404 (this fix)

## Notes

- Taxonomy rewrite slug matching post type slug is a common WordPress pattern
- Used by core (e.g., WooCommerce: `product` post type + `product_cat` taxonomy both use `product` slug)
- Creates intuitive, hierarchical URL structure
- SEO benefit: Category pages clearly organized under post type

## References

- WordPress Codex: [register_taxonomy](https://developer.wordpress.org/reference/functions/register_taxonomy/)
- WordPress Codex: [Rewrite API](https://codex.wordpress.org/Rewrite_API)
- WP-CLI: [wp term update](https://developer.wordpress.org/cli/commands/term/update/)
