<?php

/**
 * If no custom query specified, lets load the default
 */

	if ( $query == false ){
		$testimonials 	= SZ_Easy_Testimonials::get_default_query();
	} else {
		$testimonials = $query;
	}

	$css = apply_filters( 'sz_easy_testimonals_classnames', $_css );

/**
 * The template starts here...
 */
if ( $testimonials->have_posts() ): ?>

	<div class="<?php echo $css['parent_class']; ?> testimonials">
		<ul>
			<?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>

			<li class="<?php echo $css['item_class']; ?>">
				<a href="<?php echo SZ_Easy_Testimonials::get_testimonial_link(); ?>">

					<?php if ( has_post_thumbnail() ) { ?>
						<div class="testimonial-thumb-wrapper circular-image" style="background: url(<?php echo SZ_Easy_Testimonials::get_thumb_url(); ?>) no-repeat;"></div>
					<?php } else { ?>
						<div class="testimonial-thumb-wrapper circular-image" style="background-color: #99cc33;"></div>
					<?php } ?>
				</a>
				<div class="<?php echo $css['content_class']; ?>">

					<blockquote>
						<h4 class="testimonial-header"><?php the_title(); ?></h4>
						<span class="testimonial-content">
							<?php echo SZ_Easy_Testimonials::get_custom_excerpt( get_the_excerpt() )?>
							<a href="<?php echo SZ_Easy_Testimonials::get_testimonial_link(); ?>"> more...</a>
						</span>
					</blockquote>

				</div>

			</li>
			<?php endwhile; ?>
		</ul>
	</div>
<?php else: ?>
	<p>No testimonials to display.</p>
<?php endif; ?>
<?php wp_reset_query(); ?>
