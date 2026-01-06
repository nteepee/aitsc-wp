<?php
/**
 * Reset WordPress URL to Localhost
 * This script changes the WordPress site URL from test.philng.name.vn back to localhost
 */

// Database configuration
$db_host = 'localhost:/Applications/MAMP/tmp/mysql/mysql.sock';
$db_name = 'aitsctest_wp';
$db_user = 'root';
$db_pass = 'root';

// Connect to database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// URLs
$old_url = 'https://test.philng.name.vn';
$new_url = 'http://localhost:8888/aitsc-wp';

echo "=== WordPress URL Reset Script ===\n\n";
echo "Old URL: $old_url\n";
echo "New URL: $new_url\n\n";

// Update wp_options table
$updates = [
    'siteurl' => $new_url,
    'home' => $new_url,
];

$updated_count = 0;

foreach ($updates as $option => $value) {
    // First check if option exists
    $check_sql = "SELECT COUNT(*) as count FROM wp_options WHERE option_name = '" . $conn->real_escape_string($option) . "'";
    $result = $conn->query($check_sql);
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        // Update existing option
        $sql = "UPDATE wp_options SET option_value = '" . $conn->real_escape_string($value) . "'
                WHERE option_name = '" . $conn->real_escape_string($option) . "'";

        if ($conn->query($sql)) {
            echo "✓ Updated '$option' to '$value'\n";
            $updated_count++;
        } else {
            echo "✗ Failed to update '$option': " . $conn->error . "\n";
        }
    } else {
        // Insert new option
        $sql = "INSERT INTO wp_options (option_name, option_value)
                VALUES ('" . $conn->real_escape_string($option) . "', '" . $conn->real_escape_string($value) . "')";

        if ($conn->query($sql)) {
            echo "✓ Created '$option' with value '$value'\n";
            $updated_count++;
        } else {
            echo "✗ Failed to create '$option': " . $conn->error . "\n";
        }
    }
}

echo "\n=== Summary ===\n";
echo "Total updates: $updated_count\n\n";
echo "✓ WordPress has been reset to localhost!\n";
echo "✓ You can now access: http://localhost:8888/aitsc-wp/wp-admin/\n";

$conn->close();
?>
