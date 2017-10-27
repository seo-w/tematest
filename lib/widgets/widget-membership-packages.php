<?php
// Credits: http://buffercode.com/simple-method-create-custom-wordpress-widget-admin-dashboard/
// REGISTER WIDGET
function widget_membership_packages() {
	register_widget( 'widget_membership_packages' );
}
add_action( 'widgets_init', 'widget_membership_packages' );

class widget_membership_packages extends WP_Widget {

	// CONSTRUCT WIDGET
	function widget_membership_packages() {
		$widget_ops = array( 
			'classname' 	=> 'widget_membership_packages', 
			'description' => __( 'Membership Packages', 'tt' ),
			'panels_icon' => 'icon-themetrail',
		);
		parent::__construct( 'widget_membership_packages', __( 'Realty - Membership Packages', 'tt' ), $widget_ops );
	}
	
	// CREATE WIDGET FORM (WORDPRESS DASHBOARD)
  function form($instance) {
  
	  if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'Membership Packages', 'tt' );
		}
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tt' ); ?></label> 
			<input name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title );?>" class="widefat" />
		</p>
				 
		<?php
  }

  // UPDATE WIDGET
  function update( $new_instance, $old_instance ) {
  	  
	  $instance = $old_instance;
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';		 
		
		return $instance;
	  
  }

  // DISPLAY WIDGET ON FRONT END
  function widget( $args, $instance ) {
	  
	  extract( $args );
 
		// Widget starts to print information
		echo $before_widget;
		 
		$title = apply_filters( 'widget_title', $instance[ 'title' ] );	 

		if ( ! empty( $title ) ) { 
			echo $before_title . $title . $after_title; 
		}
		
		echo do_shortcode( '[membership_packages]' );
		
		// Widget ends printing information
		echo $after_widget;
	  
  }
}