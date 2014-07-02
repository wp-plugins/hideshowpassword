<?php
/**
 * hideShowPassword.
 *
 * @package   Hide_Show_Password
 * @author    Barry Ceelen <b@rryceelen.com>
 * @license   GPL-2.0+
 * @link      https://github.com/barryceelen/wp-hide-show-password
 * @copyright 2013 Barry Ceelen
 */

/**
 * Plugin class.
 *
 * @package Hide_Show_Password
 * @author  Barry Ceelen <b@rryceelen.com>
 */
class Hide_Show_Password {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.4';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Initialize the plugin by adding actions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load login screen style sheet and JavaScript.
		add_action( 'login_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'login_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	}

	/**
	 * Register and enqueue login screen style sheet.
	 *
	 * @since     1.0.0
	 *
	 */
	public function enqueue_styles() {
		wp_enqueue_style(
			'hide-show-password-login-styles',
			plugins_url( 'css/public.css', __FILE__ ),
			array(),
			self::VERSION
		);
	}

	/**
	 * Register and enqueue login screen JavaScript.
	 *
	 * @since     1.0.0
	 *
	 */
	public function enqueue_scripts() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_register_script(
			'hide-show-password',
			plugins_url( 'js/vendor/hideShowPassword' . $suffix . '.js', __FILE__ ),
			array( 'jquery' ),
			self::VERSION,
			true
		);

		wp_enqueue_script(
			'hide-show-password-login-script',
			plugins_url( 'js/public.js', __FILE__ ),
			array( 'jquery', 'hide-show-password' ),
			self::VERSION,
			true
		);
	}
}
