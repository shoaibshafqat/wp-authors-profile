<?php
/**
 * Plugin Name: WP Author's Profile
 * Description: Register post type at backend with authors personal fields also upload authors gallery image and set cover image as profile image and on frontend show author profile based on author first and last name in url, no need create the custom template also show the authors related posts at bottom of personal detail.
 * Version: 1.1
 * Author: Tehseen-Shoaib
 * Author URI: http://xpertzgroup.com
 * Requires at least: 4.4
 * Tested up to: 5.6
 * License: GPL2+ 
 *
 * Text Domain: xpertzgroup
 */
// To prevent direct access file
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Current plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 */
define( 'WPA53_Wp_AUTHOR_VERSION', '1.0.0' );
define( 'WPA53_PLUGIN_NAME', 'Wp_AUTHOR_WPA' );
define( 'WPA53_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WPA53_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * function will trigger on plugin activation to set default configuration
 */
function WPA53_activate_wp_author_wpa() {
	require_once WPA53_PLUGIN_PATH . 'classes/class-wp_author-activator.php';
	WPA53_Wp_Author_WPA_Activator::WPA53_activate();
}

register_activation_hook( __FILE__, 'WPA53_activate_wp_author_wpa' );
/**
 * Core class which used to call the actions, hooks and required dependencies files.
 */
require plugin_dir_path( __FILE__ ) . 'classes/class-wp_author.php';
/**
 * Begins execution of the plugin.
 * @since    1.0.0
 */
function WPA53_run_wp_author() {
	$wp_author = new WPA53_Wp_AUTHOR_WPA();
	$wp_author->WPA53_execute();
}
WPA53_run_wp_author();