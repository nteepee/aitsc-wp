<?php
/**
 * Custom Post Types for AITSC Pro Theme
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Register Solutions Custom Post Type with Enhanced Features
 */
function aitsc_register_solutions_cpt()
{
	$labels = array(
		'name' => _x('Solutions', 'Post type general name', 'aitsc-pro-theme'),
		'singular_name' => _x('Solution', 'Post type singular name', 'aitsc-pro-theme'),
		'menu_name' => _x('Solutions', 'Admin Menu text', 'aitsc-pro-theme'),
		'name_admin_bar' => _x('Solution', 'Add New on Toolbar', 'aitsc-pro-theme'),
		'add_new' => __('Add New', 'aitsc-pro-theme'),
		'add_new_item' => __('Add New Solution', 'aitsc-pro-theme'),
		'new_item' => __('New Solution', 'aitsc-pro-theme'),
		'edit_item' => __('Edit Solution', 'aitsc-pro-theme'),
		'view_item' => __('View Solution', 'aitsc-pro-theme'),
		'all_items' => __('All Solutions', 'aitsc-pro-theme'),
		'search_items' => __('Search Solutions', 'aitsc-pro-theme'),
		'parent_item_colon' => __('Parent Solutions:', 'aitsc-pro-theme'),
		'not_found' => __('No solutions found.', 'aitsc-pro-theme'),
		'not_found_in_trash' => __('No solutions found in Trash.', 'aitsc-pro-theme'),
		'featured_image' => _x('Solution Cover Image', 'Overrides the "Featured Image" phrase for this post type.', 'aitsc-pro-theme'),
		'set_featured_image' => _x('Set cover image', 'Overrides the "Set featured image" phrase for this post type.', 'aitsc-pro-theme'),
		'remove_featured_image' => _x('Remove cover image', 'Overrides the "Remove featured image" phrase for this post type.', 'aitsc-pro-theme'),
		'use_featured_image' => _x('Use as cover image', 'Overrides the "Use as featured image" phrase for this post type.', 'aitsc-pro-theme'),
		'archives' => _x('Solution archives', 'The post type archive label used in nav menus.', 'aitsc-pro-theme'),
		'insert_into_item' => _x('Insert into solution', 'Overrides the "Insert into post" or "Insert into page" phrase.', 'aitsc-pro-theme'),
		'uploaded_to_this_item' => _x('Uploaded to this solution', 'Overrides the "Uploaded to this post" or "Uploaded to this page" phrase.', 'aitsc-pro-theme'),
		'filter_items_list' => _x('Filter solutions list', 'Screen reader text for the filter links heading on the post type listing screen.', 'aitsc-pro-theme'),
		'items_list_navigation' => _x('Solutions list navigation', 'Screen reader text for the pagination heading on the post type listing screen.', 'aitsc-pro-theme'),
		'items_list' => _x('Solutions list', 'Screen reader text for the items list heading on the post type listing screen.', 'aitsc-pro-theme'),
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'solutions/%solution_category%', 'with_front' => false),
		'capability_type' => 'post',
		'has_archive' => 'solutions',
		'hierarchical' => false,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-lightbulb',
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
		'show_in_rest' => true,
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'rest_base' => 'solutions',
		'template' => array(array('core/paragraph')),
		'template_lock' => 'all',
	);

	register_post_type('solutions', $args);
}
add_action('init', 'aitsc_register_solutions_cpt', 10);

/**
 * Filter the link for solutions to include the category.
 */
function aitsc_solution_permalink($post_link, $post)
{
	if ('solutions' === $post->post_type) {
		$terms = wp_get_object_terms($post->ID, 'solution_category');
		if ($terms && !is_wp_error($terms) && !empty($terms)) {
			return str_replace('%solution_category%', $terms[0]->slug, $post_link);
		} else {
			return str_replace('%solution_category%', 'uncategorized', $post_link);
		}
	}
	return $post_link;
}
add_filter('post_type_link', 'aitsc_solution_permalink', 10, 2);

