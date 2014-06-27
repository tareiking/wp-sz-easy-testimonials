<?php
/**
 *	Widget for Easy Testimonials
 */
class SZ_Easy_Testimonials_Widget extends WP_Widget
{
	function SZ_Easy_Testimonials_Widget() {

		$widget_opts = array(
				'classname' => 'sz-easy-testimonials-widget',
				'description' => 'Easy Testimonial Widget',
		);

		$this->WP_Widget('sz_easy_testimonial_widget', 'Easy Testimonial Widget', $widget_opts);
	}

	function widget($args, $instance) {
		SZ_Easy_Testimonials::do_testimonials();
	}

	// updates the widget options when saved.
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
}

// Load and Register the widget
add_action('widgets_init', 'register_sz_easy_testimonials_widget');

function register_sz_easy_testimonials_widget() {
	register_widget( 'SZ_Easy_Testimonials_Widget' );
}

function show_5( $args ){
	$args['posts_per_page'] = 2;
	return $args;
}
add_action('sz_easy_testimonials_defaults' , 'show_5' );