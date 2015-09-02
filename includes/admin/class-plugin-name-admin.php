<?php
/**
 * PluginName Admin.
 *
 * @author   Your Name / Your Company Name
 * @category Admin
 * @package  PluginName/Admin
 * @license  GPL-2.0+
 * @since    1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Plugin_Name_Admin' ) ) {

	class Plugin_Name_Admin {

		/**
		 * Constructor
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function __construct() {
			add_action( 'admin_init',            array( $this, 'includes' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ), 100 );
		} // END __construct()

		/**
		 * Include any classes we need within admin.
		 *
		 * @filter plugin_name_enable_admin_help_tab
		 * @access public
		 * @since  1.0.0
		 */
		public function includes() {
			// Functions
			include( 'plugin-name-admin-functions.php' );

			// Classes we only need if the ajax is not-ajax
			if ( ! plugin_name_is_ajax() ) {
				// Main Plugin
				include( 'class-plugin-name-admin-notices.php' );
			}
		} // END includes()

		/**
		 * Registers and enqueues stylesheets and javascripts
		 * for the administration panel of the plugin.
		 *
		 * @filter plugin_name_admin_params
		 * @access public
		 * @since  1.0.0
		 */
		public function admin_scripts() {
			// PluginName Admin Javascript
			plugin_name_load_file( PLUGIN_NAME_SLUG . '_admin_script', '/admin/assets/js/plugin-name' . PLUGIN_NAME_SCRIPT_MODE . '.js', true, array( 'jquery' ), '1.0.0' );

			// Variables for PluginName Admin JavaScript
			wp_localize_script( PLUGIN_NAME_SLUG . '_admin_script', 'plugin_name_admin_params', apply_filters( 'plugin_name_admin_params', array(
				'ajaxurl'    => admin_url('admin-ajax.php'),
				'plugin_url' => PLUGIN_NAME_URL_PATH,
			) ) );

			// PluginName Admin Stylesheet
			plugin_name_load_file( PLUGIN_NAME_SLUG . '_admin_style', '/admin/assets/css/admin/plugin-name.css' );
		} // END admin_scripts()

	} // END class

} // END if class exists

return new Plugin_Name_Admin();
