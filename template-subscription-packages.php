<?php get_header();
/*
Template Name: Membership Packages
*/
?>

<div class="container">
	
	<div class="row">
	
		<?php
		$hide_sidebar = get_post_meta( $post->ID, 'estate_page_hide_sidebar', true );
		// Check for Page Sidebar
		if ( !$hide_sidebar && is_active_sidebar( 'sidebar_page' ) ) {
			echo '<div class="col-sm-8 col-md-9">';
		} else {
			echo '<div class="col-sm-12">';
		}
		?>
     	<?php 
		global $realty_theme_option;
		if($realty_theme_option['property-submission-type']=='membership'){
			$query_package_args = array(
				'post_type' 	=> 'package',
				'orderby'       => 'date',
				'order'         => 'ASC',
				'post_status'   => 'publish',
		
			);
			$query_packages = new WP_Query( $query_package_args);
			?>
			<div class="col-sm-12">
			  
	  <div id="property-items" class="show-compare subscriptions " data-view="grid-view" style="opacity: 1;"> 
		<ul class="row list-unstyled">
		<?php if ( $query_packages->have_posts() ) : while ( $query_packages->have_posts() ) : $query_packages->the_post(); 
					$active = get_post_meta( $post->ID, 'estate_if_package_active', true );
					$subscription_unit = get_post_meta( $post->ID, 'estate_package_period_unit', true );
					$number_of_ocurrances = get_post_meta( $post->ID, 'estate_package_valid_renew', true );
					$regular_listings = get_post_meta( $post->ID, 'estate_package_allowed_listings', true );
					$featured_listings = get_post_meta( $post->ID, 'estate_package_allowed_featured_listings', true );
					$package_price = get_post_meta( $post->ID, 'estate_package_price', true );
					$stripe_id = get_post_meta( $post->ID, 'estate_package_stripe_id', true );
				
				if($active){
		?>		
					<li class="col-lg-4 col-md-6">
					<div class="property-item primary-tooltips title-above-image">
					
						<div class="property-title">
							<h3 class="title" style="text-align:center;"><?php the_title(); ?></h3>
							
					   </div>
				
					<div class="property-content">
							<div class="property-meta clearfix">
								<div>
									<div class="meta-data" data-toggle="tooltip" title="" data-original-title="Allowed Listings"><?php _e('Regular Listings'); ?></div>
								</div>
								<div>
									<div class="meta-data" data-toggle="tooltip" title="" data-original-title="Listings"><?php _e($regular_listings); ?></div>
								</div>
								<div>
									<div class="meta-data" data-toggle="tooltip" title="" data-original-title="Allowed Featured Listings"><?php _e('Featured Listings'); ?></div>
								</div>
								<div>
									<div class="meta-data" data-toggle="tooltip" title="" data-original-title="Listings"><?php _e($featured_listings); ?></div>
								</div>
								<div>
									<div class="meta-data" data-toggle="tooltip" title="" data-original-title="Subscription Duration"><?php _e('Subscription Period'); ?></div>
								</div>
								<div>
									<div class="meta-data" data-toggle="tooltip" title="" data-original-title="Duration"><?php _e($number_of_ocurrances .' '. $subscription_unit); ?></div>
								</div>
							</div>
							
					<div class="property-price">
					<span class="meta-data">Price</span>
					<div class="price-tag"><?php echo $realty_theme_option['currency-sign']; ?><?php _e($package_price); ?></div>
					</div>
					
				</div>
				
			</div> 
							<a href="<?php if(is_user_logged_in()){ echo get_permalink($post->ID); } else{ echo "?login"; } ?>"><input type="button" value="Subscribe" class="subscribe-button btn btn-primary btn-block form-control"></a>
						</li>
						<?php } ?>
	<?php endwhile;
	wp_reset_query();
	endif; ?>
	
	</ul>
			
		
		
			
		</div><!-- package item -->
			</div>
            <?php } else {
				echo '<p class="alert alert-danger">' . __( 'Please enable memberships in Theme Options and create packages also.', 'tt' ) . '</p>';
			
			}
			?>
			
			</div><!-- .col-sm-9 -->
		
		<?php 
		// Check for Page Sidebar
		if ( !$hide_sidebar && is_active_sidebar( 'sidebar_page' ) ) : 
		?>
		<div class="col-sm-4 col-md-3">
			<ul id="sidebar">
				<?php dynamic_sidebar( 'sidebar_page' ); ?>
			</ul>
		</div>
		<?php endif; ?>
	
	</div><!-- .row -->
	
</div><!-- .container -->

<?php get_footer(); ?>