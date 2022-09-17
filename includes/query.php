<?php
/**
 * The query
 *
 * @package Recent Posts Extended
 */

/**
 * The posts query.
 *
 * @param  array $args the arguments.
 * @return object
 */
function rpwe_get_posts( $args = array() ) {

	// Query arguments.
	$query = array(
		'offset'              => $args['offset'],
		'posts_per_page'      => $args['limit'],
		'orderby'             => $args['orderby'],
		'order'               => $args['order'],
		'post_type'           => $args['post_type'],
		'post_status'         => $args['post_status'],
		'ignore_sticky_posts' => $args['ignore_sticky'],
	);

	// Exclude current post.
	if ( $args['exclude_current'] ) {
		$query['post__not_in'] = array( get_the_ID() );
	}

	// Limit posts based on category.
	if ( ! empty( $args['cat'] ) ) {
		$query['category__in'] = $args['cat'];
	}

	// Limit posts based on post tag.
	if ( ! empty( $args['tag'] ) ) {
		$query['tag__in'] = $args['tag'];
	}

	/**
	 * Taxonomy query.
	 * Prop Miniloop plugin by Kailey Lampert.
	 */
	if ( ! empty( $args['taxonomy'] ) ) {

		parse_str( $args['taxonomy'], $taxes );

		$operator  = 'IN';
		$tax_query = array();
		foreach ( array_keys( $taxes ) as $k => $slug ) {
			$ids = explode( ',', $taxes[ $slug ] );
			if ( count( $ids ) === 1 && $ids['0'] < 0 ) {
				// If there is only one id given, and it's negative
				// Let's treat it as 'posts not in'.
				$ids['0'] = $ids['0'] * -1;
				$operator = 'NOT IN';
			}
			$tax_query[] = array(
				'taxonomy' => $slug,
				'field'    => 'id',
				'terms'    => $ids,
				'operator' => $operator,
			);
		}

		$query['tax_query'] = $tax_query; // phpcs:ignore Standard.Category.SniffName.ErrorCode: slow query ok.
	}

	// Allow plugins/themes developer to filter the default query.
	$query = apply_filters( 'rpwe_default_query_arguments', $query );

	// Perform the query.
	$posts = new WP_Query( $query );

	return $posts;
}
