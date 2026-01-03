<?php
define('DB_NAME', 'aitsctest_wp');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', 'localhost:/Applications/MAMP/tmp/mysql/mysql.sock');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

$table_prefix = 'wp_';

define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', false); // Hide notices from displaying
define('WP_DEBUG_LOG', true); // Log to wp-content/debug.log instead
define('WP_HOME', 'http://localhost:8888/aitsc-wp');
define('WP_SITEURL', 'http://localhost:8888/aitsc-wp');

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';
