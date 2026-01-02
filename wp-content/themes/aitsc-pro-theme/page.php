<?php
/**
 * The template for displaying all single pages
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php
    while (have_posts()):
        the_post();
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- Page Hero - Standardized -->
            <?php
            aitsc_render_hero([
                'variant' => 'page',
                'title' => get_the_title(),
                'subtitle' => ' ', // Optional or dynamic based on post meta
                'description' => get_the_excerpt() ?: '',
                'height' => 'medium'
            ]);
            ?>

            <div class="page-content-wrapper full-width">
                <div class="container">
                    <div class="entry-content section">
                        <?php
                        the_content();

                        wp_link_pages(
                            array(
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'aitsc-pro-theme'),
                                'after' => '</div>',
                            )
                        );
                        ?>
                    </div>
                </div>

        </article><!-- #post-<?php the_ID(); ?> -->

        <?php
    endwhile; // End of the loop.
    ?>

</main><!-- #primary -->

<?php
get_footer();
