<?php
/**
 * Solutions Content Template
 *
 * Template part for displaying solutions in grid view with industry filtering
 * and interactive hover effects.
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

// Get first key feature for preview
$first_feature = '';
if ( $key_features ) {
	$features = explode( "\n", $key_features );
	$features = array_filter( array_map( 'trim', $features ) );
	$first_feature = ! empty( $features ) ? $features[0] : '';
}

// Industry labels for display
$industry_labels = array(
	'automotive' => __( 'Automotive', 'aitsc-pro-theme' ),
	'industrial' => __( 'Industrial', 'aitsc-pro-theme' ),
	'safety' => __( 'Safety', 'aitsc-pro-theme' ),
	'aerospace' => __( 'Aerospace', 'aitsc-pro-theme' ),
	'transportation' => __( 'Transportation', 'aitsc-pro-theme' )
);

// Complexity classes for styling
$complexity_classes = array(
	'standard' => 'complexity-low',
	'complex' => 'complexity-medium',
	'enterprise' => 'complexity-high'
);
?>

<div id="solution-<?php the_ID(); ?>" <?php post_class( 'solution-card' ); ?> data-industries="<?php echo esc_attr( implode( ',', $industry_focus ) ); ?>" data-complexity="<?php echo esc_attr( $complexity ); ?>">

	<!-- Card Header -->
	<div class="solution-card-header">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="solution-card-image">
				<a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Read more about %s', 'aitsc-pro-theme' ), get_the_title() ) ); ?>">
					<?php the_post_thumbnail( 'medium', array( 'class' => 'solution-thumbnail' ) ); ?>
					<div class="solution-image-overlay">
						<span class="view-details"><?php esc_html_e( 'View Details', 'aitsc-pro-theme' ); ?></span>
					</div>
				</a>
			</div>
		<?php endif; ?>

		<!-- Industry Tags -->
		<?php if ( ! empty( $industry_focus ) ) : ?>
			<div class="solution-card-tags">
				<?php
				$display_count = 0;
				foreach ( $industry_focus as $industry ) :
					if ( isset( $industry_labels[$industry] ) && $display_count < 2 ) :
						echo '<span class="solution-tag industry-' . esc_attr( $industry ) . '">';
						echo esc_html( $industry_labels[$industry] );
						echo '</span>';
						$display_count++;
					endif;
				endforeach;

				if ( count( $industry_focus ) > 2 ) :
					echo '<span class="solution-tag tag-more">+' . ( count( $industry_focus ) - 2 ) . '</span>';
				endif;
				?>
			</div>
		<?php endif; ?>
	</div>

	<!-- Card Content -->
	<div class="solution-card-content">
		<!-- Categories -->
		<div class="solution-card-categories">
			<?php
			$categories = get_the_terms( $solution_id, 'solution_category' );
			if ( $categories && ! is_wp_error( $categories ) ) :
				foreach ( array_slice( $categories, 0, 1 ) as $category ) :
					$category_link = get_term_link( $category );
					echo '<a href="' . esc_url( $category_link ) . '" class="solution-category-link">';
					echo esc_html( $category->name );
					echo '</a>';
				endforeach;
			endif;
			?>
		</div>

		<!-- Title -->
		<h3 class="solution-card-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>

		<!-- Service Type Badge -->
		<?php if ( $service_type ) : ?>
			<div class="solution-service-type">
				<span class="service-badge">
					<?php echo esc_html( $service_type ); ?>
				</span>
			</div>
		<?php endif; ?>

		<!-- Excerpt -->
		<?php if ( get_the_excerpt() ) : ?>
			<div class="solution-card-excerpt">
				<?php the_excerpt(); ?>
			</div>
		<?php endif; ?>

		<!-- Key Feature Preview -->
		<?php if ( $first_feature ) : ?>
			<div class="solution-card-feature">
				<div class="feature-icon">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</div>
				<span class="feature-text"><?php echo esc_html( $first_feature ); ?></span>
			</div>
		<?php endif; ?>

		<!-- Technologies Preview -->
		<?php if ( $technologies ) : ?>
			<div class="solution-card-tech">
				<?php
				$tech_array = explode( ',', $technologies );
				$tech_array = array_filter( array_map( 'trim', $tech_array ) );
				$display_tech = array_slice( $tech_array, 0, 3 );
				foreach ( $display_tech as $tech ) :
					echo '<span class="tech-badge-small">' . esc_html( $tech ) . '</span>';
				endforeach;

				if ( count( $tech_array ) > 3 ) :
					echo '<span class="tech-badge-small">+' . ( count( $tech_array ) - 3 ) . '</span>';
				endif;
				?>
			</div>
		<?php endif; ?>
	</div>

	<!-- Card Footer -->
	<div class="solution-card-footer">
		<!-- Complexity Indicator -->
		<?php if ( $complexity ) : ?>
			<div class="solution-complexity">
				<span class="complexity-label"><?php esc_html_e( 'Timeline:', 'aitsc-pro-theme' ); ?></span>
				<div class="complexity-indicator">
					<div class="complexity-bar <?php echo isset( $complexity_classes[$complexity] ) ? esc_attr( $complexity_classes[$complexity] ) : ''; ?>"></div>
					<span class="complexity-text">
						<?php
						$complexity_short = array(
							'standard' => __( '1-3 months', 'aitsc-pro-theme' ),
							'complex' => __( '3-6 months', 'aitsc-pro-theme' ),
							'enterprise' => __( '6+ months', 'aitsc-pro-theme' )
						);
						echo esc_html( $complexity_short[$complexity] ?? $complexity );
						?>
					</span>
				</div>
			</div>
		<?php endif; ?>

		<!-- Action Buttons -->
		<div class="solution-card-actions">
			<a href="<?php the_permalink(); ?>" class="action-button primary-action">
				<?php esc_html_e( 'Learn More', 'aitsc-pro-theme' ); ?>
				<span class="action-arrow">→</span>
			</a>
			<button class="action-button secondary-action" data-solution="<?php echo esc_attr( get_the_title() ); ?>" data-id="<?php echo esc_attr( $solution_id ); ?>">
				<?php esc_html_e( 'Get Quote', 'aitsc-pro-theme' ); ?>
			</button>
		</div>

		<!-- Quick View Button -->
		<button class="quick-view-button" data-id="<?php echo esc_attr( $solution_id ); ?>" aria-label="<?php esc_html_e( 'Quick view', 'aitsc-pro-theme' ); ?>">
			<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</button>
	</div>

	<!-- Hidden Data for JavaScript -->
	<div class="solution-hidden-data" style="display: none;">
		<?php
		$data = array(
			'id' => $solution_id,
			'title' => get_the_title(),
			'excerpt' => get_the_excerpt(),
			'permalink' => get_permalink(),
			'thumbnail' => get_the_post_thumbnail_url( $solution_id, 'large' ),
			'industry_focus' => $industry_focus,
			'service_type' => $service_type,
			'technologies' => $technologies,
			'complexity' => $complexity,
			'key_features' => $key_features,
			'categories' => array_map( function($cat) { return $cat->name; }, $categories ?: array() )
		);
		echo '<script type="application/json">' . json_encode( $data ) . '</script>';
		?>
	</div>
</div>