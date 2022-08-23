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
	// Query arguments.
	$query = array(
		'posts_per_page' => 1,
		'post_type'      => 'post',
	);

	// Perform the query.
	$posts = new WP_Query( $query );

	return $posts;
}
