<?php
/**
 * Custom Post Types Customizer Panel
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * CPT Customizer Settings
 */
function aitsc_customizer_cpt( $wp_customize ) {

	// Add CPT section
	$wp_customize->add_section( 'aitsc_cpt_settings', array(
		'title'       => __( 'Custom Post Types', 'aitsc-pro-theme' ),
		'description' => __( 'Configure Solutions and Case Studies display settings', 'aitsc-pro-theme' ),
		'panel'       => 'aitsc_theme_settings',
		'priority'    => 60,
	) );

	// Solutions Section Settings
	$wp_customize->add_setting( 'aitsc_solutions_archive_title', array(
		'default'           => __( 'Our Solutions', 'aitsc-pro-theme' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_solutions_archive_title', array(
		'label'       => __( 'Solutions Archive Title', 'aitsc-pro-theme' ),
		'description' => __( 'Title displayed on the solutions archive page', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'aitsc_solutions_archive_description', array(
		'default'           => __( 'Discover AITSC\'s comprehensive range of safety and compliance solutions designed to meet the unique needs of your industry.', 'aitsc-pro-theme' ),
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_solutions_archive_description', array(
		'label'       => __( 'Solutions Archive Description', 'aitsc-pro-theme' ),
		'description' => __( 'Description displayed on the solutions archive page', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'textarea',
	) );

	$wp_customize->add_setting( 'aitsc_solutions_posts_per_page', array(
		'default'           => 12,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'aitsc_solutions_posts_per_page', array(
		'label'       => __( 'Solutions Per Page', 'aitsc-pro-theme' ),
		'description' => __( 'Number of solutions to display per page in archive view', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 1,
			'max'  => 50,
			'step' => 1,
		),
	) );

	$wp_customize->add_setting( 'aitsc_solutions_show_excerpt', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_solutions_show_excerpt', array(
		'label'       => __( 'Show Solution Excerpts', 'aitsc-pro-theme' ),
		'description' => __( 'Display excerpts in solution archive grid', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'aitsc_solutions_show_categories', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_solutions_show_categories', array(
		'label'       => __( 'Show Solution Categories', 'aitsc-pro-theme' ),
		'description' => __( 'Display category links in solution archive grid', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'checkbox',
	) );

	// Case Studies Section Settings
	$wp_customize->add_setting( 'aitsc_case_studies_archive_title', array(
		'default'           => __( 'Case Studies', 'aitsc-pro-theme' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_case_studies_archive_title', array(
		'label'       => __( 'Case Studies Archive Title', 'aitsc-pro-theme' ),
		'description' => __( 'Title displayed on the case studies archive page', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'aitsc_case_studies_archive_description', array(
		'default'           => __( 'Explore real-world examples of how AITSC has helped organizations improve their safety, compliance, and operational efficiency through innovative solutions.', 'aitsc-pro-theme' ),
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_case_studies_archive_description', array(
		'label'       => __( 'Case Studies Archive Description', 'aitsc-pro-theme' ),
		'description' => __( 'Description displayed on the case studies archive page', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'textarea',
	) );

	$wp_customize->add_setting( 'aitsc_case_studies_posts_per_page', array(
		'default'           => 9,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'aitsc_case_studies_posts_per_page', array(
		'label'       => __( 'Case Studies Per Page', 'aitsc-pro-theme' ),
		'description' => __( 'Number of case studies to display per page in archive view', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 1,
			'max'  => 50,
			'step' => 1,
		),
	) );

	$wp_customize->add_setting( 'aitsc_case_studies_show_excerpt', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_case_studies_show_excerpt', array(
		'label'       => __( 'Show Case Study Excerpts', 'aitsc-pro-theme' ),
		'description' => __( 'Display excerpts in case studies archive grid', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'aitsc_case_studies_show_client', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_case_studies_show_client', array(
		'label'       => __( 'Show Client Information', 'aitsc-pro-theme' ),
		'description' => __( 'Display client name in case studies archive grid', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'aitsc_case_studies_show_technologies', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_case_studies_show_technologies', array(
		'label'       => __( 'Show Technologies', 'aitsc-pro-theme' ),
		'description' => __( 'Display technologies used in case studies archive grid', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'checkbox',
	) );

	// Homepage Integration Settings
	$wp_customize->add_setting( 'aitsc_show_solutions_on_homepage', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_show_solutions_on_homepage', array(
		'label'       => __( 'Show Solutions on Homepage', 'aitsc-pro-theme' ),
		'description' => __( 'Display featured solutions section on homepage', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'aitsc_solutions_homepage_title', array(
		'default'           => __( 'Our Solutions', 'aitsc-pro-theme' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_solutions_homepage_title', array(
		'label'       => __( 'Homepage Solutions Title', 'aitsc-pro-theme' ),
		'description' => __( 'Title for solutions section on homepage', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'aitsc_solutions_homepage_count', array(
		'default'           => 6,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'aitsc_solutions_homepage_count', array(
		'label'       => __( 'Solutions to Show on Homepage', 'aitsc-pro-theme' ),
		'description' => __( 'Number of featured solutions to display on homepage', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 1,
			'max'  => 20,
			'step' => 1,
		),
	) );

	$wp_customize->add_setting( 'aitsc_show_case_studies_on_homepage', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_show_case_studies_on_homepage', array(
		'label'       => __( 'Show Case Studies on Homepage', 'aitsc-pro-theme' ),
		'description' => __( 'Display featured case studies section on homepage', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'aitsc_case_studies_homepage_title', array(
		'default'           => __( 'Success Stories', 'aitsc-pro-theme' ),
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_case_studies_homepage_title', array(
		'label'       => __( 'Homepage Case Studies Title', 'aitsc-pro-theme' ),
		'description' => __( 'Title for case studies section on homepage', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'aitsc_case_studies_homepage_count', array(
		'default'           => 3,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'aitsc_case_studies_homepage_count', array(
		'label'       => __( 'Case Studies to Show on Homepage', 'aitsc-pro-theme' ),
		'description' => __( 'Number of featured case studies to display on homepage', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 1,
			'max'  => 20,
			'step' => 1,
		),
	) );

	// Related Content Settings
	$wp_customize->add_setting( 'aitsc_related_solutions_count', array(
		'default'           => 3,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'aitsc_related_solutions_count', array(
		'label'       => __( 'Related Solutions Count', 'aitsc-pro-theme' ),
		'description' => __( 'Number of related solutions to show on single solution pages', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 1,
			'max'  => 10,
			'step' => 1,
		),
	) );

	$wp_customize->add_setting( 'aitsc_related_case_studies_count', array(
		'default'           => 3,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'aitsc_related_case_studies_count', array(
		'label'       => __( 'Related Case Studies Count', 'aitsc-pro-theme' ),
		'description' => __( 'Number of related case studies to show on single case study pages', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 1,
			'max'  => 10,
			'step' => 1,
		),
	) );

	// Advanced Solutions Settings
	$wp_customize->add_setting( 'aitsc_solutions_enable_filtering', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_solutions_enable_filtering', array(
		'label'       => __( 'Enable Industry Filtering', 'aitsc-pro-theme' ),
		'description' => __( 'Allow visitors to filter solutions by industry focus', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'aitsc_solutions_enable_search', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_solutions_enable_search', array(
		'label'       => __( 'Enable Solutions Search', 'aitsc-pro-theme' ),
		'description' => __( 'Show search functionality on solutions archive', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'aitsc_solutions_grid_columns', array(
		'default'           => '3',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_solutions_grid_columns', array(
		'label'       => __( 'Solutions Grid Columns', 'aitsc-pro-theme' ),
		'description' => __( 'Number of columns in solutions archive grid', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'select',
		'choices'     => array(
			'2' => __( '2 Columns', 'aitsc-pro-theme' ),
			'3' => __( '3 Columns', 'aitsc-pro-theme' ),
			'4' => __( '4 Columns', 'aitsc-pro-theme' ),
		),
	) );

	$wp_customize->add_setting( 'aitsc_solutions_show_technologies', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_solutions_show_technologies', array(
		'label'       => __( 'Show Technologies in Grid', 'aitsc-pro-theme' ),
		'description' => __( 'Display technologies used on solution cards', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'checkbox',
	) );

	// Advanced Case Studies Settings
	$wp_customize->add_setting( 'aitsc_case_studies_enable_filtering', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_case_studies_enable_filtering', array(
		'label'       => __( 'Enable Case Study Filtering', 'aitsc-pro-theme' ),
		'description' => __( 'Allow visitors to filter case studies by client and industry', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'aitsc_case_studies_enable_search', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_case_studies_enable_search', array(
		'label'       => __( 'Enable Case Studies Search', 'aitsc-pro-theme' ),
		'description' => __( 'Show search functionality on case studies archive', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'aitsc_case_studies_grid_columns', array(
		'default'           => '3',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_case_studies_grid_columns', array(
		'label'       => __( 'Case Studies Grid Columns', 'aitsc-pro-theme' ),
		'description' => __( 'Number of columns in case studies archive grid', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'select',
		'choices'     => array(
			'2' => __( '2 Columns', 'aitsc-pro-theme' ),
			'3' => __( '3 Columns', 'aitsc-pro-theme' ),
			'4' => __( '4 Columns', 'aitsc-pro-theme' ),
		),
	) );

	$wp_customize->add_setting( 'aitsc_case_studies_show_gallery_preview', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_case_studies_show_gallery_preview', array(
		'label'       => __( 'Show Gallery Preview', 'aitsc-pro-theme' ),
		'description' => __( 'Display gallery preview buttons on case study cards', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'aitsc_case_studies_show_metrics', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_case_studies_show_metrics', array(
		'label'       => __( 'Show Project Metrics', 'aitsc-pro-theme' ),
		'description' => __( 'Display duration, team size, and budget information', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'checkbox',
	) );

	// Integration Settings
	$wp_customize->add_setting( 'aitsc_cpt_enable_related_content', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'aitsc_cpt_enable_related_content', array(
		'label'       => __( 'Enable Related Content', 'aitsc-pro-theme' ),
		'description' => __( 'Show related solutions/case studies on single pages', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'aitsc_cpt_contact_integration', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_cpt_contact_integration', array(
		'label'       => __( 'Enable Contact Integration', 'aitsc-pro-theme' ),
		'description' => __( 'Add "Get Quote" and consultation buttons', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'aitsc_cpt_download_brochures', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_cpt_download_brochures', array(
		'label'       => __( 'Enable Download Brochures', 'aitsc-pro-theme' ),
		'description' => __( 'Show download buttons for solution brochures', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'checkbox',
	) );

	// Animation Settings
	$wp_customize->add_setting( 'aitsc_cpt_enable_animations', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_cpt_enable_animations', array(
		'label'       => __( 'Enable Card Animations', 'aitsc-pro-theme' ),
		'description' => __( 'Add hover and entrance animations to CPT cards', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'aitsc_cpt_animation_style', array(
		'default'           => 'fade-up',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'aitsc_cpt_animation_style', array(
		'label'       => __( 'Animation Style', 'aitsc-pro-theme' ),
		'description' => __( 'Choose the animation style for cards', 'aitsc-pro-theme' ),
		'section'     => 'aitsc_cpt_settings',
		'type'        => 'select',
		'choices'     => array(
			'fade-up'      => __( 'Fade Up', 'aitsc-pro-theme' ),
			'slide-up'     => __( 'Slide Up', 'aitsc-pro-theme' ),
			'scale-up'     => __( 'Scale Up', 'aitsc-pro-theme' ),
			'fade-in'      => __( 'Fade In', 'aitsc-pro-theme' ),
			'no-animation' => __( 'No Animation', 'aitsc-pro-theme' ),
		),
	) );
}