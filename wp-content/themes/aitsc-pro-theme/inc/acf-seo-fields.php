<?php
/**
 * ACF SEO Meta Fields
 * SEO optimization for Solutions post type
 *
 * @package AITSC_Pro_Theme
 */

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
