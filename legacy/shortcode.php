<?php

/**
 * Shortcode helper
 */

/**
 * Display recent posts with shortcode.
 *
 * @since  0.9.4
 */
function rpwe_shortcode($atts, $content) {
    if (isset($atts['cssid'])) {
        $atts['cssID'] = $atts['cssid'];
        unset($atts['cssid']);
    }

    if (isset($atts['cat'])) {
        $atts['cat'] = '';
    }

    if (isset($atts['tag'])) {
        $atts['tag'] = '';
    }

    $args = shortcode_atts(rpwe_get_default_args(), $atts);
    return rpwe_get_recent_posts($args);
}
add_shortcode('rpwe', 'rpwe_shortcode');
