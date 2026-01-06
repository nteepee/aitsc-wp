<?php
/**
 * Single Solution Template
 *
 * Template part for displaying individual solution posts with industry filtering
 * and enhanced meta information display.
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Get solution meta data
$solution_id = get_the_ID();
$industry_focus = get_post_meta( $solution_id, '_solution_industry_focus', true ) ?: array();
$service_type = get_post_meta( $solution_id, '_solution_service_type', true );
$technologies = get_post_meta( $solution_id, '_solution_technologies', true );
$complexity = get_post_meta( $solution_id, '_solution_complexity', true );
$key_features = get_post_meta( $solution_id, '_solution_key_features', true );
$outcomes = get_post_meta( $solution_id, '_solution_outcomes', true );
$certification = get_post_meta( $solution_id, '_solution_certification', true );

// Get related solutions by industry focus
$related_solutions = array();
if ( ! empty( $industry_focus ) ) {
	$related_args = array(
		'post_type' => 'solutions',
		'post_status' => 'publish',
		'posts_per_page' => 4,
		'post__not_in' => array( $solution_id ),
		'meta_query' => array(
			array(
				'key' => '_solution_industry_focus',
				'value' => $industry_focus,
				'compare' => 'LIKE'
			)
		)
	);
	$related_solutions = get_posts( $related_args );
}
?>

<article id="solution-<?php the_ID(); ?>" <?php post_class( 'aitsc-solution-single' ); ?>>
	<header class="solution-header">
		<div class="solution-hero">
			<div class="solution-hero-content">
				<div class="solution-categories">
					<?php
					$categories = get_the_terms( $solution_id, 'solution_category' );
					if ( $categories && ! is_wp_error( $categories ) ) :
						foreach ( $categories as $category ) :
							$category_link = get_term_link( $category );
							echo '<a href="' . esc_url( $category_link ) . '" class="solution-category-link">';
							echo esc_html( $category->name );
							echo '</a>';
						endforeach;
					endif;
					?>
				</div>

				<h1 class="solution-title"><?php the_title(); ?></h1>

				<div class="solution-meta-info">
					<?php if ( $service_type ) : ?>
						<div class="solution-service-type">
							<span class="meta-label"><?php esc_html_e( 'Service Type:', 'aitsc-pro-theme' ); ?></span>
							<span class="meta-value"><?php echo esc_html( $service_type ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( $complexity ) : ?>
						<div class="solution-complexity">
							<span class="meta-label"><?php esc_html_e( 'Complexity:', 'aitsc-pro-theme' ); ?></span>
							<span class="meta-value complexity-<?php echo esc_attr( $complexity ); ?>">
								<?php
								$complexity_labels = array(
									'standard' => __( 'Standard (1-3 months)', 'aitsc-pro-theme' ),
									'complex' => __( 'Complex (3-6 months)', 'aitsc-pro-theme' ),
									'enterprise' => __( 'Enterprise (6+ months)', 'aitsc-pro-theme' )
								);
								echo esc_html( $complexity_labels[$complexity] ?? $complexity );
								?>
							</span>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="solution-hero-image">
						<?php the_post_thumbnail( 'full', array( 'class' => 'solution-featured-image' ) ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<!-- Industry Filter Tags -->
		<?php if ( ! empty( $industry_focus ) ) : ?>
			<div class="solution-industry-focus">
				<h3><?php esc_html_e( 'Industry Focus', 'aitsc-pro-theme' ); ?></h3>
				<div class="industry-tags">
					<?php
					$industry_labels = array(
						'automotive' => __( 'Automotive', 'aitsc-pro-theme' ),
						'industrial' => __( 'Industrial Manufacturing', 'aitsc-pro-theme' ),
						'safety' => __( 'Safety & Compliance', 'aitsc-pro-theme' ),
						'aerospace' => __( 'Aerospace & Defense', 'aitsc-pro-theme' ),
						'transportation' => __( 'Transportation & Logistics', 'aitsc-pro-theme' )
					);

					foreach ( $industry_focus as $industry ) :
						$filter_url = add_query_arg( 'industry', $industry, get_post_type_archive_link( 'solutions' ) );
						echo '<a href="' . esc_url( $filter_url ) . '" class="industry-tag industry-' . esc_attr( $industry ) . '">';
						echo isset( $industry_labels[$industry] ) ? esc_html( $industry_labels[$industry] ) : esc_html( $industry );
						echo '</a>';
					endforeach;
					?>
				</div>
			</div>
		<?php endif; ?>
	</header>

	<div class="solution-content">
		<div class="solution-grid">
			<!-- Main Content -->
			<div class="solution-main-content">
				<?php if ( get_the_content() ) : ?>
					<div class="solution-description">
						<h2><?php esc_html_e( 'Solution Overview', 'aitsc-pro-theme' ); ?></h2>
						<div class="solution-content-inner">
							<?php the_content(); ?>
						</div>
					</div>
				<?php endif; ?>

				<!-- Key Features -->
				<?php if ( $key_features ) : ?>
					<div class="solution-key-features">
						<h2><?php esc_html_e( 'Key Features', 'aitsc-pro-theme' ); ?></h2>
						<ul class="features-list">
							<?php
							$features = explode( "\n", $key_features );
							$features = array_filter( array_map( 'trim', $features ) );
							foreach ( $features as $feature ) :
								if ( ! empty( $feature ) ) :
									echo '<li class="feature-item">' . esc_html( $feature ) . '</li>';
								endif;
							endforeach;
							?>
						</ul>
					</div>
				<?php endif; ?>

				<!-- Expected Outcomes -->
				<?php if ( $outcomes ) : ?>
					<div class="solution-outcomes">
						<h2><?php esc_html_e( 'Expected Outcomes', 'aitsc-pro-theme' ); ?></h2>
						<div class="outcomes-content">
							<?php echo wp_kses_post( wpautop( $outcomes ) ); ?>
						</div>
					</div>
				<?php endif; ?>

				<!-- Technologies -->
				<?php if ( $technologies ) : ?>
					<div class="solution-technologies">
						<h2><?php esc_html_e( 'Technologies & Tools', 'aitsc-pro-theme' ); ?></h2>
						<div class="technologies-list">
							<?php
							$tech_array = explode( ',', $technologies );
							$tech_array = array_filter( array_map( 'trim', $tech_array ) );
							foreach ( $tech_array as $tech ) :
								if ( ! empty( $tech ) ) :
									echo '<span class="tech-badge">' . esc_html( $tech ) . '</span>';
								endif;
							endforeach;
							?>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<!-- Sidebar -->
			<aside class="solution-sidebar">
				<!-- Quick Info -->
				<div class="solution-quick-info">
					<h3><?php esc_html_e( 'Solution Details', 'aitsc-pro-theme' ); ?></h3>

					<?php if ( $service_type ) : ?>
						<div class="info-item">
							<span class="info-label"><?php esc_html_e( 'Service Type', 'aitsc-pro-theme' ); ?></span>
							<span class="info-value"><?php echo esc_html( $service_type ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( $complexity ) : ?>
						<div class="info-item">
							<span class="info-label"><?php esc_html_e( 'Timeline', 'aitsc-pro-theme' ); ?></span>
							<span class="info-value">
								<?php
								$complexity_labels = array(
									'standard' => __( '1-3 months', 'aitsc-pro-theme' ),
									'complex' => __( '3-6 months', 'aitsc-pro-theme' ),
									'enterprise' => __( '6+ months', 'aitsc-pro-theme' )
								);
								echo esc_html( $complexity_labels[$complexity] ?? $complexity );
								?>
							</span>
						</div>
					<?php endif; ?>

					<?php if ( $certification ) : ?>
						<div class="info-item">
							<span class="info-label"><?php esc_html_e( 'Certifications', 'aitsc-pro-theme' ); ?></span>
							<span class="info-value"><?php echo esc_html( $certification ); ?></span>
						</div>
					<?php endif; ?>
				</div>

				<!-- CTA -->
				<div class="solution-cta">
					<h3><?php esc_html_e( 'Get Started', 'aitsc-pro-theme' ); ?></h3>
					<p><?php esc_html_e( 'Ready to implement this solution? Contact our experts to discuss your specific requirements.', 'aitsc-pro-theme' ); ?></p>
					<a href="/contact/?solution=<?php echo urlencode( get_the_title() ); ?>" class="cta-button">
						<?php esc_html_e( 'Request Consultation', 'aitsc-pro-theme' ); ?>
					</a>
				</div>

				<!-- Download Info -->
				<div class="solution-download">
					<h3><?php esc_html_e( 'Learn More', 'aitsc-pro-theme' ); ?></h3>
					<p><?php esc_html_e( 'Download our detailed solution brochure for comprehensive information.', 'aitsc-pro-theme' ); ?></p>
					<button class="download-button" data-solution="<?php echo esc_attr( get_the_title() ); ?>">
						<?php esc_html_e( 'Download Brochure', 'aitsc-pro-theme' ); ?>
					</button>
				</div>
			</aside>
		</div>
	</div>

	<!-- Related Solutions -->
	<?php if ( ! empty( $related_solutions ) ) : ?>
		<section class="related-solutions">
			<div class="container">
				<h2><?php esc_html_e( 'Related Solutions', 'aitsc-pro-theme' ); ?></h2>
				<div class="related-solutions-grid">
					<?php foreach ( $related_solutions as $related ) : ?>
						<?php
						// Render unified card for related solutions
						aitsc_render_card([
							'variant' => has_post_thumbnail( $related->ID ) ? 'image' : 'solution',
							'title' => $related->post_title,
							'description' => wp_trim_words( $related->post_excerpt, 20, '...' ),
							'link' => get_permalink( $related->ID ),
							'image' => has_post_thumbnail( $related->ID ) ? get_the_post_thumbnail_url( $related->ID, 'medium' ) : '',
							'icon' => 'shield',
							'cta_text' => 'Learn More',
							'size' => 'medium',
							'custom_class' => 'related-solution-card'
						]);
						?>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- Navigation -->
	<nav class="solution-navigation">
		<div class="container">
			<div class="nav-links">
				<div class="nav-previous">
					<?php previous_post_link( '%link', '<span class="nav-arrow">←</span> %title', true, '', 'solutions' ); ?>
				</div>
				<div class="nav-archive">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'solutions' ) ); ?>">
						<?php esc_html_e( 'All Solutions', 'aitsc-pro-theme' ); ?>
					</a>
				</div>
				<div class="nav-next">
					<?php next_post_link( '%link', '%title <span class="nav-arrow">→</span>', true, '', 'solutions' ); ?>
				</div>
			</div>
		</div>
	</nav>
</article>

<!-- Schema Markup for SEO -->
<script type="application/ld+json">
{
	"@context": "https://schema.org",
	"@type": "Service",
	"name": "<?php echo esc_js( get_the_title() ); ?>",
	"description": "<?php echo esc_js( get_the_excerpt() ); ?>",
	"provider": {
		"@type": "Organization",
		"name": "AITSC",
		"url": "https://aitsc.com"
	},
	"serviceType": "<?php echo esc_js( $service_type ); ?>",
	"offers": {
		"@type": "Offer",
		"availability": "https://schema.org/InStock"
	}
	<?php if ( ! empty( $technologies ) ) : ?>
	,"keywords": "<?php echo esc_js( $technologies ); ?>"
	<?php endif; ?>
}
</script>