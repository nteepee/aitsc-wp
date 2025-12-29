<?php
/**
 * Theme Customizer
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer settings
 */
function aitsc_customize_register( $wp_customize ) {
	// Create main panel
	$wp_customize->add_panel( 'aitsc_theme_settings', array(
		'title'       => __( 'AITSC Pro Theme Settings', 'aitsc-pro-theme' ),
		'description' => __( 'Customize your AITSC website appearance and functionality', 'aitsc-pro-theme' ),
		'priority'    => 10,
	) );

	// Load panel configurations
	require_once AITSC_THEME_DIR . '/customizer/panels/colors.php';
	require_once AITSC_THEME_DIR . '/customizer/panels/typography.php';
	require_once AITSC_THEME_DIR . '/customizer/panels/layout.php';
	require_once AITSC_THEME_DIR . '/customizer/panels/header.php';
	require_once AITSC_THEME_DIR . '/customizer/panels/footer.php';
	require_once AITSC_THEME_DIR . '/customizer/panels/homepage.php';
	require_once AITSC_THEME_DIR . '/customizer/panels/cpt.php';

	// Register each panel
	aitsc_customizer_colors( $wp_customize );
	aitsc_customizer_typography( $wp_customize );
	aitsc_customizer_layout( $wp_customize );
	aitsc_customizer_header( $wp_customize );
	aitsc_customizer_footer( $wp_customize );
	aitsc_customizer_homepage( $wp_customize );
	aitsc_customizer_cpt( $wp_customize );
}
add_action( 'customize_register', 'aitsc_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously
 */
function aitsc_customize_preview_js() {
	wp_enqueue_script(
		'aitsc-customizer',
		AITSC_THEME_URI . '/assets/js/customizer-preview.js',
		array( 'customize-preview' ),
		AITSC_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'aitsc_customize_preview_js' );
