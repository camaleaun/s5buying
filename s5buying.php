<?php
/**
 * Plugin Name: s5buying
 * Plugin URI: http://www.sfive.com.br/buying/
 * Description: An helper to shopping lists and history for retailers.
 * Version: 1.0.0
 * Author: sFive
 * Author URI: http://sfive.com.br
 * Requires at least: 4.4
 * Tested up to: 4.5
 *
 * Text Domain: s5buying
 * Domain Path: /i18n/languages/
 *
 * @package s5buying
 * @category Core
 * @author sFive
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'S5buying' ) ) :

	/**
	 * Main S5buying Class.
	 *
	 * @class S5buying
	 * @version 1.0.0
	 */
	final class S5buying {

		/**
		 * s5buying version.
		 *
		 * @var string
		 */
		public $version = '1.0.0';

		/**
		 * The single instance of the class.
		 *
		 * @var s5buying
		 */
		protected static $_instance = null;

		/**
		 * Main s5buying Instance.
		 *
		 * Ensures only one instance of s5buying is loaded or can be loaded.
		 *
		 * @static
		 * @see s5buying()
		 * @return s5buying - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * s5buying Constructor.
		 */
		public function __construct() {
			$this->define_constants();
			$this->includes();
			$this->init_hooks();

			do_action( 's5buying_loaded' );
		}

		/**
		 * Hook into actions and filters.
		 * @since 1.0.0
		 */
		private function init_hooks() {
			register_activation_hook( __FILE__, array( 's5buying_Install', 'install' ) );
			add_action( 'init', array( $this, 'init' ), 0 );
		}

		/**
		 * Define s5panfe Constants.
		 */
		private function define_constants() {
			$this->define( 'S5BUYING_VERSION', $this->version );
		}

		/**
		 * Define constant if not already set.
		 *
		 * @param  string $name
		 * @param  string|bool $value
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * What type of request is this?
		 *
		 * @param  string $type admin.
		 * @return bool
		 */
		private function is_request( $type ) {
			switch ( $type ) {
				case 'admin' :
					return is_admin();
			}
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 */
		public function includes() {
			include_once( 'includes/s5buying-core-functions.php' );
			include_once( 'includes/class-s5buying-install.php' );

			if ( $this->is_request( 'admin' ) ) {
				include_once( 'includes/admin/class-s5buying-admin.php' );
			}

			$this->api   = include( 'includes/class-s5buying-api.php' ); // API Class
		}

		/**
		 * Init s5panfe when WordPress Initialises.
		 */
		public function init() {
			// Before init action
			do_action( 'before_s5buying_init' );

			// Set up localisation
			$this->load_plugin_textdomain();

			// Init action
			do_action( 's5buying_init' );
		}

		/**
		 * Load Localisation files.
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 's5buying', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Get the plugin url.
		 * @return string
		 */
		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', __FILE__ ) );
		}
	}

endif;

/**
 * Main instance of s5buying.
 *
 * Returns the main instance of s5buying to prevent the need to use globals.
 *
 * @return s5buying
 */
function s5buying() {
	return S5buying::instance();
}

s5buying();
