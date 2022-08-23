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
	$defs = rposts_get_defaults();
	$args = shortcode_atts( $defs, $atts );

	return rposts_get_posts( $args );
}
add_shortcode( 'rpost', 'rposts_shorcode' );
