<?php
/**
 * Customizer Homepage Panel
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aitsc_customizer_homepage( $wp_customize ) {
	// Add section
	$wp_customize->add_section( 'aitsc_homepage', array(
		'title'    => __( 'Homepage Sections', 'aitsc-pro-theme' ),
		'panel'    => 'aitsc_theme_settings',
		'priority' => 60,
	) );

	// Hero Headline
	$wp_customize->add_setting( 'aitsc_hero_headline', array(
		'default'           => __( 'Solving Your Most Expensive Problems', 'aitsc-pro-theme' ),
		'sanitize_callback' => 'aitsc_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_hero_headline', array(
		'label'       => __( 'Hero Headline', 'aitsc-pro-theme' ),
		'description' => __( 'Main headline in hero section', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_homepage',
		'type'        => 'text',
		'priority'    => 10,
	) );

	// Hero Subheadline
	$wp_customize->add_setting( 'aitsc_hero_subheadline', array(
		'default'           => __( 'Advanced technology solutions for fleet safety and operational excellence', 'aitsc-pro-theme' ),
		'sanitize_callback' => 'aitsc_sanitize_html',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_hero_subheadline', array(
		'label'       => __( 'Hero Subheadline', 'aitsc-pro-theme' ),
		'description' => __( 'Subtitle text in hero section', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_homepage',
		'type'        => 'textarea',
		'priority'    => 20,
	) );

	// Hero Background Image
	$wp_customize->add_setting( 'aitsc_hero_bg_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'aitsc_hero_bg_image', array(
		'label'       => __( 'Hero Background Image', 'aitsc-pro-theme' ),
		'description' => __( 'Background image for hero section (1920x800px recommended)', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_homepage',
		'priority'    => 30,
	) ) );

	// Hero CTA Text
	$wp_customize->add_setting( 'aitsc_hero_cta_text', array(
		'default'           => __( 'Get Started', 'aitsc-pro-theme' ),
		'sanitize_callback' => 'aitsc_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_hero_cta_text', array(
		'label'       => __( 'Hero CTA Button Text', 'aitsc-pro-theme' ),
		'description' => __( 'Call-to-action button text', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_homepage',
		'type'        => 'text',
		'priority'    => 40,
	) );

	// Hero CTA URL
	$wp_customize->add_setting( 'aitsc_hero_cta_url', array(
		'default'           => '/contact/',
		'sanitize_callback' => 'aitsc_sanitize_url',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_hero_cta_url', array(
		'label'       => __( 'Hero CTA Button URL', 'aitsc-pro-theme' ),
		'description' => __( 'Link for CTA button', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_homepage',
		'type'        => 'url',
		'priority'    => 50,
	) );

	// Display Solutions Section
	$wp_customize->add_setting( 'aitsc_display_solutions', array(
		'default'           => true,
		'sanitize_callback' => 'aitsc_sanitize_checkbox',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'aitsc_display_solutions', array(
		'label'       => __( 'Display Solutions Section', 'aitsc-pro-theme' ),
		'description' => __( 'Show/hide solutions showcase on homepage', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_homepage',
		'type'        => 'checkbox',
		'priority'    => 60,
	) );
}
