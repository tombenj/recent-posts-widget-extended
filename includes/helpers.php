<?php
/**
 * Function helper
 *
 * @package Recent Posts Extended
 */

/**
 * Display list of tags for widget.
 */
function rpwe_tags_list() {

	// Arguments.
	$args = array(
		'number' => 99,
	);

	// Allow dev to filter the arguments.
	$args = apply_filters( 'rpwe_tags_list_args', $args );

	// Get the tags.
	$tags = get_terms( 'post_tag', $args );

	return $tags;
}

/**
 * Display list of categories for widget.
 */
function rpwe_cats_list() {

	// Arguments.
	$args = array(
		'number' => 99,
	);

	// Allow dev to filter the arguments.
	$args = apply_filters( 'rpwe_cats_list_args', $args );

	// Get the cats.
	$cats = get_terms( 'category', $args );

	return $cats;
}

/**
 * Validate boolean value
 *
 * @param string $input User input.
 * @return bool
 */
function rpwe_string_to_boolean( $input ) {
	$allowed_strings = array( '0', '1', 'true', 'false' );
	if ( in_array( $input, $allowed_strings, true ) ) {
		return filter_var( $input, FILTER_VALIDATE_BOOLEAN );
	} else {
		return false;
	}
}
