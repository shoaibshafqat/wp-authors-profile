<?php
/**
 * The frontend functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the frontend stylesheet and JavaScript.
 * @package    Wp_Author_WPA
 * @subpackage Wp_Author_WPA/backend
 * @author     Shoaib Shafqat <shoaibshafqat@gmail.com>
 */
class WPA53_Wp_Author_Frontend
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;
    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;
    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of the plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    /**
     * Register the stylesheets for the frontend side of the site.
     *
     * @since    1.0.0
     */
    public function WPA53_enqueue_styles()
    {global $post;
		if(isset($post) and $post->post_type == 'authors'){
			// load style file on all pages for authors container
			wp_enqueue_style( 'wp_author-style', WPA53_PLUGIN_URL . 'front/css/wp_author-style.css', array(), $this->version, 'all' );
			
			// load style file on all pages for authors container
			wp_enqueue_style( 'bootstrap', WPA53_PLUGIN_URL . 'front/css/bootstrap.4.3.1.min.css', array(), $this->version, 'all' );
			
			// load style file on all pages for authors container
			wp_enqueue_style( 'simpleLightbox-css', WPA53_PLUGIN_URL . 'front/css/simpleLightbox.css', array(), $this->version, 'all' );
			}
    }
	
	/**
     * Register the JavaScript for the backend area.
     *
     * @since    1.0.0
     */
    public function WPA53_enqueue_scripts()
    {global $post;
		if(isset($post) and $post->post_type == 'authors'){
		  wp_enqueue_script('jquery');
		  wp_enqueue_script( 'simpleLightbox-js', WPA53_PLUGIN_URL . 'front/js/simpleLightbox.js', array(), array(), true, false  );
		  wp_enqueue_script( 'wp-authors-front', WPA53_PLUGIN_URL . 'front/js/wp-authors-front.js', array(), array(), true, false  );
		}
	  }
	  /**
     * Filter the single_template with our custom function
	 * 
     * @since    1.0.0
     */
	public function WPA53_author_custom_template($single) {
		global $post;
		/* Checks for single template by post type */
		if ( isset($post) and $post->post_type == 'authors' ) {
			if ( file_exists( WPA53_PLUGIN_PATH . 'front/template/single-authors.php' ) ) {
				$single = dirname( __FILE__ ). '/template/single-authors.php';			
			}
		}
		
		return $single;
	}
	
	/**
     * Return author related posts
     *
     * @since    1.0.0
     */
    public function WPA53_author_related_posts($params)
    {
		$post_query = new WP_Query( array( 'author' => $params['author_id'], 
											'post_type' => $params['post_type'], 
											'posts_per_page ' => $params['limit'], 
											'post_status' => 'publish'
										   ) 
										);
		return $post_query;
		}	  	
}