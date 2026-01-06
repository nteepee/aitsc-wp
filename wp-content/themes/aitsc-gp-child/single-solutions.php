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

<main id="primary" class="site-main solution-page">

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

		// Paper Stack Wrapper - Start
		// Universal section-by-section scroll animations
		$paper_stack_settings = aitsc_get_paper_stack_settings();
		if ($paper_stack_settings['enabled']) {
			aitsc_paper_stack([
				'enabled' => true,
				'variant' => $paper_stack_settings['variant'],
				'distance' => get_theme_mod('aitsc_paper_stack_distance', 100) . 'px',
				'duration' => get_theme_mod('aitsc_paper_stack_duration', 0.6) . 's',
				'easing' => get_theme_mod('aitsc_paper_stack_easing', 'ease-out'),
			]);
		}
		?>

		<?php
		// Overview Section
		get_template_part('template-parts/solution/overview');

		// Key Features Grid - Icon Cards (Fleet Safe Pro style)
		$features = get_field('features', $solution_id);
		if ($features && is_array($features)): ?>
			<section class="aitsc-section aitsc-section--features">
				<div class="aitsc-container">
					<div class="aitsc-section__header">
						<h2 class="aitsc-section__title">Key Features</h2>
						<p class="aitsc-section__subtitle">Comprehensive safety monitoring with intelligent automation</p>
					</div>

					<div class="aitsc-grid aitsc-grid--3-col">
						<?php
						foreach ($features as $feature) {
							aitsc_render_card(array(
								'variant' => 'icon',
								'title' => $feature['title'] ?? '',
								'description' => $feature['description'] ?? '',
								'icon' => $feature['icon'] ?? 'star',
								'size' => 'medium'
							));
						}
						?>
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
		// Get ACF gallery images
		$gallery_images = array();
		$acf_gallery = get_field('gallery', $solution_id);

		if ($acf_gallery && is_array($acf_gallery)) {
			foreach ($acf_gallery as $attachment) {
				// Handle both ID format and array format
				if (is_numeric($attachment)) {
					$url = wp_get_attachment_url($attachment);
				} else {
					$url = $attachment['url'] ?? '';
				}

				if ($url) {
					$gallery_images[] = $url;
				}
			}
		}

		// Render gallery using fleet-safe-pro structure with dark section wrapper
		if (!empty($gallery_images) && function_exists('aitsc_render_gallery')):
			?>
			<section class="aitsc-section aitsc-section--gallery">
				<?php
				aitsc_render_gallery(array(
					'title' => 'Product Gallery',
					'subtitle' => 'Close-up views of system components and installation examples',
					'images' => $gallery_images
				));
				?>
			</section>
			<?php
		endif;

		// Complete Technology Solutions
		// get_template_part('template-parts/solution/tech-solutions');

		// Science of Safety
		get_template_part('template-parts/solution/science');

		// Trusted Ecosystem
		get_template_part('template-parts/solution/ecosystem');

		// Installation Guide - Steps + Tabs
		$install_steps = get_field('installation_steps', $solution_id);
		if ($install_steps && is_array($install_steps) && function_exists('aitsc_render_steps')):
			?>
			<section class="aitsc-section aitsc-section--installation">
				<div class="aitsc-container">
					<div class="aitsc-section__header">
						<h2 class="aitsc-section__title">Installation Guide</h2>
						<p class="aitsc-section__subtitle">Quick setup with detailed procedures</p>
					</div>
					<?php
					aitsc_render_steps(array(
						'title' => 'Quick Installation Steps',
						'subtitle' => 'Scroll through each step',
						'variant' => 'slider',
						'steps' => $install_steps
					));
					?>
				</div>
			</section>
			<?php
		endif;

		// Detailed Installation Tabs
		$install_tabs = get_field('installation_tabs', $solution_id);
		if ($install_tabs && is_array($install_tabs) && function_exists('aitsc_render_tabs')):
			?>
			<div class="aitsc-install-tabs">
				<?php
				aitsc_render_tabs(array(
					'title' => 'Detailed Installation Procedures',
					'id' => 'install-guide-tabs',
					'tabs' => $install_tabs
				));
				?>
			</div>
			<?php
		endif;

		// Compliance & Warranty Section
		?>
		<section class="aitsc-section aitsc-section--compliance">
			<div class="aitsc-container">
				<div class="aitsc-section__header">
					<h2 class="aitsc-section__title">Compliance & Warranty</h2>
					<p class="aitsc-section__subtitle">Peace of mind with comprehensive coverage</p>
				</div>

				<div class="aitsc-grid aitsc-grid--2-col">
					<?php
					aitsc_render_card(array(
						'variant' => 'white-feature',
						'title' => '12-Month Warranty',
						'description' => 'All components covered with 12-month warranty from purchase date. Return-to-base parts replacement with customer-paid shipping.',
						'icon' => 'verified_user',
						'custom_class' => 'h-100',
						'specs' => array(
							'Comprehensive component coverage',
							'Return-to-base replacement service',
							'Serial number verification required',
							'RMA (Return Merchandise Authorization) mandatory'
						)
					));

					aitsc_render_card(array(
						'variant' => 'white-feature',
						'title' => 'Australian Consumer Law',
						'description' => 'Our goods come with guarantees that cannot be excluded under the Australian Consumer Law (ACL). You are entitled to a replacement or refund for major failures.',
						'icon' => 'gavel',
						'custom_class' => 'h-100',
						'specs' => array(
							'ACL consumer guarantees apply',
							'Replacement for major failures',
							'Refund for significant non-compliance',
							'Limited to purchase price liability'
						)
					));

					aitsc_render_card(array(
						'variant' => 'white-feature',
						'title' => 'Claims Process',
						'description' => 'Contact <a href="mailto:support@aitsc.au">support@aitsc.au</a> with proof of purchase and serial number. RMA required before returning any components.',
						'icon' => 'support_agent',
						'custom_class' => 'h-100',
						'specs' => array(
							'Proof of purchase required',
							'Serial number verification',
							'DOA: Report within 14 days',
							'Customer pays return shipping'
						)
					));

					aitsc_render_card(array(
						'variant' => 'white-feature',
						'title' => 'Installation Requirements',
						'description' => 'Ensure installation by competent personnel in accordance with AITSC documentation and applicable vehicle/OEM guidance.',
						'icon' => 'engineering',
						'custom_class' => 'h-100',
						'specs' => array(
							'Professional installation required',
							'Follow AITSC documentation',
							'No hardware/software modification',
							'No non-approved parts'
						)
					));
					?>
				</div>
			</div>
		</section>

		<?php
		// Contact Form Section (from Fleet Safe Pro)
		?>
		<section id="contact" class="aitsc-section aitsc-section--cta">
			<div class="aitsc-container">
				<div class="aitsc-demo-cta">
					<div class="aitsc-demo-cta__content">
						<h2 class="aitsc-section__title">Request a Demo</h2>
						<p class="aitsc-demo-cta__description">See our solution in action. Contact our team for a personalized
							demonstration of how this can enhance your fleet safety.</p>

						<div class="aitsc-demo-cta__features">
							<div class="aitsc-demo-feature">
								<span class="material-symbols-outlined">videocam</span>
								<span>Live Product Demo</span>
							</div>
							<div class="aitsc-demo-feature">
								<span class="material-symbols-outlined">support_agent</span>
								<span>Expert Consultation</span>
							</div>
							<div class="aitsc-demo-feature">
								<span class="material-symbols-outlined">calculate</span>
								<span>Custom Quote</span>
							</div>
						</div>
					</div>

					<div class="aitsc-demo-cta__form">
						<form class="aitsc-contact-form" action="#" method="post">
							<div class="aitsc-form-row aitsc-form-row--2col">
								<div class="aitsc-form-group">
									<label for="demo-name">Full Name *</label>
									<input type="text" id="demo-name" name="name" placeholder="John Smith" required>
								</div>
								<div class="aitsc-form-group">
									<label for="demo-email">Email Address *</label>
									<input type="email" id="demo-email" name="email" placeholder="john@company.com" required>
								</div>
							</div>
							<div class="aitsc-form-row aitsc-form-row--2col">
								<div class="aitsc-form-group">
									<label for="demo-company">Company Name</label>
									<input type="text" id="demo-company" name="company" placeholder="Your Company">
								</div>
								<div class="aitsc-form-group">
									<label for="demo-phone">Phone Number</label>
									<input type="tel" id="demo-phone" name="phone" placeholder="+61 400 000 000">
								</div>
							</div>
							<div class="aitsc-form-group">
								<label for="demo-fleet">Fleet Size</label>
								<select id="demo-fleet" name="fleet_size">
									<option value="">Select fleet size</option>
									<option value="1-10">1-10 vehicles</option>
									<option value="11-50">11-50 vehicles</option>
									<option value="51-100">51-100 vehicles</option>
									<option value="100+">100+ vehicles</option>
								</select>
							</div>
							<div class="aitsc-form-group">
								<label for="demo-message">Message</label>
								<textarea id="demo-message" name="message" rows="4"
									placeholder="Tell us about your requirements..."></textarea>
							</div>
							<button type="submit" class="aitsc-form-submit">
								<span>Request Demo</span>
								<span class="material-symbols-outlined">send</span>
							</button>
							<p class="aitsc-form-note">
								<span class="material-symbols-outlined">info</span>
								We'll respond within 24 business hours.
							</p>
						</form>
					</div>
				</div>
			</div>
		</section>

		<?php
		// Footer Contact Info
		?>
		<section class="aitsc-section aitsc-section--contact">
			<div class="aitsc-container">
				<div class="aitsc-contact-box">
					<h3>About AITSC</h3>
					<p>We solve your most expensive technology problems without spending more. AITSC is passionate about new
						technology and how to leverage it to make companies more efficient.</p>
					<p><strong>Our Mission:</strong> Solve the most critical technology gaps in multi-million-dollar industries
						and make a lasting difference for technology in Australia.</p>

					<div class="aitsc-contact-links">
						<div class="aitsc-contact-item">
							<span class="material-symbols-outlined">language</span>
							<a href="https://www.aitsc.au" target="_blank" rel="noopener">www.aitsc.au</a>
						</div>
						<div class="aitsc-contact-item">
							<span class="material-symbols-outlined">email</span>
							<a href="mailto:support@aitsc.au">support@aitsc.au</a>
						</div>
						<div class="aitsc-contact-item">
							<span class="material-symbols-outlined">email</span>
							<a href="mailto:contact@aitsc.au">contact@aitsc.au</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php

		// Paper Stack Wrapper - End
		if ($paper_stack_settings['enabled']) {
			aitsc_paper_stack_end();
		}
		?>

		<?php
	endwhile; // End of the loop.
	?>

</main><!-- #primary -->

<?php
get_footer();
