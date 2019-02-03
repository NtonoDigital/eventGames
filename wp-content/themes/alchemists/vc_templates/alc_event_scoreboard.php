<?php
/**
 * @author    Dan Fisher
 * @package   Alchemists
 * @since     1.0.0
 * @version   3.0.13
 *
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $event
 * @var $display_details
 * @var $display_percentage
 * @var $link
 * @var $color_team_1
 * @var $color_team_2
 * @var $el_class
 * @var $el_id
 * @var $css
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Alc_Event_Scoreboard
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Theme Options
$alchemists_data = get_option('alchemists_data');
$color_primary = isset( $alchemists_data['color-primary'] ) ? $alchemists_data['color-primary'] : '#ffdc11';

// Progress Bars
$event_progress_bars_stats_enable = isset( $alchemists_data['alchemists__player-sp-event-progress-bars'] ) ? $alchemists_data['alchemists__player-sp-event-progress-bars'] : 0;
$event_progress_bars_stats_custom = isset( $alchemists_data['alchemists__player-sp-event-progress-bars-custom'] ) ? $alchemists_data['alchemists__player-sp-event-progress-bars-custom'] : array();

// Circular Bars
$event_circular_bars_stats_enable = isset( $alchemists_data['alchemists__player-sp-event-circular-bars'] ) ? $alchemists_data['alchemists__player-sp-event-circular-bars'] : 0;
$event_circular_bars_stats_custom = isset( $alchemists_data['alchemists__player-sp-event-circular-bars-custom'] ) ? $alchemists_data['alchemists__player-sp-event-circular-bars-custom'] : array();
if ( alchemists_sp_preset( 'football' ) ) {
	$event_circular_bars_stats_format_default = 'number';
} else {
	$event_circular_bars_stats_format_default = 'percentage';
}
$event_circular_bars_stats_format = ( isset( $alchemists_data['alchemists__player-sp-event-circular-bars-custom-format'] ) && ! empty( $alchemists_data['alchemists__player-sp-event-circular-bars-custom-format'] ) ) ? $alchemists_data['alchemists__player-sp-event-circular-bars-custom-format'] : $event_circular_bars_stats_format_default;

// Game Stats
$event_stats_table_enable = isset( $alchemists_data['alchemists__player-sp-event-game-stats'] ) ? $alchemists_data['alchemists__player-sp-event-game-stats'] : 0;
$event_stats_table_custom = isset( $alchemists_data['alchemists__player-sp-event-game-stats-custom'] ) ? $alchemists_data['alchemists__player-sp-event-game-stats-custom'] : array();
if ( alchemists_sp_preset( 'football' ) ) {
	$event_stats_table_title_default = esc_html__( 'Matchup', 'alchemists' );
} else {
	$event_stats_table_title_default = esc_html__( 'Game Statistics', 'alchemists' );
}
$event_stats_table_title  = ( isset( $alchemists_data['alchemists__player-sp-event-game-stats-title'] ) && ! empty( $alchemists_data['alchemists__player-sp-event-game-stats-title'] ) ) ? $alchemists_data['alchemists__player-sp-event-game-stats-title'] : $event_stats_table_title_default;

// Timeline
$event_timeline_type = isset( $alchemists_data['alchemists__player-sp-event-game-timeline-type'] ) ? $alchemists_data['alchemists__player-sp-event-game-timeline-type'] : 'horizontal';

// Custom Progress Bars
$event_progress_bars_stats_custom_array = array();
$event_progress_bars_stats_custom_array = alchemists_sp_get_performances_array( $event_progress_bars_stats_custom, $event_progress_bars_stats_custom_array );

// Custom Circular Bars
$event_circular_bars_stats_custom_array = array();
$event_circular_bars_stats_custom_array = alchemists_sp_get_performances_array( $event_circular_bars_stats_custom, $event_circular_bars_stats_custom_array );

// Custom Stats Table
$event_stats_table_custom_array = array();
$event_stats_table_custom_array = alchemists_sp_get_performances_array( $event_stats_table_custom, $event_stats_table_custom_array );

// SportsPress default options
$defaults = array(
	'abbreviate_teams' => get_option( 'sportspress_abbreviate_teams', 'yes' ) === 'yes' ? true : false,
	'link_teams'       => get_option( 'sportspress_link_teams', 'no' ) == 'yes' ? true : false,
);
extract( $defaults, EXTR_SKIP );


$stats_default = array();

// Sports specifics
if ( alchemists_sp_preset( 'soccer') ) {

	// Soccer

	// Default Event Stats
	$stats_default = array(
		'progress_bars'  => array( 'sh', 'f', 'off' ),
		'event_percents' => array( 'shpercent', 'passpercent' ),
		'event_stats'    => array( 'sh', 'sog', 'ck', 's', 'yellowcards', 'redcards' )
	);

	// Stats
	$event_stats               = $stats_default['event_stats'];
	$event_progress_bars_stats = $stats_default['progress_bars'];
	$event_percents_stats      = $stats_default['event_percents'];

} elseif ( alchemists_sp_preset( 'football') ) {

	// American Football

	// Default Game Stats
	$stats_default = array(
		'progress_bars'  => array( 'att', 'yds', 'rec' ),
		'event_percents' => array( 'comp', 'recyds', 'int' ),
		'event_stats'    => array( 'yds', 'td', 'lng', 'fum', 'lost' )
	);

	// Stats
	$event_stats               = $stats_default['event_stats'];
	$event_progress_bars_stats = $stats_default['progress_bars'];
	$event_percents_stats      = $stats_default['event_percents'];

} else {

	// Basketball

	// Default Game Stats
	$stats_default = array(
		'progress_bars'  => array( 'ast', 'reb', 'stl', 'blk', 'pf' ),
		'event_percents' => array( 'fgpercent', 'threeppercent', 'ftpercent' ),
	);

	// Stats
	$event_progress_bars_stats = $stats_default['progress_bars'];
	$event_percents_stats      = $stats_default['event_percents'];
}


	// Custom Stats - Progress Bars
	if ( $event_progress_bars_stats_enable && $event_progress_bars_stats_custom_array ) {
		$event_progress_bars_stats = $event_progress_bars_stats_custom_array;
	}

	// Custom Stats - Circular Bars
	if ( $event_circular_bars_stats_enable && $event_circular_bars_stats_custom_array ) {
		$event_percents_stats = $event_circular_bars_stats_custom_array;
	}

	// Custom Stats - Stats Table
	if ( $event_stats_table_enable && $event_stats_table_custom_array ) {
		$event_stats = $event_stats_table_custom_array;
	}


// Shortcode params
$title = $event = $display_percentage = $link = $color_team_1 = $color_team_2 = $el_class = $el_id = $css = $css_animation = '';
$a_href = $a_title = $a_target = $a_rel = '';
$attributes = array();

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$class_to_filter = 'card';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

//parse link
$link = ( '||' === $link ) ? '' : $link;
$link = vc_build_link( $link );
$use_link = false;
if ( strlen( $link['url'] ) > 0 ) {
	$use_link = true;
	$a_href = $link['url'];
	$a_title = $link['title'];
	$a_target = $link['target'];
	$a_rel = $link['rel'];
}

$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

$id = '';
if ( isset( $event ) ) {
	$post = get_post( $event );
	$id = $post;
}

if ( $use_link ) {
	$attributes[] = 'href="' . trim( $a_href ) . '"';
	$attributes[] = 'title="' . esc_attr( trim( $a_title ) ) . '"';
	if ( ! empty( $a_target ) ) {
		$attributes[] = 'target="' . esc_attr( trim( $a_target ) ) . '"';
	}
	if ( ! empty( $a_rel ) ) {
		$attributes[] = 'rel="' . esc_attr( trim( $a_rel ) ) . '"';
	}
}

// 1st Team Color
$color_team_1_bar_output = '';
$color_team_1_progress_bar_output = '';
if ( $color_team_1 ) {
	$color_team_1_bar_output = 'data-bar-color=' . $color_team_1;

	if ( alchemists_sp_preset( 'football' ) ) {
		$color_team_1_progress_bar_output = 'background-image: radial-gradient(circle, ' . $color_team_1 . ', ' . $color_team_1 . ' 2px, transparent 2px, transparent), radial-gradient(circle, ' . $color_team_1 . ', ' . $color_team_1 . ' 2px, transparent 2px, transparent), linear-gradient(to right, ' . $color_team_1 . ', ' . $color_team_1 . ' 4px, transparent 4px, transparent 8px);';
	} else {
		$color_team_1_progress_bar_output = 'background-color:' . $color_team_1;
	}

} else {
	$color_team_1_bar_output = 'data-bar-color=' . $color_primary;

	if ( alchemists_sp_preset( 'football' ) ) {
		$color_team_1_progress_bar_output = 'background-image: radial-gradient(circle, ' . $color_primary . ', ' . $color_primary . ' 2px, transparent 2px, transparent), radial-gradient(circle, ' . $color_primary . ', ' . $color_primary . ' 2px, transparent 2px, transparent), linear-gradient(to right, ' . $color_primary . ', ' . $color_primary . ' 4px, transparent 4px, transparent 8px);';
	} else {
		$color_team_1_progress_bar_output = 'background-color:' . $color_primary;
	}
}

// 2nd Team Color
$color_team_2_bar_output = '';
if ( alchemists_sp_preset( 'football') ) {
	$color_team_2_bar_output = 'data-bar-color=#aaf20e';
} elseif ( alchemists_sp_preset( 'soccer') ) {
	$color_team_2_bar_output = 'data-bar-color=#9fe900';
} else {
	$color_team_2_bar_output = 'data-bar-color=#0cb2e2';
}
$color_team_2_progress_bar_output = '';
if ( $color_team_2 ) {
	$color_team_2_bar_output = 'data-bar-color=' . $color_team_2;

	if ( alchemists_sp_preset( 'football' ) ) {
		$color_team_2_progress_bar_output = 'background-image: radial-gradient(circle, ' . $color_team_2 . ', ' . $color_team_2 . ' 2px, transparent 2px, transparent), radial-gradient(circle, ' . $color_team_2 . ', ' . $color_team_2 . ' 2px, transparent 2px, transparent), linear-gradient(to right, ' . $color_team_2 . ', ' . $color_team_2 . ' 4px, transparent 4px, transparent 8px);';
	} else {
		$color_team_2_progress_bar_output = 'background-color:' . $color_team_2;
	}
}

$attributes = implode( ' ', $attributes );
?>

<!-- Game Scoreboard -->
<div <?php echo implode( ' ', $wrapper_attributes ); ?> class="<?php echo esc_attr( apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->settings['base'], $atts ) ); ?>">

	<?php if ( $title ) { ?>
		<div class="widget__title card__header">
			<?php echo wpb_widget_title( array( 'title' => $title ) ) ?>

			<?php if ( $use_link ) {
				echo '<a class="btn btn-default btn-outline btn-xs card-header__button" ' . $attributes . '>' . $a_title . '</a>';
			} ?>
		</div>
	<?php } ?>

	<div class="card__content">

		<?php if ( alchemists_sp_preset( 'soccer') ) : ?>

		<?php
		// Soccer
		$permalink      = get_post_permalink( $post, false, true );
		$results        = get_post_meta( $post->ID, 'sp_results', true );
		$primary_result = alchemists_sportspress_primary_result();
		$event_date     = $post->post_date;
		$teams          = array_unique( get_post_meta( $post->ID, 'sp_team' ) );
		$teams          = array_filter( $teams, 'sp_filter_positive' );

		$sportspress_primary_result = get_option( 'sportspress_primary_result', null );

		if( !empty( $sportspress_primary_result ) ) {
			$goals = $sportspress_primary_result;
		} else {
			$goals = 'goals';
		}

		if ( count( $teams ) > 1 ) {
			$team1 = $teams[0];
			$team2 = $teams[1];
		}

		$venue1_desc = wp_get_post_terms( $team1, 'sp_venue' );
		$venue2_desc = wp_get_post_terms( $team2, 'sp_venue' );
		?>

		<!-- Game Result -->
		<div class="game-result">

			<section class="game-result__section pt-0">
				<header class="game-result__header game-result__header--alt">
					<?php $leagues = get_the_terms( $post, 'sp_league' ); if ( $leagues ): $league = array_shift( $leagues ); ?>
						<span class="game-result__league">
							<?php echo esc_html( $league->name ); ?>

							<?php $seasons = get_the_terms( $post, 'sp_season' ); if ( $seasons ): $season = array_shift( $seasons ); ?>
								<?php echo esc_html( $season->name ); ?>
							<?php endif; ?>

						</span>
					<?php endif; ?>

					<?php
						$venues = get_the_terms( $post, 'sp_venue' );
						if ( $venues ): ?>

							<h3 class="game-result__title">
								<?php
								$venue_names = array();
								foreach ( $venues as $venue ) {
									$venue_names[] = $venue->name;
								}
								echo implode( '/', $venue_names ); ?>
							</h3>

					<?php endif; ?>

					<time class="game-result__date" datetime="<?php echo esc_attr( $event_date ); ?>"><?php echo esc_html( get_the_time( sp_date_format() . ' - ' . sp_time_format(), $post ) ); ?></time>
				</header>

				<!-- Team Logos + Game Result -->
				<div class="game-result__content">

					<?php
					$j = 0;
					foreach( $teams as $team ):
						$j++;

						echo '<div class="game-result__team game-result__team--' . ( $j % 2 ? 'odd' : 'even' ) . '">';
							echo '<figure class="game-result__team-logo">';
								if ( has_post_thumbnail ( $team ) ):
									echo get_the_post_thumbnail( $team, 'alchemists_team-logo-fit' );
								endif;
							echo '</figure>';
							echo '<div class="game-result__team-info">';
								echo '<h5 class="game-result__team-name">' . esc_html( get_the_title( $team ) ) . '</h5>';
								echo '<div class="game-result__team-desc">';
									if ( $j == 1 ) {
										if ( isset( $venue1_desc[0] )) {
											echo esc_html( $venue1_desc[0]->description );
										}
									} elseif ( $j == 2 ) {
										if ( isset( $venue2_desc[0] )) {
											echo esc_html( $venue2_desc[0]->description );
										}
									}
								echo '</div>';
							echo '</div>';
						echo '</div>';

					endforeach;
					?>

					<!-- Game Score -->
					<div class="game-result__score-wrap">
						<div class="game-result__score game-result__score--lg">

							<?php

							// 1st Team
							$team1_class = 'game-result__score-result--loser';
							if (!empty($results)) {
								if (!empty($results[$team1])) {
									if (isset($results[$team1]['outcome']) && !empty($results[$team1]['outcome'][0])) {
										if ( $results[$team1]['outcome'][0] == 'win' ) {
											$team1_class = 'game-result__score-result--winner';
										}
									}
								}
							}

							// 2nd Team
							$team2_class = 'game-result__score-result--loser';
							if (!empty($results)) {
								if (!empty($results[$team2])) {
									if (isset($results[$team2]['outcome']) && !empty($results[$team2]['outcome'][0])) {
										if ( $results[$team2]['outcome'][0] == 'win' ) {
											$team2_class = 'game-result__score-result--winner';
										}
									}
								}
							}

							?>

							<!-- 1st Team -->
							<span class="game-result__score-result <?php echo esc_attr( $team1_class ); ?>">
								<?php if (!empty($results)) {
									if (!empty($results[$team1]) && !empty($results[$team2])) {
										if (isset($results[$team1][$primary_result]) && isset($results[$team2][$primary_result])) {
											echo esc_html( $results[$team1][$primary_result] );
										}
									}
								} ?>
							</span>
							<!-- 1st Team / End -->

							<span class="game-result__score-dash">-</span>

							<!-- 2nd Team -->
							<span class="game-result__score-result <?php echo esc_attr( $team2_class ); ?>">
								<?php if (!empty($results)) {
									if (!empty($results[$team1]) && !empty($results[$team2])) {
										if (isset($results[$team1][$primary_result]) && isset($results[$team2][$primary_result])) {
											echo esc_html( $results[$team2][$primary_result] );
										}
									}
								} ?>
							</span>
							<!-- 2nd Team / End -->

						</div>
						<div class="game-result__score-label"><?php esc_html_e( 'Final Score', 'alchemists' ); ?></div>

					</div>
					<!-- Game Score / End -->

				</div>
				<!-- Team Logos + Game Result / End -->

				<?php if ( $display_details ) : ?>
					<?php if (!empty($results)) : ?>
						<?php if (!empty($results[$team1]) && !empty($results[$team2])) : ?>
							<?php if ( isset($results[$team1][$primary_result]) && isset($results[$team2][$primary_result]) ) : ?>

								<div class="spacer"></div>
								<section class="game-result__section">

									<?php // Get Performance
									$event_performance = sp_get_performance( $post );

									// Remove the first row to leave us with the actual data
									unset( $event_performance[0] );

									// Player Performance
									$performances_posts = get_posts(array(
										'post_type'      => 'sp_performance',
										'posts_per_page' => 9999,
										'orderby'        => 'menu_order',
										'order'          => 'DESC'
									));

									$performances_posts_array = array();
									if($performances_posts){
										foreach($performances_posts as $performance_post){
											$performances_posts_array[$performance_post->post_name] = array(
												'label'   => $performance_post->post_title,
												'value'   => $performance_post->post_name,
												'excerpt' => $performance_post->post_excerpt
											);
										}
										wp_reset_postdata();
									}
									?>

									<header class="game-result__header game-result__header--alt">
										<div class="game-result__header--alt__team">
											<?php alchemists_sp_player_goal_output( $goals, $event_performance[ $team1 ] ); ?>
										</div>
										<div class="game-result__header--alt__team">
											<?php alchemists_sp_player_goal_output( $goals, $event_performance[ $team2 ] ); ?>
										</div>
									</header>

									<?php
									// Stats
									$game_stats_array = alchemists_sp_filter_array( $performances_posts_array, $event_stats );
									?>

									<!-- Game Stats -->
									<div class="game-result__stats">
										<div class="row">
											<div class="col-xs-12 col-md-6 col-md-push-3 game-result__stats-scoreboard">
												<div class="game-result__table-stats game-result__table-stats--soccer">
													<div class="table-responsive">
														<table class="table table-wrap-bordered table-thead-color">
															<thead>
																<tr>
																	<th colspan="3"><?php echo esc_html( $event_stats_table_title ); ?></th>
																</tr>
															</thead>
															<tbody>
																<?php foreach ( $game_stats_array as $game_stat_key => $game_stat_excerpt ) :

																	// Event Stats
																	if (isset( $event_performance[$team1][0][$game_stat_key] ) && !empty( $event_performance[$team1][0][$game_stat_key] )) {
																		$event_team1_stat = $event_performance[$team1][0][$game_stat_key];
																	} else {
																		$event_team1_stat = 0;
																	}

																	if (isset( $event_performance[$team2][0][$game_stat_key] ) && !empty( $event_performance[$team2][0][$game_stat_key] )) {
																		$event_team2_stat = $event_performance[$team2][0][$game_stat_key];
																	} else {
																		$event_team2_stat = 0;
																	} ?>

																	<tr>
																		<td><?php echo esc_html( $event_team1_stat ); ?></td>
																		<td><?php echo esc_html( $game_stat_excerpt['excerpt'] ); ?></td>
																		<td><?php echo esc_html( $event_team2_stat ); ?></td>
																	</tr>

																<?php endforeach; ?>
															</tbody>
														</table>
													</div>
												</div>
											</div>

											<?php
											// Progress Bars
											$event_stats_array = array();
											$event_stats_array = alchemists_sp_filter_array( $performances_posts_array, $event_progress_bars_stats );

											// Accuracy
											$event_stats_percent_array = array();
											$event_stats_percent_array = alchemists_sp_filter_array( $performances_posts_array, $event_percents_stats );
											?>

											<div class="col-xs-6 col-md-3 col-md-pull-6 game-result__stats-team-1">

												<div class="row">

													<?php // 1st Team
													foreach ( $event_stats_percent_array as $event_percent_key => $event_percent_excerpt ) :

														// Performance - Value
														$event_team1_value = alchemists_check_exists_not_empty( $event_performance[ $team1 ][0][ $event_percent_key ] );
														$event_team2_value = alchemists_check_exists_not_empty( $event_performance[ $team2 ][0][ $event_percent_key ] );

														// Performance - Percent
														$event_team1_percent = alchemists_sp_get_performances_based_on_format( $event_circular_bars_stats_format, $event_team1_value, $event_team2_value );
														?>

														<div class="col-xs-6">
															<div class="circular circular--size-70">
																<div class="circular__bar" data-percent="<?php echo esc_attr( $event_team1_percent ); ?>" <?php echo esc_attr( $color_team_1_bar_output ); ?>>
																	<span class="circular__percents"><?php echo esc_html( $event_team1_value ); ?><?php echo ( $event_circular_bars_stats_format == 'percentage' ) ? '<small>%</small>' : ''; ?></span>
																</div>
																<span class="circular__label"><?php echo esc_html( $event_percent_excerpt['excerpt'] ); ?></span>
															</div>
														</div>

													<?php endforeach; ?>
												</div>

												<div class="spacer"></div>

												<?php // 1st Team
												foreach ( $event_stats_array as $event_stat_bar_key => $event_stat_bar_label ) :

													// Event Stats
													$event_team1_stat = alchemists_check_exists_not_empty( $event_performance[ $team1 ][0][ $event_stat_bar_key ] );
													$event_team2_stat = alchemists_check_exists_not_empty( $event_performance[ $team2 ][0][ $event_stat_bar_key ] );
													$event_team1_stat_pct = alchemists_sp_performance_percent( $event_team1_stat, $event_team2_stat );
													?>

													<div class="progress-stats">
														<div class="progress__label progress__label--abbr"><?php echo esc_html( $event_stat_bar_label['label'] ); ?></div>
														<div class="progress">
															<div class="progress__bar" role="progressbar" aria-valuenow="<?php echo esc_attr( $event_team1_stat_pct ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $event_team1_stat_pct ); ?>%; <?php echo esc_attr( $color_team_1_progress_bar_output ); ?>"></div>
														</div>
														<div class="progress__number progress__number--20"><?php echo esc_html( $event_team1_stat ); ?></div>
													</div>

												<?php endforeach; ?>

											</div>
											<div class="col-xs-6 col-md-3 game-result__stats-team-2">

												<div class="row">

													<?php // 2nd Team
													foreach ( $event_stats_percent_array as $event_percent_key => $event_percent_excerpt ) :

														// Performance - Value
														$event_team1_value = alchemists_check_exists_not_empty( $event_performance[ $team1 ][0][ $event_percent_key ] );
														$event_team2_value = alchemists_check_exists_not_empty( $event_performance[ $team2 ][0][ $event_percent_key ] );

														// Performance - Percent
														$event_team2_percent = alchemists_sp_get_performances_based_on_format( $event_circular_bars_stats_format, $event_team2_value, $event_team1_value );
														?>

														<div class="col-xs-6">
															<div class="circular circular--size-70">
																<div class="circular__bar" data-percent="<?php echo esc_attr( $event_team2_percent ); ?>" <?php echo esc_attr( $color_team_2_bar_output ); ?>>
																	<span class="circular__percents"><?php echo esc_html( $event_team2_value ); ?><?php echo ( $event_circular_bars_stats_format == 'percentage' ) ? '<small>%</small>' : ''; ?></span>
																</div>
																<span class="circular__label"><?php echo esc_html( $event_percent_excerpt['excerpt'] ); ?></span>
															</div>
														</div>

													<?php endforeach; ?>
												</div>

												<div class="spacer"></div>

												<?php // 2nd Team
												foreach ( $event_stats_array as $event_stat_bar_key => $event_stat_bar_label ) :

													// Event Stats
													$event_team1_stat = alchemists_check_exists_not_empty( $event_performance[ $team1 ][0][ $event_stat_bar_key ] );
													$event_team2_stat = alchemists_check_exists_not_empty( $event_performance[ $team2 ][0][ $event_stat_bar_key ] );

													$event_team2_stat_pct = alchemists_sp_performance_percent( $event_team2_stat, $event_team1_stat );
													?>


													<div class="progress-stats">
														<div class="progress__label progress__label--abbr"><?php echo esc_html( $event_stat_bar_label['label'] ); ?></div>
														<div class="progress">
															<div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="<?php echo esc_attr( $event_team2_stat_pct ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $event_team2_stat_pct ); ?>%; <?php echo esc_attr( $color_team_2_progress_bar_output ); ?>"></div>
														</div>
														<div class="progress__number progress__number--20"><?php echo esc_html( $event_team2_stat ); ?></div>
													</div>

												<?php endforeach; ?>

											</div>
										</div>
									</div>
									<!-- Game Stats / End -->

								</section>

							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
			</section>

			<?php if ( $display_percentage ) : ?>
				<?php if (!empty($results)) : ?>
					<?php if (!empty($results[$team1]) && !empty($results[$team2])) : ?>
						<?php if ( isset($results[$team1][$primary_result]) && isset($results[$team2][$primary_result]) ) : ?>
							<?php
							// ball possession fields
							$team1_poss   = isset( $results[$team1]['poss'] ) ? str_replace( '%', '', $results[$team1]['poss'] ) : '';
							$team2_poss   = isset( $results[$team2]['poss'] ) ? str_replace( '%', '', $results[$team2]['poss'] ) : '';

							if (!empty($results[$team1]['poss']) && !empty($results[$team2]['poss'])) : ?>

								<!-- Ball Possession -->
								<section class="game-result__section">
									<header class="game-result__subheader card__subheader">
										<h5 class="game-result__subtitle"><?php esc_attr_e( 'Ball Possession', 'alchemists' ); ?></h5>
									</header>
									<div class="game-result__content">

										<!-- Progress: Ball Possession -->
										<div class="progress-double-wrapper">
											<div class="spacer-sm"></div>
											<div class="progress-inner-holder">
												<div class="progress__digit progress__digit--left progress__digit--highlight"><?php echo esc_html( $team1_poss ); ?>%</div>
												<div class="progress__double">
													<div class="progress progress--lg">
														<div class="progress__bar" role="progressbar" aria-valuenow="<?php echo esc_attr( $team1_poss ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $team1_poss ); ?>%; <?php echo esc_attr( $color_team_1_progress_bar_output ); ?>"></div>
													</div>
													<div class="progress progress--lg">
														<div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="<?php echo esc_attr( $team2_poss ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $team2_poss ); ?>%; <?php echo esc_attr( $color_team_2_progress_bar_output ); ?>"></div>
													</div>
												</div>
												<div class="progress__digit progress__digit--right progress__digit--highlight"><?php echo esc_html( $team2_poss ); ?>%</div>
											</div>
										</div>
										<!-- Progress: Ball Possession / End -->

									</div>
								</section>
								<!-- Ball Possession / End -->

							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>

				<?php // Game Timeline
				if ( ! empty( $results ) ) :
					if ( ! empty( $results[ $team1 ] ) && ! empty( $results[ $team2 ] ) ) :

						// Get linear timeline from event
						$event = new SP_Event( $id );
						$timeline = $event->timeline( false, true );

						// Return if timeline is empty
						if ( !empty( $timeline ) ) :

							// Get full time of event
							$event_minutes = $event->minutes();

							// Initialize spacer
							$previous = 0;
							?>

							<!-- Game Timeline -->
							<section class="game-result__section">
								<header class="game-result__subheader card__subheader">
									<h5 class="game-result__subtitle"><?php esc_html_e( 'Game Timeline', 'alchemists' ); ?></h5>
								</header>
								<div class="game-result__content game-result__content--block game-result__content--visible mb-0">

									<?php include( locate_template( 'sportspress/event/alc-event-timeline-' . $event_timeline_type . '.php' ) ); ?>

									<div class="spacer-sm"></div>

									<div class="game-result__section-decor"></div>

								</div>
							</section>
						<?php endif; ?>

					<?php endif; ?>
				<?php endif; ?>

			<?php endif; ?>


		</div>
		<!-- Game Result / End -->

		<?php // American Football
		elseif ( alchemists_sp_preset( 'football' ) ) : ?>

		<!-- Game Result -->
		<div class="game-result">
		<?php
		$permalink      = get_post_permalink( $post, false, true );
		$results        = get_post_meta( $post->ID, 'sp_results', true );
		$primary_result = alchemists_sportspress_primary_result();
		$teams          = array_unique( get_post_meta( $post->ID, 'sp_team' ) );
		$teams          = array_filter( $teams, 'sp_filter_positive' );
		$event_date     = $post->post_date;

		$sportspress_primary_result = get_option( 'sportspress_primary_result', null );

		if ( count( $teams ) > 1 ) {
			$team1 = $teams[0];
			$team2 = $teams[1];
		}

		$venue1_desc = wp_get_post_terms($team1, 'sp_venue');
		$venue2_desc = wp_get_post_terms($team2, 'sp_venue');

		$show_stats = '';
		if (!empty($results)) :
			if (!empty($results[$team1]) && !empty($results[$team2])) :
				if ( isset($results[$team1]['outcome']) && isset($results[$team2]['outcome']) ) :
					$show_stats = true;
				endif;
			endif;
		endif;
		?>

			<section class="game-result__section pt-0">
				<header class="game-result__header game-result__header--alt">

					<?php $leagues = get_the_terms( $id, 'sp_league' ); if ( $leagues ): $league = array_shift( $leagues ); ?>
						<span class="game-result__league">
							<?php echo esc_html( $league->name ); ?>

							<?php $seasons = get_the_terms( $id, 'sp_season' ); if ( $seasons ): $season = array_shift( $seasons ); ?>
								<?php echo esc_html( $season->name ); ?>
							<?php endif; ?>

						</span>
					<?php endif; ?>

					<?php
						$venues = get_the_terms( $id, 'sp_venue' );
						if ( $venues ): ?>

							<h3 class="game-result__title">
								<?php
								$venue_names = array();
								foreach ( $venues as $venue ) {
									$venue_names[] = $venue->name;
								}
								echo implode( '/', $venue_names ); ?>
							</h3>

					<?php endif; ?>

					<time class="game-result__date" datetime="<?php echo esc_attr( $event_date ); ?>">
						<?php echo esc_html( get_the_time( sp_date_format(), $post ) ); ?>
					</time>

				</header>

				<!-- Team Logos + Game Result -->
				<div class="game-result__content">
					<?php
					$j = 0;
					foreach( $teams as $team ):
						$j++;

						echo '<div class="game-result__team game-result__team--' . ( $j % 2 ? 'odd' : 'even' ) . '">';
							echo '<figure class="game-result__team-logo">';
								if ( has_post_thumbnail ( $team ) ):

									if ( $link_teams ) :
										echo '<a href="' . get_permalink( $team, false, true ) . '" title="' . get_the_title( $team ) . '">';
											echo get_the_post_thumbnail( $team, 'alchemists_team-logo-sm-fit' );
										echo '</a>';
									else:
										echo get_the_post_thumbnail( $team, 'alchemists_team-logo-sm-fit' );
									endif;
								endif;

							echo '</figure>';

							echo '<div class="game-result__team-info">';
								echo '<h5 class="game-result__team-name">' . esc_html( get_the_title( $team ) ) . '</h5>';
								echo '<div class="game-result__team-desc">';
									if ( $j == 1 ) {
										if ( isset( $venue1_desc[0] )) {
											echo esc_html( $venue1_desc[0]->description );
										}
									} elseif ( $j == 2 ) {
										if ( isset( $venue2_desc[0] )) {
											echo esc_html( $venue2_desc[0]->description );
										}
									}
								echo '</div>';
							echo '</div>';
						echo '</div>';

					endforeach;
					?>

					<!-- Game Score -->
					<div class="game-result__score-wrap">
						<div class="game-result__score game-result__score--lg">

							<?php

							$status = esc_html__( 'Preview', 'alchemists' );

							if ( ! empty( $results ) ) :

								$status = esc_html__( 'Final Score', 'alchemists' ); ?>

								<?php
								// 1st Team
								$team1_class = 'game-result__score-result--loser';
								if (!empty($results)) {
									if (!empty($results[$team1])) {
										if (isset($results[$team1]['outcome']) && !empty($results[$team1]['outcome'][0])) {
											if ( $results[$team1]['outcome'][0] == 'win' ) {
												$team1_class = 'game-result__score-result--winner';
											}
										}
									}
								}

								// 2nd Team
								$team2_class = 'game-result__score-result--loser';
								if (!empty($results)) {
									if (!empty($results[$team2])) {
										if (isset($results[$team2]['outcome']) && !empty($results[$team2]['outcome'][0])) {
											if ( $results[$team2]['outcome'][0] == 'win' ) {
												$team2_class = 'game-result__score-result--winner';
											}
										}
									}
								}

								?>

								<!-- 1st Team -->
								<span class="game-result__score-result <?php echo esc_attr( $team1_class ); ?>">
									<?php if (!empty($results)) {
										if (!empty($results[$team1]) && !empty($results[$team2])) {
											if (isset($results[$team1][$primary_result]) && isset($results[$team2][$primary_result])) {
												echo esc_html( $results[$team1][$primary_result] );
											}
										}
									} ?>
								</span>
								<!-- 1st Team / End -->

								<span class="game-result__score-dash">-</span>

								<!-- 2nd Team -->
								<span class="game-result__score-result <?php echo esc_attr( $team2_class ); ?>">
									<?php if (!empty($results)) {
										if (!empty($results[$team1]) && !empty($results[$team2])) {
											if (isset($results[$team1][$primary_result]) && isset($results[$team2][$primary_result])) {
												echo esc_html( $results[$team2][$primary_result] );
											}
										}
									} ?>
								</span>
								<!-- 2nd Team / End -->

						<?php else : ?>

							<span class="game-result__score-dash">&ndash;</span>

						<?php endif; ?>

						</div>

						<div class="game-result__score-label">
							<?php echo apply_filters( 'sportspress_event_logos_status', $status, $id ); ?>
						</div>

					</div>
					<!-- Game Score / End -->

				</div>
				<!-- Team Logos + Game Result / End -->

				<?php if ( $show_stats && $display_details ) : ?>

				<?php
				// Player Performance
				$result_posts = get_posts(array(
					'post_type'      => 'sp_result',
					'posts_per_page' => 9999,
					'orderby'        => 'menu_order',
					'order'          => 'DESC'
				));
				$result_posts_array = array();

				if ( $result_posts ) {
					foreach ($result_posts as $result_post) {
						$result_posts_array[$result_post->post_name] = array(
							'label'   => $result_post->post_title,
							'value'   => $result_post->post_name,
							'excerpt' => $result_post->post_excerpt,
						);
					}
					wp_reset_postdata();
				}
				$result_posts_array = array_reverse( $result_posts_array );
				?>
					<!-- Game Stats -->
					<div class="game-result__stats">
						<div class="row">
							<div class="col-xs-12 col-md-6 col-md-push-3 game-result__stats-scoreboard">
								<div class="game-result__table-stats">
									<div class="table-responsive">
										<table class="table table__cell-center table-wrap-bordered table-thead-color">
											<thead>
												<tr>
													<th><?php esc_html_e( 'Scoreboard', 'alchemists' ); ?></th>
													<?php foreach ( $result_posts_array as $result_post_key => $result_post_value ) : ?>
														<?php if ( 'poss' != $result_post_value['value'] ) : ?>
														<th title="<?php echo esc_attr( $result_post_value['excerpt'] ); ?>"><?php echo $result_post_value['label']; ?></th>
														<?php endif; ?>
													<?php endforeach; ?>
												</tr>
											</thead>
											<tbody>

												<?php foreach ( $teams as $key => $team) : ?>
													<?php $current_team = $teams[$key]; ?>
													<tr>
														<th><?php echo get_the_title( $current_team ); ?></th>
														<?php foreach ( $results[$current_team] as $result_key => $result_value ) : ?>
															<?php if ( 'outcome' != $result_key ) : ?>
																<?php if ( 'poss' != $result_key ) : ?>
																	<td>
																		<?php
																		if ( $result_value != '' ) {
																			echo esc_html( $result_value );
																		} else {
																			echo '-';
																		}
																		?>
																	</td>
																<?php endif; ?>
															<?php endif; ?>
														<?php endforeach; ?>
													</tr>
												<?php endforeach; ?>

											</tbody>
										</table>
									</div>
								</div>
							</div>

							<?php
							// Get Performance
							$event_performance = sp_get_performance( $id );

							// Remove the first row to leave us with the actual data
							unset( $event_performance[0] );

							// Player Performance
							$performances_posts = get_posts(array(
								'post_type'      => 'sp_performance',
								'posts_per_page' => 9999,
								'orderby'        => 'menu_order',
								'order'          => 'DESC'
							));

							$performances_posts_array = array();
							if( $performances_posts ){
								foreach( $performances_posts as $performance_post ){
									$performances_posts_array[ $performance_post->post_name ] = array(
										'label'   => $performance_post->post_title,
										'value'   => $performance_post->post_name,
										'excerpt' => $performance_post->post_excerpt
									);
								}
								wp_reset_postdata();
							}

							// Stats - Progress Bars
							$game_stats_array = array();
							$game_stats_array = alchemists_sp_filter_array( $performances_posts_array, $event_progress_bars_stats );
							?>

							<div class="col-xs-6 col-md-3 col-md-pull-6 game-result__stats-team-1">

								<?php // 1st Team
									foreach ( $game_stats_array as $game_stat_key => $game_stat_label ) :

										// Event Stats
										$event_team1_stat     = alchemists_check_exists_not_empty( $event_performance[ $team1 ][0][ $game_stat_key ] );
										$event_team2_stat     = alchemists_check_exists_not_empty( $event_performance[ $team2 ][0][ $game_stat_key ] );
										$event_team1_stat_pct = alchemists_sp_performance_percent( $event_team1_stat, $event_team2_stat );
										?>

										<div class="progress-stats">
											<div class="progress__label progress__label--abbr"><?php echo esc_html( $game_stat_label['label'] ); ?></div>
											<div class="progress progress--battery">
												<div class="progress__bar" role="progressbar" aria-valuenow="<?php echo esc_attr( $event_team1_stat_pct ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $event_team1_stat_pct ); ?>%; <?php echo esc_attr( $color_team_1_progress_bar_output ); ?>"></div>
											</div>
											<div class="progress__number progress__number--20"><?php echo esc_html( $event_team1_stat ); ?></div>
										</div>

									<?php endforeach; ?>

							</div>
							<div class="col-xs-6 col-md-3 game-result__stats-team-2">

								<?php // 2nd Team
								foreach ( $game_stats_array as $game_stat_key => $game_stat_label ) :

									// Event Stats
									$event_team1_stat     = alchemists_check_exists_not_empty( $event_performance[ $team1 ][0][ $game_stat_key ] );
									$event_team2_stat     = alchemists_check_exists_not_empty( $event_performance[ $team2 ][0][ $game_stat_key ] );
									$event_team2_stat_pct = alchemists_sp_performance_percent( $event_team2_stat, $event_team1_stat );
									?>

									<div class="progress-stats">
										<div class="progress__label progress__label--abbr"><?php echo esc_html( $game_stat_label['label'] ); ?></div>
										<div class="progress progress--battery">
											<div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="<?php echo esc_attr( $event_team2_stat_pct ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $event_team2_stat_pct ); ?>%; <?php echo esc_attr( $color_team_2_progress_bar_output ); ?>"></div>
										</div>
										<div class="progress__number progress__number--20"><?php echo esc_html( $event_team2_stat ); ?></div>
									</div>

								<?php endforeach; ?>

							</div>
						</div>
					</div>
					<!-- Game Stats / End -->

				<?php endif; ?>
			</section>

			<?php if ( $display_details ) : ?>
			<?php
				if (!empty($results)) {
					if (!empty($results[$team1]) && !empty($results[$team2])) {

						// ball possession fields
						$team1_poss = isset( $results[$team1]['poss'] ) ? str_replace( '%', '', $results[$team1]['poss'] ) : '';
						$team2_poss = isset( $results[$team2]['poss'] ) ? str_replace( '%', '', $results[$team2]['poss'] ) : '';

						if (!empty($results[$team1]['poss']) && !empty($results[$team2]['poss'])) { ?>

							<!-- Ball Possession -->
							<section class="game-result__section">
								<header class="game-result__subheader card__subheader">
									<h5 class="game-result__subtitle"><?php esc_attr_e( 'Ball Possession', 'alchemists' ); ?></h5>
								</header>
								<div class="game-result__content">

									<!-- Progress: Ball Possession -->
									<div class="progress-double-wrapper progress-double-wrapper--fullwidth">
										<div class="progress-inner-holder">
											<div class="progress__digit progress__digit--left progress__digit--highlight"><?php echo esc_html( $team1_poss ); ?>%</div>
											<div class="progress progress--battery">
												<div class="progress__bar" role="progressbar" aria-valuenow="<?php echo esc_attr( $team1_poss ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $team1_poss ); ?>%; <?php echo esc_attr( $color_team_1_progress_bar_output ); ?>"></div>
												<div class="progress__bar progress__bar--success" role="progressbar" aria-valuenow="<?php echo esc_attr( $team2_poss ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $team2_poss ); ?>%; <?php echo esc_attr( $color_team_2_progress_bar_output ); ?>"></div>
											</div>
											<div class="progress__digit progress__digit--right progress__digit--highlight"><?php echo esc_html( $team2_poss ); ?>%</div>
										</div>
									</div>
									<!-- Progress: Ball Possession / End -->

								</div>
							</section>
							<!-- Ball Possession / End -->

						<?php
						}
					}
				}
				?>
			<?php endif; ?>

			<?php if ( $display_percentage ) : ?>
				<!-- Additional Stats -->
				<section class="game-result__section">
					<header class="game-result__subheader card__subheader">
						<h5 class="game-result__subtitle"><?php esc_html_e( 'Additional Stats', 'alchemists' ); ?></h5>
					</header>
					<div class="game-result__content-alt">

						<?php
						// Stats - Circular Bars
						$game_stats_additional_array = array();
						$game_stats_additional_array = alchemists_sp_filter_array( $performances_posts_array, $event_percents_stats );
						?>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<?php // 1st Team
									foreach ( $game_stats_additional_array as $game_stat_additional_key => $game_stat_additional_value ) :

										// Performance - Value
										$event_team1_value = alchemists_check_exists_not_empty( $event_performance[ $team1 ][0][ $game_stat_additional_key ] );
										$event_team2_value = alchemists_check_exists_not_empty( $event_performance[ $team2 ][0][ $game_stat_additional_key ] );

										// Performance - Percent
										$event_team1_percent = alchemists_sp_get_performances_based_on_format( $event_circular_bars_stats_format, $event_team1_value, $event_team2_value );
										?>

										<div class="col-xs-4">
											<div class="circular">
												<div class="circular__bar" data-percent="<?php echo esc_attr( $event_team1_percent ); ?>" <?php echo esc_attr( $color_team_1_bar_output ); ?>>
													<span class="circular__percents circular__percents--lg"><?php echo esc_html( $event_team1_value ); ?><small class="circular__label" title="<?php echo esc_attr( $game_stat_additional_value['excerpt'] ); ?>"><?php echo esc_html( $game_stat_additional_value['label'] ); ?></small></span>
												</div>
											</div>
										</div>

									<?php endforeach; ?>

								</div>
								<div class="spacer"></div>
								<div class="row">

									<?php // 2nd Team
									foreach ( $game_stats_additional_array as $game_stat_additional_key => $game_stat_additional_value ) :

										// Performance - Value
										$event_team1_value = alchemists_check_exists_not_empty( $event_performance[ $team1 ][0][ $game_stat_additional_key ] );
										$event_team2_value = alchemists_check_exists_not_empty( $event_performance[ $team2 ][0][ $game_stat_additional_key ] );

										// Performance - Percent
										$event_team2_percent = alchemists_sp_get_performances_based_on_format( $event_circular_bars_stats_format, $event_team2_value, $event_team1_value );
										?>

										<div class="col-xs-4">
											<div class="circular">
												<div class="circular__bar" data-percent="<?php echo esc_attr( $event_team2_percent ); ?>" <?php echo esc_attr( $color_team_2_bar_output ); ?>>
													<span class="circular__percents circular__percents--lg"><?php echo esc_html( $event_team2_value ); ?><small class="circular__label" title="<?php echo esc_attr( $game_stat_additional_value['excerpt'] ); ?>"><?php echo esc_html( $game_stat_additional_value['label'] ); ?></small></span>
												</div>
											</div>
										</div>

									<?php endforeach; ?>

								</div>
							</div>
							<div class="col-md-5 col-md-offset-1">

								<?php
								$game_all_stats_array = array();
								$game_all_stats_array = alchemists_sp_filter_array( $performances_posts_array, $event_stats );
								?>

								<div class="game-result__table-additional-stats">
									<div class="table-responsive">
										<table class="table table--no-border">
											<thead>
												<tr>
													<th><?php echo esc_html( $event_stats_table_title ); ?></th>
													<th><?php echo sp_get_team_name( $team1, $abbreviate_teams ); ?></th>
													<th><?php echo sp_get_team_name( $team2, $abbreviate_teams ); ?></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ( $game_all_stats_array as $game_all_stat_key => $game_all_stat_value ) : ?>
													<tr>
														<th><?php echo esc_html( $game_all_stat_value['excerpt'] ); ?></th>

														<?php
														$event_team1_percent = alchemists_check_exists_not_empty( $event_performance[ $team1 ][0][ $game_all_stat_key ] );
														?>
														<td><?php echo esc_html( $event_team1_percent ); ?></td>

														<?php
														$event_team2_percent = alchemists_check_exists_not_empty( $event_performance[ $team2 ][0][ $game_all_stat_key ] );
														?>
														<td><?php echo esc_html( $event_team2_percent ); ?></td>

													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>

							</div>
						</div>

					</div>
				</section>
				<!-- Additional Stats / End -->
				<?php endif; ?>

		</div>
		<!-- Game Result / End -->

		<?php else : ?>

		<?php
		// Basketball
		$permalink      = get_post_permalink( $post, false, true );
		$results        = get_post_meta( $post->ID, 'sp_results', true );
		$primary_result = alchemists_sportspress_primary_result();
		$event_date     = $post->post_date;
		$teams          = array_unique( get_post_meta( $post->ID, 'sp_team' ) );
		$teams          = array_filter( $teams, 'sp_filter_positive' );

		if (count($teams) > 1) {
			$team1 = $teams[0];
			$team2 = $teams[1];
		}

		$venue1_desc = wp_get_post_terms($team1, 'sp_venue');
		$venue2_desc = wp_get_post_terms($team2, 'sp_venue');
		?>

		<!-- Game Result -->
		<div class="game-result">

			<section class="game-result__section">
				<header class="game-result__header">
					<?php $leagues = get_the_terms( $post, 'sp_league' ); if ( $leagues ): $league = array_shift( $leagues ); ?>
						<h3 class="game-result__title">
							<?php echo esc_html( $league->name ); ?>

							<?php $seasons = get_the_terms( $post, 'sp_season' ); if ( $seasons ): $season = array_shift( $seasons ); ?>
								<?php echo esc_html( $season->name ); ?>
							<?php endif; ?>

						</h3>
					<?php endif; ?>

					<time class="game-result__date" datetime="<?php echo esc_attr( $event_date ); ?>"><?php echo esc_html( get_the_time( sp_date_format() . ' - ' . sp_time_format(), $post ) ); ?></time>
				</header>

				<!-- Team Logos + Game Result -->
				<div class="game-result__content">

					<?php
					$j = 0;
					foreach( $teams as $team ):
						$j++;

						echo '<div class="game-result__team game-result__team--' . ( $j % 2 ? 'odd' : 'even' ) . '">';
							echo '<figure class="game-result__team-logo">';
								if ( has_post_thumbnail ( $team ) ):
									echo get_the_post_thumbnail( $team, 'alchemists_team-logo-fit' );
								endif;
							echo '</figure>';
							echo '<div class="game-result__team-info">';
								echo '<h5 class="game-result__team-name">' . esc_html( get_the_title( $team ) ) . '</h5>';
								echo '<div class="game-result__team-desc">';
									if ( $j == 1 ) {
										if ( isset( $venue1_desc[0] )) {
											echo esc_html( $venue1_desc[0]->description );
										}
									} elseif ( $j == 2 ) {
										if ( isset( $venue2_desc[0] )) {
											echo esc_html( $venue2_desc[0]->description );
										}
									}
								echo '</div>';
							echo '</div>';
						echo '</div>';

					endforeach;
					?>

					<!-- Game Score -->
					<div class="game-result__score-wrap">
						<div class="game-result__score">

							<?php

							// 1st Team
							$team1_class = 'game-result__score-result--loser';
							if (!empty($results)) {
								if (!empty($results[$team1])) {
									if (isset($results[$team1]['outcome']) && !empty($results[$team1]['outcome'][0])) {
										if ( $results[$team1]['outcome'][0] == 'win' ) {
											$team1_class = 'game-result__score-result--winner';
										}
									}
								}
							}

							// 2nd Team
							$team2_class = 'game-result__score-result--loser';
							if (!empty($results)) {
								if (!empty($results[$team2])) {
									if (isset($results[$team2]['outcome']) && !empty($results[$team2]['outcome'][0])) {
										if ( $results[$team2]['outcome'][0] == 'win' ) {
											$team2_class = 'game-result__score-result--winner';
										}
									}
								}
							}

							?>

							<!-- 1st Team -->
							<span class="game-result__score-result <?php echo esc_attr( $team1_class ); ?>">
								<?php if (!empty($results)) {
									if (!empty($results[$team1]) && !empty($results[$team2])) {
										if (isset($results[$team1][$primary_result]) && isset($results[$team2][$primary_result])) {
											echo esc_html( $results[$team1][$primary_result] );
										}
									}
								} ?>
							</span>
							<!-- 1st Team / End -->

							<span class="game-result__score-dash">-</span>

							<!-- 2nd Team -->
							<span class="game-result__score-result <?php echo esc_attr( $team2_class ); ?>">
								<?php if (!empty($results)) {
									if (!empty($results[$team1]) && !empty($results[$team2])) {
										if (isset($results[$team1][$primary_result]) && isset($results[$team2][$primary_result])) {
											echo esc_html( $results[$team2][$primary_result] );
										}
									}
								} ?>
							</span>
							<!-- 2nd Team / End -->

						</div>
						<div class="game-result__score-label"><?php esc_html_e( 'Final Score', 'alchemists' ); ?></div>

					</div>
					<!-- Game Score / End -->

				</div>
				<!-- Team Logos + Game Result / End -->



				<?php if ( $display_details || $display_percentage ) :

				// Player Performance
				$performances_posts = get_posts(array(
					'post_type'      => 'sp_performance',
					'posts_per_page' => 9999,
					'orderby'        => 'menu_order',
					'order'          => 'DESC'
				));

				$performances_posts_array = array();
				if($performances_posts){
					foreach($performances_posts as $performance_post){
						$performances_posts_array[$performance_post->post_name] = array(
							'label'   => $performance_post->post_title,
							'value'   => $performance_post->post_name,
							'excerpt' => $performance_post->post_excerpt
						);
					}
					wp_reset_postdata();
				}

				endif; ?>

				<?php if ( $display_details ) : ?>
					<?php if (!empty($results)) : ?>
						<?php if (!empty($results[$team1]) && !empty($results[$team2])) : ?>
							<?php if ( isset($results[$team1][$primary_result]) && isset($results[$team2][$primary_result]) ) : ?>

								<?php
								// Player Performance
								$result_posts = get_posts(array(
									'post_type'      => 'sp_result',
									'posts_per_page' => 9999,
									'orderby'        => 'menu_order',
									'order'          => 'DESC'
								));
								$result_posts_array = array();

								if ( $result_posts ) {
									foreach ($result_posts as $result_post) {
										$result_posts_array[$result_post->post_name] = array(
											'label'   => $result_post->post_title,
											'value'   => $result_post->post_name,
											'excerpt' => $result_post->post_excerpt,
										);
									}
									wp_reset_postdata();
								}
								$result_posts_array = array_reverse( $result_posts_array );
								?>

								<!-- Game Stats -->
								<div class="game-result__stats">
									<div class="row">
										<div class="col-xs-12 col-md-6 col-md-push-3 game-result__stats-scoreboard">
											<div class="game-result__table-stats">
												<div class="table-responsive">
													<table class="table table__cell-center table-wrap-bordered table-thead-color">
														<thead>
															<tr>
																<th><?php esc_html_e( 'Scoreboard', 'alchemists' ); ?></th>
																<?php foreach ( $result_posts_array as $result_post_key => $result_post_value ) : ?>
																	<th title="<?php echo esc_attr( $result_post_value['excerpt'] ); ?>"><?php echo $result_post_value['label']; ?></th>
																<?php endforeach; ?>
															</tr>
														</thead>
														<tbody>
															<?php foreach ( $teams as $key => $team) : ?>
																<?php $current_team = $teams[$key]; ?>
																<tr>
																	<th><?php echo get_the_title( $current_team ); ?></th>
																	<?php foreach ( $results[$current_team] as $result_key => $result_value ) : ?>
																		<?php if ( 'outcome' != $result_key ) : ?>
																			<td>
																				<?php
																				if ( $result_value != '' ) {
																					echo esc_html( $result_value );
																				} else {
																					echo '-';
																				}
																				?>
																			</td>
																		<?php endif; ?>
																	<?php endforeach; ?>
																</tr>
															<?php endforeach; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>

										<?php
										// get Performance
										$event_performance = sp_get_performance( $post );

										// Remove the first row to leave us with the actual data
										unset( $event_performance[0] );

										// Custom Stats
										$game_stats_array = array();
										$game_stats_array = alchemists_sp_filter_array( $performances_posts_array, $event_progress_bars_stats );

										// echo '<pre>' . var_export($game_stats_array, true) . '</pre>';

										?>
										<div class="col-xs-6 col-md-3 col-md-pull-6 game-result__stats-team-1">

											<?php // 1st Team
											foreach ( $game_stats_array as $game_stat_key => $game_stat_label ) :

												// Event Stats
												$event_team1_stat = alchemists_check_exists_not_empty( $event_performance[ $team1 ][0][ $game_stat_key ] );
												$event_team2_stat = alchemists_check_exists_not_empty( $event_performance[ $team2 ][0][ $game_stat_key ] );
												$event_team1_stat_pct = alchemists_sp_performance_percent( $event_team1_stat, $event_team2_stat );
												?>

												<div class="progress-stats">
													<div class="progress__label progress__label--abbr"><?php echo esc_html( $game_stat_label['label'] ); ?></div>
													<div class="progress">
														<div class="progress__bar" role="progressbar" aria-valuenow="<?php echo esc_attr( $event_team1_stat_pct ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $event_team1_stat_pct ); ?>%; <?php echo esc_attr( $color_team_1_progress_bar_output ); ?>"></div>
													</div>
													<div class="progress__number progress__number--20"><?php echo esc_html( $event_team1_stat ); ?></div>
												</div>

											<?php endforeach; ?>

										</div>
										<div class="col-xs-6 col-md-3 game-result__stats-team-2">

											<?php // 2nd Team
											foreach ( $game_stats_array as $game_stat_key => $game_stat_label ) :

												// Event Stats
												$event_team1_stat = alchemists_check_exists_not_empty( $event_performance[ $team1 ][0][ $game_stat_key ] );
												$event_team2_stat = alchemists_check_exists_not_empty( $event_performance[ $team2 ][0][ $game_stat_key ] );
												$event_team2_stat_pct = alchemists_sp_performance_percent( $event_team2_stat, $event_team1_stat );
												?>

												<div class="progress-stats">
													<div class="progress__label progress__label--abbr"><?php echo esc_html( $game_stat_label['label'] ); ?></div>
													<div class="progress">
														<div class="progress__bar progress__bar--info" role="progressbar" aria-valuenow="<?php echo esc_attr( $event_team2_stat_pct ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr( $event_team2_stat_pct ); ?>%; <?php echo esc_attr( $color_team_2_progress_bar_output ); ?>"></div>
													</div>
													<div class="progress__number progress__number--20"><?php echo esc_html( $event_team2_stat ); ?></div>
												</div>

											<?php endforeach; ?>

										</div>
									</div>
								</div>
								<!-- Game Stats / End -->

							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
			</section>

			<?php if ( $display_percentage ) : ?>
				<?php if (!empty($results)) : ?>
					<?php if (!empty($results[$team1]) && !empty($results[$team2])) : ?>
						<?php if ( isset($results[$team1][$primary_result]) && isset($results[$team2][$primary_result]) ) : ?>

							<?php
							// Percentage
							$game_stats_percentage_array = array();
							$game_stats_percentage_array = alchemists_sp_filter_array( $performances_posts_array, $event_percents_stats );
							?>

							<!-- Game Percentage -->
							<section class="game-result__section">
								<header class="game-result__subheader card__subheader">
									<h5 class="game-result__subtitle"><?php esc_html_e( 'Game Statistics', 'alchemists' ); ?></h5>
								</header>
								<div class="game-result__content-alt mb-0">
									<div class="row">
										<div class="col-xs-12 col-md-6">
											<div class="row">

												<?php // 1st Team
												foreach ( $game_stats_percentage_array as $event_percent_key => $event_percent_label ) :

													// Performance - Value
													$event_team1_value = alchemists_check_exists_not_empty( $event_performance[ $team1 ][0][ $event_percent_key ] );
													$event_team2_value = alchemists_check_exists_not_empty( $event_performance[ $team2 ][0][ $event_percent_key ] );

													// Performance - Percent
													$event_team1_percent = alchemists_sp_get_performances_based_on_format( $event_circular_bars_stats_format, $event_team1_value, $event_team2_value );
													?>

													<div class="col-xs-4">
														<div class="circular">
															<div class="circular__bar" data-percent="<?php echo esc_attr( $event_team1_percent ); ?>" <?php echo esc_attr( $color_team_1_bar_output ); ?>>
																<span class="circular__percents"><?php echo esc_html( $event_team1_value ); ?><?php echo ( $event_circular_bars_stats_format == 'percentage' ) ? '<small>%</small>' : ''; ?></span>
															</div>
															<span class="circular__label"><?php echo esc_html( $event_percent_label['excerpt'] ); ?></span>
														</div>
													</div>

												<?php endforeach; ?>

											</div>
										</div>
										<div class="col-xs-12 col-md-6">
											<div class="row">

												<?php // 2nd Team
												foreach ( $game_stats_percentage_array as $game_percent_key => $game_percent_label ) :

													// Performance - Value
													$event_team1_value = alchemists_check_exists_not_empty( $event_performance[ $team1 ][0][ $game_percent_key ] );
													$event_team2_value = alchemists_check_exists_not_empty( $event_performance[ $team2 ][0][ $game_percent_key ] );

													// Performance - Percent
													$event_team2_percent = alchemists_sp_get_performances_based_on_format( $event_circular_bars_stats_format, $event_team2_value, $event_team1_value );
													?>

													<div class="col-xs-4">
														<div class="circular">
															<div class="circular__bar" data-percent="<?php echo esc_attr( $event_team2_percent ); ?>" <?php echo esc_attr( $color_team_2_bar_output ); ?>>
																<span class="circular__percents"><?php echo esc_html( $event_team2_value ); ?><?php echo ( $event_circular_bars_stats_format == 'percentage' ) ? '<small>%</small>' : ''; ?></span>
															</div>
															<span class="circular__label"><?php echo esc_html( $game_percent_label['excerpt'] ); ?></span>
														</div>
													</div>

												<?php endforeach; ?>

											</div>
										</div>
									</div>
								</div>
							</section>
							<!-- Game Percentage / End -->
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>


		</div>
		<!-- Game Result / End -->

		<?php endif; ?>

	</div>
</div>
<!-- Game Scoreboard / End -->
