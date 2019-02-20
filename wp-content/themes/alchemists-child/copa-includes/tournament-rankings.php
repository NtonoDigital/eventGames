<?php

function copa_organize_teams_rankings_data($events, $eventids, $teams){
    $return = $merged = array();
    if($events){
        
        $result['goalsgiven'] = $merged['goalsgiven'] = array();
        $result['goalsreceived'] = $merged['goalsreceived'] = array();
        $result['assists'] = $merged['assists'] = array();
        $result['cards'] = $merged['cards'] = array();
        $result['mvps'] = $merged['mvps'] = array();
        
        foreach($events as $e){
            
            if(
                !in_array($e['teams'][0], $teams)
                || !in_array($e['teams'][1], $teams)
            ){
                continue;
            }

            foreach($e['teams'] as $key=>$team){
                
                if(!isset($merged['goalsgiven'][$team])){
                    $merged['goalsgiven'][$team] = 0;
                }
                if(!isset($merged['goalsreceived'][$team])){
                    $merged['goalsreceived'][$team] = 0;
                }
                $merged['goalsgiven'][$team] += (int)$e['results'][$key];
                if($key > 0){
                    $revkey = 0;
                }else{
                    $revkey = 1;
                }
                $merged['goalsreceived'][$team] += (int)$e['results'][$revkey];
            }
        }
        foreach($eventids as $e){
            $event = get_post($e);
            
            if(!$event || is_wp_error($event)){
                continue;
            }
            $players = get_post_meta($event->ID, 'sp_players', true);
            if(!$players){
                continue;
            }

            $teamsid = array_keys($players);
            if(
                !in_array($teamsid[0], $teams)
                || !in_array($teamsid[1], $teams)
            ){
                continue;
            }

            if($players){
                $stars = get_post_meta( $event->ID, 'sp_stars', true );

                foreach($players as $team_id=>$data1){
                    if(!in_array($team_id, $teams)){
                        continue;
                    }
                    if(count($data1) > 0){
                        foreach($data1 as $playerid => $loop){
                            if(!$playerid){ // 0 index actually having no data
                                continue;
                            }
                            if(!isset($merged['assists'][$team_id])){
                                $merged['assists'][$team_id] = array('played'=>0, 'value'=> 0);
                            }
                            if(!isset($merged['cards'][$team_id])){
                                $merged['cards'][$team_id] = array('played'=>0, 'value'=> 0);
                            }
                            if(!isset($merged['mvps'][$team_id])){
                                $merged['mvps'][$team_id] = array('played'=>0, 'value'=> 0);
                            }

                            if($stars && in_array($playerid, array_keys($stars))){          
                                $merged['mvps'][$team_id]['value'] += 1;
                                $merged['mvps'][$team_id]['played'] += 1;
                            }

                            $merged['assists'][$team_id]['value'] += (int)$loop['assists'];
                            $merged['assists'][$team_id]['played'] += 1;
                            $merged['cards'][$team_id]['played'] += 1;
                            $merged['cards'][$team_id]['value'] += (int)$loop['yellowcards'];
                            $merged['cards'][$team_id]['value'] += (int)$loop['redcards'];
                        }
                    }
                    
                }
            }
        }
    }
    if($merged){
        foreach($merged as $key=>$m1){
            $count = 0;
            foreach($m1 as $id=>$m){
                if(is_array($m)){
                    $return[$key][$count] = array_merge(array('id'=>$id), $m);
                    $count++;
                }
            }
        }
        foreach($return as &$m){
            usort($m, 'copa_sort_rankings');
        }
    }
    return $return;
}
function copa_sort_rankings($a, $b){
    if ($a['value'] == $b['value']) {
        return 0;
    }
    return ($a['value'] < $b['value']) ? 1 : -1;
}

function copa_organize_players_rankings_data($events, $teams){
    $return = $merged = array();
    if($events){
        
        $return['goalsgiven'] = $merged['goalsgiven'] = array();
        $return['assists'] = $merged['assists'] = array();
        $return['cards'] = $merged['cards'] = array();
        $return['mvps'] = $merged['mvps'] = array();
        $return['saves'] = $merged['saves'] = array();
        
        foreach($events as $e){
            $event = get_post($e);
            if(!$event || is_wp_error($event)){
                continue;
            }
            $players = get_post_meta($event->ID, 'sp_players', true);
            if(!$players){
                continue;
            }
            $teamsid = array_keys($players);
            if(
                !in_array($teamsid[0], $teams)
                || !in_array($teamsid[1], $teams)
            ){
                continue;
            }
            $stars = get_post_meta( $event->ID, 'sp_stars', true );

            if($stars){
                foreach($stars as $playerid=>$star){
                    if(!isset($merged['mvps'][$playerid])){
                        $merged['mvps'][$playerid] = 0;
                    }
                    $merged['mvps'][$playerid] += 1;
                }
            }

            

            if($players){
                foreach($players as $team_id=>$data1){
                    
                    if(count($data1) > 0){
                        foreach($data1 as $playerid => $loop){

                            if(!$playerid){ // 0 index actually having no data
                                continue;
                            }
                            if(!isset($merged['goalsgiven'][$playerid])){
                                $merged['goalsgiven'][$playerid] = array('played'=>0, 'value'=> 0);
                            }
                            if(!isset($merged['assists'][$playerid])){
                                $merged['assists'][$playerid] = array('played'=>0, 'value'=> 0);
                            }
                            if(!isset($merged['cards'][$playerid])){
                                $merged['cards'][$playerid] = array('played'=>0, 'value'=> 0);
                            }
                            if(!isset($merged['saves'][$playerid])){
                                $merged['saves'][$playerid] = array('played'=>0, 'value'=> 0);
                            }
                            if(isset($loop['saves']) && $loop['saves']){
                                $merged['saves'][$playerid]['value'] += (int)$loop['saves'];
                                $merged['saves'][$playerid]['played'] += 1;
                            }

                            $merged['goalsgiven'][$playerid]['value'] += (int)$loop['goals'];
                            $merged['assists'][$playerid]['value'] += (int)$loop['assists'];
                            $merged['cards'][$playerid]['value'] += (int)$loop['redcards'];
                            $merged['goalsgiven'][$playerid]['played'] += 1;
                            $merged['assists'][$playerid]['played'] += 1;
                            $merged['cards'][$playerid]['played'] += 1;

                        }
                    }
                    
                }
            }
        }
    }
    if($merged){
        foreach($merged as $key=>$m1){
            $count = 0;
            foreach($m1 as $id=>$m){
                if(is_array($m)){
                    $return[$key][$count] = array_merge(array('id'=>$id), $m);
                    $count++;
                }
            }
        }
        foreach($return as &$m){
            usort($m, 'copa_sort_rankings');
        }
    }
    return $return;
}


