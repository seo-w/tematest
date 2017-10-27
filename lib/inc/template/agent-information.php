<section class="agent content-box">
	<div class="row">
	  <?php
		$agent_output  = '<div class="col-sm-4">';
		
	  if ( $profile_image ) {
      
      $profile_image_id = tt_get_image_id( $profile_image );
      $profile_image_array = wp_get_attachment_image_src( $profile_image_id, 'square-400' );
      $agent_output .= '<img src="' . $profile_image_array[0] . '" />';
      
      if ( $realty_theme_option['show-agent-social-networks'] ) {
	      $agent_output .= '<div class="social-transparent">';
	      if ( $facebook ) { 
		      $agent_output .=  '<a href="' . $facebook . '" target="_blank"><i class="fa fa-facebook"></i></a>'; 
		    }
	      if ( $twitter ) { 
		    	$agent_output .=  '<a href="' . $twitter . '" target="_blank"><i class="fa fa-twitter"></i></a>'; 
		    }
	      if ( $google ) { 
		    	$agent_output .=  '<a href="' . $google . '" target="_blank"><i class="fa fa-google-plus"></i></a>'; 
		    }
	      if ( $linkedin ) { 
		    	$agent_output .=  '<a href="' . $linkedin . '" target="_blank"><i class="fa fa-linkedin"></i></a>'; 
		    }
	      $agent_output .= '</div>';
      }
      $agent_output .= '</div>';
      $agent_output .= '<div class="col-sm-8">';
      
	  }	else {
	  	$agent_output .= '<div class="col-sm-12">';
	  }
	      
	  if ( $first_name && $last_name ) {
			$agent_output .= '<h2 class="title">' . $first_name . ' ' . $last_name . '</h2>';
			if ( $company_name ) {
				$agent_output .= '<p class="company-name">' . $company_name . '</p>';
			}
		} else if ( $company_name ) {
			$agent_output .= '<h2 class="title">' . $company_name . '</h2>';
		}
		
		echo $agent_output;
		
	  if ( $email && $realty_theme_option['show-agent-email'] ) { ?><div class="contact"><i class="fa fa-envelope-o"></i><a href="mailto:<?php echo antispambot( $email ); ?>"><?php echo antispambot( $email ); ?></a></div><?php }
	  if ( $office && $realty_theme_option['show-agent-office'] ) { ?><div class="contact"><i class="fa fa-phone"></i><?php echo $office; ?></div><?php }
	  if ( $mobile && $realty_theme_option['show-agent-mobile'] ) { ?><div class="contact"><i class="fa fa-mobile"></i><?php echo $mobile; ?></div><?php }
	  if ( $fax && $realty_theme_option['show-agent-fax'] ) { ?><div class="contact"><i class="fa fa-fax"></i><?php echo $fax; ?></div><?php }
	  if ( $website && $realty_theme_option['show-agent-website'] ) { ?><div class="contact"><i class="fa fa-globe"></i><a href="<?php echo $website; ?>" target="_blank"><?php echo $website_clean; ?></a></div><?php } ?>
	  <div class="description">
	  	<?php if ( $bio ) {  if(!is_author()){$trim = wp_trim_words( $bio, 40, '..' ); echo '<p>' . $trim . '</p>'; } else { echo '<p>' . $bio . '</p>'; } } ?>
	  </div>
	  
	  <?php if ( ! is_page_template( 'author.php' ) ) { ?>
	  <div class="agent-more-link"><a href="<?php echo $author_profile_url; ?>" class="btn btn-primary"><?php _e( 'Profile', 'tt' ); ?></a></div></div>
	  <?php } ?>
	 </div>	
</section>