<?php
define('DB_NAME', 'aitsctest_wp_dev');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', 'localhost:/Applications/MAMP/tmp/mysql/mysql.sock');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

$table_prefix = 'wp_';

define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', true); // Show errors on screen
define('WP_DEBUG_LOG', true); // Log to wp-content/debug.log
define('SCRIPT_DEBUG', true); // Use unminified versions
define('SAVEQUERIES', true); // Save database queries
define('WP_HOME', 'http://localhost:8888/aitsc-wp-copy');
define('WP_SITEURL', 'http://localhost:8888/aitsc-wp-copy');

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';
