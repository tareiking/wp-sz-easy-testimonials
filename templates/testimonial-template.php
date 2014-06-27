<?php
$defaults  = array(
	'post_type'       => 'testimonial',
	'posts_per_page'  => -1,
);

$args = wp_parse_args( $args, $defaults );

$testimonials = new WP_Query( $args );

if ( $slider_items->have_posts() ): ?>

	<div class="testimonials">
		<ul class="testimonial-item">
			<?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>

				<li>

					<?php if ( has_post_thumbnail() ): ?>
						<?php the_post_thumbnail( 'testimonial-thumb' ); ?>
					<?php endif; ?>

					<?php the_content(); ?>

				</li>
			<?php endwhile; ?>
		</ul>
	</div>
<?php else: ?>
	<p>No testimonials to display.</p>
<?php endif; ?>
<?php wp_reset_query(); ?>