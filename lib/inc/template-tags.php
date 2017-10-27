<?php
/**
 * Custom template tags for this theme.
 *
 * @package Realty
 */

/**
 * Property Sorting & View
 *
 */
 
if ( ! function_exists( 'tt_property_listing_sorting_and_view' ) ) {
	function tt_property_listing_sorting_and_view($sort_order='') {

		global $realty_theme_option;
		$listing_view = $realty_theme_option['property-listing-default-view'];
		
		if( ! empty( $_GET[ 'order-by' ] ) ) {
			$orderby = $_GET[ 'order-by' ];
		}
		else {
			
			if(!empty($sort_order)){
			  
			   $orderby = $sort_order;
			  
			} else {
				
			  $orderby = "date-new";
			}
		}
		?>
		<div class="search-results-header clearfix">
			
			<div class="search-results-view primary-tooltips">
				<i class="fa fa-repeat <?php if ( ! $orderby || $orderby != 'random' ) { echo 'hide'; } ?>" data-toggle="tooltip" title="<?php _e( 'Reload', 'tt' ); ?>"></i>
				<i class="fa fa-th-large <?php if ( isset( $listing_view ) && $listing_view == "grid-view" ) { echo "active"; } ?>" data-view="grid-view" data-toggle="tooltip" title="<?php _e( 'Grid View', 'tt' ); ?>"></i>
				<i class="fa fa-th-list <?php if ( isset( $listing_view ) && $listing_view == "list-view" ) { echo "active"; } ?>" data-view="list-view" data-toggle="tooltip" title="<?php _e( 'List View', 'tt' ); ?>"></i>
			</div>
			
			<div class="search-results-order clearfix">
				<div class="form-group select">
					<select name="order-by" id="orderby" class="form-control">
						<option value="featured" <?php selected( 'featured', $orderby ); ?>><?php _e( 'Featured First', 'tt' ); ?></option>
						<option value="date-new" <?php selected( 'date-new', $orderby ); ?>><?php _e( 'Sort by Date (Newest First)', 'tt' ); ?></option>
						<option value="date-old" <?php selected( 'date-old', $orderby ); ?>><?php _e( 'Sort by Date (Oldest First)', 'tt' ); ?></option>
						<option value="price-high" <?php selected( 'price-high', $orderby ); ?>><?php _e( 'Sort by Price (Highest First)', 'tt' ); ?></option>
						<option value="price-low" <?php selected( 'price-low', $orderby ); ?>><?php _e( 'Sort by Price (Lowest First)', 'tt' ); ?></option>
		        <option value="name-asc" <?php selected( 'name-asc', $orderby ); ?>><?php _e( 'Sort by Name (Ascending)', 'tt' ); ?></option>
		        <option value="name-desc" <?php selected( 'name-desc', $orderby ); ?>><?php _e( 'Sort by Name (Descending)', 'tt' ); ?></option>
						<option value="random" <?php selected( 'random', $orderby ); ?>><?php _e( 'Random', 'tt' ); ?></option>
					</select>
				</div>
			</div>
		
		</div>
		<?php
			
	}
}

/**
 * Get page ID set to "User - Profile" Page Template
 *
 */

if ( ! function_exists( 'tt_page_id_user_profile' ) ) {
	function tt_page_id_user_profile() {
		
		$template_user_profile_page_id = null;
		$template_user_profile_array = get_pages( array (
			'meta_key' => '_wp_page_template',
			'meta_value' => 'template-user-profile.php'
			)
		);
		
		if ( $template_user_profile_array ) {
			$template_user_profile_page_id = $template_user_profile_array[0]->ID;
		}
		
		return $template_user_profile_page_id;
		
	}
}

/**
 * Get page ID set to "User - Favorites" Page Template
 *
 */

if ( ! function_exists( 'tt_page_id_user_favorites' ) ) {
	function tt_page_id_user_favorites() {
		
		$template_user_favorites_page_id = null;
		$template_user_favorites_array = get_pages( array (
			'meta_key' => '_wp_page_template',
			'meta_value' => 'template-user-favorites.php'
			)
		);
		if ( $template_user_favorites_array ) {
			$template_user_favorites_page_id = $template_user_favorites_array[0]->ID;
		}
		
		return $template_user_favorites_page_id;
		
	}
}

/**
 * Get page ID set to "Property Submit" Page Template
 *
 */

if ( ! function_exists( 'tt_page_id_property_submit' ) ) {
	function tt_page_id_property_submit() {
		
		$template_property_submit_page_id = null;
		$template_property_submit_array = get_pages( array (
			'meta_key' => '_wp_page_template',
			'meta_value' => 'template-property-submit.php'
			)
		);
		if ( $template_property_submit_array ) {
			$template_property_submit_page_id = $template_property_submit_array[0]->ID;
		}
		
		return $template_property_submit_page_id;
		
	}
}

/**
 * Get page ID set to "Property Submit Listing" Page Template
 *
 */

if ( ! function_exists( 'tt_page_id_property_submit_listing' ) ) {
	function tt_page_id_property_submit_listing() {
		
		$template_property_submit_listing_page_id = null;
		$template_property_submit_listing_array = get_pages( array (
			'meta_key' => '_wp_page_template',
			'meta_value' => 'template-property-submit-listing.php'
			)
		);
		if ( $template_property_submit_listing_array ) {
			$template_property_submit_listing_page_id = $template_property_submit_listing_array[0]->ID;
		}
		
		return $template_property_submit_listing_page_id;
		
	}
}

/**
 * Get page ID set to "User Login" Page Template
 *
 */

if ( ! function_exists( 'tt_page_id_user_login' ) ) {
	function tt_page_id_user_login() {
		
		$template_user_login_page_id = null;
		$template_user_login_array = get_pages( array (
			'meta_key' => '_wp_page_template',
			'meta_value' => 'template-user-login.php'
			)
		);
		if ( $template_user_login_array  ) {
			
			$template_user_login_page_id = $template_user_login_array[0]->ID;
		}
		else {
		 $template_user_login_page_id = '#login-modal';
		}
		
		return $template_user_login_page_id;
		
	}
}