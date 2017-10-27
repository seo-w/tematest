<?php 
if ( wp_basename( get_page_template() ) == 'template-user-profile.php' ) {
	$profile_active = ' class="active"';
} else {
	$profile_active = null;
}

if ( wp_basename( get_page_template() ) == 'template-property-submit-listing.php' ) {
	$property_submit_listing_active = ' class="active"';
} else {
	$property_submit_listing_active = null;
}

if ( wp_basename( get_page_template() ) == 'template-property-submit.php' ) {
	$property_submit_active = ' class="active"';
} else {
	$property_submit_active = null;
}

if ( wp_basename( get_page_template() ) == 'template-user-favorites.php' ) {
	$favorites_active = ' class="active"';
} else {
	$favorites_active = null;
}
?>

<ul class="sidebar-widget-user-pages user-menu list-unstyled">
	<li<?php echo $profile_active; ?>><a href="<?php echo get_permalink( tt_page_id_user_profile() ); ?>"><i class="fa fa-cog"></i> <?php _e( 'Profile', 'tt' ); ?></a></li>
	<li<?php echo $property_submit_listing_active; ?>><a href="<?php echo get_permalink( tt_page_id_property_submit_listing() ); ?>"><i class="fa fa-database"></i> <?php _e( 'My Properties', 'tt' ); ?></a></li>
	<li<?php echo $property_submit_active; ?>><a href="<?php echo get_permalink( tt_page_id_property_submit() ); ?>"><i class="fa fa-plus"></i> <?php _e( 'Submit Property', 'tt' ); ?></a></li>
	<li<?php echo $favorites_active; ?>><a href="<?php echo get_permalink( tt_page_id_user_favorites() ); ?>"><i class="fa fa-heart"></i> <?php _e( 'Favorites', 'tt' ); ?></a></li>
	<li><a href="<?php echo wp_logout_url( site_url('/') ); ?>"><i class="fa fa-sign-out"></i> <?php _e( 'Logout', 'tt' ); ?></a></li>
</ul>