function copa_display_tournament_teams_rankings($table_id, $mode = 'teams_rankings'){
    global $wpdb;
    $teams = $wpdb->get_col($wpdb->prepare("SELECT pm.meta_value FROM {$wpdb->postmeta} pm LEFT JOIN {$wpdb->posts} p ON pm.post_id=p.ID WHERE p.ID = %d AND pm.meta_key='sp_team' AND p.post_status='publish' AND pm.meta_value+0>0", $table_id));
    // $table = new SP_League_Table( $table_id );
    // $list = $table->data();
    if(!$teams){
        $pre_teams = get_post_meta($table_id, 'sp_teams', true);
        if($pre_teams){
            $teams = array_keys($pre_teams);
        }
    }

    $tournament = get_post_meta($table_id, 'sp_tournament', true);
    
    if($mode == 'players_rankings'){
        $events = get_post_meta($tournament, 'sp_event');
        $data = copa_organize_players_rankings_data($events, $teams);
    }else{
        $events = get_post_meta($tournament, 'sp_events', true);
        $eventids = get_post_meta($tournament, 'sp_event');
        $data = copa_organize_teams_rankings_data($events, $eventids, $teams);
    }
    $boxestitles = array(
        'goalsgiven' => esc_html__('Goals Made', 'alchemists'),
        'goalsreceived' => esc_html__('Goals Received', 'alchemists'),
        'assists' => esc_html__('Assists', 'alchemists'),
        'cards' => esc_html__('Cards', 'alchemists'),
        'mvps' => esc_html__('MVP', 'alchemists'),
        'saves' => esc_html__('Goalie', 'alchemists'),
    );

    
    $output = '<div class="row">';

    $count = 1;

    foreach($data as $key=>$val1){
        if($val1){
            $output .= '<div class="col-md-4 col-sm-6 col-xs-12">';
            $output .= '<div class="widget card card--has-table widget-leaders">';
            $output .= '<div class="widget__title card__header">';
            $output .= '<h4>'.$boxestitles[$key].'</h4>';
            $output .= '</div>';
            $output .= '<div class="widget__content card__content">';
            $output .= '<div class="table-responsive">';
            $output .= '<table class="table team-leader"><thead>';
            $k = 1;

            $output .= '<tr>
                <th class="team-leader__rank"></th>
                <th class="team-leader__type">'.esc_html__( 'Name', 'alchemists' ).'</th>
                <th class="team-leader__total">'.esc_html__( 'T', 'alchemists' ).'</th>
                <th class="team-leader__gp">'.esc_html__( 'GP', 'alchemists' ).'</th>
                <th class="team-leader__avg">'.esc_html__( 'AVG', 'alchemists' ).'</th>
            </tr>';
            
            $top_team = $val1;
            $top_team = array_shift($top_team);

            $output .= '</thead><tbody>';

            foreach($val1 as $value){
                if($k > 3){
                    break;
                }
                $team_id = $value['id'];
                $team = get_post($team_id);
                $thumbnail = '';
                $permalink = get_permalink($team->ID);
                
                $output .= '<tr>';
                $output .= '<td class="rounded-col"><span>'.$k.'</span></td>';
                $output .= '<td class="team-leader__player">';
                $output .= '<div class="team-leader__player-info">';
                if(has_post_thumbnail($team->ID)){
                    $thumbnail = get_the_post_thumbnail($team->ID, 'alchemists_player-xxs');
                    $output .= '<figure class="team-leader__player-img">
                        <a href="'.$permalink.'">'.$thumbnail.'</a>
                    </figure>';
                }
                $output .= '<div class="team-leader__player-inner">
                <h5 class="team-leader__player-name">
                    <a href="'.$permalink.'">'.$team->post_title.'</a>
                </h5></div>';
                $output .= '</div>';
                $output .= '</td>';
                $output .= '<td class="team-leader__total">';
                $output .= $value['value'];
                $output .= '</td>';
                $output .= '<td class="team-leader__gp">';
                $output .= $value['played'];
                $output .= '</td>';
                $output .= '<td class="team-leader__avg">';
                $output .= '</td>';
                $output .= '</tr>';
                $k++;
            }
            $output .= '<tbody></table>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            if($count % 3 == 0 && $count < count($data)){
                $output .= '</div><div class="row">';
            }
            $count++;
        }
    }
    $output .= '</div>';

    echo $output;

}
