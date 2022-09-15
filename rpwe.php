<?php
/**
 * Plugin Name:       Recent Posts Extended
 * Plugin URI:        https://github.com/gasatrya/recent-posts-widget-extended
 * Description:       Enables advanced shortcode & widget that gives you total control over the output of your site’s most recent Posts.
 * Version:           2.0
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

define( 'RP_VERSION', '2.0' );
define( 'RP_CLASS', plugin_dir_path( __FILE__ ) . 'class' );
define( 'RP_INCLUDES', plugin_dir_path( __FILE__ ) . 'inc' );
define( 'RP_ASSETS', plugin_dir_url( __FILE__ ) . 'assets' );
define( 'RP_LEGACY', plugin_dir_path( __FILE__ ) . 'legacy' );

// Legacy, old version.
require_once RP_LEGACY . '/legacy.php';

// Load plugin files.
require_once RP_INCLUDES . '/defaults.php';
require_once RP_INCLUDES . '/query.php';
require_once RP_CLASS . '/class-image-resizer.php';
require_once RP_INCLUDES . '/helpers.php';
require_once RP_INCLUDES . '/functions.php';
require_once RP_INCLUDES . '/shortcodes.php';

/**
 * Language
 */
function rpost_i18n() {
	load_plugin_textdomain( 'recent-posts-widget-extended', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'rpost_i18n' );
