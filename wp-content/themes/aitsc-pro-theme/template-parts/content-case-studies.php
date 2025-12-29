<?php
/**
 * Case Studies Content Template
 *
 * Template part for displaying case studies in archive display
 * with client information filtering and project galleries.
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
$gallery_ids = get_post_meta( $case_study_id, '_case_study_gallery', true );

// Process first gallery image for thumbnail
$first_gallery_image = null;
if ( $gallery_ids ) {
	$image_ids = array_map( 'trim', explode( ',', $gallery_ids ) );
	foreach ( $image_ids as $image_id ) {
		$image_id = intval( $image_id );
		if ( $image_id > 0 ) {
			$image_data = wp_get_attachment_image_src( $image_id, 'large' );
			if ( $image_data ) {
				$first_gallery_image = array(
					'url' => $image_data[0],
					'thumbnail' => wp_get_attachment_image_src( $image_id, 'medium' )[0],
					'alt' => get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ?: get_the_title( $image_id )
				);
				break;
			}
		}
	}
}

// Process results for display
$first_result = '';
if ( $results ) {
	$result_items = explode( "\n", $results );
	$result_items = array_filter( array_map( 'trim', $result_items ) );
	$first_result = ! empty( $result_items ) ? $result_items[0] : '';
}

// Create industry categories for filtering
$industry_categories = array();
if ( $client_industry ) {
	$industry_categories[] = strtolower( str_replace( ' ', '-', $client_industry ) );
}

// Convert categories to array for data attributes
$categories_data = array();
$categories = get_the_terms( $case_study_id, 'case_study_category' );
if ( $categories && ! is_wp_error( $categories ) ) {
	$categories_data = wp_list_pluck( $categories, 'slug' );
}
?>

<div id="case-study-<?php the_ID(); ?>" <?php post_class( 'case-study-card' ); ?> data-client="<?php echo esc_attr( strtolower( str_replace( ' ', '-', $client ?: '' ) ) ); ?>" data-industry="<?php echo esc_attr( implode( ',', $industry_categories ) ); ?>" data-categories="<?php echo esc_attr( implode( ',', $categories_data ) ); ?>">

	<!-- Card Image -->
	<div class="case-study-card-image">
		<?php if ( $first_gallery_image || has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'View case study: %s', 'aitsc-pro-theme' ), get_the_title() ) ); ?>">
				<?php if ( $first_gallery_image ) : ?>
					<img src="<?php echo esc_url( $first_gallery_image['thumbnail'] ); ?>" alt="<?php echo esc_attr( $first_gallery_image['alt'] ); ?>" class="case-study-thumbnail" loading="lazy">
				<?php else : ?>
					<?php the_post_thumbnail( 'medium', array( 'class' => 'case-study-thumbnail', 'loading' => 'lazy' ) ); ?>
				<?php endif; ?>

				<div class="case-study-image-overlay">
					<div class="overlay-content">
						<span class="view-project"><?php esc_html_e( 'View Project', 'aitsc-pro-theme' ); ?></span>
						<div class="project-stats">
							<?php if ( $duration ) : ?>
								<span class="stat">
									<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M12 2v20m-9-11h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
									</svg>
									<?php echo esc_html( $duration ); ?>
								</span>
							<?php endif; ?>

							<?php if ( $team_size ) : ?>
								<span class="stat">
									<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M12 7a3 3 0 100-6 3 3 0 000 6zm0 2a8 8 0 00-8 8v6h16v-6a8 8 0 00-8-8z" fill="currentColor"/>
									</svg>
									<?php echo esc_html( $team_size ); ?>
								</span>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</a>
		<?php else : ?>
			<div class="case-study-placeholder">
				<svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M14 2v6h6M16 13H8M16 17H8M10 9H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
		<?php endif; ?>

		<!-- Client Badge -->
		<?php if ( $client ) : ?>
			<div class="client-badge">
				<span class="client-name"><?php echo esc_html( $client ); ?></span>
			</div>
		<?php endif; ?>
	</div>

	<!-- Card Content -->
	<div class="case-study-card-content">
		<!-- Categories -->
		<div class="case-study-categories">
			<?php
			if ( $categories && ! is_wp_error( $categories ) ) :
				foreach ( array_slice( $categories, 0, 2 ) as $category ) :
					echo '<span class="case-study-category">' . esc_html( $category->name ) . '</span>';
				endforeach;

				if ( count( $categories ) > 2 ) :
					echo '<span class="case-study-category category-more">+' . ( count( $categories ) - 2 ) . '</span>';
				endif;
			endif;
			?>
		</div>

		<!-- Title -->
		<h3 class="case-study-card-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>

		<!-- Project Title -->
		<?php if ( $project_title ) : ?>
			<p class="case-study-project-title"><?php echo esc_html( $project_title ); ?></p>
		<?php endif; ?>

		<!-- Client Industry -->
		<?php if ( $client_industry ) : ?>
			<div class="client-industry">
				<span class="industry-icon">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M3 21h18M5 21V7l8-4v18M13 21V11l8-4v14M9 9v4M12 9v4M15 13v4M6 13v4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</span>
				<span class="industry-text"><?php echo esc_html( $client_industry ); ?></span>
			</div>
		<?php endif; ?>

		<!-- Excerpt -->
		<?php if ( get_the_excerpt() ) : ?>
			<div class="case-study-card-excerpt">
				<?php the_excerpt(); ?>
			</div>
		<?php endif; ?>

		<!-- Key Result -->
		<?php if ( $first_result ) : ?>
			<div class="case-study-result">
				<div class="result-icon">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</div>
				<span class="result-text"><?php echo esc_html( $first_result ); ?></span>
			</div>
		<?php endif; ?>

		<!-- Technologies Preview -->
		<?php if ( $technologies ) : ?>
			<div class="case-study-technologies">
				<span class="tech-label"><?php esc_html_e( 'Technologies:', 'aitsc-pro-theme' ); ?></span>
				<div class="tech-list">
					<?php
					$tech_array = explode( ',', $technologies );
					$tech_array = array_filter( array_map( 'trim', $tech_array ) );
					$display_tech = array_slice( $tech_array, 0, 3 );
					foreach ( $display_tech as $tech ) :
						if ( ! empty( $tech ) ) :
							echo '<span class="tech-badge">' . esc_html( $tech ) . '</span>';
						endif;
					endforeach;

					if ( count( $tech_array ) > 3 ) :
						echo '<span class="tech-badge tech-more">+' . ( count( $tech_array ) - 3 ) . '</span>';
					endif;
					?>
				</div>
			</div>
		<?php endif; ?>
	</div>

	<!-- Card Footer -->
	<div class="case-study-card-footer">
		<!-- Project Budget -->
		<?php if ( $project_budget ) : ?>
			<div class="project-budget">
				<span class="budget-label"><?php esc_html_e( 'Budget:', 'aitsc-pro-theme' ); ?></span>
				<span class="budget-value"><?php echo esc_html( $project_budget ); ?></span>
			</div>
		<?php endif; ?>

		<!-- Action Buttons -->
		<div class="case-study-actions">
			<a href="<?php the_permalink(); ?>" class="action-button primary-action">
				<?php esc_html_e( 'Read Case Study', 'aitsc-pro-theme' ); ?>
				<span class="action-arrow">→</span>
			</a>
			<button class="action-button secondary-action" data-case-study="<?php echo esc_attr( get_the_title() ); ?>" data-id="<?php echo esc_attr( $case_study_id ); ?>">
				<?php esc_html_e( 'Get Similar', 'aitsc-pro-theme' ); ?>
			</button>
		</div>

		<!-- Quick Gallery Button -->
		<?php if ( ! empty( $gallery_images ) ) : ?>
			<button class="gallery-preview-button" data-id="<?php echo esc_attr( $case_study_id ); ?>" aria-label="<?php esc_html_e( 'Preview gallery', 'aitsc-pro-theme' ); ?>">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				<span class="gallery-count"><?php echo count( $gallery_images ); ?></span>
			</button>
		<?php endif; ?>
	</div>

	<!-- Hidden Data for JavaScript -->
	<div class="case-study-hidden-data" style="display: none;">
		<?php
		$data = array(
			'id' => $case_study_id,
			'title' => get_the_title(),
			'project_title' => $project_title,
			'excerpt' => get_the_excerpt(),
			'permalink' => get_permalink(),
			'thumbnail' => $first_gallery_image ? $first_gallery_image['url'] : get_the_post_thumbnail_url( $case_study_id, 'large' ),
			'client' => $client,
			'client_industry' => $client_industry,
			'duration' => $duration,
			'team_size' => $team_size,
			'project_budget' => $project_budget,
			'technologies' => $technologies,
			'challenge' => $challenge,
			'results' => $results,
			'gallery_count' => ! empty( $gallery_images ) ? count( $gallery_images ) : 0,
			'categories' => array_map( function($cat) { return $cat->name; }, $categories ?: array() ),
			'industry_categories' => $industry_categories
		);
		echo '<script type="application/json">' . json_encode( $data ) . '</script>';
		?>
	</div>
</div>