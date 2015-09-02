<?php
/**
 * PluginName Admin Hooks
 *
 * @todo     Place your hooks for the functions used in the administration side of the plugin.
 * @author   Your Name / Your Company Name
 * @category Core
 * @package  PluginName/Admin/Hooks
 * @license  GPL-2.0+
 * @since    1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

register_activation_hook( PLUGIN_NAME_FILE, array( 'Plugin_Name_Activation', '__construct' ) );
