<?php
/**
 * Bulk Image Upload Script for Seat Belt Pages
 * Phase B1: Image Integration
 */

require_once('wp-load.php');

if (!function_exists('media_handle_sideload')) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
}

// Track upload results
$results = [
    'success' => [],
    'failed' => [],
    'total' => 0
];

/**
 * Upload image and return attachment ID
 */
function upload_image($file_path, $title, $alt_text = '', $post_id = 0) {
    global $results;

    $results['total']++;

    if (!file_exists($file_path)) {
        $results['failed'][] = "File not found: $file_path";
        echo "❌ FAILED: $title - File not found\n";
        return false;
    }

    // Copy to temp directory
    $temp_file = wp_tempnam(basename($file_path));
    copy($file_path, $temp_file);

    // Prepare file array
    $file_array = [
        'name' => basename($file_path),
        'tmp_name' => $temp_file
    ];

    // Upload
    $attachment_id = media_handle_sideload($file_array, $post_id, $title);

    if (is_wp_error($attachment_id)) {
        $results['failed'][] = "$title: " . $attachment_id->get_error_message();
        echo "❌ FAILED: $title - " . $attachment_id->get_error_message() . "\n";
        @unlink($temp_file);
        return false;
    }

    // Set alt text
    if ($alt_text) {
        update_post_meta($attachment_id, '_wp_attachment_image_alt', $alt_text);
    }

    $results['success'][] = "$title (ID: $attachment_id)";
    echo "✅ SUCCESS: $title (ID: $attachment_id)\n";

    return $attachment_id;
}

echo "=== PHASE B1: IMAGE UPLOAD STARTED ===\n\n";

$base_path = "/Applications/MAMP/htdocs/aitsc-wp/ATISC CONTENT/AITSC 2";

// GROUP 1: Display Interface Screenshots (8 files)
echo "--- GROUP 1: Display Interface Screenshots ---\n";

upload_image("$base_path/Photos/800x480-v15---white-red.png",
    "Seat Belt Display Interface Main",
    "Main display unit showing seat belt status");

upload_image("$base_path/Photos/800x480-v15---white-red---4-row.png",
    "Buses Display 4-Row",
    "Display showing 4-row coach bus configuration");

upload_image("$base_path/Photos/800x480-v15---white-red---right-hand-drive.png",
    "Fleet Display Right-Hand Drive",
    "Display interface for right-hand drive fleet vehicles");

upload_image("$base_path/Photos/800x480-v15---white-red---no-last-row.png",
    "Rideshare Display Compact",
    "Compact 4-seater display for rideshare vehicles");

upload_image("$base_path/Diagrams/wiring v3.png",
    "Installation Wiring Diagram",
    "Complete system wiring schematic");

upload_image("$base_path/Photos/November BB/Converted by Thinh/16.png",
    "Buckle Sensor Component",
    "Seatbelt buckle sensor close-up view");

upload_image("$base_path/Photos/November BB/Converted by Thinh/21.png",
    "Seat Sensor Component",
    "Seat occupancy sensor pressure pad");

upload_image("$base_path/Photos/800x480-v15---white-red.png",
    "Display Unit Component",
    "Main display unit interface");

echo "\n--- GROUP 2: Feature Images (8 files) ---\n";

upload_image("$base_path/Photos/800x480-v15---white-red-4-seater.png",
    "4-Seater Display Configuration",
    "Display showing 4-passenger seating layout");

upload_image("$base_path/Photos/coach seating arrangement - small.png",
    "Coach Seating Layout",
    "Seating arrangement diagram for coach buses");

upload_image("$base_path/Photos/Hiace seating arrangement - small.png",
    "Hiace Fleet Seating",
    "Toyota Hiace fleet vehicle seating configuration");

upload_image("$base_path/Photos/800x480-v15---white-red-4-seater.png",
    "Rideshare 4-Passenger Layout",
    "4-passenger configuration for rideshare vehicles");

upload_image("$base_path/Diagrams/PXL_20250626_031747843.png",
    "Component Placement Diagram",
    "System component installation locations");

upload_image("$base_path/Photos/November BB/Converted by Thinh/10.png",
    "Installation Step 1",
    "First step in system installation process");

upload_image("$base_path/Photos/November BB/Converted by Thinh/11.png",
    "Installation Step 2",
    "Second step in system installation process");

upload_image("$base_path/Photos/November BB/Converted by Thinh/17.png",
    "Buckle Sensor Close-Up",
    "Detailed view of buckle sensor mechanism");

echo "\n--- GROUP 3: Spec Diagrams (3 files) ---\n";

upload_image("$base_path/Diagrams/wiring v3.png",
    "System Wiring Diagram",
    "Complete electrical wiring schematic");

upload_image("$base_path/Photos/coach seating arrangement wide 2-simplified.png",
    "Buses Seating Diagram",
    "Coach bus seating arrangement wide view");

upload_image("$base_path/Diagrams/PXL_20250626_031728699.jpg",
    "Installation Specification Diagram",
    "System installation specifications");

echo "\n--- GROUP 4: Gallery Images (13 files) ---\n";

// Primary Gallery
upload_image("$base_path/Photos/1-PXL_20250915_011220751.jpg",
    "Seat Belt System Gallery 1");
upload_image("$base_path/Photos/800x480-v14---white-red---4rows.png",
    "Seat Belt System Gallery 2");
upload_image("$base_path/Photos/800x480-v15---white-red---left-hand-drive---row-5-removed.png",
    "Seat Belt System Gallery 3");
upload_image("$base_path/Diagrams/PXL_20250626_031747843.png",
    "Seat Belt System Gallery 4");

// Buses Gallery
upload_image("$base_path/Photos/2-PXL_20250915_010542663.jpg",
    "Buses System Gallery 1");
upload_image("$base_path/Photos/3-PXL_20250915_011201690.jpg",
    "Buses System Gallery 2");

// Fleet Gallery
upload_image("$base_path/Photos/4-PXL_20250915_010524962.jpg",
    "Fleet System Gallery 1");
upload_image("$base_path/Photos/5-PXL_20250915_010414735.jpg",
    "Fleet System Gallery 2");

// Rideshare Gallery
upload_image("$base_path/Photos/6-PXL_20250915_010407976.jpg",
    "Rideshare System Gallery 1");
upload_image("$base_path/Photos/7-PXL_20250915_010401553.jpg",
    "Rideshare System Gallery 2");

// Installation Gallery
upload_image("$base_path/Photos/November BB/Converted by Thinh/12.png",
    "Installation Gallery 1");
upload_image("$base_path/Photos/November BB/Converted by Thinh/13.png",
    "Installation Gallery 2");
upload_image("$base_path/Photos/November BB/Converted by Thinh/14.png",
    "Installation Gallery 3");
upload_image("$base_path/Photos/November BB/Converted by Thinh/15.png",
    "Installation Gallery 4");

echo "\n=== UPLOAD COMPLETE ===\n";
echo "Total: {$results['total']}\n";
echo "Success: " . count($results['success']) . "\n";
echo "Failed: " . count($results['failed']) . "\n";

if (!empty($results['failed'])) {
    echo "\n--- FAILED UPLOADS ---\n";
    foreach ($results['failed'] as $failure) {
        echo "  - $failure\n";
    }
}

echo "\n--- ATTACHMENT IDs for ACF Population ---\n";
foreach ($results['success'] as $success) {
    echo "  - $success\n";
}
