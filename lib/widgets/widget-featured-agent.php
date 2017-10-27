<?php
// Credits: http://buffercode.com/simple-method-create-custom-wordpress-widget-admin-dashboard/
// REGISTER WIDGET
function widget_agents() {
	register_widget( 'widget_agents' );
}
add_action( 'widgets_init', 'widget_agents' );

class widget_agents extends WP_Widget {

	// CONSTRUCT WIDGET
	function widget_agents() {
		$widget_ops = array( 
			'classname' 	=> 'widget_agents', 
			'description' => __( 'Featured Agent', 'tt' ),
			'panels_icon' => 'icon-themetrail',
		);
		parent::__construct( 'widget_agents', __( 'Realty - Featured Agent', 'tt' ), $widget_ops );
	}
	
	// CREATE WIDGET FORM (WORDPRESS DASHBOARD)
  function form($instance) {
  
	  if ( isset( $instance[ 'title' ] ) && isset ( $instance[ 'agent' ] ) ) {
			$title = $instance[ 'title' ];
			$agent = $instance[ 'agent' ];
		}
		else {
			$title = __( 'Featured Agent', 'tt' );
			$agent = false;
		}
		if ( isset ( $instance[ 'random' ] ) ) {
			$random = $instance[ 'random' ];
		}
		else {
			$random = false;
		}
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tt' ); ?></label> 
			<input name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title );?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'agent' ); ?>"><?php _e( 'Choose Featured Agent:', 'tt' ); ?></label> 
			<select name="<?php echo $this->get_field_name( 'agent' ); ?>" id="<?php echo $this->get_field_id( 'agent' ); ?>" class="widefat">
				<?php 
				$all_agents = get_users( array( 'role' => 'agent', 'fields' => 'ID' ) );
				foreach( $all_agents as $single_agent ) { ?>
					<option value="<?php echo $single_agent; ?>" <?php selected( $agent, $single_agent ); ?>><?php echo get_user_meta($single_agent, 'first_name', true ) . ' ' . get_user_meta($single_agent, 'last_name', true ); ?></option>
				<?php } ?>
			</select>
		</p>
		
		<p>
			<input name="<?php echo $this->get_field_name( 'random' ); ?>" type="checkbox" <?php checked( $random, 'on' ); ?> />
			<label for="<?php echo $this->get_field_id( 'random' ); ?>"><?php _e( 'Show Random Agent', 'tt' ); ?></label> 
		</p>
		 
		<?php
		
  }

  // UPDATE WIDGET
  function update( $new_instance, $old_instance ) {
  	  
	  $instance = $old_instance;
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';		 
		$instance['agent'] = $new_instance['agent'];		 		 
		$instance['random'] = ( ! empty( $new_instance['random'] ) ) ? strip_tags( $new_instance['random'] ) : '';
		
		return $instance;
	  
  }

  // DISPLAY WIDGET ON FRONT END
  function widget( $args, $instance ) {
	  
	  extract( $args );
 
		// Widget starts to print information
		echo $before_widget;
		 
		$title = apply_filters( 'widget_title', $instance[ 'title' ] );	 
		$random = $instance[ 'random' ] ? true : false;
		if ( $random ) {
			$agent = get_users( array( 'role' => 'agent', 'fields' => 'ID' ) );
			shuffle( $agent );
			$agent = $agent[0];
		}
		else {
			$agent = empty( $instance[ 'agent' ] ) ? '1' : $instance[ 'agent' ];
		}
		 
		if ( !empty( $title ) ) { 
			echo $before_title . $title . $after_title; 
		};
		
		$company_name = get_user_meta( $agent, 'company_name', true );
		$first_name = get_user_meta( $agent, 'first_name', true );
		$last_name = get_user_meta( $agent, 'last_name', true );
		$email = get_userdata( $agent );
		$email = $email->user_email;
		$office = get_user_meta( $agent, 'office_phone_number', true );
		$mobile = get_user_meta( $agent, 'mobile_phone_number', true );
		$fax = get_user_meta( $agent, 'fax_number', true );
		$website = get_userdata( $agent );
		$website = $website->user_url;
		$website_clean = str_replace( array( 'http://', 'https://' ), '', $website );
		$bio = get_user_meta( $agent, 'description', true );
		$profile_image = get_user_meta( $agent, 'user_image', true );
		$author_profile_url = get_author_posts_url( $agent );
		
		$facebook = get_user_meta( $agent, 'custom_facebook', true );
		$twitter = get_user_meta( $agent, 'custom_twitter', true );
		$google = get_user_meta( $agent, 'custom_google', true );
		$linkedin = get_user_meta( $agent, 'custom_linkedin', true );
		global $realty_theme_option;
		if ( $facebook || $twitter || $google || $linkedin ) {
			$no_socials = false;
		}
		else {
			$no_socials = true;
		}
		?>
		<div class="widget-container">
			<div class="widget-thumbnail">
				<a href="<?php echo $author_profile_url; ?>">
					<?php 
					if ( $profile_image ) {
						$profile_image_id = tt_get_image_id( $profile_image );
						$profile_image_array = wp_get_attachment_image_src( $profile_image_id, 'thumbnail-400-300' );
						echo '<img src="' . $profile_image_array[0] . '" alt="" />';
					}
					else {
						echo '<img src="//placehold.it/400x300/eee/ccc/&text=.." alt="" />';
					} 
					?>
				</a>
			</div>
			<div class="widget-text">
				<div class="agent-details<?php if ( $no_socials ) { echo " no-details"; } ?>">
					<h4 class="title"><?php echo $first_name . ' ' .$last_name; ?></h4>
					<?php if ( $email && $realty_theme_option['show-agent-email'] ) { ?><div class="contact"><i class="fa fa-envelope-o"></i><a href="mailto:<?php echo antispambot( $email ); ?>"><?php echo antispambot( $email ); ?></a></div><?php } ?>
					<?php if ( $office && $realty_theme_option['show-agent-office'] ) { ?><div class="contact"><i class="fa fa-phone"></i><?php echo $office; ?></div><?php } ?>
					<?php if ( $mobile && $realty_theme_option['show-agent-mobile'] ) { ?><div class="contact"><i class="fa fa-mobile"></i><?php echo $mobile; ?></div><?php } ?>
				</div>
			</div>
		</div>
		<?php		
		// Widget ends printing information
		echo $after_widget;
	  
  }
	
	

}