<?php
global $realty_theme_option, $current_user;

$add_favorites_temporary = $realty_theme_option['property-favorites-temporary'];
?>
<div id="login-bar-header" class="primary-tooltips">
	<?php if ( !is_user_logged_in() ) { 
	if ( $add_favorites_temporary && !$realty_theme_option['property-favorites-disabled'] ) {
	?>
	<a href="<?php echo get_permalink( tt_page_id_user_favorites() ); ?>">
		<?php echo '<span class="desktop">' . __( 'Favorites', 'tt' ) . '</span>'; ?></span>
		<span class="mobile" data-toggle="tooltip" data-placement="bottom" title="<?php _e( 'Favorites', 'tt' ); ?>"><i class="fa fa-heart"></i></span>
	</a>
	<?php } 
	// Theme Option: Hide Submit Link
	if ( !$realty_theme_option['site-header-hide-property-submit-link'] && !$realty_theme_option['property-submit-hide-link'] ) { 
	?>
	<a href="#login-modal" data-toggle="modal"><?php _e( 'Submit Property', 'tt' ); ?></a>
	<?php } ?>
	<a href="<?php if ( $realty_theme_option['header-login-modal-layout'] == 'login-page' ) { echo get_permalink( tt_page_id_user_login() ); } else { echo '#login-modal'; } ?>" data-toggle="modal"><?php if ( get_option('users_can_register') ) { _e( 'Login/Register', 'tt' ); } else { _e( 'Login', 'tt' ); } ?></a>
	<?php }	
	// Logged-In User
	else {
	
	get_currentuserinfo();
	$current_user_role = $current_user->roles[0];

	$user_id = get_current_user_id();
					
	$get_user_meta_favorites = get_user_meta( $user_id, 'realty_user_favorites', false ); // false = array()
	
	$number_of_favorites = 0;
	
	if ( $get_user_meta_favorites ) {
		foreach ( $get_user_meta_favorites[0] as $favorite ) {
			if ( get_post_status( $favorite ) == "publish" ) {
				$number_of_favorites++;
			}
		}
	}
	
	if ( !$realty_theme_option['property-favorites-disabled'] ) {
	?>
	<a href="<?php echo get_permalink( tt_page_id_user_favorites() ); ?>">
		<?php echo '<span class="desktop">' . __( 'Favorites', 'tt' ) . ' (<span>' . $number_of_favorites . '</span>)</span>'; ?></span>
		<span class="mobile" data-toggle="tooltip" data-placement="bottom" title="<?php _e( 'Favorites', 'tt' ); ?>"><i class="fa fa-heart"></i></span>
	</a>
	<?php 
	}
	if ( !$realty_theme_option['property-submit-hide-link'] ) { 
	// Theme Option: Is Property Submit For Subscribers Disabled?
	if ( $current_user_role != "subscriber" || !$realty_theme_option['property-submit-disabled-for-subscriber'] ) { 
	?>
	<a href="<?php echo get_permalink( tt_page_id_property_submit() ); ?>">
		<?php echo '<span class="desktop">' . __( 'Submit Property', 'tt' ) . '</span>'; ?>
		<span class="mobile" data-toggle="tooltip" data-placement="bottom" title="<?php _e( 'Submit Property', 'tt' ); ?>"><i class="fa fa-send"></i></span>
	</a>
	<?php 
	}
	}
	$user_published_properties_args = array(
		'post_type' 				=> 'property',
		'posts_per_page' 		=> -1,
		'author' 						=> $current_user->ID,
		'post_status'				=> array( 'publish', 'pending' )
	);
	$query_user_published_properties = new WP_Query( $user_published_properties_args );
	// Check If Subscriber Has Any Any Pending Or Published Properties
	if ( $current_user_role != "subscriber" || $query_user_published_properties->have_posts() ) :
	?>
	<a href="<?php echo get_permalink( tt_page_id_property_submit_listing() ); ?>">
		<?php echo '<span class="desktop">' . __( 'My Properties', 'tt' ) . '</span>'; ?>
		<span class="mobile" data-toggle="tooltip" data-placement="bottom" title="<?php _e( 'My Properties', 'tt' ); ?>"><i class="fa fa-home"></i></span>
	</a>
	<?php
	endif;
	wp_reset_query();
	?>
	<a href="<?php echo get_permalink( tt_page_id_user_profile() ); ?>">
		<?php echo '<span class="desktop">' . __( 'Profile', 'tt' ) . '</span>'; ?>
		<span class="mobile" data-toggle="tooltip" data-placement="bottom" title="<?php _e( 'Profile', 'tt' ); ?>"><i class="fa fa-user"></i></span>
	</a>
	<a href="<?php echo wp_logout_url( site_url('/') ); ?>"><?php _e( 'Logout', 'tt' ); ?></a>
	<?php } ?>
</div>