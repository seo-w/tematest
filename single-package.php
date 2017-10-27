<?php get_header(); ?>
<div class="row testimonial-item">
	<div class="col-sm-12">
		<div class="content">
		<?php		
		global $realty_theme_option;
		
		if ( $realty_theme_option['property-submission-type'] == 'membership' ) {
			
		$active = get_post_meta( $post->ID, 'estate_if_package_active', true );
		$subscription_unit = get_post_meta( $post->ID, 'estate_package_period_unit', true );
		$subscription_unit = substr( $subscription_unit, 0 , -1 );
		$number_of_ocurrances = get_post_meta( $post->ID, 'estate_package_valid_renew', true );
		$regular_listings = get_post_meta( $post->ID, 'estate_package_allowed_listings', true );
		$featured_listings = get_post_meta( $post->ID, 'estate_package_allowed_featured_listings', true );
		$package_price = get_post_meta( $post->ID, 'estate_package_price', true );
		$stripe_id = get_post_meta( $post->ID, 'estate_package_stripe_id', true );
		$user_role = '';
		
		if( is_user_logged_in() ) {	
			
			global $current_user;
			get_currentuserinfo();
			$user_role = $current_user->roles[0];
			
			if ( $user_role == 'subscriber' ) {
				
				$user_listings = get_user_meta( $current_user->ID, 'subscribed_listing_remaining', true );
				$user_featured = get_user_meta( $current_user->ID, 'subscribed_featured_listing_remaining', true );
				$free_subscribed_before = get_user_meta( $current_user->ID, 'subscribed_free_package_once', true );
				$package_id = get_user_meta ( $current_user->ID, 'subscribed_package_default_id', true );
				$package = get_post( $package_id );
				if ( tt_is_user_membership_valid( $current_user->ID ) == 1) {
				
					if ( $user_listings <= $regular_listings || $user_featured <= $featured_listings || $user_listings == 'Unlimited' ) {
						
					echo '<div class="alert alert-info alert-dismissable">' . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . __( 'You have already subscribed to', 'tt' ) . ' <strong>' . __($package->post_title,'tt') . '</strong>. ' . __( 'Listings are available. If you still want to subsctibe to this package proceed to make payment.', 'tt' ) . '</div>';
					
					} else {
						
					echo '<div class="alert alert-info alert-dismissable">' . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . __( 'You are subscribed', 'tt' ) .  ' <strong>' . __($package->post_title,'tt' ). '</strong>. ' . __( 'But your allowed number of listings is reached. Proceed to make payment for this package.', 'tt' ) . '</div>';
					
					}
				
				}
				
			}
		
		}
		?>
		
		<style>
			.package-detail {
				display: inline-block;
				min-width: 250px;
			}
		</style>	
		
		<h1 class="title"><?php _e( get_the_title(), 'tt' ); ?></h1>
		
		<ul>
			<li><span class="package-detail"><?php _e( 'Included Regular Listings', 'tt' ); ?>: </span><?php echo $regular_listings; ?></li>
			<li><span class="package-detail"><?php _e( 'Included Featured Listings', 'tt' ); ?>: </span><?php echo $featured_listings; ?></li>
			<li><span class="package-detail"><?php _e( 'Subscription Period', 'tt' ); ?>: </span><?php echo $number_of_ocurrances . ' ' . _n( $subscription_unit, $subscription_unit . 's', $number_of_ocurrances, 'tt'); ?></li>
		</ul>
		
		<h5><?php echo __( 'Price', 'tt' ) . ': ' . $realty_theme_option['currency-sign'] . __( $package_price ); ?></h5>	

		<?php
		if ( is_user_logged_in() ) {
			
		if ( isset($_GET['payment'] ) && $_GET['payment'] == 'failed') {
			echo '<p class="alert alert-danger">' . __( 'Payment failed! Please try again with correct payment information.', 'tt' ) . '</p>';
		}
		
		if ( $user_role != 'agent' && !current_user_can( 'manage_options' )  ) {
          if($package_price > 0) {
          
  		 ?>
		  <ul class="list-unstyled">
			<li style="margin-bottom: 1em">
			<?php 
			if ( $realty_theme_option['enable-stripe-payments'] ) {
				tt_stripe_payment_form( $post->ID ); 
			}
			?> 
			</li>
			<li>
				<div class="package-paypal-button">
				<?php 
				if( $realty_theme_option['paypal-enable'] ) {
					echo tt_package_payment_button( $post->ID ); 
				}
				?>
				</div>
			</li>
		</ul> 
        <?php  } else {
			   
			    if(isset($_GET['subscribe_for_free']) && $_GET['subscribe_for_free'] == 'confirmed') {
					
					if( $free_subscribed_before == 'Yes' ) {
						echo '<p class="alert alert-danger">' . __( 'You are already Subscribed to free package Once, please go for other premium packages.', 'tt' ) . '</p>';
					   
					} else {
					
					   echo '<p class="alert alert-info">' . __( 'You are Successfully Subscribed.', 'tt' ) . '</p>';
					   $invoice_id = tt_create_user_invoice($post->ID, '');
					   update_user_meta( $current_user->ID, 'subscribed_free_package_once', 'Yes');
					
					}
				}
				else {
					
				   echo '<a class="btn" style="background-color: '.$realty_theme_option['paypal-enable'].'" href="?subscribe_for_free=confirmed">Subscribe</a>';
				   
				}
				  
			}
		
		} else { // Role "subscriber
		
			echo '<p class="alert alert-info">' . __( 'You are visiting this page as admin or agent. Please login as "Subscriber" to subscribe to this package.', 'tt' ) . '</p>';
			
		} 
		} else { // Not logged-in visitor
		
			echo '<p class="alert alert-info">' . __( 'You are not logged in. Please login as "Subscriber" to subscribe to this package.', 'tt' ) . '</p>';
			
		}
		} else { // Memberships aren't enabled
		
			echo '<p class="alert alert-info">' . __( 'This page is not available, memberships are not enabled.', 'tt' ) . '</p>';
			
		}
		
		while ( have_posts() ) : the_post();				
			the_content();
		endwhile;
		?>
		
		</div><!-- .content -->
	</div><!-- .col-sm -->
</div><!-- .testimonial-item -->
<?php get_footer(); ?>