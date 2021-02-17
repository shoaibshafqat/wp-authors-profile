<?php
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0 
 * @package    Wp_Author_WPA
 * @subpackage Wp_Author_WPA/classes
 * @author     Shoaib Shafqat <shoaibshafqat@gmail.com>
 */
class WPA53_Wp_Author_WPA_Activator {
	/**
	 * refresh the permalink after creation of new CPT
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function WPA53_activate() {
		$plugin_admin = new WPA53_Wp_Author_Admin( WPA53_Wp_AUTHOR_VERSION, WPA53_PLUGIN_NAME );
		$plugin_admin->WPA53_wp_author_rooted_functions();
		flush_rewrite_rules(true);	
		}
}
