<?php

define('COPA_CHILD_THEME_DIR', get_stylesheet_directory());
define('COPA_CHILD_THEME_URI', get_stylesheet_directory_uri());

require_once COPA_CHILD_THEME_DIR.'/copa-includes/base-actions.php';
require_once COPA_CHILD_THEME_DIR.'/copa-includes/shortcodes.php';

add_action('wp_enqueue_scripts', 'copa_child_thm_enqueue_scripts', 1000);

function copa_child_thm_enqueue_scripts(){
    $nonce = wp_create_nonce('kcm45a0995');
    // wp_enqueue_style('copa_style', COPA_CHILD_THEME_URI.'/style.css');
    wp_register_script('copa_tournaments_filter', COPA_CHILD_THEME_URI.'/js/copa_tournaments_filter.js', array('jquery'));
    wp_add_inline_script('copa_tournaments_filter', 'var copa_filter_nonce="'.$nonce.'", copa_ajax_url="'.admin_url('admin-ajax.php').'";');
}

add_action('page_before_content', 'display_pages_submenu', $priority = 10 );

/**
 * Sub menú
 */
function display_pages_submenu() {
    global $post;

    if( !$post ) return;
    if( is_404() ) return;

    if( $post->post_parent && $post->post_type === 'page' ) {

        $args = array(
            'post_parent' => $post->post_parent,
            'post_type'   => 'page', 
            'numberposts' => -1,
            'post_status' => 'publish',
            'orderby' => 'menu_order', 
            'order' => 'ASC'
        );
        
        $children = get_children( $args );

        if( count( $children ) > 0 ) {
            ob_start(); ?>
            <!-- Submenu -->
            <nav class="content-filter">
                <div class="container">
                    <a href="#" class="content-filter__toggle"></a>
                    <ul class="content-filter__list">
                        <?php foreach( $children as $child ): ?>
                            <li class="content-filter__item <?php if ( $post->ID === $child->ID ) { echo 'content-filter__item--active'; }; ?>">
                                <a href="<?php echo esc_url( get_permalink( $child->ID ) ); ?>" class="content-filter__link">
                                <?php echo esc_html( $child->post_title  ); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </nav>
            <!-- Submenu / End -->
            <?php
            echo ob_get_clean();
        }
    }
}

function copa_add_query_var_speventalbum( $vars ) {
    array_push( $vars, 'speventalbum' );
	return $vars;
}
add_filter( 'query_vars', 'copa_add_query_var_speventalbum' );

function copa_malta_theme_setup() {
    add_image_size('alchemists_thumbnail-player', 356, 356, array('cente', 'center')); // Player Normal
	add_image_size('alchemists_thumbnail-player-lg', 380, 380, array('cente', 'center')); // Player Large
	add_image_size('alchemists_thumbnail-player-lg-fit', 470, 470, array('cente', 'center')); // Player Large - fit
	add_image_size('alchemists_thumbnail-player-sm', 189, 189, array('left', 'top')); // Player Small
	add_image_size('alchemists_thumbnail-player-block', 140, 140, array('cente', 'center')); // Player Small (Team Blocks)
}
add_action( 'after_setup_theme', 'copa_malta_theme_setup', 20 );

/*
    add_image_size('alchemists_thumbnail-player', 356, 400, false); // Player Normal
	add_image_size('alchemists_thumbnail-player-lg', 380, 570, true); // Player Large
	add_image_size('alchemists_thumbnail-player-lg-fit', 470, 580, false); // Player Large - fit
	add_image_size('alchemists_thumbnail-player-sm', 189, 198, array('left', 'top')); // Player Small
    add_image_size('alchemists_thumbnail-player-block', 140, 210, true); // Player Small (Team Blocks)
 */

// acf for copa
require_once COPA_CHILD_THEME_DIR . '/copa-includes/acf-fields.php';