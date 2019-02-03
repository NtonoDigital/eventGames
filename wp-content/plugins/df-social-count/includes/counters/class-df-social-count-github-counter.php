<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * DF Social Count GitHub Counter.
 *
 * @package  DF_Social_Count/GitHub_Counter
 * @category Counter
 * @author   Dan Fisher
 */
class DF_Social_Count_GitHub_Counter extends DF_Social_Count_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'github';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://api.github.com/users/';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return isset( $settings['github_active'] ) && ! empty( $settings['github_username'] );
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
			$this->connection = wp_remote_get( $this->api_url . sanitize_text_field( $settings['github_username'] ), array( 'timeout' => 60 ) );

			if ( is_wp_error( $this->connection ) || 200 != $this->connection['response']['code'] ) {
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
		$github_username = ! empty( $settings['github_username'] ) ? $settings['github_username'] : '';
		$github_txt      = ! empty( $settings['github_txt'] ) ? $settings['github_txt'] : __( 'GitHub', 'df-social-count' );

		return $this->get_view_item( 'https://github.com/' . $github_username, $total, __( 'followers', 'df-social-count' ), $github_txt, $settings );
	}
}
