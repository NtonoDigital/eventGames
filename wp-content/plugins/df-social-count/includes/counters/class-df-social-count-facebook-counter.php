<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * DF Social Count Facebook Counter.
 *
 * @package  DF_Social_Count/Facebook_Counter
 * @category Counter
 * @author   Dan Fisher
 */
class DF_Social_Count_Facebook_Counter extends DF_Social_Count_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'facebook';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://graph.facebook.com';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return isset( $settings['facebook_active'] ) && ! empty( $settings['facebook_id'] ) && ! empty( $settings['facebook_token'] );
	}

	/**
	 * Get access token.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return string
	 */
	protected function get_access_token( $settings ) {
		if ( isset( $settings['facebook_token'] ) && ! empty( $settings['facebook_token'] ) ) {
			$access_token = $settings['facebook_token'];
		} else {
			$access_token = '';
		}
		return sanitize_text_field( $access_token );
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
			$access_token = $this->get_access_token( $settings );
			$url = sprintf(
				'%s%s?fields=fan_count&access_token=%s',
				$this->api_url . '/v3.0/',
				sanitize_text_field( $settings['facebook_id'] ),
				$access_token
			);

			$this->connection = wp_remote_get( $url, array( 'timeout' => 60 ) );

			if ( is_wp_error( $this->connection ) || ( isset( $this->connection['response']['code'] ) && 200 != $this->connection['response']['code'] ) ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$_data = json_decode( $this->connection['body'], true );

				if ( isset( $_data['fan_count'] ) ) {
					$count = intval( $_data['fan_count'] );

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
		$facebook_id  = ! empty( $settings['facebook_id'] ) ? $settings['facebook_id'] : '';
		$facebook_txt = ! empty( $settings['facebook_txt'] ) ? $settings['facebook_txt'] : __( 'Facebook', 'df-social-count' );

		return $this->get_view_item( 'https://www.facebook.com/' . $facebook_id, $total, __( 'likes', 'df-social-count' ), $facebook_txt, $settings );
	}
}
