<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * DF Social Count Plus Vimeo Counter.
 *
 * @package  DF_Social_Count/Vimeo_Counter
 * @category Counter
 * @author   Dan Fisher
 */
class DF_Social_Count_Vimeo_Counter extends DF_Social_Count_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'vimeo';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://vimeo.com/api/v2/channel/%s/info.json';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return isset( $settings['vimeo_active'] ) && ! empty( $settings['vimeo_channel'] );
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
			$this->connection = wp_remote_get( sprintf( $this->api_url, sanitize_text_field( $settings['vimeo_channel'] ) ), array( 'timeout' => 60 ) );

			if ( is_wp_error( $this->connection ) || 200 != $this->connection['response']['code'] ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$_data = json_decode( $this->connection['body'], true );

				if ( isset( $_data['total_subscribers'] ) ) {
					$count = intval( $_data['total_subscribers'] );

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
		$vimeo_channel = ! empty( $settings['vimeo_channel'] ) ? $settings['vimeo_channel'] : '';
		$vimeo_txt     = ! empty( $settings['vimeo_txt'] ) ? $settings['vimeo_txt'] : __( 'Vimeo', 'df-social-count' );

		return $this->get_view_item( 'https://vimeo.com/' . $vimeo_channel, $total, __( 'followers', 'df-social-count' ), $vimeo_txt, $settings );
	}
}
