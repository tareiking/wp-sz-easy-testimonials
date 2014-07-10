<?php

$plugin_defaults = SZ_Easy_Testimonials_Widget::get_widget_defaults();

$default_css = $plugin_defaults['css'];
$defaults = $plugin_defaults['args'];

// Allow developers to adjust the main query args
$args	= apply_filters( 'sz_easy_testimonials_defaults', $defaults );

// Allow developers to drop in their own classnames
$css	= apply_filters( 'sz_easy_testimonals_classnames', $default_css );

// Parse args from both arrays
$args	= wp_parse_args( $args, $defaults );
$css	= wp_parse_args( $css, $default_css );

// Run that query...
$testimonials = new WP_Query( $args );

/**
 * The template starts here...
 */
if ( $testimonials->have_posts() ): ?>

	<div class="<?php echo $css['parent_class']; ?>">
		<ul class="slides">
			<?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>

				<li class="<?php echo $css['item_class']; ?>">
					<blockquote>
						<div class="<?php echo $css['content_class']; ?>">
							<?php the_content(); ?>
						</div>

						<?php if ( $defaults['show_title'] ) { ?>
						<cite class="<?php echo $css['title_class']; ?>"><h3><?php the_title(); ?></h3></cite>
						<?php } ?>

					</blockquote>

				</li>
			<?php endwhile; ?>
		</ul>
	</div>

<?php else: ?>
	<p>No testimonials to display.</p>
<?php endif; ?>
<?php wp_reset_query(); ?>
