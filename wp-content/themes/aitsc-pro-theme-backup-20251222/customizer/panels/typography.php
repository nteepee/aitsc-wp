<?php
/**
 * Customizer Typography Panel
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aitsc_customizer_typography( $wp_customize ) {
	// Add section
	$wp_customize->add_section( 'aitsc_typography', array(
		'title'    => __( 'Typography', 'aitsc-pro-theme' ),
		'panel'    => 'aitsc_theme_settings',
		'priority' => 20,
	) );

	// Font Family
	$wp_customize->add_setting( 'aitsc_font_family', array(
		'default'           => 'inter',
		'sanitize_callback' => 'aitsc_sanitize_select',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_font_family', array(
		'label'       => __( 'Font Family', 'aitsc-pro-theme' ),
		'description' => __( 'Choose the primary font for your site', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_typography',
		'type'        => 'select',
		'choices'     => array(
			'inter'    => __( 'Inter (Recommended)', 'aitsc-pro-theme' ),
			'gt-eesti' => __( 'GT Eesti Display (Premium)', 'aitsc-pro-theme' ),
			'manrope'  => __( 'Manrope', 'aitsc-pro-theme' ),
			'dm-sans'  => __( 'DM Sans', 'aitsc-pro-theme' ),
			'system'   => __( 'System Font', 'aitsc-pro-theme' ),
		),
		'priority'    => 10,
	) );

	// Base Font Size
	$wp_customize->add_setting( 'aitsc_base_font_size', array(
		'default'           => 16,
		'sanitize_callback' => 'aitsc_sanitize_number_range',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_base_font_size', array(
		'label'       => __( 'Base Font Size (px)', 'aitsc-pro-theme' ),
		'description' => __( 'Default body text size', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_typography',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 14,
			'max'  => 20,
			'step' => 1,
		),
		'priority'    => 20,
	) );

	// Heading Font Weight
	$wp_customize->add_setting( 'aitsc_heading_weight', array(
		'default'           => 700,
		'sanitize_callback' => 'aitsc_sanitize_select',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_heading_weight', array(
		'label'       => __( 'Heading Font Weight', 'aitsc-pro-theme' ),
		'description' => __( 'Weight for h1-h6 headings', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_typography',
		'type'        => 'select',
		'choices'     => array(
			'200' => __( 'Extra Light (200)', 'aitsc-pro-theme' ),
			'300' => __( 'Light (300)', 'aitsc-pro-theme' ),
			'400' => __( 'Regular (400)', 'aitsc-pro-theme' ),
			'500' => __( 'Medium (500)', 'aitsc-pro-theme' ),
			'700' => __( 'Bold (700)', 'aitsc-pro-theme' ),
		),
		'priority'    => 30,
	) );

	// Body Font Weight
	$wp_customize->add_setting( 'aitsc_body_weight', array(
		'default'           => 300,
		'sanitize_callback' => 'aitsc_sanitize_select',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_body_weight', array(
		'label'       => __( 'Body Font Weight', 'aitsc-pro-theme' ),
		'description' => __( 'Weight for body text', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_typography',
		'type'        => 'select',
		'choices'     => array(
			'200' => __( 'Extra Light (200)', 'aitsc-pro-theme' ),
			'300' => __( 'Light (300)', 'aitsc-pro-theme' ),
			'400' => __( 'Regular (400)', 'aitsc-pro-theme' ),
		),
		'priority'    => 40,
	) );
}
