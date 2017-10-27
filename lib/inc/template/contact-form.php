<section id="contact" class="content-box">
	<h4 class="section-title"><span><?php _e( 'Contact', 'tt' ); ?></span></h4>
  <?php 
  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
  if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) && $realty_theme_option['property-contact-form-cf7-shortcode'] ) { 
  	echo do_shortcode( '[contact-form-7 id="' . $realty_theme_option['property-contact-form-cf7-shortcode'] . '" title="Contact - 1 Column"]' );
  } else {
  ?>
  <form id="contact-form" method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
		<div class="row primary-tooltips">
			<div class="form-group col-sm-4">	
				<span class="input">
					<input type="text" name="name" id="name" class="form-control" title="<?php _e( 'Please enter your name.', 'tt' ); ?>">
					<label class="input-label"><span class="input-span"><?php _e( 'Name', 'tt' ); ?></span></label>
				</span>	
				<span class="input">
					<input type="text" name="email" id="email" class="form-control" title="<?php _e( 'Please enter your email.', 'tt' ); ?>">
					<label class="input-label"><span class="input-span"><?php _e( 'Email', 'tt' ); ?></span></label>
				</span>
				<span class="input">
					<input type="text" name="phone" id="phone" class="form-control" title="<?php _e( 'Please enter only digits for your phone number.', 'tt' ); ?>">
					<label class="input-label"><span class="input-span"><?php _e( 'Phone', 'tt' ); ?></span></label>
				</span>
			</div>
			<div class="form-group col-sm-8">
				<span class="input textarea">
					<textarea name="message" id="message" class="form-control" title="<?php _e( 'Please enter your message.', 'tt' ); ?>"></textarea>
					<label class="input-label"><span class="input-span"><?php _e( 'Message', 'tt' ); ?></span></label>
				</span>
			</div>
		</div>
		<input type="submit" name="submit" value="<?php _e( 'Send Message', 'tt' ); ?>" >
		<input type="hidden" name="action" value="submit_property_contact_form" />
		<input type="hidden" name="nonce" value="<?php echo wp_create_nonce(); ?>" />
		<?php 
		// Check If Agent Has An Email Address
		if ( isset( $email ) && ! empty( $email ) ) {
		?>
		<input type="hidden" name="agent_email" value="<?php echo antispambot( $email ); ?>">
		<?php 
		} 
		// No Agent Email Address Found -> Send Email To Site Administrator
		else { ?>
		<input type="hidden" name="agent_email" value="<?php echo antispambot( $property_contact_form_default_email ); ?>">
		<?php } ?>
		<input type="hidden" name="property_title" value="<?php echo get_the_title( get_the_ID() ); ?>" />
		<input type="hidden" name="property_url" value="<?php echo get_permalink( get_the_ID() ); ?>" />
	</form>
	<?php } ?>
	<div id="form-success" class="hide alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<?php _e( 'Message has been sent successfully.', 'tt' ); ?>
	</div>
	<div id="form-submitted"></div>
</section>