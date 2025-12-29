<?php
/**
 * Template for displaying single solutions
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

get_header(); ?>

<main id="primary" class="site-main">
	<div class="container">
		<div class="solution-single">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'solution-article' ); ?>>
					<header class="solution-header">
						<div class="solution-header-top">
							<?php if ( function_exists( 'get_the_post_thumbnail' ) && has_post_thumbnail() ) : ?>
								<div class="solution-hero-image">
									<?php the_post_thumbnail( 'full', array( 'class' => 'solution-hero' ) ); ?>
								</div>
							<?php endif; ?>

							<div class="solution-title-section">
								<?php aitsc_pro_theme_posted_on(); ?>
								<h1 class="solution-title"><?php the_title(); ?></h1>
								<?php if ( get_the_excerpt() ) : ?>
									<p class="solution-excerpt"><?php the_excerpt(); ?></p>
								<?php endif; ?>
							</div>
						</div>
					</header>

					<div class="solution-content-wrapper">
						<div class="solution-content-main">
							<div class="solution-content">
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
							$industry = get_post_meta( get_the_ID(), '_solution_industry', true );
							$technologies = get_post_meta( get_the_ID(), '_solution_technologies', true );
							$key_features = get_post_meta( get_the_ID(), '_solution_key_features', true );

							if ( $industry || $technologies || $key_features ) :
							?>
								<div class="solution-details">
									<h3 class="solution-details-title"><?php esc_html_e( 'Solution Details', 'aitsc-pro-theme' ); ?></h3>

									<div class="solution-details-grid">
										<?php if ( $industry ) : ?>
											<div class="solution-detail-item">
												<h4 class="solution-detail-label"><?php esc_html_e( 'Industry:', 'aitsc-pro-theme' ); ?></h4>
												<p class="solution-detail-value"><?php echo esc_html( $industry ); ?></p>
											</div>
										<?php endif; ?>

										<?php if ( $technologies ) : ?>
											<div class="solution-detail-item">
												<h4 class="solution-detail-label"><?php esc_html_e( 'Technologies:', 'aitsc-pro-theme' ); ?></h4>
												<p class="solution-detail-value"><?php echo esc_html( $technologies ); ?></p>
											</div>
										<?php endif; ?>

										<?php if ( $key_features ) : ?>
											<div class="solution-detail-item">
												<h4 class="solution-detail-label"><?php esc_html_e( 'Key Features:', 'aitsc-pro-theme' ); ?></h4>
												<div class="solution-detail-value">
													<?php echo wpautop( esc_textarea( $key_features ) ); ?>
												</div>
											</div>
										<?php endif; ?>
									</div>
								</div>
							<?php endif; ?>
						</div>

						<aside class="solution-sidebar">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="solution-thumbnail">
									<?php the_post_thumbnail( 'medium_large', array( 'class' => 'solution-thumb' ) ); ?>
								</div>
							<?php endif; ?>

							<?php
							// Get categories and tags
							$categories = get_the_terms( get_the_ID(), 'solution_category' );
							$tags = get_the_terms( get_the_ID(), 'solution_tag' );
							?>

							<?php if ( $categories ) : ?>
								<div class="solution-categories">
									<h4 class="solution-sidebar-title"><?php esc_html_e( 'Categories', 'aitsc-pro-theme' ); ?></h4>
									<div class="solution-category-list">
										<?php foreach ( $categories as $category ) : ?>
											<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="solution-category-link">
												<?php echo esc_html( $category->name ); ?>
											</a>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( $tags ) : ?>
								<div class="solution-tags">
									<h4 class="solution-sidebar-title"><?php esc_html_e( 'Tags', 'aitsc-pro-theme' ); ?></h4>
									<div class="solution-tag-list">
										<?php foreach ( $tags as $tag ) : ?>
											<a href="<?php echo esc_url( get_term_link( $tag ) ); ?>" class="solution-tag-link">
												<?php echo esc_html( $tag->name ); ?>
											</a>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>

							<div class="solution-actions">
								<a href="<?php echo esc_url( get_post_type_archive_link( 'solutions' ) ); ?>" class="solution-back-link">
									&larr; <?php esc_html_e( 'Back to Solutions', 'aitsc-pro-theme' ); ?>
								</a>

								<?php if ( function_exists( 'aitsc_pro_theme_get_contact_page_url' ) ) : ?>
									<a href="<?php echo esc_url( aitsc_pro_theme_get_contact_page_url() ); ?>" class="solution-contact-btn">
										<?php esc_html_e( 'Request Demo', 'aitsc-pro-theme' ); ?>
									</a>
								<?php endif; ?>
							</div>
						</aside>
					</div>

					<footer class="solution-footer">
						<div class="solution-navigation">
							<div class="solution-nav-prev">
								<?php previous_post_link( '%link', '<span class="solution-nav-label">' . esc_html__( 'Previous Solution', 'aitsc-pro-theme' ) . '</span> %title' ); ?>
							</div>
							<div class="solution-nav-next">
								<?php next_post_link( '%link', '<span class="solution-nav-label">' . esc_html__( 'Next Solution', 'aitsc-pro-theme' ) . '</span> %title' ); ?>
							</div>
						</div>
					</footer>
				</article>

				<?php
				// Related solutions
				$related_solutions = aitsc_get_related_solutions( get_the_ID() );
				if ( $related_solutions ) :
				?>
					<section class="related-solutions">
						<h2 class="related-solutions-title"><?php esc_html_e( 'Related Solutions', 'aitsc-pro-theme' ); ?></h2>
						<div class="related-solutions-grid">
							<?php foreach ( $related_solutions as $related_solution ) : ?>
								<div class="related-solution-card">
									<?php if ( has_post_thumbnail( $related_solution->ID ) ) : ?>
										<div class="related-solution-image">
											<a href="<?php echo esc_url( get_permalink( $related_solution->ID ) ); ?>">
												<?php echo get_the_post_thumbnail( $related_solution->ID, 'medium', array( 'class' => 'related-solution-thumb' ) ); ?>
											</a>
										</div>
									<?php endif; ?>

									<div class="related-solution-content">
										<h3 class="related-solution-title">
											<a href="<?php echo esc_url( get_permalink( $related_solution->ID ) ); ?>">
												<?php echo esc_html( get_the_title( $related_solution->ID ) ); ?>
											</a>
										</h3>

										<?php if ( get_the_excerpt( $related_solution->ID ) ) : ?>
											<p class="related-solution-excerpt"><?php echo get_the_excerpt( $related_solution->ID ); ?></p>
										<?php endif; ?>

										<a href="<?php echo esc_url( get_permalink( $related_solution->ID ) ); ?>" class="related-solution-link">
											<?php esc_html_e( 'Learn More', 'aitsc-pro-theme' ); ?> &rarr;
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