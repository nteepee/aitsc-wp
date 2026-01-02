# System Architecture

## 1. Directory Structure
The AITSC Pro Theme follows a modular component-based architecture within the WordPress structure.

```
aitsc-pro-theme/
├── assets/                  # Compiled assets
│   ├── css/                 # Global and legacy styles
│   └── js/                  # Interactive functionality modules
├── components/              # Self-contained UI components
│   ├── card/                # Card variants (feature, product, etc.)
│   ├── hero/                # Hero section system
│   ├── trust-bar/           # Social proof component
│   └── logo-carousel/       # Animated logo display
├── inc/                     # Core theme logic
│   ├── components.php       # Component registration and enqueuing
│   ├── enqueue.php          # Script/style management
│   └── template-tags.php    # Custom template helper functions
├── template-parts/          # Complex template segments
│   └── contact-form-advanced.php # Multi-step form logic
└── [templates].php          # Standard WordPress template hierarchy
```

## 2. Component Loading Lifecycle
1. **Registration**: Components are registered in `inc/components.php`.
2. **Logic Inclusion**: Component PHP files are required during `after_setup_theme`.
3. **Asset Enqueuing**: CSS and JS for specific components are enqueued only when needed, or globally if common, during `wp_enqueue_scripts`.
4. **Rendering**: Templates call component render functions (e.g., `aitsc_render_hero($args)`) with specific configuration.

## 3. Data Management
- **Structured Content**: Advanced Custom Fields (ACF) is used to define custom fields for Solutions and Case Studies.
- **Static Data**: `inc/aitsc-content-data.php` provides fallback or static service data where dynamic fields are not yet populated.
- **Form Data**: Handled via AJAX (`inc/contact-ajax.php`) with security nonces and server-side validation.

## 4. Key Systems
- **Theme Engine**: Custom logic for handling light/dark theme variables (currently standardized to white).
- **Responsive System**: Custom CSS grid and flexbox system based on 5 standardized breakpoints.
- **Accessibility Layer**: Dedicated JavaScript manager (`assets/js/accessibility.js`) for focus management and ARIA updates.
