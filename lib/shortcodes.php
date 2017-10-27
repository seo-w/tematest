<?php
/*-----------------------------------------------------------------------------------*/
/* Section Title
/*-----------------------------------------------------------------------------------*/

function tt_section_title( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'heading'			=> 'h2',
		'style'				=> '1',
		'text_align'	=> ''
	), $atts ) );
	
	if ( $text_align == 'center' ) {
		$text_align = ' text-center';
	} else if ( $text_align == 'right' ) {
		$text_align = ' text-right';		
	} else {
		$text_align = null;
	}
	
	if ( $heading ) {
		return '<' . $heading . ' class="section-title style' . $style . $text_align . '"><span>' . do_shortcode( $content ) . '</span></' . $heading . '>';
	} else {
		return '<h2 class="section-title"><span>' . do_shortcode( $content ) . '</span></h2>';
	}
		
}
add_shortcode('section_title', 'tt_section_title');


/*-----------------------------------------------------------------------------------*/
/* Agents
/*-----------------------------------------------------------------------------------*/

function tt_agents( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'columns'		=> '2',
		'order'			=> 'DESC'
	), $atts ) );
	
	global $realty_theme_option;
	ob_start();
	
	if ( $order ) {
		$all_agents = get_users( array( 'role' => 'agent', 'fields' => 'ID', 'orderby'=> 'registered', 'order' => $order) );
	} else {
		$all_agents = get_users( array( 'role' => 'agent', 'fields' => 'ID' ) );
	}
	
	if ( $columns ) {
		echo '<div class="tt-agent-shortcode owl-carousel-' . $columns . '-nav nav-bottom">';
	} else {
		echo '<div class="owl-carousel-2-nav nav-bottom">';
	}

	foreach( $all_agents as $agent ) {
		
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
		
		if ( $facebook || $twitter || $google || $linkedin ) {
			$no_socials = false;
		} else {
			$no_socials = true;
		}
		?>
		<div class="widget-container">
			<div class="owl-thumbnail">
				<a href="<?php echo $author_profile_url; ?>">
					<?php 
					if ( $profile_image ) {
						$profile_image_id = tt_get_image_id( $profile_image );
						$profile_image_array = wp_get_attachment_image_src( $profile_image_id, 'square-400' );
						echo '<img src="' . $profile_image_array[0] . '" alt="" />';
					}
					else {
						echo '<img src="//placehold.it/400x400/eee/ccc/&text=.." alt="" />';
					} 
					?>
				</a>
			</div>
			<div class="widget-text">
				<div class="agent-details<?php if ( $no_socials ) { echo " no-details"; } ?>">
					<?php 
					if ( $first_name && $last_name ) {
						echo '<h4 class="title">' . $first_name . ' ' . $last_name . '</h4>';	
					}
					?>
					<?php if ( $email && $realty_theme_option['show-agent-email']  ) { ?><div class="contact"><i class="fa fa-envelope-o"></i><a href="mailto:<?php echo antispambot( $email ); ?>"><?php echo antispambot( $email ); ?></a></div><?php } ?>
					<?php if ( $office && $realty_theme_option['show-agent-office'] ) { ?><div class="contact"><i class="fa fa-phone"></i><?php echo $office; ?></div><?php } ?>
					<?php if ( $mobile && $realty_theme_option['show-agent-mobile'] ) { ?><div class="contact"><i class="fa fa-mobile"></i><?php echo $mobile; ?></div><?php } ?>			
				</div>
			</div>
		</div>
		<?php } ?>
		</div><!-- .owl-carousel -->
	<?php
	return ob_get_clean();
	
}
add_shortcode('agents', 'tt_agents');


/*-----------------------------------------------------------------------------------*/
/* Agents - More Properties
/*-----------------------------------------------------------------------------------*/

function tt_agents_properties( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'amount'		=> -1,
		'order'			=> ''
	), $atts ) );
	
	global $post;
	ob_start();

	$agent = get_post_meta( $post->ID, 'estate_property_custom_agent', true );

	if ( ! $agent ) {
		$agent_author = $post->post_author;
		$args_agent_properties = array(
			'post_type' 				=> 'property',
			'posts_per_page' 		=> $amount,
			'author'						=> $agent_author,
		);
	} else {
		$args_agent_properties = array(
			'post_type' 				=> 'property',
			'posts_per_page' 		=> $amount,
			'meta_query' 				=> array(
				array(
					'key' 		=> 'estate_property_custom_agent',
					'value' 	=> $agent,
					'compare'	=> '='
				)
			)
		);
	}
	
	// Order By:
	if ( $order == "random" ) {
		$args_agent_properties[ 'orderby' ] = 'rand';
	}
	
	$query_agent = new WP_Query( $args_agent_properties );
	if ( $query_agent->have_posts() ) :
	?>
	<div class="owl-carousel-1-nav nav-bottom">
		<?php
		while ( $query_agent->have_posts() ) : $query_agent->the_post();
		global $post;
		?>
		<div class="widget-container">
			<a href="<?php the_permalink(); ?>">
				<div class="widget-thumbnail">
					<?php 
					if ( has_post_thumbnail() ) { 
						the_post_thumbnail( 'thumbnail-400-300' );
					}	
					else {
						echo '<img src ="//placehold.it/400x300/eee/ccc/&text=.." />';
					}
					?>
				</div>
				
				<div class="widget-text">
					<?php the_title( '<h5 class="title">', '</h5>' ); ?>
					<div class="property-price"><?php echo tt_property_price(); ?></div>
				</div>
			</a>
		</div>
		<?php
		endwhile;
		?>
	</div>
	<?php
	wp_reset_query();
	endif;
	
	return ob_get_clean();
	
}
add_shortcode('agent_properties', 'tt_agents_properties');


