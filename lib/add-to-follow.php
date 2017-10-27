<?php
/* AJAX - Follow
============================== */
function tt_ajax_add_remove_follow() {
	$user_id = $_GET['user'];
	$property_id = $_GET['property'];
			
	// Get follow Meta Data
	$get_user_meta_follow = get_user_meta( $user_id, 'realty_user_follow', false ); // false = array()

	// No User Meta Data follow Found -> Add Data
	if ( !$get_user_meta_follow ) {
		$create_follow = array($property_id);
		add_user_meta( $user_id, 'realty_user_follow', $create_follow );		
	}
	// Meta Data Found -> Update Data
	else {
		// Add New Follow
		if ( !in_array( $property_id, $get_user_meta_follow[0] ) ) {
			array_unshift( $get_user_meta_follow[0], $property_id ); // Add To Beginning Of follow Array
			update_user_meta( $user_id, 'realty_user_follow', $get_user_meta_follow[0] );		
		}
		// Remove Follow
		else {
			$removeFollowFromPosition = array_search( $property_id, $get_user_meta_follow[0] );
			unset($get_user_meta_follow[0][$removeFollowFromPosition]);
			update_user_meta( $user_id, 'realty_user_follow', $get_user_meta_follow[0] );		
		}
	}
}
add_action('wp_ajax_tt_ajax_add_remove_follow', 'tt_ajax_add_remove_follow');


/* follow - Click
============================== */
if ( !function_exists('tt_add_remove_follow') ) {
	function tt_add_remove_follow() {
		
		global $realty_theme_option;
		
		if ( $realty_theme_option['property-follow-disabled'] ) 
		return;
		
		$property_id = get_the_ID();
		
		// Logged-In User
		if ( is_user_logged_in() ) {		
			$user_id = get_current_user_id();		
			$get_user_meta_follow = get_user_meta( $user_id, 'realty_user_follow', false ); // false = array()					
			
			// Follow: true
			if ( ! empty( $get_user_meta_follow ) && in_array( $property_id, $get_user_meta_follow[0] ) ) {
				$favicon = '<i class="add-to-follow fa fa-envelope" data-fol-id="' . $property_id . '" data-toggle="tooltip" title="' . __( 'Unsubscribe From Email Updates', 'tt' ) . '"></i>';	
			}
			// Follow: false
			else {
				$favicon = '<i class="add-to-follow fa fa-envelope-o" data-fol-id="' . $property_id . '" data-toggle="tooltip" title="' . __( 'Subscribe To Email Updates', 'tt' ) . '"></i>';
			}	
		}
		// Not Logged-In Visitor
		else {
			$favicon = '<i class="add-to-follow fa fa-envelope-o" data-fol-id="' . $property_id . '" data-toggle="tooltip" title="' . __( 'Subscribe To Email Updates', 'tt' ) . '"></i>';
		}
		
		return $favicon;
		
	}
}

/* follow - Script
============================== */
function tt_follow_script() {

	global $realty_theme_option;
	// $add_follow_temporary = $realty_theme_option['property-follow-temporary'];
	?>
	
	<script>		
	<?php /*
	// Temporary follow
	if ( !is_user_logged_in() && $realty_theme_option['property-follow-temporary'] ) { 
	?>
	jQuery('.add-to-follow').each(function() {
		
		// Check If item Already In follow Array
		function inArray(needle, haystack) {
	    if ( haystack ) {    
		    var length = haystack.length;
		    for( var i = 0; i < length; i++ ) {
		      if(haystack[i] == needle) return true;
		    }
		    return false;
	    }
		}
		
		// Check If Browser Supports LocalStorage		
		if (!store.enabled) {
	    alert('<?php echo __( 'Local storage is not supported by your browser. Please disable "Private Mode", or upgrade to a modern browser.', 'tt' ); ?>');
			return;
	  }
		// Toggle Heart Class
		if ( inArray( jQuery(this).attr('data-fol-id'), store.get('follow') ) ) {
			
			jQuery(this).toggleClass('fa-envelope fa-envelope-o');
			
			if ( jQuery(this).hasClass('fa-envelope') ) {
				jQuery(this).attr('data-original-title', '<?php _e( 'Remove From follow', 'tt' ); ?>');
			}
			
		}
		
	});
	<?php } */?>
		
	jQuery('.container').on("click",'.add-to-follow',function() {
		
		<?php 
		// Logged-In User
		if ( is_user_logged_in() ) {
		?>
		
			// Toggle Follow Tooltips
			if ( jQuery(this).hasClass('fa-envelope-o') ) {
				jQuery(this).attr('data-original-title', '<?php _e( 'Unsubscribe From Email Updates', 'tt' ); ?>');
			}
			if ( jQuery(this).hasClass('fa-envelope') ) {
				jQuery(this).attr('data-original-title', '<?php _e( 'Subscribe To Email Updates', 'tt' ); ?>');
			}
			
			jQuery(this).find('i').toggleClass('fa-envelope fa-envelope-o');
			jQuery(this).closest('i').toggleClass('fa-envelope fa-envelope-o');
			
			<?php 
			if ( is_user_logged_in() ) {
				$user_id = get_current_user_id();
				?>
				jQuery.ajax({			
				  type: 'GET',
				  url: ajaxURL,
				  data: {
				    'action'        :   'tt_ajax_add_remove_follow', // WP Function
				    'user'					: 	<?php echo $user_id; ?>,
				    'property'			: 	jQuery(this).attr('data-fol-id')
				  },
				  success: function (response) { },
				  error: function () { }			  
				});
				<?php
			}
		
		}
		// Not Logged-In Visitor - Show Modal
		else {		
			?>
			jQuery('a[href="#tab-login"]').tab('show');
			jQuery('#login-modal').modal();
			jQuery('#msg-login-to-add-follow').removeClass('hide');
			jQuery('#msg-login-to-add-follow').addClass('hide');
			<?php	
		}
		?>
		
	});
	</script>
	
<?php
}
add_action( 'wp_footer', 'tt_follow_script', 21 );


// Sent Message when property is updated.
function tt_property_updated_send_email( $post_id ) {
	// If this is just a revision, don't send the email.
	if ( wp_is_post_revision( $post_id ) )
		return;

	$users = get_users( 'meta_key=realty_user_follow' );
		
	foreach ( $users as $user ) {
		$follows = get_user_meta( $user->ID, 'realty_user_follow', true );

		foreach ( $follows as $follow ) {
			if( $post_id == $follow ) {
				
				$post_title = get_the_title();
				$post_url = get_permalink();
				$subject = __( 'A property that you follow has been updated', 'tt' );

				$message  = '<h2 style="margin-bottom: 0.5em">' . $post_title . '</h2>';
				if ( has_post_thumbnail() ) {
					$message .=  '<a href="' . $post_url . '">' . wp_get_attachment_image( get_post_thumbnail_id(), 'thumbnail' ) . '</a>';
				}
				$message .= '<p><a href="' . $post_url . '">' . $post_url  . '</a></p>';
				$message .= '<div style="height:1px; margin: 1em 0; background-color:#eee"></div>';
				$message .= '<p style="color: #999">' . __( 'Unsubscribe from update notifications by clicking the property link above, then click the envelop icon next to the property title.', 'tt' ) . '</p>';
				
				// Send email to user.
				wp_mail( $user->user_email, $subject, $message );
				
			}
		}
		
	}

}
add_action( 'save_post', 'tt_property_updated_send_email' );
