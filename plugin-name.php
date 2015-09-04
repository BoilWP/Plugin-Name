<?php
/*
 * Plugin Name: @todo
 * Plugin URI:  @todo
 * Description: @todo
 * Version:     1.0.0
 * Author:      @todo
 * Author URI:  @todo
 * Text Domain: plugin-name
 *
 * @package   PluginName
 * @author    @todo
 * @copyright Copyright (c) 2015
 * @license   GPL-2.0+
 *
 * IMPORTANT! Ensure that you make the following adjustments
 * before releasing your extension:
 *
 * - Replace all instances of plugin-name with the name of your plugin.
 *   By WordPress coding standards, the folder name, plugin file name,
 *   and text domain should all match. For the purposes of standardization,
 *   the folder name, plugin file name, and text domain are all the
 *   lowercase form of the actual plugin name, replacing spaces with
 *   hyphens.
 *
 * - Replace all instances of Plugin_Name with the name of your plugin.
 *   For the purposes of standardization, the camel case form of the plugin
 *   name, replacing spaces with underscores, is used to define classes
 *   in your extension.
 *
 * - Replace all instances of PLUGIN_NAME with the name of your plugin.
 *   For the purposes of standardization, the uppercase form of the plugin
 *   name, removing spaces, is used to define plugin constants.
 *
 * - Replace all instances of Plugin Name with the actual name of your
 *   plugin.
 *
 * - Find all instances of @todo in the plugin and update the relevant
 *   areas as necessary.
 *
 * - All functions that are not class methods MUST be prefixed with the
 *   plugin name, replacing spaces with underscores. NOT PREFIXING YOUR
 *   FUNCTIONS CAN CAUSE PLUGIN CONFLICTS!
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Plugin_Name' ) ) {

	/**
	 * Main PluginName Class
	 *
	 * @todo  Replace 'Plugin_Name' with the name of your plugin class.
	 * @since 1.0.0
	 */
	final class Plugin_Name {

		/**
		 * The single instance of the class
		 *
		 * @var    object  $instance The one true Plugin_Name
		 * @access private
		 * @since  1.0.0
		 */
		 private static $_instance = null;

		/**
		 * Slug
		 *
		 * @todo   Rename the plugin slug to your own.
		 * @var    string
		 * @access public
		 * @since  1.0.0
		 */
		public $plugin_slug = 'plugin_name';

		/**
		 * PluginName.
		 *
		 * @todo   Rename the plugin name to your own.
		 * @var    string
		 * @access public
		 * @since  1.0.0
		 */
		public $name = "PluginName";

		/**
		 * The minimum version of PHP the plugin requires.
		 *
		 * @todo   Enter the minimum version of PHP this plugin requires.
		 * @var    string
		 * @access public
		 * @since  1.0.0
		 */
		public static $php_required_min = "5.4.0";

		/**
		 * The minimum version of WordPress the plugin requires.
		 *
		 * @todo   Enter the minimum version of WordPress this plugin requires.
		 * @var    string
		 * @access public
		 * @since  1.0.0
		 */
		public static $wp_version_min = "4.0";

		/**
		 * Main PluginName Instance
		 *
		 * Ensures only one instance of PluginName is loaded or can be loaded.
		 *
		 * @todo   Replace 'Plugin_Name' with the name of your plugin class.
		 * @return object self::instance The one true Plugin_Name
		 * @see    Plugin_Name()
		 * @access public static
		 * @since  1.0.0
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new Plugin_Name;
				self::$_instance->setup_constants();
				self::$_instance->load_plugin_textdomain();
				self::$_instance->includes();
			}
			return self::$_instance;
		} // END instance()

		/**
		 * Constructor
		 *
		 * @return void
		 * @access public
		 * @since  1.0.0
		 */
		public function __construct() {
			// Auto-load classes on demand
			if ( function_exists( "__autoload" ) )
				spl_autoload_register( "__autoload" );

				spl_autoload_register( array( $this, 'autoload' ) );
		} // END __construct()

		/**
		 * Auto-load PluginName classes on demand to reduce memory consumption.
		 *
		 * @param  mixed $class
		 * @return void
		 * @access public
		 * @since  1.0.0
		 */
		public function autoload( $class ) {
			$class = strtolower( $class );
			$file  = 'class-' . str_replace( '_', '-', $class ) . '.php';
			$path = '';

			if ( strpos( $class, 'plugin_name_admin_' ) === 0 ) {
				$path = PLUGIN_NAME_FILE_PATH . '/includes/admin/';
			} else if ( strpos( $class, 'plugin_name_' ) === 0 ) {
				$path = PLUGIN_NAME_FILE_PATH . '/includes/';
			}

			if ( $path && is_readable( $path . $file ) ) {
				include_once( $path . $file );
				return true;
			}
		} // END autoload()

		/**
		 * Setup Constants
		 *
		 * @todo   Change 'PLUGIN_NAME' to the name of the plugin in CAPITAL LETTERS.
		 * @access private
		 * @since  1.0.0
		 */
		private function setup_constants() {
			$this->define( 'PLUGIN_NAME_VERSION', '1.0.0' );
			$this->define( 'PLUGIN_NAME_FILE', __FILE__ );
			$this->define( 'PLUGIN_NAME_SLUG', $this->plugin_slug );
			$this->define( 'PLUGIN_NAME_URL_PATH', untrailingslashit( plugins_url( '/', __FILE__ ) ) );
			$this->define( 'PLUGIN_NAME_FILE_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			$this->define( 'PLUGIN_NAME_SCRIPT_MODE', $suffix );
		} // END setup_constants()

		/**
		 * Define constant if not already set.
		 *
		 * @param  string $name
		 * @param  string|bool $value
		 * @access private
		 * @since  1.0.0
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Throw error on object clone
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @return void
		 * @access public
		 * @since  1.0.0
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'plugin-name' ), '1.0.0' );
		} // END __clone()

		/**
		 * Disable unserializing of the class
		*
		* @return void
		* @access public
		* @since  1.0.0
		*/
		public function __wakeup() {
			// Unserializing instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'plugin-name' ), '1.0.0' );
		} // END __wakeup()

		/**
		 * Include required core files used in admin and on the frontend.
		 *
		 * @return void
		 * @access public
		 * @since  1.0.0
		 */
		public function includes() {
			// Contains core functions for the front/back end.
			include_once( 'includes/plugin-name-core-functions.php' );

			/**
			 * Load files required for the administrator only
			 * when the user is viewing the WordPress dashboard.
			 */
			if ( is_admin() ) {
				// The plugin checks requirements on activation before it does other stuff.
				include_once( 'includes/admin/class-plugin-name-admin-activation.php' );

				// The plugin then installs.
				include_once( 'includes/admin/class-plugin-name-admin-install.php' );

				// The admin features.
				include_once( 'includes/admin/class-plugin-name-admin.php' );

				// Hooks used only in the admin.
				include_once( 'includes/admin/plugin-name-admin-hooks.php' );
			}

			/**
			 * Load files required for the frontend only
			 * when the user is viewing the site.
			 */
			if ( ! is_admin() || defined( 'DOING_AJAX' ) ) {
				// Functions used for the frontend only.
				include_once( 'includes/plugin-name-functions.php' );

				// Hooks used only in the frontend.
				include_once( 'includes/plugin-name-hooks.php' );
			}
		} // END includes()

		/**
		 * Load Localisation files.
		 *
		 * Note: the first-loaded translation file overrides any
		 * following ones if the same translation is present.
		 *
		 * @todo   1. Replace 'plugin-name' with the correct textdomain.
		 * @todo   2. Do the same for the plugin folder directory.
		 * @filter plugin_name_languages_directory
		 * @filter plugin_locale
		 * @return void
		 * @access public
		 * @since  1.0.0
		 */
		public function load_plugin_textdomain() {
			// Set filter for plugin's languages directory
			$lang_dir = dirname( plugin_basename( PLUGIN_NAME_FILE ) ) . '/languages/';
			$lang_dir = apply_filters( 'plugin_name_languages_directory', $lang_dir );

			// Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale',  get_locale(), 'plugin-name' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'plugin-name', $locale );

			// Setup paths to current locale file
			$mofile_local  = $lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/' . 'plugin-name' . '/' . $mofile;

			if ( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/plugin-name/ folder
				load_textdomain( 'plugin-name', $mofile_global );
			} else if ( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/plugin-name/languages/ folder
				load_textdomain( 'plugin-name', $mofile_local );
			} else {
				// Load the default language files
				load_plugin_textdomain( 'plugin-name', false, $lang_dir );
			}
		} // END load_plugin_textdomain()

		/**
		 * Registers and enqueues stylesheets and javascripts
		 * for the frontend of the site for the plugin.
		 *
		 * @filter plugin_name_params
		 * @access private
		 * @since  1.0.0
		 */
		private function register_scripts_and_styles() {
			plugin_name_load_file( PLUGIN_NAME_SLUG . '-script', '/assets/js/frontend/plugin-name' . PLUGIN_NAME_SCRIPT_MODE . '.js', true, array( 'jquery' ), '1.0.0' );

			// PluginName Stylesheet
			plugin_name_load_file( PLUGIN_NAME_SLUG . '-style', '/assets/css/plugin-name.css' );

			// Variables for PluginName Frontend Javascript
			wp_localize_script( PLUGIN_NAME_SLUG . '-script', 'plugin_name_params', apply_filters( 'plugin_name_params', array(
				'home_url'   => home_url(),
				'plugin_url' => PLUGIN_NAME_URL_PATH,
			) ) );
		} // END register_scripts_and_styles()

	} // END Plugin_Name()

} // END class_exists('Plugin_Name')

/**
 * Returns the instance of Plugin_Name to prevent
 * the need to use globals.
 */
return Plugin_Name::instance();
