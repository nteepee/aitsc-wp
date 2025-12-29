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

            <!-- Page Hero - Full Width -->
            <header class="page-hero full-width">
                <div class="container">
                    <?php the_title('<h1 class="page-hero-title">', '</h1>'); ?>
                </div>
            </header>

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

<style>
    /* Local Critical CSS for Pages */
    .entry-header {
        padding-top: var(--space-32);
        background-color: var(--wq-black);
        border-bottom: 1px solid var(--wq-border);
        padding-bottom: var(--space-8);
    }

    .page-title {
        font-size: var(--text-5xl);
        text-transform: uppercase;
        color: var(--wq-text-white);
    }

    .entry-content {
        color: var(--wq-text-grey);
        font-size: var(--text-lg);
        line-height: 1.8;
    }

    .entry-content h2,
    .entry-content h3 {
        color: var(--wq-text-white);
        margin-top: var(--space-8);
        margin-bottom: var(--space-4);
    }

    .entry-content ul {
        margin-bottom: var(--space-6);
        padding-left: var(--space-6);
    }

    .entry-content li {
        margin-bottom: var(--space-2);
    }
</style>

<?php
get_footer();
