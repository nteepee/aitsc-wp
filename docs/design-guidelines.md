# Design Guidelines

## 1. Visual Identity

### 1.1 Color Palette
- **Primary**: AITSC Cyan (#005cb2) - `--aitsc-primary`
- **Secondary**: Slate 900 (#1E293B) - `--aitsc-text-primary`
- **Background**: Pure White (#FFFFFF) - `--aitsc-bg-primary`
- **Surface**: Slate 50 (#F8FAFC) - `--aitsc-bg-secondary`
- **Border**: Slate 200 (#E2E8F0) - `--aitsc-border`

### 1.2 Typography
- **Headings**: Bold, Slate 900. Use Cyan for emphasis spans.
- **Body**: Slate 600-700 for readability.
- **Accents**: Uppercase, tracked (2px) for subtitles and labels.

## 2. Component Design Standards

### 2.1 Hero Sections
The Hero section is the primary visual anchor for every page.

#### Standard Page Hero (`variant => 'page'`)
- **Background**: Soft gradient from Slate 50 to White.
- **Title**: Large, bold heading (h1).
- **Subtitle**: Cyan, uppercase label above the title.
- **Description**: Concise overview of the page content.
- **Usage**: Mandatory for all standard internal pages (About, Contact, Services listing).

#### Pillar/Product Hero (`variant => 'white-fullwidth'`)
- **Background**: High-quality photographic background.
- **Content Box**: Centered white box with background blur (glassmorphism).
- **Usage**: Used for high-conversion landing pages or key product pillars.

### 2.2 Cards & Grids
- **Border Radius**: 12-16px (`--aitsc-radius-lg`).
- **Shadows**: Soft, multi-layered shadows for depth (`--aitsc-shadow-md`).
- **Hover States**: Subtle lift (translateY) and Cyan border/icon color change.

## 3. Layout Principles
- **Container**: Max-width of 1200px.
- **Spacing**: Use a consistent 8px grid system (multiples of 4).
- **Vertical Rhythm**: Section padding typically 80px-120px (py-24).

## 4. Branding for Emphasis
- Use `<span class="text-cyan-600">Keyword</span>` within headings to highlight core service areas (e.g., "Fleet Safety", "Solutions", "Stories").
- This ensures visual consistency with the Harrison.ai medical-tech aesthetic while maintaining AITSC branding.
