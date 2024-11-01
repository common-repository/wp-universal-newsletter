<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://primitivespark.com
 * @since      1.0.0
 *
 * @package    wp-universal-newsletter
 * @subpackage wp-universal-newsletter/includes
 *

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @since      1.0.0
 * @package    wp-universal-newsletter
 * @subpackage wp-universal-newsletter/includes
 * @author     Brett Exnowslki <bexnowski@primitivespark.com>
 */
class wpun_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wp_newsletter    The ID of this plugin.
	 */
	private $wpun_newsletter;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $wpun_newsletter       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $wpun_newsletter, $version ) {

		$this->wpun_newsletter = $wpun_newsletter;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in wp_newsletter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The wp_newsletter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->wpun_newsletter, plugin_dir_url( __FILE__ ) . 'css/wp-newsletter-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in wp_newsletter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The wp_newsletter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->wpun_newsletter, plugin_dir_url( __FILE__ ) . 'js/wp-newsletter-public.js', array( 'jquery' ), $this->version, false );

	}

}
