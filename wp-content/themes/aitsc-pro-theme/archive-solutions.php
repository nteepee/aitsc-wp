<?php
/**
 * The template for displaying archive pages for Solutions - White Theme Migration (Phase 5)
 */

get_header();
?>

<main id="primary" class="site-main">

	<!-- Archive Hero - White Theme -->
	<?php
	aitsc_render_hero([
		'variant' => 'page',
		'title' => '<span class="text-cyan-600">Solutions</span> Portfolio',
		'subtitle' => 'ENGINEERING EXCELLENCE ACROSS THE TRANSPORT SAFETY STACK',
		'description' => 'From embedded firmware to AI-powered fleet protection, we deliver end-to-end transport safety solutions.',
		'height' => 'medium'
	]);
	?>

	<!-- Trust Bar -->
	<?php
	aitsc_render_trust_bar([
		'text' => 'Deployed in over 50 active fleets across Australia',
		'tag' => 'p'
	]);
	?>

	<!-- Solution Categories Grid - White Feature Cards -->
	<section class="py-24 bg-white">
		<div class="container">
			<?php
			// Get all solution categories (exclude Uncategorized)
			$categories = get_terms(array(
				'taxonomy' => 'solution_category',
				'hide_empty' => true,
				'parent' => 0, // Only top-level categories
				'exclude' => array(1), // Exclude Uncategorized (ID: 1)
			));

			if (!empty($categories) && !is_wp_error($categories)): ?>
				<div class="aitsc-grid aitsc-grid--3-col">
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
						// Render white feature card
						aitsc_render_card([
							'variant' => 'white-feature',
							'title' => $category->name,
							'description' => esc_html($description),
							'link' => get_term_link($category, 'solution_category'),
							'icon' => $icon,
							'cta_text' => 'Explore Solutions',
							'size' => 'large',
							'custom_class' => 'h-100'
						]);
					endforeach; ?>
				</div>

			<?php else: ?>
				<p class="text-center text-slate-600">
					<?php esc_html_e('No solution categories found.', 'aitsc-pro-theme'); ?>
				</p>
			<?php endif; ?>
		</div>
	</section>

	<!-- Social Proof Section - White Theme -->
	<section class="py-24 bg-slate-50">
		<div class="container">
			<div class="text-center mb-16">
				<h2 class="text-4xl md:text-5xl font-light text-slate-900 mb-4">
					Trusted by Leading <span class="text-cyan-600">Transport Operators</span>
				</h2>
				<p class="text-xl text-slate-600 max-w-2xl mx-auto">
					Join Bus4x4 and other industry leaders who rely on our engineering solutions
				</p>
			</div>

			<!-- Stats Counter Component -->
			<?php
			aitsc_render_stats([
				[
					'value' => '100%',
					'label' => 'Client Satisfaction',
					'icon' => 'verified',
					'highlight' => true
				],
				[
					'value' => '50+',
					'label' => 'Active Fleets',
					'icon' => 'business_center',
					'highlight' => true
				],
				[
					'value' => '24/7',
					'label' => 'Technical Support',
					'icon' => 'support_agent',
					'highlight' => true
				]
			]);
			?>

			<!-- CTA -->
			<div class="text-center mt-16">
				<a href="<?php echo esc_url(home_url('/contact')); ?>"
					class="inline-flex items-center gap-2 px-8 py-4 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold rounded-lg transition-colors shadow-lg">
					Start Your Project
					<span class="material-symbols-outlined">arrow_forward</span>
				</a>
			</div>
		</div>
	</section>

</main><!-- #primary -->

<?php
get_footer();
