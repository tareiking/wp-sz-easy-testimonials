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

	public static function get_widget_defaults(){

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
				'post_type'			=> 'testimonial',
				'posts_per_page'	=> 5,
				'show_title'		=> true,
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

		/**
		 * Render the testimonial template
		 */
		SZ_Easy_Testimonials::do_testimonials( $args, $instance );
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
