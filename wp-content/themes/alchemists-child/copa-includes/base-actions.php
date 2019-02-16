<?php

add_action('wp_ajax_copa_load_filter_vars', 'copa_load_filter_vars');
add_action('wp_ajax_nopriv_copa_load_filter_vars', 'copa_load_filter_vars');

function copa_load_filter_vars()
{
    if(isset($_POST['copa_filter_nonce']) && wp_verify_nonce($_POST['copa_filter_nonce'], 'kcm45a0995')){
        global $wpdb;
        if(isset($_POST['sp_tournament'])
        && !isset($_POST['sp_season'])  
        && $_POST['sp_tournament']
        && is_numeric($_POST['sp_tournament'])
        ){
            $args = array(
                'object_ids'               => (int)$_POST['sp_tournament'],
                'taxonomy'               => 'sp_season',
                'orderby'                => 'name',
                'order'                  => 'ASC',
                'hide_empty'             => true,
            );
            $the_query = new WP_Term_Query($args);
            $terms = $the_query->get_terms();
            if($terms && !is_wp_error($terms)){
                $printjson = array();
                foreach($terms as $term){
                    $printjson[$term->term_id] = $term->name;
                }
                echo json_encode($printjson);
            }
        }elseif(isset($_POST['sp_tournament']) 
        && $_POST['sp_tournament']
        && is_numeric($_POST['sp_tournament']) 
        && isset($_POST['sp_season']) 
        && $_POST['sp_season']
        && is_numeric($_POST['sp_season'])
        ){
            $sp_tournament = (int)$_POST['sp_tournament'];
            $sp_season = (int)$_POST['sp_season'];
            if(!isset($_POST['criteria']) || !$_POST['criteria']){
                $sql = $wpdb->prepare("SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type='sp_table' AND post_status='publish' AND ID IN(SELECT pm.post_id FROM {$wpdb->postmeta} pm INNER JOIN {$wpdb->term_relationships} tr ON pm.post_id=tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id=tt.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON tt.term_id=t.term_id WHERE t.term_id=%d AND tt.taxonomy='sp_season' AND pm.meta_key='sp_tournament' AND pm.meta_value='%d') ORDER BY post_title ASC", $sp_season, $sp_tournament);
                $results = $wpdb->get_results($sql);
                if($results && !is_wp_error($results)){
                    echo json_encode($results);
                }
            }else{
                // creteria based html output
                switch($_POST['criteria']){
                    case 'results':
                    case 'calender':
                        $sql = $wpdb->prepare("SELECT pm.meta_value FROM wp2_postmeta pm 
                        INNER JOIN wp2_posts p ON pm.post_id=p.ID 
                        WHERE p.post_type='sp_tournament' 
                        AND p.post_status='publish'
                        AND pm.meta_key='sp_event'
                        AND p.ID IN(SELECT tr.object_id FROM wp2_term_relationships tr 
                                    INNER JOIN wp2_term_taxonomy tt ON tr.term_taxonomy_id=tt.term_taxonomy_id
                                    INNER JOIN wp2_terms t ON tt.term_id=t.term_id
                                    WHERE tr.object_id=%d AND t.term_id=%d)", $sp_tournament, $sp_season);
                        $results = $wpdb->get_results($sql);
                        var_dump($results);
                        if($results && !is_wp_error($results)){
                            $layout_type = isset($_POST['criteria']) && $_POST['criteria'] ? $_POST['criteria'] : 'calender';
                            if($layout_type == 'calender'){
                                require_once COPA_CHILD_THEME_DIR.'/copa-includes/tournament-event-list.php';
                            }else{
                                require_once COPA_CHILD_THEME_DIR.'/copa-includes/tournament-results.php';
                            }
                        }
                    break;
                    case 'final': 
                        $tournament_id = $sp_tournament;
                        require_once COPA_CHILD_THEME_DIR.'/copa-includes/tournament-bracket.php';
                    break;
                }
            }
        }elseif(isset($_POST['sp_table']) 
        && $_POST['sp_table']
        && is_numeric($_POST['sp_table'])){
            $table_id = (int)$_POST['sp_table'];
            $layout_type = isset($_POST['criteria']) && $_POST['criteria'] ? $_POST['criteria'] : 'table';
            if(in_array($layout_type, array('teams_rankings','players_rankings'))){
                require_once COPA_CHILD_THEME_DIR.'/copa-includes/tournament-rankings.php';
                copa_display_tournament_teams_rankings($table_id, $layout_type);
            }elseif($layout_type == 'icon'){
                require_once COPA_CHILD_THEME_DIR.'/copa-includes/league-groups-icons.php';
            }else{
                require_once COPA_CHILD_THEME_DIR.'/copa-includes/league-table-part.php';
            }
        }elseif(isset($_POST['sp_team']) 
        && $_POST['sp_team'] 
        && is_numeric($_POST['sp_team'])){
            
            $id = (int)$_POST['sp_team'];

            if(isset($_POST['player_name']) && $_POST['player_name']){
                $args = array(
                    'team_id' => $id,
                    'player_name' => $_POST['player_name']
                );
                $copa_team_players_list = new Copa_Team_Players_List($args);
                $copa_team_players_list->alterplayers();
            }

            $layout_type = isset($_POST['criteria']) && $_POST['criteria'] ? $_POST['criteria'] : 'team_players';
            if($layout_type == 'team_players'){
                // $id  = $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_type='sp_list' AND post_status='publish' ORDER BY ID DESC LIMIT 1");
                if($id && function_exists('sp_get_template')){
                    sp_get_template('player-list.php', array(
                        'id' => $id,
                        // 'show_title' => false,
                    ));
                }
            }
        }
    }
    die();
}

class Copa_Team_Players_List{

    public $do_player_list_custom_filter = false;
    private $_args;

    public function __construct($args)
    {
        $this->_args = $args;
        add_filter('sportspress_player_list_players', array(&$this, 'copa_player_list_players_filter'), 11, 4);
    }
    public function alterplayers($action = true){
        $this->do_player_list_custom_filter = $action;
    }
    public function copa_player_list_players_filter($players = array(), $args = array(), $team = null, $team_key = null){
        global $wpdb;
        if($this->do_player_list_custom_filter && isset($this->_args['player_name']) 
        && $this->_args['player_name'] 
        && preg_match('/^[\d\w ]+$/',$this->_args['player_name'])){
            $sp_players = get_post_meta( $this->_args['team_id'], 'sp_players', true );
            if($sp_players){
                $sp_players = implode(',', array_keys($sp_players));
                $sql = sprintf("SELECT * FROM {$wpdb->posts} WHERE ID IN(%s) AND post_type='sp_player' AND post_status='publish' AND post_title LIKE '%%%s%%'", $sp_players, $this->_args['player_name']);
            }elseif((int)$team){
                $era = get_post_meta( $this->_args['team_id'], 'sp_era', true );
                $meta_key = $era == 'past'? 'sp_past_team' : 'sp_current_team';
                $sql = sprintf("SELECT * FROM {$wpdb->posts} WHERE ID IN(SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='%s' AND meta_value='%d') AND post_status='publish' AND post_type='sp_player' AND post_title LIKE '%%%s%%'", $meta_key, (int)$team, $this->_args['player_name']);
            }
            if(isset($sql) && $sql){
                $results = $wpdb->get_results($sql);
                if(!is_wp_error($results)){
                    $players = $results;
                    return $players;
                }
            }
            // $players = array();
        }
        return $players;
    }
}