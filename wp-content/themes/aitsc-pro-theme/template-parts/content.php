<?php
/**
 * Template part for displaying posts (Unified Card System)
 *
 * @package AITSCProTheme
 */

// Prepare metadata for blog card
$meta = [
	'date' => get_the_date('M j, Y'),
	'category' => '',
	'read_time' => '',
];

// Get categories (exclude uncategorized)
$categories = get_the_category();
$category_names = [];
if ($categories) {
	foreach ($categories as $category) {
		if ($category->slug !== 'uncategorized') {
			$category_names[] = $category->name;
		}
	}
}
if (!empty($category_names)) {
	$meta['category'] = implode(', ', $category_names);
}

// Calculate read time
$content = get_post_field('post_content', get_the_ID());
$word_count = str_word_count(strip_tags($content));
$read_time = ceil($word_count / 200); // 200 words per minute
$meta['read_time'] = $read_time . ' min read';

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('animate-fade-in'); ?>>
	<?php
	// Render unified blog card
	aitsc_render_card([
		'variant' => 'blog',
		'title' => get_the_title(),
		'description' => wp_trim_words(get_the_excerpt(), 25, '...'),
		'link' => get_permalink(),
		'image' => has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : '',
		'cta_text' => 'Read Full Insight',
		'size' => 'medium',
		'custom_class' => 'wq-blog-card',
		'meta' => $meta
	]);
	?>
</article>