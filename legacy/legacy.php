<?php
/**
 * Legacy
 *
 * @package Posts Extended
 */

/**
 * Load legacy files.
 */
require_once 'functions.php';
require_once 'shortcode.php';
require_once 'helpers.php';

/**
 * Load the custom widgets.
 */
add_action(
	'widgets_init',
	function () {
		require_once 'widget.php';
		register_widget( 'Recent_Posts_Widget_Extended' );
	}
);

/**
 * Load the custom style.
 */
add_action(
	'admin_enqueue_scripts',
	function () {
		wp_enqueue_style( 'rpwe-admin-style', plugin_dir_url( __FILE__ ) . 'rpwe-admin.css', null, RP_VERSION );
	}
);
