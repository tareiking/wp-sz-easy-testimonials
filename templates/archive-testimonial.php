<?php
/**
 * Testimonial Archive Page
 *
 * @package Green Financial Theme
 */

/**
 * If customer has specified a page named "Testimonials",
 * lets load that instead of the archive-testimonial.php
 */
if ( get_page_by_title( 'testimonials' ) ) {
	wp_redirect( get_permalink( get_page_by_title( 'testimonials' ) ) );
}

get_header(); ?>

	<div class="row testimonials">

	<header class="entry-header">
		<h1 class="entry-title"><?php _e( 'Testimonials', ''); ?>
			<?php edit_post_link( __( 'Edit', 'green_financial' ), '<span class="edit-link">(', ')</span>' ); ?>
		</h1>
	</header><!-- .entry-header -->

		<div class="large-12 columns content testimonial-page-template" role="content">

			<?php
			// Generate a child page grid if current page is a parent.
			$testimonials = new WP_Query( array (
					'post_type'              => 'testimonial',
					'order'                  => 'ASC',
					'pagination'             => true,
					'paged' => $paged,
				) ); ?>

			<div class="row">
				<?php
				while ( $testimonials->have_posts() ) : $testimonials->the_post();

				get_template_part( 'parts/content', 'testimonial' ); ?>

				<?php endwhile; ?>


			</div>

			<?php green_financial_custom_pagination( $testimonials ); ?>

			<?php wp_reset_postdata(); // reset the query ?>

		</div>
	</div>

<?php get_footer(); ?>