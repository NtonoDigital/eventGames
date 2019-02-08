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
                $sql = $wpdb->prepare("SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type='sp_table' AND post_status='publish' AND ID IN(SELECT pm.post_id FROM {$wpdb->postmeta} pm INNER JOIN {$wpdb->term_relationships} tr ON pm.post_id=tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id=tt.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON tt.term_id=t.term_id WHERE t.term_id=%d AND tt.taxonomy='sp_season' AND pm.meta_key='sp_tournament' AND pm.meta_value='%d')", $sp_season, $sp_tournament);
                $results = $wpdb->get_results($sql);
                if($results && !is_wp_error($results)){
                    echo json_encode($results);
                }
            }else{
                // creteria based html output
                switch($_POST['criteria']){
                    case 'results':
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
                        if($results && !is_wp_error($results)){
                            require_once COPA_CHILD_THEME_DIR.'/copa-includes/tournament-results.php';
                        }
                    break;
                }
            }
        }elseif(isset($_POST['sp_table']) 
        && $_POST['sp_table']
        && is_numeric($_POST['sp_table'])){
            $table_id = (int)$_POST['sp_table'];
            $layout_type = isset($_POST['criteria']) && $_POST['criteria'] ? $_POST['criteria'] : 'table';
            if($layout_type == 'icon'){
                require_once COPA_CHILD_THEME_DIR.'/copa-includes/league-groups-icons.php';
            }else{
                require_once COPA_CHILD_THEME_DIR.'/copa-includes/league-table-part.php';
            }
        }
    }
    die();
}