<?php
/**
 * Template for displaying single case studies
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

get_header(); ?>

<main id="primary" class="site-main">
	<div class="container">
		<div class="case-study-single">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'case-study-article' ); ?>>
					<header class="case-study-header">
						<div class="case-study-header-top">
							<?php if ( function_exists( 'get_the_post_thumbnail' ) && has_post_thumbnail() ) : ?>
								<div class="case-study-hero-image">
									<?php the_post_thumbnail( 'full', array( 'class' => 'case-study-hero' ) ); ?>
								</div>
							<?php endif; ?>

							<div class="case-study-title-section">
								<?php aitsc_pro_theme_posted_on(); ?>
								<h1 class="case-study-title"><?php the_title(); ?></h1>
								<?php if ( get_the_excerpt() ) : ?>
									<p class="case-study-excerpt"><?php the_excerpt(); ?></p>
								<?php endif; ?>
							</div>
						</div>
					</header>

					<div class="case-study-content-wrapper">
						<div class="case-study-content-main">
							<div class="case-study-content">
								<?php
								the_content();
								wp_link_pages(
									array(
										'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'aitsc-pro-theme' ) . '</span>',
										'after'  => '</div>',
									)
								);
								?>
							</div>

							<?php
							// Get custom meta fields
							$client = get_post_meta( get_the_ID(), '_case_study_client', true );
							$industry = get_post_meta( get_the_ID(), '_case_study_industry', true );
							$duration = get_post_meta( get_the_ID(), '_case_study_duration', true );
							$technologies = get_post_meta( get_the_ID(), '_case_study_technologies', true );
							$results = get_post_meta( get_the_ID(), '_case_study_results', true );

							if ( $client || $industry || $duration || $technologies || $results ) :
							?>
								<div class="case-study-details">
									<h3 class="case-study-details-title"><?php esc_html_e( 'Project Details', 'aitsc-pro-theme' ); ?></h3>

									<div class="case-study-details-grid">
										<?php if ( $client ) : ?>
											<div class="case-study-detail-item">
												<h4 class="case-study-detail-label"><?php esc_html_e( 'Client:', 'aitsc-pro-theme' ); ?></h4>
												<p class="case-study-detail-value"><?php echo esc_html( $client ); ?></p>
											</div>
										<?php endif; ?>

										<?php if ( $industry ) : ?>
											<div class="case-study-detail-item">
												<h4 class="case-study-detail-label"><?php esc_html_e( 'Industry:', 'aitsc-pro-theme' ); ?></h4>
												<p class="case-study-detail-value"><?php echo esc_html( $industry ); ?></p>
											</div>
										<?php endif; ?>

										<?php if ( $duration ) : ?>
											<div class="case-study-detail-item">
												<h4 class="case-study-detail-label"><?php esc_html_e( 'Project Duration:', 'aitsc-pro-theme' ); ?></h4>
												<p class="case-study-detail-value"><?php echo esc_html( $duration ); ?></p>
											</div>
										<?php endif; ?>

										<?php if ( $technologies ) : ?>
											<div class="case-study-detail-item">
												<h4 class="case-study-detail-label"><?php esc_html_e( 'Technologies Used:', 'aitsc-pro-theme' ); ?></h4>
												<p class="case-study-detail-value"><?php echo esc_html( $technologies ); ?></p>
											</div>
										<?php endif; ?>

										<?php if ( $results ) : ?>
											<div class="case-study-detail-item case-study-detail-full">
												<h4 class="case-study-detail-label"><?php esc_html_e( 'Key Results:', 'aitsc-pro-theme' ); ?></h4>
												<div class="case-study-detail-value">
													<?php echo wpautop( esc_textarea( $results ) ); ?>
												</div>
											</div>
										<?php endif; ?>
									</div>
								</div>
							<?php endif; ?>
						</div>

						<aside class="case-study-sidebar">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="case-study-thumbnail">
									<?php the_post_thumbnail( 'medium_large', array( 'class' => 'case-study-thumb' ) ); ?>
								</div>
							<?php endif; ?>

							<?php
							// Get categories and tags
							$categories = get_the_terms( get_the_ID(), 'case_study_category' );
							$tags = get_the_terms( get_the_ID(), 'case_study_tag' );
							?>

							<?php if ( $categories ) : ?>
								<div class="case-study-categories">
									<h4 class="case-study-sidebar-title"><?php esc_html_e( 'Categories', 'aitsc-pro-theme' ); ?></h4>
									<div class="case-study-category-list">
										<?php foreach ( $categories as $category ) : ?>
											<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="case-study-category-link">
												<?php echo esc_html( $category->name ); ?>
											</a>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( $tags ) : ?>
								<div class="case-study-tags">
									<h4 class="case-study-sidebar-title"><?php esc_html_e( 'Tags', 'aitsc-pro-theme' ); ?></h4>
									<div class="case-study-tag-list">
										<?php foreach ( $tags as $tag ) : ?>
											<a href="<?php echo esc_url( get_term_link( $tag ) ); ?>" class="case-study-tag-link">
												<?php echo esc_html( $tag->name ); ?>
											</a>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>

							<div class="case-study-actions">
								<a href="<?php echo esc_url( get_post_type_archive_link( 'case_studies' ) ); ?>" class="case-study-back-link">
									&larr; <?php esc_html_e( 'Back to Case Studies', 'aitsc-pro-theme' ); ?>
								</a>

								<?php if ( function_exists( 'aitsc_pro_theme_get_contact_page_url' ) ) : ?>
									<a href="<?php echo esc_url( aitsc_pro_theme_get_contact_page_url() ); ?>" class="case-study-contact-btn">
										<?php esc_html_e( 'Similar Project?', 'aitsc-pro-theme' ); ?>
									</a>
								<?php endif; ?>

								<a href="<?php echo esc_url( get_post_type_archive_link( 'solutions' ) ); ?>" class="case-study-solutions-link">
									<?php esc_html_e( 'View Solutions', 'aitsc-pro-theme' ); ?>
								</a>
							</div>
						</aside>
					</div>

					<footer class="case-study-footer">
						<div class="case-study-navigation">
							<div class="case-study-nav-prev">
								<?php previous_post_link( '%link', '<span class="case-study-nav-label">' . esc_html__( 'Previous Case Study', 'aitsc-pro-theme' ) . '</span> %title' ); ?>
							</div>
							<div class="case-study-nav-next">
								<?php next_post_link( '%link', '<span class="case-study-nav-label">' . esc_html__( 'Next Case Study', 'aitsc-pro-theme' ) . '</span> %title' ); ?>
							</div>
						</div>
					</footer>
				</article>

				<?php
				// Related case studies
				$related_case_studies = aitsc_get_related_case_studies( get_the_ID() );
				if ( $related_case_studies ) :
				?>
					<section class="related-case-studies">
						<h2 class="related-case-studies-title"><?php esc_html_e( 'Related Case Studies', 'aitsc-pro-theme' ); ?></h2>
						<div class="related-case-studies-grid">
							<?php foreach ( $related_case_studies as $related_case_study ) : ?>
								<div class="related-case-study-card">
									<?php if ( has_post_thumbnail( $related_case_study->ID ) ) : ?>
										<div class="related-case-study-image">
											<a href="<?php echo esc_url( get_permalink( $related_case_study->ID ) ); ?>">
												<?php echo get_the_post_thumbnail( $related_case_study->ID, 'medium', array( 'class' => 'related-case-study-thumb' ) ); ?>
											</a>
										</div>
									<?php endif; ?>

									<div class="related-case-study-content">
										<h3 class="related-case-study-title">
											<a href="<?php echo esc_url( get_permalink( $related_case_study->ID ) ); ?>">
												<?php echo esc_html( get_the_title( $related_case_study->ID ) ); ?>
											</a>
										</h3>

										<?php
										$related_client = get_post_meta( $related_case_study->ID, '_case_study_client', true );
										if ( $related_client ) :
										?>
											<p class="related-case-study-client">
												<?php esc_html_e( 'Client:', 'aitsc-pro-theme' ); ?> <?php echo esc_html( $related_client ); ?>
											</p>
										<?php endif; ?>

										<?php if ( get_the_excerpt( $related_case_study->ID ) ) : ?>
											<p class="related-case-study-excerpt"><?php echo get_the_excerpt( $related_case_study->ID ); ?></p>
										<?php endif; ?>

										<a href="<?php echo esc_url( get_permalink( $related_case_study->ID ) ); ?>" class="related-case-study-link">
											<?php esc_html_e( 'Read Case Study', 'aitsc-pro-theme' ); ?> &rarr;
										</a>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</section>
				<?php endif; ?>

				<?php comments_template(); ?>

			<?php endwhile; ?>
		</div>
	</div>
</main>

<?php get_footer(); ?>