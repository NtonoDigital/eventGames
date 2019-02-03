<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * DF Social Count Users Counter.
 *
 * @package  DF_Social_Count/Users_Counter
 * @category Counter
 * @author   Dan Fisher
 */
class DF_Social_Count_Users_Counter extends DF_Social_Count_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'users';

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
		return isset( $settings['users_active'] ) && ! empty( $settings['users_user_role'] );
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
			$users = count_users();

			if ( 'all' == $settings['users_user_role'] ) {
				$this->total = intval( $users['total_users'] );
			} else if ( ! empty( $users['avail_roles'][ $settings['users_user_role'] ] ) ) {
				$this->total = intval( $users['avail_roles'][ $settings['users_user_role'] ] );
			} else {
				$this->total = 0;
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
		$url       = ! empty( $settings['users_url'] ) ? $settings['users_url'] : get_home_url();
		$label     = ! empty( $settings['users_label'] ) ? $settings['users_label'] : __( 'users', 'df-social-count' );
		$users_txt = ! empty( $settings['users_txt'] ) ? $settings['users_txt'] : __( 'Users', 'df-social-count' );

		unset( $settings['target_blank'] );

		return $this->get_view_item( $url, $total, $label, $users_txt, $settings );
	}
}
