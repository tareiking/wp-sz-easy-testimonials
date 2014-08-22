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

		if ( $instance['posts_per_page'] == '' || $instance['posts_per_page'] == 0 ) {
			$instance['posts_per_page'] = 5;
		}

		$args = array (
			'post_type'       => 'testimonial',
			'posts_per_page'  => (int) $instance['posts_per_page'],
			'order'           => 'ASC',
			'orderby'         => 'menu_order',
		);


		if ( ! $instance['featured'] == ''){
			$args['p'] = $instance['featured'];
		}

		// If testimonial has already been set in post_meta
		$args = apply_filters( 'sz_testimonial_display_query', $args );

		$query = new WP_Query( $args );

		/**
		 * Render our widget
		 */
		echo $args['before_widget'];

		// Render title with link
		if ( $instance['title'] != '' ){ ?>
			<h3 class="widget-title">
				<a href="<?php echo get_post_type_archive_link( 'testimonial' ); ?>">
					<?php echo $instance['title']; ?>
				</a>
			</h3>

		<?php }

		SZ_Easy_Testimonials::do_testimonials( $query );

		echo $args['after_widget'];

		wp_reset_query();

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
		if ( ! isset( $instance['posts_per_page'] ) ) {
			$instance['posts_per_page'] = 5;
		}
		if ( ! isset( $instance['testimonials_link'] ) ) {
			$instance['posts_per_page'] = '';
		}
		if ( ! isset( $instance['featured'] ) ) {
			$instance['featured'] = '';
			$featured = '';
		} else {
			$featured = $instance['featured'];
		}

		// Get all testimonials
		$query_args = array(
			'post_type'         => 'testimonial',
			'orderby'           => 'menu_order',
			'posts_per_page'    => -1,
			'show_title'        => true,
		);

		$testimonials = new WP_Query( $query_args ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<?php if ( $testimonials->have_posts() ) : ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'featured' ); ?>"><?php _e( 'Featured Testimonial: <br>If selected, only one testimonial will be shown.' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'featured' ); ?>" id="<?php echo $this->get_field_id( 'featured' ); ?>" class="widefat">
				<option value=""></option>
				<?php
				while ( $testimonials->have_posts() ) : $testimonials->the_post();
					printf( '<option value="%s" %s>%s</option>', get_the_ID(), selected( get_the_ID(), $instance['featured'], 0 ), get_the_title() );
				endwhile;
				?>
			</select>
		</p>
		<?php endif ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e( '# of Testimonials visible' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="text" value="<?php echo esc_attr( $instance['posts_per_page'] ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'testimonials_link' ); ?>"><?php _e( 'Testimonials link: (eg: http://mydomain.com/testimonials/)' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'testimonials_link' ); ?>" name="<?php echo $this->get_field_name( 'testimonials_link' ); ?>" type="text" value="<?php echo esc_attr( $instance['testimonials_link'] ); ?>">
		</p>

		<?php
		wp_reset_query();

	}

	// updates the widget options when saved.
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['posts_per_page'] = strip_tags( $new_instance['posts_per_page'] );
		$instance['testimonials_link'] = strip_tags( $new_instance['testimonials_link'] );
		$instance['featured'] = strip_tags( $new_instance['featured'] );
		return $instance;
	}
}

// Load and Register the widget
add_action( 'widgets_init', 'register_sz_easy_testimonials_widget' );

function register_sz_easy_testimonials_widget() {
	register_widget( 'SZ_Easy_Testimonials_Widget' );
}
