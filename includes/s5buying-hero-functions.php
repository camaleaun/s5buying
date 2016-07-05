<?php
/**
 * s5buying Order Functions
 *
 * Functions for order specific things.
 *
 * @author      sFive
 * @category    Core
 * @package     s5buying/Functions
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Main function for returning heroes.
 *
 * @since  1.0
 */
function get_heroes() {
	global $wpdb;
	$columns = 'hero_id, hero_name';
	$table = $wpdb->prefix . 'heroes';
	$results = $wpdb->get_results( "SELECT $columns FROM $table" );
	$heroes = $results;
	return $heroes;
}
