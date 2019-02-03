<?php
/**
 * Player Radar Graph Statistics for Single Player
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   3.0.3
 */

// Skip if there are no rows in the table
if ( empty( $data ) ) {
	return;
}

unset( $data[0] );

if ( isset( $data[-1] )) {
	$data = $data[-1]; // Get Total array
}

wp_enqueue_script( 'alchemists-chartjs' );

// Theme Options
$alchemists_data           = get_option( 'alchemists_data' );
$color_primary             = isset( $alchemists_data['color-primary'] ) ? $alchemists_data['color-primary'] : '#ffdc11';
$color_primary_radar       = hex2rgba( $color_primary, 0.8 );
$radar_enable              = isset( $alchemists_data['alchemists__player-title-radar'] ) ? $alchemists_data['alchemists__player-title-radar'] : 0;
$radar_performances_custom = isset( $alchemists_data['alchemists__player-title-radar-custom'] ) ? $alchemists_data['alchemists__player-title-radar-custom'] : array();

$radar_performances_custom_array = array();
if ( $radar_performances_custom ) {
	foreach ( $radar_performances_custom as $radar_performance_key => $radar_performance_value) {
		$radar_performances_custom_array[ get_post_field( 'post_name', $radar_performances_custom[$radar_performance_key] ) ] = get_post_field( 'post_title', $radar_performances_custom[$radar_performance_key] );
	}
}

$radar_stats_defaults = array(
	'basketball' => array(
		'off'     => esc_html( 'OFF', 'alchemists' ),
		'ast'     => esc_html( 'AST', 'alchemists' ),
		'threepm' => esc_html( '3PT', 'alchemists' ),
		'fgm'     => esc_html( 'FGM', 'alchemists' ),
		'def'     => esc_html( 'DEF', 'alchemists' ),
	)
);

$radar_stats = array();
if ( alchemists_sp_preset( 'basketball' ) ) {
	$radar_stats = $radar_stats_defaults['basketball'];
}

if ( $radar_enable && $radar_performances_custom_array ) {
	$radar_stats = $radar_performances_custom_array;
}

// get stats labels
$radar_stats_labels = '"' . implode( '", "', $radar_stats ) . '"';

// get stats values
$radar_stats_output = array();
foreach ( $radar_stats as $radar_stat_key => $radar_stat_value ) {
	if ( isset( $data[ $radar_stat_key ] ) ) {
		$radar_stats_output[ $radar_stat_key ] = apply_filters( 'alc_player_statistics_radar_value', $data[ $radar_stat_key ] );
	}
}
$radar_stats_values = array();
$radar_stats_values = implode( ', ', $radar_stats_output );
?>

<div class="player-info__item player-info__item--stats">
	<canvas id="player-stats" class="player-info-chart" height="290"></canvas>

	<script type="text/javascript">
		(function($){
			$(document).on('ready', function() {
				var radar_data = {
					type: 'radar',
					data: {
						labels: [ <?php echo $radar_stats_labels; ?> ],
						datasets: [{
							data: [ <?php echo $radar_stats_values; ?> ],
							backgroundColor: "<?php echo esc_html( $color_primary_radar ); ?>",
							borderColor: "<?php echo esc_html( $color_primary ); ?>",
							pointBorderColor: "rgba(255,255,255,0)",
							pointBackgroundColor: "rgba(255,255,255,0)",
							pointBorderWidth: 0
						}]
					},
					options: {
						legend: {
							display: false,
						},
						tooltips: {
							backgroundColor: "rgba(49,64,75,0.8)",
							titleFontSize: 10,
							titleSpacing: 2,
							titleMarginBottom: 4,
							bodyFontFamily: 'Montserrat, sans-serif',
							bodyFontSize: 9,
							bodySpacing: 0,
							cornerRadius: 2,
							xPadding: 10,
							displayColors: false,
						},
						scale: {
							angleLines: {
								color: "rgba(255,255,255,0.025)",
							},
							pointLabels: {
								fontColor: "#9a9da2",
								fontFamily: 'Montserrat, sans-serif',
							},
							ticks: {
								beginAtZero: true,
								display: false,
							},
							gridLines: {
								color: "rgba(255,255,255,0.05)",
								lineWidth: 2,
							},
							labels: {
								display: false
							}
						}
					},
				};

				var ctx = $("#player-stats");
				var playerInfo = new Chart(ctx, radar_data);
			});
		})(jQuery);

	</script>
</div>
