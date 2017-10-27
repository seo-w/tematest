<div class="property-image-container <?php if ( ! $property_images ) { echo 'single '; } echo $realty_theme_option['property-image-height'] . ' ' . $fit_or_cut; ?>">

	<div class="spinner">
	  <div class="bounce1"></div>
	  <div class="bounce2"></div>
	  <div class="bounce3"></div>
	</div>
	
	<?php
	$property_video_provider = get_post_meta( $post->ID, 'estate_property_video_provider', true );
	$property_video_id = get_post_meta( $post->ID, 'estate_property_video_id', true );
	
	if ( $property_video_provider == 'youtube' ) {
		if ( is_ssl() ) {
			$property_video_url = 'https://youtube.com/watch?v=' . $property_video_id;
		} else {
			$property_video_url = 'http://youtube.com/watch?v=' . $property_video_id;
		}
	}
	
	if ( $property_video_provider == 'vimeo' ) {
		if ( is_ssl() ) {
			$property_video_url = 'https://player.vimeo.com/video/' . $property_video_id;
		} else {
			$property_video_url = 'http://player.vimeo.com/video/' . $property_video_id;
		}
	}
	
	echo '<div class="fluid-width-video-wrapper">' . wp_oembed_get( $property_video_url ) . '</div>';
	?>
</div><!-- .property-image-container -->