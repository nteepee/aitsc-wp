# AITSC Pro Theme - Front Page Setup Instructions

## WordPress Configuration Required

The AITSC Pro Theme includes a custom front-page.php template that provides the professional homepage design. To ensure this template is used:

### Step 1: Set WordPress Front Page
1. Go to WordPress Admin: http://localhost:8888/aitsc-wp/wp-admin/
2. Navigate to **Settings → Reading**
3. Select **"A static page"** for "Front page displays"
4. Choose a page for the "Front page" (create one if needed)
5. Save changes

### Step 2: Configure Theme Options
1. Go to **Appearance → Customize**
2. Configure homepage settings in "Homepage" panel:
   - Hero Headline: "Solving Your Most Expensive Problems"
   - Hero Subheadline: Your custom description
   - Hero CTA text and URL
   - Display solutions section: ✓

### Step 3: Add Navigation Menu
1. Go to **Appearance → Menus**
2. Create a new menu and assign to "Primary Menu"
3. Add your site pages to the menu

## Current Theme Features

✅ **Professional Design System:**
- AITSC brand colors (#005cb2 blue, #00e128 neon green)
- WorldQuant-inspired modern layout
- GT Eesti Display typography with Inter fallback

✅ **Complete Template System:**
- front-page.php (professional homepage)
- header.php + template-parts/navigation.php
- footer.php with 4-column widget areas
- sidebar.php for blog layouts

✅ **Custom Theme Customizer:**
- Colors panel (primary, neon, orange, blue)
- Typography panel (fonts, sizes, weights)
- Layout panel (container width, spacing)
- Header panel (logo, sticky, transparency)
- Footer panel (columns, background, copyright)
- Homepage panel (hero section, CTA, solutions)

✅ **Responsive Design:**
- Mobile-first approach
- Tablet layouts (768px+)
- Desktop enhancements (1200px+)
- Touch-friendly interactions

✅ **Accessibility Features:**
- WCAG 2.1 AA compliance
- ARIA labels and landmarks
- Keyboard navigation support
- Screen reader optimization

## Troubleshooting

If the theme still looks "ugly" or unstyled:

1. **Check WordPress Settings:** Ensure static front page is configured
2. **Clear Browser Cache:** Hard refresh (Ctrl+F5) or clear cache
3. **Check CSS Loading:** View browser DevTools → Network tab
4. **Verify Theme Activation:** Appearance → Themes → AITSC Pro Theme is active

## Next Steps

Phase 1 foundation is complete. Phase 2 will include:
- Custom post types for Services and Case Studies
- Service page templates
- Team member system
- Advanced component library

The theme provides an excellent foundation for the full AITSC website redesign.