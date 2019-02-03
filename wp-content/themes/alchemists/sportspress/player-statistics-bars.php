<?php
/**
 * Player Percentage Statistics for Single Player
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @version   1.0.0
 * @version   3.0.3
 */

// Skip if there are no rows in the table
if ( empty( $data ) ) {
	return;
}

unset( $data[0] );
$data = $data[-1]; // Get Total array

// Theme Options
$alchemists_data   = get_option('alchemists_data');
$color_primary     = isset( $alchemists_data['color-primary'] ) ? $alchemists_data['color-primary'] : '#ffdc11';
$bars_enable       = isset( $alchemists_data['alchemists__player-title-progress-bars'] ) ? $alchemists_data['alchemists__player-title-progress-bars'] : 0;
$bars_stats_custom = isset( $alchemists_data['alchemists__player-title-progress-bars-custom'] ) ? $alchemists_data['alchemists__player-title-progress-bars-custom'] : array();

$bars_stats_custom_array = array();
if ( $bars_stats_custom ) {
	foreach ( $bars_stats_custom as $bars_stat_key => $bars_stat_value) {
		$bars_stats_custom_array[ get_post_field( 'post_name', $bars_stats_custom[ $bars_stat_key ] ) ] = get_post_field( 'post_excerpt', $bars_stats_custom[ $bars_stat_key ] );
	}
}

// Get Player Statistics posts
$statistics = get_posts( array(
	'post_type'      => 'sp_statistic',
	'posts_per_page' => 9999
));

// New array based on Player Statistics posts
$statistic_array = array();
if( $statistics ){
	foreach( $statistics as $statistic ){
		$statistic_array[ $statistic->post_name ] = $statistic->post_excerpt;
	}
}

$bars_stats_defaults = array(
	'soccer' => array(
		'winratio',
		'shpercent',
		'passpercent',
		'perf',
		'penpercent',
	),
	'football' => array(
		'cmppercent',
		'tdpercent',
		'eventsplayedpercent',
		'fgpercent',
	)
);

$bars_stats = array();
if ( alchemists_sp_preset( 'soccer' ) ) {
	$bars_stats = alchemists_sp_filter_array( $statistic_array, $bars_stats_defaults['soccer'] );
} else if ( alchemists_sp_preset( 'football' ) ) {
	$bars_stats = alchemists_sp_filter_array( $statistic_array, $bars_stats_defaults['football'] );
}

if ( $bars_enable && $bars_stats_custom ) {
	$bars_stats = $bars_stats_custom_array;
}

$progress_classes = array(
	'progress',
);
$progress_bar_classes = array(
	'progress__bar',
);

// Specifies elements depends on selected sport
if ( alchemists_sp_preset( 'soccer') ) {
	// progress bar types
	$progress_bar_classes[] = 'progress__bar--success';
} elseif ( alchemists_sp_preset( 'football') )  {
	// progress bar classes
	$progress_classes[] = 'progress--battery';
}

// echo '<pre>' . var_export( $alchemists_data, true ) . '</pre>';
?>

<!-- Player Stats -->
<div class="player-info__item player-info__item--stats">
	<div class="player-info__item--stats-inner">

		<?php foreach ( $bars_stats as $bars_stat_key => $bars_stat_value ) :

			$excerpt = $bars_stat_value;
			$value   = $data[ $bars_stat_key ];

			if ( $value > 10) {
				$value = round( $value, 0 );
			}
			?>
			<!-- Progress: <?php echo esc_html( $excerpt ); ?> -->
			<div class="progress-stats progress-stats--top-labels">
				<div class="progress__label"><?php echo esc_html( $excerpt ); ?></div>
				<div class="<?php echo esc_attr( implode( ' ', $progress_classes ) ); ?>">
					<div class="<?php echo esc_attr( implode( ' ', $progress_bar_classes ) ); ?>" role="progressbar" aria-valuenow="<?php echo esc_attr( $value ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $value ); ?>%"></div>
				</div>
				<div class="progress__number"><?php echo esc_attr( $value ); ?>%</div>
			</div>
			<!-- Progress: <?php echo esc_html( $excerpt ); ?> / End -->

		<?php endforeach; ?>

	</div>
</div>
<!-- Player Stats / End -->
