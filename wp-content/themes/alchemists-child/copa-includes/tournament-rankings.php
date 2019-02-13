<?php

function copa_organize_teams_rankings_data($events, $teams){
    $merged = array();
    if($events){
        if(!isset($merged['goals'])){
            $merged['goalsgiven'] = array();
            $merged['goalsreceived'] = array();
        }
        foreach($events as $e){
            $event = get_post($e['id']);
            

            foreach($e['teams'] as $key=>$team){
                if(!isset($merged['goalsgiven'][$team])){
                    $merged['goalsgiven'][$team] = 0;
                }
                if(!isset($merged['goalsreceived'][$team])){
                    $merged['goalsreceived'][$team] = 0;
                }
                $merged['goalsgiven'][$team] += $e['results'][$key];
                if($key > 0){
                    $revkey = 0;
                }else{
                    $revkey = 1;
                }
                $merged['goalsreceived'][$team] += $e['results'][$revkey];
            }

            $players = get_post_meta($event->ID, 'sp_players', true);
            if($players){
                foreach($players as $team_id=>$data1){
                    array_shift($data1);

                }
            }
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
