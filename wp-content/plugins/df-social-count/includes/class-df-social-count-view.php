<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus View.
 *
 * @package  DF_Social_Count/View
 * @category View
 * @author   Dan Fisher
 */
class DF_Social_Count_View {

	/**
	 * Get view model.
	 *
	 * @param  int $model
	 *
	 * @return string
	 */
	public static function get_view_model( $model ) {
		$models = array(
			'default',
			'columns',
			'grid'
		);

		return isset( $models[ $model ] ) ? $models[ $model ] : 'default';
	}

	/**
	 * Widget view.
	 *
	 * @return string
	 */
	public static function get_view() {
		wp_enqueue_style( 'df-social-count' );

		$settings = get_option( 'dfsocialcount_settings' );
		$design   = get_option( 'dfsocialcount_design' );
		$count    = DF_Social_Count_Generator::get_count();
		$icons    = isset( $design['icons'] ) ? array_map( 'sanitize_key', explode( ',', $design['icons'] ) ) : array();
		$style    = self::get_view_model( $design['models'] );

		$html = '<div class="df-social-count df-social-count--' . $style . '">';

			foreach ( $icons as $icon ) {
				$class = 'DF_Social_Count_' . $icon . '_counter';

				if ( ! isset( $count[ $icon ] ) ) {
					continue;
				}

				$total = apply_filters( 'DF_Social_Count_number_format', $count[ $icon ] );

				if ( class_exists( $class ) ) {
					$_class = new $class();
					$html  .= $_class->get_view( $settings, $total );
				} else {
					$html .= apply_filters( 'DF_Social_Count_' . $icon . 'html_counter', '', $settings, $total );
				}
			}

		$html .= '</div>';

		return $html;
	}
}