/*-----------------------------------------------------------------------------------*/
/* Featured Properties
/*-----------------------------------------------------------------------------------*/

function tt_featured_properties( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'columns'					=> '2',
		'num_of_listings' => '-1',
		'order'						=> 'desc'
		
	), $atts ) );
	
	ob_start();
	if ( $columns ) {
		echo '<div class="owl-fearured-properties owl-carousel-' . $columns . '-nav nav-bottom">';
	} else {
		echo '<div class="owl-fearured-properties owl-carousel-2-nav nav-bottom">';
	}
	
	if ( $num_of_listings ) {
		set_query_var( 'posts_per_page', $num_of_listings );
	}
	
	if ( $order ) {
		set_query_var( 'order', $order );
	}
	
	get_template_part( 'lib/inc/template/property-featured' );
	
	return ob_get_clean();
	
}
add_shortcode('featured_properties', 'tt_featured_properties');


/*-----------------------------------------------------------------------------------*/
/*  Single Property
/*-----------------------------------------------------------------------------------*/

function tt_single_property( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'id'		=> '1'
	), $atts ) );

	$query_properties_args = array(
		'post_type' 			=> 'property',
		'posts_per_page' 	=> 1,
		'page_id' 				=> $id
	);
	
	$query_properties = new WP_Query( $query_properties_args );
	
	if ( $query_properties->have_posts() ) : 
		while ( $query_properties->have_posts() ) : $query_properties->the_post();
			ob_start();
			get_template_part( 'lib/inc/template/property-item' );
			return ob_get_clean();
		endwhile;
	wp_reset_query();
	endif;
	
}
add_shortcode('single_property', 'tt_single_property');


/*-----------------------------------------------------------------------------------*/
/*  Property Search Form
/*-----------------------------------------------------------------------------------*/

function tt_property_search_form( $atts, $content = null ) {

	ob_start();
	get_template_part( 'lib/inc/template/search-form' );
	return ob_get_clean();
	
}
add_shortcode('property_search_form', 'tt_property_search_form');


/*-----------------------------------------------------------------------------------*/
/*  Custom Search Form
/*-----------------------------------------------------------------------------------*/

function tt_property_custom_search_form( $atts, $content = null ) {
	
  extract( shortcode_atts( array(
		'location'						=> '',
		'type'								=> '',
		'status'							=> '',
		'features'						=> '',
		'id' 									=> '',
		'price'     					=> '', 
	  'size'            		=> '', 
	  'rooms'      					=> '', 
	  'bedrooms'      			=> '', 
	  'bathrooms'      			=> '', 
	  'garages'      				=> '', 
	  'search_keyword'			=> '',
	  'available_from'			=> '', 
		'minprice'     				=> '', 
		'maxprice'     				=> '', 
		'pricerange'     			=> '', 
	), $atts ) );
	
	ob_start();
	
	$search_fields = array();
	$search_labels = array();
	$search_parameters = array();
	$search_id = '[custom_property_search_form';
	
	if ( $location ) {
		$search_fields[] = 'estate_property_location';
		$search_labels[] = $location;
		$search_parameters[] = 'estate_property_location';
		$search_id .= ' ' . 'location="' . $location . '"';
	}
	if ( $type ) {
		$search_fields[] = 'estate_property_type';
		$search_labels[] = $type;
		$search_parameters[] = 'estate_property_type';
		$search_id .= ' ' . 'type="' . $type . '"';
	}
	if ( $status ) {
		$search_fields[] = 'estate_property_status';
		$search_labels[] = $status;
		$search_parameters[] = 'estate_property_status';
		$search_id .= ' ' . 'status="' . $status . '"';
	}
	if ( $id ) {
		$search_fields[] = 'estate_property_id';
		$search_labels[] = $id;
		$search_parameters[] = 'estate_property_id';
		$search_id .= ' ' . 'id="' . $id . '"';
	}
	if ( $price ) {
		$search_fields[] = 'estate_property_price';
		$search_labels[] = $price;
		$search_parameters[] = 'estate_property_price';
		$search_id .= ' ' . 'price="' . $price . '"';
	}
	if ( $size ) {
		$search_fields[] = 'estate_property_size';
		$search_labels[] = $size;
		$search_parameters[] = 'estate_property_size';
		$search_id .= ' ' . 'size="' . $size . '"';
	}
	if ( $rooms ) {
		$search_fields[] = 'estate_property_rooms';
		$search_labels[] = $rooms;
		$search_parameters[] = 'estate_property_rooms';
		$search_id .= ' ' . 'rooms="' . $rooms . '"';
	}
	if ( $bedrooms ) {
		$search_fields[] = 'estate_property_bedrooms';
		$search_labels[] = $bedrooms;
		$search_parameters[] = 'estate_property_bedrooms';
		$search_id .= ' ' . 'bedrooms="' . $bedrooms . '"';
	}
	if ( $bathrooms ) {
		$search_fields[] = 'estate_property_bathrooms';
		$search_labels[] = $bathrooms;
		$search_parameters[] = 'estate_property_bathrooms';
		$search_id .= ' ' . 'bathrooms="' . $bathrooms . '"';
	}
	if ( $garages ) {
		$search_fields[] = 'estate_property_garages';
		$search_labels[] = $garages;
		$search_parameters[] = 'estate_property_garages';
		$search_id .= ' ' . 'garages="' . $garages . '"';
	}
	if ( $search_keyword ) {
		$search_fields[] = 'estate_search_by_keyword';
		$search_labels[] = $search_keyword;
		$search_parameters[] = 'estate_search_by_keyword';
		$search_id .= ' ' . 'search_keyword="' . $search_keyword . '"';
	}
	if ( $available_from ) {
		$search_fields[] = 'estate_property_available_from';
		$search_labels[] = $available_from;
		$search_parameters[] = 'estate_property_available_from';
		$search_id .= ' ' . 'available_from="' . $available_from . '"';
	}
	if ( $minprice ) {
		$search_fields[] = 'estate_property_price_min';
		$search_labels[] = $minprice;
		$search_parameters[] = 'estate_property_price_min';
		$search_id .= ' ' . 'minprice="' . $minprice . '"';
	}
	if ( $maxprice ) {
		$search_fields[] = 'estate_property_price_max';
		$search_labels[] = $maxprice;
		$search_parameters[] = 'estate_property_price_max';
		$search_id .= ' ' . 'maxprice="' . $maxprice . '"';
	}
	if ( $pricerange ) {
		$search_fields[] = 'estate_property_pricerange';
		$search_labels[] = $pricerange;
		$search_parameters[] = 'estate_property_pricerange';
		$search_id .= ' ' . 'pricerange="' . $pricerange . '"';
	}
	$search_id .= ']';
	
	if ( $search_id ) {
		set_query_var( 'property_search_id', base64_encode( $search_id ) );
	}
	if ( ! tt_is_array_empty( $search_fields ) ) {
		set_query_var( 'property_search_fields', $search_fields );
	}
	if ( ! tt_is_array_empty( $search_labels ) ) {
		set_query_var( 'property_search_labels', $search_labels );
	}
	if ( ! tt_is_array_empty($search_parameters ) ) {
		set_query_var( 'property_search_parameters', $search_parameters );
	}
	get_template_part( 'lib/inc/template/search-form' );
	
	return ob_get_clean();
	
}
add_shortcode( 'property_multiple_search_form', 'tt_property_custom_search_form' ); // obsolete since renaming in v2.4
add_shortcode( 'custom_property_search_form', 'tt_property_custom_search_form' );


