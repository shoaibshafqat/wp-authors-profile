<?php

/**
 * This file is used to add metafields in metabox for posts
 *
 * @package    Wp_Author_WPA
 * @subpackage Wp_Author_WPA/classes
 * @author     Shoaib Shafqat <shoaibshafqat@gmail.com>
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
// get post meta array of current post
$post_metas = get_post_meta( $post->ID );
// get fields value from post meta array
$first_name = isset( $post_metas['first_name'][0] ) ? $post_metas['first_name'][0] : '';
$last_name = isset( $post_metas['last_name'][0] ) ? $post_metas['last_name'][0] : '';
$bio =  isset( $post_metas['bio'][0] ) ? $post_metas['bio'][0] : '';
$fb_url = isset( $post_metas['fb_url'][0] ) ? $post_metas['fb_url'][0] : '';
$lnk_url = isset( $post_metas['lnk_url'][0] ) ? $post_metas['lnk_url'][0] : '';
$wp_user_assgn = isset( $post_metas['wp_user_assgn'][0] ) ? $post_metas['wp_user_assgn'][0] : 0;
$gallery_ids = '';

if( !empty( $post_metas['author_gallery'][0] ) ){
	$gallery_ids = $post_metas['author_gallery'][0];  
	}?>

<!-- Metabox fields container start -->
<ul class="bn_container">
    <!-- Set authors -->
    <li class="bn_fieldset">
        <label for="first_name" class="bn_label"><?php esc_html_e( 'First name:', WPA53_PLUGIN_NAME ) ?></label>        
        <input value="<?php echo esc_attr($first_name) ?>" required="required" type="text" name="first_name" id="first_name" class="bn_text_input" pattern="[A-Za-z ]+" title="Only alphabets are allowed"/>
		
    </li>
    
    <li class="bn_fieldset">
        <label for="last_name" class="bn_label"><?php esc_html_e( 'Last Name:', WPA53_PLUGIN_NAME ) ?></label>
        <input type="text" name="last_name" id="last_name" class="bn_text_input" value="<?php echo esc_attr( $last_name ); ?>" pattern="[A-Za-z ]+" title="Only alphabets are allowed"/>
    </li>
    
    <li class="bn_fieldset">
        <label for="bio" class="bn_label"><?php esc_html_e( 'Biography:', WPA53_PLUGIN_NAME ) ?></label>
        <textarea name="bio" id="bio" cols="50" class="bn_text_input" rows="5"><?php echo esc_attr( $bio ); ?></textarea>
    </li>
    
    <li class="bn_fieldset">
        <label for="fb_url" class="bn_label"><?php esc_html_e( 'Facebook URL:', WPA53_PLUGIN_NAME ) ?></label>
        <input type="url" name="fb_url" id="fb_url" class="bn_text_input" value="<?php echo esc_attr( $fb_url ); ?>"/>
    </li>
    
    <li class="bn_fieldset">
        <label for="lnk_url" class="bn_label"><?php esc_html_e( 'Linkedin URL:', WPA53_PLUGIN_NAME ) ?></label>
        <input type="url" name="lnk_url" id="lnk_url" class="bn_text_input" value="<?php echo esc_attr( $lnk_url ); ?>"/>
    </li>
    
    <li class="bn_fieldset">
        <label for="wp_user_assgn" class="bn_label"><?php esc_html_e( 'Assign Wp Users:', WPA53_PLUGIN_NAME ) ?></label>
        <?php wp_dropdown_users( array('option_none_value' => '', 'show_option_none' => 'Assign to wp user', 'name' => 'wp_user_assgn', 'orderby' => 'display_name', 'order' => 'ASC', 'selected' => esc_attr( $wp_user_assgn )) ); ?>
    </li>
    
    <li class="bn_fieldset">
        <label for="author_gallery" class="bn_label"><?php esc_html_e( 'Image gallery:', WPA53_PLUGIN_NAME ) ?></label>
        <?php $gallery_html = null;
			  if($gallery_ids){
				  $gallery_html .= '<ul class="author_gallery_list">';
				  $gallery_array = explode(',', $gallery_ids);
				  foreach ($gallery_array as $gallery_list) {
						  $gallery_html .='<li>
											<div class="author_gallery_container">
											  <span id="'.$gallery_list.'" class="author_gallery_close"></span>
												<img id="close-id'.esc_attr($gallery_list). '" src="' .wp_get_attachment_thumb_url($gallery_list). '">
											 </div>
										   </li>';
					}
					$gallery_html .= '</ul>';
			  }?>
		<input id="author_gallery" type="hidden" name="author_gallery" value="<?php echo esc_attr($gallery_ids) ?>" />
		<span id="author_gallery_src"><?php echo $gallery_html ?></span>
		<div class="shift8_gallery_button_container">
          <input id="author_gallery_button" class="button" type="button" value="Add Gallery" />
        </div>
    </li>
    
</ul>
<!-- Metabox fields container end -->