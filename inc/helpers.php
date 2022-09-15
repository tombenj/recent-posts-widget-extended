<?php
/**
 * Helper functions.
 *
 * @package Recent Posts Extended
 */

/**
 * Validate boolean value
 *
 * @param string $input User input.
 * @return bool
 */
function rposts_string_to_boolean( $input ) {
	$allowed_strings = array( '0', '1', 'true', 'false' );
	if ( in_array( $input, $allowed_strings, true ) ) {
		return filter_var( $input, FILTER_VALIDATE_BOOLEAN );
	} else {
		return false;
	}
}
