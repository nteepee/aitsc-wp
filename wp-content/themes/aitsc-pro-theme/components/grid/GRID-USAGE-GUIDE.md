# Grid Component Usage Guide

**Purpose**: Semantic, responsive grid system replacing Bootstrap

---

## Quick Start

### Basic Grid

```php
<div class="aitsc-grid aitsc-grid--3-col">
    <div>Item 1</div>
    <div>Item 2</div>
    <div>Item 3</div>
</div>
```

**Result**: 3 equal-width columns on desktop, responsive on mobile

---

## Grid Variants

### 2-Column Grid
```php
<div class="aitsc-grid aitsc-grid--2-col">
    <div>Left</div>
    <div>Right</div>
</div>
```

**Responsive**:
- Desktop (>992px): 2 columns
- Mobile (<768px): 1 column

**Use Cases**: Comparisons, before/after, pros/cons

---

### 3-Column Grid (DEFAULT for features)
```php
<div class="aitsc-grid aitsc-grid--3-col">
    <div>Item 1</div>
    <div>Item 2</div>
    <div>Item 3</div>
</div>
```

**Responsive**:
- Desktop (>992px): 3 columns
- Tablet (768-992px): 2 columns
- Mobile (<768px): 1 column

**Use Cases**: Service highlights, benefits, blog posts

---

### 4-Column Grid
```php
<div class="aitsc-grid aitsc-grid--4-col">
    <div>Item 1</div>
    <div>Item 2</div>
    <div>Item 3</div>
    <div>Item 4</div>
</div>
```

**Responsive**:
- Desktop (>992px): 4 columns
- Tablet (768-992px): 2 columns
- Mobile (<768px): 1 column

**Use Cases**: Product catalogs, dense listings

---

## Gap Modifiers

### Default Gap (16px)
```php
<div class="aitsc-grid aitsc-grid--3-col">
    <!-- Default gap: var(--space-4) = 16px -->
</div>
```

### Custom Gaps
```php
<!-- Small gap (8px) -->
<div class="aitsc-grid aitsc-grid--3-col aitsc-grid--gap-2">

<!-- Large gap (24px) -->
<div class="aitsc-grid aitsc-grid--3-col aitsc-grid--gap-6">

<!-- Extra large gap (32px) -->
<div class="aitsc-grid aitsc-grid--3-col aitsc-grid--gap-8">
```

---

## Alignment Utilities

### Center Items
```php
<div class="aitsc-grid aitsc-grid--3-col aitsc-grid--center">
    <!-- Items centered horizontally AND vertically -->
</div>
```

**Note**: This overrides `align-items: stretch`, so cards won't have equal heights

---

## With Cards (CRITICAL)

### ✅ CORRECT: Equal Heights
```php
<div class="aitsc-grid aitsc-grid--3-col">
    <div>
        <?php aitsc_render_card([
            'variant' => 'white-feature',
            'custom_class' => 'h-100'  // ✅ REQUIRED
        ]); ?>
    </div>
    <div>
        <?php aitsc_render_card([
            'variant' => 'white-feature',
            'custom_class' => 'h-100'  // ✅ REQUIRED
        ]); ?>
    </div>
</div>
```

### ❌ INCORRECT: Unequal Heights
```php
<div class="aitsc-grid aitsc-grid--3-col">
    <div>
        <?php aitsc_render_card([
            'variant' => 'white-feature'
            // ❌ Missing 'h-100'
        ]); ?>
    </div>
</div>
```

---

## Grid Decision Matrix

| Items | Content Density | Recommended Grid |
|-------|----------------|------------------|
| 2 | Any | `--2-col` |
| 3 | Medium/High | `--3-col` |
| 4 | Low/Medium | `--4-col` or `--2-col` |
| 4 | High | `--3-col` (one orphan) |
| 5-6 | Medium | `--3-col` |
| 6-8 | Low | `--4-col` |
| 8+ | Low | `--4-col` |

**Content Density**:
- **Low**: Icon + short title (e.g., trust badges)
- **Medium**: Icon + title + 2-3 sentences
- **High**: Icon + title + paragraph + image

---

## Responsive Breakpoints

| Breakpoint | Size | Behavior |
|-----------|------|----------|
| Mobile | <768px | All grids → 1 column |
| Tablet | 768-992px | 3-col & 4-col → 2 columns |
| Desktop | >992px | Full grid layout |

**CSS Variables**:
```css
--breakpoint-md: 48rem;   /* 768px */
--breakpoint-lg: 62rem;   /* 992px */
```

---

## Migration from Bootstrap

### Before (Bootstrap)
```php
<div class="row">
    <div class="col-md-4">Item 1</div>
    <div class="col-md-4">Item 2</div>
    <div class="col-md-4">Item 3</div>
</div>
```

### After (Semantic Grid)
```php
<div class="aitsc-grid aitsc-grid--3-col">
    <div>Item 1</div>
    <div>Item 2</div>
    <div>Item 3</div>
</div>
```

**Why**: Bootstrap CSS not loaded in theme, semantic grid is lighter and more maintainable

---

## Implementation Details

### CSS (style.css:908-950)

```css
.aitsc-grid {
    display: grid;
    gap: var(--space-4);  /* 16px default */
    width: 100%;
    align-items: stretch;  /* CRITICAL: Equal heights */
}

.aitsc-grid--2-col {
    grid-template-columns: repeat(2, 1fr);
}

.aitsc-grid--3-col {
    grid-template-columns: repeat(3, 1fr);
}

.aitsc-grid--4-col {
    grid-template-columns: repeat(4, 1fr);
}

/* Mobile: All collapse to 1 column */
@media (max-width: 47.9375rem) {
    .aitsc-grid--2-col,
    .aitsc-grid--3-col,
    .aitsc-grid--4-col {
        grid-template-columns: 1fr;
    }
}

/* Tablet: 3-col & 4-col become 2 columns */
@media (min-width: 48rem) and (max-width: 61.9375rem) {
    .aitsc-grid--3-col,
    .aitsc-grid--4-col {
        grid-template-columns: repeat(2, 1fr);
    }
}
```

---

## Common Patterns

### Services Section (front-page.php:44)
```php
<div class="aitsc-grid aitsc-grid--4-col">
    <?php foreach ($services as $service): ?>
        <div>
            <?php aitsc_render_card([
                'variant' => 'white-feature',
                'custom_class' => 'h-100'
            ]); ?>
        </div>
    <?php endforeach; ?>
</div>
```

### Benefits Section (front-page.php:118)
```php
<div class="aitsc-grid aitsc-grid--3-col">
    <div><?php aitsc_render_card(['custom_class' => 'h-100']); ?></div>
    <div><?php aitsc_render_card(['custom_class' => 'h-100']); ?></div>
    <div><?php aitsc_render_card(['custom_class' => 'h-100']); ?></div>
</div>
```

### Blog Posts (front-page.php:169)
```php
<div class="aitsc-grid aitsc-grid--3-col">
    <?php while (have_posts()): the_post(); ?>
        <div>
            <?php aitsc_render_card([
                'variant' => 'blog',
                'custom_class' => 'h-100'
            ]); ?>
        </div>
    <?php endwhile; ?>
</div>
```

---

## DO NOT REMOVE

```css
/* style.css:912 - CRITICAL for equal heights */
.aitsc-grid {
    align-items: stretch;  /* DO NOT REMOVE */
}
```

Removing `align-items: stretch` breaks equal-height card layouts.

---

**Last Updated**: 2024-12-31
**Version**: 4.0.0 (Harrison.ai White Theme)
