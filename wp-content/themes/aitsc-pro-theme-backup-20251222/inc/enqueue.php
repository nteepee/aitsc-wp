<?php
/**
 * Enqueue scripts and styles
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue styles
 */
function aitsc_enqueue_styles() {
	// Theme stylesheet
	wp_enqueue_style(
		'aitsc-style',
		get_stylesheet_uri(),
		array(),
		AITSC_VERSION
	);

	// === CRITICAL FOUNDATION FIXES (Load First) ===
	// Phase 01: Critical Foundation Fixes - z-index, positioning, container visibility
	wp_enqueue_style(
		'aitsc-critical-foundation',
		AITSC_THEME_URI . '/assets/css/01-critical-foundation-fixes.css',
		array( 'aitsc-style' ),
		AITSC_VERSION
	);

	// Phase 01: Design System Consolidation - unified colors, typography, components
	wp_enqueue_style(
		'aitsc-design-system-consolidated',
		AITSC_THEME_URI . '/assets/css/02-design-system-consolidated.css',
		array( 'aitsc-critical-foundation' ),
		AITSC_VERSION
	);

	// Phase 01: Responsive Grid System - mobile-first layouts, components
	wp_enqueue_style(
		'aitsc-responsive-grid-system',
		AITSC_THEME_URI . '/assets/css/03-responsive-grid-system.css',
		array( 'aitsc-design-system-consolidated' ),
		AITSC_VERSION
	);

	// === LEGACY DESKTOP-FIRST STYLES (Load After Foundation) ===
	// Design system (Phase 2) - Keep for compatibility
	wp_enqueue_style(
		'aitsc-design-system',
		AITSC_THEME_URI . '/assets/css/design-system.css',
		array( 'aitsc-responsive-grid-system' ),
		AITSC_VERSION
	);

	// Components (Phase 2)
	wp_enqueue_style(
		'aitsc-components',
		AITSC_THEME_URI . '/assets/css/components.css',
		array( 'aitsc-design-system' ),
		AITSC_VERSION
	);

	// Animations (Phase 7)
	wp_enqueue_style(
		'aitsc-animations',
		AITSC_THEME_URI . '/assets/css/animations.css',
		array( 'aitsc-components' ),
		AITSC_VERSION
	);

	// Advanced scroll animations (Phase 3 - Group 1)
	wp_enqueue_style(
		'aitsc-scroll-animations',
		AITSC_THEME_URI . '/assets/css/scroll-animations-advanced.css',
		array( 'aitsc-animations' ),
		AITSC_VERSION
	);

	// Homepage styles (Phase 5)
	wp_enqueue_style(
		'aitsc-homepage',
		AITSC_THEME_URI . '/assets/css/homepage.css',
		array( 'aitsc-components' ),
		AITSC_VERSION
	);

	// Advanced Homepage styles (Phase 5 Enhanced)
	wp_enqueue_style(
		'aitsc-homepage-advanced',
		AITSC_THEME_URI . '/assets/css/homepage-advanced.css',
		array( 'aitsc-components' ),
		AITSC_VERSION
	);

	// Custom Post Types styles (Phase 4)
	wp_enqueue_style(
		'aitsc-cpt',
		AITSC_THEME_URI . '/assets/css/cpt.css',
		array( 'aitsc-components' ),
		AITSC_VERSION
	);

	// Responsive styles (Phase 3)
	wp_enqueue_style(
		'aitsc-responsive',
		AITSC_THEME_URI . '/assets/css/responsive.css',
		array( 'aitsc-cpt' ),
		AITSC_VERSION
	);

	// Dark theme CSS
	wp_enqueue_style(
		'aitsc-dark-theme',
		AITSC_THEME_URI . '/assets/css/dark-theme.css',
		array( 'aitsc-design-system' ),
		AITSC_VERSION
	);

	// WorldQuant Homepage CSS (Phase 1 Implementation)
	wp_enqueue_style(
		'aitsc-worldquant-homepage',
		AITSC_THEME_URI . '/assets/css/worldquant-homepage.css',
		array( 'aitsc-components', 'aitsc-dark-theme' ),
		AITSC_VERSION
	);

	// Pure CSS Hero Background Effects (replaces background images)
	wp_enqueue_style(
		'aitsc-hero-background-effects',
		AITSC_THEME_URI . '/assets/css/hero-background-effects.css',
		array( 'aitsc-worldquant-homepage' ),
		AITSC_VERSION
	);

	// Enhanced accessibility CSS
	wp_enqueue_style(
		'aitsc-accessibility',
		AITSC_THEME_URI . '/assets/css/accessibility.css',
		array( 'aitsc-design-system' ),
		AITSC_VERSION
	);

	// Critical Layout Fixes - Container visibility and scrolling fixes
	wp_enqueue_style(
		'aitsc-layout-fixes',
		AITSC_THEME_URI . '/assets/css/layout-fixes.css',
		array( 'aitsc-accessibility', 'aitsc-worldquant-homepage' ),
		AITSC_VERSION
	);

	// Z-Index Layering Fixes - Navigation and footer z-index issues
	wp_enqueue_style(
		'aitsc-z-index-fixes',
		AITSC_THEME_URI . '/assets/css/z-index-layering-fixes.css',
		array( 'aitsc-layout-fixes' ),
		AITSC_VERSION
	);

	// Homepage Layout Fixes - Hero section and content organization
	wp_enqueue_style(
		'aitsc-homepage-layout-fixes',
		AITSC_THEME_URI . '/assets/css/homepage-layout-fixes.css',
		array( 'aitsc-z-index-fixes' ),
		AITSC_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'aitsc_enqueue_styles' );

/**
 * Enqueue scripts
 */
function aitsc_enqueue_scripts() {
	// Navigation script (Phase 3) - simplified for testing
	wp_enqueue_script(
		'aitsc-navigation',
		AITSC_THEME_URI . '/assets/js/navigation.js',
		array(),
		AITSC_VERSION,
		true
	);

	// Animations script (Phase 7)
	wp_enqueue_script(
		'aitsc-animations',
		AITSC_THEME_URI . '/assets/js/animations.js',
		array(),
		AITSC_VERSION,
		true
	);

	// Forms script (Phase 8)
	wp_enqueue_script(
		'aitsc-forms',
		AITSC_THEME_URI . '/assets/js/forms.js',
		array(),
		AITSC_VERSION,
		true
	);

	// Enhanced dark mode module
	wp_enqueue_script(
		'aitsc-dark-mode',
		AITSC_THEME_URI . '/assets/js/dark-mode.js',
		array(),
		AITSC_VERSION,
		true
	);

	// Dark mode toggle (enhanced)
	wp_enqueue_script(
		'aitsc-dark-mode-toggle',
		AITSC_THEME_URI . '/assets/js/dark-mode-toggle.js',
		array('aitsc-dark-mode'),
		AITSC_VERSION,
		true
	);

	// Accessibility manager
	wp_enqueue_script(
		'aitsc-accessibility',
		AITSC_THEME_URI . '/assets/js/accessibility.js',
		array('aitsc-dark-mode'),
		AITSC_VERSION,
		true
	);

	// Enhanced form validation
	wp_enqueue_script(
		'aitsc-form-validation',
		AITSC_THEME_URI . '/assets/js/form-validation.js',
		array('aitsc-accessibility'),
		AITSC_VERSION,
		true
	);

	// Enhanced interactive elements and forms (Phase 9)
	wp_enqueue_script(
		'aitsc-interactive',
		AITSC_THEME_URI . '/assets/js/aitsc-interactive.js',
		array('jquery', 'aos'), // AOS for animations
		AITSC_VERSION,
		true
	);

	// Animation manager with Page Visibility API
	wp_enqueue_script(
		'aitsc-animation-manager',
		AITSC_THEME_URI . '/assets/js/animation-manager.js',
		array('aitsc-dark-mode', 'aitsc-accessibility'),
		AITSC_VERSION,
		true
	);

	// Homepage animations (carousel, counters)
	wp_enqueue_script(
		'aitsc-homepage-animations',
		AITSC_THEME_URI . '/assets/js/homepage-animations.js',
		array( 'jquery' ),
		AITSC_VERSION,
		true
	);

	// Localize script for AJAX
	wp_localize_script(
		'aitsc-navigation',
		'aitscData',
		array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'aitsc-nonce' ),
		)
	);

	// Add comment reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'aitsc_enqueue_scripts' );

