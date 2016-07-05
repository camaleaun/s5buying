<?php
/**
 * Installation related functions and actions
 *
 * @author   sFive
 * @category Admin
 * @package  s5buying/Classes
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * s5buying_Install Class.
 */
class S5buying_Install {

	/**
	 * Hook in tabs.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'check_version' ), 5 );
	}

	/**
	 * Check s5buying version and run the updater is required.
	 *
	 * This check is done on all requests and runs if he versions do not match.
	 */
	public static function check_version() {
		if ( ! defined( 'IFRAME_REQUEST' ) && get_option( 's5buying_version' ) !== s5buying()->version ) {
			self::install();
			do_action( 's5buying_updated' );
		}
	}

	/**
	 * Install s5buying.
	 */
	public static function install() {
		global $wpdb;

		if ( ! defined( 'S5BUYING_INSTALLING' ) ) {
			define( 'S5BUYING_INSTALLING', true );
		}

		self::create_tables();

		// Flush rules after install
		flush_rewrite_rules();

		// Trigger action
		do_action( 's5buying_installed' );
	}

	/**
	 * Set up the database tables which the plugin needs to function.
	 *
	 * Tables:
	 *		heroes - Table for storing heroes.
	 */
	private static function create_tables() {
		global $wpdb;

		$wpdb->hide_errors();

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( self::get_schema() );
	}

	/**
	 * Get Table schema.
	 * @return string
	 */
	private static function get_schema() {
		global $wpdb;

		$collate = '';

		if ( $wpdb->has_cap( 'collation' ) ) {
			if ( ! empty( $wpdb->charset ) ) {
				$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if ( ! empty( $wpdb->collate ) ) {
				$collate .= " COLLATE $wpdb->collate";
			}
		}

		/*
		 * Indexes have a maximum size of 767 bytes. Historically, we haven't need to be concerned about that.
		 * As of WordPress 4.2, however, we moved to utf8mb4, which uses 4 bytes per character. This means that an index which
		 * used to have room for floor(767/3) = 255 characters, now only has room for floor(767/4) = 191 characters.
		 *
		 * This may cause duplicate index notices in logs due to https://core.trac.wordpress.org/ticket/34870 but dropping
		 * indexes first causes too much load on some servers/larger DB.
		 */
		$max_index_length = 191;

		return "
CREATE TABLE {$wpdb->prefix}heroes (
  hero_id bigint(20) NOT NULL AUTO_INCREMENT,
  hero_name longtext NOT NULL,
  UNIQUE KEY hero_id (hero_id),
  PRIMARY KEY (hero_id)
) $collate;
INSERT INTO {$wpdb->prefix}heroes (hero_id, hero_name) VALUES
(11, 'Mr. Nice'),
(12, 'Narco'),
(13, 'Bombasto'),
(14, 'Celeritas'),
(15, 'Magneta'),
(16, 'RubberMan'),
(17, 'Dynama'),
(18, 'Dr IQ'),
(19, 'Magma'),
(20, 'Tornado');
		";
	}
}

S5buying_Install::init();