/*-----------------------------------------------------------------------------------*/
/*  Property Listing
/*-----------------------------------------------------------------------------------*/

function tt_property_listing( $atts, $content = null ) {
	global $realty_theme_option;
  $listing_view = $realty_theme_option['property-listing-default-view'];
	extract( shortcode_atts( array(
		'per_page'									=> '10',
		'columns'										=> '',
		'location'									=> '',
		'status'										=> '',
		'type'											=> '',
		'features'									=> '',
		'max_price'									=> '',
		'min_rooms'									=> '',
		'available_from'						=> '',
		'view'											=> '',
		'show_sorting_toggle_view' 	=> 'hide',
		'sort_by'         					=> 'date-new',
	), $atts ) );
	
	ob_start();
  
  // Property Sorting & View
	if ( $show_sorting_toggle_view == 'show' ) {
		echo tt_property_listing_sorting_and_view($sort_by);
	}
  ?>
  
  <div id="property-items" class="show-compare<?php echo ' ' . $view; ?>"  data-view="<?php if ( isset( $listing_view ) && $view=='' ) { echo $listing_view; }?>">
	
	<?php
	get_template_part( 'lib/inc/template/property', 'comparison' );
	
	if ( ! $per_page ) {
		$per_page = 10;
	}
	
	// Property Query
	if ( is_front_page() ) {
		$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
	} else {
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	}
	
	$query_properties_args = array(
		'post_type' 			=> 'property',
		'posts_per_page' 	=> $per_page,
		'paged' 					=> $paged
	);
	
	/* TAX QUERIES: 
	============================== */
	$tax_query = array();
	
	if ( $location ) {
		$tax_query[]	= array(
			'taxonomy' 	=> 'property-location',
			'field' 		=> 'slug',
			'terms'			=> $location
		);
	}
	
	if ( $status ) {
		$tax_query[]	= array(
			'taxonomy' 	=> 'property-status',
			'field' 		=> 'slug',
			'terms'			=> $status
		);
	}
	
	if ( $type ) {
		$tax_query[]	= array(
			'taxonomy' 	=> 'property-type',
			'field' 		=> 'slug',
			'terms'			=> $type
		);
	}
	
	if ( $features ) {
		$tax_query[]	= array(
			'taxonomy' 	=> 'property-features',
			'field' 		=> 'slug',
			'terms'			=> explode( ',', $features ),
			'operator'	=> 'AND'
		);
	}
	
	// Count Taxonomy Queries + set their relation for search query
	$tax_count = count( $tax_query );
	if ( $tax_count > 1 ) {
		$tax_query['relation'] = 'AND';
	}
	
	$query_properties_args['tax_query'] = $tax_query;
	
	/* META QUERIES: 
	============================== */
	$meta_query = array();
	
	if( $max_price ) {
		$meta_query[] = array(
			'key' 			=> 'estate_property_price',
			'value' 		=> $max_price,
			'compare'		=> '<=',
			'type' 			=> 'NUMERIC',
		);
	}
	
	if( $min_rooms ) {
		$meta_query[] = array(
			'key' 			=> 'estate_property_rooms',
			'value' 		=> $min_rooms,
			'compare'		=> '>=',
			'type' 			=> 'NUMERIC',
		);
	}
	
	if( $available_from ) {
		$meta_query[] = array(
			'key' 			=> 'estate_property_available_from',
			'value' 		=> $available_from,
			'compare'		=> '<=',
			'type' 			=> 'NUMERIC',
		);
	}
	
	// Count Meta Queries + set their relation for search query
	$meta_count = count( $meta_query );
	if ( $meta_count > 1 ) {
	  $meta_query['relation'] = 'AND';
	}
	if ( ! empty( $_GET[ 'order-by' ] ) ) {
		$orderby = $_GET[ 'order-by' ];
	}
	else {
		$orderby = $sort_by;
	}

	// By Date (Newest First)
	if ( $orderby == 'date-new' ) {
		$query_properties_args['orderby'] = 'date';
		$query_properties_args['order'] = 'DESC';
	}
	
	// By Date (Oldest First)
	if ( $orderby == 'date-old' ) {
		$query_properties_args['orderby'] = 'date';
		$query_properties_args['order'] = 'ASC';
	}
	
	// By Price (Highest First)
	if ( $orderby == 'price-high' ) {
		$query_properties_args['meta_key'] = 'estate_property_price';
		$query_properties_args['orderby'] = 'meta_value_num';
		$query_properties_args['order'] = 'DESC';
	}
	
	// By Price (Lowest First)
	if ( $orderby == 'price-low' ) {
		$query_properties_args['meta_key'] = 'estate_property_price';
		$query_properties_args['orderby'] = 'meta_value_num';
		$query_properties_args['order'] = 'ASC';
	}
	
	// By Name (Ascending)
	if ( $orderby == 'name-asc' ) {
		$query_properties_args['orderby'] = 'title';
		$query_properties_args['order'] = 'ASC';
	}
	
	// By Name (Ascending)
	if ( $orderby == 'name-desc' ) {
		$query_properties_args['orderby'] = 'title';
		$query_properties_args['order'] = 'DESC';
	}
	if ( $orderby == 'featured' ) {
		$query_properties_args['orderby'] = 'meta_value';
		$query_properties_args['order'] = 'DESC';
		$query_properties_args['meta_key'] = 'estate_property_featured';
	}
	
	if ( $orderby == 'random' ) {
		$query_properties_args['orderby'] = 'rand';
		$query_properties_args['order'] = '';
	}
	
	if ( $meta_count > 0 ) {
		$query_properties_args['meta_query'] = $meta_query;
	}
	$query_properties = new WP_Query( $query_properties_args );
	
	if ( $query_properties->have_posts() ) :
	?> 
	<ul class="row list-unstyled">
		<?php 
		while ( $query_properties->have_posts() ) : $query_properties->the_post();
		
		// Shortcode Columns Setting
		if ( isset( $columns ) && $columns == "1" ) {
			echo '<li class="col-md-12">';
		}
		else if ( isset( $columns ) && $columns == "2" ) {
			echo '<li class="col-md-6">';
		}
		else if ( isset( $columns ) && $columns == "3" ) {
			echo '<li class="col-lg-4 col-md-6">';
		}
		else if ( isset( $columns ) && $columns == "4" ) {
			echo '<li class="col-lg-3 col-md-6">';
		}
		// Theme Options Columns Settings
		else {
			global $realty_theme_option;
			$columns_theme_option = $realty_theme_option['property-listing-columns'];
			if ( empty($columns_theme_option) ) {
				echo '<li class="col-md-6">';
			}
			else {
				echo '<li class="' . $columns_theme_option . '">';
			}
		}
		
		get_template_part( 'lib/inc/template/property', 'item' );
		
		echo '</li>';
		
		endwhile; 
		?>
	</ul>
	<?php wp_reset_query(); ?>
	
	<div id="pagination">
	<?php
	// Built Property Pagination
	$big = 999999999; // need an unlikely integer

	echo paginate_links( array(
		'base' 				=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ) . '#property-items',
		'format' 			=> '?page=%#%',
		'total' 			=> $query_properties->max_num_pages,
		//'show_all'		=> true,
		'end_size'    => 4,
		'mid_size'    => 2,
		'type'				=> 'list',
		'current'     => $paged,
		'prev_text' 	=> __( '<i class="btn btn-default fa fa-angle-left"></i>', 'tt' ),
		'next_text' 	=> __( '<i class="btn btn-default fa fa-angle-right"></i>', 'tt' ),
	) );
	?>
	</div>
	
	<?php
	else:
	?>
	<div>
		<p class="lead"><?php _e('No Properties Found.', 'tt') ?></p>
	</div>
	<?php
	endif;
	?>
	
	</div><!-- #property-items -->
	<?php
	return ob_get_clean();	
}
add_shortcode('property_listing', 'tt_property_listing');


