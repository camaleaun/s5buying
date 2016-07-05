<?php
/**
 * Setup menus in WP admin.
 *
 * @author   sFive
 * @category Admin
 * @package  s5buying/Admin
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'S5buying_Admin_Menus' ) ) :

/**
 * S5buying_Admin_Menus Class.
 */
class S5buying_Admin_Menus {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		// Add menus
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 9 );
	}

	/**
	 * Add menu items.
	 */
	public function admin_menu() {
		add_menu_page( __( 'Retail Shop', 's5buying' ), __( 'Retail Shop', 's5buying' ), 'manage_options', 's5buying', null, null, '55.5' );
	}
}

endif;

return new S5buying_Admin_Menus();
