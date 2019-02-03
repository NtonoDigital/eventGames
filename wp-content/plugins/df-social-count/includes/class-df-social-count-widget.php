<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register DF Social Count widget.
 */
class DFSocialCount extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		$widget_ops = array(
			'classname' => 'df-social-count-widget',
			'description' => esc_html__( 'Display social counters as a widget.', 'df-social-count' ),
		);
		$control_ops = array(
			'id_base' => 'df-social-count'
		);

		parent::__construct(
			'df-social-count',
			__( 'DF Social Count', 'df-social-count' ),
			$widget_ops, $control_ops
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		echo $args['before_widget'];

		echo DF_Social_Count_View::get_view();

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
	?>
		<p class="help">
		<?php printf( __( 'You can edit your social counters in the <a href="%s">DF Social Count settings</a>.', 'df-social-count' ), admin_url( 'options-general.php?page=df-social-count' ) ); ?>
			</p>
	<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		
		return $instance;
	}
}
