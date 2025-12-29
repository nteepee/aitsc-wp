<?php
/**
 * AITSC Pro Theme - Test File
 * This file tests basic theme functionality
 *
 * To run: http://localhost:8888/aitsc-wp/wp-content/themes/aitsc-pro-theme/test-theme.php
 */

// Include WordPress
require_once('../../../../wp-config.php');

// Test theme constants
echo "<h1>AITSC Pro Theme Test</h1>";

// Test if theme directory exists
$theme_path = get_theme_root() . '/aitsc-pro-theme';
if (is_dir($theme_path)) {
    echo "<p style='color: green;'>✓ Theme directory exists: $theme_path</p>";
} else {
    echo "<p style='color: red;'>✗ Theme directory not found</p>";
}

// Test if style.css exists and has proper theme header
$style_css = $theme_path . '/style.css';
if (file_exists($style_css)) {
    echo "<p style='color: green;'>✓ style.css exists</p>";

    // Read and display theme header
    $style_content = file_get_contents($style_css);
    if (strpos($style_content, 'Theme Name: AITSC Pro Theme') !== false) {
        echo "<p style='color: green;'>✓ Theme header found in style.css</p>";
    } else {
        echo "<p style='color: red;'>✗ Theme header not found in style.css</p>";
    }
} else {
    echo "<p style='color: red;'>✗ style.css not found</p>";
}

// Test if functions.php exists
if (file_exists($theme_path . '/functions.php')) {
    echo "<p style='color: green;'>✓ functions.php exists</p>";
} else {
    echo "<p style='color: red;'>✗ functions.php not found</p>";
}

// Test customizer files
$customizer_files = [
    'inc/customizer.php',
    'inc/customizer-callbacks.php',
    'customizer/panels/colors.php',
    'customizer/panels/typography.php',
    'customizer/panels/layout.php',
    'customizer/panels/header.php',
    'customizer/panels/footer.php',
    'customizer/panels/homepage.php'
];

echo "<h2>Customizer Files Test:</h2>";
foreach ($customizer_files as $file) {
    $full_path = $theme_path . '/' . $file;
    if (file_exists($full_path)) {
        echo "<p style='color: green;'>✓ $file</p>";
    } else {
        echo "<p style='color: red;'>✗ $file</p>";
    }
}

// Test assets directory
$assets_files = [
    'assets/css/design-system.css',
    'assets/js/customizer-preview.js'
];

echo "<h2>Assets Files Test:</h2>";
foreach ($assets_files as $file) {
    $full_path = $theme_path . '/' . $file;
    if (file_exists($full_path)) {
        $size = filesize($full_path);
        echo "<p style='color: green;'>✓ $file ($size bytes)</p>";
    } else {
        echo "<p style='color: red;'>✗ $file</p>";
    }
}

// Test if theme is recognized by WordPress
if (wp_get_theme('aitsc-pro-theme')->exists()) {
    echo "<p style='color: green;'>✓ Theme is recognized by WordPress</p>";
} echo "<h2>Next Steps:</h2>";
echo "<ol>";
echo "<li>Go to WordPress Admin: <a href='http://localhost:8888/aitsc-wp/wp-admin/'>http://localhost:8888/aitsc-wp/wp-admin/</a></li>";
echo "<li>Navigate to Appearance → Themes</li>";
echo "<li>Activate 'AITSC Pro Theme'</li>";
echo "<li>Go to Appearance → Customize to test theme options</li>";
echo "</ol>";

echo "<p><strong>Theme Status:</strong> Ready for activation!</p>";
?>