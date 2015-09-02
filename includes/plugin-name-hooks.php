<?php
/**
 * PluginName Hooks
 *
 * @todo     Place your hooks for the functions used in the frontend for the plugin.
 * @author   Your Name / Your Company Name
 * @category Core
 * @package  PluginName/Hooks
 * @license  GPL-2.0+
 * @since    1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', array( 'Plugin_Name', 'register_scripts_and_styles' ) );
