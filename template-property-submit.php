<?php 
/*
Template Name: Property Submit
*/

// Check If We Create Or Edit A Property
acf_form_head();
get_header();
$hide_footer_widgets = get_post_meta( $post->ID, 'estate_page_hide_footer_widgets', true );
$is_assigned_agent = false;
$property_id = 0;
global $realty_theme_option;

if ( isset( $_GET['edit'] ) && ! empty( $_GET['edit'] ) ) {
	// Edit Property
	
	$edit = $_GET['edit'];
	$property_id = $edit;
	$property = get_post($edit);
	$property_author = '';
	if( get_post_type ( $property) == 'property' ) {
		
		$assigned_agent = get_post_meta( $property_id, 'estate_property_custom_agent', true );
		$property_author = $property->post_author ;
		if ( get_current_user_id() == $assigned_agent ) {
			
			$is_assigned_agent = true;
			
		}
	}
				
	$acf_form_post_id = $edit;
	$submit_value = __( 'Update Property', 'tt' );
	$updated_message = '<div class="alert alert-success alert-dismissable">' . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . __( 'Property update successful.', 'tt' ) . '</div>';
    
} else {
	
	// New Property
	$edit = null;
	$acf_form_post_id = 'new_post';
	$submit_value = __( 'Submit Property', 'tt' );
	$updated_message = '<div class="alert alert-success alert-dismissable">' . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . __( 'Property has been published.', 'tt' ) . '</div>';
	
}

$post_status = 'pending';

// Post Status
if ( is_user_logged_in() ) {
	
	global $current_user;
	get_currentuserinfo();
	$current_user_role = $current_user->roles[0];
	$allow_submit_all = false;	
	// User Role "Agent" and "Admin" can publish, "Subscriber" is "pending"
	if ( $current_user_role == 'agent' || current_user_can( 'manage_options' ) ) {
		
		$post_status = 'publish';
		$allow_submit_all = true;
		
	} else {
		
		$post_status = 'pending';
		$submit_type = $realty_theme_option['property-submission-type'];
		if($submit_type == 'per-listing'){
			
			$updated_message = '<div class="alert alert-success alert-dismissable">' . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . __( 'Property is submitted, To Publish it Please Go to My Properties and Make Payment.', 'tt' ) . '</div>';
			
		} else if( $submit_type == 'membership'){
			
			if( !$edit ) {
				
				$updated_message = '<div class="alert alert-success alert-dismissable">' . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . __( 'Property is submitted and published.', 'tt' ) . '</div>';
				
			}
			
		}
		else {
			
			$updated_message = '<div class="alert alert-success alert-dismissable">' . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . __( 'Property is submitted,It will be Published Soon.', 'tt' ) . '</div>';
			
		}
		
	}
	$allowed_submit_on_membership = false;
	if($realty_theme_option['property-submission-type'] == 'membership' && $current_user_role == 'subscriber') {
		//echo tt_is_user_membership_valid($current_user->ID);
		$valid_member = tt_is_user_membership_valid($current_user->ID);
		
		if($valid_member == 1 ){
			
			if( tt_user_remaining_listings( $current_user->ID ) > 0 || tt_user_remaining_featured_listings($current_user->ID ) > 0 || tt_user_remaining_listings($current_user->ID) == 'Unlimited' || tt_user_remaining_featured_listings($current_user->ID) == 'Unlimited' ){
				
					$allowed_submit_on_membership = true;
					
					$post_status = 'publish';
					$remaining_listings = tt_user_remaining_listings($current_user->ID);
					$featured_listings = tt_user_remaining_featured_listings($current_user->ID);
					$package_id = get_user_meta($current_user->ID,'subscribed_package_default_id',true);
					$package_title = get_the_title($package_id);
					echo '<p class="alert alert-info">' . __( 'Your Package: '.$package_title.' | '.'Remaining Listings: '.$remaining_listings.' | '.'Remaining Featured Listings: '.$featured_listings , 'tt' ) . '</p>';				
					
			}
			else {
				
				$allowed_submit_on_membership = true;
					
					$post_status = 'pending';
					$remaining_listings = tt_user_remaining_listings($current_user->ID);
					$featured_listings = tt_user_remaining_featured_listings($current_user->ID);
					$package_id = get_user_meta($current_user->ID,'subscribed_package_default_id',true);
					$package_title = get_the_title($package_id);
					echo '<p class="alert alert-info">' . __( 'Your Package: '.$package_title.' | '.'Remaining Listings: '.$remaining_listings.' | '.'Remaining Featured Listings: '.$featured_listings , 'tt' ) . '</p>';	
				
			}
		}
		
		
	}
}
// http://www.advancedcustomfields.com/resources/acf_form/
$form_options = array(

	'post_id'         => $acf_form_post_id,
	'post_title'      => true,
	'post_content'    => true,
	'form_attributes' => array(
		'id'              => 'property-submit',
	),
	'new_post'		    => array(
		'post_type'	      => 'property',
		'post_status'	    => $post_status
	),
	'submit_value'    => $submit_value,
	'updated_message' => $updated_message,
);
?>