/*-----------------------------------------------------------------------------------*/
/*  Map
/*-----------------------------------------------------------------------------------*/

function tt_map( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'address'			=> '',
		'latitude'		=>'',
		'longitude'		=>'',
		'location'		=>'',
		'status'			=> '',
		'type'				=> '',
		'features'		=> '',
		'zoomlevel'	 	=> '14',
		'height'			=> '500px',
		'width'				=> '100%'
		
	), $atts ) );
	
	if ( ! empty( $latitude ) ) {
		$latitude = $latitude;
	} else {
		$latitude = 0;
	}
	
	if ( ! empty( $longitude ) ) {
		$longitude = $longitude;
	} else {
		$longitude = 0;
	}
	
	ob_start();
	
	// Property Query
	if ( is_front_page() ) {
		$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
	} else {
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	}
		
	$query_properties_args = array(
		'post_type' 			=> 'property',
		'posts_per_page' 	=> -1,
		'paged' 					=> $paged
	);
	
	/* TAX QUERIES: 
	============================== */
	$tax_query = array();
	
	if ( $location ) {
		$tax_query[]	= array(
			'taxonomy' 	=> 'property-location',
			'field' 		=> 'slug',
			'terms'			=> $location
		);
	}
	
	if ( $status ) {
		$tax_query[]	= array(
			'taxonomy' 	=> 'property-status',
			'field' 		=> 'slug',
			'terms'			=> $status
		);
	}
	
	if ( $type ) {
		$tax_query[]	= array(
			'taxonomy' 	=> 'property-type',
			'field' 		=> 'slug',
			'terms'			=> $type
		);
	}
	
	if ( $features ) {
		$tax_query[]	= array(
			'taxonomy' 	=> 'property-features',
			'field' 		=> 'slug',
			'terms'			=> $features
		);
	}
	
	// Count Taxonomy Queries + set their relation for search query
	$tax_count = count( $tax_query );
	if ( $tax_count > 1 ) {
		$tax_query['relation'] = 'AND';
	}
	
	$query_properties_args['tax_query'] = $tax_query;
	$query_properties = new WP_Query( $query_properties_args );

	if ( $query_properties->have_posts() ) :

	$random = rand();
	$property_string = '';

	while ( $query_properties->have_posts() ) : $query_properties->the_post();

	global $post;
	$google_maps = get_post_meta( $post->ID, 'estate_property_google_maps', true );
	
	if ( ! tt_is_array_empty($google_maps )) {
		
		$address = $google_maps['address'];
		if ( $google_maps['lat'] ) {
			$address_latitude = $google_maps['lat'];
		} else {
			$address_latitude = '51.5286416';
		}
		if ( $google_maps['lng'] ) {
			$address_longitude = $google_maps['lng'];
		} else {
			$address_longitude = '-0.1015987';
		}
		
	}

	// Check If We Have LatLng Coordinates From Google Maps
	if ( $google_maps ) {

		$property_string .= "{ ";
		$property_string .= "permalink:'" . get_the_permalink() . "', ";
		$property_string .= "title:'" . get_the_title() . "', ";
		$property_string .= "price:'" . tt_property_price() . "', ";
		$property_string .= "latLng: new google.maps.LatLng(" . $address_latitude . ", " . $address_longitude . "), ";
		if ( has_post_thumbnail() ) { 
			$property_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
			$property_string .= "thumbnail: '" . $property_thumbnail[0] . "'";
		}	else { 
			$property_string .= "thumbnail: '//placehold.it/300x100/eee/ccc/&text=..'";
		}
		$property_string .= " }," . "\n";

	}

	endwhile;

	?>
	<script>
	var map_<?php echo $random; ?> = null, markers = [], newMarkers_<?php echo $random; ?> = [], markerCluster = null, infobox = [];
	
	function initMap() {
	  
		<?php echo tt_mapMarkers(); ?>
		
			var	mapOptions = {
			
			center: new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>),
			zoom: <?php echo $zoomlevel; ?>,
			scrollwheel: false,
			streetViewControl: true,
			disableDefaultUI: true
			
		};
		map_<?php echo $random; ?> = new google.maps.Map(document.getElementById("google-map-<?php echo $random; ?>"), mapOptions);
		
		<?php 
		global $realty_theme_option;
		if ( $realty_theme_option['style-your-map'] == true ) { ?>
			if ( map_options.map_style !== '' ) {
				var styles = JSON.parse(map_options.map_style);
				map_<?php echo $random; ?>.setOptions( { styles: styles } );
			}
		<?php } ?> 
		
		<?php if ( ! empty( $address ) && $latitude == 0 && $longitude == 0 ) { ?>
		var address = "<?php echo $address; ?>";

		// Get latLng from property address and grab it with callback, as geocode calls asynchonous
	  function getLatLng(callback) {
		  var geocoder = new google.maps.Geocoder();  	  
		  if ( geocoder ) {	  
			  geocoder.geocode( { 'address': address}, function(results, status ) { 
					if (status == google.maps.GeocoderStatus.OK) {   	
						latLng = results[0].geometry.location;
						callback(latLng);
					}
					else {
						alert("Geocoder failed due to: " + status);
					}  		     
			  });	  
		  }   
	  }
	  <?php } ?>
		
		markers = initMarkers(map_<?php echo $random; ?>, [ <?php echo $property_string; ?> ]);
		
		function initMarkers(map_<?php echo $random; ?>, markerData) {
			
			<?php if ( $latitude != 0 && $longitude != 0 ) { ?>
			
							map_<?php echo $random; ?>.setCenter(new google.maps.LatLng(<?php echo $latitude; ?> , <?php echo $longitude; ?>));
							
			<?php } else { ?>
				
							getLatLng(function(latLng) {
								map_<?php echo $random; ?>.setCenter(latLng);  	
							});  
				
			<?php } ?>
			for( var i = 0; i < markerData.length; i++ ) {
				
				marker = new google.maps.Marker({
				map: map_<?php echo $random; ?>,
				position: markerData[i].latLng,
				icon: customIcon,
				animation: google.maps.Animation.DROP
				}),
							  
				infoboxOptions = {
					content: 	'<div class="map-marker-wrapper">'+
											'<div class="map-marker-container">'+
												'<div class="arrow-down"></div>'+
													'<img src="'+markerData[i].thumbnail+'" />'+
													'<div class="content">'+
													'<a href="'+markerData[i].permalink+'">'+
													'<h5 class="title">'+markerData[i].title+'</h5>'+
													'</a>'+
													markerData[i].price+
													'</div>'+
												'</div>'+
										'</div>',
					disableAutoPan: false,
				  pixelOffset: new google.maps.Size(-33, -90),
				  zIndex: null,
				  isHidden: true,
				  alignBottom: true,
				  closeBoxURL: "<?php echo TT_LIB_URI . '/images/close.png'; ?>",
				  infoBoxClearance: new google.maps.Size(25, 25)
				};
				
				newMarkers_<?php echo $random; ?>.push(marker);
			
				newMarkers_<?php echo $random; ?>[i].infobox = new InfoBox(infoboxOptions);
			
				google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
					
					if ( newMarkers_<?php echo $random; ?>[i].infobox.getVisible() ) {
						newMarkers_<?php echo $random; ?>[i].infobox.hide();
					}
					else {
						jQuery('.infoBox').hide();
						newMarkers_<?php echo $random; ?>[i].infobox.show();
					}
					
					newMarkers_<?php echo $random; ?>[i].infobox.open(map_<?php echo $random; ?>, this);
				 map_<?php echo $random; ?>.setCenter(marker.getPosition());  	
				 map_<?php echo $random; ?>.panBy(0,-175);
				  
				}
				})( marker, i ) ); 
				
				google.maps.event.addListener(map_<?php echo $random; ?>, 'click', function() {
				jQuery('.infoBox').hide();
			  });
				
			}
			
			var markerCluster_<?php echo $random; ?> = new MarkerClusterer(map_<?php echo $random; ?>, newMarkers_<?php echo $random; ?>, markerClusterOptions);
			
			return newMarkers_<?php echo $random; ?>;
			
		}
		
		// Spiderfier
		var oms = new OverlappingMarkerSpiderfier(map_<?php echo $random; ?>, { markersWontMove: true, markersWontHide: true, keepSpiderfied: true, legWeight: 5 });
		
		function omsMarkers( markers ) {
		  for ( var i = 0; i < markers.length; i++ ) {
			oms.addMarker( markers[i] );
		  }   
		}
		
		omsMarkers(markers);
		
		// Zoom In
		google.maps.event.addDomListener(document.getElementById('zoom-in-<?php echo $random; ?>'), 'click', function () {      
			var currentZoom = map_<?php echo $random; ?>.getZoom();
			currentZoom++;
			if ( currentZoom > 19 ) {
				currentZoom = 19;
			}
			map_<?php echo $random; ?>.setZoom(currentZoom);
		});
		
		// Zoom Out
		google.maps.event.addDomListener(document.getElementById('zoom-out-<?php echo $random; ?>'), 'click', function () {      
			var currentZoom = map_<?php echo $random; ?>.getZoom();
			currentZoom--;
			if ( currentZoom > 19 ) {
				currentZoom = 19;
			}
			map_<?php echo $random; ?>.setZoom(currentZoom);
		});
		
		// Map Type: Roadmap
		google.maps.event.addDomListener(document.getElementById('map-type-roadmap-<?php echo $random; ?>'), 'click', function () {      
			map_<?php echo $random; ?>.setMapTypeId(google.maps.MapTypeId.ROADMAP);	
		}); 		 
		
		// Map Type: Satellite
		google.maps.event.addDomListener(document.getElementById('map-type-satellite-<?php echo $random; ?>'), 'click', function () {      
			map_<?php echo $random; ?>.setMapTypeId(google.maps.MapTypeId.SATELLITE);	
		}); 		 
		
		// Map Type: Hybrid
		google.maps.event.addDomListener(document.getElementById('map-type-hybrid-<?php echo $random; ?>'), 'click', function () {      
			map_<?php echo $random; ?>.setMapTypeId(google.maps.MapTypeId.HYBRID);	
		}); 		 
	
		// Map Type: Terrain
		google.maps.event.addDomListener(document.getElementById('map-type-terrain-<?php echo $random; ?>'), 'click', function () {      
			map_<?php echo $random; ?>.setMapTypeId(google.maps.MapTypeId.TERRAIN);	
		});
		
		jQuery('.map-type li').click(function() {
			jQuery('.map-type li').removeClass('active');
			jQuery(this).addClass('active');
		});
	  
	} // initMap()

	google.maps.event.addDomListener(window, 'load', initMap);
	
	// Geo Location: Current Location
	function currentLocation() {
		
		// Geolocation - Current Location
		jQuery('#current-location-<?php echo $random; ?>').click(function() {
		
			// Current Location Marker
			var markerCurrent = new google.maps.Marker({
			  //clickable: false,
			  icon: new google.maps.MarkerImage('//maps.gstatic.com/mapfiles/mobile/mobileimgs2.png',
				  new google.maps.Size(22,22),
				  new google.maps.Point(0,18),
				  new google.maps.Point(11,11)),
			  shadow: null,
			  zIndex: null,
			  map: map_<?php echo $random; ?>
			});
		
			jQuery(this).toggleClass('active');
		
			if ( !jQuery('#current-location-<?php echo $random; ?>').hasClass('draw') ) {
			
				// Create Loading Element
			  var loading = document.createElement('div');
		
		    loading.setAttribute( 'class', 'loading' );
		
		    loading.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
		
		    document.getElementById('map-wrapper-<?php echo $random; ?>').appendChild(loading);
			    
			}
		
			if (navigator.geolocation) {
			
				navigator.geolocation.getCurrentPosition(function(current) {
			    var me = new google.maps.LatLng(current.coords.latitude, current.coords.longitude);
			    markerCurrent.setPosition(me);
					map_<?php echo $random; ?>.panTo(me);
					
					// Remove Loader
		    	loading.remove();
					
					// https://developers.google.com/maps/documentation/javascript/examples/circle-simple
					var currentRadiusCircleOptions = {
			      strokeColor: '#00CFF0',
			      strokeOpacity: 0.6,
			      strokeWeight: 2,
			      fillColor: '#00CFF0',
			      fillOpacity: 0.2,
			      map: map_<?php echo $random; ?>,
			      center: me,
			      visible: true,
			      radius: 1000 // Unit: meter
			    };
		    
		    // When Initializing
				if ( !jQuery('#current-location-<?php echo $random; ?>').hasClass('draw') ) {	
			    
			    // Create Circle
			    currentRadiusCircle = new google.maps.Circle(currentRadiusCircleOptions);
		  
				}
				
				jQuery('#current-location-<?php echo $random; ?>').addClass('draw');
				
				// Toggle Crrent Location Icon & Circle
				if ( jQuery('#current-location-<?php echo $random; ?>').hasClass('active') ) {
					markerCurrent.setMap(map_<?php echo $random; ?>);
					currentRadiusCircle.setMap(map_<?php echo $random; ?>);
				}
				else {
					markerCurrent.setMap(null);
					currentRadiusCircle.setMap(null);
				}
					
				});
				
			}
			// Error: Can't Retrieve Current Location
			else {
			  //alert("Current Position Not Found");
			}
			
			// Toggle Current Location Circle Visibility				
			google.maps.event.addListener(markerCurrent, 'click', (function() {		
				if ( currentRadiusCircle.getVisible() ) {
			  	currentRadiusCircle.set( 'visible', false );
				}
				else {
			  	currentRadiusCircle.set( 'visible', true );
				}		
			}));
			
		});
	
	}
	
	google.maps.event.addDomListener(window, 'load', currentLocation);

	</script>

	<div id="map-wrapper-<?php echo $random; ?>" class="map-wrapper">
			
		<div class="map-controls">
			<a href="#" class="control zoom-in" id="zoom-in-<?php echo $random; ?>" data-toggle="tooltip" title="<?php _e( 'Zoom In', 'tt' ); ?>"><i class="fa fa-plus"></i></a>
			<a href="#" class="control zoom-out" id="zoom-out-<?php echo $random; ?>" data-toggle="tooltip" title="<?php _e( 'Zoom Out', 'tt' ); ?>"><i class="fa fa-minus"></i></a>
			<a href="#" class="control map-type" id="map-type-<?php echo $random; ?>" data-toggle="tooltip" title="<?php _e( 'Map Type', 'tt' ); ?>">
				<i class="fa fa-image"></i>
				<ul class="list-unstyled">
					<li id="map-type-roadmap-<?php echo $random; ?>" class="map-type"><?php _e( 'Roadmap', 'tt' ); ?></li>
					<li id="map-type-satellite-<?php echo $random; ?>" class="map-type"><?php _e( 'Satellite', 'tt' ); ?></li>
					<li id="map-type-hybrid-<?php echo $random; ?>" class="map-type"><?php _e( 'Hybrid', 'tt' ); ?></li>
					<li id="map-type-terrain-<?php echo $random; ?>" class="map-type"><?php _e( 'Terrain', 'tt' ); ?></li>
				</ul>
			</a>
			<a href="#" id="current-location-<?php echo $random; ?>" class="control" data-toggle="tooltip" title="<?php _e( 'Radius: 1000m', 'tt' ); ?>"><i class="fa fa-crosshairs"></i> <?php _e( 'Current Location', 'tt' ); ?></a>
		</div>
			
		<div id="google-map-<?php echo $random; ?>" class="google-map" style="height: <?php echo $height; ?>">
			<div class="spinner">
			  <div class="bounce1"></div>
			  <div class="bounce2"></div>
			  <div class="bounce3"></div>
			</div>	
		</div>
		
	</div>

	<?php

	wp_reset_query();
		
	else:
	?>	
	<div class="map-no-properties-found">
		<p class="lead text-center"><?php _e( 'No Properties Found.', 'tt' ) ?></p>
	</div>
	<?php
	endif;
	return ob_get_clean();
	
}
add_shortcode('map', 'tt_map');


