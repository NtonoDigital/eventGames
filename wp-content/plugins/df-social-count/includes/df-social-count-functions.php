<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * All counters function.
 *
 * @return array All counts.
 */
function get_scp_all() {
	$count = DF_Social_Count_Generator::get_count();

	return $count;
}

/**
 * Get counter function.
 *
 * @param  string $counter
 *
 * @return int
 */
function get_scp_counter( $counter = '' ) {
	$count = get_scp_all();

	return isset( $count[ $counter ] ) ? $count[ $counter ] : 0;
}


/**
 * Get widget counter function.
 *
 * @return string Widget count.
 */
function get_scp_widget() {
	return DF_Social_Count_View::get_view();
}


/**
 * Format numbers to nearest thousands such as Kilos, Millions
 * @param string $number
 * @param string $precision
 * 
 * @return int
 */
function dfsocial_format_number( $number, $precision = 1 ) {
	if ( $number < 900 ) {
		// 0 - 900
		$number_format = number_format( $number, $precision );
		$suffix = '';
	} else if ( $number < 900000 ) {
		// 0.9k-850k
		$number_format = number_format( $number / 1000, $precision );
		$suffix = 'K';
	} else if ( $number < 900000000 ) {
		// 0.9m-850m
		$number_format = number_format( $number / 1000000, $precision );
		$suffix = 'M';
	}
	// Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
	// Intentionally does not affect partials, eg "1.50" -> "1.50"
	if ( $precision > 0 ) {
		$dotzero = '.' . str_repeat( '0', $precision );
		$number_format = str_replace( $dotzero, '', $number_format );
	}

	return $number_format . $suffix;
}
