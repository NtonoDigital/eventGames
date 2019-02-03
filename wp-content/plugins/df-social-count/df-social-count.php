<?php
/**
 * Plugin Name: DF Social Count
 * Plugin URI: https://github.com/danfisher85/df-social-count
 * Description: Displays your numbers in Facebook, GitHub, Google+, Instagram, Pinterest, Steam Community, Tumblr, Twitch, Twitter, Vimeo, Youtube, posts, comments and users.
 * Author: Dan Fisher
 * Author URI: https://themeforest.net/user/dan_fisher
 * Version: 1.0.0
 * License: GPLv2 or later
 * Text Domain: df-social-count
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'DF_Social_Count' ) ) :

/**
 * DF_Social_Count main class.
 *
 * @package  DF_Social_Count
 * @category Core
 * @author   Dan Fisher
 */
class DF_Social_Count {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '3.4.1';

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin.
	 */
	private function __construct() {
		// Load plugin text domain.
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Include classes.
		$this->includes();
		$this->include_counters();

		if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
			$this->admin_includes();
		}

		// Widget.
		add_action( 'widgets_init', array( $this, 'register_widget' ) );

		// Scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'styles_and_scripts' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'df-social-count', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Include admin actions.
	 */
	protected function admin_includes() {
		include dirname( __FILE__ ) . '/includes/admin/class-df-social-count-admin.php';
	}

	/**
	 * Include plugin functions.
	 */
	protected function includes() {
		include_once dirname( __FILE__ ) . '/includes/class-df-social-count-generator.php';
		include_once dirname( __FILE__ ) . '/includes/abstracts/abstract-df-social-count-counter.php';
		include_once dirname( __FILE__ ) . '/includes/class-df-social-count-view.php';
		include_once dirname( __FILE__ ) . '/includes/class-df-social-count-widget.php';
		include_once dirname( __FILE__ ) . '/includes/df-social-count-functions.php';
		include_once dirname( __FILE__ ) . '/includes/df-social-count-deprecated-functions.php';
	}

	/**
	 * Include counters.
	 */
	protected function include_counters() {
		foreach ( glob( realpath( dirname( __FILE__ ) ) . '/includes/counters/*.php' ) as $filename ) {
			include_once $filename;
		}
	}

	/**
	 * Register widget.
	 */
	public function register_widget() {
		register_widget( 'DFSocialCount' );
	}

	/**
	 * Register public styles and scripts.
	 */
	public function styles_and_scripts() {
		wp_register_style( 'df-social-count', plugins_url( 'assets/css/df-social-count.min.css', __FILE__ ), array(), DF_Social_Count::VERSION, 'all' );
	}
}

/**
 * Init the plugin.
 */
add_action( 'plugins_loaded', array( 'DF_Social_Count', 'get_instance' ) );

endif;
