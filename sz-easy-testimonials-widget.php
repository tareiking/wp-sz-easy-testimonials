<?php
/**
 * Widget for Easy Testimonials
 */
class SZ_Easy_Testimonials_Widget extends WP_Widget
{
	function SZ_Easy_Testimonials_Widget() {

		$widget_opts = array(
			'classname'  => 'sz-easy-testimonials-widget',
			'description' => 'Easy Testimonial Widget',
		);

		$this->WP_Widget( 'sz_easy_testimonial_widget', 'Easy Testimonial Widget', $widget_opts );
	}

	public static function get_defaults(){

		$defaults = array(

			'css' => array(
				'parent_class'		=> 'testimonials',
				'item_class'		=> 'testimonial-item',
				'image_class'		=> 'testimonial-image',
				'content_class'		=> 'testimonial-content',
				'title_class'		=> 'testimonial-title',
				),

			'args' => array(
				'excerpt_limit'		=> 25,
				)
		);

		return $defaults;
	}

	/**
	 * Render the widget here
	 * @todo create a combined template similar to the do_testimonials() function
	 * @todo had trouble passing widget instance variables to do_testimonials() function
	 */
	function widget( $args, $instance ) {

		/**
		 * Setup the widget variables
		 */
		global $post;

		$defaults = SZ_Easy_Testimonials_Widget::get_defaults();

		$args = apply_filters( 'sz_easy_testimonials_defaults', $args );
		$css = apply_filters( 'sz_easy_testimonals_classnames', __return_empty_array() );

		$css = wp_parse_args( $css, $defaults['css'] );
		$args = wp_parse_args( $args, $defaults['args'] );

		if ( $instance['posts_per_page'] = '' || $instance['posts_per_page'] = 0 ) {
			$instance['post_per_page'] = 5;
		}

		$query = new WP_Query( array (
				'post_type'              => 'testimonial',
				'posts_per_page'         => $instance['post_per_page'],
				'order'                  => 'ASC',
		));

		/**
		 * Render our widget
		 */
		echo $args['before_widget'];
		echo '<h3 class="widget-title">' . $instance['title'] . '</h3>'; ?>

		<!-- Testimonials Widget -->
		<div class="<?php echo $css['parent_class']; ?> testimonials">
			<ul>
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>

				<?php
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
					$thumb_url = $thumb['0'];
				?>
				<li class="<?php echo $css['item_class']; ?>">
					<?php if ( has_post_thumbnail() ): ?>
						<div class="testimonial-thumb-wrapper circular-image" style="background: url(<?php echo $thumb_url; ?>) no-repeat;"></div>
					<?php endif; ?>

					<div class="<?php echo $css['content_class']; ?>">

						<blockquote>
							<span class="<?php echo $css['title_class']; ?>"><strong><?php the_title(); ?></strong></span>
							<?php echo SZ_Easy_Testimonials::get_custom_excerpt( get_the_excerpt(), $args['excerpt_limit'] ); ?>
						</blockquote>

					</div>

				</li>

				<?php endwhile; ?>
			</ul>
		</div>

		<?php echo $args['after_widget']; ?>

		<?php wp_reset_query();

	}


	/**
	 * Back-end widget form.
	 *
	 * @param array   $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		if ( ! isset( $instance['post_per_page'] ) ) {
			$instance['post_per_page'] = 5;
		}
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_per_page' ); ?>"><?php _e( '# of testimonials shown:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'post_per_page' ); ?>" name="<?php echo $this->get_field_name( 'post_per_page' ); ?>" type="text" value="<?php echo esc_attr( $instance['post_per_page'] ); ?>">
		</p>
		<?php
	}

	// updates the widget options when saved.
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['post_per_page'] = strip_tags( $new_instance['post_per_page'] );
		return $instance;
	}
}

// Load and Register the widget
add_action( 'widgets_init', 'register_sz_easy_testimonials_widget' );

function register_sz_easy_testimonials_widget() {
	register_widget( 'SZ_Easy_Testimonials_Widget' );
}
