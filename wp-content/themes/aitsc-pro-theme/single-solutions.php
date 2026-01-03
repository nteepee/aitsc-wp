<?php
/**
 * The template for displaying all single solutions - White Theme Migration (Phase 5)
 *
 * ACF-powered dynamic solution landing pages with white theme universal components.
 * Uses ACF data for dynamic content rendering.
 *
 * @package AITSC_Pro_Theme
 * @since 4.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$solution_id = get_the_ID();
$slug = get_post_field('post_name', $solution_id);

// Custom Routing for Pillar Pages (e.g. Fleet Safe Pro)
// Route BEFORE calling get_header() to prevent duplication
if ($slug === 'fleet-safe-pro') {
    $template_path = locate_template('page-fleet-safe-pro.php');
    if ($template_path) {
        include($template_path);
    }
    // Stop execution - pillar template handles header/footer
    exit;
}

get_header();
?>

<main id="primary" class="site-main solution-page bg-white">

	<?php
	while (have_posts()):
		the_post();

		// Determine hero variant based on category
		$terms = get_the_terms($solution_id, 'solution_category');
		$use_worldquant_hero = false;
		if ($terms && !is_wp_error($terms)) {
			foreach ($terms as $term) {
				if ($term->slug === 'passenger-monitoring-systems') {
					$use_worldquant_hero = true;
					break;
				}
			}
		}

		// Hero Section - Dynamic based on category
		if ($use_worldquant_hero && function_exists('aitsc_render_hero_solution')) {
			// WorldQuant-style hero for passenger monitoring systems
			aitsc_render_hero_solution([
				'variant' => 'solution-page',
				'show_ticker' => false, // Enable ticker if ACF data exists
				'animation' => true,
				'post_id' => $solution_id
			]);
		} else {
			// White Fullwidth Hero for other solutions
			$hero = get_field('hero_section', $solution_id);
			if ($hero) {
				aitsc_render_hero([
					'variant' => 'white-fullwidth',
					'title' => $hero['title'] ?? get_the_title($solution_id),
					'subtitle' => $hero['subtitle'] ?? '',
					'description' => $hero['description'] ?? '',
					'cta_primary' => $hero['cta_text'] ?? 'Learn More',
					'cta_primary_link' => $hero['cta_link'] ?? get_permalink($solution_id),
					'cta_secondary' => $hero['cta_secondary_text'] ?? 'Contact Sales',
					'cta_secondary_link' => $hero['cta_secondary_link'] ?? home_url('/contact'),
					'image' => $hero['image'] ?? '',
					'height' => 'large'
				]);
			} else {
				// Fallback hero
				aitsc_render_hero([
					'variant' => 'white-fullwidth',
					'title' => get_the_title($solution_id),
					'subtitle' => 'TRANSPORT SAFETY SOLUTIONS',
					'description' => get_the_excerpt($solution_id),
					'height' => 'large'
				]);
			}
		}

		// Trust Bar
		aitsc_render_trust_bar([
			'text' => 'Trusted by over 50 active transport fleets across Australia',
			'tag' => 'p'
		]);

		// Overview Section
		get_template_part('template-parts/solution/overview');

		// Key Features Grid - White Feature Cards
		$features = get_field('features', $solution_id);
		if ($features && is_array($features)): ?>
			<section id="features" class="solution-features py-24 bg-slate-50">
				<div class="container">
					<div class="text-center mb-16">
						<h2 class="text-4xl md:text-5xl font-light text-slate-900 mb-4">Key Features</h2>
						<p class="text-lg text-cyan-600 uppercase tracking-wider">What Makes This Solution Stand Out</p>
					</div>
					<div class="aitsc-grid aitsc-grid--3-col">
						<?php foreach ($features as $feature): ?>
							<div>
								<?php
								aitsc_render_card([
									'variant' => 'white-feature',
									'title' => $feature['feature_title'] ?? '',
									'description' => $feature['feature_description'] ?? '',
									'icon' => $feature['feature_icon'] ?? 'star',
									'custom_class' => 'h-100'
								]);
								?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</section>
		<?php else:
			get_template_part('template-parts/solution/features');
		endif;

		// Flexible Content Sections (Text+Image, 3-Column, Video)
		get_template_part('template-parts/solution/sections');

		// Technical Specifications
		get_template_part('template-parts/solution/specs');

		// Product Gallery
		get_template_part('template-parts/solution/gallery');

		// Complete Technology Solutions
		// get_template_part('template-parts/solution/tech-solutions');
	
		// Science of Safety
		get_template_part('template-parts/solution/science');

		// Latest Perspectives (Blog)
		get_template_part('template-parts/solution/blog-insights');

		// Trusted Ecosystem
		get_template_part('template-parts/solution/ecosystem');

		// Call-to-Action Section - White Theme CTA
		$cta = get_field('cta', $solution_id);
		if ($cta && is_array($cta)) {
			aitsc_render_cta([
				'variant' => 'fullwidth',
				'title' => $cta['cta_section_title'] ?? 'Ready to Get Started?',
				'description' => $cta['cta_section_description'] ?? 'Contact our engineering team to discuss how this solution can transform your fleet operations.',
				'button_text' => $cta['cta_button_text'] ?? 'Request a Quote',
				'button_link' => $cta['cta_button_link'] ?? home_url('/contact'),
				'button_secondary_text' => 'Learn More',
				'button_secondary_link' => home_url('/solutions')
			]);
		} else {
			// Fallback CTA
			aitsc_render_cta([
				'variant' => 'fullwidth',
				'title' => 'Ready to Transform Your Fleet Safety?',
				'description' => 'Contact our engineering team to discuss how this solution can meet your unique requirements.',
				'button_text' => 'Request a Quote',
				'button_link' => home_url('/contact'),
				'button_secondary_text' => 'View All Solutions',
				'button_secondary_link' => home_url('/solutions')
			]);
		}

	endwhile; // End of the loop.

	// Related Pages Navigation - Cross-page links based on solution ID
	get_template_part('template-parts/solution/related-pages');
	?>

</main><!-- #primary -->

<?php
get_footer();
