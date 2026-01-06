<?php
/**
 * AITSC Bulk Image Upload Script
 *
 * Uploads organized images from /wp-content/uploads/aitsc-images/ to WordPress Media Library
 * Generates CSV mapping with attachment IDs for ACF field assignment
 *
 * Usage: wp eval-file scripts/bulk-image-upload.php
 */

// Define source directory
$UPLOAD_DIR = WP_CONTENT_DIR . '/uploads/aitsc-images';
$CSV_OUTPUT = WP_CONTENT_DIR . '/uploads/image-upload-mapping.csv';
$ERROR_LOG = WP_CONTENT_DIR . '/uploads/image-upload-errors.log';

// Image metadata by category
$IMAGE_CATEGORIES = [
    'heroes' => [
        'fleet-safe-pro' => ['purpose' => 'hero', 'category' => 'fleet-safe-pro', 'priority' => 'critical'],
        'pcb-design' => ['purpose' => 'hero', 'category' => 'pcb-design', 'priority' => 'critical'],
        'embedded-systems' => ['purpose' => 'hero', 'category' => 'embedded-systems', 'priority' => 'critical'],
        'automotive' => ['purpose' => 'hero', 'category' => 'automotive', 'priority' => 'critical'],
    ],
    'galleries' => [
        'fleet-safe-pro' => ['purpose' => 'gallery', 'category' => 'fleet-safe-pro', 'priority' => 'critical'],
        'pcb-design' => ['purpose' => 'gallery', 'category' => 'pcb-design', 'priority' => 'critical'],
        'embedded-systems' => ['purpose' => 'gallery', 'category' => 'embedded-systems', 'priority' => 'critical'],
        'automotive' => ['purpose' => 'gallery', 'category' => 'automotive', 'priority' => 'critical'],
        'november-bb' => ['purpose' => 'gallery', 'category' => 'general', 'priority' => 'recommended'],
    ],
    'graphics' => [
        'icons' => ['purpose' => 'icon', 'category' => 'graphics', 'priority' => 'recommended'],
        'decorative' => ['purpose' => 'decorative', 'category' => 'graphics', 'priority' => 'optional'],
        'backgrounds' => ['purpose' => 'background', 'category' => 'graphics', 'priority' => 'optional'],
    ],
    'technical' => [
        'diagrams' => ['purpose' => 'diagram', 'category' => 'technical', 'priority' => 'recommended'],
        'seating-maps' => ['purpose' => 'diagram', 'category' => 'technical', 'priority' => 'recommended'],
    ],
    'brand' => ['purpose' => 'brand', 'category' => 'brand', 'priority' => 'critical'],
];

// Initialize CSV
$csv_data = [
    ['Filename', 'Attachment ID', 'URL', 'Alt Text', 'Purpose', 'Category', 'Priority', 'Status', 'Uploaded At']
];

$upload_stats = [
    'total' => 0,
    'success' => 0,
    'skipped' => 0,
    'failed' => 0,
];

$errors = [];

WP_CLI::log('=== AITSC Bulk Image Upload ===');
WP_CLI::log('Source: ' . $UPLOAD_DIR);
WP_CLI::log('');

