<?php
/**
 * Temporary script to activate aitsc-gp-child theme
 * Access: http://localhost:8888/activate-theme.php
 * DELETE AFTER USE!
 */

// Load WordPress
require_once(__DIR__ . '/wp-load.php');

// Verify we're in WP admin context or add security check
if (!current_user_can('manage_options')) {
    die('Access denied. Please log in as admin.');
}

$theme = 'aitsc-gp-child';

// Switch theme
switch_theme($theme);

echo "<h2>Theme Activated: $theme</h2>";
echo "<p><strong>IMPORTANT:</strong> Delete this file immediately!</p>";
echo "<p>Next steps:</p>";
echo "<ol>";
echo "<li>Go to <a href='/wp-admin/'>WordPress Admin</a></li>";
echo "<li>Appearance > Themes (verify aitsc-gp-child is active)</li>";
echo "<li>Appearance > GeneratePress > Activate License</li>";
echo "<li>License key: <code>de485e6af6e7e30eb60dbe638d50e55f</code></li>";
echo "<li>Delete this file: <code>activate-theme.php</code></li>";
echo "</ol>";
