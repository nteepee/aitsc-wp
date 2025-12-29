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
