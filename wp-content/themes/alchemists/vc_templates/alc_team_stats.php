<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $team_id
 * @var $league_table_id
 * @var $values
 * @var $el_class
 * @var $el_id
 * @var $css
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Alc_Team_Stats
 */

$title = $team_id = $league_table_id = $values = $el_class = $el_id = $css = $css_animation = '';

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$class_to_filter = 'widget card card--has-table widget-team-stats';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

$values = (array) vc_param_group_parse_atts( $values );
$values_array = array();
foreach ($values as $data) {
	$new_stat = $data;
	$new_stat['stat_heading'] = isset( $data['stat_heading'] ) ? $data['stat_heading'] : '';
	$new_stat['stat_value'] = isset( $data['stat_value'] ) ? $data['stat_value'] : '';
	$new_stat['stat_icon'] = isset( $data['stat_icon'] ) ? $data['stat_icon'] : '';
	$new_stat['stat_icon_symbol'] = isset( $data['stat_icon_symbol'] ) ? $data['stat_icon_symbol'] : '';

	$values_array[] = $new_stat;
}

// Check if we're on Single Team page and Team is not selected
if ( is_singular('sp_team') && $team_id == 'default' ) {
	if ( ! isset( $id ) ) {
		$id = get_the_ID();
	}
} else {
	$id = intval($team_id);
}

// Select the Team
$team = new SP_Team( $id );
$tables = $team->tables();
$table_id = intval($league_table_id);

// Jump into League Table data
$table = new SP_League_Table( $table_id );
$data = $table->data();

// Remove the first row to leave us with the actual data
unset( $data[0] );

// Style depends on selected sport
$stats_table_classes = array( 'team-stats-box' );

if ( alchemists_sp_preset( 'football' ) ) {
	$stats_table_classes[] = 'team-stats-box--cell-bg';
}

// selected sport
$sp_preset_name = 'default';
if ( alchemists_sp_preset( 'soccer' ) ) {
	$sp_preset_name = 'soccer';
} elseif ( alchemists_sp_preset( 'football' ) ) {
	$sp_preset_name = 'football';
}
?>

<!-- Widget: Team Stats -->
<div <?php echo implode( ' ', $wrapper_attributes ); ?> class="<?php echo esc_attr( apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->settings['base'], $atts ) ); ?>">
	<?php if ( $title ) { ?>
		<div class="widget__title card__header">
			<?php echo wpb_widget_title( array( 'title' => $title ) ) ?>
		</div>
	<?php } ?>
	<div class="widget__content card__content">
		<ul class="<?php echo esc_attr( implode( ' ', $stats_table_classes ) ); ?>">
			<?php
			if ( ! empty($values_array)) {
				foreach ( $values_array as $stat_item ) {
					if ( ! empty( $stat_item['stat_value'] ) ) {

						// values
						$stats = get_post( $stat_item['stat_value'] );
						$stat = $stats->post_name;

						if ( isset( $data[ $id ][ $stat ] ) ) {

							$stat_value = strip_tags( $data[ $id ][ $stat ]);

							// label
							$stat_label = $stat_item['stat_heading'];

							// icon
							$stat_icon = $stat_item['stat_icon'];


							include( locate_template( 'vc_templates/alc_team_stats/alc_team_stat-' . $sp_preset_name . '.php' ) );

						}

					}
				}
			}
			?>
		</ul>
	</div>
</div>
<!-- Widget: Team Stats / End -->
