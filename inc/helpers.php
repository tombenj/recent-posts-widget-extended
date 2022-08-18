<?php
/**
 * Helpers functions
 *
 * @package Posts Extended
 */

/**
 * Sets default value.
 *
 * @return array
 */
function rposts_get_defaults() {
	$defaults = array(
		'title'     => __( 'Recent Posts', 'recent-posts-widget-extended' ),
		'title_url' => '',
	);

	// Allows developer to filter the default arguments.
	return apply_filters( 'rposts_get_defaults', $defaults );
}

/**
 * Display the posts.
 *
 * @param array $args User input.
 * @return mixed
 */
function rposts_display( $args = array() ) {

	// Merge the input arguments and the defaults.
	$defaults = rposts_get_defaults();
	$args     = wp_parse_args( $args, $defaults );

	// Set up a default, empty variable.
	$html = '';

	return $html;
}
