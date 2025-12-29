<?php
/**
 * AITSC Pro Theme Functions
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

// Constants
define('AITSC_VERSION', '3.0.6'); // Bump version
define('AITSC_THEME_DIR', get_template_directory());
define('AITSC_THEME_URI', get_template_directory_uri());

/**
 * Load theme modules
 */
require_once AITSC_THEME_DIR . '/inc/enqueue.php';
require_once AITSC_THEME_DIR . '/inc/theme-options.php';
require_once AITSC_THEME_DIR . '/inc/customizer.php';
require_once AITSC_THEME_DIR . '/inc/customizer-callbacks.php';
require_once AITSC_THEME_DIR . '/customizer/panels/homepage-advanced.php';
require_once AITSC_THEME_DIR . '/inc/template-tags.php';
require_once AITSC_THEME_DIR . '/inc/custom-post-types.php';
require_once AITSC_THEME_DIR . '/inc/aitsc-content-data.php';
require_once AITSC_THEME_DIR . '/inc/components.php';
require_once AITSC_THEME_DIR . '/inc/acf-fields.php';
require_once AITSC_THEME_DIR . '/inc/acf-solution-fields.php';

/**
 * Check ACF Dependency
 */
function aitsc_check_acf_dependency()
{
	if (!function_exists('get_field')) {
		add_action('admin_notices', function () {
			echo '<div class="error"><p><strong>AITSC Pro Theme:</strong> Advanced Custom Fields Pro is required for full functionality. Please install and activate ACF Pro.</p></div>';
		});
	}
}
add_action('after_setup_theme', 'aitsc_check_acf_dependency');

/**
 * Theme Setup
 */
