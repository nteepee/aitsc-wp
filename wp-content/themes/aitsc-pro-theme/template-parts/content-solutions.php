<?php
/**
 * Solutions Content Template
 *
 * Template part for displaying solutions in grid view with industry filtering
 * and interactive hover effects.
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

// Get solution meta data
$solution_id = get_the_ID();
$industry_focus = get_post_meta($solution_id, '_solution_industry_focus', true) ?: array();
$service_type = get_post_meta($solution_id, '_solution_service_type', true);
$technologies = get_post_meta($solution_id, '_solution_technologies', true);
$complexity = get_post_meta($solution_id, '_solution_complexity', true);
$key_features = get_post_meta($solution_id, '_solution_key_features', true);

// Get first key feature for preview
$first_feature = '';
if ($key_features) {
	$features = explode("\n", $key_features);
	$features = array_filter(array_map('trim', $features));
	$first_feature = !empty($features) ? $features[0] : '';
}

// Industry labels for display
$industry_labels = array(
	'automotive' => __('Automotive', 'aitsc-pro-theme'),
	'industrial' => __('Industrial', 'aitsc-pro-theme'),
	'safety' => __('Safety', 'aitsc-pro-theme'),
	'aerospace' => __('Aerospace', 'aitsc-pro-theme'),
	'transportation' => __('Transportation', 'aitsc-pro-theme')
);

// Complexity classes for styling
$complexity_classes = array(
	'standard' => 'complexity-low',
	'complex' => 'complexity-medium',
	'enterprise' => 'complexity-high'
);
?>

<?php
/**
 * Solutions Content Template
 *
 * @package AITSC_Pro_Theme
 */

$solution_id = get_the_ID();
$service_type = get_post_meta($solution_id, '_solution_service_type', true);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('animate-fade-in'); ?>>
	<?php
	// Render unified solution card using AITSC component system
	aitsc_render_card([
		'variant' => 'solution',
		'title' => get_the_title(),
		'description' => get_the_excerpt(),
		'link' => get_permalink(),
		'image' => has_post_thumbnail() ? get_the_post_thumbnail_url($solution_id, 'large') : '',
		'icon' => 'shield', // Default icon for solutions
		'cta_text' => 'Explore Solution',
		'size' => 'medium',
		'custom_class' => 'aitsc-solution-card',
		'meta' => [
			'category' => $service_type ?: 'Expert Solution',
			'badge' => 'Solution'
		]
	]);
	?>
</article>

<!-- Hidden Data for JavaScript -->
<div class="solution-hidden-data" style="display: none;">
	<?php
	$data = array(
		'id' => $solution_id,
		'title' => get_the_title(),
		'excerpt' => get_the_excerpt(),
		'permalink' => get_permalink(),
		'thumbnail' => get_the_post_thumbnail_url($solution_id, 'large'),
		'industry_focus' => $industry_focus,
		'service_type' => $service_type,
		'technologies' => $technologies,
		'complexity' => $complexity,
		'key_features' => $key_features,
		'categories' => array_map(function ($cat) {
			return $cat->name;
		}, $categories ?: array())
	);
	echo '<script type="application/json">' . json_encode($data) . '</script>';
	?>
</div>