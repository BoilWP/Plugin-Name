<?php
/**
 * Activating the plugin.
 *
 * @since    1.0.0
 * @author   Your Name / Your Company Name
 * @category Admin
 * @package  PluginName/Admin
 * @license  GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Plugin_Name_Activation' ) ) {

	/**
	 * Plugin_Name_Activation Class
	 */
	class Plugin_Name_Activation {

		/**
		 * Constructor.
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function __construct() {
			// Fetch the Php version checker.
			require_once( 'wp-update-php/WPUpdatePhp.php' );
			$updatePhp = new WPUpdatePhp( Plugin_Name()->php_required_min );

			// If the miniumum version of PHP required is available then install the plugin.
			if ( $updatePhp->does_it_meet_required_php_version( PHP_VERSION ) ) {
				add_action( 'plugins_loaded', array( $this, 'run_activation' ) );
			} else {
				// If the required PHP version is not avaialble then deactivate the plugin.
				deactivate_plugins( plugin_basename( PLUGIN_NAME_FILE ) );
			} // END if/else
		} // END __construct()

		/**
		 * Now we are ready so let's install the plugin.
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function run_activation(){
			include_once( 'class-plugin-name-admin-install.php' );
			$install_plugin = new Plugin_Name_Install;

			$install_plugin->install();
		}

	} // END if class.

} // END if class exists.

return new Plugin_Name_Activation();
