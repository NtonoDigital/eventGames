<?php

function copa_display_tournament_teams_rankings($table_id){
    $table = new SP_League_Table( $table_id );
    $list = $table->data();
    print_r($list);

}
