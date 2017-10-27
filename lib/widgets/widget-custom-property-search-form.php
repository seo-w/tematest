<?php
// Credits: http://buffercode.com/simple-method-create-custom-wordpress-widget-admin-dashboard/
// REGISTER WIDGET
function widget_custom_property_search_form() {
	register_widget( 'widget_custom_property_search_form' );
}
add_action( 'widgets_init', 'widget_custom_property_search_form' );

class widget_custom_property_search_form extends WP_Widget {

	// CONSTRUCT WIDGET
	function widget_custom_property_search_form() {
		$widget_ops = array( 
			'classname' 	=> 'widget_custom_property_search_form', 
			'description' => __( 'Custom Property Search', 'tt' ),
			'panels_icon' => 'icon-themetrail',
		);
		parent::__construct( 'widget_custom_property_search_form', __( 'Realty - Custom Property Search', 'tt' ), $widget_ops );
	}
	
	// CREATE WIDGET FORM (WORDPRESS DASHBOARD)
  function form($instance) {
  
	  if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'Custom Property Search', 'tt' );
		}
		
		if ( isset( $instance['show_location'] ) ) {
			$show_location = $instance['show_location'];
		} else {
			$show_location = false;
		}
		
		if ( isset( $instance['label_location'] ) ) {
			$label_location = $instance['label_location'];
		} else {
			$label_location = __( 'Any Location', 'tt' );
		}
		
		if ( isset( $instance['show_status'] ) ) {
			$show_status = $instance['show_status'];
		} else {
			$show_status = false;
		}
	
		if ( isset( $instance['label_status'] ) ) {
			$label_status = $instance['label_status'];
		} else {
			$label_status = __( 'Any Status', 'tt' );
		}
		
		if ( isset( $instance['show_type'] ) ) {
			$show_type = $instance['show_type'];
		} else {
			$show_type = false;
		}
		
		if ( isset( $instance['label_type'] ) ) {
			$label_type = $instance['label_type'];
		} else {
			$label_type = __( 'Any Type', 'tt' );
		}
		
		if ( isset( $instance['show_features'] ) ) {
			$show_features = $instance['show_features'];
		} else {
			$show_features = false;
		}
		
		if ( isset( $instance['label_features'] ) ) {
			$label_features = $instance['label_features'];
		} else {
			$label_features = __( 'Show more search options', 'tt' );
		}
		
		if ( isset( $instance['show_id'] ) ) {
			$show_id = $instance['show_id'];
		} else {
			$show_id = false;
		}
		
		if ( isset( $instance['label_id'] ) ) {
			$label_id = $instance['label_id'];
		} else {
			$label_id = __( 'ID', 'tt' );
		}
		
		if ( isset( $instance['show_price'] ) ) {
			$show_price = $instance['show_price'];
		} else {
			$show_price = false;
		}
		
		if ( isset( $instance['label_price'] ) ) {
			$label_price = $instance['label_price'];
		} else {
			$label_price = __( 'Price', 'tt' );
		}
		
		if ( isset( $instance['show_size'] ) ) {
			$show_size = $instance['show_size'];
		} else {
			$show_size = false;
		}
		
		if ( isset( $instance['label_size'] ) ) {
			$label_size = $instance['label_size'];
		} else {
			$label_size = __( 'Size', 'tt' );
		}
		
		if ( isset( $instance['show_rooms'] ) ) {
			$show_rooms = $instance['show_rooms'];
		} else {
			$show_rooms = false;
		}
		
		if ( isset( $instance['label_rooms'] ) ) {
			$label_rooms = $instance['label_rooms'];
		} else {
			$label_rooms = __( 'Rooms', 'tt' );
		}
		
		if ( isset( $instance['show_bedrooms'] ) ) {
			$show_bedrooms = $instance['show_bedrooms'];
		} else {
			$show_bedrooms = false;
		}
		
		if ( isset( $instance['label_bedrooms'] ) ) {
			$label_bedrooms = $instance['label_bedrooms'];
		} else {
			$label_bedrooms = __( 'Bedrooms', 'tt' );
		}
		
		if ( isset( $instance['show_bathrooms'] ) ) {
			$show_bathrooms = $instance['show_bathrooms'];
		} else {
			$show_bathrooms = false;
		}
		
		if ( isset( $instance['label_bathrooms'] ) ) {
			$label_bathrooms = $instance['label_bathrooms'];
		} else {
			$label_bathrooms = __( 'Bathrooms', 'tt' );
		}
		
		if ( isset( $instance['show_garages'] ) ) {
			$show_garages = $instance['show_garages'];
		} else {
			$show_garages = false;
		}
		
		if ( isset( $instance['label_garages'] ) ) {
			$label_garages = $instance['label_garages'];
		} else {
			$label_garages = __( 'Garages', 'tt' );
		}
		
		if ( isset( $instance['show_keyword'] ) ) {
			$show_keyword = $instance['show_keyword'];
		} else {
			$show_keyword = false;
		}
		
		if ( isset( $instance['label_keyword'] ) ) {
			$label_keyword = $instance['label_keyword'];
		} else {
			$label_keyword = __( 'Keyword', 'tt' );
		}
		
		if ( isset( $instance['show_available_from'] ) ) {
			$show_available_from = $instance['show_available_from'];
		} else {
			$show_available_from = false;
		}
		
		if ( isset( $instance['label_available_from'] ) ) {
			$label_available_from = $instance['label_available_from'];
		} else {
			$label_available_from = __( 'Available From', 'tt' );
		}
		
		if ( isset( $instance['show_minprice'] ) ) {
			$show_minprice = $instance['show_minprice'];
		} else {
			$show_minprice = false;
		}
		
		if ( isset( $instance['label_minprice'] ) ) {
			$label_minprice = $instance['label_minprice'];
		} else {
			$label_minprice = __( 'Min. Price', 'tt' );
		}
		
		if ( isset( $instance['show_maxprice'] ) ) {
			$show_maxprice = $instance['show_maxprice'];
		} else {
			$show_maxprice = false;
		}
		
		if ( isset( $instance['label_maxprice'] ) ) {
			$label_maxprice = $instance['label_maxprice'];
		} else {
			$label_maxprice = __( 'Max. Price', 'tt' );
		}
		
		if ( isset( $instance['show_pricerange'] ) ) {
			$show_pricerange = $instance['show_pricerange'];
		} else {
			$show_pricerange = false;
		}
		
		if ( isset( $instance['label_pricerange'] ) ) {
			$label_pricerange = $instance['label_pricerange'];
		} else {
			$label_pricerange = __( 'From', 'tt' );
		}
		?>
		
		<style>
		.hide {
			display: none;
		}
		</style>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tt' ); ?></label> 
			<input name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title );?>" class="widefat" />
		</p>
		
		<p>
			<input name="<?php echo $this->get_field_name( 'show_location' ); ?>" type="checkbox" <?php checked( $show_location, 'on' ); ?> />
			<label for="<?php echo $this->get_field_name( 'show_location' ); ?>"><?php echo __( 'Show', 'tt' ) . ' ' . __( 'Location', 'tt' ); ?></label>
		</p>
		<p class="hide">
			<input name="<?php echo $this->get_field_name( 'label_location' ); ?>" type="text" value="<?php echo esc_attr( $label_location );?>" placeholder="<?php echo __( 'Label:', 'tt' ) . ' ' . __( 'Any Location', 'tt' ); ?>" class="widefat" />
		</p>
		
		<p>
			<input name="<?php echo $this->get_field_name( 'show_status' ); ?>" type="checkbox" <?php checked( $show_status, 'on' ); ?> />
			<label for="<?php echo $this->get_field_name( 'show_status' ); ?>"><?php echo __( 'Show', 'tt' ) . ' ' . __( 'Status', 'tt' ); ?></label>
		</p>
		<p class="hide">
			<input name="<?php echo $this->get_field_name( 'label_status' ); ?>" type="text" value="<?php echo esc_attr( $label_status );?>" placeholder="<?php echo __( 'Label:', 'tt' ) . ' ' . __( 'Any Status', 'tt' ); ?>" class="widefat" />
		</p>
		
		<p>
			<input name="<?php echo $this->get_field_name( 'show_type' ); ?>" type="checkbox" <?php checked( $show_type, 'on' ); ?> />			
			<label for="<?php echo $this->get_field_name( 'show_type' ); ?>"><?php echo __( 'Show', 'tt' ) . ' ' . __( 'Type', 'tt' ); ?></label>
		</p>
		<p class="hide">
			<input name="<?php echo $this->get_field_name( 'label_type' ); ?>" type="text" value="<?php echo esc_attr( $label_type );?>" placeholder="<?php echo __( 'Label:', 'tt' ) . ' ' . __( 'Any Type', 'tt' ); ?>" class="widefat" />
		</p>
		
		<p class="hide">
			<input name="<?php echo $this->get_field_name( 'show_features' ); ?>" type="checkbox" <?php checked( $show_features, 'on' ); ?> />			
			<label for="<?php echo $this->get_field_name( 'show_features' ); ?>"><?php echo __( 'Show', 'tt' ) . ' ' . __( 'Features', 'tt' ); ?></label>
		</p>
		<p class="hide">
			<input name="<?php echo $this->get_field_name( 'label_features' ); ?>" type="text" value="<?php echo esc_attr( $label_features );?>" placeholder="<?php echo __( 'Label:', 'tt' ) . ' ' . __( 'Show more search options', 'tt' ); ?>" class="widefat" />
		</p>
				
		<p>
			<input name="<?php echo $this->get_field_name( 'show_id' ); ?>" type="checkbox" <?php checked( $show_id, 'on' ); ?> />			
			<label for="<?php echo $this->get_field_name( 'show_id' ); ?>"><?php echo __( 'Show', 'tt' ) . ' ' . __( 'ID', 'tt' ); ?></label>
		</p>
		<p>
			<input name="<?php echo $this->get_field_name( 'label_id' ); ?>" type="text" value="<?php echo esc_attr( $label_id );?>" placeholder="<?php echo __( 'Label:', 'tt' ) . ' ' . __( 'ID', 'tt' ); ?>" class="widefat" />
		</p>
		
		<p>
			<input name="<?php echo $this->get_field_name( 'show_price' ); ?>" type="checkbox" <?php checked( $show_price, 'on' ); ?> />			
			<label for="<?php echo $this->get_field_name( 'show_price' ); ?>"><?php echo __( 'Show', 'tt' ) . ' ' . __( 'Price', 'tt' ); ?></label>
		</p>
		<p>
			<input name="<?php echo $this->get_field_name( 'label_price' ); ?>" type="text" value="<?php echo esc_attr( $label_price );?>" placeholder="<?php echo __( 'Label:', 'tt' ) . ' ' . __( 'Price', 'tt' ); ?>" class="widefat" />
		</p>
		
		<p>
			<input name="<?php echo $this->get_field_name( 'show_size' ); ?>" type="checkbox" <?php checked( $show_size, 'on' ); ?> />			
			<label for="<?php echo $this->get_field_name( 'show_size' ); ?>"><?php echo __( 'Show', 'tt' ) . ' ' . __( 'Size', 'tt' ); ?></label>
		</p>
		<p>
			<input name="<?php echo $this->get_field_name( 'label_size' ); ?>" type="text" value="<?php echo esc_attr( $label_size );?>" placeholder="<?php echo __( 'Label:', 'tt' ) . ' ' . __( 'Size', 'tt' ); ?>" class="widefat" />
		</p>
		
		<p>
			<input name="<?php echo $this->get_field_name( 'show_rooms' ); ?>" type="checkbox" <?php checked( $show_rooms, 'on' ); ?> />			
			<label for="<?php echo $this->get_field_name( 'show_rooms' ); ?>"><?php echo __( 'Show', 'tt' ) . ' ' . __( 'Rooms', 'tt' ); ?></label>
		</p>
		<p>
			<input name="<?php echo $this->get_field_name( 'label_rooms' ); ?>" type="text" value="<?php echo esc_attr( $label_rooms );?>" placeholder="<?php echo __( 'Label:', 'tt' ) . ' ' . __( 'Rooms', 'tt' ); ?>" class="widefat" />
		</p>
		
		<p>
			<input name="<?php echo $this->get_field_name( 'show_bedrooms' ); ?>" type="checkbox" <?php checked( $show_bedrooms, 'on' ); ?> />			
			<label for="<?php echo $this->get_field_name( 'show_bedrooms' ); ?>"><?php echo __( 'Show', 'tt' ) . ' ' . __( 'Bedrooms', 'tt' ); ?></label>
		</p>
		<p>
			<input name="<?php echo $this->get_field_name( 'label_bedrooms' ); ?>" type="text" value="<?php echo esc_attr( $label_bedrooms );?>" placeholder="<?php echo __( 'Label:', 'tt' ) . ' ' . __( 'Bedrooms', 'tt' ); ?>" class="widefat" />
		</p>
		
		<p>
			<input name="<?php echo $this->get_field_name( 'show_bathrooms' ); ?>" type="checkbox" <?php checked( $show_bathrooms, 'on' ); ?> />			
			<label for="<?php echo $this->get_field_name( 'show_bathrooms' ); ?>"><?php echo __( 'Show', 'tt' ) . ' ' . __( 'Bathrooms', 'tt' ); ?></label>
		</p>
		<p>
			<input name="<?php echo $this->get_field_name( 'label_bathrooms' ); ?>" type="text" value="<?php echo esc_attr( $label_bathrooms );?>" placeholder="<?php echo __( 'Label:', 'tt' ) . ' ' . __( 'Bathrooms', 'tt' ); ?>" class="widefat" />
		</p>
		
		<p>
			<input name="<?php echo $this->get_field_name( 'show_garages' ); ?>" type="checkbox" <?php checked( $show_garages, 'on' ); ?> />			
			<label for="<?php echo $this->get_field_name( 'show_garages' ); ?>"><?php echo __( 'Show', 'tt' ) . ' ' . __( 'Garages', 'tt' ); ?></label>
		</p>
		<p>
			<input name="<?php echo $this->get_field_name( 'label_garages' ); ?>" type="text" value="<?php echo esc_attr( $label_garages );?>" placeholder="<?php echo __( 'Label:', 'tt' ) . ' ' . __( 'Garages', 'tt' ); ?>" class="widefat" />
		</p>
		
		<p>
			<input name="<?php echo $this->get_field_name( 'show_keyword' ); ?>" type="checkbox" <?php checked( $show_keyword, 'on' ); ?> />			
			<label for="<?php echo $this->get_field_name( 'show_keyword' ); ?>"><?php echo __( 'Show', 'tt' ) . ' ' . __( 'Keyword', 'tt' ); ?></label>
		</p>
		<p>
			<input name="<?php echo $this->get_field_name( 'label_keyword' ); ?>" type="text" value="<?php echo esc_attr( $label_keyword );?>" placeholder="<?php echo __( 'Label:', 'tt' ) . ' ' . __( 'Keyword', 'tt' ); ?>" class="widefat" />
		</p>
		
		<p>
			<input name="<?php echo $this->get_field_name( 'show_available_from' ); ?>" type="checkbox" <?php checked( $show_available_from, 'on' ); ?> />			
			<label for="<?php echo $this->get_field_name( 'show_available_from' ); ?>"><?php echo __( 'Show', 'tt' ) . ' ' . __( 'Available From', 'tt' ); ?></label>
		</p>
		<p>
			<input name="<?php echo $this->get_field_name( 'label_available_from' ); ?>" type="text" value="<?php echo esc_attr( $label_available_from );?>" placeholder="<?php echo __( 'Label:', 'tt' ) . ' ' . __( 'Available From', 'tt' ); ?>" class="widefat" />
		</p>
		
		<p>
			<input name="<?php echo $this->get_field_name( 'show_minprice' ); ?>" type="checkbox" <?php checked( $show_minprice, 'on' ); ?> />			
			<label for="<?php echo $this->get_field_name( 'show_minprice' ); ?>"><?php echo __( 'Show', 'tt' ) . ' ' . __( 'Min. Price', 'tt' ); ?></label>
		</p>
		<p>
			<input name="<?php echo $this->get_field_name( 'label_minprice' ); ?>" type="text" value="<?php echo esc_attr( $label_minprice );?>" placeholder="<?php echo __( 'Label:', 'tt' ) . ' ' . __( 'Min. Price', 'tt' ); ?>" class="widefat" />
		</p>
		
		<p>
			<input name="<?php echo $this->get_field_name( 'show_maxprice' ); ?>" type="checkbox" <?php checked( $show_maxprice, 'on' ); ?> />			
			<label for="<?php echo $this->get_field_name( 'show_maxprice' ); ?>"><?php echo __( 'Show', 'tt' ) . ' ' . __( 'Max. Price', 'tt' ); ?></label>
		</p>
		<p>
			<input name="<?php echo $this->get_field_name( 'label_maxprice' ); ?>" type="text" value="<?php echo esc_attr( $label_maxprice );?>" placeholder="<?php echo __( 'Label:', 'tt' ) . ' ' . __( 'Max. Price', 'tt' ); ?>" class="widefat" />
		</p>
		
		<p>
			<input name="<?php echo $this->get_field_name( 'show_pricerange' ); ?>" type="checkbox" <?php checked( $show_pricerange, 'on' ); ?> />			
			<label for="<?php echo $this->get_field_name( 'show_pricerange' ); ?>"><?php echo __( 'Show', 'tt' ) . ' ' . __( 'Price Range', 'tt' ); ?></label>
		</p>
		<p>
			<input name="<?php echo $this->get_field_name( 'label_pricerange' ); ?>" type="text" value="<?php echo esc_attr( $label_pricerange );?>" placeholder="<?php echo __( 'Label:', 'tt' ) . ' ' . __( 'Price Range', 'tt' ); ?>" class="widefat" />
		</p>
		 
		<?php
		
  }

  // UPDATE WIDGET
  function update( $new_instance, $old_instance ) {
  	  
	  $instance = $old_instance;
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		
		$instance['show_location'] = ( ! empty( $new_instance['show_location'] ) ) ? $new_instance['show_location'] : '';
		$instance['label_location'] = ( ! empty( $new_instance['label_location'] ) ) ? strip_tags( $new_instance['label_location'] ) : __( 'Location', 'tt' );
		
		$instance['show_status'] = ( isset( $new_instance['show_status'] ) ) ? $new_instance['show_status'] : '';
		$instance['label_status'] = ( ! empty( $new_instance['label_status'] ) ) ? strip_tags( $new_instance['label_status'] ) : __( 'Status', 'tt' );
		
		$instance['show_type'] = ( isset( $new_instance['show_type'] ) ) ? $new_instance['show_type'] : '';
		$instance['label_type'] = ( ! empty( $new_instance['label_type'] ) ) ? strip_tags( $new_instance['label_type'] ) : __( 'Type', 'tt' );
		
		//$instance['show_features'] = ( isset( $new_instance['show_features'] ) ) ? $new_instance['show_features'] : '';
		//$instance['label_features'] = ( ! empty( $new_instance['label_features'] ) ) ? strip_tags( $new_instance['label_features'] ) : __( 'Show more search options', 'tt' );
		
		$instance['show_id'] = ( isset( $new_instance['show_id'] ) ) ? $new_instance['show_id'] : '';
		$instance['label_id'] = ( ! empty( $new_instance['label_id'] ) ) ? strip_tags( $new_instance['label_id'] ) : __( 'Property ID', 'tt' );
		
		$instance['show_price'] = ( isset( $new_instance['show_price'] ) ) ? $new_instance['show_price'] : '';
		$instance['label_price'] = ( ! empty( $new_instance['label_price'] ) ) ? strip_tags( $new_instance['label_price'] ) : __( 'Price', 'tt' );
		
		$instance['show_size'] = ( isset( $new_instance['show_size'] ) ) ? $new_instance['show_size'] : '';
		$instance['label_size'] = ( ! empty( $new_instance['label_size'] ) ) ? strip_tags( $new_instance['label_size'] ) : __( 'Size', 'tt' );
		
		$instance['show_rooms'] = ( isset( $new_instance['show_rooms'] ) ) ? $new_instance['show_rooms'] : '';
		$instance['label_rooms'] = ( ! empty( $new_instance['label_rooms'] ) ) ? strip_tags( $new_instance['label_rooms'] ) : __( 'Rooms', 'tt' );
		
		$instance['show_bedrooms'] = ( isset( $new_instance['show_bedrooms'] ) ) ? $new_instance['show_bedrooms'] : '';
		$instance['label_bedrooms'] = ( ! empty( $new_instance['label_bedrooms'] ) ) ? strip_tags( $new_instance['label_bedrooms'] ) : __( 'Bedrooms', 'tt' );
		
		$instance['show_bathrooms'] = ( isset( $new_instance['show_bathrooms'] ) ) ? $new_instance['show_bathrooms'] : '';
		$instance['label_bathrooms'] = ( ! empty( $new_instance['label_bathrooms'] ) ) ? strip_tags( $new_instance['label_bathrooms'] ) : __( 'Bathrooms', 'tt' );
		
		$instance['show_garages'] = ( isset( $new_instance['show_garages'] ) ) ? $new_instance['show_garages'] : '';
		$instance['label_garages'] = ( ! empty( $new_instance['label_garages'] ) ) ? strip_tags( $new_instance['label_garages'] ) : __( 'Garages', 'tt' );
		
		$instance['show_keyword'] = ( isset( $new_instance['show_keyword'] ) ) ? $new_instance['show_keyword'] : '';
		$instance['label_keyword'] = ( ! empty( $new_instance['label_keyword'] ) ) ? strip_tags( $new_instance['label_keyword'] ) : __( 'Keyword', 'tt' );
		
		$instance['show_available_from'] = ( isset( $new_instance['show_available_from'] ) ) ? $new_instance['show_available_from'] : '';
		$instance['label_available_from'] = ( ! empty( $new_instance['label_available_from'] ) ) ? strip_tags( $new_instance['label_available_from'] ) : __( 'Available From', 'tt' );
		
		$instance['show_minprice'] = ( isset( $new_instance['show_minprice'] ) ) ? $new_instance['show_minprice'] : '';
		$instance['label_minprice'] = ( ! empty( $new_instance['label_minprice'] ) ) ? strip_tags( $new_instance['label_minprice'] ) : __( 'Min. Price', 'tt' );
		
		$instance['show_maxprice'] = ( isset( $new_instance['show_maxprice'] ) ) ? $new_instance['show_maxprice'] : '';
		$instance['label_maxprice'] = ( ! empty( $new_instance['label_maxprice'] ) ) ? strip_tags( $new_instance['label_maxprice'] ) : __( 'Max. Price', 'tt' );
		
		$instance['show_pricerange'] = ( isset( $new_instance['show_pricerange'] ) ) ? $new_instance['show_pricerange'] : '';
		$instance['label_pricerange'] = ( ! empty( $new_instance['label_pricerange'] ) ) ? strip_tags( $new_instance['label_pricerange'] ) : __( 'From', 'tt' );
		
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
		};
		
		// Parameters
		$parameters = array();
		
		$parameters[] = $instance[ 'show_location' ] ? 'location="' . $instance['label_location'] . '"' : '';
		$parameters[] = $instance[ 'show_status' ] ? 'status="' . $instance['label_status'] . '"' : '';
		$parameters[] = $instance[ 'show_type' ] ? 'type="' . $instance['label_type'] . '"' : '';
		//$parameters[] = $instance[ 'show_features' ] ? 'features="' . $instance['label_features'] . '"' : '';
		$parameters[] = $instance[ 'show_id' ] ? 'id="' . $instance['label_id'] . '"' : '';
		$parameters[] = $instance[ 'show_price' ] ? 'price="' . $instance['label_price'] . '"' : '';
		$parameters[] = $instance[ 'show_size' ] ? 'size="' . $instance['label_size'] . '"' : '';
		$parameters[] = $instance[ 'show_rooms' ] ? 'rooms="' . $instance['label_rooms'] . '"' : '';
		$parameters[] = $instance[ 'show_bedrooms' ] ? 'bedrooms="' . $instance['label_bedrooms'] . '"' : '';
		$parameters[] = $instance[ 'show_bathrooms' ] ? 'bathrooms="' . $instance['label_bathrooms'] . '"' : '';
		$parameters[] = $instance[ 'show_garages' ] ? 'garages="' . $instance['label_garages'] . '"' : '';
		$parameters[] = $instance[ 'show_keyword' ] ? 'keyword="' . $instance['label_keyword'] . '"' : '';
		$parameters[] = $instance[ 'show_available_from' ] ? 'available_from="' . $instance['label_available_from'] . '"' : '';
		$parameters[] = $instance[ 'show_minprice' ] ? 'minprice="' . $instance['label_minprice'] . '"' : '';
		$parameters[] = $instance[ 'show_maxprice' ] ? 'maxprice="' . $instance['label_maxprice'] . '"' : '';
		$parameters[] = $instance[ 'show_pricerange' ] ? 'pricerange="' . $instance['label_pricerange'] . '"' : '';
		
		echo do_shortcode( '[custom_property_search_form ' . implode( ' ', $parameters ) . ']' );
		
		// Widget ends printing information
		echo $after_widget;
	  
  }
	
	

}