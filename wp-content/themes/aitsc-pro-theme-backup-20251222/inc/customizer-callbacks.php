<?php
/**
 * Customizer sanitization callbacks
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sanitize hex color
 */
function aitsc_sanitize_hex_color( $color ) {
	if ( '' === $color ) {
		return '';
	}

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}

	return '';
}

/**
 * Sanitize checkbox
 */
function aitsc_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * Sanitize select options
 */
function aitsc_sanitize_select( $input, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Sanitize number within range
 */
function aitsc_sanitize_number_range( $number, $setting ) {
	// Ensure input is an absolute integer.
	$number = absint( $number );

	// Get the input attributes associated with the setting.
	$atts = $setting->manager->get_control( $setting->id )->input_attrs;

	// Get minimum number in the range.
	$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );

	// Get maximum number in the range.
	$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );

	// Get step.
	$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );

	// If the number is within the valid range, return it; otherwise, return the default.
	return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}

/**
 * Sanitize URL
 */
function aitsc_sanitize_url( $url ) {
	return esc_url_raw( $url );
}

/**
 * Sanitize HTML (for textareas)
 */
function aitsc_sanitize_html( $html ) {
	return wp_kses_post( $html );
}

/**
 * Sanitize text
 */
function aitsc_sanitize_text( $text ) {
	return sanitize_text_field( $text );
}

/**
 * Sanitize email
 */
function aitsc_sanitize_email( $email ) {
	return sanitize_email( $email );
}

/**
 * Sanitize integer
 */
function aitsc_sanitize_integer( $int ) {
	return absint( $int );
}
