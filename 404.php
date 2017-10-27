<?php 
get_header(); 
global $realty_theme_option;
?>	

<div id="main-content" class="content-box">
	
	<?php 
	// Check For Selected 404 Error Page in Theme Options Panel
	if ( !empty($realty_theme_option['404-page']) ) : 
	
		echo do_shortcode( get_post_field( 'post_content', $realty_theme_option['404-page'] ) );
	
	// No Custom 404 page Selected, Show The Following Default 404 Content
	else :
		?>
		<div class="text-center">
			<h1><?php _e( 'Sorry, but the requested page does not exist', 'tt' ); ?></h1>
			<p class="lead-text-muted"><?php _e( 'Maybe a quick search helps you get you back on track.', 'tt' ); ?></p>
		</div>
	
		<?php 
		get_template_part( 'lib/inc/template/search-form' );
		get_template_part( 'lib/inc/template/google-map-multiple-properties' );	
		?>
	
	<?php endif; ?>
	
</div>

</div><!-- .row -->
<?php get_footer(); ?>