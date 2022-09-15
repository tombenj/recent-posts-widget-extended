<?php
/**
 * Shortcods
 *
 * @package Recent Posts Extended
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

	if ( isset( $atts['content_title_link'] ) ) {
		$atts['content_title_link'] = rposts_string_to_boolean( $atts['content_title_link'] );
	}

	$defs = rposts_get_defaults();
	$args = shortcode_atts( $defs, $atts );

	return rposts_get_posts( $args );
}
add_shortcode( 'rposts', 'rposts_shorcode' );
