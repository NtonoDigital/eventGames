<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$defaults = array(
	'number' => -1,
	'columns' => null,
	'highlight' => null,
	'show_full_table_link' => false,
	'title' => false,
	'show_title' => get_option( 'sportspress_table_show_title', 'yes' ) == 'yes' ? true : false,
	'show_team_logo' => get_option( 'sportspress_table_show_logos', 'yes' ) == 'yes' ? true : false,
	'link_posts' => null,
	'responsive' => get_option( 'sportspress_enable_responsive_tables', 'no' ) == 'yes' ? true : false,
	'sortable' => get_option( 'sportspress_enable_sortable_tables', 'yes' ) == 'yes' ? true : false,
	'scrollable' => get_option( 'sportspress_enable_scrollable_tables', 'yes' ) == 'yes' ? true : false,
	'paginated' => get_option( 'sportspress_table_paginated', 'yes' ) == 'yes' ? true : false,
	'rows' => get_option( 'sportspress_table_rows', 10 ),
);

extract( $defaults, EXTR_SKIP );

$title = esc_html__('Tournament Results', 'alchemists');

$output = '';

$output .= '<div class="card card--has-table">';

if ( $title ) {
	$output .= '<header class="card__header">';
    $output .= '<h4 class="sp-table-caption">' . $title . '</h4>';
	$output .= '</header>';
}

$output .= '<div class="card__content">';

$output .= '<div class="table-responsive sp-table-wrapper">';

$output .= '<table class="table table-hover team-schedule table-standings sp-league-table sp-data-table' . ( $responsive ? ' sp-responsive-table ' : '' ). ( $scrollable ? ' sp-scrollable-table' : '' ) . ( $paginated ? ' sp-paginated-table' : '' ) . '" data-sp-rows="' . $rows . '">' . '<thead>' . '<tr>';

$output .= '<th>'.esc_html__('Date', 'alchemists').'</th>';
$output .= '<th>'.esc_html__('Event', 'alchemists').'</th>';
$output .= '<th>'.esc_html__('Results', 'alchemists').'</th>';
$output .= '<th>'.esc_html__('League', 'alchemists').'</th>';
$output .= '</tr></thead><tbody>';

$the_tournament = get_post($sp_tournament);

foreach($results as $result){
    
    $event = get_post((int)$result->meta_value);

    if(!$event){
        continue;
    }

    $table = new SP_Event((int)$result->meta_value);
    $data = $table->results();
    $all_goals = array();
    $counter = 0;
    $goalscol = '';

    foreach($data as $teamid=>$stat){
        
        if(!$teamid){
            continue;
        }

        $team = get_post((int)$teamid);
        
        if(!$team){
            continue;
        }

        $name = $team->post_title;

        if(!$name || in_array(strtolower($name), array('equipo', 'equipos', 'no equipo'))){
            continue;
        }
        
        if(!isset($stat['goals'])){
            continue;
        }
        if(!is_numeric($stat['goals'])){
            $stat['goals'] = 0;
        }
        
        $all_goals[] = $goals = (int)$stat['goals'];
        
        $logo = '';
        if ( has_post_thumbnail( $team->ID ) ){
			$logo = get_the_post_thumbnail( $team->ID, 'sportspress-fit-icon' );
        }
        if($counter == 0){
            $goalscol .= '<span class="team-title">'.$name.'</span>&nbsp;&nbsp;';
            if($logo){
                $goalscol .= '<span class="team-logo">'.$logo.'</span>&nbsp;&nbsp;';
            }
            $goalscol .= '<span class="team-goals">'.$goals.'</span>';
            $goalscol .= '-';
        }else{
            $goalscol .= '<span class="team-goals">'.$goals.'</span>&nbsp;&nbsp;';
            if($logo){
                $goalscol .= '<span class="team-logo">'.$logo.'</span>&nbsp;&nbsp;';
            }
            $goalscol .= '<span class="team-title">'.$name.'</span>';
        }

        $counter++;
    }

    if(!$goalscol){
        continue;
    }

    $match_date = $table->day();

    if(!$match_date){

        $match_date = apply_filters( 'sportspress_event_date', get_post_time( get_option( 'date_format' ), false, $event, true ), $event->ID );

    }
    $match_date = '<a href="'.get_permalink($event->ID).'" itemprop="url">'.$match_date.'</a>';

    $output .= '<tr>';

    $output .= '<td class="date-date" data-label="'.esc_attr__('Date', 'alchemists').'">';
    $output .= $match_date;
    $output .= '</td>';

    $output .= '<td class="data-event" data-label="'.esc_attr__('Event', 'alchemists').'">';
    $output .= $goalscol;
    $output .= '</td>';

    $output .= '<td class="data-result" data-label="'.esc_attr__('Results', 'alchemists').'">';
    $output .= implode(' - ', $all_goals);
    $output .= '</td>';
    
    $args = array(
        'object_ids'               => (int)$result->meta_value,
        'taxonomy'               => 'sp_league',
        'orderby'                => 'name',
        'order'                  => 'ASC',
        'hide_empty'             => true,
    );
    $the_query = new WP_Term_Query($args);

    $leagues = $the_query->get_terms();

    $output .= '<td class="data-league" data-label="'.esc_attr__('League', 'alchemists').'">';
    if($leagues && !is_wp_error($leagues)){
        foreach($leagues as $n=>$league){
            if($n > 0){
                $output .= ', ';
            }
            $output .= $league->name;
        }
    }
    $output .= '</td>';
    $output .= '</tr>';

}
$output .= '</tbody></table>';

$output .= '</div></div></div>';
?>
<div class="sp-template sp-template-results-table">
	<?php echo $output; ?>
</div>