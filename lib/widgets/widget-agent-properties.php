<?php
// Credits: http://buffercode.com/simple-method-create-custom-wordpress-widget-admin-dashboard/
// REGISTER WIDGET
function widget_agent_properties() {
	register_widget( 'widget_agent_properties' );
}
add_action( 'widgets_init', 'widget_agent_properties' );

class widget_agent_properties extends WP_Widget {

	// CONSTRUCT WIDGET
	function widget_agent_properties() {
		$widget_ops = array( 
			'classname' 	=> 'widget_agent_properties', 
			'description' => __( 'Agent More Properties', 'tt' ),
			'panels_icon' => 'icon-themetrail',
		);
		parent::__construct( 'widget_agent_properties', __( 'Realty - Agent Properties', 'tt' ), $widget_ops );
	}
	
	// CREATE WIDGET FORM (WORDPRESS DASHBOARD)
  function form($instance) {
  
	  if ( isset( $instance[ 'title' ] ) && isset ( $instance[ 'amount' ] ) ) {
			$title = $instance[ 'title' ];
			$amount = $instance[ 'amount' ];
			$random = $instance[ 'random' ];
		} else {
			$title = __( 'Agent More Properties', 'tt' );
			$amount = -1;
			$random = false;
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
			<label for="<?php echo $this->get_field_id( 'amount' ); ?>"><?php _e( 'Number of Properties to Display:', 'tt' ); ?></label> 
			<input name="<?php echo $this->get_field_name( 'amount' ); ?>" type="number" min="-1" value="<?php echo esc_attr( $amount );?>" class="widefat" />
			<small><?php _e( 'Enter "-1" to show all', 'tt' ); ?></small>
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
		 
		$title = apply_filters( 'widget_title', $instance[ 'title' ] );	 
		$amount = empty( $instance[ 'amount' ] ) ? '3' : $instance[ 'amount' ];
		$amount = intval( $amount );
		$random = $instance[ 'random' ] ? true : false;
		 
		if ( ! empty( $title ) ) { 
			echo $before_title . $title . $after_title; 
		}
		
		global $post;
		$agent = get_post_meta( $post->ID, 'estate_property_custom_agent', true );

		if ( ! $agent ) {
			$agent_author = $post->post_author;
			$args_agent_properties = array(
				'post_type' 				=> 'property',
				'posts_per_page' 		=> $amount,
				'author'						=> $agent_author,
			);
		} else {
			$args_agent_properties = array(
				'post_type' 				=> 'property',
				'posts_per_page' 		=> $amount,
				'meta_query' 				=> array(
					array(
						'key' 		=> 'estate_property_custom_agent',
						'value' 	=> $agent,
						'compare'	=> '='
					)
				)
			);
		}
		
		// Order By:
		if ( $random ) {
			$args_agent_properties[ 'orderby' ] = 'rand';
		}
		
		$query_agent = new WP_Query( $args_agent_properties );
		if ( $query_agent->have_posts() ) :
		?>
		<div class="owl-carousel-1-nav widget-agent-properties">
			<?php
			while ( $query_agent->have_posts() ) : $query_agent->the_post();
			global $post;
			?>
			<div class="widget-container">
				<a href="<?php the_permalink(); ?>">
					<div class="widget-thumbnail">
						<?php 
						if ( has_post_thumbnail() ) { 
							the_post_thumbnail( 'thumbnail-400-300' );
						}	
						else {
							echo '<img src ="//placehold.it/400x300/eee/ccc/&text=.." />';
						}
						?>
					</div>
					
					<div class="widget-text">
						<?php the_title( '<h5 class="title">', '</h5>' ); ?>
						<div class="property-price"><?php echo tt_property_price(); ?></div>
					</div>
				</a>
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