function aitsc_theme_setup()
{
	// Make theme available for translation
	load_theme_textdomain('aitsc-pro-theme', AITSC_THEME_DIR . '/languages');

	// Add default posts and comments RSS feed links to head
	add_theme_support('automatic-feed-links');

	// Let WordPress manage the document title
	add_theme_support('title-tag');

	// Enable support for Post Thumbnails
	add_theme_support('post-thumbnails');

	// Register navigation menus
	register_nav_menus(array(
		'primary' => esc_html__('Primary Menu', 'aitsc-pro-theme'),
		'footer' => esc_html__('Footer Menu', 'aitsc-pro-theme'),
		'mobile' => esc_html__('Mobile Menu', 'aitsc-pro-theme'),
	));

	// Switch default core markup to HTML5
	add_theme_support('html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	));

	// Add theme support for custom logo
	add_theme_support('custom-logo', array(
		'height' => 100,
		'width' => 300,
		'flex-height' => true,
		'flex-width' => true,
	));

	// Add theme support for selective refresh for widgets
	add_theme_support('customize-selective-refresh-widgets');

	// Add support for responsive embedded content
	add_theme_support('responsive-embeds');

	// Add support for Block Editor features
	add_theme_support('align-wide');
	add_theme_support('editor-styles');

	// Enqueue editor styles
	add_editor_style('assets/css/editor-style.css');
}
add_action('after_setup_theme', 'aitsc_theme_setup');

/**
 * Set content width
 */
function aitsc_content_width()
{
	$GLOBALS['content_width'] = apply_filters('aitsc_content_width', 1200);
}
add_action('after_setup_theme', 'aitsc_content_width', 0);

/**
 * Register widget areas
 */
function aitsc_widgets_init()
{
	// Footer widget areas
	for ($i = 1; $i <= 4; $i++) {
		register_sidebar(array(
			'name' => sprintf(esc_html__('Footer Widget Area %d', 'aitsc-pro-theme'), $i),
			'id' => 'footer-' . $i,
			'description' => sprintf(esc_html__('Appears in the footer section %d', 'aitsc-pro-theme'), $i),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	}

	// Sidebar widget area
	register_sidebar(array(
		'name' => esc_html__('Primary Sidebar', 'aitsc-pro-theme'),
		'id' => 'sidebar-1',
		'description' => esc_html__('Appears on blog posts and pages with sidebar layout', 'aitsc-pro-theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
}
add_action('widgets_init', 'aitsc_widgets_init');

/**
 * Load template parts for Solutions and Case Studies
 */
function aitsc_get_template_part($slug, $name = null)
{
	if ($name) {
		$template = locate_template(array("{$slug}-{$name}.php", "{$slug}.php"));
	} else {
		$template = locate_template("{$slug}.php");
	}

	if ($template) {
		load_template($template, false);
	} else {
		// Fallback to template-parts directory
		$template_path = AITSC_THEME_DIR . "/template-parts/{$slug}.php";
		if (file_exists($template_path)) {
			load_template($template_path, false);
		}
	}
}

/**
 * Custom archive templates for CPTs
 */
function aitsc_archive_template($template)
{
	if (is_post_type_archive('solutions')) {
		$new_template = locate_template(array('archive-solutions.php', 'archive.php'));
		if ($new_template) {
			return $new_template;
		}
	}

	if (is_post_type_archive('case_studies')) {
		$new_template = locate_template(array('archive-case-studies.php', 'archive.php'));
		if ($new_template) {
			return $new_template;
		}
	}

	return $template;
}
add_filter('archive_template', 'aitsc_archive_template');

/**
 * Custom single templates for CPTs
 */
function aitsc_single_template($template)
{
	if (is_singular('solutions')) {
		$new_template = locate_template(array('single-solutions.php', 'single.php'));
		if ($new_template) {
			return $new_template;
		}
	}

	if (is_singular('case_studies')) {
		$new_template = locate_template(array('single-case-studies.php', 'single.php'));
		if ($new_template) {
			return $new_template;
		}
	}

	return $template;
}
add_filter('single_template', 'aitsc_single_template');

/**
 * Filter CPT archive queries for custom settings
 */
function aitsc_cpt_archive_query($query)
{
	if (!is_admin() && $query->is_main_query()) {
		if (is_post_type_archive('solutions')) {
			$posts_per_page = get_theme_mod('aitsc_solutions_posts_per_page', 12);
			$query->set('posts_per_page', $posts_per_page);
		}

		if (is_post_type_archive('case_studies')) {
			$posts_per_page = get_theme_mod('aitsc_case_studies_posts_per_page', 9);
			$query->set('posts_per_page', $posts_per_page);
		}
	}

	return $query;
}
add_filter('pre_get_posts', 'aitsc_cpt_archive_query');

/**
 * Enqueue CPT-specific scripts
 */
function aitsc_cpt_scripts()
{
	// Frontend scripts for CPT archives
	if (
		is_post_type_archive('solutions') || is_post_type_archive('case_studies') ||
		is_singular('solutions') || is_singular('case_studies')
	) {

		// REMOVED: cpt-frontend.js/css don't exist - were causing 404 errors
		// wp_enqueue_script(
		// 	'aitsc-cpt-frontend',
		// 	AITSC_THEME_URI . '/assets/js/cpt-frontend.js',
		// 	array('jquery'),
		// 	AITSC_VERSION,
		// 	true
		// );

		// wp_enqueue_style(
		// 	'aitsc-cpt-frontend',
		// 	AITSC_THEME_URI . '/assets/css/cpt-frontend.css',
		// 	array(),
		// 	AITSC_VERSION
		// );

		// REMOVED: wp_localize_script for non-existent script
		// Pass theme settings to JavaScript
		// wp_localize_script('aitsc_cpt_frontend', 'aitsc_cpt_settings', array(
		// 	'enable_animations' => get_theme_mod('aitsc_cpt_enable_animations', true),
		// 	'animation_style' => get_theme_mod('aitsc_cpt_animation_style', 'fade-up'),
		// 	'enable_filtering' => array(
		// 		'solutions' => get_theme_mod('aitsc_solutions_enable_filtering', true),
		// 		'case_studies' => get_theme_mod('aitsc_case_studies_enable_filtering', true)
		// 	),
		// 	'enable_search' => array(
		// 		'solutions' => get_theme_mod('aitsc_solutions_enable_search', true),
		// 		'case_studies' => get_theme_mod('aitsc_case_studies_enable_search', true)
		// 	),
		// 	'grid_columns' => array(
		// 		'solutions' => get_theme_mod('aitsc_solutions_grid_columns', '3'),
		// 		'case_studies' => get_theme_mod('aitsc_case_studies_grid_columns', '3')
		// 	),
		// 	'ajax_url' => admin_url('admin-ajax.php'),
		// 	'nonce' => wp_create_nonce('aitsc_cpt_nonce')
		// ));
	}
}
add_action('wp_enqueue_scripts', 'aitsc_cpt_scripts');

/**
 * AJAX handlers for CPT functionality
 */
function aitsc_cpt_ajax_handlers()
{
	add_action('wp_ajax_aitsc_filter_solutions', 'aitsc_ajax_filter_solutions');
	add_action('wp_ajax_nopriv_aitsc_filter_solutions', 'aitsc_ajax_filter_solutions');

	add_action('wp_ajax_aitsc_filter_case_studies', 'aitsc_ajax_filter_case_studies');
	add_action('wp_ajax_nopriv_aitsc_filter_case_studies', 'aitsc_ajax_filter_case_studies');

	add_action('wp_ajax_aitsc_search_solutions', 'aitsc_ajax_search_solutions');
	add_action('wp_ajax_nopriv_aitsc_search_solutions', 'aitsc_ajax_search_solutions');

	add_action('wp_ajax_aitsc_search_case_studies', 'aitsc_ajax_search_case_studies');
	add_action('wp_ajax_nopriv_aitsc_search_case_studies', 'aitsc_ajax_search_case_studies');
}
add_action('init', 'aitsc_cpt_ajax_handlers');

/**
 * AJAX filter solutions
 */
function aitsc_ajax_filter_solutions()
{
	check_ajax_referer('aitsc_cpt_nonce', 'nonce');

	$industry = isset($_POST['industry']) ? sanitize_text_field($_POST['industry']) : '';
	$service_type = isset($_POST['service_type']) ? sanitize_text_field($_POST['service_type']) : '';
	$complexity = isset($_POST['complexity']) ? sanitize_text_field($_POST['complexity']) : '';

	$args = array(
		'post_type' => 'solutions',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'tax_query' => array()
	);

	if (!empty($industry)) {
		$args['meta_query'][] = array(
			'key' => '_solution_industry_focus',
			'value' => $industry,
			'compare' => 'LIKE'
		);
	}

	if (!empty($service_type)) {
		$args['meta_query'][] = array(
			'key' => '_solution_service_type',
			'value' => $service_type
		);
	}

	if (!empty($complexity)) {
		$args['meta_query'][] = array(
			'key' => '_solution_complexity',
			'value' => $complexity
		);
	}

	$query = new WP_Query($args);

	$response = array(
		'success' => true,
		'posts' => array()
	);

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$response['posts'][] = array(
				'id' => get_the_ID(),
				'title' => get_the_title(),
				'excerpt' => get_the_excerpt(),
				'permalink' => get_permalink(),
				'thumbnail' => get_the_post_thumbnail_url('medium'),
				'categories' => wp_get_post_terms(get_the_ID(), 'solution_category'),
				'tags' => wp_get_post_terms(get_the_ID(), 'solution_tag')
			);
		}
	}

	wp_reset_postdata();
	wp_send_json($response);
	wp_die();
}

/**
 * AJAX filter case studies
 */
function aitsc_ajax_filter_case_studies()
{
	check_ajax_referer('aitsc_cpt_nonce', 'nonce');

	$client = isset($_POST['client']) ? sanitize_text_field($_POST['client']) : '';
	$industry = isset($_POST['industry']) ? sanitize_text_field($_POST['industry']) : '';
	$category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';

	$args = array(
		'post_type' => 'case_studies',
		'post_status' => 'publish',
		'posts_per_page' => -1
	);

	if (!empty($client)) {
		$args['meta_query'][] = array(
			'key' => '_case_study_client',
			'value' => $client,
			'compare' => 'LIKE'
		);
	}

	if (!empty($industry)) {
		$args['meta_query'][] = array(
			'key' => '_case_study_client_industry',
			'value' => $industry,
			'compare' => 'LIKE'
		);
	}

	if (!empty($category)) {
		$args['tax_query'][] = array(
			'taxonomy' => 'case_study_category',
			'field' => 'slug',
			'terms' => $category
		);
	}

	$query = new WP_Query($args);

	$response = array(
		'success' => true,
		'posts' => array()
	);

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$response['posts'][] = array(
				'id' => get_the_ID(),
				'title' => get_the_title(),
				'excerpt' => get_the_excerpt(),
				'permalink' => get_permalink(),
				'thumbnail' => get_the_post_thumbnail_url('medium'),
				'client' => get_post_meta(get_the_ID(), '_case_study_client', true),
				'industry' => get_post_meta(get_the_ID(), '_case_study_client_industry', true),
				'duration' => get_post_meta(get_the_ID(), '_case_study_duration', true),
				'categories' => wp_get_post_terms(get_the_ID(), 'case_study_category')
			);
		}
	}

	wp_reset_postdata();
	wp_send_json($response);
	wp_die();
}

/**
 * Utility: Clean Markdown from Content
 * Converts **text** to <strong>text</strong> and handles basic formatting for cleaner frontend output.
 */
function aitsc_parse_markdown_lite($content)
{
	// 1. Convert **text** to <strong>text</strong>
	$content = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $content);

	// 2. Convert *text* to <em>text</em>
	$content = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $content);

	return $content;
}
add_filter('the_content', 'aitsc_parse_markdown_lite');
add_filter('the_excerpt', 'aitsc_parse_markdown_lite');
add_filter('get_the_excerpt', 'aitsc_parse_markdown_lite');

/**
 * End of functions.php
 */
