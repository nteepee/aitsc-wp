<?php
/**
 * The main template file
 *
 * @package AITSC_Pro_Theme
 */

get_header();
?>

<div id="primary" class="site-content blog-index-page">
    <div class="container">

        <!-- Blog Header Section -->
        <header class="blog-header py-5 mb-5 text-center">
            <h1 class="wq-section-title animate-slide-up">Insights & News</h1>
            <p class="wq-subtitle animate-slide-up delay-1">Expert analysis and updates for the fleet industry.</p>
        </header>

        <div class="blog-layout-grid">

            <!-- Main Content Area -->
            <main id="main" class="site-main blog-feed">
                <?php if (have_posts()): ?>
                    <div class="posts-grid-wrapper">
                        <?php
                        while (have_posts()):
                            the_post();
                            get_template_part('template-parts/content', get_post_type());
                        endwhile;
                        ?>
                    </div>

                    <?php
                    the_posts_pagination(array(
                        'prev_text' => '<span class="material-symbols-outlined">chevron_left</span>',
                        'next_text' => '<span class="material-symbols-outlined">chevron_right</span>',
                        'mid_size' => 2,
                    ));
                    ?>

                <?php else: ?>
                    <?php get_template_part('template-parts/content', 'none'); ?>
                <?php endif; ?>
            </main><!-- #main -->

            <!-- Sidebar Area -->
            <?php get_sidebar(); ?>

        </div><!-- .blog-layout-grid -->

    </div><!-- .container -->
</div><!-- #primary -->

<?php
get_footer();