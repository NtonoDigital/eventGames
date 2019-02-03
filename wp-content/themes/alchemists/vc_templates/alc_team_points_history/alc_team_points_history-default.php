<?php
/**
 * The template for displaying ALC: Team Points History (Basketball)
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   3.0.8
 */

// Create a unique identifier based on the current time in microseconds
$identifier = uniqid( 'points-history-' );
?>

<?php if ( $title ) { ?>
	<div class="widget__title card__header">
		<?php echo wpb_widget_title( array( 'title' => $title ) ) ?>
	</div>
<?php } ?>
<div class="card__content">
	<canvas id="<?php echo esc_attr( $identifier ); ?>" class="points-history-chart" height="135"></canvas>

	<script type="text/javascript">
		(function($){
			$(document).on('ready', function() {
				var data = {
					type: 'line',
					data: {
						labels: [<?php print_r( $dates_by_event); ?>],
						datasets: [{
							label: "<?php esc_html_e( 'POINTS', 'alchemists' ); ?>",
							fill: false,
							lineTension: 0,
							backgroundColor: "<?php echo esc_js( $chart_line_color ); ?>",
							borderWidth: 2,
							borderColor: "<?php echo esc_js( $chart_line_color ); ?>",
							borderCapStyle: 'butt',
							borderDashOffset: 0.0,
							borderJoinStyle: 'bevel',
							pointRadius: 0,
							pointBorderWidth: 0,
							pointHoverRadius: 5,
							pointHoverBackgroundColor: "#fff",
							pointHoverBorderColor: "<?php echo esc_js( $chart_point_color ); ?>",
							pointHoverBorderWidth: 5,
							pointHitRadius: 10,
							data: [<?php echo esc_js( $results_by_event ); ?>],
							spanGaps: false,
						}]
					},
					options: {
						legend: {
							display: false,
							labels: {
								boxWidth: 8,
								fontSize: 9,
								fontColor: '#31404b',
								fontFamily: 'Montserrat, sans-serif',
								padding: 20,
							}
						},
						tooltips: {
							backgroundColor: "rgba(49,64,75,0.8)",
							titleFontSize: 0,
							titleSpacing: 0,
							titleMarginBottom: 0,
							bodyFontFamily: 'Montserrat, sans-serif',
							bodyFontSize: 9,
							bodySpacing: 0,
							cornerRadius: 2,
							xPadding: 10,
							displayColors: false,
						},
						scales: {
							xAxes: [{
								gridLines: {
									color: "#e4e7ed",
								},
								ticks: {
									fontColor: '#9a9da2',
									fontFamily: 'Montserrat, sans-serif',
									fontSize: 10,
								},
							}],
							yAxes: [{
								gridLines: {
									display:false,
									color: "rgba(255,255,255,0)",
								},
								ticks: {
									beginAtZero: true,
									fontColor: '#9a9da2',
									fontFamily: 'Montserrat, sans-serif',
									fontSize: 10,
									padding: 20
								}
							}]
						}
					},
				};

				var ctx = $('#<?php echo esc_js( $identifier ); ?>');
				var gamesHistory = new Chart(ctx, data);
			});
		})(jQuery);

	</script>
</div>
