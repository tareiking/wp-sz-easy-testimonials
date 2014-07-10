<?php
/*
Plugin Name: Sennza Easy Testimonials
Version: 0.1-alpha
Description: @todo
Author: @todo
Author URI: @todo
Plugin URI: @todo
Text Domain: sz-easy-testimonials
Domain Path: /languages
*/

if ( ! class_exists('SZ_Easy_Testimonials')) {

/**
 * Class: SZ_Easy_Testimonials
 */
class SZ_Easy_Testimonials
{

private static $instance;

	/**
	 * Create a new instance of our class
	 *
	 * @return SZ_Easy_Testimonials
	 */

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new SZ_Easy_Testimonials;
		}

		return self::$instance;
	}

	function __construct(){
		add_action( 'init', array ( $this, 'register_cpt' ) );
	}

	// Register Custom Post Type
	function register_cpt() {

		$labels = array(
			'name'                => 'Testimonials',
			'singular_name'       => 'Testimonial',
			'menu_name'           => 'Testimonials',
			'parent_item_colon'   => 'Parent Item:',
			'all_items'           => 'All Testimonials',
			'view_item'           => 'View Item',
			'add_new_item'        => 'Add New Item',
			'add_new'             => 'Add New',
			'edit_item'           => 'Edit Item',
			'update_item'         => 'Update Item',
			'search_items'        => 'Search Item',
			'not_found'           => 'Not found',
			'not_found_in_trash'  => 'Not found in Trash',
		);
		$args = array(
			'label'               => 'Testimonials',
			'description'         => 'Show your customer testimonials',
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions' ),
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_icon'           => 'dashicons-smiley',
			'menu_position'       => 20,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capability_type'     => 'page',
		);
		register_post_type( 'testimonial', $args );

		add_image_size( 'testimonial-thumb', 300, 9999 );

	}

	public static function get_custom_excerpt($content = '', $limit = 25){
		$trimmed = wp_trim_words( $content, $limit, '...' );
		return $trimmed;
	}

	public static function do_testimonials( $widget_args = array(), $widget_instance = array() ) {

		$plugindir	= dirname( __FILE__ );
		$templatefilename = 'testimonials-template.php';

		if ( file_exists( TEMPLATEPATH . '/' . $templatefilename ) ) {
			$return_template = TEMPLATEPATH . '/' . $templatefilename;
			require_once( $return_template );
		} else {
			$return_template = $plugindir . '/templates/' . $templatefilename;
			require_once( $return_template );
		}
	}

}

} // endif

require_once( plugin_dir_path( __FILE__ ) . '/sz-easy-testimonials-widget.php' );

add_action( 'plugins_loaded', array( 'SZ_Easy_Testimonials', 'get_instance' ) );