<?php
if( !function_exists('tt_stripe_process_payment') ):
function tt_stripe_process_payment() {
	global $realty_theme_option,$current_user;
	get_currentuserinfo();
	if(isset($_POST['action']) && $_POST['action'] == 'stripe' && wp_verify_nonce($_POST['stripe_nonce'], 'stripe-nonce')) {
		
		
		// load the stripe libraries
		require_once(TT_LIB . '/stripe/lib/Stripe.php');
		
		// retrieve the token generated by stripe.js
		$token = $_POST['stripeToken'];
		if(isset($_POST['stripeEmail']) && $_POST['stripeEmail']) { 
					$email_user = strip_tags(trim($_POST['stripeEmail']));
		} else {
			$email_user = '';
		}
		
		if(isset($realty_theme_option['stripe-api-secret-key']) && $realty_theme_option['stripe-api-secret-key']) {
		$secret_key =  strip_tags(trim($realty_theme_option['stripe-api-secret-key']));
		
		}else {
			$secret_key = '';
		}
			
		Stripe::setApiKey($secret_key);
		if(isset($_POST['stripe_plan']) && $_POST['stripe_plan']) { // process a recurring payment
			
			// recurring payment setup will go here
			$plan_id = strip_tags(trim(get_post_meta( base64_decode($_POST['stripe_plan']))), 'estate_package_stripe_id', true );
			$default_plan_id = base64_decode($_POST['stripe_plan']);
			try {			
				$customer = Stripe_Customer::create(array(
						'source' => $token,
						'plan' => $plan_id,
						'email' => $email_user,
					)
				);	
				$invoice_id = tt_create_user_invoice($default_plan_id, 'Stripe');
				tt_user_properties_publish_on_package_update($current_user->ID);
				// redirect on successful recurring payment setup
				$redirect = add_query_arg('payment', 'paid', $_POST['redirect']);
				
			} catch (Exception $e) {
				// redirect on failure
				$body = $e->getJsonBody();
                $err  = $body['error'];
				print('ERROR:' . $err['message'] . "\n");
  				$redirect = add_query_arg('payment', $e->getMesssage(), $_POST['redirect']);
				
			}
		   
		} else { // process a one-time payment
			
			// attempt to charge the customer's card
			if(isset($_POST['stripe_charge']) && $_POST['stripe_charge']) { 
				
				$property_id = base64_decode($_POST['stripe_charge']);
			    if ( isset( $property_id ) ) {
					$property_id = $property_id;
				}
				$stripe_enable_subscription = $realty_theme_option['paypal-enable-subscription'];
				$stripe_subscription_recurrence = $realty_theme_option['paypal-subscription-recurrence'];
				$stripe_subscription_period = $realty_theme_option['paypal-subscription-period'];
				$stripe_settings_amount = $realty_theme_option['paypal-amount'];
				$stripe_featured_amount = $realty_theme_option['paypal-featured-amount'];
				
				$property_extra_featured = get_post_meta( $property_id, 'estate_property_featured', true );
				if ( $property_extra_featured ) {
					$stripe_settings_amount = $stripe_settings_amount + $stripe_featured_amount;
				}
				
				$stripe_settings_currency_code = $realty_theme_option['paypal-currency-code'];	
				try {
					$charge = Stripe_Charge::create(array(
							'amount' => $stripe_settings_amount*100, // $10
							'source' => $token,
							'currency' => $stripe_settings_currency_code,
							'description' => get_the_title($property_id).'-'.$property_id,
							//'email' => $email_user,
						)
					);
					$invoice_id = tt_create_user_invoice($property_id, 'Stripe');
					$paypal_settings_auto_publish = $realty_theme_option['paypal-auto-publish'];
					if( $paypal_settings_auto_publish ) {
						$property = array(
							'ID'		=> $property_id,
							'post_status' => 'publish',
						);
						wp_update_post( $property );
					}
					// redirect on successful payment
					$redirect = add_query_arg('payment', 'paid', $_POST['redirect']);
					
				} catch (Exception $e) {
					// redirect on failed payment
					$redirect = add_query_arg('payment', 'failed', $_POST['redirect']);
				}
			}
			
		}
		
		// redirect back to our previous page with the added query variable
		wp_redirect($redirect); exit;
	}
}
endif;
add_action('init', 'tt_stripe_process_payment', 20);

if( !function_exists('tt_load_stripe_scripts') ):
function tt_load_stripe_scripts() {

	global $realty_theme_option;
	
	// check to see if we are in test mode
	$publishable='';
	if(isset($realty_theme_option['stripe-api-publishable-key']) && $realty_theme_option['stripe-api-publishable-key']) {
		$publishable = $realty_theme_option['stripe-api-publishable-key'];
	} 
	if(is_singular('package') || is_page_template('template-property-submit-listing.php')){
		wp_enqueue_script('stripe', 'https://js.stripe.com/v2/');
		wp_enqueue_script('stripe-processing', get_template_directory_uri() . '/lib/stripe/js/stripe-processing.js');
	}
	wp_localize_script('stripe-processing', 'stripe_vars', array(
			'publishable_key' => $publishable,
		)
	);
}
endif;
add_action('wp_enqueue_scripts', 'tt_load_stripe_scripts');


if( !function_exists('tt_stripe_payment_form') ):
function tt_stripe_payment_form($plan_id='') {
	
	global $realty_theme_option;
	$publishable_key = trim($realty_theme_option['stripe-api-publishable-key']);
	if(isset($_GET['payment']) && $_GET['payment'] == 'paid' && get_post_type($plan_id)=='package') {
		if(get_post_type($plan_id)=='package'){
			echo '<p class="alert alert-success">' . __( 'Thank you for your payment. You are successfully subscribed.', 'tt' ) . '</p>';
		} 	
		
	} else { ?>
		<form action="" method="POST" id="stripe-payment-form">
            <script
			  src="http://checkout.stripe.com/v2/checkout.js" class="stripe-button"
			  data-key="<?php echo $publishable_key; ?>"
			  data-name="<?php bloginfo( 'name' ); ?>"
			  data-description="<?php echo esc_attr( get_the_title($plan_id) ); ?>">
			</script>
			<input type="hidden" name="action" value="stripe"/>
            <?php if(get_post_type($plan_id)=='package'){ ?>
                        <input type="hidden" name="stripe_plan" value="<?php echo base64_encode($plan_id); ?>"/>
                        <input type="hidden" name="redirect" value="<?php echo get_permalink(); ?>"/>
            <?php } else {
						$template_page_property_submit_listing_array = get_pages( array (
							'meta_key' => '_wp_page_template',
							'meta_value' => 'template-property-submit-listing.php'
						)
						);
						if ( $template_page_property_submit_listing_array ) {
							$submit_listing_page = $template_page_property_submit_listing_array[0]->ID;
						}
			?>
                        <input type="hidden" name="stripe_charge" value="<?php echo base64_encode($plan_id); ?>"/>
                        <input type="hidden" name="redirect" value="<?php echo get_permalink($submit_listing_page); ?>"/>
            <?php } ?>
			<input type="hidden" name="stripe_nonce" value="<?php echo wp_create_nonce('stripe-nonce'); ?>"/>
		</form>
		<div class="payment-errors"></div>
		<?php
	}
}
endif;