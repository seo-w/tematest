<?php
// Credits: http://buffercode.com/simple-method-create-custom-wordpress-widget-admin-dashboard/
// REGISTER WIDGET
function widget_testimonials() {
	register_widget( 'widget_testimonials' );
}
add_action( 'widgets_init', 'widget_testimonials' );

class widget_testimonials extends WP_Widget {

	// CONSTRUCT WIDGET
	function widget_testimonials() {
		$widget_ops = array( 
			'classname' 	=> 'widget_testimonials', 
			'description' => __( 'Testimonials', 'tt' ),
			'panels_icon' => 'icon-themetrail',
		);
		parent::__construct( 'widget_testimonials', __( 'Realty - Testimonials', 'tt' ), $widget_ops );
	}
	
	// CREATE WIDGET FORM (WORDPRESS DASHBOARD)
  function form($instance) {
  
	  if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'Testimonials', 'tt' );
		}
		
		if ( isset ( $instance[ 'amount' ] ) ) {
			$amount = $instance[ 'amount' ];
		} else {
			$amount = -1;
		}
		
		if ( isset ( $instance[ 'random' ] ) ) {
			$random = $instance[ 'random' ];
		} else {
			$random = false;
		}
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tt' ); ?></label> 
			<input name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title );?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'amount' ); ?>"><?php _e( 'Total Number of Testimonial to Display:', 'tt' ); ?></label> 
			<input name="<?php echo $this->get_field_name( 'amount' ); ?>" type="number" min="-1" value="<?php echo esc_attr( $amount );?>" class="widefat" />
		</p>
		
		<p>
			<input name="<?php echo $this->get_field_name( 'random' ); ?>" type="checkbox" <?php checked( $random, 'on' ); ?> />
			<label for="<?php echo $this->get_field_id( 'random' ); ?>"><?php _e( 'Instead of Newest First, Order Randomly', 'tt' ); ?></label> 
		</p>
		 
		<?php
		
  }

  // UPDATE WIDGET
  function update( $new_instance, $old_instance ) {
  	  
	  $instance = $old_instance;
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';		 
		$instance['amount'] = ( ! empty( $new_instance['amount'] ) ) ? strip_tags( $new_instance['amount'] ) : '';		 		 
		$instance['random'] = ( ! empty( $new_instance['random'] ) ) ? strip_tags( $new_instance['random'] ) : '';		 		 
		
		return $instance;
	  
  }

  // DISPLAY WIDGET ON FRONT END
  function widget( $args, $instance ) {
	  
	  extract( $args );
 
		// Widget starts to print information
		echo $before_widget;
		 
		$title = apply_filters( 'widget_title', $instance['title'] );	 
		$amount = empty( $instance[ 'amount' ] ) ? -1 : $instance['amount'];
		$amount = intval( $amount );
		$random = $instance['random'] ? true : false;
		 
		if ( !empty( $title ) ) { 
			echo $before_title . $title . $after_title; 
		};

		// Query Featured Properties
		$args_testimonials = array(
			'post_type' 				=> 'testimonial',
			'posts_per_page' 		=> $amount
		);
		
		// Order By:
		if ( $random ) {
			$args_testimonials[ 'orderby' ] = 'rand';
		}
		
		$query_testimonials = new WP_Query( $args_testimonials );
		
		if ( $query_testimonials->have_posts() ) :
		?>
		<div class="owl-carousel-1-nav">
			<?php
			while ( $query_testimonials->have_posts() ) : $query_testimonials->the_post();
			global $post;
			$testimonial = get_post_meta( $post->ID, 'estate_testimonial_text', true ); 
			?>
			<div class="widget-container">
				<div class="property-thumbnail"><?php the_post_thumbnail( 'thumbnail-400-300' ); ?></div>			
				<div class="widget-text">
					<blockquote>
						<p><?php	echo $testimonial; ?></p>
						<?php the_title( '<cite>', '</cite>' ); ?>
					</blockquote>
				</div>
			</div>
			<?php
			endwhile;
			?>
		</div>
		<?php
		wp_reset_query();
		endif;
		
		// Widget ends printing information
		echo $after_widget;
	  
  }

}