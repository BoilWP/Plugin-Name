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
		 * @var    array DB updates that need to be run
		 * @return array
		 * @access private static
		 * @since  1.0.0
		 */
		private static $db_updates = array(
			//'1.0.1' => 'updates/plugin-name-update-1.0.1.php',
		);

		/**
		 * Constructor.
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public static function init() {
			add_action( 'admin_init', array( __CLASS__, 'check_version' ), 5 );
			add_action( 'admin_init', array( __CLASS__, 'install_actions' ) );
		} // END __construct()

		/**
		 * When called, the plugin checks the version
		 * of the plugin and the database version in use.
		 * This function determins if the plugin requires
		 * to process an update.
		 *
		 * @return void
		 * @access public static
		 * @since  1.0.0
		 */
		public static function check_version() {
			if ( ! defined( 'IFRAME_REQUEST' ) && ( get_option( 'plugin_name_version' ) != PLUGIN_NAME_VERSION || get_option( 'plugin_name_db_version' ) != PLUGIN_NAME_VERSION ) ) {
				self::install();
				do_action('plugin_name_updated');
			}
		} // END check_version()

		/**
		 * Install actions such as updating the plugin when a button is clicked.
		 *
		 * @access public static
		 * @since  1.0.0
		 */
		public static function install_actions() {
			if ( ! empty( $_GET['do_update_plugin_name'] ) ) {
				self::update();

				// Update complete
				Plugin_Name_Admin_Notices::remove_notice( 'update' );
			}
		} // END install_action()

		/**
		 * Install PluginName.
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function install() {
			// Queue upgrades.
			$current_plugin_name_version    = get_option( 'plugin_name_version', null );
			$current_plugin_name_db_version = get_option( 'plugin_name_db_version', null );

			Plugin_Name_Admin_Notices::remove_all_notices();

			// If no version detected, then this is a new install :)
			if ( is_null( $current_plugin_name_version ) && is_null( $current_plugin_name_db_version ) ) {
				// Show a notice to the administrator user.
				Plugin_Name_Admin_Notices::add_notice( 'install' );
			}

			if ( !empty( $db_updates ) ) {
				// If the plugin has an update, check that an update is required.
				if ( ! is_null( $current_plugin_name_db_version ) && version_compare( $current_plugin_name_db_version, max( array_keys( self::$db_updates ) ), '<' ) ) {
					Plugin_Name_Admin_Notices::add_notice( 'update' );
				}
			} else {
				self::update_plugin_name_db_version();
			}

			// Update the PluginName version.
			self::update_plugin_name_version();

			// Trigger action.
			do_action( 'plugin_name_installed' );
		} // END install()

		/**
		 * Update PluginName version to current.
		 *
		 * @access private static
		 * @since  1.0.0
		 */
		private static function update_plugin_name_version() {
			delete_option( 'plugin_name_version' );
			add_option( 'plugin_name_version', PLUGIN_NAME_VERSION );
		} // END update_plugin_name_version()

		/**
		 * Update PluginName DataBase version to current.
		 *
		 * @access private static
		 * @since  1.0.0
		 */
		private static function update_plugin_name_db_version( $version = null ) {
			delete_option( 'plugin_name_db_version' );
			add_option( 'plugin_name_db_version', is_null( $version ) ? PLUGIN_NAME_VERSION : $version );
		} // END update_plugin_name_db_version()

		/**
		 * Update PluginName.
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function update() {
			$current_plugin_name_db_version = get_option( 'plugin_name_db_version' );

			foreach ( self::$db_updates as $version => $updater ) {
				if ( version_compare( $current_plugin_name_db_version, $version, '<' ) ) {
					include( $updater );
					self::update_plugin_name_db_version( $version );
				}
			}

			self::update_plugin_name_db_version();
		} // END update()

	} // END if class.

} // END if class exists.

// Run Install
Plugin_Name_Install::init();
