<?php
/**
 * Provide a frontend area to show the authors
 *
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
get_header();
$post_id = get_the_ID();
$post_metas = get_post_meta( $post_id );
$first_name =  isset( $post_metas['first_name'][0] )  ? $post_metas['first_name'][0] : '';
$last_name =  isset( $post_metas['last_name'][0] ) ? $post_metas['last_name'][0] : '';
$bio =  isset( $post_metas['bio'][0] ) ? $post_metas['bio'][0] : '';
$fb_url =  isset( $post_metas['fb_url'][0] )  ? $post_metas['fb_url'][0] : '';
$lnk_url =  isset( $post_metas['lnk_url'][0] )  ? $post_metas['lnk_url'][0] : '';
$wp_user_assgn =  isset( $post_metas['wp_user_assgn'][0] )  ? $post_metas['wp_user_assgn'][0] : '';
$gallery_ids =  isset( $post_metas['author_gallery'][0] )  ? $post_metas['author_gallery'][0] : '';

$plugin_front = new WPA53_Wp_Author_Frontend( WPA53_Wp_AUTHOR_VERSION, WPA53_PLUGIN_NAME );
$releted_posts = !empty($wp_user_assgn) ? $plugin_front->WPA53_author_related_posts(array('author_id' => $wp_user_assgn, 'post_type' => 'post', 'limit' => 10)) : '';			
?>
<!-- Metabox fields container start -->
<div class="bn_container">
  <div class="container">
  <?php while( have_posts() ): the_post();?>
    <div class="row">
      <div class="col-12">
        <?php //echo '<h1>'.esc_html(get_the_title()).'</h1>'; ?>
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?><br />
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
      </div>
      <div class="col-12 authors_info">
        <h4>Author Personal Detail</h4>
        <?php if ( has_post_thumbnail() ) : the_post_thumbnail('thumbnail');endif;        
		if(!empty($first_name) || !empty($last_name )){echo '<div class="name">'.esc_attr($first_name).' '.esc_attr($last_name).'</div>';}
			  if(!empty($bio)){echo '<div class="bio">'.$bio.'</div>';} ?>
        <div class="col-12 pull-right">
          <?php if(!empty($lnk_url)){echo '<span class="social"><a target="_blank" href="'.esc_url($lnk_url).'"><i class="icon linkedin"></i></a></span>';} ?>
          <?php if(!empty($fb_url)){echo '<span class="social"><a target="_blank" href="'.esc_url($fb_url).'"><i class="icon facebook"></i></a></span>';} ?>
        </div>
      </div>
      <div class="col-12">
      <?php if(!empty($gallery_ids)){
              $gallery_array = explode(',', $gallery_ids);
              echo '<h4>Author Gallery</h4><div class="gallery">';
              foreach ($gallery_array as $gallery_list) {
                $image_url = wp_get_attachment_image_url( $gallery_list, 'full', "", array( "class" => "img-responsive" ) );
                echo '<a class="bn_image" title="'.esc_attr(get_the_title($gallery_list)).'" href="'.esc_url($image_url).'"><img src="'.esc_url(wp_get_attachment_thumb_url($gallery_list)).'" /></a>';
                }
            echo '</div>';
          } 
		  
		  ?>
      </div>
      
      <div class="col-12">
        <?php if ( !empty($releted_posts) && $releted_posts->have_posts() ) {
                  echo '<h4>Related Posts</h4><ul class="bn_releted_posts">';
                  while ( $releted_posts->have_posts() ) {
                      $releted_posts->the_post();
                      echo '<li class="col-lg-6 col-12"><a target="_blank" href="'.esc_url(get_permalink()).'">' . esc_html(get_the_title()) . '</a></li>';
                  }
                  echo '</ul>';
              }
              
              /* Restore original Post Data */
              wp_reset_postdata(); ?>
      </div>
      </div>
  <?php endwhile; wp_reset_postdata(); ?>
  </div>
</div>
<!-- Metabox fields container end -->
<?php get_footer(); ?>