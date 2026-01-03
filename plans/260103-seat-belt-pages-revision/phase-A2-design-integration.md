# Phase A2: Design Integration

**Execution Group**: A (Parallel with A1)
**Agent Type**: fullstack-developer
**Estimated Time**: 2-3 hours
**File Ownership**: Template Files (EXCLUSIVE WRITE)

---

## Objective

Integrate Problem-Solution and Related Pages components into single-solutions.php template for all 8 seat belt pages, ensuring visual consistency and proper component rendering.

---

## Component Inventory

### Already Created (Phase 2)
- ✅ `components/problem-solution/problem-solution-block.php`
- ✅ `components/problem-solution/problem-solution-block.css`
- ✅ `components/problem-solution/problem-solution-animations.js`
- ✅ `components/navigation/related-pages.php`
- ✅ `components/navigation/related-pages.css`

### Registered in inc/components.php
- ✅ All CSS/JS enqueued
- ✅ Component functions loaded

---

## Template Integration Strategy

### single-solutions.php Structure

**Current Sections**:
1. Hero (✅ Fixed in Phase 1)
2. Features Grid
3. Technical Specifications
4. Installation Guide
5. Gallery/Documentation

**Add New Sections**:
1. **Problem-Solution Block** (after Hero, before Features)
2. **Related Pages Navigation** (after Gallery, before Footer)

---

## Implementation Tasks

### Task 1: Integrate Problem-Solution Component

**Location**: `single-solutions.php` line ~80 (after hero, before features)

**Code to Add**:
```php
<?php
// Problem-Solution Section
if (function_exists('aitsc_render_problem_solution')) {
    // Get ACF problem cards data
    $problem_cards = get_field('problem_cards', $solution_id);
    $solution_overview = get_field('solution_overview', $solution_id);

    if ($problem_cards || $solution_overview) {
        aitsc_render_problem_solution(array(
            'problems' => $problem_cards ?: array(),
            'solution_title' => $solution_overview['title'] ?? 'The Solution',
            'solution_subtitle' => $solution_overview['subtitle'] ?? '',
            'solution_text' => $solution_overview['text'] ?? '',
            'highlight' => array(
                'title' => $solution_overview['highlight_title'] ?? '',
                'text' => $solution_overview['highlight_text'] ?? ''
            ),
            'variant' => 'default'
        ));
    }
}
?>
```

**Validation**:
- Check ACF fields exist: `problem_cards`, `solution_overview`
- Fallback to empty arrays if fields missing
- Component renders without errors

---

### Task 2: Integrate Related Pages Navigation

**Location**: `single-solutions.php` line ~250 (after gallery, before footer)

**Code to Add**:
```php
<?php
// Related Pages Navigation
if (function_exists('aitsc_render_related_pages')) {
    aitsc_render_related_pages(array(
        'post_id' => $solution_id,
        'taxonomy' => 'solution_category',
        'max_posts' => 6,
        'exclude_current' => true,
        'title' => 'Related Solutions',
        'subtitle' => 'Explore our complete passenger monitoring system'
    ));
}
?>
```

**Validation**:
- Component auto-detects taxonomy terms
- Shows up to 6 related posts
- Excludes current post
- Renders with proper badges (Product/Guide/Component/Use Case)

---

### Task 3: Verify Component Rendering

**Check List**:
- [ ] Problem-Solution appears after hero on all 8 pages
- [ ] Problem cards display with icons and animations
- [ ] Solution overview has highlight box
- [ ] Related Pages appears at bottom of all 8 pages
- [ ] Related cards show images (if available)
- [ ] Smart badges detect page type correctly
- [ ] No PHP errors in console
- [ ] CSS animations trigger on scroll

---

### Task 4: Template Structure Optimization

**Add Wrapper Sections** for better spacing:

```php
<!-- Problem-Solution Wrapper -->
<div class="aitsc-section-wrapper aitsc-section-wrapper--dark">
    <?php
    // Problem-Solution component here
    ?>
</div>

<!-- Related Pages Wrapper -->
<div class="aitsc-section-wrapper aitsc-section-wrapper--gradient">
    <?php
    // Related Pages component here
    ?>
</div>
```

