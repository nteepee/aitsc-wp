<?php
/**
 * ACF Field Groups - Solution Page Content
 *
 * Registers ACF field groups for solution landing pages.
 * Provides dynamic content management for all solution posts.
 *
 * @package AITSC_Pro_Theme
 * @subpackage ACF
 * @since 3.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Solution Page Content Fields
 *
 * Field group applied to 'solutions' post type.
 * Provides complete content structure for solution landing pages.
 */
if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group([
        'key' => 'group_solution_page',
        'title' => 'Solution Page Content',
        'fields' => [
            // Hero Section
            [
                'key' => 'field_hero_section',
                'label' => 'Hero Section',
                'name' => 'hero_section',
                'type' => 'group',
                'layout' => 'block',
                'sub_fields' => [
                    [
                        'key' => 'field_hero_title',
                        'label' => 'Hero Title',
                        'name' => 'title',
                        'type' => 'text',
                        'required' => 1,
                        'placeholder' => 'Custom PCB Design & Development',
                        'instructions' => 'Main hero headline (supports HTML)',
                    ],
                    [
                        'key' => 'field_hero_subtitle',
                        'label' => 'Hero Subtitle',
                        'name' => 'subtitle',
                        'type' => 'textarea',
                        'rows' => 3,
                        'placeholder' => 'From concept to production-ready boards in weeks, not months',
                        'instructions' => 'Supporting text below hero title',
                    ],
                    [
                        'key' => 'field_hero_image',
                        'label' => 'Hero Background Image',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'url',
                        'preview_size' => 'medium',
                        'instructions' => 'Optional: Background image (particle system displays by default)',
                    ],
                    [
                        'key' => 'field_hero_cta_text',
                        'label' => 'CTA Button Text',
                        'name' => 'cta_text',
                        'type' => 'text',
                        'default_value' => 'Get Started',
                        'placeholder' => 'Request Quote',
                    ],
                    [
                        'key' => 'field_hero_cta_link',
                        'label' => 'CTA Button Link',
                        'name' => 'cta_link',
                        'type' => 'url',
                        'default_value' => '#contact',
                        'placeholder' => '#contact',
                    ],
                ],
            ],

            // Overview Section
            [
                'key' => 'field_overview_content',
                'label' => 'Solution Overview',
                'name' => 'overview_content',
                'type' => 'wysiwyg',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
                'instructions' => 'Rich text description of the solution (Executive Summary)',
            ],

            // Key Features (Repeater)
            [
                'key' => 'field_key_features',
                'label' => 'Key Features',
                'name' => 'key_features',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add Feature',
                'min' => 3,
                'max' => 8,
                'collapsed' => 'field_feature_title',
                'sub_fields' => [
                    [
                        'key' => 'field_feature_icon',
                        'label' => 'Icon',
                        'name' => 'feature_icon',
                        'type' => 'text',
                        'placeholder' => 'settings',
                        'instructions' => 'Material Symbol icon name (e.g., "settings", "shield", "speed")',
                        'default_value' => 'check_circle',
                    ],
                    [
                        'key' => 'field_feature_title',
                        'label' => 'Feature Title',
                        'name' => 'feature_title',
                        'type' => 'text',
                        'required' => 1,
                        'placeholder' => 'Rapid Prototyping',
                    ],
                    [
                        'key' => 'field_feature_description',
                        'label' => 'Feature Description',
                        'name' => 'feature_description',
                        'type' => 'textarea',
                        'rows' => 3,
                        'required' => 1,
                        'placeholder' => 'Fast turnaround from design to physical prototype',
                    ],
                ],
            ],

            // Technical Specifications
            [
                'key' => 'field_specs_section',
                'label' => 'Technical Specifications',
                'name' => 'specs_section',
                'type' => 'group',
                'layout' => 'block',
                'sub_fields' => [
                    [
                        'key' => 'field_specs_content',
                        'label' => 'Specifications Content',
                        'name' => 'content',
                        'type' => 'wysiwyg',
                        'tabs' => 'all',
                        'toolbar' => 'full',
                        'media_upload' => 0,
                        'instructions' => 'HTML table or formatted specifications',
                    ],
                    [
                        'key' => 'field_specs_pdf',
                        'label' => 'Specifications PDF',
                        'name' => 'pdf_link',
                        'type' => 'file',
                        'return_format' => 'url',
                        'mime_types' => 'pdf',
                        'instructions' => 'Optional: Downloadable PDF specifications',
                    ],
                ],
            ],

            // Product Gallery
            [
                'key' => 'field_solution_gallery',
                'label' => 'Product Gallery',
                'name' => 'gallery_images',
                'type' => 'gallery',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'insert' => 'append',
                'library' => 'all',
                'min' => 0,
                'max' => 20,
                'instructions' => 'Product photos and images (supports lightbox)',
            ],

            // Flexible Content Sections
            [
                'key' => 'field_solution_sections',
                'label' => 'Flexible Content Sections',
                'name' => 'solution_sections',
                'type' => 'flexible_content',
                'button_label' => 'Add Section',
                'layouts' => [
                    // Text + Image Layout
                    'text_image' => [
                        'key' => 'layout_text_image',
                        'name' => 'text_image',
                        'label' => 'Text + Image',
                        'display' => 'block',
                        'sub_fields' => [
                            [
                                'key' => 'field_ti_title',
                                'label' => 'Section Title',
                                'name' => 'title',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'field_ti_content',
                                'label' => 'Content',
                                'name' => 'content',
                                'type' => 'wysiwyg',
                            ],
                            [
                                'key' => 'field_ti_image',
                                'label' => 'Image',
                                'name' => 'image',
                                'type' => 'image',
                                'return_format' => 'array',
                            ],
                            [
                                'key' => 'field_ti_layout',
                                'label' => 'Image Position',
                                'name' => 'layout',
                                'type' => 'select',
                                'choices' => [
                                    'left' => 'Image Left',
                                    'right' => 'Image Right',
                                ],
                                'default_value' => 'right',
                            ],
                        ],
                    ],

                    // 3-Column Features
                    'three_columns' => [
                        'key' => 'layout_three_columns',
                        'name' => 'three_columns',
                        'label' => '3-Column Features',
                        'display' => 'block',
                        'sub_fields' => [
                            [
                                'key' => 'field_3col_title',
                                'label' => 'Section Title',
                                'name' => 'title',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'field_3col_items',
                                'label' => 'Column Items',
                                'name' => 'items',
                                'type' => 'repeater',
                                'min' => 3,
                                'max' => 3,
                                'layout' => 'block',
                                'button_label' => 'Add Column',
                                'sub_fields' => [
                                    [
                                        'key' => 'field_3col_item_icon',
                                        'label' => 'Icon',
                                        'name' => 'icon',
                                        'type' => 'text',
                                        'placeholder' => 'check_circle',
                                    ],
                                    [
                                        'key' => 'field_3col_item_title',
                                        'label' => 'Title',
                                        'name' => 'title',
                                        'type' => 'text',
                                    ],
                                    [
                                        'key' => 'field_3col_item_content',
                                        'label' => 'Content',
                                        'name' => 'content',
                                        'type' => 'textarea',
                                        'rows' => 4,
                                    ],
                                ],
                            ],
                        ],
                    ],

                    // Full-Width Video
                    'video' => [
                        'key' => 'layout_video',
                        'name' => 'video',
                        'label' => 'Video Section',
                        'display' => 'block',
                        'sub_fields' => [
                            [
                                'key' => 'field_video_title',
                                'label' => 'Section Title',
                                'name' => 'title',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'field_video_url',
                                'label' => 'Video URL',
                                'name' => 'video_url',
                                'type' => 'url',
                                'placeholder' => 'https://youtube.com/watch?v=...',
                                'instructions' => 'YouTube, Vimeo, or direct video URL',
                            ],
                        ],
                    ],
                ],
            ],

            // Related Case Studies
            [
                'key' => 'field_related_case_studies',
                'label' => 'Related Case Studies',
                'name' => 'related_case_studies',
                'type' => 'relationship',
                'post_type' => ['case_studies'],
                'filters' => ['search'],
                'return_format' => 'id',
                'min' => 0,
                'max' => 3,
                'instructions' => 'Select related case studies to display',
            ],

            // CTA Section
            [
                'key' => 'field_cta_section',
                'label' => 'Call-to-Action Section',
                'name' => 'cta_section',
                'type' => 'group',
                'layout' => 'block',
                'sub_fields' => [
                    [
                        'key' => 'field_cta_title',
                        'label' => 'CTA Title',
                        'name' => 'title',
                        'type' => 'text',
                        'default_value' => 'Ready to Get Started?',
                    ],
                    [
                        'key' => 'field_cta_description',
                        'label' => 'CTA Description',
                        'name' => 'description',
                        'type' => 'textarea',
                        'rows' => 3,
                        'default_value' => 'Contact us to discuss how our solutions can help your project',
                    ],
                    [
                        'key' => 'field_cta_form_shortcode',
                        'label' => 'Form Shortcode',
                        'name' => 'form_shortcode',
                        'type' => 'text',
                        'placeholder' => '[gravityform id="1"]',
                        'instructions' => 'Gravity Forms or Contact Form 7 shortcode',
                    ],
                    [
                        'key' => 'field_cta_button_text',
                        'label' => 'Button Text',
                        'name' => 'button_text',
                        'type' => 'text',
                        'default_value' => 'Request Quote',
                    ],
                    [
                        'key' => 'field_cta_button_link',
                        'label' => 'Button Link',
                        'name' => 'button_link',
                        'type' => 'url',
                        'placeholder' => '#contact',
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'solutions',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
        'show_in_rest' => 0,
    ]);
}


// Merged from acf-solution-fields.php
// Register additional ACF field groups
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


// Merged from acf-seo-fields.php
// SEO Meta Fields
if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'group_seo_meta',
        'title' => 'SEO Meta Tags',
        'fields' => array(
            array(
                'key' => 'field_seo_meta_description',
                'label' => 'Meta Description',
                'name' => 'seo_meta_description',
                'type' => 'textarea',
                'instructions' => 'SEO meta description (150-160 characters). Appears in Google search results.',
                'required' => 0,
                'maxlength' => 160,
                'rows' => 3,
                'placeholder' => 'Enter a compelling description that encourages clicks...',
            ),
            array(
                'key' => 'field_seo_og_image',
                'label' => 'Open Graph Image',
                'name' => 'seo_og_image',
                'type' => 'image',
                'instructions' => 'Image for social media sharing (recommended: 1200x630px). Defaults to featured image if not set.',
                'required' => 0,
                'return_format' => 'url',
                'preview_size' => 'large',
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
        'menu_order' => 10,
        'position' => 'side',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
}
