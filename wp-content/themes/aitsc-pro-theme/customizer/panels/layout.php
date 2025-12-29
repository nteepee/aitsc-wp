<?php
/**
 * Customizer Layout Panel
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aitsc_customizer_layout( $wp_customize ) {
	// Add section
	$wp_customize->add_section( 'aitsc_layout', array(
		'title'    => __( 'Layout', 'aitsc-pro-theme' ),
		'panel'    => 'aitsc_theme_settings',
		'priority' => 30,
	) );

	// Container Width
	$wp_customize->add_setting( 'aitsc_container_width', array(
		'default'           => 1200,
		'sanitize_callback' => 'aitsc_sanitize_number_range',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_container_width', array(
		'label'       => __( 'Container Max Width (px)', 'aitsc-pro-theme' ),
		'description' => __( 'Maximum width for site content', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_layout',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 1000,
			'max'  => 1600,
			'step' => 50,
		),
		'priority'    => 10,
	) );

	// Section Padding
	$wp_customize->add_setting( 'aitsc_section_padding', array(
		'default'           => 80,
		'sanitize_callback' => 'aitsc_sanitize_number_range',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_section_padding', array(
		'label'       => __( 'Section Padding (px)', 'aitsc-pro-theme' ),
		'description' => __( 'Vertical padding for sections', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_layout',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 40,
			'max'  => 120,
			'step' => 8,
		),
		'priority'    => 20,
	) );

	// Grid Gap
	$wp_customize->add_setting( 'aitsc_grid_gap', array(
		'default'           => 32,
		'sanitize_callback' => 'aitsc_sanitize_number_range',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_grid_gap', array(
		'label'       => __( 'Grid Gap (px)', 'aitsc-pro-theme' ),
		'description' => __( 'Spacing between grid items', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_layout',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 16,
			'max'  => 64,
			'step' => 8,
		),
		'priority'    => 30,
	) );
}
