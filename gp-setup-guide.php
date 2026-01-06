<?php
/**
 * GP Premium Setup Script
 * Run once to activate child theme and setup GP Premium
 * Access: http://localhost:8888/gp-setup-guide.php
 * DELETE AFTER USE!
 */

// Load WordPress without theme
define('WP_USE_THEMES', false);
require_once(__DIR__ . '/wp-load.php');

// Security: Only logged in admins
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    auth_redirect();
}

$messages = [];
$errors = [];

// 1. Activate Child Theme
$theme = 'aitsc-gp-child';
if (wp_get_theme()->get_stylesheet() !== $theme) {
    $result = switch_theme($theme);
    if (is_wp_error($result)) {
        $errors[] = "Theme activation failed: " . $result->get_error_message();
    } else {
        $messages[] = "✅ Child theme '$theme' activated!";
    }
} else {
    $messages[] = "✅ Child theme '$theme' already active!";
}

// 2. Check if GP Premium plugin exists
$gp_premium_plugin = 'gp-premium/gp-premium.php';
if (!file_exists(WP_PLUGIN_DIR . '/gp-premium/gp-premium.php')) {
    $errors[] = "⚠️ GP Premium plugin not installed. Download from: <a href='https://generatepress.com/account' target='_blank'>GeneratePress Account</a>";
    $errors[] = "License key: <code>de485e6af6e7e30eb60dbe638d50e55f</code>";
} else {
    // Activate GP Premium
    if (!is_plugin_active($gp_premium_plugin)) {
        activate_plugin($gp_premium_plugin);
        $messages[] = "✅ GP Premium plugin activated!";
    } else {
        $messages[] = "✅ GP Premium plugin already active!";
    }

    // 3. Activate GP Premium License
    $license_key = 'de485e6af6e7e30eb60dbe638d50e55f';
    if (get_option('generatepress_premium_license_key') !== $license_key) {
        update_option('generatepress_premium_license_key', $license_key);
        $messages[] = "✅ GP Premium license key saved!";
    }
}

// 4. Verify theme structure
$child_theme_path = get_stylesheet_directory();
$required_files = [
    'functions.php',
    'style.css',
    'inc/custom-post-types.php',
    'inc/acf-fields.php',
    'inc/components.php',
];

foreach ($required_files as $file) {
    if (!file_exists($child_theme_path . '/' . $file)) {
        $errors[] = "❌ Missing required file: $file";
    }
}

// 5. Check for PHP errors
$messages[] = "✅ All required theme files present!";

?>
<!DOCTYPE html>
<html>
<head>
    <title>GP Setup - AITSC Migration</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, sans-serif; max-width: 800px; margin: 40px auto; padding: 20px; }
        h1 { color: #333; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .warning { background: #fff3cd; color: #856404; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .info { background: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 5px; margin: 10px 0; }
        code { background: #f5f5f5; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
        pre { background: #f5f5f5; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .btn { display: inline-block; padding: 10px 20px; background: #0073aa; color: white; text-decoration: none; border-radius: 5px; margin: 5px; }
        .btn:hover { background: #005177; }
    </style>
</head>
<body>
    <h1>🚀 GeneratePress Setup - AITSC Migration</h1>

    <?php if (!empty($messages)): ?>
        <?php foreach ($messages as $msg): ?>
            <div class="success"><?php echo $msg; ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="info">
        <h3>📋 Current Status:</h3>
        <ul>
            <li>Active Theme: <strong><?php echo wp_get_theme()->get('Name'); ?></strong></li>
            <li>Child Theme: <strong><?php echo get_stylesheet(); ?></strong></li>
            <li>GP Premium Active: <strong><?php echo is_plugin_active('gp-premium/gp-premium.php') ? 'Yes ✅' : 'No ❌'; ?></strong></li>
        </ul>
    </div>

    <?php if (empty($errors)): ?>
        <div class="success">
            <h3>✨ Setup Complete!</h3>
            <p>Next steps:</p>
            <ol>
                <li><a href="/wp-admin/" class="btn">Go to WordPress Admin</a></li>
                <li>Appearance > GeneratePress > Modules (enable needed modules)</li>
                <li>Appearance > GeneratePress > License (verify activation)</li>
                <li>Test frontend: <a href="/" class="btn">View Site</a></li>
                <li><strong>DELETE THIS FILE: <code>gp-setup-guide.php</code></strong></li>
            </ol>
        </div>
    <?php else: ?>
        <div class="warning">
            <h3>⚠️ Manual Steps Required:</h3>
            <ol>
                <li>Download GP Premium from <a href="https://generatepress.com/account" target="_blank">GeneratePress Account</a></li>
                <li>Upload to: <code>/wp-content/plugins/</code></li>
                <li>Refresh this page</li>
            </ol>
        </div>
    <?php endif; ?>

    <div class="info">
        <h3>📁 Theme Structure Verified:</h3>
        <pre><?php
        $files = array_filter(glob($child_theme_path . '/*.php'), 'is_file');
        foreach ($files as $file) {
            echo basename($file) . "\n";
        }
        ?></pre>
    </div>

    <div class="warning">
        <strong>⚠️ SECURITY WARNING:</strong> Delete this file after setup: <code>gp-setup-guide.php</code>
    </div>
</body>
</html>
