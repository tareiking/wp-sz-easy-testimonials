<?php

$defaults  = array(
	'post_type'			=> 'testimonial',
	'posts_per_page'	=> 2,
	'show_title'		=> true,
);

$default_css = array(
	'parent_class'		=> 'testimonials',
	'item_class'		=> 'testimonial-item',
	'image_class'		=> 'testimonial-image',
	'content_class'		=> 'testimonial-content',
	'title_class'		=> 'testimonial-title',
);

// Allow developers to adjust the main query args
$args	= apply_filters( 'sz_easy_testimonials_defaults', $args );

// Allow developers to drop in their own classnames
$css	= apply_filters( 'sz_easy_testimonals_classnames', $custom_css );

$args	= wp_parse_args( $args, $defaults );
$css	= wp_parse_args( $custom_css, $default_css );

$testimonials = new WP_Query( $args );

if ( $testimonials->have_posts() ): ?>

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