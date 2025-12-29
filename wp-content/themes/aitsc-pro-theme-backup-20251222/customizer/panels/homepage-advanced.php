<?php
/**
 * Advanced Homepage Customizer Panel
 *
 * Enhanced controls for all homepage template parts including:
 * - Advanced hero section with video background
 * - Animated statistics and metrics
 * - Solutions showcase with filtering
 * - Case studies preview
 * - Testimonials and social proof
 * - Advanced CTA sections with countdown
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add advanced homepage section to Customizer
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function aitsc_customizer_homepage_advanced( $wp_customize ) {

    // Add advanced homepage section
    $wp_customize->add_section( 'aitsc_homepage_advanced', array(
        'title'       => __( 'Advanced Homepage Sections', 'aitsc-pro-theme' ),
        'description' => __( 'Configure advanced homepage sections and animations', 'aitsc-pro-theme' ),
        'panel'       => 'aitsc_theme_settings',
        'priority'    => 65,
    ) );

    // ========================================================================
    // HERO SECTION CONTROLS
    // ========================================================================

    // Hero Section Enable/Disable
    $wp_customize->add_setting( 'aitsc_enable_hero_section', array(
        'default'           => true,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_enable_hero_section', array(
        'label'       => __( 'Enable Hero Section', 'aitsc-pro-theme' ),
        'description' => __( 'Show or hide the advanced hero section', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 5,
    ) );

    // Hero Background Type
    $wp_customize->add_setting( 'aitsc_hero_bg_type', array(
        'default'           => 'image',
        'sanitize_callback' => 'aitsc_sanitize_select',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_hero_bg_type', array(
        'label'       => __( 'Hero Background Type', 'aitsc-pro-theme' ),
        'description' => __( 'Choose background type for hero section', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'select',
        'choices'     => array(
            'image'    => __( 'Image Background', 'aitsc-pro-theme' ),
            'video'    => __( 'Video Background', 'aitsc-pro-theme' ),
            'gradient'  => __( 'Gradient Background', 'aitsc-pro-theme' ),
            'pattern'  => __( 'Pattern Background', 'aitsc-pro-theme' ),
        ),
        'priority'    => 10,
    ) );

    // Hero Background Video
    $wp_customize->add_setting( 'aitsc_hero_bg_video', array(
        'default'           => '',
        'sanitize_callback' => 'aitsc_sanitize_url',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_hero_bg_video', array(
        'label'       => __( 'Hero Background Video URL', 'aitsc-pro-theme' ),
        'description' => __( 'MP4 video URL for hero background', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'url',
        'input_attrs' => array(
            'placeholder' => 'https://example.com/video.mp4',
        ),
        'priority'    => 15,
    ) );

    // Hero Background Video Poster
    $wp_customize->add_setting( 'aitsc_hero_bg_video_poster', array(
        'default'           => '',
        'sanitize_callback' => 'aitsc_sanitize_url',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'aitsc_hero_bg_video_poster', array(
        'label'       => __( 'Hero Video Poster Image', 'aitsc-pro-theme' ),
        'description' => __( 'Fallback image shown before video loads', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'priority'    => 20,
    ) ) );

    // Hero Gradient Colors
    $wp_customize->add_setting( 'aitsc_hero_gradient_start', array(
        'default'           => '#005cb2',
        'sanitize_callback' => 'aitsc_sanitize_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'aitsc_hero_gradient_start', array(
        'label'       => __( 'Hero Gradient Start Color', 'aitsc-pro-theme' ),
        'description' => __( 'Start color for gradient background', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'priority'    => 25,
    ) ) );

    $wp_customize->add_setting( 'aitsc_hero_gradient_end', array(
        'default'           => '#003e80',
        'sanitize_callback' => 'aitsc_sanitize_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'aitsc_hero_gradient_end', array(
        'label'       => __( 'Hero Gradient End Color', 'aitsc-pro-theme' ),
        'description' => __( 'End color for gradient background', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'priority'    => 30,
    ) ) );

    // Hero Overlay Opacity
    $wp_customize->add_setting( 'aitsc_hero_overlay_opacity', array(
        'default'           => 0.8,
        'sanitize_callback' => 'aitsc_sanitize_float',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_hero_overlay_opacity', array(
        'label'       => __( 'Hero Overlay Opacity', 'aitsc-pro-theme' ),
        'description' => __( 'Opacity level for hero overlay (0.1 to 1.0)', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0.1,
            'max'  => 1.0,
            'step'  => 0.1,
        ),
        'priority'    => 35,
    ) );

    // Hero Text Animation
    $wp_customize->add_setting( 'aitsc_hero_text_animation', array(
        'default'           => true,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_hero_text_animation', array(
        'label'       => __( 'Enable Hero Text Animation', 'aitsc-pro-theme' ),
        'description' => __( 'Animated shimmer effect on hero headline', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 40,
    ) );

    // Hero Parallax Effect
    $wp_customize->add_setting( 'aitsc_hero_parallax_effect', array(
        'default'           => true,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_hero_parallax_effect', array(
        'label'       => __( 'Enable Hero Parallax Effect', 'aitsc-pro-theme' ),
        'description' => __( 'Parallax scrolling effect for hero background', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 45,
    ) );

    // Hero Floating Elements
    $wp_customize->add_setting( 'aitsc_hero_floating_elements', array(
        'default'           => false,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_hero_floating_elements', array(
        'label'       => __( 'Enable Hero Floating Elements', 'aitsc-pro-theme' ),
        'description' => __( 'Floating background elements for visual interest', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 50,
    ) );

    // Hero Scroll Indicator
    $wp_customize->add_setting( 'aitsc_hero_scroll_indicator', array(
        'default'           => true,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_hero_scroll_indicator', array(
        'label'       => __( 'Show Hero Scroll Indicator', 'aitsc-pro-theme' ),
        'description' => __( 'Animated scroll-to-explore indicator', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 55,
    ) );

    // ========================================================================
    // STATISTICS SECTION CONTROLS
    // ========================================================================

    // Stats Section Enable/Disable
    $wp_customize->add_setting( 'aitsc_enable_stats_section', array(
        'default'           => true,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_enable_stats_section', array(
        'label'       => __( 'Enable Statistics Section', 'aitsc-pro-theme' ),
        'description' => __( 'Show animated statistics/metrics section', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 60,
    ) );

    // Stats Background Type
    $wp_customize->add_setting( 'aitsc_stats_background', array(
        'default'           => 'dark',
        'sanitize_callback' => 'aitsc_sanitize_select',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_stats_background', array(
        'label'       => __( 'Stats Background Type', 'aitsc-pro-theme' ),
        'description' => __( 'Background style for statistics section', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'select',
        'choices'     => array(
            'dark'      => __( 'Dark Background', 'aitsc-pro-theme' ),
            'light'     => __( 'Light Background', 'aitsc-pro-theme' ),
            'gradient'   => __( 'Gradient Background', 'aitsc-pro-theme' ),
            'custom'    => __( 'Custom Background', 'aitsc-pro-theme' ),
        ),
        'priority'    => 65,
    ) );

    // Stats Layout
    $wp_customize->add_setting( 'aitsc_stats_layout', array(
        'default'           => 'grid',
        'sanitize_callback' => 'aitsc_sanitize_select',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_stats_layout', array(
        'label'       => __( 'Stats Layout Style', 'aitsc-pro-theme' ),
        'description' => __( 'Layout style for statistics items', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'select',
        'choices'     => array(
            'grid'      => __( 'Grid Layout', 'aitsc-pro-theme' ),
            'cards'     => __( 'Card Layout', 'aitsc-pro-theme' ),
            'mixed'     => __( 'Mixed Layout (Grid + Progress)', 'aitsc-pro-theme' ),
        ),
        'priority'    => 70,
    ) );

    // Stats Columns
    $wp_customize->add_setting( 'aitsc_stats_columns', array(
        'default'           => 4,
        'sanitize_callback' => 'aitsc_sanitize_number',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_stats_columns', array(
        'label'       => __( 'Statistics Columns', 'aitsc-pro-theme' ),
        'description' => __( 'Number of columns for statistics display', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'select',
        'choices'     => array(
            '2' => __( '2 Columns', 'aitsc-pro-theme' ),
            '3' => __( '3 Columns', 'aitsc-pro-theme' ),
            '4' => __( '4 Columns', 'aitsc-pro-theme' ),
        ),
        'priority'    => 75,
    ) );

    // Stats Animation Style
    $wp_customize->add_setting( 'aitsc_stats_animation_style', array(
        'default'           => 'counter',
        'sanitize_callback' => 'aitsc_sanitize_select',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_stats_animation_style', array(
        'label'       => __( 'Statistics Animation Style', 'aitsc-pro-theme' ),
        'description' => __( 'Type of animation for statistics', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'select',
        'choices'     => array(
            'counter'   => __( 'Counters Only', 'aitsc-pro-theme' ),
            'progress'  => __( 'Progress Bars Only', 'aitsc-pro-theme' ),
            'mixed'     => __( 'Counters + Progress Bars', 'aitsc-pro-theme' ),
        ),
        'priority'    => 80,
    ) );

    // ========================================================================
    // SOLUTIONS SHOWCASE CONTROLS
    // ========================================================================

    // Solutions Showcase Enable/Disable
    $wp_customize->add_setting( 'aitsc_enable_solutions_showcase', array(
        'default'           => true,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_enable_solutions_showcase', array(
        'label'       => __( 'Enable Advanced Solutions Showcase', 'aitsc-pro-theme' ),
        'description' => __( 'Use advanced solutions showcase with filtering', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 85,
    ) );

    // Solutions Layout
    $wp_customize->add_setting( 'aitsc_solutions_layout', array(
        'default'           => 'grid',
        'sanitize_callback' => 'aitsc_sanitize_select',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_solutions_layout', array(
        'label'       => __( 'Solutions Layout', 'aitsc-pro-theme' ),
        'description' => __( 'Layout style for solutions display', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'select',
        'choices'     => array(
            'grid'     => __( 'Grid Layout', 'aitsc-pro-theme' ),
            'carousel'  => __( 'Carousel Layout', 'aitsc-pro-theme' ),
            'masonry'  => __( 'Masonry Layout', 'aitsc-pro-theme' ),
        ),
        'priority'    => 90,
    ) );

    // Solutions Columns
    $wp_customize->add_setting( 'aitsc_solutions_columns', array(
        'default'           => 3,
        'sanitize_callback' => 'aitsc_sanitize_number',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_solutions_columns', array(
        'label'       => __( 'Solutions Columns', 'aitsc-pro-theme' ),
        'description' => __( 'Number of columns for solutions grid', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'select',
        'choices'     => array(
            '2' => __( '2 Columns', 'aitsc-pro-theme' ),
            '3' => __( '3 Columns', 'aitsc-pro-theme' ),
            '4' => __( '4 Columns', 'aitsc-pro-theme' ),
        ),
        'priority'    => 95,
    ) );

    // Solutions Display Count
    $wp_customize->add_setting( 'aitsc_solutions_count', array(
        'default'           => 6,
        'sanitize_callback' => 'aitsc_sanitize_number',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_solutions_count', array(
        'label'       => __( 'Solutions Display Count', 'aitsc-pro-theme' ),
        'description' => __( 'Number of solutions to show on homepage', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 12,
            'step'  => 1,
        ),
        'priority'    => 100,
    ) );

    // Enable Solutions Filtering
    $wp_customize->add_setting( 'aitsc_solutions_filtering', array(
        'default'           => true,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_solutions_filtering', array(
        'label'       => __( 'Enable Solutions Filtering', 'aitsc-pro-theme' ),
        'description' => __( 'Show filter buttons for solutions by industry/technology', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 105,
    ) );

    // Solutions "View All" Button
    $wp_customize->add_setting( 'aitsc_solutions_show_all', array(
        'default'           => true,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_solutions_show_all', array(
        'label'       => __( 'Show "View All Solutions" Button', 'aitsc-pro-theme' ),
        'description' => __( 'Display button linking to all solutions page', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 110,
    ) );

    $wp_customize->add_setting( 'aitsc_solutions_all_url', array(
        'default'           => '/solutions/',
        'sanitize_callback' => 'aitsc_sanitize_url',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_solutions_all_url', array(
        'label'       => __( 'Solutions "View All" URL', 'aitsc-pro-theme' ),
        'description' => __( 'Link for "View All Solutions" button', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'url',
        'priority'    => 115,
    ) );

    // ========================================================================
    // CASE STUDIES PREVIEW CONTROLS
    // ========================================================================

    // Case Studies Preview Enable/Disable
    $wp_customize->add_setting( 'aitsc_enable_case_studies_preview', array(
        'default'           => true,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_enable_case_studies_preview', array(
        'label'       => __( 'Enable Case Studies Preview', 'aitsc-pro-theme' ),
        'description' => __( 'Show featured case studies section', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 120,
    ) );

    // Case Studies Layout
    $wp_customize->add_setting( 'aitsc_case_studies_layout', array(
        'default'           => 'featured',
        'sanitize_callback' => 'aitsc_sanitize_select',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_case_studies_layout', array(
        'label'       => __( 'Case Studies Layout', 'aitsc-pro-theme' ),
        'description' => __( 'Layout style for case studies display', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'select',
        'choices'     => array(
            'featured' => __( 'Featured Layout (Large + Small)', 'aitsc-pro-theme' ),
            'grid'     => __( 'Grid Layout', 'aitsc-pro-theme' ),
            'carousel'  => __( 'Carousel Layout', 'aitsc-pro-theme' ),
        ),
        'priority'    => 125,
    ) );

    // Case Studies Display Count
    $wp_customize->add_setting( 'aitsc_case_studies_count', array(
        'default'           => 3,
        'sanitize_callback' => 'aitsc_sanitize_number',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_case_studies_count', array(
        'label'       => __( 'Case Studies Display Count', 'aitsc-pro-theme' ),
        'description' => __( 'Number of case studies to show on homepage', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 6,
            'step'  => 1,
        ),
        'priority'    => 130,
    ) );

    // Show Case Studies Metrics
    $wp_customize->add_setting( 'aitsc_case_studies_metrics', array(
        'default'           => true,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_case_studies_metrics', array(
        'label'       => __( 'Show Case Studies Metrics', 'aitsc-pro-theme' ),
        'description' => __( 'Display results metrics in case studies', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 135,
    ) );

    // Show Case Studies Testimonials
    $wp_customize->add_setting( 'aitsc_case_studies_testimonials', array(
        'default'           => true,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_case_studies_testimonials', array(
        'label'       => __( 'Show Case Studies Testimonials', 'aitsc-pro-theme' ),
        'description' => __( 'Display client testimonials in case studies', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 140,
    ) );

    // Case Studies "View All" Button
    $wp_customize->add_setting( 'aitsc_case_studies_show_all', array(
        'default'           => true,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_case_studies_show_all', array(
        'label'       => __( 'Show "View All Case Studies" Button', 'aitsc-pro-theme' ),
        'description' => __( 'Display button linking to all case studies page', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 145,
    ) );

    $wp_customize->add_setting( 'aitsc_case_studies_all_url', array(
        'default'           => '/case-studies/',
        'sanitize_callback' => 'aitsc_sanitize_url',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_case_studies_all_url', array(
        'label'       => __( 'Case Studies "View All" URL', 'aitsc-pro-theme' ),
        'description' => __( 'Link for "View All Case Studies" button', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'url',
        'priority'    => 150,
    ) );

    // ========================================================================
    // TESTIMONIALS SECTION CONTROLS
    // ========================================================================

    // Testimonials Enable/Disable
    $wp_customize->add_setting( 'aitsc_enable_testimonials', array(
        'default'           => true,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_enable_testimonials', array(
        'label'       => __( 'Enable Testimonials Section', 'aitsc-pro-theme' ),
        'description' => __( 'Show client testimonials and social proof', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 155,
    ) );

    // Testimonials Layout
    $wp_customize->add_setting( 'aitsc_testimonials_layout', array(
        'default'           => 'carousel',
        'sanitize_callback' => 'aitsc_sanitize_select',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_testimonials_layout', array(
        'label'       => __( 'Testimonials Layout', 'aitsc-pro-theme' ),
        'description' => __( 'Layout style for testimonials display', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'select',
        'choices'     => array(
            'carousel' => __( 'Carousel Layout', 'aitsc-pro-theme' ),
            'grid'     => __( 'Grid Layout', 'aitsc-pro-theme' ),
            'mixed'    => __( 'Mixed Layout (Featured + Grid)', 'aitsc-pro-theme' ),
        ),
        'priority'    => 160,
    ) );

    // Testimonials Count
    $wp_customize->add_setting( 'aitsc_testimonials_count', array(
        'default'           => 6,
        'sanitize_callback' => 'aitsc_sanitize_number',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_testimonials_count', array(
        'label'       => __( 'Testimonials Display Count', 'aitsc-pro-theme' ),
        'description' => __( 'Number of testimonials to show', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 12,
            'step'  => 1,
        ),
        'priority'    => 165,
    ) );

    // Testimonials Autoplay
    $wp_customize->add_setting( 'aitsc_testimonials_autoplay', array(
        'default'           => true,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_testimonials_autoplay', array(
        'label'       => __( 'Enable Testimonials Autoplay', 'aitsc-pro-theme' ),
        'description' => __( 'Auto-rotate through testimonials', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 170,
    ) );

    // Testimonials Autoplay Speed
    $wp_customize->add_setting( 'aitsc_testimonials_autoplay_speed', array(
        'default'           => 5000,
        'sanitize_callback' => 'aitsc_sanitize_number',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_testimonials_autoplay_speed', array(
        'label'       => __( 'Autoplay Speed (milliseconds)', 'aitsc-pro-theme' ),
        'description' => __( 'Time between testimonial rotations', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 2000,
            'max'  => 10000,
            'step'  => 500,
        ),
        'priority'    => 175,
    ) );

    // Show Client Logos
    $wp_customize->add_setting( 'aitsc_testimonials_logos', array(
        'default'           => true,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_testimonials_logos', array(
        'label'       => __( 'Show Client Logos', 'aitsc-pro-theme' ),
        'description' => __( 'Display logos of companies that trust AITSC', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 180,
    ) );

    // Show Awards Section
    $wp_customize->add_setting( 'aitsc_testimonials_awards', array(
        'default'           => false,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_testimonials_awards', array(
        'label'       => __( 'Show Awards & Certifications', 'aitsc-pro-theme' ),
        'description' => __( 'Display industry awards and certifications', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 185,
    ) );

    // ========================================================================
    // CTA SECTION CONTROLS
    // ========================================================================

    // CTA Enable/Disable
    $wp_customize->add_setting( 'aitsc_enable_cta_section', array(
        'default'           => true,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_enable_cta_section', array(
        'label'       => __( 'Enable Advanced CTA Section', 'aitsc-pro-theme' ),
        'description' => __( 'Show advanced call-to-action section', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 190,
    ) );

    // CTA Type
    $wp_customize->add_setting( 'aitsc_cta_type', array(
        'default'           => 'standard',
        'sanitize_callback' => 'aitsc_sanitize_select',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_cta_type', array(
        'label'       => __( 'CTA Layout Type', 'aitsc-pro-theme' ),
        'description' => __( 'Choose CTA section layout style', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'select',
        'choices'     => array(
            'standard'  => __( 'Standard Layout', 'aitsc-pro-theme' ),
            'split'     => __( 'Split Layout (Content + Form)', 'aitsc-pro-theme' ),
            'fullwidth' => __( 'Fullwidth Layout', 'aitsc-pro-theme' ),
            'countdown' => __( 'Countdown Layout', 'aitsc-pro-theme' ),
        ),
        'priority'    => 195,
    ) );

    // CTA Background Type
    $wp_customize->add_setting( 'aitsc_cta_background', array(
        'default'           => 'gradient',
        'sanitize_callback' => 'aitsc_sanitize_select',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_cta_background', array(
        'label'       => __( 'CTA Background Type', 'aitsc-pro-theme' ),
        'description' => __( 'Background style for CTA section', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'select',
        'choices'     => array(
            'solid'    => __( 'Solid Color', 'aitsc-pro-theme' ),
            'gradient'  => __( 'Gradient', 'aitsc-pro-theme' ),
            'image'     => __( 'Image Background', 'aitsc-pro-theme' ),
            'pattern'   => __( 'Pattern Background', 'aitsc-pro-theme' ),
        ),
        'priority'    => 200,
    ) );

    // CTA Background Color
    $wp_customize->add_setting( 'aitsc_cta_bg_color', array(
        'default'           => '#005cb2',
        'sanitize_callback' => 'aitsc_sanitize_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'aitsc_cta_bg_color', array(
        'label'       => __( 'CTA Background Color', 'aitsc-pro-theme' ),
        'description' => __( 'Solid background color for CTA section', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'priority'    => 205,
    ) ) );

    // CTA Background Image
    $wp_customize->add_setting( 'aitsc_cta_bg_image', array(
        'default'           => '',
        'sanitize_callback' => 'aitsc_sanitize_url',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'aitsc_cta_bg_image', array(
        'label'       => __( 'CTA Background Image', 'aitsc-pro-theme' ),
        'description' => __( 'Background image for CTA section', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'priority'    => 210,
    ) ) );

    // CTA Overlay Opacity
    $wp_customize->add_setting( 'aitsc_cta_overlay_opacity', array(
        'default'           => 0.9,
        'sanitize_callback' => 'aitsc_sanitize_float',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_cta_overlay_opacity', array(
        'label'       => __( 'CTA Overlay Opacity', 'aitsc-pro-theme' ),
        'description' => __( 'Opacity level for CTA background overlay', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0.1,
            'max'  => 1.0,
            'step'  => 0.1,
        ),
        'priority'    => 215,
    ) );

    // Show Form in CTA
    $wp_customize->add_setting( 'aitsc_cta_show_form', array(
        'default'           => false,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_cta_show_form', array(
        'label'       => __( 'Show Contact Form in CTA', 'aitsc-pro-theme' ),
        'description' => __( 'Display contact form in CTA section', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 220,
    ) );

    // CTA Form Type
    $wp_customize->add_setting( 'aitsc_cta_form_type', array(
        'default'           => 'simple',
        'sanitize_callback' => 'aitsc_sanitize_select',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_cta_form_type', array(
        'label'       => __( 'CTA Form Type', 'aitsc-pro-theme' ),
        'description' => __( 'Type of form to show in CTA section', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'select',
        'choices'     => array(
            'simple'   => __( 'Simple Contact Form', 'aitsc-pro-theme' ),
            'contact'  => __( 'Detailed Contact Form', 'aitsc-pro-theme' ),
            'demo'     => __( 'Demo Request Form', 'aitsc-pro-theme' ),
        ),
        'priority'    => 225,
    ) );

    // Show Urgency Badge
    $wp_customize->add_setting( 'aitsc_cta_urgency', array(
        'default'           => false,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_cta_urgency', array(
        'label'       => __( 'Show Urgency Badge', 'aitsc-pro-theme' ),
        'description' => __( 'Display "Limited Time Offer" urgency indicator', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 230,
    ) );

    // CTA Countdown Date
    $wp_customize->add_setting( 'aitsc_cta_countdown_date', array(
        'default'           => '',
        'sanitize_callback' => 'aitsc_sanitize_text',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_cta_countdown_date', array(
        'label'       => __( 'CTA Countdown End Date', 'aitsc-pro-theme' ),
        'description' => __( 'End date for countdown timer (YYYY-MM-DD format)', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'text',
        'input_attrs' => array(
            'placeholder' => '2024-12-31',
        ),
        'priority'    => 235,
    ) );

    // Show Trust Indicators
    $wp_customize->add_setting( 'aitsc_cta_trust_indicators', array(
        'default'           => false,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_cta_trust_indicators', array(
        'label'       => __( 'Show Trust Indicators', 'aitsc-pro-theme' ),
        'description' => __( 'Display guarantee and trust indicators', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 240,
    ) );

    // Show Floating Elements
    $wp_customize->add_setting( 'aitsc_cta_floating_elements', array(
        'default'           => false,
        'sanitize_callback' => 'aitsc_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'aitsc_cta_floating_elements', array(
        'label'       => __( 'Show Floating Elements', 'aitsc-pro-theme' ),
        'description' => __( 'Floating background elements in CTA section', 'aitsc-pro-theme' ),
        'section'     => 'aitsc_homepage_advanced',
        'type'        => 'checkbox',
        'priority'    => 245,
    ) );
}

add_action( 'customize_register', 'aitsc_customizer_homepage_advanced' );