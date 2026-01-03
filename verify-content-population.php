<?php
/**
 * Verification Script - Content Population
 * Checks all 8 pages have correct ACF content
 */

define('WP_USE_THEMES', false);
require_once(__DIR__ . '/wp-load.php');

$page_ids = array(144, 146, 147, 149, 145, 148, 150, 151);

echo "=== CONTENT POPULATION VERIFICATION ===\n\n";

$all_valid = true;

foreach ($page_ids as $post_id) {
    $post = get_post($post_id);
    echo "Post ID {$post_id}: {$post->post_title}\n";

    // Check problem_cards
    $problem_cards = get_field('problem_cards', $post_id);
    $problem_count = is_array($problem_cards) ? count($problem_cards) : 0;
    $problem_ok = $problem_count === 4;
    echo "  ✓ problem_cards: {$problem_count}/4 cards" . ($problem_ok ? " ✓" : " ✗") . "\n";

    // Check solution_overview
    $solution = get_field('solution_overview', $post_id);
    $solution_ok = is_array($solution) &&
                   !empty($solution['title']) &&
                   !empty($solution['subtitle']) &&
                   !empty($solution['text']) &&
                   !empty($solution['highlight_title']) &&
                   !empty($solution['highlight_text']);
    echo "  ✓ solution_overview: " . ($solution_ok ? "Complete ✓" : "Missing fields ✗") . "\n";

    // Check features
    $features = get_field('features', $post_id);
    $features_count = is_array($features) ? count($features) : 0;
    $features_ok = $features_count === 10;
    echo "  ✓ features: {$features_count}/10 features" . ($features_ok ? " ✓" : " ✗") . "\n";

    // Verify "You Get" prefix in features
    $you_get_count = 0;
    if (is_array($features)) {
        foreach ($features as $feature) {
            if (strpos($feature['title'], 'You Get ') === 0) {
                $you_get_count++;
            }
        }
    }
    echo "  ✓ benefit language: {$you_get_count}/10 with 'You Get' prefix" . ($you_get_count === 10 ? " ✓" : " ✗") . "\n";

    $page_valid = $problem_ok && $solution_ok && $features_ok && ($you_get_count === 10);
    echo "  " . ($page_valid ? "✓ VALID" : "✗ ISSUES FOUND") . "\n\n";

    if (!$page_valid) {
        $all_valid = false;
    }
}

echo "\n=== SUMMARY ===\n";
echo "Total pages verified: " . count($page_ids) . "\n";
echo "Status: " . ($all_valid ? "✓✓✓ ALL PAGES VALID ✓✓✓" : "✗ SOME PAGES HAVE ISSUES") . "\n";

exit($all_valid ? 0 : 1);
