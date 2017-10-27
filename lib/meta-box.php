<?php
if ( !function_exists('estate_register_meta_boxes') ) {
	function estate_register_meta_boxes( $meta_boxes ) {
	            
		$prefix = 'estate_';
		
		$agents = array( '' => __( 'None', 'tt' ) );
		// Get all users with role "agent"
		$all_agents = get_users( array( 'role' => 'agent', 'fields' => 'ID' ) );
		foreach( $all_agents as $agent ) { 
			$agents[$agent] = get_user_meta($agent, 'first_name', true ) . ' ' . get_user_meta($agent, 'last_name', true );
		}
		/* TESTIMONIAL
		============================== */
		$meta_boxes[] = array(		
			'id' 						=> 'testimonial_settings',
			'title' 				=> __( 'Testimonial', 'tt' ),
			'pages' 				=> array( 'testimonial' ),
			'context' 			=> 'normal',
			'priority' 			=> 'high',
			'autosave' 			=> true,
			'fields' 				=> array(
				array(
					'name' 					=> __( 'Testimonial Text', 'tt' ),
					'id'   					=> "{$prefix}testimonial_text",
					'type' 					=> 'textarea',
					//'std'  					=> __( '', 'tt' ),
				),
			)
		);
		
		/* POST TYPE "GALLERY"
		============================== */
		$meta_boxes[] = array(		
			'id' 						=> 'post_type_gallery',
			'title' 				=> __( 'Gallery Settings', 'tt' ),
			'pages' 				=> array( 'post' ),
			'context' 			=> 'normal',
			'priority' 			=> 'high',
			'autosave' 			=> true,
			'fields' 				=> array(
				array(
					'name'             => __( 'Gallery Images', 'tt' ),
					'id'               => "{$prefix}post_gallery",
					'type'             => 'image_advanced',
					'max_file_uploads' => 100,
					'force_delete' 		 => false,
				),
			)
		);
		
		/* POST TYPE "Invoice"
		============================== */
		$meta_boxes[] = array(		
			'id' 						=> 'tt_user_invoice',
			'title' 				=> __( 'Invoice Data', 'tt' ),
			'pages' 				=> array( 'invoice' ),
			'context' 			=> 'normal',
			'priority' 			=> 'high',
			'autosave' 			=> true,
			'fields' 				=> array(
			    array(
					'name' 	=> __( 'Invoice Paid?', 'tt' ),
					'id'    => "{$prefix}if_invoice_paid",
					'type' 	=> 'checkbox',
					'std'  	=> 0,
				),
				array(
					'name'	=> __( 'Invoice ID'),
					'id'	  => "{$prefix}invoice_id",
					'desc'	=> '',
					'type' 	=> 'text',
					'std' 	=> ''
				),
				array(
					'name'	=> __( 'User ID'),
					'id'	  => "{$prefix}invoiced_user_id",
					'desc'	=> '',
					'type' 	=> 'text',
					'std' 	=> ''
				),	
				array(
					'name'	=> __( 'Invoice For'),
					'id'	  => "{$prefix}invoice_item_title",
					'desc'	=> '',
					'type' 	=> 'text',
					'std' 	=> ''
				),	
				array(
					'name'	=> __( 'Property Listing Or Package ID'),
					'id'	  => "{$prefix}invoice_item_id",
					'desc'	=> '',
					'type' 	=> 'text',
					'std' 	=> ''
				),	
				array(
					'name'	=> __( 'Payment Method'),
					'id'	  => "{$prefix}invoice_payment_method",
					'desc'	=> '',
					'type' 	=> 'text',
					'std' 	=> ''
				),	
				array(
					'name'	=>  __( 'Amount Paid'),
					'id'	  => "{$prefix}invoice_amount_paid",
					'desc'	=> 'Price Unit Will be same as set in Theme Options',
					'type' 	=> 'text',
					'std' 	=> '',
					'step'     => 0.01
				),	
				array(
					'name'	=>  __( 'Listing Or Package Price'),
					'id'	  => "{$prefix}invoice_item_price",
					'desc'	=> 'Price Unit Will be same as set in Theme Options',
					'type' 	=> 'text',
					'std' 	=> '',
					'step'     => 0.01
				),
				array(
					'name' => __( 'Invoice Date', 'tt' ),
					'id'   => "{$prefix}date_invoice_created",
					'type' => 'date',
					// jQuery date picker options. See here http://api.jqueryui.com/datepicker
					'js_options' => array(
						'prependText'     => '',
						'dateFormat'      => 'yy/mm/dd',
						'changeMonth'     => true,
						'changeYear'      => true,
						'showButtonPanel' => false,
					),
				),	
			)
		);
		
		/* POST TYPE "Package"
		============================== */
		$meta_boxes[] = array(
			'id' 						=> 'tt_user_membership',
			'title' 				=> __( 'Package Details', 'tt' ),
			'pages' 				=> array( 'package' ),
			'context' 			=> 'normal',
			'priority' 			=> 'high',
			'autosave' 			=> true,
			'fields' 				=> array(
			    array(
					'name' 	=> __( 'Activate', 'tt' ),
					'id'    => "{$prefix}if_package_active",
					'type' 	=> 'checkbox',
					'std'  	=> 0,
				),
				array(
					'name'     => __( 'Package Subscription Period', 'tt' ),
					'id'	     => "{$prefix}package_valid_renew",
					'desc'	   => __( 'Subscription valid for __ days, weeks, months or years.', 'tt' ),
					'type'     => 'number',
					'min'      => 0,
					'std' 	   => ''
				),
				array(
					'name'     => __( 'Package Subscription Unit', 'tt' ),
					'id'       => "{$prefix}package_period_unit",
					//'desc'     => __( '', 'tt' ),
					'type'     => 'select',
					'options'  => array(
						'days'     => __( 'Days', 'tt' ),
						'weeks'    => __( 'Weeks', 'tt' ),
						'months'   => __( 'Months', 'tt' ),
						'years'    => __( 'Years', 'tt' )
					),
				),
				array(
					'name'	   => __( 'Allowed Listings'),
					'id'	     => "{$prefix}package_allowed_listings",
					'desc'	   => __( 'Enter -1 for unlimited listings.', 'tt' ),
					'min'      => 0,
					'type' 	   => 'number',
					'std' 	   => '',
					'min'			 => -1,
				),	
				array(
					'name'	   => __( 'Allowed Featured Listings'),
					'id'	     => "{$prefix}package_allowed_featured_listings",
					'desc'	   => __( 'Enter -1 for unlimited featured listings.', 'tt' ),
					'type' 	   => 'number',
					'std' 	   => '',
					'min'      => -1,
				),	
				array(
					'name'	   => __( 'Package Price'),
					'id'	     => "{$prefix}package_price",
					'desc'	   => __( 'Enter "0" for free or no price.', 'tt' ),
					'type' 	   => 'number',
					'std' 	   => '',
					'min'      => 0,
					'step'     => 0.01
				),	
				array(
					'name'	   => __( 'Unique Stripe Package ID'),
					'id'	     => "{$prefix}package_stripe_id",
					'desc'	   => '',
					'type' 	   => 'text',
					'std' 	   => ''
				),	
				
			)
		);
		
		
		/* POST TYPE "VIDEO"
		============================== */
		$meta_boxes[] = array(		
			'id' 						=> 'post_type_video',
			'title' 				=> __( 'Video Settings', 'tt' ),
			'pages' 				=> array( 'post' ),
			'context' 			=> 'normal',
			'priority' 			=> 'high',
			'autosave' 			=> true,
			'fields' 				=> array(
				array(
				'name'	=> 'Full Video URL',
				'id'		=> "{$prefix}post_video_url",
				'desc'	=> 'Insert Full Video URL (i.e. <strong>http://vimeo.com/99370876</strong>)',
				'type' 	=> 'text',
				'std' 	=> ''
			)
			)
		);
		
		
		/* PAGE SETTINGS
		============================== */
		
		$meta_boxes[] = array(		
			'id' 						=> 'pages_settings',
			'title' 				=> __( 'Page Settings', 'tt' ),
			'pages' 				=> array( 'post', 'page', 'property', 'agent' ),
			'context' 			=> 'normal',
			'priority' 			=> 'high',
			'autosave' 			=> true,
			'fields' 				=> array(
				array(
					'name' 					=> __( 'Hide Sidebar', 'tt' ),
					'id'   					=> "{$prefix}page_hide_sidebar",
					'type' 					=> 'checkbox',
					'std'  					=> 0,
				),
				array(
					'name' 					=> __( 'Hide Footer Widgets', 'tt' ),
					'id'   					=> "{$prefix}page_hide_footer_widgets",
					'type' 					=> 'checkbox',
					'std'  					=> 0,
				),
				// Intro Page Only
				array(
					'name'             => __( 'Intro Fullscreen Background Slideshow Images', 'tt' ),
					'id'               => "{$prefix}intro_fullscreen_background_slideshow_images",
					'class'			   => 'intro-only',
					'type'             => 'image_advanced',
					'max_file_uploads' => 100,
					'force_delete' 		 => false,
				),
				array(
					'name'          => __( 'Intro Fullscreen Background Video Provider', 'tt' ),
					//'desc'  				=> __( '', 'tt' ),
					'id'            => "{$prefix}intro_fullscreen_background_video_provider",
					'class'					=> 'intro-only',
					'type' 					=> 'select',
					'options'  			=> array(
						'none' 				=> __( 'None', 'tt' ),
						'youtube' 		=> __( 'YouTube', 'tt' ),
						'vimeo' 			=> __( 'Vimeo', 'tt' ),
					),
					'std'  					=> 'none',
				),
				array(
					'name'          => __( 'Intro Fullscreen Background Video ID', 'tt' ),
					'id'            => "{$prefix}intro_fullscreen_background_video_id",
					'class'					=> 'intro-only',
					'type'          => 'text',
					'desc'					=> __( 'Insert your video ID (i.e. <strong>0q_oXY0thxo</strong>)', 'tt' ),
				),
				/*array(
					'name' 					=> __( 'Intro Fullscreen Background Video: Enable Audio', 'tt' ),
					'id'   					=> "{$prefix}intro_fullscreen_background_video_audio",
					'class'         => 'intro-only',
					'type' 					=> 'checkbox',
					'std'  					=> 0,
					//'desc'					=> __( '', 'tt' ),
				), */
			)
		);
		
		
		if ( post_type_exists( 'property' ) ) {
			
			// Page Template "Property - Map"
			$meta_boxes[] = array(		
				'id' 						=> 'property_map_settings',
				'title' 				=> __( 'Property Map Settings', 'tt' ),
				'pages' 				=> array( 'page' ),
				'context' 			=> 'normal',
				'priority' 			=> 'high',
				'autosave' 			=> true,
				'fields' 				=> array(
					array(
						'name' 					=> __( 'Property Location', 'tt' ),
						'id'   					=> "{$prefix}property_map_location",
						//'desc'  				=> __( '', 'tt' ),
						'type'    			=> 'taxonomy_advanced',
						'options' 			=> array(
							'taxonomy' 				=> 'property-location', // Taxonomy name
							'type' 						=> 'select_advanced', // How to show taxonomy: 'checkbox_list' (default) or 'checkbox_tree', 'select_tree', select_advanced or 'select'. Optional
							'args' 						=> array() // Additional arguments for get_terms() function. Optional
						),
					),
					array(
						'name' 					=> __( 'Property Status', 'tt' ),
						'id'   					=> "{$prefix}property_map_status",
						//'desc'  				=> __( '', 'tt' ),
						'type'    			=> 'taxonomy_advanced',
						'options' 			=> array(
							'taxonomy' 				=> 'property-status',
							'type' 						=> 'checkbox_list',
							'args' 						=> array()
						),
					),
					array(
						'name' 					=> __( 'Property Type', 'tt' ),
						'id'   					=> "{$prefix}property_map_type",
						//'desc'  				=> __( '', 'tt' ),
						'type'    			=> 'taxonomy_advanced',
						'options' 			=> array(
							'taxonomy' 				=> 'property-type',
							'type' 						=> 'checkbox_list',
							'args' 						=> array()
						),
					),
					array(
						'name' 					=> __( 'Custom Zoom Level', 'tt' ),
						'id'   					=> "{$prefix}property_map_custom_zoom_level",
						'desc'  				=> __( 'Enter only, if your properties are located very closeby, and you would like to zoom closer. Zoom targets oldest property.', 'tt' ),
						'type' 					=> 'number',
						'step'  				=> 1,
						'min'						=> 0
					),
				)
			);
			
		}
		
		return $meta_boxes;
	}
}
add_filter( 'rwmb_meta_boxes', 'estate_register_meta_boxes' );