<?php get_header();
/*
Template Name: Agents
*/
$hide_sidebar = get_post_meta( get_the_ID(), 'estate_page_hide_sidebar', true );
$hide_footer_widgets = get_post_meta( $post->ID, 'estate_page_hide_footer_widgets', true );
global $realty_theme_option;

if(isset($realty_theme_option['template_agent_order'])) {
	
	$agents_order = $realty_theme_option['template_agent_order'];
	
} else {
	
	$agents_order = 'desc';
}
if(isset($realty_theme_option['template_agent_orderby'])) {
	
	$agents_orderby = $realty_theme_option['template_agent_orderby'];
	
} else {
	
	$agents_orderby = 'registered';
}
?>
<div class="row">
	
	<?php 
	// Check for Agent Sidebar
	if ( ! $hide_sidebar && is_active_sidebar( 'sidebar_agent' ) ) {
		
		echo '<div class="col-sm-8 col-md-9">';
		
	} else {
		
		echo '<div class="col-sm-12">';
		
	}
	
	$args_users = array(
		'role'         => 'agent',
		'orderby'      => $agents_orderby ,
		'order'        => $agents_order ,	
	);
	
	$user_query_results = get_users( $args_users );
	
	// Display author info only, if user has published properties
	if ( $user_query_results ) {
		
		foreach( $user_query_results as $agent_user ) {
			
			$agent = $agent_user->ID;
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
			
			include( TT_LIB . '/inc/template/agent-information.php' );
		
		}
	
	} else {
		echo '<p>' . __( 'Publish at least one property to enable your public user profile.', 'tt' ) . '</p>';
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