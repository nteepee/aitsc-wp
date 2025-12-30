<?php
/**
 * The template for displaying archive pages for Case Studies - White Theme Migration (Phase 5)
 */

get_header();
?>

<main id="primary" class="site-main bg-white">

	<!-- Archive Hero - White Theme -->
	<?php
	aitsc_render_hero([
		'variant' => 'page',
		'title' => 'Success <span class="text-cyan-600">Stories</span>',
		'subtitle' => 'PROVEN RESULTS IN TRANSPORT SAFETY',
		'description' => 'Discover how our engineering solutions are transforming fleet operations across the Australian transport logistics sector.',
		'height' => 'medium'
	]);
	?>

	<!-- Trust Bar -->
	<?php
	aitsc_render_trust_bar([
		'text' => 'Delivering measurable safety improvements across Bus4x4 and leading transport operators',
		'tag' => 'p'
	]);
	?>

	<!-- Case Studies Grid - White Product Cards -->
	<section class="py-24 bg-white">
		<div class="container">
			<?php if (have_posts()): ?>
				<div class="row g-4">
					<?php
					while (have_posts()):
						the_post();
						$client = get_post_meta(get_the_ID(), '_case_study_client', true);
						$client_industry = get_post_meta(get_the_ID(), '_case_study_client_industry', true);
						$thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'medium');
						?>
						<div class="col-lg-4 col-md-6 mb-4">
							<?php
							aitsc_render_card([
								'variant' => 'white-product',
								'title' => get_the_title(),
								'description' => get_the_excerpt(),
								'link' => get_permalink(),
								'image' => $thumbnail ?: get_template_directory_uri() . '/assets/images/placeholder-case-study.jpg',
								'cta_text' => 'Read Case Study',
								'custom_class' => 'h-100',
								'meta' => [
									'client' => $client,
									'industry' => $client_industry
								]
							]);
							?>
						</div>
					<?php endwhile; ?>
				</div>

				<div class="pagination mt-12">
					<?php the_posts_pagination([
						'prev_text' => '← Previous',
						'next_text' => 'Next →',
						'class' => 'flex justify-center gap-2'
					]); ?>
				</div>

			<?php else: ?>
				<div class="text-center py-16">
					<p class="text-slate-600 text-lg"><?php esc_html_e('No case studies found.', 'aitsc-pro-theme'); ?></p>
					<a href="<?php echo esc_url(home_url('/solutions')); ?>" class="inline-flex items-center gap-2 mt-6 text-cyan-600 hover:text-cyan-700 font-semibold">
						<span>Explore Our Solutions</span>
						<span class="material-symbols-outlined">arrow_forward</span>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</section>

</main><!-- #primary -->

<?php
get_footer();