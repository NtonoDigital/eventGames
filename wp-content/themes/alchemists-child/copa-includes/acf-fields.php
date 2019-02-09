<?php 
/**
 * Advance Custom Fields Definitions for 
 * Malta morena
 * 
 * @author Richard Blondet <richardblondet@gmail.com>
 */


// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

function maltamorena_acf_add_local_field_groups() {
    acf_add_local_field_group(array(
        'key' => 'group_maltamorena_2019_02_09_0331',
        'title' => esc_html__( 'Teams In Album', 'alchemists' ),
        'fields' => array(
            array(
                'key' => 'field_maltamorena_2019_02_09_0332',
                'label' => esc_html__( 'Teams', 'alchemists' ),
                'name' => 'teams_in_gallery_albums',
                'type' => 'post_object',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'sp_team',
                ),
                'taxonomy' => array(
                ),
                'allow_null' => 1,
                'multiple' => 1,
                'return_format' => 'object',
                'ui' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'albums',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'left',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));
}

add_action('acf/init', 'maltamorena_acf_add_local_field_groups');