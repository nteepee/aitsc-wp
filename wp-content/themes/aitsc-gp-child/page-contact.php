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
    <?php
    aitsc_render_hero([
        'variant' => 'page',
        'title' => get_the_title(),
        'subtitle' => 'GET IN TOUCH WITH OUR TEAM',
        'description' => 'Have a project in mind? Let\'s discuss how we can help you achieve your transport safety engineering goals.',
        'height' => 'medium'
    ]);
    ?>

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
