<?php
/**
 * The template for displaying single Case Studies - White Theme Migration (Phase 5)
 */

get_header();
?>

<main id="primary" class="site-main bg-white">

	<?php while (have_posts()):
		the_post();
		$client = get_post_meta(get_the_ID(), '_case_study_client', true);
		$client_industry = get_post_meta(get_the_ID(), '_case_study_client_industry', true);
		$challenge = get_post_meta(get_the_ID(), '_case_study_challenge', true);
		$results = get_post_meta(get_the_ID(), '_case_study_results', true);
		?>

		<!-- Case Study Hero - White Theme -->
		<?php
		aitsc_render_hero([
			'variant' => 'page',
			'title' => get_the_title(),
			'subtitle' => 'CLIENT: ' . strtoupper($client),
			'description' => get_the_excerpt(),
			'height' => 'medium'
		]);
		?>

		<!-- Trust Bar -->
		<?php
		aitsc_render_trust_bar([
			'text' => 'A proven success story in ' . ($client_industry ?: 'transport safety engineering'),
			'tag' => 'p'
		]);
		?>

		<!-- Main Content Grid - White Theme -->
		<section class="py-24 bg-white">
			<div class="container">
				<div class="row g-5">

					<!-- Left Column: Story -->
					<div class="col-lg-8">
						<div class="mb-12">
							<h3 class="text-3xl font-light text-slate-900 mb-6 pb-4 border-b-2 border-cyan-600">The Challenge</h3>
							<div class="text-lg text-slate-700 leading-relaxed">
								<?php echo wpautop(esc_html($challenge)); ?>
							</div>
						</div>

						<div class="mb-12">
							<h3 class="text-3xl font-light text-slate-900 mb-6 pb-4 border-b-2 border-slate-200">The Solution</h3>
							<div class="entry-content text-lg text-slate-700 leading-relaxed">
								<?php the_content(); ?>
							</div>
						</div>

						<div class="mb-12">
							<h3 class="text-3xl font-light text-cyan-600 mb-6 pb-4 border-b-2 border-cyan-600">The Results</h3>
							<div class="text-lg text-slate-700 leading-relaxed">
								<?php echo wpautop(esc_html($results)); ?>
							</div>
						</div>
					</div>

					<!-- Right Column: Stats & Meta -->
					<aside class="col-lg-4">
						<div class="sticky-top" style="top: 100px;">
							<!-- Project Specs Card -->
							<?php
							aitsc_render_card([
								'variant' => 'white-minimal',
								'title' => 'Project Specs',
								'description' => sprintf(
									'<ul class="list-none p-0 space-y-3">
										<li class="flex justify-between pb-2 border-b border-slate-200">
											<span class="text-slate-600">Industry</span>
											<strong class="text-slate-900">%s</strong>
										</li>
										<li class="flex justify-between pb-2 border-b border-slate-200">
											<span class="text-slate-600">Duration</span>
											<strong class="text-slate-900">%s</strong>
										</li>
										<li class="flex justify-between pb-2 border-b border-slate-200">
											<span class="text-slate-600">Team Size</span>
											<strong class="text-slate-900">%s</strong>
										</li>
									</ul>',
									esc_html($client_industry ?: 'N/A'),
									esc_html(get_post_meta(get_the_ID(), '_case_study_duration', true) ?: 'N/A'),
									esc_html(get_post_meta(get_the_ID(), '_case_study_team_size', true) ?: 'N/A')
								),
								'custom_class' => 'mb-4'
							]);
							?>

							<!-- Key Metrics Card -->
							<?php if ($metrics = get_post_meta(get_the_ID(), '_case_study_metrics', true)): ?>
								<?php
								$metric_lines = array_filter(array_map('trim', explode("\n", $metrics)));
								$metrics_html = '<ul class="list-none p-0 space-y-3">';
								foreach ($metric_lines as $metric) {
									$metrics_html .= sprintf('<li class="text-xl font-bold text-cyan-600">%s</li>', esc_html($metric));
								}
								$metrics_html .= '</ul>';

								aitsc_render_card([
									'variant' => 'white-minimal',
									'title' => 'Key Metrics',
									'description' => $metrics_html,
									'custom_class' => 'border-2 border-cyan-600'
								]);
								?>
							<?php endif; ?>
						</div>
					</aside>

				</div>
			</div>
		</section>

	<?php endwhile; ?>

</main><!-- #primary -->

<?php
get_footer();