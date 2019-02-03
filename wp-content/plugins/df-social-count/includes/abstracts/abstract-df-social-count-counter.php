<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * DF Social Count Counter.
 *
 * @package  DF_Social_Count/Abstracts
 * @category Abstract
 * @author   Dan Fisher
 */
abstract class DF_Social_Count_Counter {

	/**
	 * Total count.
	 *
	 * @var int
	 */
	protected $total = 0;

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = '';

	/**
	 * Connection.
	 *
	 * @var WP_Error|array
	 */
	protected $connection = array();

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return false;
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
		return $this->total;
	}

	/**
	 * Get the li element.
	 *
	 * @param  string $url      Item url.
	 * @param  int    $count    Item count.
	 * @param  string $label    Item label.
	 * @param  string $text     Item text.
	 * @param  array  $settings Item settings.
	 *
	 * @return string           HTML item element.
	 */
	protected function get_view_item( $url, $count, $label, $text, $settings ) {
		$target_blank = isset( $settings['target_blank'] ) ? ' target="_blank"' : '';
		$styles       = '';

		$count = dfsocial_format_number( $count );

		$html = sprintf( '<a class="btn-social-counter btn-social-counter--%s" href="%s" rel="nofollow noopener noreferrer" %s>', $this->id, esc_url( $url ), $target_blank );
			$html .= '<div class="btn-social-counter__icon">';
				$html .= '<i class="fa fa-' . $this->id . '"></i>';
			$html .= '</div>';
			$html .= sprintf( '<h6 class="btn-social-counter__title"%s>%s</h6>', $styles, apply_filters( 'DF_Social_Count_label', $text ) );
			$html .= sprintf( '<span class="btn-social-counter__count"%s><span class="btn-social-counter__count-num">%s</span> %s</span>', $styles, apply_filters( 'DF_Social_Count_number_format', $count ), $label );
			$html .= '<span class="btn-social-counter__add-icon"></span>';
		$html .= '</a>';

		return apply_filters( 'df_social_count_get_view_item', $html, $url, $count, $label, $text, $settings, $this->id );
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
		return '';
	}

	/**
	 * Debug.
	 *
	 * @return array
	 */
	public function debug() {
		return $this->connection;
	}
}
