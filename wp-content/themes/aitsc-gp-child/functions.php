<?php
/**
 * AITSC GeneratePress Child Theme
 *
 * @package AITSC_GP_Child
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Constants
define('AITSC_GP_VERSION', '1.0.0');
define('AITSC_GP_THEME_DIR', get_stylesheet_directory());
define('AITSC_GP_THEME_URI', get_stylesheet_directory_uri());

// Backwards compatibility: Map legacy constants to child theme
// This ensures preserved code that references old constants works
if (!defined('AITSC_THEME_DIR')) {
    define('AITSC_THEME_DIR', AITSC_GP_THEME_DIR);
}
if (!defined('AITSC_THEME_URI')) {
    define('AITSC_THEME_URI', AITSC_GP_THEME_URI);
}
if (!defined('AITSC_VERSION')) {
    define('AITSC_VERSION', AITSC_GP_VERSION);
}

/**
 * Enqueue child theme assets
 */
function aitsc_gp_enqueue_assets() {
    $theme_version = wp_get_theme(get_template())->get('Version');

    // Legacy CSS band-aid - loads original theme styles for immediate visual fix
    $legacy_css = get_stylesheet_directory() . '/assets/css/legacy.css';
    if (file_exists($legacy_css)) {
        wp_enqueue_style('aitsc-legacy', get_stylesheet_directory_uri() . '/assets/css/legacy.css', array('generatepress-style'), $theme_version);
    }

    // Enqueue available CSS files
    $blog_css = get_stylesheet_directory() . '/assets/css/single-blog-style.css';
    if (file_exists($blog_css)) {
        wp_enqueue_style('aitsc-blog-style', get_stylesheet_directory_uri() . '/assets/css/single-blog-style.css', array('generatepress-style'), $theme_version);
    }

    // Paper stack styles (if created)
    $paper_css = get_stylesheet_directory() . '/components/paper-stack/paper-stack.css';
    if (file_exists($paper_css)) {
        wp_enqueue_style('aitsc-paper-stack', get_stylesheet_directory_uri() . '/components/paper-stack/paper-stack.css', array(), $theme_version);
    }

    // Paper stack scripts (if created)
    $paper_js = get_stylesheet_directory() . '/components/paper-stack/paper-stack.js';
    if (file_exists($paper_js)) {
        wp_enqueue_script('aitsc-paper-stack-js', get_stylesheet_directory_uri() . '/components/paper-stack/paper-stack.js', array(), $theme_version, true);
    }

    // Enqueue JavaScript files
    $js_files = array(
        'theme-core' => '/assets/js/theme-core.js',
        'navigation' => '/assets/js/navigation.js',
        'forms' => '/assets/js/forms.js',
        'scroll-animations' => '/assets/js/scroll-animations.js',
        'particle-system' => '/assets/js/particle-system.js',
        'paper-stack-fallback' => '/assets/js/paper-stack-fallback.js',
    );

    foreach ($js_files as $handle => $path) {
        $js_file = get_stylesheet_directory() . $path;
        if (file_exists($js_file)) {
            // Add jQuery as dependency for theme scripts
            wp_enqueue_script('aitsc-' . $handle, get_stylesheet_directory_uri() . $path, array('jquery'), $theme_version, true);
        }
    }
}
add_action('wp_enqueue_scripts', 'aitsc_gp_enqueue_assets', 20);

/**
 * Theme Setup
 */
function aitsc_gp_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'gallery', 'caption'));
    add_theme_support('customize-selective-refresh-widgets');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'aitsc-gp'),
        'footer' => __('Footer Menu', 'aitsc-gp'),
    ));

    // Remove parent theme actions if needed
    remove_action('generate_footer', 'generate_construct_footer');
}
add_action('after_setup_theme', 'aitsc_gp_theme_setup');

/**
 * Flush rewrite rules on activation
 */
function aitsc_gp_activate() {
    // CPTs are already registered via includes
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'aitsc_gp_activate');

/**
 * Enqueue parent theme style
 */
function aitsc_gp_parent_enqueue() {
    wp_enqueue_style('generatepress-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'aitsc_gp_parent_enqueue');

/**
 * Load preserved modules
 * Note: GP handles enqueue, theme-options, customizer internally
 */
require_once AITSC_GP_THEME_DIR . '/inc/custom-post-types.php';
require_once AITSC_GP_THEME_DIR . '/inc/acf-fields.php';
require_once AITSC_GP_THEME_DIR . '/inc/components.php';
require_once AITSC_GP_THEME_DIR . '/inc/paper-stack.php';
require_once AITSC_GP_THEME_DIR . '/inc/contact-ajax.php';
require_once AITSC_GP_THEME_DIR . '/inc/template-tags.php';

// Using original header.php and footer.php from aitsc-pro-theme
// Custom header/footer hooks removed to preserve original design
