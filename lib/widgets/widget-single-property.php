<?php
// Credits: http://buffercode.com/simple-method-create-custom-wordpress-widget-admin-dashboard/
// REGISTER WIDGET
function widget_single_property() {
	register_widget( 'widget_single_property' );
}
add_action( 'widgets_init', 'widget_single_property' );

class widget_single_property extends WP_Widget {

	// CONSTRUCT WIDGET
	function widget_single_property() {
		$widget_ops = array( 
			'classname' 	=> 'widget_single_property', 
			'description' => __( 'Single Property', 'tt' ),
			'panels_icon' => 'icon-themetrail',
		);
		parent::__construct( 'widget_single_property', __( 'Realty - Single Property', 'tt' ), $widget_ops );
	}
	
	// CREATE WIDGET FORM (WORDPRESS DASHBOARD)
  function form($instance) {
  
	  if ( isset( $instance[ 'title' ] ) && isset ( $instance[ 'id' ] ) ) {
			$title = $instance[ 'title' ];
			$id = $instance[ 'id' ];
		}
		else {
			$title = __( 'Single Property', 'tt' );
			$id = __( '1', 'tt' );
		}
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tt' ); ?></label> 
			<input name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title );?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php _e( 'Property:', 'tt' ); ?></label> 
			<select name="<?php echo $this->get_field_name( 'id' ); ?>" id="<?php echo $this->get_field_id( 'id' ); ?>" class="widefat">
				<?php 
				$query_property_ids_args = array( 
					'post_type' 			=> 'property',
					'post_status' 		=> 'publish',
					'posts_per_page' 	=> -1
				);
				
				$query_property_ids = new WP_Query( $query_property_ids_args );
				while ( $query_property_ids->have_posts() ) : $query_property_ids->the_post();
				?>
				<option value="<?php the_ID(); ?>" <?php selected( $id, get_the_ID() ); ?>><?php echo get_the_title(); ?></option>
				<?php
				endwhile;
				?>
			</select>
		</p>
		 
		<?php
		
  }

  // UPDATE WIDGET
  function update( $new_instance, $old_instance ) {
  	  
	  $instance = $old_instance;
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';		 
		$instance['id'] = ( ! empty( $new_instance['id'] ) ) ? strip_tags( $new_instance['id'] ) : '';		 		  		 
		
		return $instance;
	  
  }

  // DISPLAY WIDGET ON FRONT END
  function widget( $args, $instance ) {
	  
	  extract( $args );
 
		// Widget starts to print information
		echo $before_widget;
		 
		$title = apply_filters( 'widget_title', $instance[ 'title' ] );	 
		$id = empty( $instance[ 'id' ] ) ? '1' : $instance[ 'id' ];
		$id = intval( $id );
		 
		if ( ! empty( $title ) ) { 
			echo $before_title . $title . $after_title; 
		}

		// Query Single Property
		$query_single_property_args = array(
			'post_type' 			=> 'property',
			'posts_per_page' 	=> 1,
			'page_id' 				=> $id
		);
		
		$query_single_property = new WP_Query( $query_single_property_args );
		
		if ( $query_single_property->have_posts() ) : while ( $query_single_property->have_posts() ) : $query_single_property->the_post();
			get_template_part( 'lib/inc/template/property-item' );
		endwhile;
		wp_reset_query();
		endif;
		
		// Widget ends printing information
		echo $after_widget;
	  
  }
	
}