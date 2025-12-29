<?php
/**
 * Template for displaying solutions archive
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

get_header(); ?>

<main id="primary" class="site-main">
	<div class="container">
		<header class="archive-header">
			<h1 class="archive-title">
				<?php
				if ( is_tax() ) {
					$term = get_queried_object();
					echo esc_html( $term->name );
				} elseif ( is_post_type_archive() ) {
					echo esc_html__( 'Solutions', 'aitsc-pro-theme' );
				} else {
					the_archive_title();
				}
				?>
			</h1>

			<div class="archive-description">
				<?php
				if ( is_tax() ) {
					$term = get_queried_object();
					echo wp_kses_post( $term->description );
				} elseif ( is_post_type_archive() ) {
					echo '<p>' . esc_html__( 'Discover AITSC\'s comprehensive range of safety and compliance solutions designed to meet the unique needs of your industry.', 'aitsc-pro-theme' ) . '</p>';
				} else {
					the_archive_description();
				}
				?>
			</div>

			<?php if ( is_post_type_archive( 'solutions' ) ) : ?>
				<div class="archive-actions">
					<?php if ( function_exists( 'aitsc_pro_theme_get_contact_page_url' ) ) : ?>
						<a href="<?php echo esc_url( aitsc_pro_theme_get_contact_page_url() ); ?>" class="archive-cta-btn">
							<?php esc_html_e( 'Get a Free Consultation', 'aitsc-pro-theme' ); ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="solutions-filters">
				<?php
				// Display category filter
				$categories = get_terms( array(
					'taxonomy'   => 'solution_category',
					'hide_empty' => true,
					'orderby'    => 'name',
					'order'      => 'ASC',
				) );

				if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
				?>
					<div class="filter-section">
						<h3 class="filter-title"><?php esc_html_e( 'Filter by Category', 'aitsc-pro-theme' ); ?></h3>
						<div class="filter-buttons">
							<a href="<?php echo esc_url( get_post_type_archive_link( 'solutions' ) ); ?>"
							   class="filter-btn <?php echo ! is_tax( 'solution_category' ) ? 'active' : ''; ?>">
								<?php esc_html_e( 'All Solutions', 'aitsc-pro-theme' ); ?>
							</a>
							<?php foreach ( $categories as $category ) : ?>
								<a href="<?php echo esc_url( get_term_link( $category ) ); ?>"
								   class="filter-btn <?php echo is_tax( 'solution_category', $category->term_id ) ? 'active' : ''; ?>">
									<?php echo esc_html( $category->name ); ?>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<div class="solutions-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<div class="solution-card">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="solution-card-image">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'medium_large', array( 'class' => 'solution-card-thumb' ) ); ?>
								</a>
							</div>
						<?php else : ?>
							<div class="solution-card-placeholder">
								<a href="<?php the_permalink(); ?>">
									<div class="solution-placeholder-icon">⚡</div>
								</a>
							</div>
						<?php endif; ?>

						<div class="solution-card-content">
							<?php aitsc_pro_theme_posted_on(); ?>

							<h2 class="solution-card-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>

							<?php if ( get_the_excerpt() ) : ?>
								<div class="solution-card-excerpt">
									<?php the_excerpt(); ?>
								</div>
							<?php endif; ?>

							<?php
							// Get custom meta fields
							$industry = get_post_meta( get_the_ID(), '_solution_industry', true );
							$technologies = get_post_meta( get_the_ID(), '_solution_technologies', true );

							if ( $industry || $technologies ) :
							?>
								<div class="solution-card-meta">
									<?php if ( $industry ) : ?>
										<div class="solution-card-meta-item">
											<span class="solution-card-meta-label"><?php esc_html_e( 'Industry:', 'aitsc-pro-theme' ); ?></span>
											<span class="solution-card-meta-value"><?php echo esc_html( $industry ); ?></span>
										</div>
									<?php endif; ?>

									<?php if ( $technologies ) : ?>
										<div class="solution-card-meta-item">
											<span class="solution-card-meta-label"><?php esc_html_e( 'Technologies:', 'aitsc-pro-theme' ); ?></span>
											<span class="solution-card-meta-value"><?php echo esc_html( $technologies ); ?></span>
										</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<?php
							// Get categories
							$categories = get_the_terms( get_the_ID(), 'solution_category' );
							if ( $categories && ! is_wp_error( $categories ) ) :
							?>
								<div class="solution-card-categories">
									<?php foreach ( $categories as $category ) : ?>
										<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="solution-card-category">
											<?php echo esc_html( $category->name ); ?>
										</a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<div class="solution-card-footer">
								<a href="<?php the_permalink(); ?>" class="solution-card-link">
									<?php esc_html_e( 'Learn More', 'aitsc-pro-theme' ); ?> &rarr;
								</a>
							</div>
						</div>
					</div>
					<?php
				endwhile;
				?>
			</div>

			<?php
			the_posts_pagination(
				array(
					'prev_text'          => __( 'Previous page', 'aitsc-pro-theme' ),
					'next_text'          => __( 'Next page', 'aitsc-pro-theme' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'aitsc-pro-theme' ) . ' </span>',
				)
			);
			?>

		<?php else : ?>
			<div class="no-results">
				<h2 class="no-results-title"><?php esc_html_e( 'No Solutions Found', 'aitsc-pro-theme' ); ?></h2>
				<p class="no-results-message">
					<?php
					if ( is_tax() ) {
						esc_html_e( 'No solutions found in this category. Please try browsing other categories or search for specific solutions.', 'aitsc-pro-theme' );
					} else {
						esc_html_e( 'No solutions available at the moment. Please check back soon or contact us for more information.', 'aitsc-pro-theme' );
					}
					?>
				</p>

				<div class="no-results-actions">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'solutions' ) ); ?>" class="no-results-link">
						<?php esc_html_e( 'Browse All Solutions', 'aitsc-pro-theme' ); ?>
					</a>

					<?php if ( function_exists( 'aitsc_pro_theme_get_contact_page_url' ) ) : ?>
						<a href="<?php echo esc_url( aitsc_pro_theme_get_contact_page_url() ); ?>" class="no-results-link">
							<?php esc_html_e( 'Contact Us', 'aitsc-pro-theme' ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( is_post_type_archive( 'solutions' ) ) : ?>
			<section class="solutions-cta">
				<div class="solutions-cta-content">
					<h2 class="solutions-cta-title"><?php esc_html_e( 'Need Custom Solutions?', 'aitsc-pro-theme' ); ?></h2>
					<p class="solutions-cta-description">
						<?php esc_html_e( 'Our team can develop tailored safety and compliance solutions to meet your specific industry requirements. Contact us today to discuss your needs.', 'aitsc-pro-theme' ); ?>
					</p>

					<div class="solutions-cta-actions">
						<?php if ( function_exists( 'aitsc_pro_theme_get_contact_page_url' ) ) : ?>
							<a href="<?php echo esc_url( aitsc_pro_theme_get_contact_page_url() ); ?>" class="solutions-cta-btn primary">
								<?php esc_html_e( 'Request Custom Solution', 'aitsc-pro-theme' ); ?>
							</a>
						<?php endif; ?>

						<a href="<?php echo esc_url( get_post_type_archive_link( 'case_studies' ) ); ?>" class="solutions-cta-btn secondary">
							<?php esc_html_e( 'View Case Studies', 'aitsc-pro-theme' ); ?>
						</a>
					</div>
				</div>
			</section>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>