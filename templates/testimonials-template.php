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

			<?php
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
				$thumb_url = $thumb['0'];
			?>
			<li class="<?php echo $css['item_class']; ?>">
				<?php if ( has_post_thumbnail() ) { ?>
					<div class="testimonial-thumb-wrapper circular-image" style="background: url(<?php echo $thumb_url; ?>) no-repeat;"></div>
				<?php } else { ?>
					<div class="testimonial-thumb-wrapper circular-image" style="background-color: #99cc33;"></div>
				<?php } ?>

				<div class="<?php echo $css['content_class']; ?>">

					<blockquote>
						<span class="<?php echo $css['title_class']; ?>"><strong><?php the_title(); ?></strong></span>
						<?php echo SZ_Easy_Testimonials::get_custom_excerpt( get_the_excerpt() ); ?>
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
