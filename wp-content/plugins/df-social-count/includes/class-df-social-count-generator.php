<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * DF Social Count Generator.
 *
 * @package  DF_Social_Count/Generator
 * @category Generator
 * @author   Dan Fisher
 */
class DF_Social_Count_Generator {

	/**
	 * Transient name.
	 *
	 * @var string
	 */
	public static $transient = 'dfsocialcount_counter';

	/**
	 * Cache option name.
	 *
	 * @var string
	 */
	public static $cache = 'dfsocialcount_cache';

	/**
	 * Update the counters.
	 *
	 * @return array
	 */
	public static function get_count() {
		// Get transient.
		$total = get_transient( self::$transient );

		// Test transient if exist.
		if ( false != $total ) {
			return $total;
		}

		$total    = array();
		$settings = get_option( 'dfsocialcount_settings' );
		$cache    = get_option( self::$cache );
		$counters = apply_filters( 'DF_Social_Count_counters', array(
			'DF_Social_Count_Comments_Counter',
			'DF_Social_Count_Facebook_Counter',
			'DF_Social_Count_GitHub_Counter',
			'DF_Social_Count_GooglePlus_Counter',
			'DF_Social_Count_Instagram_Counter',
			'DF_Social_Count_Pinterest_Counter',
			'DF_Social_Count_Posts_Counter',
			'DF_Social_Count_Steam_Counter',
			'DF_Social_Count_Tumblr_Counter',
			'DF_Social_Count_Twitch_Counter',
			'DF_Social_Count_Twitter_Counter',
			'DF_Social_Count_Users_Counter',
			'DF_Social_Count_Vimeo_Counter',
			'DF_Social_Count_YouTube_Counter',
		) );

		foreach ( $counters as $counter ) {
			$_counter = new $counter();
			$total[ $_counter->id ] = $_counter->get_total( $settings, $cache );
		}

		// Update plugin extra cache.
		update_option( self::$cache, $total );

		// Update counter transient.
		set_transient( self::$transient, $total, apply_filters( 'df_social_count_transient_time', 60*60*24 ) ); // 24 hours.

		return $total;
	}

	/**
	 * Delete the counters.
	 */
	public static function delete_count() {
		delete_transient( self::$transient );
	}

	/**
	 * Reset the counters.
	 */
	public static function reset_count() {
		self::delete_count();
		self::get_count();
	}
}