/**
 * Register Case Studies Custom Post Type with Enhanced Features
 */
function aitsc_register_case_studies_cpt()
{
	$labels = array(
		'name' => _x('Case Studies', 'Post type general name', 'aitsc-pro-theme'),
		'singular_name' => _x('Case Study', 'Post type singular name', 'aitsc-pro-theme'),
		'menu_name' => _x('Case Studies', 'Admin Menu text', 'aitsc-pro-theme'),
		'name_admin_bar' => _x('Case Study', 'Add New on Toolbar', 'aitsc-pro-theme'),
		'add_new' => __('Add New', 'aitsc-pro-theme'),
		'add_new_item' => __('Add New Case Study', 'aitsc-pro-theme'),
		'new_item' => __('New Case Study', 'aitsc-pro-theme'),
		'edit_item' => __('Edit Case Study', 'aitsc-pro-theme'),
		'view_item' => __('View Case Study', 'aitsc-pro-theme'),
		'all_items' => __('All Case Studies', 'aitsc-pro-theme'),
		'search_items' => __('Search Case Studies', 'aitsc-pro-theme'),
		'parent_item_colon' => __('Parent Case Studies:', 'aitsc-pro-theme'),
		'not_found' => __('No case studies found.', 'aitsc-pro-theme'),
		'not_found_in_trash' => __('No case studies found in Trash.', 'aitsc-pro-theme'),
		'featured_image' => _x('Case Study Cover Image', 'Overrides the "Featured Image" phrase for this post type.', 'aitsc-pro-theme'),
		'set_featured_image' => _x('Set cover image', 'Overrides the "Set featured image" phrase for this post type.', 'aitsc-pro-theme'),
		'remove_featured_image' => _x('Remove cover image', 'Overrides the "Remove featured image" phrase for this post type.', 'aitsc-pro-theme'),
		'use_featured_image' => _x('Use as cover image', 'Overrides the "Use as featured image" phrase for this post type.', 'aitsc-pro-theme'),
		'archives' => _x('Case Study archives', 'The post type archive label used in nav menus.', 'aitsc-pro-theme'),
		'insert_into_item' => _x('Insert into case study', 'Overrides the "Insert into post" or "Insert into page" phrase.', 'aitsc-pro-theme'),
		'uploaded_to_this_item' => _x('Uploaded to this case study', 'Overrides the "Uploaded to this post" or "Uploaded to this page" phrase.', 'aitsc-pro-theme'),
		'filter_items_list' => _x('Filter case studies list', 'Screen reader text for the filter links heading on the post type listing screen.', 'aitsc-pro-theme'),
		'items_list_navigation' => _x('Case studies list navigation', 'Screen reader text for the pagination heading on the post type listing screen.', 'aitsc-pro-theme'),
		'items_list' => _x('Case studies list', 'Screen reader text for the items list heading on the post type listing screen.', 'aitsc-pro-theme'),
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'case-studies', 'with_front' => false),
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 21,
		'menu_icon' => 'dashicons-clipboard',
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions', 'author', 'page-attributes'),
		'show_in_rest' => true,
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'rest_base' => 'case-studies',
		'template' => array(array('core/paragraph')),
		'template_lock' => 'all',
	);

	register_post_type('case_studies', $args);
}
add_action('init', 'aitsc_register_case_studies_cpt');

/**
 * Register Solutions Taxonomies
 */
