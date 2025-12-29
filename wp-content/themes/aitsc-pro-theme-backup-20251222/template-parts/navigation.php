<?php
/**
 * Navigation template part for AITSC Pro Theme
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'aitsc-pro-theme' ); ?>">
    <div class="container">
        <div class="navigation-wrapper">
            <div class="site-branding">
                <?php
                if ( has_custom_logo() ) :
                    the_custom_logo();
                else :
                    if ( is_front_page() && is_home() ) :
                        ?>
                        <h1 class="site-title">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <?php bloginfo( 'name' ); ?>
                            </a>
                        </h1>
                        <?php
                    else :
                        ?>
                        <p class="site-title">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <?php bloginfo( 'name' ); ?>
                            </a>
                        </p>
                        <?php
                    endif;

                    $description = get_bloginfo( 'description', 'display' );
                    if ( $description || is_customize_preview() ) :
                        ?>
                        <p class="site-description"><?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                        <?php
                    endif;
                endif;
                ?>
            </div><!-- .site-branding -->

            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle menu', 'aitsc-pro-theme' ); ?>">
                <span class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                <span class="menu-text"><?php esc_html_e( 'Menu', 'aitsc-pro-theme' ); ?></span>
            </button>

            <div class="primary-menu-container">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'primary-menu',
                        'container'      => false,
                        'fallback_cb'    => 'aitsc_fallback_menu',
                    )
                );
                ?>
            </div>

            <!-- Dark Mode Toggle -->
            <button class="theme-toggle" data-theme-toggle aria-label="Toggle dark mode">
                <span class="theme-icon" aria-hidden="true">🌙</span>
            </button>
        </div>
    </div>
</nav><!-- #site-navigation -->

<?php
/**
 * Fallback menu callback
 */
function aitsc_fallback_menu() {
	?>
	<ul id="primary-menu" class="primary-menu">
		<li class="menu-item">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'aitsc-pro-theme' ); ?></a>
		</li>
		<li class="menu-item">
			<a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'About', 'aitsc-pro-theme' ); ?></a>
		</li>
		<li class="menu-item">
			<a href="<?php echo esc_url( home_url( '/solutions' ) ); ?>"><?php esc_html_e( 'Solutions', 'aitsc-pro-theme' ); ?></a>
		</li>
		<li class="menu-item">
			<a href="<?php echo esc_url( home_url( '/case-studies' ) ); ?>"><?php esc_html_e( 'Case Studies', 'aitsc-pro-theme' ); ?></a>
		</li>
		<li class="menu-item">
			<a href="<?php echo esc_url( home_url( '/blog' ) ); ?>"><?php esc_html_e( 'Blog', 'aitsc-pro-theme' ); ?></a>
		</li>
		<li class="menu-item">
			<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contact', 'aitsc-pro-theme' ); ?></a>
		</li>
	</ul>
	<?php
}
?>