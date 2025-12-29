<?php
/**
 * Customizer Footer Panel
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aitsc_customizer_footer( $wp_customize ) {
	// Add section
	$wp_customize->add_section( 'aitsc_footer', array(
		'title'    => __( 'Footer', 'aitsc-pro-theme' ),
		'panel'    => 'aitsc_theme_settings',
		'priority' => 50,
	) );

	// Footer Layout
	$wp_customize->add_setting( 'aitsc_footer_layout', array(
		'default'           => '4-column',
		'sanitize_callback' => 'aitsc_sanitize_select',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'aitsc_footer_layout', array(
		'label'       => __( 'Footer Layout', 'aitsc-pro-theme' ),
		'description' => __( 'Number of widget columns in footer', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_footer',
		'type'        => 'select',
		'choices'     => array(
			'1-column' => __( '1 Column', 'aitsc-pro-theme' ),
			'2-column' => __( '2 Columns', 'aitsc-pro-theme' ),
			'3-column' => __( '3 Columns', 'aitsc-pro-theme' ),
			'4-column' => __( '4 Columns', 'aitsc-pro-theme' ),
		),
		'priority'    => 10,
	) );

	// Footer Background
	$wp_customize->add_setting( 'aitsc_footer_bg', array(
		'default'           => '#1a1a1a',
		'sanitize_callback' => 'aitsc_sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'aitsc_footer_bg', array(
		'label'       => __( 'Footer Background Color', 'aitsc-pro-theme' ),
		'description' => __( 'Background color for footer', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_footer',
		'priority'    => 20,
	) ) );

	// Copyright Text
	$wp_customize->add_setting( 'aitsc_copyright_text', array(
		'default'           => sprintf( __( '© %s AITSC. All rights reserved.', 'aitsc-pro-theme' ), date( 'Y' ) ),
		'sanitize_callback' => 'aitsc_sanitize_html',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_copyright_text', array(
		'label'       => __( 'Copyright Text', 'aitsc-pro-theme' ),
		'description' => __( 'Text displayed in footer copyright area', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_footer',
		'type'        => 'textarea',
		'priority'    => 30,
	) );
}
