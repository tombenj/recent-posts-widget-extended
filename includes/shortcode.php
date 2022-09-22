<?php
/**
 * Shortcode helper
 *
 * @package Recent Posts Extended
 */

/**
 * Recent posts shortcode.
 *
 * @param array $atts the arguments.
 * @return string|array The HTML for the posts.
 */
function rpwe_shortcode( $atts ) {

	// Breaking changes from version 1.x.x to 2.0.
	if ( isset( $atts['cssid'] ) ) {
		$atts['css_id'] = $atts['cssid'];
	} elseif ( isset( $atts['cssID'] ) ) {
		$atts['css_id'] = $atts['cssID'];
	}

	// Convert string to boolean.
	$attr_strings = array( 'excerpt', 'thumb', 'date', 'date_relative', 'date_modified', 'readmore', 'comment_count', 'post_title', 'link_target', 'styles_default' );
	foreach ( $attr_strings as $attr ) {
		if ( isset( $atts[ $attr ] ) ) {
			$atts[ $attr ] = rpwe_string_to_boolean( $atts[ $attr ] );
		}
	}

	// Merge the default arguments with the shortcode attributes.
	$atts = shortcode_atts( rpwe_get_default_args(), $atts );

	// load default style.
	if ( $atts['styles_default'] ) {
		wp_enqueue_style( 'rpwe-style' );
	}

	return rpwe_get_recent_posts( $atts );
}
add_shortcode( 'rpwe', 'rpwe_shortcode' );
