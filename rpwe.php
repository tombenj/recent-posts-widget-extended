<?php

/**
 * Plugin Name:       Recent Posts Widget Extended
 * Plugin URI:        https://idenovasi.com/projects/recent-posts-widget-extended/
 * Description:       Enables advanced widget that gives you total control over the output of your site’s most recent Posts.
 * Version:           1.1.0
 * Requires at least: 5.8
 * Requires PHP:      7.2
 * Author:            Idenovasi
 * Author URI:        https://idenovasi.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       recent-posts-widget-extended
 * Domain Path:       /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class RPW_Extended {

    /**
     * PHP5 constructor method.
     *
     * @since  0.1
     */
    public function __construct() {

        // Set the constants needed by the plugin.
        add_action('plugins_loaded', array(&$this, 'constants'), 1);

        // Internationalize the text strings used.
        add_action('plugins_loaded', array(&$this, 'i18n'), 2);

        // Load the functions files.
        add_action('plugins_loaded', array(&$this, 'includes'), 3);

        // Load the admin style.
        add_action('admin_enqueue_scripts', array(&$this, 'admin_style'));

        // Register widget.
        add_action('widgets_init', array(&$this, 'register_widget'));

        // Register new image size.
        add_action('init', array(&$this, 'register_image_size'));
    }

    /**
     * Defines constants used by the plugin.
     *
     * @since  0.1
     */
    public function constants() {

        // Set constant path to the plugin directory.
        define('RPWE_DIR', trailingslashit(plugin_dir_path(__FILE__)));

        // Set the constant path to the plugin directory URI.
        define('RPWE_URI', trailingslashit(plugin_dir_url(__FILE__)));

        // Set the constant path to the includes directory.
        define('RPWE_INCLUDES', RPWE_DIR . trailingslashit('includes'));

        // Set the constant path to the includes directory.
        define('RPWE_CLASS', RPWE_DIR . trailingslashit('classes'));

        // Set the constant path to the assets directory.
        define('RPWE_ASSETS', RPWE_URI . trailingslashit('assets'));
    }

    /**
     * Loads the translation files.
     *
     * @since  0.1
     */
    public function i18n() {
        load_plugin_textdomain('recent-posts-widget-extended', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    /**
     * Loads the initial files needed by the plugin.
     *
     * @since  0.1
     */
    public function includes() {
        require_once(RPWE_INCLUDES . 'resizer.php');
        require_once(RPWE_INCLUDES . 'functions.php');
        require_once(RPWE_INCLUDES . 'shortcode.php');
        require_once(RPWE_INCLUDES . 'helpers.php');
    }

    /**
     * Register custom style for the widget settings.
     *
     * @since  0.8
     */
    public function admin_style() {
        // Loads the widget style.
        wp_enqueue_style('rpwe-admin-style', trailingslashit(RPWE_ASSETS) . 'css/rpwe-admin.css', null, null);
    }

    /**
     * Register the widget.
     *
     * @since  0.9.1
     */
    public function register_widget() {
        require_once(RPWE_CLASS . 'widget.php');
        register_widget('Recent_Posts_Widget_Extended');
    }

    /**
     * Register new image size.
     *
     * @since  0.9.4
     */
    function register_image_size() {
        add_image_size('rpwe-thumbnail', 45, 45, true);
    }
}

new RPW_Extended;
