<?php
/**
 * Enqueue scripts and styles
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Enqueue styles
 */
function aitsc_enqueue_styles()
{
	// Enqueue Google Fonts (Inter + Outfit -> Manrope)
	wp_enqueue_style('aitsc-google-fonts', 'https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap', array(), null);

	// 1.5. Google Material Symbols (Required for Prototype Icons)
	wp_enqueue_style(
		'aitsc-material-symbols',
		'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0',
		array(),
		null
	);

	// 2. CSS Variables (Design System) - Critical Dependency
	wp_enqueue_style(
		'aitsc-variables',
		AITSC_THEME_URI . '/assets/css/variables.css',
		array(),
		AITSC_VERSION
	);

	// 3. Main Theme Stylesheet (Resets + Base + Components)
	wp_enqueue_style(
		'aitsc-style',
		get_stylesheet_uri(),
		array('aitsc-variables'), // Depend on variables
		AITSC_VERSION
	);

	// 3. AOS Animation Library (Optional, keeping for potential utility)
	wp_enqueue_style('aos-css', 'https://unpkg.com/aos@2.3.4/dist/aos.css', array(), '2.3.4');
}
add_action('wp_enqueue_scripts', 'aitsc_enqueue_styles');

/**
 * Enqueue scripts
 */
function aitsc_enqueue_scripts()
{
	// AITSC Theme Core JS (Particles + Interactions)
	wp_enqueue_script(
		'aitsc-theme-core',
		AITSC_THEME_URI . '/assets/js/theme-core.js',
		array('jquery'), // Depends on jQuery
		AITSC_VERSION,
		true // Load in footer
	);

	// Register AOS library from CDN (stable version, footer loading for performance)
	wp_enqueue_script('aos', 'https://unpkg.com/aos@2.3.4/dist/aos.js', array(), '2.3.4', true);

	// Navigation script
	wp_enqueue_script(
		'aitsc-navigation',
		AITSC_THEME_URI . '/assets/js/navigation.js',
		array(),
		AITSC_VERSION,
		true
	);

	// WorldQuant-style Particle System
	wp_enqueue_script(
		'aitsc-particle-system',
		AITSC_THEME_URI . '/assets/js/particle-system.js',
		array(),
		AITSC_VERSION,
		true
	);

	// Scroll Animations (Phase 4)
	wp_enqueue_script(
		'aitsc-scroll-animations',
		AITSC_THEME_URI . '/assets/js/scroll-animations.js',
		array(),
		AITSC_VERSION,
		true
	);

	// --- The following scripts are planned for future phases but files don't exist yet ---
	// Commented out to prevent 500 errors and console pollution

	/**/

	// Forms script  
	wp_enqueue_script(
		'aitsc-forms',
		AITSC_THEME_URI . '/assets/js/forms.js',
		array(),
		AITSC_VERSION,
		true
	);

	/*

	// Enhanced dark mode module (Future Phase)
	wp_enqueue_script(
		'aitsc-dark-mode',
		AITSC_THEME_URI . '/assets/js/dark-mode.js',
		array(),
		AITSC_VERSION,
		true
	);

	// Dark mode toggle (Future Phase)
	wp_enqueue_script(
		'aitsc-dark-mode-toggle',
		AITSC_THEME_URI . '/assets/js/dark-mode-toggle.js',
		array('aitsc-dark-mode'),
		AITSC_VERSION,
		true
	);

	// Accessibility manager (Future Phase)
	wp_enqueue_script(
		'aitsc-accessibility',
		AITSC_THEME_URI . '/assets/js/accessibility.js',
		array('aitsc-dark-mode'),
		AITSC_VERSION,
		true
	);

	// Enhanced form validation (Future Phase)
	wp_enqueue_script(
		'aitsc-form-validation',
		AITSC_THEME_URI . '/assets/js/form-validation.js',
		array('aitsc-accessibility'),
		AITSC_VERSION,
		true
	);

	// Enhanced interactive elements (Future Phase)
	wp_enqueue_script(
		'aitsc-interactive',
		AITSC_THEME_URI . '/assets/js/aitsc-interactive.js',
		array('jquery', 'aos'),
		AITSC_VERSION,
		true
	);

	// Animation manager (Future Phase)
	wp_enqueue_script(
		'aitsc-animation-manager',
		AITSC_THEME_URI . '/assets/js/animation-manager.js',
		array('aitsc-dark-mode', 'aitsc-accessibility'),
		AITSC_VERSION,
		true
	);

	// Homepage animations (Future Phase)
	wp_enqueue_script(
		'aitsc-homepage-animations',
		AITSC_THEME_URI . '/assets/js/homepage-animations.js',
		array('jquery'),
		AITSC_VERSION,
		true
	);
	*/

	// Localize script for AJAX
	wp_localize_script(
		'aitsc-navigation',
		'aitscData',
		array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('aitsc-nonce'),
		)
	);

	// Add comment reply script
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'aitsc_enqueue_scripts');

/**
 * Enqueue Customizer preview scripts
 */
function aitsc_customizer_preview_scripts()
{
	wp_enqueue_script(
		'aitsc-customizer-preview',
		AITSC_THEME_URI . '/assets/js/customizer-preview.js',
		array('customize-preview'),
		AITSC_VERSION,
		true
	);
}
add_action('customize_preview_init', 'aitsc_customizer_preview_scripts');

/**
 * Enqueue admin styles and scripts
 */
function aitsc_admin_scripts()
{
	// REMOVED: admin.css doesn't exist - was causing 404 errors
	// wp_enqueue_style(
	// 	'aitsc-admin',
	// 	AITSC_THEME_URI . '/assets/css/admin.css',
	// 	array(),
	// 	AITSC_VERSION
	// );
}
add_action('admin_enqueue_scripts', 'aitsc_admin_scripts');
