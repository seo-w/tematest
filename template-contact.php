<?php get_header();
/*
Template Name: Contact
*/
$hide_sidebar = get_post_meta( $post->ID, 'estate_page_hide_sidebar', true );
$hide_footer_widgets = get_post_meta( $post->ID, 'estate_page_hide_footer_widgets', true );

?>
	</div><!-- .container -->
	
	<?php 
	// Check Contact Theme Option for Googe Maps Visibility
	if ( $realty_theme_option['contact-google-map'] ) { 
	?>

	<script>
	var map;
	function initMap() {
	
		// https://developers.google.com/maps/documentation/javascript/examples/  
	  var mapOptions = {
	    zoom: <?php if($realty_theme_option['contact-map-zoom-level']){ echo $realty_theme_option['contact-map-zoom-level']; } else { echo "11"; } ?>,
	    center: new google.maps.LatLng(-34.397, 150.644),
	    scrollwheel: false,
	    streetViewControl: true,
			disableDefaultUI: true
	  };
	  
	  map = new google.maps.Map(document.getElementById('google-map'), mapOptions);
	  
	  <?php 
		global $realty_theme_option;
		if ($realty_theme_option['style-your-map']==true){ ?>
			if (map_options.map_style!=='') {
				var styles = JSON.parse(map_options.map_style);
				map.setOptions( { styles: styles } );
			}
		<?php } ?> 
	  <?php echo tt_mapMarkers(); ?>

		// https://developers.google.com/maps/documentation/javascript/geocoding
		<?php 
		global $post, $realty_theme_option;
		if ( ! tt_is_array_empty( $realty_theme_option['contact-address'])) {
			$address_all = $realty_theme_option['contact-address'];
			$address = $address_all[0];
			$phone = $realty_theme_option['contact-phone'];
			$mobile = $realty_theme_option['contact-mobile'];
			$email = $realty_theme_option['contact-email'];
			$logo = $realty_theme_option['contact-logo'];
		}
		$logo_src = '';
	
		if( ! tt_is_array_empty( $address_all ) ) {
			$i = 0;
			foreach ( $address_all as $detail ) { 

				if ( isset( $phone[$i] ) ) {
					$phone_number = $phone[$i];
				} else {
					$phone_number = '';
				}
				
				if ( isset( $mobile[$i] ) ) {
					$mobile_number = $mobile[$i];
				} else {
					$mobile_number = '';
				}
				
				if (isset( $email[$i] ) ) {
					$email_id = $email[$i];
				} else {
					$email_id = '';
				}
				
				if ( isset($logo[$i] ) ) {
					$logo_data = $logo[$i];
					$logo_src = '';
					
					if ( ! empty( $logo_data['url'] ) ) {
						$logo_array = wp_get_attachment_image_src( $logo_data['id'], 'medium' );
						$logo_src = $logo_array[0];
						$logo_img = '<img src="' . $logo_array[0] . '" />';
					} else {
						$logo_src = '';
					}			
				}
				?>
		
	  var address = '<?php echo $detail; ?>';
	  geocoder = new google.maps.Geocoder();
	  
	  geocoder.geocode( { 'address': address}, function(results, status) {
	    if (status == google.maps.GeocoderStatus.OK) {
	     
	      map.setCenter(results[0].geometry.location);
				
				
	      var marker = new google.maps.Marker({
	          map: map,
	          position: results[0].geometry.location,
	          icon: customIcon
	      });
	      
	      var logo 		= '<?php echo $logo_src; ?>';
	      var address = '<?php echo $detail; ?>';
	      var phone 	= '<?php echo $phone_number; ?>';
	      var mobile 	= '<?php echo $mobile_number; ?>';
	      var email 	= '<?php echo antispambot(  $email_id ); ?>';
	           
	      // http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/docs/reference.html
				infobox = new InfoBox({
			  content: 	'<div class="map-marker-wrapper">'+
						'<div class="map-marker-container">'+
  						'<div class="arrow-down"></div>'+
							<?php if ( $logo_src ) { ?>'<img src="'+logo+'" style="max-width:50%" />'+<?php } ?>
							'<div class="content">'+
							<?php if ( $detail ) { ?>'<div class="contact-detail"><i class="fa fa-map-marker"></i>'+address+'</div>'+<?php } ?>
							<?php if ( $phone_number ) { ?>'<div class="contact-detail"><i class="fa fa-phone"></i>'+phone+'</div>'+<?php } ?>
							<?php if ( $mobile_number ) { ?>'<div class="contact-detail"><i class="fa fa-mobile"></i>'+mobile+'</div>'+<?php } ?>
							<?php if ( $email_id ) { ?>'<div class="contact-detail"><i class="fa fa-envelope"></i><a href="mailto:'+email+'">'+email+'</a></div>'+<?php } ?>
							'</div>'+
						'</div>'+
			    '</div>',
				  disableAutoPan: false,
				  pixelOffset: new google.maps.Size(-33, -90),
				  zIndex: null,
				  alignBottom: true,
				  closeBoxURL: "<?php echo TT_LIB_URI . '/images/close.png'; ?>",
				  infoBoxClearance: new google.maps.Size(60, 60)
				});
			
			  infobox.open(map, marker);
			  map.panTo(results[0].geometry.location);
			  <?php if($i==0){ ?>
				infobox.show()
				<?php } else { ?>
					infobox.hide();
				<?php } ?>
			  google.maps.event.addListener(marker, 'click', function() {					    	
		    	if ( infobox.getVisible() ) {
			    	infobox.hide();
		    	}
		    	else {
			    	infobox.show();
		    	}						    	
		    	infobox.open(map, marker);
					map.panTo(results[0].geometry.location);						      
				});
				
	      
	    } 
	    else {
	      alert("Geocode was not successful for the following reason: " + status);
	    }
	    
	  });
		var logo 		= '';
		var address = '';
		var phone 	= '';
		var mobile 	= '';
		var email 	= '';
		<?php 
		$i++;
			}
		} 
		?>
		
	}
	
	google.maps.event.addDomListener(window, 'load', initMap);
	google.maps.event.addDomListener(window, 'resize', initMap);
	
	</script>
	
	<div id="map-wrapper" class="map-wrapper">

		<div class="container">
			
			<div id="map-controls" class="map-controls">
				<a href="#" class="control zoom-in" id="zoom-in" data-toggle="tooltip" title="<?php _e( 'Zoom In', 'tt' ); ?>"><i class="fa fa-plus"></i></a>
				<a href="#" class="control zoom-out" id="zoom-out" data-toggle="tooltip" title="<?php _e( 'Zoom Out', 'tt' ); ?>"><i class="fa fa-minus"></i></a>
				<a href="#" class="control map-type" id="map-type" data-toggle="tooltip" title="<?php _e( 'Map Type', 'tt' ); ?>">
					<i class="fa fa-image"></i>
					<ul class="list-unstyled">
						<li id="map-type-roadmap"><?php _e( 'Roadmap', 'tt' ); ?></li>
						<li id="map-type-satellite"><?php _e( 'Satellite', 'tt' ); ?></li>
						<li id="map-type-hybrid"><?php _e( 'Hybrid', 'tt' ); ?></li>
						<li id="map-type-terrain"><?php _e( 'Terrain', 'tt' ); ?></li>
					</ul>
				</a>
				<a href="#" class="control" id="current-location" data-toggle="tooltip" title="<?php _e( 'Radius: 1000m', 'tt' ); ?>"><i class="fa fa-crosshairs"></i> <?php _e( 'Current Location', 'tt' ); ?></a>
			</div>
			
		</div>
			
		<div id="google-map" class="google-map">
			<div class="spinner">
			  <div class="bounce1"></div>
			  <div class="bounce2"></div>
			  <div class="bounce3"></div>
			</div>	
		</div>
		
	</div>
	
	<?php 
	} // END IF Show Google Map
	else {
		tt_page_banner();	
	}
	?>
	<?php
	while ( have_posts() ) : the_post(); 
	?>
	<div class="container">
	
	<div class="row">
	
		<?php 
		// Check for Agent Sidebar
		if ( !$hide_sidebar && is_active_sidebar( 'sidebar_contact' ) ) {
			echo '<div class="col-sm-8 col-md-9">';
		} else {
			echo '<div class="col-sm-12">';
		}
		?>
		
		<div id="main-content" class="content-box template-contact">				
			<?php the_content(); ?>
		</div>
		
		</div><!-- .col-sm-9 -->
		
		<?php 
		// Check for Page Sidebar
		if ( !$hide_sidebar && is_active_sidebar( 'sidebar_contact' ) ) : 
		?>
		<div class="col-sm-4 col-md-3">
			<ul id="sidebar">
				<?php dynamic_sidebar( 'sidebar_contact' ); ?>
			</ul>
		</div>
		<?php endif; ?>
	
	
	</div><!-- .row -->
	
<?php
endwhile;

get_footer(); 
?>