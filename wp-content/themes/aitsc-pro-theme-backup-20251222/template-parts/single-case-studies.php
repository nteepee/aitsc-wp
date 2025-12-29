<?php
/**
 * Single Case Study Template
 *
 * Template part for displaying individual case study posts with project galleries
 * and comprehensive client information.
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Get case study meta data
$case_study_id = get_the_ID();
$client = get_post_meta( $case_study_id, '_case_study_client', true );
$client_industry = get_post_meta( $case_study_id, '_case_study_client_industry', true );
$project_title = get_post_meta( $case_study_id, '_case_study_project_title', true );
$duration = get_post_meta( $case_study_id, '_case_study_duration', true );
$team_size = get_post_meta( $case_study_id, '_case_study_team_size', true );
$project_budget = get_post_meta( $case_study_id, '_case_study_project_budget', true );
$technologies = get_post_meta( $case_study_id, '_case_study_technologies', true );
$challenge = get_post_meta( $case_study_id, '_case_study_challenge', true );
$results = get_post_meta( $case_study_id, '_case_study_results', true );
$metrics = get_post_meta( $case_study_id, '_case_study_metrics', true );
$gallery_ids = get_post_meta( $case_study_id, '_case_study_gallery', true );
$testimonial = get_post_meta( $case_study_id, '_case_study_testimonial', true );
$testimonial_author = get_post_meta( $case_study_id, '_case_study_testimonial_author', true );

// Process gallery images
$gallery_images = array();
if ( $gallery_ids ) {
	$image_ids = array_map( 'trim', explode( ',', $gallery_ids ) );
	foreach ( $image_ids as $image_id ) {
		$image_id = intval( $image_id );
		if ( $image_id > 0 ) {
			$image_data = wp_get_attachment_image_src( $image_id, 'large' );
			if ( $image_data ) {
				$gallery_images[] = array(
					'id' => $image_id,
					'url' => $image_data[0],
					'width' => $image_data[1],
					'height' => $image_data[2],
					'thumbnail' => wp_get_attachment_image_src( $image_id, 'thumbnail' )[0],
					'alt' => get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ?: get_the_title( $image_id )
				);
			}
		}
	}
}

// Process metrics
$processed_metrics = array();
if ( $metrics ) {
	$lines = explode( "\n", $metrics );
	foreach ( $lines as $line ) {
		$line = trim( $line );
		if ( ! empty( $line ) && strpos( $line, ':' ) !== false ) {
			$parts = explode( ':', $line, 2 );
			if ( count( $parts ) === 2 ) {
				$processed_metrics[] = array(
					'label' => trim( $parts[0] ),
					'value' => trim( $parts[1] )
				);
			}
		}
	}
}
?>

<article id="case-study-<?php the_ID(); ?>" <?php post_class( 'aitsc-case-study-single' ); ?>>
	<header class="case-study-header">
		<div class="case-study-hero">
			<div class="hero-background">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="hero-image-overlay">
						<?php the_post_thumbnail( 'full', array( 'class' => 'case-study-hero-image' ) ); ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="hero-content">
				<div class="container">
					<!-- Categories -->
					<div class="case-study-categories">
						<?php
						$categories = get_the_terms( $case_study_id, 'case_study_category' );
						if ( $categories && ! is_wp_error( $categories ) ) :
							foreach ( $categories as $category ) :
								$category_link = get_term_link( $category );
								echo '<a href="' . esc_url( $category_link ) . '" class="case-study-category-link">';
								echo esc_html( $category->name );
								echo '</a>';
							endforeach;
						endif;
						?>
					</div>

					<h1 class="case-study-title"><?php the_title(); ?></h1>

					<?php if ( $project_title ) : ?>
						<p class="case-study-project-title"><?php echo esc_html( $project_title ); ?></p>
					<?php endif; ?>

					<?php if ( $client ) : ?>
						<div class="case-study-client">
							<span class="client-label"><?php esc_html_e( 'Client:', 'aitsc-pro-theme' ); ?></span>
							<span class="client-name"><?php echo esc_html( $client ); ?></span>
							<?php if ( $client_industry ) : ?>
								<span class="client-industry"><?php echo esc_html( $client_industry ); ?></span>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</header>

	<!-- Project Overview -->
	<section class="case-study-overview">
		<div class="container">
			<div class="overview-grid">
				<div class="overview-content">
					<h2><?php esc_html_e( 'Project Overview', 'aitsc-pro-theme' ); ?></h2>
					<?php if ( get_the_content() ) : ?>
						<div class="overview-text">
							<?php the_content(); ?>
						</div>
					<?php endif; ?>
				</div>

				<div class="overview-stats">
					<div class="stat-items">
						<?php if ( $duration ) : ?>
							<div class="stat-item">
								<div class="stat-icon">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M12 2v20m-9-11h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
									</svg>
								</div>
								<div class="stat-content">
									<div class="stat-label"><?php esc_html_e( 'Duration', 'aitsc-pro-theme' ); ?></div>
									<div class="stat-value"><?php echo esc_html( $duration ); ?></div>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( $team_size ) : ?>
							<div class="stat-item">
								<div class="stat-icon">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M12 7a3 3 0 100-6 3 3 0 000 6zm0 2a8 8 0 00-8 8v6h16v-6a8 8 0 00-8-8z" fill="currentColor"/>
									</svg>
								</div>
								<div class="stat-content">
									<div class="stat-label"><?php esc_html_e( 'Team Size', 'aitsc-pro-theme' ); ?></div>
									<div class="stat-value"><?php echo esc_html( $team_size ); ?></div>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( $project_budget ) : ?>
							<div class="stat-item">
								<div class="stat-icon">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1.81.45 1.61 1.67 1.61 1.16 0 1.6-.64 1.6-1.46 0-.84-.68-1.22-2.34-1.61-2.24-.53-3.38-1.41-3.38-2.96 0-1.55 1.28-2.67 3.03-3.01V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.63-1.71-1.63-1.06 0-1.54.6-1.54 1.28 0 .78.56 1.18 2.27 1.6 2.44.6 3.71 1.49 3.71 3.07 0 1.58-1.33 2.78-3.42 3.03z" fill="currentColor"/>
									</svg>
								</div>
								<div class="stat-content">
									<div class="stat-label"><?php esc_html_e( 'Project Budget', 'aitsc-pro-theme' ); ?></div>
									<div class="stat-value"><?php echo esc_html( $project_budget ); ?></div>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Main Content -->
	<div class="case-study-content">
		<div class="container">
			<div class="content-grid">
				<!-- Challenge -->
				<?php if ( $challenge ) : ?>
					<section class="case-study-challenge">
						<h2><?php esc_html_e( 'The Challenge', 'aitsc-pro-theme' ); ?></h2>
						<div class="challenge-content">
							<?php echo wp_kses_post( wpautop( $challenge ) ); ?>
						</div>
					</section>
				<?php endif; ?>

				<!-- Solution -->
				<?php if ( get_the_content() ) : ?>
					<section class="case-study-solution">
						<h2><?php esc_html_e( 'Our Solution', 'aitsc-pro-theme' ); ?></h2>
						<div class="solution-content">
							<?php the_content(); ?>
						</div>
					</section>
				<?php endif; ?>

				<!-- Technologies -->
				<?php if ( $technologies ) : ?>
					<section class="case-study-technologies">
						<h2><?php esc_html_e( 'Technologies Used', 'aitsc-pro-theme' ); ?></h2>
						<div class="technologies-grid">
							<?php
							$tech_array = explode( ',', $technologies );
							$tech_array = array_filter( array_map( 'trim', $tech_array ) );
							foreach ( $tech_array as $tech ) :
								if ( ! empty( $tech ) ) :
									echo '<div class="tech-item">';
									echo '<div class="tech-icon">' . esc_html( substr( $tech, 0, 2 ) ) . '</div>';
									echo '<div class="tech-name">' . esc_html( $tech ) . '</div>';
									echo '</div>';
								endif;
							endforeach;
							?>
						</div>
					</section>
				<?php endif; ?>

				<!-- Results -->
				<?php if ( $results ) : ?>
					<section class="case-study-results">
						<h2><?php esc_html_e( 'Key Results', 'aitsc-pro-theme' ); ?></h2>
						<div class="results-content">
							<?php
							$result_items = explode( "\n", $results );
							$result_items = array_filter( array_map( 'trim', $result_items ) );
							foreach ( $result_items as $result ) :
								if ( ! empty( $result ) ) :
									echo '<div class="result-item">';
									echo '<div class="result-check">✓</div>';
									echo '<div class="result-text">' . esc_html( $result ) . '</div>';
									echo '</div>';
								endif;
							endforeach;
							?>
						</div>
					</section>
				<?php endif; ?>

				<!-- Metrics -->
				<?php if ( ! empty( $processed_metrics ) ) : ?>
					<section class="case-study-metrics">
						<h2><?php esc_html_e( 'Measurable Impact', 'aitsc-pro-theme' ); ?></h2>
						<div class="metrics-grid">
							<?php foreach ( $processed_metrics as $metric ) : ?>
								<div class="metric-card">
									<div class="metric-value"><?php echo esc_html( $metric['value'] ); ?></div>
									<div class="metric-label"><?php echo esc_html( $metric['label'] ); ?></div>
								</div>
							<?php endforeach; ?>
						</div>
					</section>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<!-- Project Gallery -->
	<?php if ( ! empty( $gallery_images ) ) : ?>
		<section class="case-study-gallery">
			<div class="container">
				<h2><?php esc_html_e( 'Project Gallery', 'aitsc-pro-theme' ); ?></h2>
				<div class="gallery-container">
					<div class="gallery-main">
						<?php if ( isset( $gallery_images[0] ) ) : ?>
							<img id="main-image" src="<?php echo esc_url( $gallery_images[0]['url'] ); ?>" alt="<?php echo esc_attr( $gallery_images[0]['alt'] ); ?>" class="main-gallery-image">
						<?php endif; ?>
					</div>
					<?php if ( count( $gallery_images ) > 1 ) : ?>
						<div class="gallery-thumbnails">
							<?php foreach ( $gallery_images as $index => $image ) : ?>
								<button
									class="gallery-thumbnail<?php echo $index === 0 ? ' active' : ''; ?>"
									data-image="<?php echo esc_url( $image['url'] ); ?>"
									data-alt="<?php echo esc_attr( $image['alt'] ); ?>"
									aria-label="<?php esc_html_e( 'View image', 'aitsc-pro-theme' ); ?>"
								>
									<img src="<?php echo esc_url( $image['thumbnail'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
								</button>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- Testimonial -->
	<?php if ( $testimonial ) : ?>
		<section class="case-study-testimonial">
			<div class="container">
				<div class="testimonial-content">
					<blockquote class="testimonial-quote">
						<?php echo wp_kses_post( wpautop( $testimonial ) ); ?>
					</blockquote>
					<?php if ( $testimonial_author ) : ?>
						<cite class="testimonial-author">
							<?php echo esc_html( $testimonial_author ); ?>
						</cite>
					<?php endif; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- Call to Action -->
	<section class="case-study-cta">
		<div class="container">
			<div class="cta-content">
				<h2><?php esc_html_e( 'Ready to Transform Your Business?', 'aitsc-pro-theme' ); ?></h2>
				<p><?php esc_html_e( 'Discover how AITSC can help you achieve similar results with our customized engineering solutions.', 'aitsc-pro-theme' ); ?></p>
				<div class="cta-buttons">
					<a href="/contact/?case-study=<?php echo urlencode( get_the_title() ); ?>" class="cta-primary">
						<?php esc_html_e( 'Start Your Project', 'aitsc-pro-theme' ); ?>
					</a>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'solutions' ) ); ?>" class="cta-secondary">
						<?php esc_html_e( 'Explore Solutions', 'aitsc-pro-theme' ); ?>
					</a>
				</div>
			</div>
		</div>
	</section>

	<!-- Navigation -->
	<nav class="case-study-navigation">
		<div class="container">
			<div class="nav-links">
				<div class="nav-previous">
					<?php previous_post_link( '%link', '<span class="nav-arrow">←</span> %title', true, '', 'case_studies' ); ?>
				</div>
				<div class="nav-archive">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'case_studies' ) ); ?>">
						<?php esc_html_e( 'All Case Studies', 'aitsc-pro-theme' ); ?>
					</a>
				</div>
				<div class="nav-next">
					<?php next_post_link( '%link', '%title <span class="nav-arrow">→</span>', true, '', 'case_studies' ); ?>
				</div>
			</div>
		</div>
	</nav>
</article>

<!-- Gallery Modal -->
<div id="gallery-modal" class="gallery-modal" aria-hidden="true">
	<div class="modal-content">
		<button class="modal-close" aria-label="<?php esc_html_e( 'Close gallery', 'aitsc-pro-theme' ); ?>">&times;</button>
		<div class="modal-image-container">
			<img id="modal-image" src="" alt="">
		</div>
		<div class="modal-nav">
			<button class="modal-prev" aria-label="<?php esc_html_e( 'Previous image', 'aitsc-pro-theme' ); ?>">&lt;</button>
			<button class="modal-next" aria-label="<?php esc_html_e( 'Next image', 'aitsc-pro-theme' ); ?>">&gt;</button>
		</div>
	</div>
</div>

<!-- Schema Markup for SEO -->
<script type="application/ld+json">
{
	"@context": "https://schema.org",
	"@type": "CaseStudy",
	"name": "<?php echo esc_js( get_the_title() ); ?>",
	"description": "<?php echo esc_js( get_the_excerpt() ); ?>",
	"about": {
		"@type": "Thing",
		"name": "<?php echo esc_js( $project_title ?: get_the_title() ); ?>"
	},
	"client": {
		"@type": "Organization",
		"name": "<?php echo esc_js( $client ); ?>"
		<?php if ( $client_industry ) : ?>
		,"industry": "<?php echo esc_js( $client_industry ); ?>"
		<?php endif; ?>
	},
	"provider": {
		"@type": "Organization",
		"name": "AITSC",
		"url": "https://aitsc.com"
	},
	"startDate": "<?php echo esc_js( get_the_date( 'c' ) ); ?>",
	"outcome": {
		"@type": "Thing",
		"name": "Successful Project Completion"
		<?php if ( ! empty( $processed_metrics ) ) : ?>
		,"description": "<?php echo esc_js( wp_json_encode( $processed_metrics ) ); ?>"
		<?php endif; ?>
	}
	<?php if ( $technologies ) : ?>
	,"keywords": "<?php echo esc_js( $technologies ); ?>"
	<?php endif; ?>
}
</script>