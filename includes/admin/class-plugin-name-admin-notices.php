<?php
/**
 * Display notices in the WordPress admin.
 *
 * @since    1.0.0
 * @author   Your Name / Your Company Name
 * @category Admin
 * @package  PluginName
 * @license  GPL-2.0+
 */

/**
 * This class was forked from the plugin called
 * WooCommerce with some alterations.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Plugin_Name_Admin_Notices' ) ) {

	/**
	 * Plugin_Name_Admin_Notices Class
	 */
	class Plugin_Name_Admin_Notices {

		/**
		 * Array of notices - name => callback
		 *
		 * @var    array
		 * @access private
		 * @since  1.0.0
		 */
		private $core_notices = array(
			'require' => 'requirement_notice',
			'install' => 'install_notice',
			'update'  => 'update_notice',
		);

		/**
		 * Constructor
		 *
		 * @global string $wp_version
		 * @return void
		 * @access public
		 * @since  1.0.0
		 */
		public function __construct() {
			global $wp_version;

			if ( current_user_can( 'manage_options' ) ) {
				add_action( 'admin_print_styles', array( $this, 'add_notices' ) );
			}

			/** Checks that the WordPress setup meets the plugin requirements. **/
			if ( ! version_compare( $wp_version, Plugin_Name::$wp_version_min, '>=' ) ) {

				// Deactivate the plugin.
				deactivate_plugins( plugin_basename( PLUGIN_NAME_FILE ) );

				// Show a notice to the administrator user.
				self::add_notice( 'require' );

				// Return nothing else.
				return;
			}

			// If all is OK then remove the requirement notice.
			//self::remove_notice( 'require' );
		} // END __construct()

		 /**
		 * Remove all notices from this plugin.
		 *
		 * @access public static
		 * @since  1.0.0
		 */
		public static function remove_all_notices() {
			delete_option( 'plugin_name_admin_notices' );
		}

		/**
		 * Show a notice.
		 *
		 * @param  string $name
		 * @access public static
		 * @since  1.0.0
		 */
		public static function add_notice( $name ) {
			$notices = array_unique( array_merge( get_option( 'plugin_name_admin_notices', array() ), array( $name ) ) );
 			update_option( 'plugin_name_admin_notices', $notices );
		}

		/**
		 * Remove a notice from being displayed.
		 *
		 * @param  string $name
		 * @access public static
		 * @since  1.0.0
		 */
		public static function remove_notice( $name ) {
			$notices = array_diff( get_option( 'plugin_name_admin_notices', array() ), array( $name ) );
			update_option( 'plugin_name_admin_notices', $notices );
		}

		/**
		 * See if a notice is being shown.
		 *
		 * @param  string  $name
		 * @return boolean
		 * @access public static
		 * @since  1.0.0
		 */
		public static function has_notice( $name ) {
			return in_array( $name, get_option( 'plugin_name_admin_notices', array() ) );
		}

		/**
		 * Hide a notice if the GET variable is set.
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function hide_notices() {
			if ( isset( $_GET['plugin-name-hide-notice'] ) && isset( $_GET['_plugin_name_notice_nonce'] ) ) {
				if ( ! wp_verify_nonce( $_GET['_plugin_name_notice_nonce'], 'plugin_name_hide_notices_nonce' ) ) {
					wp_die( __( 'Action failed. Please refresh the page and retry.', 'plugin-name' ) );
				}

				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( __( 'Cheatin&#8217; huh?', 'plugin-name' ) );
				}

				$hide_notice = sanitize_text_field( $_GET['plugin-name-hide-notice'] );
				self::remove_notice( $hide_notice );
				do_action( 'plugin_name_hide_' . $hide_notice . '_notice' );
			}
		}

		/**
		 * Add notices + styles if needed.
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function add_notices() {
			$notices = get_option( 'plugin_name_admin_notices', array() );

			if ( $notices ) {
				plugin_name_load_file( 'plugin-name-activation', '/includes/admin/assets/css/activation' . PLUGIN_NAME_SCRIPT_MODE . '.css' );
				foreach ( $notices as $notice ) {
					if ( ! empty( $this->core_notices[ $notice ] ) && apply_filters( 'plugin_name_show_admin_notice', true, $notice ) ) {
						if ( $notice == 'update' ) {
							plugin_name_load_file( PLUGIN_NAME_SLUG . '_admin_update_script', '/includes/admin/assets/js/update.js', true, array( 'jquery' ), '1.0.0' );
						}
						add_action( 'admin_notices', array( $this, $this->core_notices[ $notice ] ) );
					}
				}
			}
		}

		/**
		 * Show the notice when called.
		 *
		 * @return string
		 * @access public
		 * @since  1.0.0
		 */
		public function the_notice( $notice_type, $message ) {
			 return '<div id="message" class="' . $notice_type . ' plugin-name-message"><p>' . $message . '</p></div>';
		}

		/**
		 * If the plugin does not meet it's requirements, show a message.
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function requirement_notice() {
			echo self::the_notice( 'error', sprintf( __( 'Sorry, %s requires WordPress %s or higher. Please upgrade your WordPress setup.', 'plugin-name'), Plugin_Name()->name, Plugin_Name()->wp_version_min ) );
		} // END display_req_notice()

		/**
		 * If we have just installed the plugin, show a message.
		 *
		 * return  string
		 * @access public
		 * @since  1.0.0
		 */
		public function install_notice() {
			echo self::the_notice( 'updated', sprintf( __( 'Thank you for installing %s <a style="float:right;" href="' . esc_url( wp_nonce_url( add_query_arg( 'plugin-name-hide-notice', 'install' ), 'plugin_name_hide_notices_nonce', '_plugin_name_notice_nonce' ) ). '">%s</a>', 'plugin-name' ), Plugin_Name()->name, __( 'Dismiss Notice', 'plugin-name' ) ) );
		}

		/**
		 * If we have just installed the plugin, show a message.
		 *
		 * return  string
		 * @access public
		 * @since  1.0.0
		 */
		public function update_notice() {
			echo self::the_notice( 'updated', sprintf( __( '<strong>%s Data Update Required</strong> &#8211; We just need to update your install to the latest version. <a href="' . esc_url( add_query_arg( 'do_update_plugin_name', 'true', admin_url() ) ) . '" class="plugin-name-update-now button-primary">' . __( 'Run the updater', 'plugin-name' ) . '</a>', 'plugin-name' ), Plugin_Name()->name ) );
		}

	} // END Plugin_Name_Admin_Notices class.

} // END if class exists.

new Plugin_Name_Admin_Notices();
