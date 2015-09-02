<?php
/**
 * PluginName Core Functions
 *
 * @author   Your Name / Your Company Name
 * @category Core
 * @package  PluginName/Functions
 * @license  GPL-2.0+
 * @since    1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

// Include core functions
include( 'plugin-name-conditional-functions.php' );
include( 'plugin-name-formatting-functions.php' );

/**
 * Helper function for registering and enqueueing scripts and styles.
 *
 * @param  string  $name      The ID to register with WordPress.
 * @param  string  $file_path The path to the actual file.
 * @param  bool    $is_script Optional, argument for if the incoming file_path is a JavaScript source file.
 * @param  array   $support   Optional, for requiring other javascripts for the source file you are calling.
 * @param  string  $version   Optional, can match the version of the plugin or version of the source file.
 * @global string  $wp_version
 * @access private
 * @since  1.0.0
 */
function plugin_name_load_file( $name, $file_path, $is_script = false, $support = array(), $version = '' ) {
  global $wp_version;

  $url  = PLUGIN_NAME_URL_PATH . $file_path;
  $file = PLUGIN_NAME_FILE_PATH . $file_path;

  if ( file_exists( $file ) ) {
    if ( $is_script ) {
      wp_register_script( $name, $url, $support, $version );
      wp_enqueue_script( $name );
    }
    else {
      wp_register_style( $name, $url );
      wp_enqueue_style( $name );
    } // end if
  } // end if
} // END plugin_name_load_file()
