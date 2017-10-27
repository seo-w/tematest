<?php
/* META BOX PROPERTY PAYMENT
============================== */
function tt_add_meta_box_property_payment() {
  add_meta_box( 'meta-box', __('Property Payment Details', 'tt' ), 'tt_meta_box_property_payment', 'property', 'normal', 'core' );
}
add_action( 'add_meta_boxes', 'tt_add_meta_box_property_payment' );

if ( !function_exists('tt_meta_box_property_payment') ) {
	function tt_meta_box_property_payment( $post ) {
	
	  $payment_data = get_post_custom( $post->ID );
	  $empty  = '-';
	
	  $property_payment_txn_id = isset( $payment_data['property_payment_txn_id'] ) ? $payment_data['property_payment_txn_id'][0] : $empty;
	  $property_payment_date   = isset( $payment_data['property_payment_payment_date'] ) ? $payment_data['property_payment_payment_date'][0] : $empty;
	  $property_payment_payer_email = isset( $payment_data['property_payment_payer_email'] ) ? $payment_data['property_payment_payer_email'][0] : $empty;
	  $property_payment_first_name = isset( $payment_data['property_payment_first_name'] ) ? $payment_data['property_payment_first_name'][0] : $empty;
	  $property_payment_last_name = isset( $payment_data['property_payment_last_name'] ) ? $payment_data['property_payment_last_name'][0] : $empty;
	  $property_payment_status = isset( $payment_data['property_payment_status'] ) ? $payment_data['property_payment_status'][0] : $empty;
	  $property_payment_mc_gross = isset( $payment_data['property_payment_mc_gross'] ) ? $payment_data['property_payment_mc_gross'][0] : $empty;
	  $property_payment_mc_currency = isset( $payment_data['property_payment_mc_currency'] ) ? $payment_data['property_payment_mc_currency'][0] : $empty;
	
	  $output  = '<p>';
	  $output .=  '<span style="color:limegreen; font-weight:700; text-transform:uppercase">' . $property_payment_status . '</span><br />';
	  $output .= $property_payment_mc_currency . ' ' . $property_payment_mc_gross . '<br />';
	  $output .= $property_payment_first_name . ' ' . $property_payment_last_name . '<br />';
	  $output .= $property_payment_payer_email . '<hr>';
	  $output .= '</p>';
	  $output .= $property_payment_txn_id . '<br />';
	  $output .= $property_payment_date . '<br />';
	  
	  if ( $property_payment_status == 'Completed' ) {
	  	echo $output;
	  }
	  else {
		  echo '-';
	  }
	}
}