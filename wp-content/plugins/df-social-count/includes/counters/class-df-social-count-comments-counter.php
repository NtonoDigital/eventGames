<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus Comments Counter.
 *
 * @package  DF_Social_Count/Comments_Counter
 * @category Counter
 * @author   Dan Fisher
 */
class DF_Social_Count_Comments_Counter extends DF_Social_Count_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'comments';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = '';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return ( isset( $settings['comments_active'] ) );
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
			$data = wp_count_comments();

			if ( is_wp_error( $data ) ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$count = intval( $data->approved );

				$this->total = $count;
			}
		}

		return $this->total;
	}

	/**
	 * Get conter view.
	 *
	 * @param  array  $settings   Plugin settings.
	 * @param  int    $total      Counter total.
	 * @param  string $text_color Text color.
	 *
	 * @return string
	 */
	public function get_view( $settings, $total ) {
		$url          = ! empty( $settings['comments_url'] ) ? $settings['comments_url'] : get_home_url();
		$comments_txt = ! empty( $settings['comments_txt'] ) ? $settings['comments_txt'] : __( 'Comments', 'df-social-count' );

		unset( $settings['target_blank'] );

		return $this->get_view_item( $url, $total, __( 'comments', 'df-social-count' ), $comments_txt, $settings );
	}
}
