<?php
/**
 * The template for displaying single Case Studies
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php while (have_posts()):
		the_post();
		$client = get_post_meta(get_the_ID(), '_case_study_client', true);
		$challenge = get_post_meta(get_the_ID(), '_case_study_challenge', true);
		$results = get_post_meta(get_the_ID(), '_case_study_results', true);
		?>

		<!-- Case Study Hero -->
		<section class="cs-hero section">
			<div class="container">
				<div class="cs-hero-content">
					<span class="cs-client-label">Client: <?php echo esc_html($client); ?></span>
					<h1 class="cs-page-title"><?php the_title(); ?></h1>
				</div>
			</div>
		</section>

		<!-- Main Content Grid -->
		<section class="cs-body section">
			<div class="container">
				<div class="cs-grid">

					<!-- Left Column: Story -->
					<div class="cs-story">
						<div class="cs-block">
							<h3 class="cs-heading">The Challenge</h3>
							<div class="cs-text">
								<?php echo wpautop(esc_html($challenge)); ?>
							</div>
						</div>

						<div class="cs-block">
							<h3 class="cs-heading">The Solution</h3>
							<div class="entry-content">
								<?php the_content(); ?>
							</div>
						</div>

						<div class="cs-block">
							<h3 class="cs-heading text-orange">The Results</h3>
							<div class="cs-text">
								<?php echo wpautop(esc_html($results)); ?>
							</div>
						</div>
					</div>

					<!-- Right Column: Stats & Meta -->
					<aside class="cs-meta-sidebar">
						<div class="cs-meta-box">
							<h4>Project Specs</h4>
							<ul class="meta-list">
								<li>
									<span>Industry</span>
									<strong><?php echo esc_html(get_post_meta(get_the_ID(), '_case_study_client_industry', true)); ?></strong>
								</li>
								<li>
									<span>Duration</span>
									<strong><?php echo esc_html(get_post_meta(get_the_ID(), '_case_study_duration', true)); ?></strong>
								</li>
								<li>
									<span>Team Size</span>
									<strong><?php echo esc_html(get_post_meta(get_the_ID(), '_case_study_team_size', true)); ?></strong>
								</li>
							</ul>
						</div>

						<?php if ($metrics = get_post_meta(get_the_ID(), '_case_study_metrics', true)): ?>
							<div class="cs-meta-box highlight-box">
								<h4>Key Metrics</h4>
								<ul class="metric-list">
									<?php
									$metric_lines = explode("\n", $metrics);
									foreach ($metric_lines as $metric) {
										if (trim($metric)) {
											echo '<li>' . esc_html($metric) . '</li>';
										}
									}
									?>
								</ul>
							</div>
						<?php endif; ?>
					</aside>

				</div>
			</div>
		</section>

	<?php endwhile; ?>

</main><!-- #primary -->

<style>
	/* Local Critical CSS for Single Case Study */
	.cs-hero {
		background-color: var(--wq-panel);
		border-bottom: 1px solid var(--wq-border);
		padding-top: var(--space-32);
		padding-bottom: var(--space-12);
	}

	.cs-client-label {
		display: block;
		color: var(--wq-orange);
		text-transform: uppercase;
		margin-bottom: var(--space-4);
		font-weight: 600;
	}

	.cs-page-title {
		font-size: var(--text-4xl);
	}

	.cs-grid {
		display: grid;
		grid-template-columns: 2fr 1fr;
		gap: var(--space-16);
	}

	.cs-heading {
		font-size: var(--text-2xl);
		margin-bottom: var(--space-6);
		border-bottom: 1px solid var(--wq-border);
		padding-bottom: var(--space-4);
		display: inline-block;
	}

	.cs-block {
		margin-bottom: var(--space-16);
	}

	.cs-meta-sidebar {
		position: sticky;
		top: 100px;
		height: fit-content;
	}

	.cs-meta-box {
		background: var(--wq-panel);
		border: 1px solid var(--wq-border);
		padding: var(--space-6);
		margin-bottom: var(--space-8);
	}

	.cs-meta-box h4 {
		font-size: var(--text-lg);
		margin-bottom: var(--space-4);
		color: var(--wq-text-white);
	}

	.meta-list,
	.metric-list {
		list-style: none;
		padding: 0;
	}

	.meta-list li {
		display: flex;
		justify-content: space-between;
		margin-bottom: var(--space-4);
		border-bottom: 1px solid rgba(255, 255, 255, 0.05);
		padding-bottom: var(--space-2);
	}

	.meta-list span {
		color: var(--wq-text-grey);
	}

	.highlight-box {
		border-color: var(--wq-orange);
	}

	.metric-list li {
		font-size: var(--text-xl);
		color: var(--wq-text-white);
		font-weight: 700;
		margin-bottom: var(--space-4);
	}

	@media (max-width: 61.9375rem) {
		.cs-grid {
			grid-template-columns: 1fr;
		}
	}
</style>

<?php
get_footer();