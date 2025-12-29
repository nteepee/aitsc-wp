<?php
/**
 * Theme Toggle Template Part
 * Enhanced dark mode toggle with full accessibility support
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$dark_mode_label = __( 'Toggle dark mode', 'aitsc-pro-theme' );
$light_mode_label = __( 'Toggle light mode', 'aitsc-pro-theme' );
$current_theme = isset( $_COOKIE['aitsc-theme'] ) ? $_COOKIE['aitsc-theme'] :
                  ( isset( $_SERVER['HTTP_USER_AGENT'] ) && preg_match( '/dark/i', $_SERVER['HTTP_USER_AGENT'] ) ? 'dark' : 'light' );

// Determine current icon and label based on theme
$icon_class = $current_theme === 'dark' ? 'sun-icon' : 'moon-icon';
$icon_emoji = $current_theme === 'dark' ? '☀️' : '🌙';
$toggle_label = $current_theme === 'dark' ? $light_mode_label : $dark_mode_label;
$aria_pressed = $current_theme === 'dark' ? 'true' : 'false';
$aria_label = sprintf(
	/* translators: %s: current theme (light or dark) */
	__( 'Current theme: %s. Click to toggle.', 'aitsc-pro-theme' ),
	$current_theme
);
?>

<button
	class="theme-toggle"
	data-theme-toggle
	role="switch"
	aria-checked="<?php echo esc_attr( $aria_pressed ); ?>"
	aria-label="<?php echo esc_attr( $aria_label ); ?>"
	title="<?php echo esc_attr( $toggle_label ); ?>"
	type="button"
	tabindex="0"
>
	<span class="theme-icon <?php echo esc_attr( $icon_class ); ?>"
		  aria-hidden="true"
		  role="img">
		<?php echo esc_html( $icon_emoji ); ?>
	</span>
	<span class="sr-only">
		<?php echo esc_html( $toggle_label ); ?>
	</span>
</button>