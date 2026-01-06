<?php
/**
 * Quick child theme activator - DELETE AFTER USE!
 */
define('WP_USE_THEMES', false);
require_once(__DIR__ . '/wp-load.php');

$theme = 'aitsc-gp-child';

// Activate theme
switch_theme($theme);

// Clear caches
update_option('theme_switched', false);

echo "✅ Theme activated: $theme\n";
echo "🌐 Access: http://localhost:8888/\n";
echo "🔧 Admin: http://localhost:8888/wp-admin/\n";
echo "\n⚠️ DELETE THIS FILE NOW!\n";

// Verify theme files
$theme_path = get_stylesheet_directory();
echo "\n📁 Theme files:\n";
foreach (glob($theme_path . '/*.php') as $file) {
    echo "  - " . basename($file) . "\n";
}