function aitsc_register_solutions_taxonomies()
{
	// Solutions Categories
	$labels = array(
		'name' => _x('Solution Categories', 'taxonomy general name', 'aitsc-pro-theme'),
		'singular_name' => _x('Solution Category', 'taxonomy singular name', 'aitsc-pro-theme'),
		'search_items' => __('Search Solution Categories', 'aitsc-pro-theme'),
		'all_items' => __('All Solution Categories', 'aitsc-pro-theme'),
		'parent_item' => __('Parent Solution Category', 'aitsc-pro-theme'),
		'parent_item_colon' => __('Parent Solution Category:', 'aitsc-pro-theme'),
		'edit_item' => __('Edit Solution Category', 'aitsc-pro-theme'),
		'update_item' => __('Update Solution Category', 'aitsc-pro-theme'),
		'add_new_item' => __('Add New Solution Category', 'aitsc-pro-theme'),
		'new_item_name' => __('New Solution Category Name', 'aitsc-pro-theme'),
		'menu_name' => __('Solution Categories', 'aitsc-pro-theme'),
	);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'solutions', 'with_front' => false),
		'show_in_rest' => true,
	);

	register_taxonomy('solution_category', array('solutions'), $args);

	// Solutions Tags
	$labels = array(
		'name' => _x('Solution Tags', 'taxonomy general name', 'aitsc-pro-theme'),
		'singular_name' => _x('Solution Tag', 'taxonomy singular name', 'aitsc-pro-theme'),
		'search_items' => __('Search Solution Tags', 'aitsc-pro-theme'),
		'all_items' => __('All Solution Tags', 'aitsc-pro-theme'),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __('Edit Solution Tag', 'aitsc-pro-theme'),
		'update_item' => __('Update Solution Tag', 'aitsc-pro-theme'),
		'add_new_item' => __('Add New Solution Tag', 'aitsc-pro-theme'),
		'new_item_name' => __('New Solution Tag Name', 'aitsc-pro-theme'),
		'menu_name' => __('Solution Tags', 'aitsc-pro-theme'),
		'separate_items_with_commas' => __('Separate solution tags with commas', 'aitsc-pro-theme'),
		'add_or_remove_items' => __('Add or remove solution tags', 'aitsc-pro-theme'),
		'choose_from_most_used' => __('Choose from the most used solution tags', 'aitsc-pro-theme'),
		'not_found' => __('No solution tags found.', 'aitsc-pro-theme'),
	);

	$args = array(
		'hierarchical' => false,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
		'rewrite' => array('slug' => 'solution-tag', 'with_front' => false),
		'show_in_rest' => true,
	);

	register_taxonomy('solution_tag', array('solutions'), $args);
}
add_action('init', 'aitsc_register_solutions_taxonomies', 9);

/**
 * Register Case Studies Taxonomies
 */
function aitsc_register_case_studies_taxonomies()
{
	// Case Studies Categories
	$labels = array(
		'name' => _x('Case Study Categories', 'taxonomy general name', 'aitsc-pro-theme'),
		'singular_name' => _x('Case Study Category', 'taxonomy singular name', 'aitsc-pro-theme'),
		'search_items' => __('Search Case Study Categories', 'aitsc-pro-theme'),
		'all_items' => __('All Case Study Categories', 'aitsc-pro-theme'),
		'parent_item' => __('Parent Case Study Category', 'aitsc-pro-theme'),
		'parent_item_colon' => __('Parent Case Study Category:', 'aitsc-pro-theme'),
		'edit_item' => __('Edit Case Study Category', 'aitsc-pro-theme'),
		'update_item' => __('Update Case Study Category', 'aitsc-pro-theme'),
		'add_new_item' => __('Add New Case Study Category', 'aitsc-pro-theme'),
		'new_item_name' => __('New Case Study Category Name', 'aitsc-pro-theme'),
		'menu_name' => __('Case Study Categories', 'aitsc-pro-theme'),
	);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'case-study-category', 'with_front' => false),
		'show_in_rest' => true,
	);

	register_taxonomy('case_study_category', array('case_studies'), $args);

	// Case Studies Tags
	$labels = array(
		'name' => _x('Case Study Tags', 'taxonomy general name', 'aitsc-pro-theme'),
		'singular_name' => _x('Case Study Tag', 'taxonomy singular name', 'aitsc-pro-theme'),
		'search_items' => __('Search Case Study Tags', 'aitsc-pro-theme'),
		'all_items' => __('All Case Study Tags', 'aitsc-pro-theme'),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __('Edit Case Study Tag', 'aitsc-pro-theme'),
		'update_item' => __('Update Case Study Tag', 'aitsc-pro-theme'),
		'add_new_item' => __('Add New Case Study Tag', 'aitsc-pro-theme'),
		'new_item_name' => __('New Case Study Tag Name', 'aitsc-pro-theme'),
		'menu_name' => __('Case Study Tags', 'aitsc-pro-theme'),
		'separate_items_with_commas' => __('Separate case study tags with commas', 'aitsc-pro-theme'),
		'add_or_remove_items' => __('Add or remove case study tags', 'aitsc-pro-theme'),
		'choose_from_most_used' => __('Choose from the most used case study tags', 'aitsc-pro-theme'),
		'not_found' => __('No case study tags found.', 'aitsc-pro-theme'),
	);

	$args = array(
		'hierarchical' => false,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
		'rewrite' => array('slug' => 'case-study-tag', 'with_front' => false),
		'show_in_rest' => true,
	);

	register_taxonomy('case_study_tag', array('case_studies'), $args);
}
add_action('init', 'aitsc_register_case_studies_taxonomies');

