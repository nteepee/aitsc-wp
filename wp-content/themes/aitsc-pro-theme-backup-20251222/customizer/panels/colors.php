<?php
/**
 * Customizer Colors Panel
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aitsc_customizer_colors( $wp_customize ) {
	// Add section
	$wp_customize->add_section( 'aitsc_colors', array(
		'title'    => __( 'Colors', 'aitsc-pro-theme' ),
		'panel'    => 'aitsc_theme_settings',
		'priority' => 10,
	) );

	// Primary Color
	$wp_customize->add_setting( 'aitsc_primary_color', array(
		'default'           => '#005cb2',
		'sanitize_callback' => 'aitsc_sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'aitsc_primary_color', array(
		'label'       => __( 'Primary Color (Brand Blue)', 'aitsc-pro-theme' ),
		'description' => __( 'Main brand color used for buttons, links, and accents', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_colors',
		'priority'    => 10,
	) ) );

	// Accent Neon
	$wp_customize->add_setting( 'aitsc_accent_neon', array(
		'default'           => '#00e128',
		'sanitize_callback' => 'aitsc_sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'aitsc_accent_neon', array(
		'label'       => __( 'Accent Neon Green', 'aitsc-pro-theme' ),
		'description' => __( 'Neon green accent (WorldQuant-inspired)', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_colors',
		'priority'    => 20,
	) ) );

	// Accent Orange
	$wp_customize->add_setting( 'aitsc_accent_orange', array(
		'default'           => '#fa8c24',
		'sanitize_callback' => 'aitsc_sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'aitsc_accent_orange', array(
		'label'       => __( 'Accent Orange', 'aitsc-pro-theme' ),
		'description' => __( 'Secondary accent for CTAs and highlights', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_colors',
		'priority'    => 30,
	) ) );

	// Accent Blue
	$wp_customize->add_setting( 'aitsc_accent_blue', array(
		'default'           => '#0a8afa',
		'sanitize_callback' => 'aitsc_sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'aitsc_accent_blue', array(
		'label'       => __( 'Accent Blue', 'aitsc-pro-theme' ),
		'description' => __( 'Light blue accent for gradients', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_colors',
		'priority'    => 40,
	) ) );

	// Enable Gradients
	$wp_customize->add_setting( 'aitsc_enable_gradients', array(
		'default'           => true,
		'sanitize_callback' => 'aitsc_sanitize_checkbox',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_enable_gradients', array(
		'label'       => __( 'Enable Gradient Effects', 'aitsc-pro-theme' ),
		'description' => __( 'Use gradient colors for hero sections and CTAs', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_colors',
		'type'        => 'checkbox',
		'priority'    => 50,
	) );
}
