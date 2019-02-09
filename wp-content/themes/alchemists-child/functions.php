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

require_once COPA_CHILD_THEME_DIR . '/copa-includes/acf-fields.php';