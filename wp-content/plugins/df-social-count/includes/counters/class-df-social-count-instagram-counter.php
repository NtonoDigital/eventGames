<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * DF Social Count Instagram Counter.
 *
 * @package  DF_Social_Count/Instagram_Counter
 * @category Counter
 * @author   Dan Fisher
 */
class DF_Social_Count_Instagram_Counter extends DF_Social_Count_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'instagram';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://api.instagram.com/v1/users/';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return ( isset( $settings['instagram_active'] ) && ! empty( $settings['instagram_user_id'] ) && ! empty( $settings['instagram_access_token'] ) );
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
			$this->connection = wp_remote_get( $this->api_url . $settings['instagram_user_id'] . '/?access_token=' . $settings['instagram_access_token'], array( 'timeout' => 60 ) );

			if ( is_wp_error( $this->connection ) || '400' <= $this->connection['response']['code'] ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$response = json_decode( $this->connection['body'], true );

				if (
					isset( $response['meta']['code'] )
					&& 200 == $response['meta']['code']
					&& isset( $response['data']['counts']['followed_by'] )
				) {
					$count = intval( $response['data']['counts']['followed_by'] );

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
		$instagram_username = ! empty( $settings['instagram_username'] ) ? $settings['instagram_username'] : '';
		$instagram_txt      = ! empty( $settings['instagram_txt'] ) ? $settings['instagram_txt'] : __( 'Instagram', 'df-social-count' );

		return $this->get_view_item( 'https://instagram.com/' . $instagram_username, $total, __( 'followers', 'df-social-count' ), $instagram_txt, $settings );
	}
}