/**
 * Flush rewrite rules on plugin activation to prevent 404 errors
 */
function aitsc_flush_rewrite_rules()
{
	aitsc_register_solutions_cpt();
	aitsc_register_case_studies_cpt();
	aitsc_register_solutions_taxonomies();
	aitsc_register_case_studies_taxonomies();
	flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'aitsc_flush_rewrite_rules');

/**
 * Enhanced custom meta fields for Solutions
 */
function aitsc_solutions_meta_fields()
{
	$id = get_the_ID();
	wp_nonce_field('aitsc_solution_meta_nonce', 'solution_meta_nonce');

	echo '<div class="aitsc-meta-fields-container">';
	echo '<h4>' . esc_html__('Solution Details', 'aitsc-pro-theme') . '</h4>';

	// Industry Focus (Multi-select)
	$industry_focus = get_post_meta($id, '_solution_industry_focus', true) ?: array();
	$industries = array(
		'automotive' => __('Automotive', 'aitsc-pro-theme'),
		'industrial' => __('Industrial Manufacturing', 'aitsc-pro-theme'),
		'safety' => __('Safety & Compliance', 'aitsc-pro-theme'),
		'aerospace' => __('Aerospace & Defense', 'aitsc-pro-theme'),
		'transportation' => __('Transportation & Logistics', 'aitsc-pro-theme'),
	);
	echo '<div class="meta-field">';
	echo '<label for="solution_industry_focus">' . esc_html__('Industry Focus:', 'aitsc-pro-theme') . '</label>';
	echo '<select id="solution_industry_focus" name="solution_industry_focus[]" multiple class="widefat">';
	foreach ($industries as $key => $label) {
		$selected = in_array($key, (array) $industry_focus) ? 'selected="selected"' : '';
		echo '<option value="' . esc_attr($key) . '" ' . $selected . '>' . esc_html($label) . '</option>';
	}
	echo '</select>';
	echo '<small>' . esc_html__('Hold Ctrl/Cmd to select multiple industries', 'aitsc-pro-theme') . '</small>';
	echo '</div>';

	// Service Type
	$service_type = get_post_meta($id, '_solution_service_type', true);
	$service_types = array(
		'consulting' => __('Engineering Consulting', 'aitsc-pro-theme'),
		'testing' => __('Testing & Certification', 'aitsc-pro-theme'),
		'analysis' => __('Technical Analysis', 'aitsc-pro-theme'),
		'development' => __('Custom Solutions Development', 'aitsc-pro-theme'),
	);
	echo '<div class="meta-field">';
	echo '<label for="solution_service_type">' . esc_html__('Service Type:', 'aitsc-pro-theme') . '</label>';
	echo '<select id="solution_service_type" name="solution_service_type" class="widefat">';
	echo '<option value="">' . esc_html__('Select service type', 'aitsc-pro-theme') . '</option>';
	foreach ($service_types as $key => $label) {
		$selected = selected($service_type, $key, false);
		echo '<option value="' . esc_attr($key) . '" ' . $selected . '>' . esc_html($label) . '</option>';
	}
	echo '</select>';
	echo '</div>';

	// Technologies Used
	$technologies = get_post_meta($id, '_solution_technologies', true);
	echo '<div class="meta-field">';
	echo '<label for="solution_technologies">' . esc_html__('Technologies Used (comma-separated):', 'aitsc-pro-theme') . '</label>';
	echo '<input type="text" id="solution_technologies" name="solution_technologies" value="' . esc_attr($technologies) . '" class="widefat" />';
	echo '<small>' . esc_html__('e.g., MATLAB, CATIA, LabVIEW, ANSYS', 'aitsc-pro-theme') . '</small>';
	echo '</div>';

	// Project Complexity
	$complexity = get_post_meta($id, '_solution_complexity', true);
	echo '<div class="meta-field">';
	echo '<label for="solution_complexity">' . esc_html__('Project Complexity:', 'aitsc-pro-theme') . '</label>';
	echo '<select id="solution_complexity" name="solution_complexity" class="widefat">';
	$complexity_levels = array(
		'standard' => __('Standard (1-3 months)', 'aitsc-pro-theme'),
		'complex' => __('Complex (3-6 months)', 'aitsc-pro-theme'),
		'enterprise' => __('Enterprise (6+ months)', 'aitsc-pro-theme'),
	);
	foreach ($complexity_levels as $key => $label) {
		$selected = selected($complexity, $key, false);
		echo '<option value="' . esc_attr($key) . '" ' . $selected . '>' . esc_html($label) . '</option>';
	}
	echo '</select>';
	echo '</div>';

	// Key Features (as bullet points)
	$key_features = get_post_meta($id, '_solution_key_features', true);
	echo '<div class="meta-field">';
	echo '<label for="solution_key_features">' . esc_html__('Key Features (one per line):', 'aitsc-pro-theme') . '</label>';
	echo '<textarea id="solution_key_features" name="solution_key_features" class="widefat" rows="6">' . esc_textarea($key_features) . '</textarea>';
	echo '<small>' . esc_html__('Enter each feature on a new line', 'aitsc-pro-theme') . '</small>';
	echo '</div>';

	// Expected Outcomes
	$outcomes = get_post_meta($id, '_solution_outcomes', true);
	echo '<div class="meta-field">';
	echo '<label for="solution_outcomes">' . esc_html__('Expected Outcomes:', 'aitsc-pro-theme') . '</label>';
	echo '<textarea id="solution_outcomes" name="solution_outcomes" class="widefat" rows="4">' . esc_textarea($outcomes) . '</textarea>';
	echo '</div>';

	// Certification/Compliance
	$certification = get_post_meta($id, '_solution_certification', true);
	echo '<div class="meta-field">';
	echo '<label for="solution_certification">' . esc_html__('Certifications & Compliance:', 'aitsc-pro-theme') . '</label>';
	echo '<input type="text" id="solution_certification" name="solution_certification" value="' . esc_attr($certification) . '" class="widefat" placeholder="' . esc_attr__('e.g., ISO 9001, IATF 16949', 'aitsc-pro-theme') . '" />';
	echo '</div>';

	echo '</div>';
}

