<?php
/**
 * The core plugin class.
 *
 * This is used to define admin-specific hooks, and frontend site hooks.
 *
 * @since      1.0.0
 * @package    Wp_Author_WPA
 * @subpackage Wp_Author_WPA/classes
 * @author     Shoaib Shafqat <shoaibshafqat@gmail.com>
 */
 
class WPA53_Wp_AUTHOR_WPA
{
    /**
     * executor variable Maintains and registers all hooks for the plugin.
     *
     * @since    1.0.0
     * @access   protected
     */
    protected $executor;
    /**
     * variable plugin_name used to uniquely identify this plugin name.
     *
     * @since    1.0.0
     * @access   protected
     */
    protected $plugin_name;
    /**
     * $version defines the current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     */
    protected $version;
    /**
	 *
     * consturctor is used to define version, plugin name and load admin and frontend files
	 *
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->version = WPA53_Wp_AUTHOR_VERSION;
        $this->plugin_name = WPA53_PLUGIN_NAME;
        // Load all required files and class
		$this->WPA53_load_classes(); 
		
		// execute all hooks
        $this->WPA53_execute_admin_hooks();
		
		// execute front-end hooks
        $this->WPA53_execute_front_hooks();
    }
    /**
     *
     * Include the following files that make up the plugin:
     *
     * - Wp_Author_WPA_Executor. Orchestrates the hooks of the plugin.
     * - Wp_Author_WPA_Admin. Defines all hooks for the admin area.
     *
     * Create an instance of the executor which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function WPA53_load_classes()
    { 
		/**
         * The class responsible for actions and hooks 
         */
        require_once WPA53_PLUGIN_PATH . 'classes/class-wp_author-executor.php';
		$this->executor = new WPA53_Wp_Author_Executor();
        /**
         * The class responsible for all actions that occur in the admin area.
         */
        require_once WPA53_PLUGIN_PATH . 'backend/class-wp_author-admin.php';
		
	    /**
         * The class responsible for all actions that occur in the frontend
         * side of the site.
         */
        require_once WPA53_PLUGIN_PATH . 'front/class-wp_author-front.php';
    }
    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function WPA53_execute_admin_hooks()
    {
        $plugin_admin = new WPA53_Wp_Author_Admin( $this->WPA53_get_plugin_name(), $this->WPA53_get_version() );
		
		// enqueue style files at backend
        $this->executor->WPA53_add_action( 'admin_enqueue_scripts', $plugin_admin, 'WPA53_enqueue_styles' );
		
		// enqueue javascript files at backend
		$this->executor->WPA53_add_action( 'admin_enqueue_scripts', $plugin_admin, 'WPA53_enqueue_scripts' );
		
		// add new custom post type via hook
        $this->executor->WPA53_add_action( 'init', $plugin_admin, 'WPA53_wp_author_rooted_functions', 0 );
		
		// add post meta box to select authors
        $this->executor->WPA53_add_action( 'add_meta_boxes', $plugin_admin, 'WPA53_add_authors_meta_box' );
		
        // save post data to save the custom field values
        $this->executor->WPA53_add_action( 'save_post', $plugin_admin, 'save_postdata', 30 );		
    }
	
	 /**
     * Register all of the hooks related to the frontend functionality
     *
     * @since    1.0.0
     * @access   private
     */
    private function WPA53_execute_front_hooks()
    {
        $frontend = new WPA53_Wp_Author_Frontend( $this->WPA53_get_plugin_name(), $this->WPA53_get_version() );
		
		// enqueue style files at frontend for authors container
        $this->executor->WPA53_add_action( 'wp_enqueue_scripts', $frontend, 'WPA53_enqueue_styles' );
		
		// enqueue js files at frontend for search form
		$this->executor->WPA53_add_action( 'wp_enqueue_scripts', $frontend, 'WPA53_enqueue_scripts' );	
		
		// custom template using for author.
		$this->executor->WPA53_add_filter('single_template', $frontend, 'WPA53_author_custom_template',99);
    }
	 
    /**
     * Run this function to execute all of the hooks
     *
     * @since    1.0.0
     */
    public function WPA53_execute()
    {
        $this->executor->WPA53_execute();
    }
    /**
     * Get plugin name and used it to identify it within the plugin 
     *
     * @return    string    Current name of the plugin.
     * @since     1.0.0
     */
    public function WPA53_get_plugin_name()
    {
        return $this->plugin_name;
    }
    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    Wp_Author_WPA_Executor    Orchestrates the hooks of the plugin.
     * @since     1.0.0
     */
    public function get_loader()
    {
        return $this->executor;
    }
	
    /**
     * get the version number of the plugin.
     *
     * @since     1.0.0
     */
    public function WPA53_get_version()
    {
        return $this->version;
    }	 
}