<?php
/**
 * The template for displaying all single solutions
 *
 * ACF-powered dynamic solution landing pages with universal components.
 * Uses ACF data for dynamic content rendering.
 *
 * @package AITSC_Pro_Theme
 * @since 3.1.0
 */

// Load universal components
require_once get_template_directory() . '/components/hero/hero-universal.php';
require_once get_template_directory() . '/components/card/card-base.php';
require_once get_template_directory() . '/components/cta/cta-block.php';

get_header();

$solution_id = get_the_ID();
?>

<main id="primary" class="site-main solution-page">

	<?php
	while (have_posts()):
		the_post();

		// Hero Section - ACF-driven using universal component
		$hero = get_field('hero_section', $solution_id);
		if ($hero) {
			aitsc_render_hero([
				'variant' => 'pillar',
				'title' => $hero['title'] ?? get_the_title($solution_id),
				'subtitle' => $hero['subtitle'] ?? '',
				'description' => $hero['description'] ?? '',
				'cta_primary' => $hero['cta_text'] ?? 'Learn More',
				'cta_primary_link' => $hero['cta_link'] ?? get_permalink($solution_id),
				'cta_secondary' => $hero['cta_secondary_text'] ?? '',
				'cta_secondary_link' => $hero['cta_secondary_link'] ?? '',
				'image' => $hero['image'] ?? '',
				'height' => 'large'
			]);
		} else {
			// Fallback to original hero if no ACF data
			get_template_part('template-parts/solution/hero-fleet');
		}

		// Overview Section
		get_template_part('template-parts/solution/overview');

		// Key Features Grid - ACF-driven using universal card component
		$features = get_field('features', $solution_id);
		if ($features && is_array($features)): ?>
			<section id="features" class="solution-features py-20 md:py-28">
				<div class="container max-w-7xl mx-auto px-6">
					<div class="text-center mb-16">
						<h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Key Features</h2>
					</div>
					<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
						<?php foreach ($features as $feature):
							aitsc_render_card('solution', [
								'title' => $feature['feature_title'] ?? '',
								'description' => $feature['feature_description'] ?? '',
								'icon' => $feature['feature_icon'] ?? 'star',
								'link' => '',
								'cta_text' => ''
							]);
						endforeach; ?>
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

		// Call-to-Action Section - ACF-driven using universal CTA component
		$cta = get_field('cta', $solution_id);
		if ($cta && is_array($cta)) {
			aitsc_render_cta([
				'variant' => 'banner',
				'title' => $cta['cta_section_title'] ?? 'Ready to Get Started?',
				'description' => $cta['cta_section_description'] ?? '',
				'button_text' => $cta['cta_button_text'] ?? 'Contact Us',
				'button_link' => $cta['cta_button_link'] ?? '/contact/',
				'background' => '',
				'text_color' => ''
			]);
		} else {
			// Fallback to original CTA if no ACF data
			get_template_part('template-parts/solution/cta');
		}

	endwhile; // End of the loop.

	// Related Pages Navigation - Cross-page links based on solution ID
	get_template_part('template-parts/solution/related-pages');
	?>

</main><!-- #primary -->

<?php
get_footer();
