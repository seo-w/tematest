<?php 
get_header();
global $realty_theme_option;
$property_contact_form_default_email = $realty_theme_option['property-contact-form-default-email'];
$hide_sidebar = get_post_meta( get_the_ID(), 'estate_page_hide_sidebar', true );
$author = get_user_by( 'slug', get_query_var( 'author_name' ) );

$agent = $author->ID;

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

$author_has_published_properties = true; // Always show public profile, even when user has no published properties

// Query: Has user published any properties?
$property_args = array(
	'post_type' 				=> 'property',
	'posts_per_page' 		=> -1,
	'author'						=> $agent,
);

// Query 2: Is agent assigned to any properties?
$property_args_agent_assigned = array(
	'post_type' 				=> 'property',
	'posts_per_page' 		=> -1,
	'author__not_in'		=> $agent,
	'meta_query' 				=> array(
		array(
			'key' 		=> 'estate_property_custom_agent',
			'value' 	=> $author->ID,
			'compare'	=> '='
		)
	)
);

// Create two queries
$query_property = new WP_Query( $property_args );
$query_property_assigned_agent = new WP_Query( $property_args_agent_assigned );
$query_combined_results = new WP_Query();

// Set posts and post_count
$query_combined_results->posts = array_merge( $query_property->posts, $query_property_assigned_agent->posts );
$query_combined_results->post_count = $query_property->post_count + $query_property_assigned_agent->post_count;

// Check if user has any published or assigned properties
if ( $query_combined_results->post_count ) {
	$author_has_published_properties = true;
}

$query_property = new WP_Query( $property_args );
if ( $query_property->have_posts() ) : $query_property->the_post();
	$author_has_published_properties = true;
	wp_reset_query();
endif;
?>

<div class="row">
	
	<?php 
	// Check for Agent Sidebar
	if ( ! $hide_sidebar && is_active_sidebar( 'sidebar_agent' ) ) {
		echo '<div class="col-sm-8 col-md-9">';
	} else {
		echo '<div class="col-sm-12">';
	}

	// Display author info only, if user has published properties
	if ( $author_has_published_properties ) {
	
		include TEMPLATEPATH . '/lib//inc/template/agent-information.php'; 
		
		include TEMPLATEPATH . '/lib/inc/template/contact-form.php' ;
	
		if ( $query_combined_results->have_posts() ) : 
		
			echo '<div id="property-items"><div class="owl-carousel-2-nav nav-bottom">';
			while ( $query_combined_results->have_posts() ) : $query_combined_results->the_post();
			get_template_part( 'lib/inc/template/property', 'item' );	
			endwhile;
			wp_reset_query();
			echo '</div></div>';
		
		endif;
	
	} // END if user has published properties
	else {
		echo '<p>' . __( 'Publish at least one property to enable your public user profile.', 'tt' ) . '</p>';
		echo '</div><!-- #agent -->';
	}
	?>
	
	</div><!-- .col-sm-8 -->
	
	<?php 
	// Check for Agent Sidebar
	if ( ! $hide_sidebar && is_active_sidebar( 'sidebar_agent' ) ) : 
	?>
	<div class="col-sm-4 col-md-3">
		<ul id="sidebar">
			<?php dynamic_sidebar( 'sidebar_agent' ); ?>
		</ul>
	</div>
	<?php endif; ?>
	
</div><!-- .row -->

<?php get_footer(); ?>