<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * DF Social Count Twitch Counter.
 *
 * @package  DF_Social_Count/Twitch_Counter
 * @category Counter
 * @author   Dan Fisher
 */
class DF_Social_Count_Twitch_Counter extends DF_Social_Count_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'twitch';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://api.twitch.tv/kraken/channels/';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return isset( $settings['twitch_active'] ) && ! empty( $settings['twitch_username'] ) && ! empty( $settings['twitch_client_ID'] );
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
			$params = array(
				'timeout' => 60,
			);

			$this->connection = wp_remote_get( esc_url_raw( $this->api_url . $settings['twitch_username'] . '?client_id=' . $settings['twitch_client_ID'] ), $params );

			if ( is_wp_error( $this->connection ) || ( isset( $this->connection['response']['code'] ) && 200 != $this->connection['response']['code'] ) ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$_data = json_decode( $this->connection['body'], true );

				if ( isset( $_data['followers'] ) ) {
					$count = intval( $_data['followers'] );

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
		$twitch_username = ! empty( $settings['twitch_username'] ) ? $settings['twitch_username'] : '';
		$twitch_txt      = ! empty( $settings['twitch_txt'] ) ? $settings['twitch_txt'] : __( 'Twitch', 'df-social-count' );

		return $this->get_view_item( 'http://www.twitch.tv/' . $twitch_username . '/profile', $total, __( 'followers', 'df-social-count' ), $twitch_txt, $settings );
	}
}
