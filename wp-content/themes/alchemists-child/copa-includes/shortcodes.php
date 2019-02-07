<?php


add_shortcode('copa_tournaments_filter', 'copa_tournaments_filter');

function copa_tournaments_filter($atts = array(), $content = null){
    
    global $wpdb;

    wp_enqueue_script('copa_tournaments_filter');

    extract(shortcode_atts(array('extra_css'), $atts, 'copa_tournaments_filter'));

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
/**
 * Shortcode for tournament results filter
 */

add_shortcode('copa_trm_results_filter', 'copa_trm_results_filter');

function copa_trm_results_filter($atts = array(), $content = null){
    
    global $wpdb;

    wp_enqueue_script('copa_tournaments_filter');

    extract(shortcode_atts(array('extra_css'), $atts, 'copa_tournaments_filter'));

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
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="results_sp_tournament">
                        <?php 
                        if(!empty($tournaments) && !is_wp_error($tournaments)){
                            foreach($tournaments as $tournament){    
                        ?>
                        <option value="<?php echo $tournament->ID?>"><?php echo $tournament->post_title;?></option>
                        <?php }}?>
                    </select>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="results_sp_season">
                        <?php foreach($tseasons as $t){?>
                        <option value="<?php echo $t->term_id?>"><?php echo $t->name?></option>
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