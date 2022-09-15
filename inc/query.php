<?php
/**
 * The posts query.
 *
 * @package Posts Extended
 */

/**
 * The posts query.
 *
 * @param array $args the query arguments.
 * @return object
 */
function rposts_get_query( $args = array() ) {

	// Merge the input arguments and the defaults.
	$defs = rposts_get_defaults();
	$args = wp_parse_args( $args, $defs );

	// Query arguments.
	$query = array(
		'posts_per_page' => $args['posts_per_page'],
		'post_type'      => $args['post_types'],
	);

	// Perform the query.
	$posts = new WP_Query( $query );

	return $posts;
}
