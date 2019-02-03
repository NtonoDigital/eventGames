<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * DF Social Count Plus Google+ Counter.
 *
 * @package  DF_Social_Count/GooglePlus_Counter
 * @category Counter
 * @author   Dan Fisher
 */
class DF_Social_Count_GooglePlus_Counter extends DF_Social_Count_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'googleplus';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://www.googleapis.com/plus/v1/people/';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return ( isset( $settings['googleplus_active'] ) && ! empty( $settings['googleplus_id'] ) && ! empty( $settings['googleplus_api_key'] ) );
	}

	/**
	 * Get the total.
	 *
	 * @param  array $settings Plugin settings.
	 * @param  array $cache    Counter cache.
	 *
	 * @return int
	 */
	public function get_total( $settings, $cache ) {
		if ( $this->is_available( $settings ) ) {
			$this->connection = wp_remote_get( $this->api_url . $settings['googleplus_id'] . '?key=' . $settings['googleplus_api_key'], array( 'timeout' => 60 ) );

			if ( is_wp_error( $this->connection ) || '400' <= $this->connection['response']['code'] ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$_data = json_decode( $this->connection['body'], true );

				if ( isset( $_data['circledByCount'] ) ) {
					$count = intval( $_data['circledByCount'] );

					$this->total = $count;
				} else {
					$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
				}
			}
		}

		return $this->total;
	}

	/**
	 * Get conter view.
	 *
	 * @param  array  $settings   Plugin settings.
	 * @param  int    $total      Counter total.
	 *
	 * @return string
	 */
	public function get_view( $settings, $total ) {
		$googleplus_id  = ! empty( $settings['googleplus_id'] ) ? $settings['googleplus_id'] : '';
		$googleplus_txt = ! empty( $settings['googleplus_txt'] ) ? $settings['googleplus_txt'] : __( 'Google+', 'df-social-count' );

		return $this->get_view_item( 'https://plus.google.com/' . $googleplus_id, $total, __( 'followers', 'df-social-count' ), $googleplus_txt, $settings );
	}
}
