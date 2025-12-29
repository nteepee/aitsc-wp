<?php
/**
 * Custom template tags for this theme
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Display navigation to next/previous post when applicable
 */
function aitsc_post_navigation() {
	the_post_navigation( array(
		'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'aitsc-pro-theme' ) . '</span> <span class="nav-title">%title</span>',
		'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'aitsc-pro-theme' ) . '</span> <span class="nav-title">%title</span>',
	) );
}

/**
 * Display posted on date
 */
function aitsc_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() )
	);

	printf(
		'<span class="posted-on">%s</span>',
		$time_string
	);
}

/**
 * Display post author
 */
function aitsc_posted_by() {
	printf(
		'<span class="byline">%s <a class="url fn n" href="%s">%s</a></span>',
		esc_html__( 'by', 'aitsc-pro-theme' ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);
}

/**
 * Get related solutions for single solution pages
 */
function aitsc_get_related_solutions( $post_id ) {
	$count = get_theme_mod( 'aitsc_related_solutions_count', 3 );

	// Get categories of current solution
	$categories = get_the_terms( $post_id, 'solution_category' );
	$category_ids = array();

	if ( $categories && ! is_wp_error( $categories ) ) {
		foreach ( $categories as $category ) {
			$category_ids[] = $category->term_id;
		}
	}

	$args = array(
		'post_type'      => 'solutions',
		'post_status'    => 'publish',
		'posts_per_page' => $count,
		'post__not_in'   => array( $post_id ),
		'orderby'        => 'rand',
	);

	// If solution has categories, get solutions from same categories
	if ( ! empty( $category_ids ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'solution_category',
				'field'    => 'term_id',
				'terms'    => $category_ids,
			)
		);
	}

	$related_query = new WP_Query( $args );

	if ( $related_query->have_posts() ) {
		return $related_query->get_posts();
	}

	return false;
}

/**
 * Get related case studies for single case study pages
 */
function aitsc_get_related_case_studies( $post_id ) {
	$count = get_theme_mod( 'aitsc_related_case_studies_count', 3 );

	// Get categories of current case study
	$categories = get_the_terms( $post_id, 'case_study_category' );
	$category_ids = array();

	if ( $categories && ! is_wp_error( $categories ) ) {
		foreach ( $categories as $category ) {
			$category_ids[] = $category->term_id;
		}
	}

	$args = array(
		'post_type'      => 'case_studies',
		'post_status'    => 'publish',
		'posts_per_page' => $count,
		'post__not_in'   => array( $post_id ),
		'orderby'        => 'rand',
	);

	// If case study has categories, get case studies from same categories
	if ( ! empty( $category_ids ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'case_study_category',
				'field'    => 'term_id',
				'terms'    => $category_ids,
			)
		);
	}

	$related_query = new WP_Query( $args );

	if ( $related_query->have_posts() ) {
		return $related_query->get_posts();
	}

	return false;
}

/**
 * Get featured solutions for homepage
 */
function aitsc_get_featured_solutions() {
	$count = get_theme_mod( 'aitsc_solutions_homepage_count', 6 );

	$args = array(
		'post_type'      => 'solutions',
		'post_status'    => 'publish',
		'posts_per_page' => $count,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	$featured_query = new WP_Query( $args );

	if ( $featured_query->have_posts() ) {
		return $featured_query;
	}

	return false;
}

/**
 * Get featured case studies for homepage
 */
function aitsc_get_featured_case_studies() {
	$count = get_theme_mod( 'aitsc_case_studies_homepage_count', 3 );

	$args = array(
		'post_type'      => 'case_studies',
		'post_status'    => 'publish',
		'posts_per_page' => $count,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	$featured_query = new WP_Query( $args );

	if ( $featured_query->have_posts() ) {
		return $featured_query;
	}

	return false;
}

/**
 * Get contact page URL
 */
function aitsc_pro_theme_get_contact_page_url() {
	$contact_page = get_page_by_path( 'contact' );
	if ( $contact_page ) {
		return get_permalink( $contact_page->ID );
	}

	// Try to find a page with 'contact' in the title
	$contact_pages = get_pages( array(
		'meta_key'    => '_wp_page_template',
		'meta_value'  => 'template-contact.php',
		'number'       => 1,
	) );

	if ( ! empty( $contact_pages ) ) {
		return get_permalink( $contact_pages[0]->ID );
	}

	return '#'; // fallback
}

/**
 * Display entry footer with categories and tags
 */
function aitsc_entry_footer() {
	if ( 'post' === get_post_type() ) {
		$categories_list = get_the_category_list( esc_html__( ', ', 'aitsc-pro-theme' ) );
		if ( $categories_list ) {
			printf( '<span class="cat-links">%s %s</span>', esc_html__( 'Posted in', 'aitsc-pro-theme' ), $categories_list );
		}

		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'aitsc-pro-theme' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">%s %s</span>', esc_html__( 'Tagged', 'aitsc-pro-theme' ), $tags_list );
		}
	}

	edit_post_link(
		sprintf(
			wp_kses(
				__( 'Edit <span class="screen-reader-text">%s</span>', 'aitsc-pro-theme' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			wp_kses_post( get_the_title() )
		),
		'<span class="edit-link">',
		'</span>'
	);
}

/**
 * Get primary color from theme mod
 */
function aitsc_get_primary_color() {
	return get_theme_mod( 'aitsc_primary_color', '#005cb2' );
}

/**
 * Get accent neon color from theme mod
 */
function aitsc_get_accent_neon() {
	return get_theme_mod( 'aitsc_accent_neon', '#00e128' );
}

/**
 * Get font family from theme mod
 */
function aitsc_get_font_family() {
	$font_family = get_theme_mod( 'aitsc_font_family', 'inter' );

	$fonts = array(
		'inter'    => "'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif",
		'gt-eesti' => "'GT Eesti Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif",
		'manrope'  => "'Manrope', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif",
		'dm-sans'  => "'DM Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif",
		'system'   => "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif",
	);

	return isset( $fonts[ $font_family ] ) ? $fonts[ $font_family ] : $fonts['inter'];
}