/*-----------------------------------------------------------------------------------*/
/* Latest Posts
/*-----------------------------------------------------------------------------------*/

function tt_shortcode_latest_posts( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'posts'		=> '3',
		'columns'	=> '2'
	), $atts ) );
	
	ob_start();
	// Query Featured Properties
	$args_latest_posts = array(
		'post_type' 				=> 'post',
		'posts_per_page' 		=> $posts
	);
	
	$query_latest_posts = new WP_Query( $args_latest_posts );
	
	if ( $query_latest_posts->have_posts() ) :
	?>
	<div class="owl-latest-posts owl-carousel-<?php echo $columns; ?>-nav nav-bottom">
		<?php
		while ( $query_latest_posts->have_posts() ) : $query_latest_posts->the_post();
		?>
		<article>
			<?php 
			if ( get_post_format( get_the_ID() ) == "video" ) {
				$video_url = get_post_meta( get_the_ID(), "estate_post_video_url", true );
				echo wp_oembed_get( $video_url );
			}
			elseif ( ( get_post_format( get_the_ID() ) == "gallery" ) ) {
				$gallery = get_post_meta( get_the_ID(), "estate_post_gallery", false );
				?>
				<div class="owl-carousel-1-xxx">
				<?php
				$args = array(
					'post_type' => 'attachment',
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'post__in' => $gallery,
					'posts_per_page' => count($gallery) // If no gallery image selected, it will add all attachments
				);
				
				$gallery_array = get_posts( $args );
				
				foreach ($gallery_array as $slide) {
					$attachment = wp_get_attachment_image_src( $slide->ID, 'thumbnail-400-300' );
					$attachment_url = $attachment[0];
				?>
					<img src="<?php echo $attachment_url; ?>" alt="" />
				<?php 
				break; // Show only first image, carousel within carousel doesn't calculate image height properly
				}
				?>
				</div>
				<?php
			}
			else {
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'thumbnail-400-300', array( 'alt' => '' ) );
				}
			}
			?>
		
			<div class="content">
				<a href="<?php the_permalink(); ?>"><?php the_title( '<h4 class="title">', '</h4>' ); ?></a>
				<?php	echo the_excerpt(); ?>
			</div>
			
		</article>
		<?php
		endwhile;
		?>
	</div>
	<?php
	wp_reset_query();
	endif;
	return ob_get_clean();
	
}
add_shortcode('latest_posts', 'tt_shortcode_latest_posts');


