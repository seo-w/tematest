<?php
if ( $property_images || ( $property_video_provider && $property_video_id && has_post_thumbnail() && $property_video_lacation == 'above' ) ) {

if ( $layout == "full-width" ) { echo '<div class="container">'; }
?>
<div id="property-thumbnails">
	<?php
	$i = 1;

	// Property Video
	if ( $property_video_provider != 'none' && $property_video_id ) {

		if ( ( $property_image_location == 'above' && $property_video_location == 'above' ) || ( $property_image_location == 'begin' && $property_video_location == 'begin' ) ) {
			if ( $property_video_provider == 'youtube' ) {
				$video_thumbnail_output  = '<div class="property-video-thumbnail" style="background-image:url(//img.youtube.com/vi/' . $property_video_id . '/0.jpg)" />';
				$video_thumbnail_output .= '<a href="#slide'. $i .'"><img src="' . get_template_directory_uri()  . '/lib/images/placeholder-600x300.png" /></a>';
				$video_thumbnail_output .= '</div>';
			}
			
			if ( $property_video_provider == 'vimeo' ) {
				
				function tt_get_vimeo_thumb( $id, $size = 'thumbnail_large' ) {
				  if( get_transient( 'vimeo_' . $size . '_' . $id ) ) {
					$thumb_image = get_transient( 'vimeo_' . $size . '_' . $id );
				  } else {
					  if ( is_ssl() ) {
						$json = json_decode( file_get_contents( "https://vimeo.com/api/v2/video/" . $id . ".json" ) );
					}
					else {
						$json = json_decode( file_get_contents( "http://vimeo.com/api/v2/video/" . $id . ".json" ) );
					}
					$thumb_image = $json[0]->$size;
					set_transient('vimeo_' . $size . '_' . $id, $thumb_image, 2629743);
				  }
				  return $thumb_image;
				}
				
				$video_thumbnail_output  = '<div class="property-video-thumbnail" style="background-image:url(' . tt_get_vimeo_thumb( $property_video_id ) . ')" /><a href="#slide'. $i .'">';
				$video_thumbnail_output .= '<img src="' . tt_get_vimeo_thumb( $property_video_id ) . '" />';
				$video_thumbnail_output .= '</a></div>';
			}
			
			echo $video_thumbnail_output;
			
			$i++;
			
		}
		
	}

	// Gallery Images
	if ( $property_images ) {
		
		foreach ( $gallery_array as $slide ) {
			$attachment = wp_get_attachment_image_src( $slide->ID, 'property-thumb' );
			$attachment_url = $attachment[0];
			echo '<div><a href="#slide'. $i .'"><img src="' . $attachment_url . '" alt="" /></a></div>';
			$i++;
		}
		
	} 
	
	// Featured Image Only
	else {
		
		$thumbnail_attr = array(
			'title' => wp_get_attachment_meta_data_title(), 
			'data-title' => wp_get_attachment_meta_data_title(), 
			'data-mfp-src' => wp_get_attachment_url( get_post_thumbnail_id() ),
		);
					
		echo '<div><a href="#slide'. $i .'">';
		the_post_thumbnail( 'property-thumb', $thumbnail_attr );
		echo '</a></div>';
		$i++;
		
	}
	?>
</div>
<?php if ( $layout == "full-width" ) { echo '</div>'; }

}