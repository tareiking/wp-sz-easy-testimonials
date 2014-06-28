<?php

$defaults  = array(
	'post_type'			=> 'testimonial',
	'posts_per_page'	=> 5,
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
$css	= apply_filters( 'sz_easy_testimonals_classnames', $_css );

$args	= wp_parse_args( $args, $defaults );
$css	= wp_parse_args( $css, $default_css );

$testimonials = new WP_Query( $args );
/**
 * The template starts here...
 */
if ( $testimonials->have_posts() ): ?>

	<div class="<?php echo $css['parent_class']; ?>">
		<ul>
			<?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>

				<li class="<?php echo $css['item_class']; ?>">

					<?php if ( $defaults['show_title'] ) { ?>
						<h1 class="<?php echo $css['title_class']; ?>"><?php the_title(); ?></h1>
					<?php } ?>

					<?php if ( has_post_thumbnail() ): ?>

						<?php the_post_thumbnail( 'testimonial-thumb' , array( 'class' => $css['image_class'] ) ); ?>

					<?php endif; ?>

					<div class="<?php echo $css['content_class']; ?>">
						<?php the_content(); ?>
					</div>

				</li>
			<?php endwhile; ?>
		</ul>
	</div>
<?php else: ?>
	<p>No testimonials to display.</p>
<?php endif; ?>
<?php wp_reset_query(); ?>