**CSS for Wrappers** (add to style.css if not exists):
```css
.aitsc-section-wrapper {
    position: relative;
    overflow: hidden;
}

.aitsc-section-wrapper--dark {
    background: linear-gradient(180deg,
        rgba(15, 23, 42, 0.9) 0%,
        rgba(30, 41, 59, 0.8) 100%
    );
}

.aitsc-section-wrapper--gradient {
    background: linear-gradient(180deg,
        rgba(30, 41, 59, 0.8) 0%,
        rgba(15, 23, 42, 0.9) 100%
    );
}
```

---

## Visual Consistency Checks

### Color Palette Alignment
- Primary Blue: `#3b82f6` (rgb(59, 130, 246))
- Red (Problems): `#ef4444` (rgb(239, 68, 68))
- Dark Background: `rgba(15, 23, 42, 0.9)`
- Light Text: `#cbd5e1`

### Typography Consistency
- Headings: `'Inter', sans-serif`
- Font sizes match WorldQuant style
- Line heights for readability

### Spacing Consistency
- Section padding: `6rem 0` desktop, `3rem 0` mobile
- Grid gaps: `2rem` desktop, `1rem` mobile
- Card padding: `1.75rem` desktop, `1.25rem` mobile

---

## Responsive Verification

**Breakpoints to Test**:
1. **Mobile** (375px): Cards stack vertically, text ≥16px
2. **Phablet** (576px): 2-column grid for problems
3. **Tablet** (768px): 2-column grid for related pages
4. **Desktop** (992px): 3-column grid for problems
5. **Large Desktop** (1200px+): 4-column grid for problems

**Test Method**:
```bash
# Use browser devtools or Claude with Chrome
# Resize viewport to each breakpoint
# Verify no horizontal overflow
# Check text readability
# Ensure CTAs in thumb zone on mobile
```

---

## File Ownership Rules

**EXCLUSIVE WRITE ACCESS**:
- ✅ `single-solutions.php` (this phase only)
- ✅ `template-parts/` (if needed for modular sections)
- ✅ `style.css` (wrapper CSS only)

**READ ONLY** (owned by A1):
- ❌ ACF content fields (`problem_cards`, `solution_overview`)
- ❌ ACF image fields
- ❌ Hero section data

**READ ONLY** (owned by B2):
- ❌ Component CSS files (already created in Phase 2)
- ❌ Responsive patches

---

## Testing Protocol

### PHP Syntax Check
```bash
php -l wp-content/themes/aitsc-pro-theme/single-solutions.php
```

### Visual Inspection
```bash
# Visit all 8 pages
open http://localhost:8888/solutions/seat-belt-detection-system/
open http://localhost:8888/solutions/seatbelt-alert-system-for-buses/
open http://localhost:8888/solutions/fleet-seatbelt-compliance/
open http://localhost:8888/solutions/rideshare-seatbelt-monitoring/
open http://localhost:8888/solutions/seat-belt-installation-guide/
open http://localhost:8888/solutions/buckle-sensor-component/
open http://localhost:8888/solutions/seat-sensor-component/
open http://localhost:8888/solutions/display-unit-component/
```

### Console Error Check
```javascript
// Open browser console, check for:
// - No PHP errors
// - No JS errors
// - Intersection Observer working
// - Animations triggering
```

---

## Deliverables

1. Modified `single-solutions.php` with integrated components
2. Added wrapper CSS (if not exists)
3. Visual verification screenshots (optional)
4. Report: `reports/fullstack-dev-260104-design-integration.md`

**Report Should Include**:
- Components integrated successfully
- All 8 pages render without errors
- Responsive behavior verified
- Any issues encountered and solutions

---

## Error Handling

**If ACF Fields Missing**:
- Components render with empty arrays (graceful degradation)
- No PHP warnings/errors
- Layout structure still intact

**If Component Functions Missing**:
```php
if (function_exists('aitsc_render_problem_solution')) {
    // render component
} else {
    // skip silently, log to error_log
    error_log('Problem-Solution component not registered');
}
```

---

**EXCLUSIVE FILE OWNERSHIP**: Template Files ONLY
**DO NOT EDIT**: ACF Content, Images, Component CSS
**RUN in parallel with Phase A1**
