<?php
/**
 * s5buying API
 *
 * Handles s5buying-API endpoint requests.
 *
 * @author   sFive
 * @category API
 * @package  s5buying/API
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 's5buying_API' ) ) :

class s5buying_API {

	/**
	 * This is the major version for the REST API and takes
	 * first-order position in endpoint URLs.
	 *
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 * @return s5buying_API
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( __CLASS__, 'register_api_hooks' ) );
	}

	/**
	 * Add new endpoints.
	 *
	 * @since 1.0.
	 */
	public static function register_api_hooks() {
		$namespace = 'toh-api/v1';
		register_rest_route( $namespace, '/list-heroes/', array(
			'methods'  => 'GET',
			'callback' => array( __CLASS__, 'get_heroes' ),
		) );
	}

	public static function get_heroes() {
		if ( 0 || false === ( $return = get_transient( 'toh_all_heroes' ) ) ) {
			$all_heroes = get_heroes();
			$return = array();
			foreach ( $all_heroes as $hero ) {
				$return[] = array(
					'id'   => $hero->hero_id,
					'name' => $hero->hero_name,
				);
			}
			// cache for 10 minutes
			set_transient( 'toh_all_heroes', $return, apply_filters( 'toh_ttl', 60 * 10 ) );
		}
		$response = new WP_REST_Response( $return );
		$response->header( 'Access-Control-Allow-Origin', apply_filters( 'toh_access_control_allow_origin', '*' ) );
		return $response;
	}
}

endif;

return new s5buying_API();
