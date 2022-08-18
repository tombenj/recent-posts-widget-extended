<?php

/**
 * Legacy
 */

require_once('resizer.php');
require_once('functions.php');
require_once('shortcode.php');
require_once('helpers.php');

add_action(
    'widgets_init',
    function () {
        require_once('widget.php');
        register_widget('Recent_Posts_Widget_Extended');
    }
);

add_action(
    'admin_enqueue_scripts',
    function () {
        wp_enqueue_style('rpwe-admin-style', plugin_dir_url(__FILE__) . 'rpwe-admin.css', null, null);
    }
);
