<?php
/**
 * Customizer Header Panel
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aitsc_customizer_header( $wp_customize ) {
	// Add section
	$wp_customize->add_section( 'aitsc_header', array(
		'title'    => __( 'Header', 'aitsc-pro-theme' ),
		'panel'    => 'aitsc_theme_settings',
		'priority' => 40,
	) );

	// Logo Width
	$wp_customize->add_setting( 'aitsc_logo_width', array(
		'default'           => 200,
		'sanitize_callback' => 'aitsc_sanitize_number_range',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_logo_width', array(
		'label'       => __( 'Logo Width (px)', 'aitsc-pro-theme' ),
		'description' => __( 'Width of the site logo', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_header',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 100,
			'max'  => 400,
			'step' => 10,
		),
		'priority'    => 10,
	) );

	// Sticky Header
	$wp_customize->add_setting( 'aitsc_sticky_header', array(
		'default'           => true,
		'sanitize_callback' => 'aitsc_sanitize_checkbox',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'aitsc_sticky_header', array(
		'label'       => __( 'Enable Sticky Header', 'aitsc-pro-theme' ),
		'description' => __( 'Header stays at top when scrolling', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_header',
		'type'        => 'checkbox',
		'priority'    => 20,
	) );

	// Header Background
	$wp_customize->add_setting( 'aitsc_header_bg', array(
		'default'           => '#ffffff',
		'sanitize_callback' => 'aitsc_sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'aitsc_header_bg', array(
		'label'       => __( 'Header Background Color', 'aitsc-pro-theme' ),
		'description' => __( 'Background color for header', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_header',
		'priority'    => 30,
	) ) );

	// Header Transparency
	$wp_customize->add_setting( 'aitsc_header_transparency', array(
		'default'           => 100,
		'sanitize_callback' => 'aitsc_sanitize_number_range',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_header_transparency', array(
		'label'       => __( 'Header Opacity (%)', 'aitsc-pro-theme' ),
		'description' => __( 'Transparency level (100 = opaque)', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_header',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 10,
		),
		'priority'    => 40,
	) );
}
