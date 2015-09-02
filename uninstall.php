<?php
/**
 * Runs on Uninstall of PluginName
 *
 * This file will remove any options and tables you
 * have created for this plugin.
 *
 * @author    Your Name / Your Company Name
 * @category  Core
 * @package   PluginName
 * @copyright Copyright (c) 2015
 * @license   GPL-2.0+
 * @since     1.0.0
 */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();

global $wpdb, $wp_roles;

// For a single site
if ( ! is_multisite() ) {

	// Delete options
	$wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE 'plugin_name_%';");

	/*
	 * @todo Place your own uninstall code here.
	 */
}
// For a multisite network
else {
	$blog_ids         = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
	$original_blog_id = get_current_blog_id();

	foreach ( $blog_ids as $blog_id ) {
		switch_to_blog( $blog_id );

		/*
		 * @todo Place your own uninstall code here.
		 */
		delete_site_option( 'option_name' );
	}

	switch_to_blog( $original_blog_id ); // Return to original blog.
}