// Fallback: Add scripts via wp_footer if enqueue doesn't work (DISABLED - scripts loaded via wp_enqueue_scripts)
// function aitsc_add_scripts_to_footer() {
//	?>
//	<!-- AITSC Theme: Scripts loading test -->
//	<script id="aitsc-navigation-js" src="<?php echo AITSC_THEME_URI . '/assets/js/navigation.js?ver=' . AITSC_VERSION; ?>"></script>
//	<script id="aitsc-animations-js" src="<?php echo AITSC_THEME_URI . '/assets/js/animations.js?ver=' . AITSC_VERSION; ?>"></script>
//	<script id="aitsc-dark-mode-js" src="<?php echo AITSC_THEME_URI . '/assets/js/dark-mode.js?ver=' . AITSC_VERSION; ?>"></script>
//	<script id="aitsc-accessibility-js" src="<?php echo AITSC_THEME_URI . '/assets/js/accessibility.js?ver=' . AITSC_VERSION; ?>"></script>
//	<?php
// }
// add_action( 'wp_footer', 'aitsc_add_scripts_to_footer' );

// Inline JavaScript fallback for immediate WorldQuant functionality
function aitsc_add_inline_worldquant_scripts() {
	?>
	<script>
	// WorldQuant Dark Mode Toggle
	document.addEventListener('DOMContentLoaded', function() {
		const darkModeToggle = document.querySelector('[data-theme-toggle]');
		const html = document.documentElement;

		if (darkModeToggle) {
			darkModeToggle.addEventListener('click', function() {
				const currentTheme = html.getAttribute('data-theme');
				const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
				html.setAttribute('data-theme', newTheme);
				localStorage.setItem('aitsc-theme', newTheme);

				// Update toggle icon
				darkModeToggle.innerHTML = newTheme === 'dark' ? '🌙' : '🌙';
			});
		}

		// Initialize theme from localStorage or system preference
		const savedTheme = localStorage.getItem('aitsc-theme');
		const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
		const initialTheme = savedTheme || (systemPrefersDark ? 'dark' : 'light');
		html.setAttribute('data-theme', initialTheme);
	});

	// WorldQuant Neon Effects
	console.log('🚀 AITSC WorldQuant Theme Active');
	?>
	<style>
	/* WorldQuant Neon Button Effects */
	.btn-neon {
		border-color: #00e128 !important;
		color: #00e128 !important;
		box-shadow: 0 0 10px rgba(0, 225, 40, 0.3) !important;
	}

	.btn-neon:hover {
		background-color: #00e128 !important;
		color: #000000 !important;
		box-shadow: 0 0 20px rgba(0, 225, 40, 0.5) !important;
	}
	</style>
	<?php
}
add_action( 'wp_head', 'aitsc_add_inline_worldquant_scripts' );

/**
 * Enqueue Customizer preview scripts
 */
function aitsc_customizer_preview_scripts() {
	wp_enqueue_script(
		'aitsc-customizer-preview',
		AITSC_THEME_URI . '/assets/js/customizer-preview.js',
		array( 'customize-preview' ),
		AITSC_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'aitsc_customizer_preview_scripts' );

/**
 * Enqueue admin styles and scripts
 */
function aitsc_admin_scripts() {
	wp_enqueue_style(
		'aitsc-admin',
		AITSC_THEME_URI . '/assets/css/admin.css',
		array(),
		AITSC_VERSION
	);
}
add_action( 'admin_enqueue_scripts', 'aitsc_admin_scripts' );
