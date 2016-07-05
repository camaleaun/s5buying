<?php
/**
 * Load assets
 *
 * @author      sFive
 * @category    Admin
 * @package     s5buying/Admin
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'S5buying_Admin_Assets' ) ) :

/**
 * S5buying_Admin_Assets Class.
 */
class S5buying_Admin_Assets {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
	}

	/**
	 * Enqueue styles.
	 */
	public function admin_styles() {

		// Register admin styles
		wp_register_style( 's5buying_admin_menu_styles', s5buying()->plugin_url() . '/assets/css/menu.css', array(), S5BUYING_VERSION );

		// Sitewide menu CSS
		wp_enqueue_style( 's5buying_admin_menu_styles' );
	}
}

endif;

return new S5buying_Admin_Assets();