/**
 * Enhanced custom meta fields for Case Studies
 */
function aitsc_case_studies_meta_fields()
{
	$id = get_the_ID();
	wp_nonce_field('aitsc_case_study_meta_nonce', 'case_study_meta_nonce');

	echo '<div class="aitsc-meta-fields-container">';
	echo '<h4>' . esc_html__('Case Study Details', 'aitsc-pro-theme') . '</h4>';

	// Client Information
	$client = get_post_meta($id, '_case_study_client', true);
	echo '<div class="meta-field">';
	echo '<label for="case_study_client">' . esc_html__('Client Name:', 'aitsc-pro-theme') . '</label>';
	echo '<input type="text" id="case_study_client" name="case_study_client" value="' . esc_attr($client) . '" class="widefat" />';
	echo '</div>';

	$client_industry = get_post_meta($id, '_case_study_client_industry', true);
	echo '<div class="meta-field">';
	echo '<label for="case_study_client_industry">' . esc_html__('Client Industry:', 'aitsc-pro-theme') . '</label>';
	echo '<input type="text" id="case_study_client_industry" name="case_study_client_industry" value="' . esc_attr($client_industry) . '" class="widefat" />';
	echo '</div>';

	// Project Details
	$project_title = get_post_meta($id, '_case_study_project_title', true);
	echo '<div class="meta-field">';
	echo '<label for="case_study_project_title">' . esc_html__('Project Title:', 'aitsc-pro-theme') . '</label>';
	echo '<input type="text" id="case_study_project_title" name="case_study_project_title" value="' . esc_attr($project_title) . '" class="widefat" />';
	echo '</div>';

	$duration = get_post_meta($id, '_case_study_duration', true);
	echo '<div class="meta-field">';
	echo '<label for="case_study_duration">' . esc_html__('Project Duration:', 'aitsc-pro-theme') . '</label>';
	echo '<input type="text" id="case_study_duration" name="case_study_duration" value="' . esc_attr($duration) . '" class="widefat" placeholder="' . esc_attr__('e.g., 6 months, 18 weeks', 'aitsc-pro-theme') . '" />';
	echo '</div>';

	$team_size = get_post_meta($id, '_case_study_team_size', true);
	echo '<div class="meta-field">';
	echo '<label for="case_study_team_size">' . esc_html__('Team Size:', 'aitsc-pro-theme') . '</label>';
	echo '<input type="text" id="case_study_team_size" name="case_study_team_size" value="' . esc_attr($team_size) . '" class="widefat" placeholder="' . esc_attr__('e.g., 3 engineers, 8 specialists', 'aitsc-pro-theme') . '" />';
	echo '</div>';

	$project_budget = get_post_meta($id, '_case_study_project_budget', true);
	echo '<div class="meta-field">';
	echo '<label for="case_study_project_budget">' . esc_html__('Project Budget:', 'aitsc-pro-theme') . '</label>';
	echo '<input type="text" id="case_study_project_budget" name="case_study_project_budget" value="' . esc_attr($project_budget) . '" class="widefat" placeholder="' . esc_attr__('e.g., $250,000, €180,000', 'aitsc-pro-theme') . '" />';
	echo '</div>';

	// Technical Details
	$technologies = get_post_meta($id, '_case_study_technologies', true);
	echo '<div class="meta-field">';
	echo '<label for="case_study_technologies">' . esc_html__('Technologies Used (comma-separated):', 'aitsc-pro-theme') . '</label>';
	echo '<input type="text" id="case_study_technologies" name="case_study_technologies" value="' . esc_attr($technologies) . '" class="widefat" placeholder="' . esc_attr__('e.g., CATIA V5, MATLAB, LabVIEW', 'aitsc-pro-theme') . '" />';
	echo '</div>';

	$challenge = get_post_meta($id, '_case_study_challenge', true);
	echo '<div class="meta-field">';
	echo '<label for="case_study_challenge">' . esc_html__('Main Challenge:', 'aitsc-pro-theme') . '</label>';
	echo '<textarea id="case_study_challenge" name="case_study_challenge" class="widefat" rows="4">' . esc_textarea($challenge) . '</textarea>';
	echo '</div>';

	// Results & Metrics
	$results = get_post_meta($id, '_case_study_results', true);
	echo '<div class="meta-field">';
	echo '<label for="case_study_results">' . esc_html__('Key Results:', 'aitsc-pro-theme') . '</label>';
	echo '<textarea id="case_study_results" name="case_study_results" class="widefat" rows="6">' . esc_textarea($results) . '</textarea>';
	echo '<small>' . esc_html__('Enter each result on a new line', 'aitsc-pro-theme') . '</small>';
	echo '</div>';

	// Measurable Metrics
	$metrics = get_post_meta($id, '_case_study_metrics', true);
	echo '<div class="meta-field">';
	echo '<label for="case_study_metrics">' . esc_html__('Measurable Metrics:', 'aitsc-pro-theme') . '</label>';
	echo '<textarea id="case_study_metrics" name="case_study_metrics" class="widefat" rows="4">' . esc_textarea($metrics) . '</textarea>';
	echo '<small>' . esc_html__('Format: Metric: Value - e.g., Cost Savings: 40%', 'aitsc-pro-theme') . '</small>';
	echo '</div>';

	// Gallery Images (comma-separated attachment IDs)
	$gallery_ids = get_post_meta($id, '_case_study_gallery', true);
	echo '<div class="meta-field">';
	echo '<label for="case_study_gallery">' . esc_html__('Gallery Image IDs:', 'aitsc-pro-theme') . '</label>';
	echo '<input type="text" id="case_study_gallery" name="case_study_gallery" value="' . esc_attr($gallery_ids) . '" class="widefat" placeholder="' . esc_attr__('Comma-separated image attachment IDs', 'aitsc-pro-theme') . '" />';
	echo '</div>';

	// Testimonial
	$testimonial = get_post_meta($id, '_case_study_testimonial', true);
	echo '<div class="meta-field">';
	echo '<label for="case_study_testimonial">' . esc_html__('Client Testimonial:', 'aitsc-pro-theme') . '</label>';
	echo '<textarea id="case_study_testimonial" name="case_study_testimonial" class="widefat" rows="4">' . esc_textarea($testimonial) . '</textarea>';
	echo '</div>';

	$testimonial_author = get_post_meta($id, '_case_study_testimonial_author', true);
	echo '<div class="meta-field">';
	echo '<label for="case_study_testimonial_author">' . esc_html__('Testimonial Author & Position:', 'aitsc-pro-theme') . '</label>';
	echo '<input type="text" id="case_study_testimonial_author" name="case_study_testimonial_author" value="' . esc_attr($testimonial_author) . '" class="widefat" placeholder="' . esc_attr__('e.g., John Smith, VP of Engineering', 'aitsc-pro-theme') . '" />';
	echo '</div>';

	echo '</div>';
}

