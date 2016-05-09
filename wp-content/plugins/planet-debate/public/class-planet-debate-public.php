<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Planet_Debate
 * @subpackage Planet_Debate/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Planet_Debate
 * @subpackage Planet_Debate/public
 * @author     Your Name <email@example.com>
 */
class Planet_Debate_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $Planet_Debate    The ID of this plugin.
	 */
	private $Planet_Debate;

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
	 * @param      string    $Planet_Debate       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Planet_Debate, $version ) {

		$this->Planet_Debate = $Planet_Debate;
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
		 * defined in Planet_Debate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Planet_Debate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->Planet_Debate, plugin_dir_url( __FILE__ ) . 'css/planet-debate-public.css', array(), $this->version, 'all' );

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
		 * defined in Planet_Debate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Planet_Debate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->Planet_Debate, plugin_dir_url( __FILE__ ) . 'js/planet-debate-public.js', array( 'jquery' ), $this->version, false );

	}

}
