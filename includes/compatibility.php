<?php
/**
 * Compatibility with 3rd party plugins.
 *
 * @package Recent Posts Extended
 */

/**
 * Tell siteorigin page builder the new widget Class name.
 */
add_filter(
	'siteorigin_panels_widget_object',
	function( $the_widget, $widget_class ) {
		if ( 'Recent_Posts_Widget_Extended' === $widget_class ) {
			global $wp_widget_factory;
			if ( isset( $wp_widget_factory->widgets['RPWE_Widget'] ) ) {
				$the_widget = $wp_widget_factory->widgets['RPWE_Widget'];
			}
		}

		return $the_widget;
	},
	10,
	2
);

/**
 * Enqueue custom JS for the Siteorigin page builder.
 */
add_action(
	'siteorigin_panel_enqueue_admin_scripts',
	function() {
		wp_enqueue_script( 'rpwe-siteorigin', RPWE_URL . 'assets/js/rpwe-siteorigin.js', array( 'jquery' ), RPWE_VERSION, true );
		wp_enqueue_style( 'rpwe-admin-style', RPWE_URL . 'assets/css/rpwe-admin.css', null, RPWE_VERSION );
	}
);
