<?php
/**
 * Template for displaying case studies archive
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
					echo esc_html__( 'Case Studies', 'aitsc-pro-theme' );
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
					echo '<p>' . esc_html__( 'Explore real-world examples of how AITSC has helped organizations improve their safety, compliance, and operational efficiency through innovative solutions.', 'aitsc-pro-theme' ) . '</p>';
				} else {
					the_archive_description();
				}
				?>
			</div>

			<?php if ( is_post_type_archive( 'case_studies' ) ) : ?>
				<div class="archive-actions">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'solutions' ) ); ?>" class="archive-cta-btn secondary">
						<?php esc_html_e( 'View Our Solutions', 'aitsc-pro-theme' ); ?>
					</a>

					<?php if ( function_exists( 'aitsc_pro_theme_get_contact_page_url' ) ) : ?>
						<a href="<?php echo esc_url( aitsc_pro_theme_get_contact_page_url() ); ?>" class="archive-cta-btn primary">
							<?php esc_html_e( 'Discuss Your Project', 'aitsc-pro-theme' ); ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="case-studies-filters">
				<?php
				// Display category filter
				$categories = get_terms( array(
					'taxonomy'   => 'case_study_category',
					'hide_empty' => true,
					'orderby'    => 'name',
					'order'      => 'ASC',
				) );

				if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
				?>
					<div class="filter-section">
						<h3 class="filter-title"><?php esc_html_e( 'Filter by Category', 'aitsc-pro-theme' ); ?></h3>
						<div class="filter-buttons">
							<a href="<?php echo esc_url( get_post_type_archive_link( 'case_studies' ) ); ?>"
							   class="filter-btn <?php echo ! is_tax( 'case_study_category' ) ? 'active' : ''; ?>">
								<?php esc_html_e( 'All Case Studies', 'aitsc-pro-theme' ); ?>
							</a>
							<?php foreach ( $categories as $category ) : ?>
								<a href="<?php echo esc_url( get_term_link( $category ) ); ?>"
								   class="filter-btn <?php echo is_tax( 'case_study_category', $category->term_id ) ? 'active' : ''; ?>">
									<?php echo esc_html( $category->name ); ?>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php
				// Display industry filter if industry meta field is used
				$industries = get_terms( array(
					'taxonomy'   => 'solution_category', // Using solution categories as proxy for industries
					'hide_empty' => true,
					'orderby'    => 'name',
					'order'      => 'ASC',
				) );

				// Alternative: Get unique industries from meta fields
				global $wpdb;
				$industries = $wpdb->get_col(
					"SELECT DISTINCT meta_value
					FROM {$wpdb->postmeta}
					WHERE meta_key = '_case_study_industry'
					AND meta_value != ''
					ORDER BY meta_value"
				);

				if ( ! empty( $industries ) && is_post_type_archive( 'case_studies' ) ) :
				?>
					<div class="filter-section">
						<h3 class="filter-title"><?php esc_html_e( 'Filter by Industry', 'aitsc-pro-theme' ); ?></h3>
						<div class="filter-buttons">
							<a href="<?php echo esc_url( get_post_type_archive_link( 'case_studies' ) ); ?>"
							   class="filter-btn <?php echo ! isset( $_GET['industry'] ) ? 'active' : ''; ?>">
								<?php esc_html_e( 'All Industries', 'aitsc-pro-theme' ); ?>
							</a>
							<?php foreach ( $industries as $industry ) : ?>
								<a href="<?php echo esc_url( add_query_arg( 'industry', urlencode( $industry ), get_post_type_archive_link( 'case_studies' ) ) ); ?>"
								   class="filter-btn <?php echo isset( $_GET['industry'] ) && $_GET['industry'] === $industry ? 'active' : ''; ?>">
									<?php echo esc_html( $industry ); ?>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<div class="case-studies-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<div class="case-study-card">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="case-study-card-image">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'medium_large', array( 'class' => 'case-study-card-thumb' ) ); ?>
								</a>
							</div>
						<?php else : ?>
							<div class="case-study-card-placeholder">
								<a href="<?php the_permalink(); ?>">
									<div class="case-study-placeholder-icon">📋</div>
								</a>
							</div>
						<?php endif; ?>

						<div class="case-study-card-content">
							<?php aitsc_pro_theme_posted_on(); ?>

							<?php
							$client = get_post_meta( get_the_ID(), '_case_study_client', true );
							if ( $client ) :
							?>
								<div class="case-study-card-client">
									<span class="case-study-client-label"><?php esc_html_e( 'Client:', 'aitsc-pro-theme' ); ?></span>
									<span class="case-study-client-name"><?php echo esc_html( $client ); ?></span>
								</div>
							<?php endif; ?>

							<h2 class="case-study-card-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>

							<?php if ( get_the_excerpt() ) : ?>
								<div class="case-study-card-excerpt">
									<?php the_excerpt(); ?>
								</div>
							<?php endif; ?>

							<?php
							// Get custom meta fields
							$industry = get_post_meta( get_the_ID(), '_case_study_industry', true );
							$duration = get_post_meta( get_the_ID(), '_case_study_duration', true );

							if ( $industry || $duration ) :
							?>
								<div class="case-study-card-meta">
									<?php if ( $industry ) : ?>
										<div class="case-study-card-meta-item">
											<span class="case-study-card-meta-label"><?php esc_html_e( 'Industry:', 'aitsc-pro-theme' ); ?></span>
											<span class="case-study-card-meta-value"><?php echo esc_html( $industry ); ?></span>
										</div>
									<?php endif; ?>

									<?php if ( $duration ) : ?>
										<div class="case-study-card-meta-item">
											<span class="case-study-card-meta-label"><?php esc_html_e( 'Duration:', 'aitsc-pro-theme' ); ?></span>
											<span class="case-study-card-meta-value"><?php echo esc_html( $duration ); ?></span>
										</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<?php
							// Get categories
							$categories = get_the_terms( get_the_ID(), 'case_study_category' );
							if ( $categories && ! is_wp_error( $categories ) ) :
							?>
								<div class="case-study-card-categories">
									<?php foreach ( $categories as $category ) : ?>
										<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="case-study-card-category">
											<?php echo esc_html( $category->name ); ?>
										</a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<?php
							// Get technologies
							$technologies = get_post_meta( get_the_ID(), '_case_study_technologies', true );
							if ( $technologies ) :
							?>
								<div class="case-study-card-technologies">
									<span class="case-study-technologies-label"><?php esc_html_e( 'Technologies:', 'aitsc-pro-theme' ); ?></span>
									<span class="case-study-technologies-value"><?php echo esc_html( $technologies ); ?></span>
								</div>
							<?php endif; ?>

							<div class="case-study-card-footer">
								<a href="<?php the_permalink(); ?>" class="case-study-card-link">
									<?php esc_html_e( 'Read Case Study', 'aitsc-pro-theme' ); ?> &rarr;
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
				<h2 class="no-results-title"><?php esc_html_e( 'No Case Studies Found', 'aitsc-pro-theme' ); ?></h2>
				<p class="no-results-message">
					<?php
					if ( is_tax() ) {
						esc_html_e( 'No case studies found in this category. Please try browsing other categories or search for specific projects.', 'aitsc-pro-theme' );
					} else {
						esc_html_e( 'No case studies available at the moment. Please check back soon or contact us for more information about our project portfolio.', 'aitsc-pro-theme' );
					}
					?>
				</p>

				<div class="no-results-actions">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'case_studies' ) ); ?>" class="no-results-link">
						<?php esc_html_e( 'Browse All Case Studies', 'aitsc-pro-theme' ); ?>
					</a>

					<a href="<?php echo esc_url( get_post_type_archive_link( 'solutions' ) ); ?>" class="no-results-link">
						<?php esc_html_e( 'View Solutions', 'aitsc-pro-theme' ); ?>
					</a>

					<?php if ( function_exists( 'aitsc_pro_theme_get_contact_page_url' ) ) : ?>
						<a href="<?php echo esc_url( aitsc_pro_theme_get_contact_page_url() ); ?>" class="no-results-link">
							<?php esc_html_e( 'Contact Us', 'aitsc-pro-theme' ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( is_post_type_archive( 'case_studies' ) ) : ?>
			<section class="case-studies-stats">
				<div class="case-studies-stats-content">
					<h2 class="case-studies-stats-title"><?php esc_html_e( 'Our Impact in Numbers', 'aitsc-pro-theme' ); ?></h2>
					<div class="case-studies-stats-grid">
						<div class="stat-item">
							<div class="stat-number">150+</div>
							<div class="stat-label"><?php esc_html_e( 'Successful Projects', 'aitsc-pro-theme' ); ?></div>
						</div>
						<div class="stat-item">
							<div class="stat-number">50+</div>
							<div class="stat-label"><?php esc_html_e( 'Industries Served', 'aitsc-pro-theme' ); ?></div>
						</div>
						<div class="stat-item">
							<div class="stat-number">98%</div>
							<div class="stat-label"><?php esc_html_e( 'Client Satisfaction', 'aitsc-pro-theme' ); ?></div>
						</div>
						<div class="stat-item">
							<div class="stat-number">24/7</div>
							<div class="stat-label"><?php esc_html_e( 'Support Available', 'aitsc-pro-theme' ); ?></div>
						</div>
					</div>
				</div>
			</section>

			<section class="case-studies-cta">
				<div class="case-studies-cta-content">
					<h2 class="case-studies-cta-title"><?php esc_html_e( 'Ready to Start Your Project?', 'aitsc-pro-theme' ); ?></h2>
					<p class="case-studies-cta-description">
						<?php esc_html_e( 'Join the many organizations that have transformed their safety and compliance with AITSC\'s innovative solutions. Let\'s discuss how we can help achieve your goals.', 'aitsc-pro-theme' ); ?>
					</p>

					<div class="case-studies-cta-actions">
						<?php if ( function_exists( 'aitsc_pro_theme_get_contact_page_url' ) ) : ?>
							<a href="<?php echo esc_url( aitsc_pro_theme_get_contact_page_url() ); ?>" class="case-studies-cta-btn primary">
								<?php esc_html_e( 'Start Your Project', 'aitsc-pro-theme' ); ?>
							</a>
						<?php endif; ?>

						<a href="<?php echo esc_url( get_post_type_archive_link( 'solutions' ) ); ?>" class="case-studies-cta-btn secondary">
							<?php esc_html_e( 'Explore Solutions', 'aitsc-pro-theme' ); ?>
						</a>
					</div>
				</div>
			</section>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>