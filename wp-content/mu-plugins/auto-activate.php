<?php
/**
 * Must-Use Plugin for Auto-Activation
 * This will automatically activate plugins when WordPress loads
 */

// Auto-activate plugins on admin_init
add_action('admin_init', function() {
    $plugins_to_activate = array(
        'seo-by-rank-math/rank-math.php',
        'updraftplus/updraftplus.php',
        'duracelltomi-google-tag-manager/duracelltomi-google-tag-manager-for-wordpress.php'
    );

    foreach ($plugins_to_activate as $plugin) {
        if (!is_plugin_active($plugin) && file_exists(WP_PLUGIN_DIR . '/' . $plugin)) {
            activate_plugin($plugin);
        }
    }
});

// Display activation status in admin
add_action('admin_notices', function() {
    $active_plugins = get_option('active_plugins');
    $target_plugins = array(
        'seo-by-rank-math/rank-math.php',
        'updraftplus/updraftplus.php',
        'duracelltomi-google-tag-manager/duracelltomi-google-tag-manager-for-wordpress.php'
    );

    echo '<div class="notice notice-success is-dismissible">';
    echo '<h3>AITSC Plugin Installation Status:</h3>';
    echo '<ul>';

    foreach ($target_plugins as $plugin) {
        $plugin_name = explode('/', $plugin)[0];
        if (in_array($plugin, $active_plugins)) {
            echo '<li>✅ ' . $plugin_name . ' - Active</li>';
        } else {
            echo '<li>❌ ' . $plugin_name . ' - Not Active</li>';
        }
    }

    echo '</ul>';
    echo '</div>';
});

?>