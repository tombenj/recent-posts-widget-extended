<?php
/**
 * Shortcods
 *
 * @package Posts Extended
 */

/**
 * The shortcode
 *
 * @param array $atts the shortcode attributes.
 * @return mixed
 */
function rposts_shorcode( $atts ) {

	if ( isset( $atts['thumbnail'] ) ) {
		$atts['thumbnail'] = rposts_string_to_boolean( $atts['thumbnail'] );
	}

	$defs = rposts_get_defaults();
	$args = shortcode_atts( $defs, $atts );

	return rposts_get_posts( $args );
}
add_shortcode( 'rpost', 'rposts_shorcode' );
