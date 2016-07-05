<?php
/**
 * s5panfe Admin
 *
 * @class    S5buying_Admin
 * @author   sFive
 * @category Admin
 * @package  s5buying/Admin
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * S5buying_Admin class.
 */
class S5buying_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'includes' ) );
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {
		include_once( 'class-s5buying-admin-menus.php' );
		include_once( 'class-s5buying-admin-assets.php' );
	}
}

return new S5buying_Admin();