/*-----------------------------------------------------------------------------------*/
/* Testimonials
/*-----------------------------------------------------------------------------------*/

function tt_testimonials( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'columns'		=> '2'
	), $atts ) );
	
	ob_start();
	if ( $columns ) {
		echo '<div class="owl-carousel-' . $columns . '-nav testimonial nav-bottom">';
	}
	else {
		echo '<div class="owl-carousel-2-nav testimonial nav-bottom">';
	}

	get_template_part( 'lib/inc/template/testimonials' );
	return ob_get_clean();
	
}
add_shortcode('testimonials', 'tt_testimonials');


/*-----------------------------------------------------------------------------------*/
/* Membership Packages
/*-----------------------------------------------------------------------------------*/

function tt_membership_packages( $atts, $content = null ) {
	global $realty_theme_option;
	
	if ( $realty_theme_option['property-submission-type'] == 'membership' ) {
		
		$query_package_args = array(
			'post_type' 		=> 'package',
			'orderby'       => 'date',
			'order'         => 'ASC',
			'post_status'   => 'publish',
		);
		
		$query_packages = new WP_Query( $query_package_args);

		ob_start(); 
		?>
	
	  <div id="property-items" class="show-compare subscriptions " data-view="grid-view" style="opacity: 1;"> 
			<ul class="row list-unstyled">
			<?php 
			if ( $query_packages->have_posts() ) : while ( $query_packages->have_posts() ) : $query_packages->the_post(); 
				
				$active = get_post_meta( get_the_ID(), 'estate_if_package_active', true );
				$subscription_unit = get_post_meta( get_the_ID(), 'estate_package_period_unit', true );
				$number_of_ocurrances = get_post_meta(get_the_ID(), 'estate_package_valid_renew', true );
				$regular_listings = get_post_meta( get_the_ID(), 'estate_package_allowed_listings', true );
				$featured_listings = get_post_meta( get_the_ID(), 'estate_package_allowed_featured_listings', true );
				$package_price = get_post_meta( get_the_ID(), 'estate_package_price', true );
				$stripe_id = get_post_meta( get_the_ID(), 'estate_package_stripe_id', true );
				
			if ( $active == true ) {
			?>		
			<li class="col-lg-4 col-md-6">
				<div class="property-item primary-tooltips title-above-image">
				
					<div class="property-title">
						<h3 class="title" style="text-align:center;"><?php _e(get_the_title()); ?></h3>
				  </div>
			
				 <div class="property-content">
					 
					<div class="property-meta clearfix">
						<div>
							<div class="meta-data"><?php _e( 'Regular Listings', 'tt' ); ?></div>
						</div>
						<div>
							<div class="meta-data"><?php _e( $regular_listings ); ?></div>
						</div>
						<div>
							<div class="meta-data"><?php _e( 'Featured Listings', 'tt' ); ?></div>
						</div>
						<div>
							<div class="meta-data"><?php _e( $featured_listings ); ?></div>
						</div>
						<div>
							<div class="meta-data"><?php _e( 'Subscription Period', 'tt' ); ?></div>
						</div>
						<div>
							<div class="meta-data"><?php _e( $number_of_ocurrances . ' ' . $subscription_unit ); ?></div>
						</div>
					</div>
						
					<div class="property-price">
						<span class="meta-data"><?php _e( 'Price', 'tt' ); ?></span>
						<div class="price-tag"><?php echo $realty_theme_option['currency-sign']; ?><?php _e( $package_price ); ?></div>
					</div>
				
				</div>
				
			</div> 
			
			<a href="<?php if ( is_user_logged_in() ) { echo get_permalink( get_the_ID() ); } else { echo "?login"; } ?>"><input type="button" value="Subscribe" class="subscribe-button btn btn-primary btn-block form-control"></a>
		</li>
		<?php } ?>
				
		<?php 
		endwhile;
		wp_reset_query();
		endif; ?>
		
		</ul>

	</div><!-- package item -->
	<?php } else {
		echo '<p class="alert alert-danger">' . __( 'Please first enable memberships under "Appearance > Theme Options > Property Submit" and create membership packages.', 'tt' ) . '</p>';
	}
	
	return ob_get_clean();
	
}
add_shortcode( 'membership_packages', 'tt_membership_packages' );