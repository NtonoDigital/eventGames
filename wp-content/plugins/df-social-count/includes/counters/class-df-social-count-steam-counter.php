<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * DF Social Count Steam Counter.
 *
 * @package  DF_Social_Count/Steam_Counter
 * @category Counter
 * @author   Dan Fisher
 */
class DF_Social_Count_Steam_Counter extends DF_Social_Count_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'steam';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://steamcommunity.com/groups/';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return isset( $settings['steam_active'] ) && ! empty( $settings['steam_group_name'] );
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
			$this->connection = wp_remote_get( $this->api_url . $settings['steam_group_name'] . '/memberslistxml/?xml=1', array( 'timeout' => 60 ) );

			if ( is_wp_error( $this->connection ) || '400' <= $this->connection['response']['code'] ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				try {
					$xml = @new SimpleXmlElement( $this->connection['body'], LIBXML_NOCDATA );
					$count = intval( $xml->groupDetails->memberCount );

					$this->total = $count;
				} catch ( Exception $e ) {
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
		$steam_group_name = ! empty( $settings['steam_group_name'] ) ? $settings['steam_group_name'] : '';
		$steam_txt        = ! empty( $settings['steam_txt'] ) ? $settings['steam_txt'] : __( 'Steam', 'df-social-count' );

		return $this->get_view_item( 'https://steamcommunity.com/groups/' . $steam_group_name, $total, __( 'members', 'df-social-count' ), $steam_txt, $settings );
	}
}
