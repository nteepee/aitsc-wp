<?php
/**
 * The template for displaying archive pages for Case Studies
 */

get_header();
?>

<main id="primary" class="site-main">

	<header class="page-header section-header">
		<div class="container">
			<h1 class="page-title">SUCCESS <span class="text-orange">STORIES</span></h1>
			<div class="archive-description">
				<p>Proven results across the Australian transport logistics sector.</p>
			</div>
		</div>
	</header>

	<section class="case-studies-list section">
		<div class="container">
			<?php if (have_posts()): ?>
				<div class="case-study-rows">
					<?php
					while (have_posts()):
						the_post();
						$client_industry = get_post_meta(get_the_ID(), '_case_study_client_industry', true);
						$metrics = get_post_meta(get_the_ID(), '_case_study_metrics', true);
						// Extract first metric line if available
						$first_metric = $metrics ? strtok($metrics, "\n") : '';
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class('case-study-row'); ?>>
							<div class="cs-content">
								<span class="cs-industry"><?php echo esc_html($client_industry); ?></span>
								<h2 class="cs-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<div class="cs-excerpt"><?php the_excerpt(); ?></div>
								<a href="<?php the_permalink(); ?>" class="btn-link">Read Case Study &rarr;</a>
							</div>
							<div class="cs-metric-highlight">
								<?php if ($first_metric): ?>
									<div class="metric-card">
										<span class="metric-value"><?php echo esc_html($first_metric); ?></span>
									</div>
								<?php endif; ?>
							</div>
						</article>
					<?php endwhile; ?>
				</div>

				<div class="pagination">
					<?php the_posts_pagination(); ?>
				</div>

			<?php else: ?>
				<p><?php esc_html_e('No case studies found.', 'aitsc-pro-theme'); ?></p>
			<?php endif; ?>
		</div>
	</section>

</main><!-- #primary -->

<style>
	/* Local Critical CSS for Case Studies Archive */
	.case-study-rows {
		display: flex;
		flex-direction: column;
		gap: var(--space-8);
	}

	.case-study-row {
		display: grid;
		grid-template-columns: 2fr 1fr;
		gap: var(--space-8);
		background-color: var(--wq-panel);
		border: 1px solid var(--wq-border);
		padding: var(--space-8);
		transition: border-color 0.3s ease;
	}

	.case-study-row:hover {
		border-color: var(--wq-orange);
	}

	.cs-industry {
		color: var(--wq-orange);
		text-transform: uppercase;
		font-size: var(--text-xs);
		letter-spacing: 0.1em;
		margin-bottom: var(--space-2);
		display: block;
	}

	.cs-title {
		font-size: var(--text-2xl);
		margin-bottom: var(--space-4);
	}

	.cs-title a {
		color: var(--wq-text-white);
	}

	.metric-card {
		display: flex;
		align-items: center;
		justify-content: center;
		height: 100%;
		background: rgba(255, 255, 255, 0.05);
		border-radius: var(--radius-md);
		padding: var(--space-4);
		text-align: center;
	}

	.metric-value {
		font-size: var(--text-xl);
		font-weight: 700;
		color: var(--wq-text-white);
	}

	@media (max-width: 47.9375rem) {
		.case-study-row {
			grid-template-columns: 1fr;
		}

		.metric-card {
			padding: var(--space-4) 0;
		}
	}
</style>

<?php
get_footer();