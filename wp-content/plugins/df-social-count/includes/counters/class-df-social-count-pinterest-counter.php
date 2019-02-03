<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * DF Social Count Pinterest Counter.
 *
 * @package  DF_Social_Count/Pinterest_Counter
 * @category Counter
 * @author   Dan Fisher
 */
class DF_Social_Count_Pinterest_Counter extends DF_Social_Count_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'pinterest';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://www.pinterest.com/';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return isset( $settings['pinterest_active'] ) && ! empty( $settings['pinterest_username'] );
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
			$this->connection = wp_remote_get( $this->api_url . sanitize_text_field( $settings['pinterest_username'] ), array( 'timeout' => 60 ) );

			if ( is_wp_error( $this->connection ) ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$count = 0;

				if ( 200 == $this->connection['response']['code'] ) {
					$tags = array();
					$regex = '/property\=\"pinterestapp:followers\" name\=\"pinterestapp:followers\" content\=\"(.*?)" data-app/';
					preg_match( $regex, $this->connection['body'], $tags );

					$count = isset( $tags[1] ) ? intval( $tags[1] ) : 0;
				}

				if ( 0 < $count ) {
					$this->total = $count;
				} else {
					$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
				}

				// Just to make the system report more clear...
				$this->connection['body'] = '{"followers":' . $count . '}';
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
		$pinterest_username = ! empty( $settings['pinterest_username'] ) ? $settings['pinterest_username'] : '';
		$pinterest_txt      = ! empty( $settings['pinterest_txt'] ) ? $settings['pinterest_txt'] : __( 'Pinterest', 'df-social-count' );

		return $this->get_view_item( 'https://www.pinterest.com/' . $pinterest_username, $total, __( 'followers', 'df-social-count' ), $pinterest_txt, $settings );
	}
}
