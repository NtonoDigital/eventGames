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

$output .= '<table class="table table-hover table-standings sp-league-table sp-data-table' . ( $responsive ? ' sp-responsive-table ' . $identifier : '' ). ( $scrollable ? ' sp-scrollable-table' : '' ) . ( $paginated ? ' sp-paginated-table' : '' ) . '" data-sp-rows="' . $rows . '">' . '<thead>' . '<tr>';

$output .= '<th>'.esc_html__('Match Day', 'alchemists').'</th>';
$output .= '<th>'.esc_html__('Event', 'alchemists').'</th>';
$output .= '<th>'.esc_html__('Result', 'alchemists').'</th>';
$output .= '<th>'.esc_html__('League', 'alchemists').'</th>';
$output .= '</tr></thead><tbody>';

$the_tournament = get_post($sp_tournament);

foreach($results as $result){
    
    $output .= '<tr>';

    $table = new SP_Event((int)$result->meta_value);
    
    $data = $table->results();

    var_dump($data);

    return;

    $match_date = $table->day();

    $output .= '<td class="data-day" data-label="'.esc_attr__('Match Day', 'alchemists').'">';
    $output .= $match_date;
    $output .= '</td>';

    $counter = 0;

    $output .= '<td class="data-event" data-label="'.esc_attr__('Event', 'alchemists').'">';

    $all_goals = array();

    foreach($data as $teamid=>$stat){
        
        if($counter > 1){
            continue;
        }

        $team = get_post((int)$teamid);
        
        if(!is_numeric($stat['firsthalf'])){
            $stat['firsthalf'] = 0;
        }
        if(!is_numeric($stat['secondhalf'])){
            $stat['secondhalf'] = 0;
        }
        $all_goals[] = $goals = (int)$stat['firsthalf']+(int)$stat['secondhalf'];
        
        $name = $team->post_title;
        $logo = '';
        if ( has_post_thumbnail( $team->ID ) ){
			$logo = get_the_post_thumbnail( $team->ID, 'sportspress-fit-icon' );
        }
        if($counter == 0){
            $output .= '<span class="team-title">'.$name.'</span>&nbsp;&nbsp;';
            if($logo){
                $output .= '<span class="team-logo">'.$logo.'</span>&nbsp;&nbsp;';
            }
            $output .= '<span class="team-goals">'.$goals.'</span>';
            $output .= '-';
        }else{
            $output .= '<span class="team-goals">'.$goals.'</span>&nbsp;&nbsp;';
            if($logo){
                $output .= '<span class="team-logo">'.$logo.'</span>&nbsp;&nbsp;';
            }
            $output .= '<span class="team-title">'.$name.'</span>';
        }

        $counter++;
    }
    $output .= '</td>';

    $output .= '<td class="data-result" data-label="'.esc_attr__('Result', 'alchemists').'">';
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