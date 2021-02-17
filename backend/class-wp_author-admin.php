<?php
/**
 * The backend-specific functionality of the plugin.
 *
 * @package    Wp_Author_WPA
 * @subpackage Wp_Author_WPA/backend
 * @author     Shoaib Shafqat <shoaibshafqat@gmail.com>
 */
class WPA53_Wp_Author_Admin
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
     * The nonce key
     *
     * @since    1.0.0
     * @access   private
     */
    private $nonce_key = 'wp_bn_nonce_field';
    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private $version;
    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    /**
     * Register the stylesheets for the backend area.
     *
     * @since    1.0.0
     */
    public function WPA53_enqueue_styles()
    {
		global $pagenow;	
		// To prevent loading css files on all pages, only load in new post and edit post page
		if( isset($_GET['post_type']) && $_GET['post_type'] == 'authors' || 
			(isset($_GET['post']) && is_numeric($_GET['post']) && get_post_type($_GET['post']) == 'authors') ){
			
			// enqueue custom css file 
			wp_enqueue_style( 'wp_author-admin-css', WPA53_PLUGIN_URL . 'backend/css/wp_author-admin.css', array(), $this->version, 'all' );
			
		}
		
		
    }
    
	/**
     * Register the JavaScript for the backend area.
     *
     * @since    1.0.0
     */
    public function WPA53_enqueue_scripts()
    {
		
		// enqueue custom javascript file for custom scripts
		if( isset($_GET['post_type']) && $_GET['post_type'] == 'authors' || 
			(isset($_GET['post']) && is_numeric($_GET['post']) && get_post_type($_GET['post']) == 'authors') ){
			// enqueue custom javascript file for custom scripts
			wp_enqueue_script( 'wp_author-admin', WPA53_PLUGIN_URL. 'backend/js/wp_author-admin.js', array(), $this->version, false );
			}
		
	}
	
	/**
     * Hook for use run scripts which are top priority
     *
     * @since    1.0.0
     */
	public function WPA53_wp_author_rooted_functions(){
		  // Register a custom post type called "author".
		  $labels = array(
					'name'                  => _x( 'Authors', 'Post type general name', 'xpertzgroup' ),
					'singular_name'         => _x( 'Author', 'Post type singular name', 'xpertzgroup' ),
					'menu_name'             => _x( 'Authors', 'Admin Menu text', 'xpertzgroup' ),
					'name_admin_bar'        => _x( 'Author', 'Add New on Toolbar', 'xpertzgroup' ),
					'add_new'               => __( 'Add New', 'xpertzgroup' ),
					'add_new_item'          => __( 'Add New Author', 'xpertzgroup' ),
					'new_item'              => __( 'New Author', 'xpertzgroup' ),
					'edit_item'             => __( 'Edit Author', 'xpertzgroup' ),
					'view_item'             => __( 'View Author', 'xpertzgroup' ),
					'all_items'             => __( 'All Authors', 'xpertzgroup' ),
					'search_items'          => __( 'Search Authors', 'xpertzgroup' ),
					'parent_item_colon'     => __( 'Parent Authors:', 'xpertzgroup' ),
					'not_found'             => __( 'No authors found.', 'xpertzgroup' ),
					'not_found_in_trash'    => __( 'No authors found in Trash.', 'xpertzgroup' ),
					'featured_image'        => _x( 'Author Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'xpertzgroup' ),
					'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'xpertzgroup' ),
					'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'xpertzgroup' ),
					'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'xpertzgroup' ),
					'archives'              => _x( 'Author archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'xpertzgroup' ),
					'insert_into_item'      => _x( 'Insert into author', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'xpertzgroup' ),
					'uploaded_to_this_item' => _x( 'Uploaded to this author', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'xpertzgroup' ),
					'filter_items_list'     => _x( 'Filter authors list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'xpertzgroup' ),
					'items_list_navigation' => _x( 'Authors list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'xpertzgroup' ),
					'items_list'            => _x( 'Authors list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'xpertzgroup' ),
				);
		  $args = array(
			  'labels'             => $labels,
			  'public'             => true,
			  'publicly_queryable' => true,
			  'show_ui'            => true,
			  'show_ui' 		   => true,
			  'menu_position' 	   => 8,
			  'menu_icon' 		   => WPA53_PLUGIN_URL . '/backend/img/authors.png',
			  'show_in_menu'       => true,
			  'query_var'          => false,
			  'rewrite'            => array( 'slug' => 'authors', 'with_front' => false ),
			  'capability_type'    => 'post',
			  'has_archive'        => true,
			  'hierarchical'       => false,
			  'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		  );
		  register_post_type( 'authors', $args );
		}
	
	/**
     * Add post meta box for authors in post edit screen
     *
     * @since    1.0.0
     */
    public function WPA53_add_authors_meta_box()
    {
        add_meta_box(
            'wp_bn_meta_box', // Unique ID
            __( 'Author\'s Personal Detail:', WPA53_PLUGIN_NAME ), // Box title
            array( $this, 'meta_box_display_callback' ), // Content callback, must be of type callable
            'authors', // Post type
            'normal', // context
            'high'     // priority
        );
    }
	
    /**
     * custom meta box html fields
     * includes checkbox, inputs
     *
     * @since    1.0.0
     */
    public function meta_box_display_callback( $post )
    {
        if ( function_exists( 'wp_nonce_field' ) ) {
            wp_nonce_field( 'wpl_nonce', $this->nonce_key );
        }
        include 'metafields/wp_author-edit-post-display.php';
    }
    /**
     * Save authors meta data
     *
     * @since    1.0.0
     */
    function save_postdata( $post_id )
    {	//Check it's not an auto save routine
		 if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
			  return;
	
		//Perform permission checks! For example:
		if ( !current_user_can('edit_post', $post_id) ) 
			  return;
		  
		$post_type = get_post_type($post_id);
		if($post_type == 'authors'){$last_name = '';
			
			// if this fails, check_admin_referer() will automatically print a "failed" page and die.
			if ( ! isset( $_POST[ $this->nonce_key ] ) || ! check_admin_referer( 'wpl_nonce', $this->nonce_key ) ) {
				return $post_id;
			}
	
			// Check the user's permissions
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
	
			// Check the if is auotsave
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}
	
			
			// save data
			if ( isset( $_POST['first_name'] ) ) {
				$first_name = sanitize_text_field( $_POST['first_name'] );
				update_post_meta( $post_id, 'first_name', $first_name );
			}
	
			if ( isset( $_POST['last_name'] ) ) {
				$last_name = sanitize_text_field( $_POST['last_name'] );
				update_post_meta( $post_id, 'last_name', $last_name );
			}
	
			if ( isset( $_POST['bio'] ) ) {
				//update_post_meta( $post_id, 'bio', sanitize_textarea_field( $_POST['bio'] ) );
				update_post_meta( $post_id, 'bio', sanitize_textarea_field( $_POST['bio'] ) );
			}

			if ( isset( $_POST['fb_url'] ) ) {
				update_post_meta( $post_id, 'fb_url', esc_url_raw( $_POST['fb_url'] ) );
			}

			if ( isset( $_POST['lnk_url'] ) ) {
				update_post_meta( $post_id, 'lnk_url', esc_url_raw( $_POST['lnk_url'] ) );
			}
	
			if ( isset( $_POST['wp_user_assgn'] ) ) {
				update_post_meta( $post_id, 'wp_user_assgn', sanitize_text_field( $_POST['wp_user_assgn'] ) );
			}
	
	
			if( isset($_POST['author_img']) ){
				  update_post_meta( $post_id, 'author_img', sanitize_text_field( $_POST['author_img'] ) );
				}
			
			if ( isset( $_POST['author_gallery'] ) ) {
				update_post_meta( $post_id, 'author_gallery', sanitize_text_field( $_POST['author_gallery'] ) );
			}
		  
		  if(!empty($first_name) || !empty($last_name))		  
		  {
			  $post_name = sanitize_title($first_name.'-'.$last_name);
			  //If calling wp_update_post, unhook this function so it doesn't loop infinitely
			  remove_action('save_post', array($this, 'save_postdata'), 30);
			  $update_post = array(
							  'ID'           => $post_id,
							  'post_name' => $post_name,
						  );
			  wp_update_post( $update_post );
			  // re-hook this function
			  add_action( 'save_post', array($this, 'save_postdata'), 30 );	
		  }
		  
		  }
		}	
}