# Card Component Usage Guide

**Purpose**: Ensure consistent, equal-height cards in grid layouts

---

## Quick Reference

### ✅ CORRECT Usage

```php
<div class="aitsc-grid aitsc-grid--3-col">
    <div>
        <?php
        aitsc_render_card([
            'variant' => 'white-feature',
            'title' => 'Service Name',
            'description' => 'Description here',
            'custom_class' => 'h-100'  // ✅ REQUIRED
        ]);
        ?>
    </div>
</div>
```

### ❌ INCORRECT Usage

```php
<div class="aitsc-grid aitsc-grid--3-col">
    <div>
        <?php
        aitsc_render_card([
            'variant' => 'white-feature',
            'title' => 'Service Name',
            'description' => 'Description here'
            // ❌ Missing 'custom_class' => 'h-100'
        ]);
        ?>
    </div>
</div>
```

**Result**: Cards will have inconsistent heights ("jagged" layout)

---

## How Equal Heights Work

### The 3-Part System

1. **Grid Container** (`style.css:908-912`)
   ```css
   .aitsc-grid {
       display: grid;
       align-items: stretch;  /* Forces all grid items to same height */
   }
   ```

2. **Card Wrapper** (Grid Item)
   - Automatically stretched by grid's `align-items: stretch`
   - All grid items in same row = same height

3. **Card Component** (`card-variants.css:12-22`)
   ```css
   .aitsc-card {
       height: 100%;  /* Fills stretched grid item */
       display: flex;
       flex-direction: column;
   }
   ```

### Content Distribution

```css
.aitsc-card__body {
    flex: 1;  /* Grows to fill available space */
}

.aitsc-card__description {
    flex: 1;  /* Text area expands to push CTA to bottom */
}
```

**Effect**: Short descriptions expand, long ones don't overflow. CTA always at bottom.

---

## Grid Column Selection

| Use Case | Grid Class | Reasoning |
|----------|-----------|-----------|
| **Feature Comparison** | `aitsc-grid--2-col` | Binary choice, side-by-side |
| **Service Showcase** | `aitsc-grid--3-col` | Balanced rhythm, optimal reading |
| **Product Catalog** | `aitsc-grid--4-col` | Dense listing, many items |
| **Blog Posts** | `aitsc-grid--3-col` | Standard blog grid pattern |

### Responsive Behavior

- **Mobile** (<768px): All → 1 column
- **Tablet** (768-992px): 3-col & 4-col → 2 columns
- **Desktop** (>992px): Full grid layout

---

## Card Variants

### white-feature
**Best for**: Primary service/feature highlights
```php
aitsc_render_card([
    'variant' => 'white-feature',
    'icon' => 'airline_seat_recline_normal',
    'title' => 'Passenger Monitoring',
    'description' => 'Real-time detection...',
    'link' => home_url('/solutions/passenger-monitoring'),
    'cta_text' => 'Explore Solutions',
    'custom_class' => 'h-100'
]);
```

### white-minimal
**Best for**: Secondary features, benefits, trust signals
```php
aitsc_render_card([
    'variant' => 'white-minimal',
    'icon' => 'verified_user',
    'title' => 'Automotive-Grade Standards',
    'description' => 'ISO 26262 compliance...',
    'custom_class' => 'h-100'
]);
```

### blog
**Best for**: Article/post listings with images
```php
aitsc_render_card([
    'variant' => 'blog',
    'title' => get_the_title(),
    'description' => get_the_excerpt(),
    'link' => get_permalink(),
    'image' => get_the_post_thumbnail_url(),
    'cta_text' => 'Read Article',
    'meta' => [
        'date' => get_the_date(),
        'read_time' => '5 min read'
    ],
    'custom_class' => 'h-100'
]);
```

---

## Common Mistakes

### Mistake 1: Forgetting `h-100`
**Problem**: Cards have different heights
**Fix**: Always add `'custom_class' => 'h-100'`

### Mistake 2: Using Bootstrap Classes
**Problem**: `.row` and `.col-md-4` don't work (Bootstrap not loaded)
**Fix**: Use `.aitsc-grid` and `.aitsc-grid--[n]-col`

### Mistake 3: Wrong Grid Column Count
**Problem**: 4 items in 3-col grid leaves 1 orphan
**Fix**: Match grid columns to item count or use auto-fit pattern

---

## Troubleshooting

### Cards Still Have Different Heights?

**Check 1**: Is `custom_class => 'h-100'` set?
```php
// In template file
'custom_class' => 'h-100'  // Must be present
```

**Check 2**: Is card inside `.aitsc-grid`?
```php
<div class="aitsc-grid aitsc-grid--3-col">  // ✅ Correct
    <div><?php aitsc_render_card([...]); ?></div>
</div>

<div class="row">  // ❌ Wrong - Bootstrap not loaded
```

**Check 3**: CSS loaded correctly?
```bash
# Verify in browser DevTools
.aitsc-grid { align-items: stretch; }  // Should be present
.aitsc-card { height: 100%; }  // Should be present
.h-100 { height: 100%; }  // Should be present
```

---

## Files Reference

- **Grid System**: `/wp-content/themes/aitsc-pro-theme/style.css:908-950`
- **Card Base**: `/wp-content/themes/aitsc-pro-theme/components/card/card-variants.css:12-372`
- **Card Logic**: `/wp-content/themes/aitsc-pro-theme/components/card/card-base.php`
- **Height Utilities**: `/wp-content/themes/aitsc-pro-theme/style.css:258-268`

---

## DO NOT REMOVE

The following CSS rules are **CRITICAL** for equal-height cards:

```css
/* style.css:912 */
.aitsc-grid {
    align-items: stretch;  /* DO NOT REMOVE */
}

/* style.css:266-268 */
.h-100 {
    height: 100%;  /* DO NOT REMOVE */
}

/* card-variants.css:15 */
.aitsc-card {
    height: 100%;  /* DO NOT REMOVE */
}

/* card-variants.css:357 */
.aitsc-card__body {
    flex: 1;  /* DO NOT REMOVE */
}
```

Removing any of these breaks the equal-height system.

---

**Last Updated**: 2024-12-31
**Version**: 4.0.0 (Harrison.ai White Theme)
