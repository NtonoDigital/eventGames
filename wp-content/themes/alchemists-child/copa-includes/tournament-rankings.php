<?php

function copa_organize_teams_rankings_data($events){

}


function copa_display_tournament_teams_rankings($table_id){
    global $wpdb;
    $teams = $wpdb->get_col($wpdb->prepare("SELECT pm.meta_value FROM {$wpdb->postmeta} pm LEFT JOIN {$wpdb->posts} p ON pm.post_id=p.ID WHERE p.ID = %d AND pm.meta_key='sp_team' AND p.post_status='publish' AND pm.meta_value+0>0", $table_id));
    $table = new SP_League_Table( $table_id );
    $list = $table->data();
    $tournament = get_post_meta($table_id, 'sp_tournament', true);
    $events = get_post_meta($tournament, 'sp_events', true);
    echo '<pre>';
    print_r($teams);
    print_r($events);
    echo '</pre>';
}
