<?php
/**
 * Theme options and support
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register custom image sizes
 */
function aitsc_register_image_sizes() {
	// Hero images (16:9 aspect ratio)
	add_image_size( 'aitsc-hero', 1920, 800, true );

	// Feature cards (4:3 aspect ratio)
	add_image_size( 'aitsc-feature', 800, 600, true );

	// Thumbnails (4:3 aspect ratio)
	add_image_size( 'aitsc-thumbnail', 400, 300, true );

	// Case study images (16:9 aspect ratio)
	add_image_size( 'aitsc-case-study', 1200, 675, true );

	// Logo size
	add_image_size( 'aitsc-logo', 300, 100, false );
}
add_action( 'after_setup_theme', 'aitsc_register_image_sizes' );

/**
 * Add custom image sizes to Media Library
 */
function aitsc_custom_image_sizes( $sizes ) {
	return array_merge( $sizes, array(
		'aitsc-hero'       => __( 'Hero Image', 'aitsc-pro-theme' ),
		'aitsc-feature'    => __( 'Feature Card', 'aitsc-pro-theme' ),
		'aitsc-thumbnail'  => __( 'Custom Thumbnail', 'aitsc-pro-theme' ),
		'aitsc-case-study' => __( 'Case Study Image', 'aitsc-pro-theme' ),
		'aitsc-logo'       => __( 'Logo Size', 'aitsc-pro-theme' ),
	) );
}
add_filter( 'image_size_names_choose', 'aitsc_custom_image_sizes' );

/**
 * Add theme support for various features
 */
function aitsc_add_theme_support() {
	// Enable support for Post Formats
	add_theme_support( 'post-formats', array(
		'aside',
		'gallery',
		'link',
		'image',
		'quote',
		'status',
		'video',
		'audio',
	) );

	// Add support for custom header
	add_theme_support( 'custom-header', array(
		'default-image'      => '',
		'width'              => 1920,
		'height'             => 800,
		'flex-height'        => true,
		'flex-width'         => true,
		'header-text'        => true,
		'default-text-color' => '005cb2',
	) );

	// Add support for custom background
	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) );

	// Add support for WooCommerce (optional)
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'aitsc_add_theme_support' );

/**
 * Set default theme mod values
 */
function aitsc_set_default_theme_mods() {
	$defaults = array(
		// Colors
		'aitsc_primary_color'    => '#005cb2',
		'aitsc_accent_neon'      => '#00e128',
		'aitsc_accent_orange'    => '#fa8c24',
		'aitsc_accent_blue'      => '#0a8afa',
		'aitsc_enable_gradients' => true,

		// Typography
		'aitsc_font_family'      => 'inter',
		'aitsc_base_font_size'   => 16,
		'aitsc_heading_weight'   => 700,
		'aitsc_body_weight'      => 300,

		// Layout
		'aitsc_container_width'  => 1200,
		'aitsc_section_padding'  => 80,
		'aitsc_grid_gap'         => 32,

		// Header
		'aitsc_logo_width'       => 200,
		'aitsc_sticky_header'    => true,
		'aitsc_header_bg'        => '#ffffff',
		'aitsc_header_transparency' => 100,

		// Footer
		'aitsc_footer_layout'    => '4-column',
		'aitsc_footer_bg'        => '#1a1a1a',
		'aitsc_copyright_text'   => sprintf(
			__( '© %s AITSC. All rights reserved.', 'aitsc-pro-theme' ),
			date( 'Y' )
		),

		// Homepage
		'aitsc_hero_headline'    => __( 'Solving Your Most Expensive Problems', 'aitsc-pro-theme' ),
		'aitsc_hero_subheadline' => __( 'Advanced technology solutions for fleet safety and operational excellence', 'aitsc-pro-theme' ),
		'aitsc_hero_cta_text'    => __( 'Get Started', 'aitsc-pro-theme' ),
		'aitsc_hero_cta_url'     => '/contact/',
		'aitsc_display_solutions' => true,
	);

	foreach ( $defaults as $mod => $value ) {
		if ( false === get_theme_mod( $mod ) ) {
			set_theme_mod( $mod, $value );
		}
	}
}
add_action( 'after_setup_theme', 'aitsc_set_default_theme_mods' );