</div><!-- .container -->
<?php tt_page_banner();	?>
<div class="container">

<div id="main-content" class="content-box">
	<?php
	if ( ! $edit ) {
		
		echo '<h1 class="section-title"><span>' . __( 'Submit New Property', 'tt' ) . '</span></h1>';
		
	}
	if ( is_user_logged_in() && (  ($property_id == 0 || get_current_user_id() == $property_author ) || $is_assigned_agent ) || current_user_can( 'manage_options' )  )     {
		
		if ( $realty_theme_option['property-submission-type'] == 'per-listing' && !$realty_theme_option['paypal-alerts-hide'] && ( $current_user_role == "subscriber" && !$realty_theme_option['property-submit-disabled-for-subscriber'] && ( get_post_status( $property_id ) != 'publish' || $property_id == 0 ) ) ) { ?>
        
			<p class="alert alert-info alert-dismissable property-payment-note">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php 
				echo __( 'Publishing Fee', 'tt' ) . ': ' . $realty_theme_option['paypal-currency-code'] . ' ' . $realty_theme_option['paypal-amount'];
				
				if ( doubleval($realty_theme_option['paypal-featured-amount']) > 0 ) {
					
					echo ' | ' . __( '"Featured" upgrade', 'tt' ) . ': ' . $realty_theme_option['paypal-currency-code'] . ' ' . $realty_theme_option['paypal-featured-amount'];
					
				}
				
				?>
			</p>
			<p class="alert alert-info alert-dismissable property-payment-note-2">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php
				if ( $realty_theme_option['paypal-auto-publish'] ) {
					
					_e( 'Property will be published automatically after payment completion.', 'tt' );
					
				}
				else {
					
					_e( 'Property will be published manually after payment completion.', 'tt' );
					
				}
				?>
			</p>
  <?php } 
	    if( $current_user_role == 'subscriber' && $realty_theme_option['property-submit-disabled-for-subscriber']){
			
			echo '<p class="alert alert-danger">' . __( 'As a subscriber you do not have permission to submit or edit properties.', 'tt' ) . '</p>';
			
		} else {
			
			if($realty_theme_option['property-submission-type'] == 'membership'){
				
				if( $allowed_submit_on_membership || $allow_submit_all ){
					
					acf_form( $form_options );
					
				} else {
					
					echo '<p class="alert alert-info">' . __( 'Your subscription package is either expired or you have reached your allowed number of listings. Please visit your profile page and check the status or select a package to subscribe.', 'tt' ) . '</p>';
					echo do_shortcode('[membership_packages]');
					
				}
			}
			else {
				acf_form( $form_options );
			}
			
		}
		
	} else {
		
			echo '<p class="alert alert-danger">' . __( 'You have to be logged-in to submit properties.', 'tt' ) . '</p>';
	}
	?>
</div>
<?php get_footer(); ?>	
