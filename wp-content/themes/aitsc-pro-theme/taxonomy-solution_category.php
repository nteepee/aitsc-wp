<?php
/**
 * The template for displaying solution category archive pages
 *
 * Shows all solutions within a specific solution_category taxonomy term.
 *
 * @package AITSC_Pro_Theme
 * @since 3.1.0
 */

get_header();
?>

<main id="primary" class="site-main">

	<!-- Category Header -->
	<section class="archive-header full-width">
		<div class="container">
			<?php
			$term = get_queried_object();
			$parent = $term->parent ? get_term($term->parent, 'solution_category') : null;
			?>

			<?php if ($parent && $parent->term_id): ?>
				<div class="breadcrumb-nav">
					<a href="<?php echo esc_url(get_post_type_archive_link('solutions')); ?>">Solutions</a>
					<span>/</span>
					<a href="<?php echo esc_url(get_term_link($parent, 'solution_category')); ?>">
						<?php echo esc_html($parent->name); ?>
					</a>
					<span>/</span>
					<span><?php echo esc_html($term->name); ?></span>
				</div>
			<?php else: ?>
				<div class="breadcrumb-nav">
					<a href="<?php echo esc_url(get_post_type_archive_link('solutions')); ?>">Solutions</a>
					<span>/</span>
					<span><?php echo esc_html($term->name); ?></span>
				</div>
			<?php endif; ?>

			<h1 class="archive-title">
				<?php echo esc_html($term->name); ?>
			</h1>
			<?php if ($term->description): ?>
				<p class="archive-description">
					<?php echo wp_kses_post($term->description); ?>
				</p>
			<?php endif; ?>
		</div>
	</section>

	<!-- Solutions in Category Grid -->
	<section class="solutions-archive-section full-width" data-aos="fade-up" data-aos-duration="1000">
		<div class="container">
			<?php if (have_posts()): ?>
				<div class="solutions-grid">
					<?php
					while (have_posts()):
						the_post();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<?php
							// Render unified solution card
							aitsc_render_card([
								'variant' => 'solution',
								'title' => get_the_title(),
								'description' => get_the_excerpt(),
								'link' => get_permalink(),
								'icon' => 'shield', // Default icon
								'cta_text' => 'Explore Solution',
								'size' => 'medium',
								'custom_class' => 'solution-card'
							]);
							?>
						</article>
					<?php endwhile; ?>
				</div>

				<div class="pagination">
					<?php
					the_posts_pagination(array(
						'prev_text' => '<span class="screen-reader-text">' . __('Previous page', 'aitsc-pro-theme') . '</span>',
						'next_text' => '<span class="screen-reader-text">' . __('Next page', 'aitsc-pro-theme') . '</span>',
						'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'aitsc-pro-theme') . ' </span>',
					));
					?>
				</div>

			<?php else: ?>
				<p><?php esc_html_e('No solutions found in this category.', 'aitsc-pro-theme'); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<!-- Subcategories (if any) -->
	<?php
	$subcategories = get_terms(array(
		'taxonomy'   => 'solution_category',
		'hide_empty' => true,
		'parent'     => $term->term_id,
	));

	if (!empty($subcategories) && !is_wp_error($subcategories)): ?>
		<section class="subcategories-section full-width">
			<div class="container">
				<h2>Related Categories</h2>
				<div class="solutions-grid">
					<?php foreach ($subcategories as $subcat): ?>
						<article class="category-card">
							<?php
							// Render unified category card
							aitsc_render_card([
								'variant' => 'icon',
								'title' => $subcat->name,
								'description' => $subcat->description ?: 'View subcategory',
								'link' => get_term_link($subcat, 'solution_category'),
								'icon' => 'category', // Default category icon
								'cta_text' => 'View Subcategory',
								'size' => 'medium',
								'custom_class' => 'solution-card'
							]);
							?>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

</main><!-- #primary -->

<style>
	.breadcrumb-nav {
		font-size: var(--text-sm);
		color: var(--aitsc-text-grey);
		margin-bottom: var(--space-6);
	}

	.breadcrumb-nav a {
		color: var(--aitsc-blue);
		text-decoration: none;
	}

	.breadcrumb-nav a:hover {
		text-decoration: underline;
	}

	.breadcrumb-nav span {
		margin: 0 var(--space-2);
	}

	.subcategories-section {
		margin-top: var(--space-16);
		padding-top: var(--space-12);
		border-top: 1px solid var(--aitsc-border);
	}

	.subcategories-section h2 {
		font-size: var(--text-3xl);
		margin-bottom: var(--space-8);
		color: var(--aitsc-text-white);
	}
</style>

<?php
get_footer();
