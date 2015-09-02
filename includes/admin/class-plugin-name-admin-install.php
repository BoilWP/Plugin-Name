<?php
/**
 * Installation related functions and actions.
 *
 * @since    1.0.0
 * @author   Your Name / Your Company Name
 * @category Admin
 * @package  PluginName/Admin
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Plugin_Name_Install' ) ) {

	/**
	 * Plugin_Name_Install Class
	 */
	class Plugin_Name_Install {

		/**
		 * Constructor.
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function init() {
			add_action( 'admin_init', array( $this, 'check_version' ), 5 );
		} // END __construct()

		/**
		 * When called, the plugin checks the version
		 * of the plugin and the database version in use.
		 * This function determins if the plugin requires
		 * to process an update.
		 *
		 * @return void
		 * @access public
		 * @since  1.0.0
		 */
		public function check_version() {
			if ( ! defined( 'IFRAME_REQUEST' ) && ( get_option( 'plugin_name_version' ) != PLUGIN_NAME_VERSION || get_option( 'plugin_name_db_version' ) != PLUGIN_NAME_VERSION ) ) {
				$this->update();
			}
		} // END check_version()

		/**
		 * Install PluginName
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function install() {
			// Update plugin version
			update_option( 'plugin_name_version', PLUGIN_NAME_VERSION );

			// Update plugin database version
			update_option( 'plugin_name_db_version', PLUGIN_NAME_VERSION );
		} // END install()

		/**
		 * Update PluginName
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function update() {
			return $this->install();
		} // END update()

	} // END if class.

} // END if class exists.

function Plugin_Name_Install() {
	return new Plugin_Name_Install();
}

// Run Install
Plugin_Name_Install()->init();
