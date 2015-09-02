<?php
/**
 * PluginName Conditional Functions
 *
 * Functions for determining the current query/page.
 *
 * @author   Your Name / Your Company Name
 * @category Core
 * @package  PluginName/Functions
 * @license  GPL-2.0+
 * @since    1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'plugin_name_is_ajax' ) ) {

	/**
	 * Returns true when the page is loaded via ajax.
	 *
	 * @return bool
	 * @access public
	 * @since  1.0.0
	 */
	function plugin_name_is_ajax() {
		if ( defined( 'DOING_AJAX' ) ) {
			return true;
		}

		return ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) ? true : false;
	} // END plugin_name_is_ajax()
}
