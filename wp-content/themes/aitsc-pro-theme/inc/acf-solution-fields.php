<?php
/**
 * ACF Field Groups for Solution Pages
 * Registers all field groups for the 'solutions' custom post type
 *
 * @package AITSC_Pro_Theme
 * @since 3.1.0
 */

if (!defined('ABSPATH')) {
	exit;
}

// Register ACF field groups
add_action('acf/include_fields', function() {
	if (!function_exists('acf_add_local_field_group')) {
		return;
	}

	// Solution Hero Section
	acf_add_local_field_group(array(
		'key' => 'group_solution_hero',
		'title' => 'Solution Hero Section',
		'fields' => array(
			array(
				'key' => 'field_hero_title',
				'label' => 'Hero Title',
				'name' => 'hero_section',
				'type' => 'group',
				'sub_fields' => array(
					array(
						'key' => 'field_hero_title_text',
						'label' => 'Title',
						'name' => 'title',
						'type' => 'text',
						'required' => 1,
					),
					array(
						'key' => 'field_hero_subtitle',
						'label' => 'Subtitle',
						'name' => 'subtitle',
						'type' => 'textarea',
						'rows' => 3,
					),
					array(
						'key' => 'field_hero_image',
						'label' => 'Background Image',
						'name' => 'image',
						'type' => 'image',
						'return_format' => 'url',
					),
					array(
						'key' => 'field_hero_cta_text',
						'label' => 'CTA Button Text',
						'name' => 'cta_text',
						'type' => 'text',
						'default_value' => 'Get Started',
					),
					array(
						'key' => 'field_hero_cta_link',
						'label' => 'CTA Button Link',
						'name' => 'cta_link',
						'type' => 'url',
						'default_value' => '#contact',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'solutions',
				),
			),
		),
		'menu_order' => 10,
	));

	// Solution Overview
	acf_add_local_field_group(array(
		'key' => 'group_solution_overview',
		'title' => 'Solution Overview',
		'fields' => array(
			array(
				'key' => 'field_overview_text',
				'label' => 'Overview Content',
				'name' => 'overview_text',
				'type' => 'wysiwyg',
				'toolbar' => 'full',
				'media_upload' => 1,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'solutions',
				),
			),
		),
		'menu_order' => 20,
	));

	// Solution Features
	acf_add_local_field_group(array(
		'key' => 'group_solution_features',
		'title' => 'Solution Features',
		'fields' => array(
			array(
				'key' => 'field_features',
				'label' => 'Features',
				'name' => 'features',
				'type' => 'repeater',
				'button_label' => 'Add Feature',
				'sub_fields' => array(
					array(
						'key' => 'field_feature_title',
						'label' => 'Feature Title',
						'name' => 'feature_title',
						'type' => 'text',
						'required' => 1,
					),
					array(
						'key' => 'field_feature_description',
						'label' => 'Feature Description',
						'name' => 'feature_description',
						'type' => 'textarea',
						'rows' => 3,
					),
					array(
						'key' => 'field_feature_icon',
						'label' => 'Feature Icon (class or emoji)',
						'name' => 'feature_icon',
						'type' => 'text',
						'placeholder' => 'e.g., icon-gear or 🔧',
					),
				),
				'min' => 0,
				'max' => 10,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'solutions',
				),
			),
		),
		'menu_order' => 30,
	));

	// Solution Specifications
	acf_add_local_field_group(array(
		'key' => 'group_solution_specs',
		'title' => 'Solution Specifications',
		'fields' => array(
			array(
				'key' => 'field_specs',
				'label' => 'Specifications',
				'name' => 'specs',
				'type' => 'repeater',
				'button_label' => 'Add Specification',
				'sub_fields' => array(
					array(
						'key' => 'field_spec_label',
						'label' => 'Specification Label',
						'name' => 'spec_label',
						'type' => 'text',
						'required' => 1,
					),
					array(
						'key' => 'field_spec_value',
						'label' => 'Specification Value',
						'name' => 'spec_value',
						'type' => 'text',
						'required' => 1,
					),
				),
				'min' => 0,
				'max' => 20,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'solutions',
				),
			),
		),
		'menu_order' => 40,
	));

	// Solution Gallery
	acf_add_local_field_group(array(
		'key' => 'group_solution_gallery',
		'title' => 'Solution Gallery',
		'fields' => array(
			array(
				'key' => 'field_gallery_images',
				'label' => 'Gallery Images',
				'name' => 'gallery_images',
				'type' => 'gallery',
				'return_format' => 'array',
				'preview_size' => 'medium',
				'insert' => 'append',
				'library' => 'all',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'solutions',
				),
			),
		),
		'menu_order' => 50,
	));

	// Solution Case Studies
	acf_add_local_field_group(array(
		'key' => 'group_solution_case_studies',
		'title' => 'Solution Case Studies',
		'fields' => array(
			array(
				'key' => 'field_related_case_studies',
				'label' => 'Related Case Studies',
				'name' => 'related_case_studies',
				'type' => 'relationship',
				'post_type' => array(
					0 => 'post', // Assuming case studies are posts
				),
				'return_format' => 'object',
				'min' => 0,
				'max' => 5,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'solutions',
				),
			),
		),
		'menu_order' => 60,
	));

	// Solution CTA Section
	acf_add_local_field_group(array(
		'key' => 'group_solution_cta',
		'title' => 'Solution CTA Section',
		'fields' => array(
			array(
				'key' => 'field_cta_section',
				'label' => 'Call-to-Action Section',
				'name' => 'cta',
				'type' => 'group',
				'sub_fields' => array(
					array(
						'key' => 'field_cta_title',
						'label' => 'CTA Title',
						'name' => 'cta_section_title',
						'type' => 'text',
						'default_value' => 'Ready to Get Started?',
					),
					array(
						'key' => 'field_cta_description',
						'label' => 'CTA Description',
						'name' => 'cta_section_description',
						'type' => 'wysiwyg',
						'toolbar' => 'basic',
						'media_upload' => 0,
					),
					array(
						'key' => 'field_cta_button_text',
						'label' => 'Button Text',
						'name' => 'cta_button_text',
						'type' => 'text',
						'default_value' => 'Contact Us',
					),
					array(
						'key' => 'field_cta_button_link',
						'label' => 'Button Link',
						'name' => 'cta_button_link',
						'type' => 'url',
						'default_value' => '#contact',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'solutions',
				),
			),
		),
		'menu_order' => 70,
	));
});
