<?php

/**
 * Function helper
 */

/**
 * Display list of tags for widget.
 *
 * @since  0.9.9.1
 */
function rpwe_tags_list() {

    // Arguments
    $args = array(
        'number' => 99
    );

    // Allow dev to filter the arguments
    $args = apply_filters('rpwe_tags_list_args', $args);

    // Get the tags
    $tags = get_terms('post_tag', $args);

    return $tags;
}

/**
 * Display list of categories for widget.
 *
 * @since  0.9.9.1
 */
function rpwe_cats_list() {

    // Arguments
    $args = array(
        'number' => 99
    );

    // Allow dev to filter the arguments
    $args = apply_filters('rpwe_cats_list_args', $args);

    // Get the cats
    $cats = get_terms('category', $args);

    return $cats;
}
