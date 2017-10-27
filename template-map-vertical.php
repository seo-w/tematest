<?php get_header();
/*
Template Name: Property Map Vertical 
*/

global $realty_theme_option;
$listing_view = $realty_theme_option['property-listing-default-view'];
?>

<script>
jQuery(window).load(function() {
	var windowHeight = jQuery(window).height();
	var initialNavHeight = jQuery('header.navbar').height();
	var verticalMapHeight = windowHeight - initialNavHeight;
	jQuery('.google-map').height(verticalMapHeight);
});
</script>

<div class="container search-result-container">
	<div class="row">
		
		<div class="col-sm-6 search-container">
			<?php 
			wp_reset_postdata();
			// Property Search Form
			if( isset( $_GET['searchid'] ) ) {
				echo do_shortcode( base64_decode( $_GET['searchid'] ) );
			} else {
				get_template_part( 'lib/inc/template/search-form' );
			}
			// Build Property Search Query
			$search_results_args = array();
			$search_results_args = apply_filters( 'property_search_args', $search_results_args );
			
			$query_search_results = new WP_Query( $search_results_args );
			
			if ( $query_search_results->have_posts() ) :	
			$count_results = $query_search_results->found_posts;
			?>
		
			<h2 class="page-title"><?php echo __( 'Search Results', 'tt' ) . ' (<span>' . $count_results . '</span>)'; ?></h2>
		
			<?php the_content(); ?>
		
			<?php echo tt_property_listing_sorting_and_view(); ?>
			
			<div id="property-search-results" data-view="<?php if ( isset( $listing_view ) ) { echo $listing_view; } else { echo 'grid-view'; } ?>">
				<div id="property-items" class="show-compare">
								
					<?php get_template_part( 'lib/inc/template/property', 'comparison' ); ?>
				
					<ul class="row list-unstyled">
						<?php 
						while ( $query_search_results->have_posts() ) : $query_search_results->the_post();
						?>
						<li class="col-md-6">
							<?php get_template_part( 'lib/inc/template/property', 'item' );	?>
						</li>
						<?php endwhile; ?>
					</ul>
					<?php wp_reset_query(); ?>
				
					<div id="pagination">
					<?php
					// Built Property Pagination
					$big = 999999999; // need an unlikely integer
				
					echo paginate_links( array(
						'base' 				=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' 			=> '?page=%#%',
						'total' 			=> $query_search_results->max_num_pages,
						'end_size'    => 4,
						'mid_size'    => 2,
						'type'				=> 'list',
						'current'     => $search_results_args['paged'],
						'prev_text' 	=> __( '<i class="btn btn-default fa fa-angle-left"></i>', 'tt' ),
						'next_text' 	=> __( '<i class="btn btn-default fa fa-angle-right"></i>', 'tt' ),
					) );
					?>
					</div>
					
					<?php
					else : ?>
					<p class="lead text-center text-muted"><?php _e( 'No Properties Match Your Search Criteria.', 'tt' ); ?></p>
					<?php
					endif;
					?>
							
				</div>
			</div>
				
		</div>
	
		<div class="col-sm-6 map-container">
		<?php
	  // Search Results Map
		if ( ! $realty_theme_option['property-search-results-disable-map'] ) {
			get_template_part( 'lib/inc/template/google-map-multiple-properties' );
		}
		?>
		</div>
		
	</div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>