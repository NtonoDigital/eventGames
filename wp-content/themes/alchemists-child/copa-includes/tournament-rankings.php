<?php

function copa_organize_teams_rankings_data($events, $teams){
    $merged = array();
    if($events){
        
        $merged['goalsgiven'] = array();
        $merged['goalsreceived'] = array();
        $merged['assists'] = array();
        $merged['cards'] = array();
        
        foreach($events as $e){
            $event = get_post($e['id']);
            
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

    $boxestitles = array(
        'goalsgiven' => esc_html__('Goals Made', 'alchemists'),
        'goalsreceived' => esc_html__('Goals Received', 'alchemists'),
        'assists' => esc_html__('Assists', 'alchemists'),
        'cards' => esc_html__('Cards', 'alchemists'),
        'mvp' => esc_html__('MVP', 'alchemists'),
    );

    
    $output = '<div class="row">';

    foreach($data as $key=>$val1){
        if($val1){
            $output .= '<div class="col-md-4 col-sm-6 col-xs-12">';
            $output .= '<div class="widget card card--has-table widget-leaders">';
            $output .= '<div class="widget__title card__header">';
            $output .= '<h4>'.$boxestitles[$key].'</h4>';
            $output .= '</div>';
            $output .= '<div class="widget__content card__content">';
            $output .= '<div class="table-responsive">';
            $output .= '<table class="table team-leader"><tbody>';
            $k = 1;
            foreach($val1 as $team_id=>$value){
                if($k > 3){
                    break;
                }
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
                $output .= '</tr>';
                $k++;
            }
            $output .= '<tbody></table>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
        }
    }
    $output .= '</div>';

    echo $output;

}
