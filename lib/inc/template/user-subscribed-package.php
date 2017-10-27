<?php
if ( is_user_logged_in() ) {
	
	$user_id = get_current_user_id();
	$userdata = get_userdata( $user_id );
	
	if ( $userdata->subscribed_package != '' ) {
		
	$package_subscribed = $userdata->subscribed_package;
	$remain_listings = $userdata->subscribed_listing_remaining;
	
	if ( $remain_listings == -1 ) {
		$remain_listings = 'Unlimited';
	}
	
	$remain_listings_featured = $userdata->subscribed_featured_listing_remaining;
	if ( $remain_listings_featured == -1 ) {
		$remain_listings_featured = 'Unlimited';
	}
	
	$package_id = $userdata->subscribed_package_default_id;
	$package_title = get_the_title( $package_id );
	?>
	
	<div class="sidebar-widget-user-pages">
		<h4><?php _e( 'Subscribed Package', 'tt' ); ?></h4>
		<h5><?php _e( $package_title, 'tt' ); ?></h5>
		<label for="subscribed_listing_remaining"><?php _e( 'Remaining Listings:', 'tt' ); ?></label>
		<label for="subscribed_listing_remaining"><?php _e( $remain_listings, 'tt' ); ?></label>
		<label for="subscribed_featured_listing_remaining"><?php _e( 'Remaining Featured Listings: ', 'tt' ); ?></label>
		<label for="subscribed_featured_listing_remaining"><?php _e( $remain_listings_featured, 'tt' ); ?></label>						
	</div>
	
	<?php 
	}

}	
?>