/**
 * Save enhanced custom meta fields with nonce verification
 */
function aitsc_save_custom_meta_fields($post_id)
{
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;
	if (!current_user_can('edit_post', $post_id))
		return;

	// Save Solutions meta fields
	if (get_post_type($post_id) === 'solutions') {
		if (!isset($_POST['solution_meta_nonce']) || !wp_verify_nonce($_POST['solution_meta_nonce'], 'aitsc_solution_meta_nonce')) {
			return;
		}

		// Industry Focus (array)
		if (isset($_POST['solution_industry_focus'])) {
			$industry_focus = array_map('sanitize_text_field', $_POST['solution_industry_focus']);
			update_post_meta($post_id, '_solution_industry_focus', $industry_focus);
		}

		// Service Type
		if (isset($_POST['solution_service_type'])) {
			update_post_meta($post_id, '_solution_service_type', sanitize_text_field($_POST['solution_service_type']));
		}

		// Technologies
		if (isset($_POST['solution_technologies'])) {
			update_post_meta($post_id, '_solution_technologies', sanitize_text_field($_POST['solution_technologies']));
		}

		// Complexity
		if (isset($_POST['solution_complexity'])) {
			update_post_meta($post_id, '_solution_complexity', sanitize_text_field($_POST['solution_complexity']));
		}

		// Key Features
		if (isset($_POST['solution_key_features'])) {
			update_post_meta($post_id, '_solution_key_features', sanitize_textarea_field($_POST['solution_key_features']));
		}

		// Outcomes
		if (isset($_POST['solution_outcomes'])) {
			update_post_meta($post_id, '_solution_outcomes', sanitize_textarea_field($_POST['solution_outcomes']));
		}

		// Certification
		if (isset($_POST['solution_certification'])) {
			update_post_meta($post_id, '_solution_certification', sanitize_text_field($_POST['solution_certification']));
		}
	}

	// Save Case Studies meta fields
	if (get_post_type($post_id) === 'case_studies') {
		if (!isset($_POST['case_study_meta_nonce']) || !wp_verify_nonce($_POST['case_study_meta_nonce'], 'aitsc_case_study_meta_nonce')) {
			return;
		}

		// Client Information
		if (isset($_POST['case_study_client'])) {
			update_post_meta($post_id, '_case_study_client', sanitize_text_field($_POST['case_study_client']));
		}
		if (isset($_POST['case_study_client_industry'])) {
			update_post_meta($post_id, '_case_study_client_industry', sanitize_text_field($_POST['case_study_client_industry']));
		}

		// Project Details
		if (isset($_POST['case_study_project_title'])) {
			update_post_meta($post_id, '_case_study_project_title', sanitize_text_field($_POST['case_study_project_title']));
		}
		if (isset($_POST['case_study_duration'])) {
			update_post_meta($post_id, '_case_study_duration', sanitize_text_field($_POST['case_study_duration']));
		}
		if (isset($_POST['case_study_team_size'])) {
			update_post_meta($post_id, '_case_study_team_size', sanitize_text_field($_POST['case_study_team_size']));
		}
		if (isset($_POST['case_study_project_budget'])) {
			update_post_meta($post_id, '_case_study_project_budget', sanitize_text_field($_POST['case_study_project_budget']));
		}

		// Technical Details
		if (isset($_POST['case_study_technologies'])) {
			update_post_meta($post_id, '_case_study_technologies', sanitize_text_field($_POST['case_study_technologies']));
		}
		if (isset($_POST['case_study_challenge'])) {
			update_post_meta($post_id, '_case_study_challenge', sanitize_textarea_field($_POST['case_study_challenge']));
		}

		// Results & Metrics
		if (isset($_POST['case_study_results'])) {
			update_post_meta($post_id, '_case_study_results', sanitize_textarea_field($_POST['case_study_results']));
		}
		if (isset($_POST['case_study_metrics'])) {
			update_post_meta($post_id, '_case_study_metrics', sanitize_textarea_field($_POST['case_study_metrics']));
		}

		// Gallery
		if (isset($_POST['case_study_gallery'])) {
			update_post_meta($post_id, '_case_study_gallery', sanitize_text_field($_POST['case_study_gallery']));
		}

		// Testimonial
		if (isset($_POST['case_study_testimonial'])) {
			update_post_meta($post_id, '_case_study_testimonial', sanitize_textarea_field($_POST['case_study_testimonial']));
		}
		if (isset($_POST['case_study_testimonial_author'])) {
			update_post_meta($post_id, '_case_study_testimonial_author', sanitize_text_field($_POST['case_study_testimonial_author']));
		}
	}
}
add_action('save_post', 'aitsc_save_custom_meta_fields');

/**
 * Add meta boxes for custom post types
 */
function aitsc_add_custom_meta_boxes()
{
	add_meta_box(
		'solution_details',
		__('Solution Details', 'aitsc-pro-theme'),
		'aitsc_solutions_meta_fields',
		'solutions',
		'normal',
		'default'
	);

	add_meta_box(
		'case_study_details',
		__('Case Study Details', 'aitsc-pro-theme'),
		'aitsc_case_studies_meta_fields',
		'case_studies',
		'normal',
		'default'
	);
}
add_action('add_meta_boxes', 'aitsc_add_custom_meta_boxes');

/**
 * Add CPT support to main query
 * NOTE: Disabled to prevent Solutions/Case Studies from appearing in the standard Blog feed.
 */
// function aitsc_add_cpt_to_query($query)
// {
// 	if (is_home() && $query->is_main_query()) {
// 		$query->set('post_type', array('post', 'solutions', 'case_studies'));
// 	}
// 	return $query;
// }
// add_filter('pre_get_posts', 'aitsc_add_cpt_to_query');