<?php
/**
 * Template Name: Contact Page (Advanced)
 *
 * @package AITSC_Pro_Theme
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- Page Hero -->
    <header class="page-hero full-width" style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8));">
        <div class="container">
            <?php the_title('<h1 class="aitsc-hero__title aitsc-hero__title--standard">', '</h1>'); ?>
        </div>
    </header>

    <div class="page-content-wrapper full-width">
        <div class="container">
            <?php
            // Load the advanced contact form template part
            get_template_part('template-parts/contact-form-advanced');
            ?>
        </div>
    </div>

</main><!-- #primary -->

<?php
get_footer();
