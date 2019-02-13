<?php

function copa_organize_teams_rankings_data($events, $teams){
    $merged = array();
    if($events){
        if(!isset($merged['goals'])){
            $merged['goalsgiven'] = array();
            $merged['goalsreceived'] = array();
            $merged['assists'] = array();
            $merged['cards'] = array();
        }
        foreach($events as $e){
            $event = get_post($e['id']);
            

            foreach($e['teams'] as $key=>$team){
                if(!in_array($team, $teams)){
                    continue;
                }
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

            $players = get_post_meta($event->ID, 'sp_players', true);
            if($players){
                foreach($players as $team_id=>$data1){
                    if(!in_array($team_id, $teams)){
                        continue;
                    }
                    if(count($data1) > 0){
                        array_shift($data1); // 0 index actually having no data
                        foreach($data1 as $playerid => $loop){
                            if(!isset($merged['assists'][$team_id])){
                                $merged['assists'][$team_id] = 0;
                            }
                            if(!isset($merged['cards'][$team_id])){
                                $merged['cards'][$team_id] = 0;
                            }
                            $merged['assists'][$team_id] += (int)$loop['assists'];
                            $merged['cards'][$team_id] += (int)$loop['yellowcards'];
                            $merged['cards'][$team_id] += (int)$loop['redcards'];
                        }
                    }
                    
                }
            }
        }
    }
    if($merged){
        foreach($merged as &$m){
            arsort($m);
        }
    }
    return $merged;
}


function copa_display_tournament_teams_rankings($table_id){
    global $wpdb;
    $teams = $wpdb->get_col($wpdb->prepare("SELECT pm.meta_value FROM {$wpdb->postmeta} pm LEFT JOIN {$wpdb->posts} p ON pm.post_id=p.ID WHERE p.ID = %d AND pm.meta_key='sp_team' AND p.post_status='publish' AND pm.meta_value+0>0", $table_id));
    // $table = new SP_League_Table( $table_id );
    // $list = $table->data();
    $tournament = get_post_meta($table_id, 'sp_tournament', true);
    $events = get_post_meta($tournament, 'sp_events', true);
    $data = copa_organize_teams_rankings_data($events, $teams);

    echo '<pre>';
    // print_r($teams);
    // print_r($events);
    print_r($data);
    echo '</pre>';
}
