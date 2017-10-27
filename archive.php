<?php
/**
 * Page template for displaying archive pages
 * @package WordPress
 * @subpackage realty
 * @since Realty 2.0
 */
get_header(); ?>
		<div class="taxonomy-results">

		<div class="search-results-header clearfix">

		<?php if ( have_posts() ) : ?>

			<h2 class="page-title">
				<?php
					echo __( 'Category:', 'tt' ) . ' ' . str_replace( '-', ' ', get_queried_object()->name );
					echo ' (' . $wp_query->found_posts . ')';
				?>
			</h2>
            <div class="taxonomy-description">
			<?php the_archive_description( '<div>', '</div>' ); ?>
			</div>
			<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				get_template_part( 'content', get_post_format() );

			// End the loop.
			endwhile;

			//Pagination
			?>
			<div id="pagination">
			<?php
			// Built Property Pagination
			global $wp_query;
			$big = 999999999; // need an unlikely integer
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			
			echo paginate_links( array(
				'base' 				=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' 			=> '?page=%#%',
				'total' 			=> $wp_query->max_num_pages,
				//'show_all'		=> true,
				'end_size'    => 4,
				'mid_size'    => 2,
				'type'				=> 'list',
				'current'     => $paged,
				'prev_text' 	=> __( '<i class="btn btn-default fa fa-angle-left"></i>', 'tt' ),
				'next_text' 	=> __( '<i class="btn btn-default fa fa-angle-right"></i>', 'tt' ),
			) );
			?>
			</div>
         <?php
		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'content', 'none' );

		endif;
		?>

	</div>
    </div>

<?php get_footer(); ?>
