<?php
/**
 * The template for displaying archive pages for Solutions
 */

get_header();
?>

<main id="primary" class="site-main">

	<!-- Archive Header - Full Width -->
	<section class="archive-header full-width">
		<div class="container">
			<h1 class="wq-hero-title wq-hero-title--standard">
				<span class="title-accent">SOLUTIONS</span> PORTFOLIO
			</h1>
			<p class="archive-description">
				From embedded firmware to AI-powered fleet protection, we deliver end-to-end transport safety solutions.
			</p>
		</div>
	</section>

	<!-- Solution Categories Grid - Full Width -->
	<section class="solutions-archive-section full-width py-16" data-aos="fade-up" data-aos-duration="1000">
		<div class="container max-w-7xl mx-auto px-4">
			<?php
			// Get all solution categories (exclude Uncategorized)
			$categories = get_terms(array(
				'taxonomy' => 'solution_category',
				'hide_empty' => true,
				'parent' => 0, // Only top-level categories
				'exclude' => array(1), // Exclude Uncategorized (ID: 1)
			));

			if (!empty($categories) && !is_wp_error($categories)): ?>
				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
					<?php
					// Icon and description mapping
					$category_data = [
						'passenger-monitoring-systems' => [
							'icon' => 'event_seat',
							'description' => 'Real-time safety monitoring and compliance solutions for modern transport fleets'
						],
						'automotive-electronics' => [
							'icon' => 'electric_car',
							'description' => 'Custom electronic systems engineered for automotive applications and vehicle integration'
						],
						'pcb-embedded-engineering' => [
							'icon' => 'developer_board',
							'description' => 'From concept to certified production-ready circuit boards and embedded systems'
						]
					];

					foreach ($categories as $category):
						$cat_slug = $category->slug;
						$icon = $category_data[$cat_slug]['icon'] ?? 'engineering';
						$description = $category_data[$cat_slug]['description'] ?? ($category->description ?: 'Explore solutions in this category');

						// Render unified icon card
						aitsc_render_card([
							'variant' => 'icon',
							'title' => $category->name,
							'description' => esc_html($description),
							'link' => get_term_link($category, 'solution_category'),
							'icon' => $icon,
							'cta_text' => 'Explore Solutions',
							'size' => 'medium',
							'custom_class' => 'group transition-all duration-200 hover:scale-[1.02]'
						]);
					endforeach; ?>
				</div>

			<?php else: ?>
				<p class="text-slate-400 text-center">
					<?php esc_html_e('No solution categories found.', 'aitsc-pro-theme'); ?>
				</p>
			<?php endif; ?>
		</div>
	</section>

	<!-- Social Proof Section -->
	<section class="py-24 bg-slate-900/30 border-y border-blue-600/10">
		<div class="container max-w-7xl mx-auto px-4">
			<div class="text-center mb-16" data-aos="fade-up">
				<h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
					Trusted by Leading <span class="text-blue-400">Transport Operators</span>
				</h2>
				<p class="text-xl text-slate-400 max-w-2xl mx-auto">
					Join Bus4x4 and other industry leaders who rely on our engineering solutions
				</p>
			</div>

			<!-- Trust Indicators -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-8" data-aos="fade-up" data-aos-delay="200">
				<div class="text-center">
					<div class="w-20 h-20 bg-blue-600/20 rounded-full flex items-center justify-center mx-auto mb-4">
						<span class="material-symbols-outlined text-4xl text-blue-400">verified</span>
					</div>
					<h3 class="text-2xl font-bold text-white mb-2">100%</h3>
					<p class="text-slate-400">Client Satisfaction</p>
				</div>

				<div class="text-center">
					<div class="w-20 h-20 bg-blue-600/20 rounded-full flex items-center justify-center mx-auto mb-4">
						<span class="material-symbols-outlined text-4xl text-blue-400">business_center</span>
					</div>
					<h3 class="text-2xl font-bold text-white mb-2">50+</h3>
					<p class="text-slate-400">Active Fleets</p>
				</div>

				<div class="text-center">
					<div class="w-20 h-20 bg-blue-600/20 rounded-full flex items-center justify-center mx-auto mb-4">
						<span class="material-symbols-outlined text-4xl text-blue-400">support_agent</span>
					</div>
					<h3 class="text-2xl font-bold text-white mb-2">24/7</h3>
					<p class="text-slate-400">Technical Support</p>
				</div>
			</div>

			<!-- CTA -->
			<div class="text-center mt-16" data-aos="fade-up" data-aos-delay="400">
				<a href="<?php echo esc_url(home_url('/contact')); ?>"
					class="inline-flex items-center gap-2 px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors shadow-lg shadow-blue-600/30">
					Start Your Project
					<span class="material-symbols-outlined">arrow_forward</span>
				</a>
			</div>
		</div>
	</section>

</main><!-- #primary -->

	<style>
		/* Local Critical CSS for Solutions Archive */
		.page-header {
			padding-top: var(--space-32);
			padding-bottom: var(--space-12);
			background-color: var(--wq-black);
		}

		/* .page-title removed in favor of global .wq-hero-title */

		/* Icon Card Specific Styles to Ensure Visibility */
		.aitsc-card--icon {
			background-color: var(--wq-panel) !important;
			border: 1px solid var(--wq-border) !important;
		}

		.aitsc-card--icon .aitsc-card__title {
			color: var(--wq-text-white) !important;
			font-size: 1.5rem !important;
			text-align: center;
			margin-bottom: 0.5rem;
		}

		.aitsc-card--icon .aitsc-card__description {
			color: var(--wq-text-grey) !important;
			text-align: center;
		}

		.aitsc-card--icon .aitsc-card__cta {
			justify-content: center;
			margin-top: 1rem;
		}

		.solution-card-footer {
			margin-top: 1rem;
			padding-top: 1rem;
			border-top: 1px solid rgba(255, 255, 255, 0.1);
		}
	</style>

<?php
get_footer();