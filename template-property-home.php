<?php 
/*
Template Name: Single Property Home
*/
get_header(); 
$single_property_id = get_post_meta( $post->ID, 'estate_single_property_id', true );
$hide_sidebar = get_post_meta( $post->ID, 'estate_page_hide_sidebar', true );
if( !empty( $single_property_id ) ) {
	
	$additional_groups = array();
	if(tt_acf_active()){
		
	  $additional_groups = tt_acf_group_id_property();
	
	}
	$single_property = new WP_Query( array('post_type' => 'property','p' => $single_property_id )  );
	while ( $single_property->have_posts() ) : $single_property->the_post();
	global $post;
	
	$property_location = get_the_terms( $post->ID, 'property-location' );
	$property_status = get_the_terms( $post->ID, 'property-status' );
	$property_type = get_the_terms( $post->ID, 'property-type' );
	$property_features = get_the_terms( $post->ID, 'property-features' );
	$date_format = get_option( 'date_format' );
	$available_from = get_post_meta( $post->ID, 'estate_property_available_from', true );
	$available_from_create_date = date_create( $available_from );
	$available_from_date = date_i18n(get_option( 'date_format' ), strtotime( $available_from) );
	$today = current_time( $date_format );
	$last_updated_on = date_i18n( get_option( 'date_format' ), strtotime( $post->post_modified ) );
	
	if ( ! empty( $available_from ) ) {
		$available_from_meta = get_field_object( 'estate_property_available_from', $post->ID );
		$available_from_label = $available_from_meta['label'];
	}
	
	$single_property_layout = get_post_meta( $post->ID, 'estate_property_layout', true );
	$property_status_update = get_post_meta( $post->ID, 'estate_property_status_update', true );
	$property_video_provider = get_post_meta( $post->ID, 'estate_property_video_provider', true );
	$property_video_id = get_post_meta( $post->ID, 'estate_property_video_id', true );
	$property_images = get_post_meta( $post->ID, 'estate_property_gallery', true );
	$featured = get_post_meta( $post->ID, 'estate_property_featured', true );
	$property_id = get_post_meta( $post->ID, 'estate_property_id', true );
	$google_maps = get_post_meta( $post->ID, 'estate_property_google_maps', true );
	
	if ( ! tt_is_array_empty( $google_maps ) ) {
		$address = $google_maps['address'];
	}
	
	$price = intval( get_post_meta( $post->ID, 'estate_property_price', true ) );
	$size = get_post_meta( $post->ID, 'estate_property_size', true );
	
	if ( ! empty( $size ) ) {
		$size_meta = get_field_object( 'estate_property_size', $post->ID );
		$size_label = $size_meta['label'];
	}
	
	$size_unit = get_post_meta( $post->ID, 'estate_property_size_unit', true );
	$rooms = get_post_meta( $post->ID, 'estate_property_rooms', true );
	
	if ( ! empty( $rooms ) ) {
		$rooms_meta = get_field_object('estate_property_rooms', $post->ID);
		$rooms_label = $rooms_meta['label'];
	}
	
	$bedrooms = get_post_meta( $post->ID, 'estate_property_bedrooms', true );
	
	if ( ! empty( $bedrooms ) ) {
		$bedrooms_meta = get_field_object( 'estate_property_bedrooms', $post->ID );
		$bedrooms_label = $bedrooms_meta['label'];
	}
	
	$bathrooms = get_post_meta( $post->ID, 'estate_property_bathrooms', true );
	
	if ( ! empty ( $bathrooms ) ) {
		$bathrooms_meta = get_field_object( 'estate_property_bathrooms', $post->ID );
		$bathrooms_label = $bathrooms_meta['label'];
	}
	
	$garages = get_post_meta( $post->ID, 'estate_property_garages', true );
	
	if ( ! empty( $garages ) ) {
		$garages_meta = get_field_object( 'estate_property_garages', $post->ID );
		$garages_label = $garages_meta['label'];
	}
	
	$agent = get_post_meta( $post->ID, 'estate_property_custom_agent', true );
	$property_contact_information = get_post_meta( $post->ID, 'estate_property_contact_information', true );
	$property_attachments_acf = get_field( 'estate_property_attachments_repeater', $post->ID );
	
	$property_attachments = array();
	
	if( $property_attachments_acf ) {    
		while( has_sub_field( 'estate_property_attachments_repeater' ) ) { 
			$property_attachment = get_sub_field( 'estate_property_attachment' );
			if ( isset( $property_attachment['id'] ) ) {
				$property_attachments[] = $property_attachment['id'];
			}
		}
	}
	
	$property_floor_plans = get_field( 'estate_property_floor_plans', $post->ID );
	
	if( $property_floor_plans  ) { 
		   
		$property_floor_plan_title = array();
		$property_floor_plan_price = array();
		$property_floor_plan_size = array();
		$property_floor_plan_rooms = array();
		$property_floor_plan_bedrooms = array();
		$property_floor_plan_bathrooms = array();
		$property_floor_plan_description = array();
		$property_floor_plan_image = array();
		
		while( has_sub_field('estate_property_floor_plans') ) { 
			$property_floor_plan_title[] = get_sub_field( 'acf_estate_floor_plan_title');
			$property_floor_plan_price[] = get_sub_field( 'acf_estate_floor_plan_price');
			$property_floor_plan_size[]= get_sub_field( 'acf_estate_floor_plan_size');
			$property_floor_plan_rooms[] = get_sub_field( 'acf_estate_floor_plan_rooms');
			$property_floor_plan_bedrooms[] = get_sub_field( 'acf_estate_floor_plan_bedrooms');
			$property_floor_plan_bathrooms[] = get_sub_field( 'acf_estate_floor_plan_bathrooms');
			$property_floor_plan_description[] = get_sub_field( 'acf_estate_floor_plan_description');
			$property_floor_plan_image[] = get_sub_field( 'acf_estate_floor_plan_image');
		}
		
	}
	
	global $realty_theme_option;
	
	$show_property = true;
	
	if ( $realty_theme_option['property-show-login-users'] && ! is_user_logged_in() ) {
		$show_property = false;
	}
	
	if ( $show_property == true ) {
		
		$property_layout = $realty_theme_option['property-layout'];
		$property_image_location = $realty_theme_option['property-image-location'];
		$property_video_location = $realty_theme_option['property-video-location'];
		$property_meta_data_type = $realty_theme_option['property-meta-data-type'];
		$property_title_details = $realty_theme_option['property-title-details'];
		$property_title_additional_details = $realty_theme_option['property-title-additional-details'];
		$property_title_features = $realty_theme_option['property-title-features'];
		$property_title_attachments = $realty_theme_option['property-title-attachments'];
		$property_title_floor_plan = $realty_theme_option['property-title-floor-plan'];
		$property_title_agent = $realty_theme_option['property-title-agent'];
		$social_sharing = $realty_theme_option['property-social-sharing'];
		$show_property_contact_form = $realty_theme_option['property-contact-form'];
		$property_contact_form_default_email = $realty_theme_option['property-contact-form-default-email'];
		$property_image_height = $realty_theme_option['property-contact-form-default-email'];
		$property_floor_plan_disable = $realty_theme_option['property-floor-plan-disable'];
		$property_image_width = $realty_theme_option['property-image-width'];
		
		$show_agent_information = $realty_theme_option['property-agent-information'];
		$if_show_agent_info = true;
		
		if ( $realty_theme_option['property-show-agent-to-logged-in-users'] && ! is_user_logged_in() ) {
			$if_show_agent_info = false;
			
		} else {
			$if_show_agent_info = true;
		}
		
		if ( ! isset( $property_image_width ) ) {
			$property_image_width = "full";
		}
		
		if ( $realty_theme_option['property-lightbox'] != "none" ) {
			$property_zoom = ' zoom';
		} else {
			$property_zoom = null;
		}
		
		if ( $realty_theme_option['property-image-height-fit-or-cut'] ) {
			$fit_or_cut = $realty_theme_option['property-image-height-fit-or-cut'];
		} else {
			$fit_or_cut = null;
		}
		
		if ( $single_property_layout == "theme_option_setting" || $single_property_layout == "" ) {
			if ( $property_layout == "layout-full-width" ) {
				$layout = "full-width";
			} else {
				$layout = "boxed";
			}
		} else {
			if ( $single_property_layout == "full_width" ) {
				$layout = "full-width";
			} else {
				$layout = "boxed";
			}
		}
		
		function wp_get_attachment_meta_data_title() {
			$attachment = get_post( get_post_thumbnail_id() );
			return $attachment->post_title;
		}
		?>
		
		<?php if ( $layout == "full-width" ) { echo '</div>'; } // .container ?>
		
		<div id="property-layout-<?php echo $layout; ?>">
			<?php 
			if ( $property_image_location == 'above' ) { 
			 
			  include TEMPLATEPATH . '/lib/inc/template/property-slideshow.php';
				 
			}
	
			// When only video is shown "above"
			if ( $property_image_location == 'begin' && $property_video_location == 'above' && $property_video_provider != 'none' && $property_video_id ) {
				include TEMPLATEPATH . '/lib/inc/template/property-video.php';
			} 
			?>
			
			<?php 
			// Property Title Style
			if ( $realty_theme_option['property-title-style'] ) {
				$property_header_title_style = $realty_theme_option['property-title-style'];
			}
			else {
				$property_header_title_style = null;
			}
			
			
			// Check if property header has no background video and image
			if ( ( $property_image_location == 'begin' && $property_video_location == 'begin' ) || ( $property_image_location == 'begin' && $property_video_location == 'above' && ( $property_video_provider == 'none' || ! $property_video_id ) ) ) {
				$property_header_media_class = ' no-media';
			} else {
				$property_header_media_class = null;
			}
			
			// Property Header Meta
			$type = '';
			$property_header_meta = tt_property_price();
			if ( $property_type ) { 
				foreach ( $property_type as $type ) { 
					$property_header_meta .= ' &middot; ' . $type->name; 
					break; 
				} 
			}
			if ( $property_status ) { 
				foreach ( $property_status as $status ) { 
					$property_header_meta .= ' &middot; ' . $status->name; 
					break; 
				} 
			}
			
			?>
			
			<div class="property-header-container primary-tooltips <?php echo $property_header_title_style . $property_header_media_class; ?>">
				
				<?php if ( $layout == "full-width" ) { echo '<div class="container">'; } ?>
					
				<div class="property-header">
					<h1 class="title">
						<span><?php echo get_the_title(); ?></span>
						<div class="clearfix mobile"></div>
						<span><?php echo tt_add_remove_favorites(); ?></span>
						<span><a href="#location"><i class="fa fa-map-marker" data-toggle="tooltip" title="<?php _e( 'Show Location', 'tt' );  ?>"></i></a></span>
						<span><?php echo tt_add_remove_follow(); ?></span>
						<span><a href="#" class="hide-title" data-toggle="tooltip" title="<?php _e( 'Hide Title', 'tt' );  ?>"><i class="fa fa-arrow-up"></i></a></span>
					</h1>
					<div class="clearfix"></div>
					<div class="meta"><?php echo $property_header_meta; ?></div>
					<div class="clearfix"></div>
					<?php if ( $property_status_update ) { echo '<div class="status-update">' . $property_status_update . '</div>'; } ?>
				</div>
			
				<i class="show-title fa fa-arrow-down" data-toggle="tooltip" data-placement="bottom" title="<?php _e( 'Show Title', 'tt' );  ?>"></i>	
				
				<?php if ( $layout == "full-width" ) { echo '</div>'; } ?>
					
			</div><!-- .property-header-container -->
			
		</div>
		
		<?php
		if ( $property_image_location == 'above' && $realty_theme_option['property-slideshow-navigation-type'] == 'thumbnail' ) { 
			include TEMPLATEPATH . '/lib/inc/template/property-slideshow-thumbnails.php'; 
		}
	
		if ( $layout == "full-width" ) { echo '<div class="container">'; }
		
		//wp_reset_postdata(); 
		?>
				
		<div class="property-meta primary-tooltips">
			
			<div class="row">
				
				<?php 
				// Use Custom Meta Data
				if ( $property_meta_data_type == "custom" ) { 
		
					$property_meta_data_field = $realty_theme_option['property-custom-meta-data-field'];
					$property_meta_data_icon_class = $realty_theme_option['property-custom-meta-data-icon-class'];
					$property_meta_data_label = $realty_theme_option['property-custom-meta-data-label'];
					$property_meta_data_label_plural = $realty_theme_option['property-custom-meta-data-label-plural'];
					$property_meta_data_tooltip = $realty_theme_option['property-custom-meta-data-tooltip'];
		
					$i = 0;
					
					foreach ( $property_meta_data_field as $field_type ) {
						
						switch ( $field_type ) {
							
							case 'estate_property_id' :
							if ( $realty_theme_option['property-id-type'] == "custom_id" ) {
								$field = $property_id;
							}
							else {
								$field = $post->ID;
							}
							break;
							
							case 'estate_property_available_from' :
							$create_date = date_create( $field );
							$field = date_format( $create_date, $date_format );	
							break;
							
							case 'estate_property_updated' :
							$field = $last_updated_on;	
							break;
							
							case 'estate_property_views' :
							$field = tt_get_property_views($post->ID);	
							break;
							
							case 'estate_property_size' :
							$size_unit = get_post_meta( $post->ID, 'estate_property_size_unit', true );
							$field = get_post_meta( $post->ID, $field_type, true );
							$field = $field . ' ' . $size_unit;
							break;
							
							default :
							$field = get_post_meta( $post->ID, $field_type, true );
							break;
							
						}
						?>
						<?php if( !empty ($field)){ ?>
						<div class="col-sm-4 col-md-3">
							<div class="meta-title"><i class="fa <?php echo $property_meta_data_icon_class[$i]; ?>"></i></div>
							<div class="meta-data" data-toggle="tooltip" title="<?php echo _n( __( $property_meta_data_label[$i], 'tt' ), __( $property_meta_data_label_plural[$i], 'tt' ), $field, 'tt' ); ?>">
								<?php
								echo $field;
								if ( $property_meta_data_tooltip[$i] == false ) {
									echo ' ' . _n( __( $property_meta_data_label[$i], 'tt' ), __( $property_meta_data_label_plural[$i], 'tt' ), $field, 'tt' );
								}
								?>
							</div>
						</div>
						<?php } ?>
						<?php 
						$i++;
					}
				} 
				// Default Meta Data
				else {
				
					if ( $available_from ) { ?>
					<div class="col-sm-4 col-md-3">
						<div class="meta-title"><i class="fa fa-calendar-o"></i></div>
						<div class="meta-data" data-toggle="tooltip" title="<?php _e( $available_from_label, 'tt' ); ?>"><?php echo $available_from_date; // if ( $available_from_date <= $today ) { echo '<i class="fa fa-check"></i>'; } ?></div>
					</div>
					<?php }
					if ( $size ) { ?>
					<div class="col-sm-4 col-md-3">
						<div class="meta-title"><i class="fa fa-expand"></i></div>
						<div class="meta-data" data-toggle="tooltip" title="<?php _e( $size_label, 'tt' ); ?>"><?php echo $size . ' ' . $size_unit; ?></div>
					</div>
					<?php }
					if ( $rooms ) { ?>
					<div class="col-sm-4 col-md-3">
						<div class="meta-title"><i class="fa fa-building-o"></i></div>
						<div class="meta-data" data-toggle="tooltip" title="<?php echo __( $rooms_label, 'tt' ); ?>"><?php echo $rooms . ' ' . _n( __( $rooms_label, 'tt' ), __( $rooms_label, 'tt' ), $rooms, 'tt' ); ?></div>
					</div>
					<?php }
					if ( $bedrooms ) { ?>
					<div class="col-sm-4 col-md-3">
						<div class="meta-title"><i class="fa fa-bed"></i></div>
						<div class="meta-data" data-toggle="tooltip" title="<?php echo __( $bedrooms_label, 'tt' ); ?>"><?php echo $bedrooms . ' ' . _n( __( $bedrooms_label, 'tt' ), __( $bedrooms_label, 'tt' ), $bedrooms, 'tt' ); ?></div>
					</div>
					<?php }
					if ( $bathrooms ) { ?>
					<div class="col-sm-4 col-md-3">
						<div class="meta-title"><i class="fa fa-tint"></i></div>
						<div class="meta-data" data-toggle="tooltip" title="<?php echo __( $bathrooms_label, 'tt' ); ?>"><?php echo $bathrooms . ' ' . _n( __( $bathrooms_label, 'tt' ), __( $bathrooms_label, 'tt' ), $bathrooms, 'tt' ); ?></div>
					</div>
					<?php }
					if ( $garages ) { ?>
					<div class="col-sm-4 col-md-3">
						<div class="meta-title"><i class="fa fa-car"></i></div>
						<div class="meta-data" data-toggle="tooltip" title="<?php echo __( $garages_label, 'tt' ); ?>"><?php echo $garages . ' '. _n( __( $garages_label, 'tt' ), __( $garages_label, 'tt' ), $garages, 'tt' ); ?></div>
					</div>
					<?php } ?>
					<?php 
					if ( $realty_theme_option['property-id-type'] == "post_id" ) {
					  $estate_property_id = $post->ID;
					}
					else {
					  $estate_property_id = $property_id;
					}
					?>
					<?php if ( !empty ($estate_property_id )) { ?>
					<div class="col-sm-4 col-md-3">
						<div class="meta-title"><i class="fa fa-slack"></i></div>
						<div class="meta-data" data-toggle="tooltip" title="<?php _e( 'Property ID', 'tt' ); ?>">
							<?php echo $estate_property_id; ?>
						</div>
					</div>
					<?php } ?>
				<?php 
				} 
				if ( ! $realty_theme_option['property-meta-data-hide-print'] ) {
				?>
				<div class="col-sm-4 col-md-3">
					<a href="#" id="print">
						<div class="meta-title"><i class="fa fa-print"></i></div>
						<div class="meta-data"><?php _e( 'Print this page', 'tt' ); ?></div>
					</a>
				</div>
				<?php
				}
				?>			
			</div>
			
		</div><!-- .property-meta -->
	
		<div class="row">
		
			<?php
			if ( ! $hide_sidebar && is_active_sidebar( 'sidebar_property' ) ) {
				echo '<div class="col-sm-8 col-md-9">';
			} 
			else {
				echo '<div class="col-sm-12">';
			}
			?>
			
			<div id="main-content" class="content-box">
				
		  <?php if ( $property_image_location == 'begin' || $property_video_location == 'begin' ) {
			  if ( $property_image_location == 'begin' ) { ?>
			  <section id="property-slider-below">
				<?php } else { ?>
				<section id="property-video">
					<?php }
					if( $property_image_location == 'above' ){
						if ( $property_video_id && $property_video_location == 'begin') {
							if ( $property_video_id && ( $property_video_provider == "youtube" || $property_video_provider == "vimeo" ) ) {
								if ( $property_video_provider == 'youtube' ) {
									if ( is_ssl() ) {
										$property_video_url = 'https://youtube.com/watch?v=' . $property_video_id;
									}
									else {
										$property_video_url = 'http://youtube.com/watch?v=' . $property_video_id;
									}
								}
	
								if ( $property_video_provider == 'vimeo' ) {
									if ( is_ssl() ) {
										$property_video_url = 'https://player.vimeo.com/video/' . $property_video_id;
									}
									else {
										$property_video_url = 'http://player.vimeo.com/video/' . $property_video_id;
									}
								}
								require_once( ABSPATH . WPINC . '/class-oembed.php' );
								$oembed = _wp_oembed_get_object();
								$url_video = $oembed->get_html( $property_video_url );
								echo '<div class="fluid-width-video-wrapper">'. $url_video . '</div>';	
							}
						}
					} else {
						
						include TEMPLATEPATH . '/lib/inc/template/property-slideshow.php';
						
						if ( $property_image_location == 'begin' && $realty_theme_option['property-slideshow-navigation-type'] == 'thumbnail' ) { 
							include TEMPLATEPATH . '/lib/inc/template/property-slideshow-thumbnails.php'; 
						}
					}
					?>
					</section>
			<?php } ?>
				
				<section id="property-content">
					<?php 
					if ( $property_title_details ) { echo '<h3 class="section-title"><span>' . __( $property_title_details, 'tt' ) . '</span></h3>'; }
					do_action( 'tt_single_property_content_before' );
					the_content(); 
					do_action( 'tt_single_property_content_after' );
					?>
				</section>
				
				<?php	if ( $property_features ) {	 ?>	
				<section id="property-features" class="primary-tooltips">
					<?php if ( $property_title_features	 ) { echo '<h3 class="section-title"><span>' . __( $property_title_features, 'tt' ) . '</span></h3>'; } ?>
					<ul class="list-unstyled row">
						<?php
						
						$property_features_all = get_terms( 'property-features', array( 'hide_empty' => false ) ); // Get All Property Features
						$property_features_slug = array();
				
						// Built Array With All Property Fe	atures
						foreach ( $property_features as $property_feature ) {
							$property_features_slug[] = $property_feature->slug;
						}
						
						// Loop Thorugh All Featur	es														
						foreach( $property_features_all as $property_feature_item ) {
						
							$property_feature_slug = $property_feature_item->slug;
							$description = $property_feature_item->description;
							$description = wp_trim_words( $description, 10, ' ..' ); 
			
							// Add Class "inactive" To Every F	eature, That This Property Doesn't Have
							if ( !in_array( $property_feature_slug, $property_features_slug ) ) { 
								$inactive = ' class="inactive"'; 	
							}
							else {
								$inactive = '';
							}
								
							if ( !$hide_sidebar && is_active_sidebar( 'sidebar_property' ) ) {
								$output  = '<li class="col-sm-6 col-md-4">';
							} else {
								$output  = '<li class="col-sm-4 col-md-3">';
							}
							
							$output .= '<a href="' . home_url() . '/property-feature/'. $property_feature_item->slug . '"' . $inactive . '>';
							if ( $inactive ) {
								$output .=	'<i class="fa fa-times"></i>';
							} else {
								$output .= '<i class="fa fa-check"></i>';
							}
							
							$output .=  $property_feature_item->name;
							
							if ( $description ) {
								$output	.= '<i class="fa fa-question-circle" data-toggle="tooltip" title="' . __( $description, 'tt' ) . '"></i>';
							}
							
							$output .= '</a>';
							$output .= 	'</li>';
							
							// Theme Option: Hide non applicable property features
							if ( $realty_theme_option['property-features-hide-non-applicable'] && $inactive ) {
								echo '';
							} else {
								echo $output;
							}
						 }
						
						?>
					</ul>
				</section>
				<?php 
				}
				
				
				
				if ( tt_acf_active() && !tt_is_array_empty( $additional_groups ) ) : // Check if ACF plugin is active & for post type "property" field group
					
					$acf_fields_name = tt_acf_fields_name( $additional_groups );
					$acf_fields_label = tt_acf_fields_label( $additional_groups );
					$acf_fields_type = tt_acf_fields_type( $additional_groups );
					
					$acf_fields_count = count( $acf_fields_name );
					$i = 0;
					$empty_field = false;
					if ( $acf_fields_count > 0 ) {
						
						// Themem Option: Property > Additional Details Layout
						if ( ! isset( $realty_theme_option['property-additional-details-layout'] ) || $realty_theme_option['property-additional-details-layout'] == 'grid' ) {
							
							// $output_grid = '<ul class="list-unstyled row">';
							$output_grid = '';
		
							foreach( $acf_fields_name as $field_name ) {
								
								if ( $acf_fields_type[$i] == 'taxonomy' ) {
									
									$taxonomy_value = get_field_object( $field_name, $post->ID );
									
									$field_terms = get_the_terms( $post->ID,$taxonomy_value['taxonomy'] );
									$field = array();
									if ( $field_terms && ! is_wp_error( $field_terms ) ) : 
										foreach( $field_terms as $term ) {
											$field[]= '<a href="'. get_term_link( $term->term_id, $term->taxonomy ).'">' . $term->name . '</a>';
										}
									endif;
									
								} else if ( $acf_fields_type[$i] == 'file' ) {
									$file = get_field( $field_name, $post->ID );
									$field = tt_icon_attachment( $file['type'] ) . ' ' . '<a href="' . $file['url'] . '" target="_blank">' . $file['filename'] . '</a>';
								}
								else {
									$field = get_field( $field_name, $post->ID );
								}
								//echo $field;
								if ( empty( $field ) ) {
									$field = '-';
									$empty_field = true;
								}
								
								if ( ! $hide_sidebar && is_active_sidebar( 'sidebar_property' ) ) {
									$output_inner = '<li class="col-sm-6 col-md-4">';
								} 
								else {
									$output_inner = '<li class="col-sm-4 col-md-3">';
								}
								
								$output_inner .= '<strong>'	 . __( $acf_fields_label[$i], 'tt' ) . ':</strong> ';
								
								if ( is_array( $field ) ) {
									$output_inner .= join( ', ', $field );
									
								} else if ( $acf_fields_type[$i] == 'url' || $acf_fields_type[$i] == 'page_link' ) {
									$output_inner .= '<a href="'.$field.'">'.$field.'</a>';
								} else if( $acf_fields_type[$i] == 'oembed' ) {
									$output_inner .= '<div class="embed-container">Available in tab view only</div>';
								} else {
									$output_inner .= $field;
								}
								$output_inner .= '</li>';
								
								if ( $empty_field == true  && $realty_theme_option['property-additional-details-hide-empty'] ) {
									$output_inner = '';
								} else {
									$output_grid .= $output_inner;
								}
									
								$i++;
								$empty_field = false;
							}
							
							// $output_grid .= '</ul>';
							
							if( ! empty( $output_grid ) || ! $realty_theme_option['property-additional-details-hide-empty'] ){ ?>
								<section id="additional-details">
								<?php if ( $property_title_additional_details ) {
									echo '<h3 class="section-title"><span>' . __( $property_title_additional_details, 'tt' ) . '</span></h3>';
								}
								echo '<ul class="list-unstyled row">'. $output_grid .'</ul>'; ?>
								</section>
							<?php }
							
						} 
						// Tab Layout
						else {
							$output = '<ul class="nav nav-tabs" role="tablist">';
							$tab_head = '';
							$i = 0;
							$tab_view = 0;
							foreach( $acf_fields_name as $field_name ) {
								
								$field = get_field( $field_name, $post->ID );							
								
								if ( empty( $field ) ) {
									$field = '-';
									$empty_field = true;
								}
								
								$tab_head = '';
								
								if ( $realty_theme_option['property-additional-details-hide-empty'] && $empty_field == true ) {
									$tab_head = '';
									
								} else {
									if ( $tab_view == 0 ) {
										
										$tab_head .= '<li role="presentation" class="active">'; 
										$tab_view++;
										
									} else {
										$tab_head .= '<li role="presentation">';
									}
									$tab_head .= '<a href="#additional-' . $i . '" aria-controls="additional-' . $i . '" role="tab" data-toggle="tab">' . __( $acf_fields_label[$i], 'tt' ) . '</a></li>';
								}
								$output.= $tab_head;
								
								$empty_field = false;
								$i++;
								
								
								
							}
							
							$output .= '</ul>';
							
							// Tab content
							$output_tab = '<div class="tab-content">';
							$tab_content ='';
							$empty_field = false;
							$tab_show = false;
							$i = 0;
							$tab_view = 0;
							foreach( $acf_fields_name as $field_name ) {
								
								if ( $acf_fields_type[$i] == 'taxonomy' ) {
									
									$taxonomy_value = get_field_object( $field_name, $post->ID );
							
									$field_terms = get_the_terms( $post->ID, $taxonomy_value['taxonomy'] );
									$field = array();
									
									if ( $field_terms && ! is_wp_error( $field_terms ) ) : 
										foreach( $field_terms as $term ) {
											$field[]= '<a href="'. get_term_link( $term->term_id, $term->taxonomy ).'">' . $term->name . '</a>';
										}
									endif;							
									
								} else if ( $acf_fields_type[$i] == 'file' ) {
									$file = get_field( $field_name, $post->ID );
									$field = tt_icon_attachment( $file['type'] ) . ' ' . '<a href="' . $file['url'] . '" target="_blank">' . $file['filename'] . '</a>';
									
								} else {
									$field = get_field( $field_name, $post->ID );
								}
								
								$tab_content = '';						
								
								if ( empty( $field ) ) {
									$field = '-';
									$empty_field = true;
								} else {
									$tab_show = true;
								}
								
								if ( $realty_theme_option['property-additional-details-hide-empty'] && $empty_field == true ) {
									$tab_content = '-';
								}
								else {
									if ( $tab_view == 0) {
										$tab_content .= '<div role="tabpanel" class="tab-pane active" id="additional-' . $i . '">';
										$tab_view++;
										
									} else {
										$tab_content .= '<div role="tabpanel" class="tab-pane" id="additional-' . $i . '">';
									}
								}
														
								if ( is_array( $field ) ) {
									
									$tab_content .= join( ', ', $field );
									
								} else if ( $acf_fields_type[$i] == 'url' || $acf_fields_type[$i] == 'page_link' ) {
									$tab_content .= '<a href="' . $field . '">' . $field . '</a>';
									
								} else if ( $acf_fields_type[$i] == 'oembed' ) {
									
									$tab_content .= '<div class="embed-container">' . $field . '</div>';
									
								} else {
									
									$tab_content .= $field;
								}
								$tab_content .= '</div>';
								
								if ( $realty_theme_option['property-additional-details-hide-empty'] && $empty_field == true ) {
									$tab_content = '';
								} else {
									$output_tab .= $tab_content;
								}
								$empty_field = false;
								
								$i++;
								
							}
							
							$output_tab .= '</div>';
							
							// echo $output_tab;
	
							if( $tab_show || ! $realty_theme_option['property-additional-details-hide-empty'] ) { ?>
								<section id="additional-details">
								<?php 
								if ( $property_title_additional_details ) {
									
									echo '<h3 class="section-title"><span>' . __( $property_title_additional_details, 'tt' ) . '</span></h3>';
									
								}
								echo $output . $output_tab; 
								?>
								</section>
							<?php }
							
						}
					
					}
					//wp_reset_postdata();
					endif;
				
				if ( ! $property_floor_plan_disable && ! empty( $property_floor_plan_image[0] ) ) { ?>
                
				<section id="floor-plan" class="primary-tooltips">
					<?php if ( $property_title_floor_plan ) { echo '<h3 class="section-title"><span>' . __( $property_title_floor_plan, 'tt' ) . '</span></h3>'; } ?>
		
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<?php			
					$i = 0;
					
					foreach ( $property_floor_plan_image as $image ) {
					?>
					  <div class="panel panel-default">
						<div class="panel-heading" data-toggle="collapse" data-target="#floor-plan-<?php echo $i; ?>">
						  <h4 class="panel-title"><?php echo $property_floor_plan_title[$i]; ?></h4>
							<div class="details text-muted">
								<small>
								<?php 
										$currency_sign = $realty_theme_option['currency-sign'];
										$currency_sign_position = $realty_theme_option['currency-sign-position'];
										
										if ( $realty_theme_option['price-decimals'] ) {
											$decimals = $realty_theme_option['price-decimals'];
										} else {
											$decimals = 0;
										}
										
										$decimal_point = '.';
										
										if ( $property_floor_plan_price[$i] ) {
											$formatted_price = number_format( $property_floor_plan_price[$i], $decimals, $decimal_point, $realty_theme_option['price-thousands-separator'] );
										} else {
											$formatted_price = 0;
										}
										
										if( $currency_sign_position == 'right' ) {
											$price = $formatted_price . $currency_sign;
										} else {
											$price = $currency_sign . $formatted_price;
										}
										
										if ( $property_floor_plan_price[$i] ) { 
											echo '<span>' . __( 'Price', 'tt' ) . ': ' . $price . '</span>'; 
										}
										
										if ( $property_floor_plan_size[$i] ) { 
											echo '<span>' . __( 'Size', 'tt' ) . ': ' . $property_floor_plan_size[$i] . ' ' . $size_unit . '</span>'; 
										}
										
										if ( $property_floor_plan_rooms[$i] ) { echo '<span>' . __( 'Rooms', 'tt' ) . ': ' . $property_floor_plan_rooms[$i] . '</span>'; }
										if ( $property_floor_plan_bedrooms[$i] ) { echo '<span>' . __( 'Bedrooms', 'tt' ) . ': ' . $property_floor_plan_bedrooms[$i] . '</span>'; }
										if ( $property_floor_plan_bathrooms[$i] ) { echo '<span>' . __( 'Bathrooms', 'tt' ) . ': ' . $property_floor_plan_bathrooms[$i] . '</span>'; } 
										?>
								</small>
							</div>
						</div>
						<div id="floor-plan-<?php echo $i; ?>" class="panel-collapse collapse">
						  <img src="<?php echo $image; ?>" />
						  <?php if ( $property_floor_plan_description[$i] ) { ?>
						  <div class="panel-body"><?php echo $property_floor_plan_description[$i]; ?></div>
						  <?php } ?>
						</div>
					  </div>
					<?php
					$i++;
					}
					?>
					</div>
				
				</section>
				<?php 
				}
				
				// Property Map
				if ( $address || $google_maps ) {
					include TEMPLATEPATH . '/lib/inc/template/google-map-single-property-home.php'; 
				}
		
				// Property Attachments
				if ( ! empty( $property_attachments_acf ) ) {
					echo '<section id="attachments">';
					if ( $property_title_attachments ) { 
					echo '<h3 class="section-title"><span>' . __( $property_title_attachments, 'tt' ) . '</span></h3>'; 
					}
					echo '<ul class="list-unstyled row">';
					foreach ( $property_attachments as $attachment_id ) {
						$attachment_url = wp_get_attachment_url( $attachment_id );
						$attachment_file_type = wp_check_filetype( $attachment_url );
						$attachment_file_type = $attachment_file_type['ext'];
						$output  = '<li class="col-sm-4 col-md-3">';
						$output .= tt_icon_attachment($attachment_file_type) . ' <a href="' . $attachment_url . '" target="_blank">' . get_the_title( $attachment_id ) . '</a>';
						$output .= '</li>';
						echo $output;
					}
					echo '</ul>';
					echo '</section>';
				}
				
				// Property Social Sharing
				if ( $social_sharing ) { 
					echo '<div class="primary-tooltips">' . tt_social_sharing() . '</div>';
				}
				?>
				
			</div><!-- #main-container -->
			
			<?php 
			if ( $if_show_agent_info == true && $show_agent_information ) {
	
				// Property Settings: If "Assign Agent" Selected, Show His/Her Details, Instead Of "Post Auhor"
				if ( $agent ) {
				
				  if ( $property_title_agent ) { 
						echo '<h2 class="section-title"><span>' . __( $property_title_agent, 'tt' ) . '</span></h2>'; 
					}
					
					$company_name = get_user_meta( $agent, 'company_name', true );
					$first_name = get_user_meta( $agent, 'first_name', true );
					$last_name = get_user_meta( $agent, 'last_name', true );
					$email = get_userdata( $agent );
					$email = $email->user_email;
					$office = get_user_meta( $agent, 'office_phone_number', true );
					$mobile = get_user_meta( $agent, 'mobile_phone_number', true );
					$fax = get_user_meta( $agent, 'fax_number', true );
					$website = get_userdata( $agent );
					$website = $website->user_url;
					$website_clean = str_replace( array( 'http://', 'https://' ), '', $website );
					$bio = get_user_meta( $agent, 'description', true );
					$profile_image = get_user_meta( $agent, 'user_image', true );
					$author_profile_url = get_author_posts_url( $agent );
					$facebook = get_user_meta( $agent, 'custom_facebook', true );
					$twitter = get_user_meta( $agent, 'custom_twitter', true );
					$google = get_user_meta( $agent, 'custom_google', true );
					$linkedin = get_user_meta( $agent, 'custom_linkedin', true );
				  
				}	else {
				
					$company_name = get_the_author_meta( 'company_name' );
					$first_name = get_the_author_meta( 'first_name' );
					$last_name = get_the_author_meta( 'last_name' );
					$email = get_the_author_meta('user_email');
					$office = get_the_author_meta('office_phone_number');
					$mobile = get_the_author_meta('mobile_phone_number');
					$fax = get_the_author_meta('fax_number');
					$website = get_the_author_meta('user_url');
					$website_clean = str_replace( array( 'http://', 'https://' ), '', $website );
					$bio = get_the_author_meta('description');
					$profile_image = get_the_author_meta('user_image');
					$author_profile_url = get_author_posts_url( $post->post_author );
					$facebook = get_the_author_meta( 'custom_facebook' );
					$twitter = get_the_author_meta( 'custom_twitter' );
					$google = get_the_author_meta( 'custom_google' );
					$linkedin = get_the_author_meta( 'custom_linkedin' );
				  
				}
				
				// Author/Agent Information
				if ( $show_agent_information && ( $property_contact_information == "all" || $property_contact_information == '' )) {
					
					if($if_show_agent_info == true){
						
					 include TEMPLATEPATH . '/lib/inc/template/agent-information.php'; 
					  
					  
					}
					else {
					  
					  echo '<p class="alert alert-danger">' . __( 'You have to be logged-in to view agent details. Click Login/Register in the top menu.', 'tt' ) . '</p>';	
					  die;
					}
				}
				else {
					//echo '<p class="alert alert-danger">' . __( 'You have to be logged-in to view agent details. Click Login/Register in the top menu.', 'tt' ) . '</p>';	
				}
			
			}
			?>
			
			<?php
			// Check Theme Option + Property Settings For Author Contact Form
			if ( $show_property_contact_form && $property_contact_information != "none" ) { 
				include TEMPLATEPATH . '/lib/inc/template/contact-form.php';
			}
			
			?>
			 
			<?php
			if ( $realty_theme_option['property-show-similar-properties'] ) {
				
				$criteria = $realty_theme_option['property-similar-properties-criteria'];
				$columns = $realty_theme_option['property-similar-properties-columns'];
			
				$args_similar_properties = array(
					'post_type'					=> 'property',
					'posts_per_page' 		=> -1,
					'post__not_in'			=> array( $single_property_id  )
				);
				
				// Theme Options: Similar Properties Criteria
				$tax_query = array();
				
				if ( $property_location ) {
					foreach ( $property_location as $location ) {
						$location = $location->slug; 
						break;
					}
				}
				else {
					$location = "";
				}
				
				if ( $criteria['location'] ) {
					$tax_query[] = array(
						'taxonomy' 	=> 'property-location',
						'field' 		=> 'slug',
						'terms'			=> $location
					);
				}
				
				if ( $criteria['status'] ) {
					$tax_query[] = array(
						'taxonomy' 	=> 'property-status',
						'field' 		=> 'slug',
						'terms'			=> $status
					);
				}
				
				if ( $criteria['type'] ) {
					$tax_query[] = array(
						'taxonomy' 	=> 'property-type',
						'field' 		=> 'slug',
						'terms'			=> $type
					);
				}
				
				$tax_count = count( $tax_query );
				if ( $tax_count > 1 ) {
					$tax_query['relation'] = 'AND';
				}
				
				if ( $tax_count > 0 ) {
					$args_similar_properties['tax_query'] = $tax_query;
				}
				
				$meta_query = array();
			
				if ( $criteria['min_rooms'] ) {
					$meta_query[] = array(
						'key' 			=> 'estate_property_rooms',
						'value' 		=> $rooms,
						'compare'   => '>=',
						'type'			=> 'NUMERIC'
					);
				}
				
				if ( $criteria['max_price'] ) {
					$meta_query[] = array(
						'key' 			=> 'estate_property_price',
						'value' 		=> $price,
						'compare'   => '<=',
						'type'			=> 'NUMERIC'
					);
				}
				
				if ( $criteria['available_from'] ) {
					$meta_query[] = array(
						'key' 			=> 'estate_property_available_from',
						'value' 		=> $available_from,
						'compare'   => '<=',
						'type'			=> 'DATE'
					);
				}
				
				$meta_count = count( $meta_query );
				if ( $meta_count > 1 ) {
				  $meta_query['relation'] = 'AND';
				}
				
				if ( $meta_count > 0 ) {
					$args_similar_properties['meta_query'] = $meta_query;
				}
				
				$query_similar_properties = new WP_Query( $args_similar_properties );
				
				if ( $query_similar_properties->have_posts() ) : 
				
					echo '<div id="similar-properties">';
					echo '<h4 class="section-title"><span>' . __( 'Similar Properties', 'tt' ) . ' (' . $query_similar_properties->found_posts . ')</span></h4>';
					echo '<div id="property-items">';
	
					if ( $columns ) {
						echo '<div class="owl-carousel-' . $columns . '-nav nav-bottom">';
					}
					else {
						echo '<div class="owl-carousel-3-nav nav-bottom">';
					}
					
					while ( $query_similar_properties->have_posts() ) : $query_similar_properties->the_post();
					get_template_part( 'lib/inc/template/property', 'item' );	
					endwhile;
					
					wp_reset_query();
					echo '</div>';
					echo '</div>';
					echo '</div>';
					
				endif; 
			}
			if ( $realty_theme_option['property-comments'] && ( comments_open() || get_comments_number() ) ) {
				comments_template();
			}
			
			?>
			<script>
			jQuery(document).ready(function() {
				
				// Pause autoplay on slide hover, but not on mobile devices.
				var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);			
				if ( isMobile ) {
					var slideshowPauseHover = 'false';
				} else {
					var slideshowPauseHover = 'true';
				}
			  
			  // Property Carousel
				jQuery('#property-carousel').owlCarousel({
				  items: 1,
				  lazyLoad: true,
				  loop: <?php if(count($property_images) > 1){ echo '1'; } else { echo '0';} ?>,
				  margin: 0,
				  <?php if ( $realty_theme_option['property-slideshow-navigation-type'] == 'thumbnail' ) { ?>
				  dots: false,
				  nav: false,
				  URLhashListener: true,
				  <?php } else { ?>
				  dots: true,
				  nav: false,
				  <?php } ?>
				  navText: 		['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
				  autoHeight: false,
				  autoplayTimeout: 3000,
				  <?php if ( $realty_theme_option['property-single-slideshow-autoplay'] == true ) { ?>
				autoplay: true,
				autoplayHoverPause: slideshowPauseHover,
				<?php } ?>
				  <?php if ( $realty_theme_option['property-slideshow-animation-type'] == 'fade' ) { ?>
					animateIn: 'fadeIn',
					animateOut: 'fadeOut',
					<?php } ?>
					<?php if ( $realty_theme_option['enable-rtl-support'] || is_rtl() ) { ?>
					rtl: true,
					<?php } ?>
				});
				
				// Property Thumbnails Carousel
				jQuery('#property-thumbnails').owlCarousel({
					<?php if ( $realty_theme_option['enable-rtl-support'] || is_rtl() ) { ?>
					rtl: true,
					<?php } ?>
					items:      4,
					lazyLoad:   false,
					loop:       false,
					margin:     15,
					dots:       false,
					nav:        true,
					autoHeight: false,
					navText: 		['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
					responsive: {
											0: { items: 2, },
											768: { items: 3, },
											1200: { items: 4, },
											},
				});
				
			});
			jQuery('.spinner').fadeTo(800, 0.5);
			setTimeout(function() {
			  jQuery('.spinner').remove();
			}, 800);
			</script>
			
			</div><!-- .col-sm-9 -->
			
			<?php 
			// Check for Property Sidebar
			if ( ! $hide_sidebar && is_active_sidebar( 'sidebar_property' ) ) : 
			?>
			<div class="col-sm-4 col-md-3">
				<ul id="sidebar">
					<?php dynamic_sidebar( 'sidebar_property' ); ?>
				</ul>
			</div>
			<?php endif; ?>
		</div><!-- .row -->
		<?php 
		  } else {
				echo '<p class="alert alert-danger">' . __( 'You have to be logged-in to view Property Details. Click Login/Register in the top menu.', 'tt' ) . '</p>';	
			} 
			?>
	
			
	<?php /*} else {
			  echo '<p class="alert alert-danger">' . __( 'Please enter a valid property id.', 'tt' ) . '</p>';
			  
		  }*/
		  
		 endwhile;
		  wp_reset_postdata();
} else {
	
	echo '<p class="alert alert-info">' . __( 'Please import settings  "wp-conent/themes/realty/lib/plugins/realty-single-property-site.json" in Custom fields and select the property from list in this page settings.', 'tt' ) . '</p>';	

}
	?>
<style>
.property-meta > div{
	float:inherit;
}
</style>
<?php	  
 get_footer();