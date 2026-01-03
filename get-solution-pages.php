<?php
require_once('wp-load.php');

$pages = get_posts(array(
    'post_type' => 'solutions',
    'post_status' => 'any',
    'posts_per_page' => -1,
    'orderby' => 'ID',
    'order' => 'ASC'
));

echo "Post IDs for Solution Pages:\n";
echo str_repeat('=', 60) . "\n";

foreach ($pages as $page) {
    printf("ID: %4d | %-50s | %s\n",
        $page->ID,
        $page->post_title,
        $page->post_name
    );
}

echo "\nTotal: " . count($pages) . " pages\n";