// Scan and upload images
foreach ($IMAGE_CATEGORIES as $main_cat => $subcats) {
    if (is_array($subcats) && isset($subcats['purpose'])) {
        // Brand category (flat structure)
        $subcats = [$main_cat => $subcats];
    }

    foreach ($subcats as $subcat => $metadata) {
        $dir = $UPLOAD_DIR . '/' . $main_cat . '/' . $subcat;

        if (!is_dir($dir)) {
            continue;
        }

        WP_CLI::log("Processing: $main_cat/$subcat");

        $files = array_diff(scandir($dir), ['.', '..', '.DS_Store']);

        foreach ($files as $file) {
            $file_path = $dir . '/' . $file;

            // Skip directories
            if (is_dir($file_path)) {
                continue;
            }

            // Skip non-image files
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed)) {
                continue;
            }

            $upload_stats['total']++;

            // Check if image already uploaded (by filename)
            $existing = new WP_Query([
                'post_type' => 'attachment',
                'posts_per_page' => 1,
                'meta_query' => [
                    [
                        'key' => '_aitsc_source_filename',
                        'value' => $file,
                        'compare' => '='
                    ]
                ]
            ]);

            if ($existing->found_posts > 0) {
                WP_CLI::log("  ⊘ Skipped: $file (already uploaded)");
                $upload_stats['skipped']++;

                $attachment_id = $existing->posts[0]->ID;
                $url = wp_get_attachment_url($attachment_id);
            } else {
                // Upload image
                $file_array = [
                    'name' => $file,
                    'tmp_name' => $file_path
                ];

                // Upload to WordPress Media Library
                $attachment_id = media_handle_sideload($file_array, 0);

                if (is_wp_error($attachment_id)) {
                    WP_CLI::log("  ✗ Failed: $file - " . $attachment_id->get_error_message());
                    $upload_stats['failed']++;
                    $errors[] = [
                        'file' => $file,
                        'error' => $attachment_id->get_error_message(),
                        'timestamp' => current_time('mysql')
                    ];
                    continue;
                }

                // Set metadata
                update_post_meta($attachment_id, '_aitsc_source_filename', $file);
                update_post_meta($attachment_id, '_aitsc_purpose', $metadata['purpose']);
                update_post_meta($attachment_id, '_aitsc_category', $metadata['category']);
                update_post_meta($attachment_id, '_aitsc_priority', $metadata['priority']);

                // Set alt text based on filename
                $alt_text = generate_alt_text($file, $metadata['purpose'], $metadata['category']);
                update_post_meta($attachment_id, '_wp_attachment_image_alt', $alt_text);

                $url = wp_get_attachment_url($attachment_id);
                WP_CLI::log("  ✓ Uploaded: $file (ID: $attachment_id)");
                $upload_stats['success']++;
            }

            // Add to CSV
            $csv_data[] = [
                $file,
                $attachment_id,
                $url,
                get_post_meta($attachment_id, '_wp_attachment_image_alt', true),
                $metadata['purpose'],
                $metadata['category'],
                $metadata['priority'],
                'Success',
                current_time('mysql')
            ];
        }

        WP_CLI::log("");
    }
}

// Write CSV file
if (count($csv_data) > 1) {
    $csv_file = fopen($CSV_OUTPUT, 'w');
    foreach ($csv_data as $row) {
        fputcsv($csv_file, $row);
    }
    fclose($csv_file);
    WP_CLI::success("CSV mapping written to: $CSV_OUTPUT");
} else {
    WP_CLI::warning("No images uploaded - CSV not generated");
}

// Write error log if there are errors
if (!empty($errors)) {
    $error_file = fopen($ERROR_LOG, 'w');
    fwrite($error_file, "AITSC Image Upload Error Log\n");
    fwrite($error_file, "Generated: " . current_time('mysql') . "\n");
    fwrite($error_file, "---\n\n");
    foreach ($errors as $error) {
        fwrite($error_file, "File: {$error['file']}\n");
        fwrite($error_file, "Error: {$error['error']}\n");
        fwrite($error_file, "Time: {$error['timestamp']}\n\n");
    }
    fclose($error_file);
    WP_CLI::warning("Error log written to: $ERROR_LOG");
}

// Summary
WP_CLI::log("");
WP_CLI::log("=== Upload Summary ===");
WP_CLI::log("Total processed: " . $upload_stats['total']);
WP_CLI::log("Successful: " . $upload_stats['success']);
WP_CLI::log("Skipped: " . $upload_stats['skipped']);
WP_CLI::log("Failed: " . $upload_stats['failed']);
WP_CLI::log("");

if ($upload_stats['failed'] == 0) {
    WP_CLI::success("All images processed successfully!");
} else {
    WP_CLI::warning($upload_stats['failed'] . " images failed - see error log");
}

/**
 * Generate alt text based on filename and metadata
 */
function generate_alt_text($filename, $purpose, $category) {
    // Remove extension and numbering
    $clean_name = preg_replace('/^[0-9]+-/', '', pathinfo($filename, PATHINFO_FILENAME));
    $clean_name = str_replace(['-', '_', 'PXL'], [' ', ' ', ''], $clean_name);
    $clean_name = ucwords(trim($clean_name));

    // Build alt text
    $category_name = ucfirst(str_replace('-', ' ', $category));

    switch ($purpose) {
        case 'hero':
            return "$category_name hero image";
        case 'gallery':
            return "$category_name product photo - $clean_name";
        case 'icon':
            return "$clean_name icon";
        case 'diagram':
            return "Technical diagram - $clean_name";
        default:
            return $clean_name;
    }
}
?>
