<?php
/**
 * Plugin Name:       Recent Posts Widget Extended
 * Plugin URI:        https://github.com/gasatrya/recent-posts-widget-extended
 * Description:       Enables advanced widget & shortcode that gives you total control over the output of your site’s most recent Posts.
 * Version:           2.0.2
 * Requires at least: 5.8
 * Requires PHP:      7.2
 * Author:            Ga Satrya
 * Author URI:        https://gasatrya.dev/
 * License:           GPL v3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       recent-posts-widget-extended
 * Domain Path:       /languages
 *
 * @package Recent Posts Extended
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RPWE_VERSION', '2.0.2' );
define( 'RPWE_PATH', plugin_dir_path( __FILE__ ) );
define( 'RPWE_URL', plugin_dir_url( __FILE__ ) );

// Loads plugin files.
$rpwe_includes = RPWE_PATH . 'includes/*.php';
foreach ( glob( $rpwe_includes ) as $file ) {
	require_once $file;
}

// Loads plugin classes.
require_once RPWE_PATH . 'classes/class-image-resizer.php';

/**
 * Language
 */
function rpwe_i18n() {
	load_plugin_textdomain( 'recent-posts-widget-extended', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'rpwe_i18n' );

/**
 * Widget register.
 */
function rpwe_widget_register() {
	require_once RPWE_PATH . 'classes/class-rpwe-widget.php';
	register_widget( 'RPWE_Widget' );
}
add_action( 'widgets_init', 'rpwe_widget_register' );

/**
 * Custom admin scripts.
 */
function rpwe_admin_scripts() {
	wp_enqueue_style( 'rpwe-admin-style', RPWE_URL . 'assets/css/rpwe-admin.css', null, RPWE_VERSION );
}
add_action( 'admin_enqueue_scripts', 'rpwe_admin_scripts' );

/**
 * Enqueue frontend stylesheet
 */
function rpwe_frontend_style() {
	wp_register_style( 'rpwe-style', RPWE_URL . 'assets/css/rpwe-frontend.css', array(), RPWE_VERSION );
}
add_action( 'wp_enqueue_scripts', 'rpwe_frontend_style' );

/**
 * Custom image size.
 *
 * DEPRECATED
 */
function rpwe_register_image_size() {
	add_image_size( 'rpwe-thumbnail', 45, 45, true );
}
add_action( 'init', 'rpwe_register_image_size' );
