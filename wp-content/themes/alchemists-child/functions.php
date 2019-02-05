<?php

define('COPA_CHILD_THEME_DIR', get_stylesheet_directory());
define('COPA_CHILD_THEME_URI', get_stylesheet_directory_uri());


add_action('wp_enqueue_scripts', 'copa_child_thm_enqueue_scripts', 1000);
add_action('wp_ajax_copa_load_filter_vars', 'copa_load_filter_vars');
add_action('wp_ajax_nopriv_copa_load_filter_vars', 'copa_load_filter_vars');

function copa_child_thm_enqueue_scripts(){
    $nonce = wp_create_nonce('kcm45a0995');
    // wp_enqueue_style('copa_style', COPA_CHILD_THEME_URI.'/style.css');
    wp_register_script('copa_tournaments_filter', COPA_CHILD_THEME_URI.'/js/copa_tournaments_filter.js', array('jquery'));
    wp_add_inline_script('copa_tournaments_filter', 'var copa_filter_nonce="'.$nonce.'", copa_ajax_url="'.admin_url('admin-ajax.php').'";');
}

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
            $sql = $wpdb->prepare("SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type='sp_table' AND post_status='publish' AND ID IN(SELECT pm.post_id FROM {$wpdb->postmeta} pm INNER JOIN {$wpdb->term_relationships} tr ON pm.post_id=tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id=tt.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON tt.term_id=t.term_id WHERE t.term_id=%d AND tt.taxonomy='sp_season' AND pm.meta_key='sp_tournament' AND pm.meta_value='%d')", $sp_season, $sp_tournament);
            $results = $wpdb->get_results($sql);
            if($results && !is_wp_error($results)){
                echo json_encode($results);
            }
        }elseif(isset($_POST['sp_table']) 
        && $_POST['sp_table']
        && is_numeric($_POST['sp_table'])){
            $table_id = (int)$_POST['sp_table'];
            require_once COPA_CHILD_THEME_DIR.'/league-table-part.php';
        }
    }
    die();
}

add_shortcode('copa_tournaments_filter', 'copa_tournaments_filter');

function copa_tournaments_filter($atts = array(), $content = null){
    
    global $wpdb;

    wp_enqueue_script('copa_tournaments_filter');

    extract(shortcode_atts(array('extra_css'), $atts, 'copa_tournaments_filter'));

    /*$tournaments = get_posts(array(
        'post_type'=>'sp_tournament',
        'posts_per_page'=>-1,
    ));*/

    $tournaments = $wpdb->get_results("SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type='sp_tournament' AND post_status='publish' AND ID IN(SELECT tr.object_id FROM {$wpdb->term_relationships} tr INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id=tt.term_taxonomy_id WHERE tt.taxonomy='sp_season')");

    if(!$tournaments || is_wp_error($tournaments)){
        return '';
    }
    foreach($tournaments as $k=>$tournament){
        $found = $wpdb->get_var("SELECT COUNT(*) FROM `wp2_postmeta` WHERE meta_key='sp_tournament' AND meta_value='{$tournament->ID}'");
        if((int)$found < 1){
            unset($tournaments[$k]);
        }
    }

    $tempts = $tournaments;

    $tempts = array_shift($tempts);

    $args = array(
        'object_ids'               => (int)$tempts->ID,
        'taxonomy'               => 'sp_season',
        'orderby'                => 'name',
        'order'                  => 'ASC',
        'hide_empty'             => true,
    );
    $the_query = new WP_Term_Query($args);
    $tseasons = $the_query->get_terms();
    
    $sql = $wpdb->prepare("SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type='sp_table' AND post_status='publish' AND ID IN(SELECT pm.post_id FROM {$wpdb->postmeta} pm INNER JOIN {$wpdb->term_relationships} tr ON pm.post_id=tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id=tt.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON tt.term_id=t.term_id WHERE t.term_id=%d AND tt.taxonomy='sp_season' AND pm.meta_key='sp_tournament' AND pm.meta_value='%d')", $tseasons[0]->term_id, $tempts->ID);
    $tables = $wpdb->get_results($sql);

    ob_start();
    ?>
    <div class="copa_tournaments_filter<?php echo $extra_css? ' '.esc_attr($extra_css):null?>">
        <div class="filter-loading hidden"><span></span></div>
        <div class="copa_tournaments_filter_inputs">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <select name="dropdown_sp_tournament">
                        <!-- <option value=""><?php esc_html_e('-- Select Tournament --', 'alchemists')?></option> -->
                        <?php 
                        if(!empty($tournaments) && !is_wp_error($tournaments)){
                            foreach($tournaments as $tournament){    
                        ?>
                        <option value="<?php echo $tournament->ID?>"><?php echo $tournament->post_title;?></option>
                        <?php }}?>
                    </select>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <select name="dropdown_sp_season">
                        <!-- <option value=""><?php esc_html_e('-- Select Year --', 'alchemists')?></option> -->
                        <?php foreach($tseasons as $t){?>
                        <option value="<?php echo $t->term_id?>"><?php echo $t->name?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <select name="dropdown_sp_table">
                        <!-- <option value=""><?php esc_html_e('-- Select Group --', 'alchemists')?></option> -->
                        <?php foreach($tables as $table){?>
                        <option value="<?php echo $table->ID?>"><?php echo $table->post_title?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
        </div><br>
        <div class="copa_tournaments_filter_results">
        <?php
            $table_id = (int)$tables[0]->ID;
            require_once COPA_CHILD_THEME_DIR.'/league-table-part.php';
        ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}