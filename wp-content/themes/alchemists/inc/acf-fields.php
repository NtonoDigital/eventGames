<?php
/**
 * Programmatic registration of Advanced Custom Fields fields
 *
 * @see http://www.advancedcustomfields.com/resources/register-fields-via-php/
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}


function alchemists_acf_add_local_field_groups() {

	acf_add_local_field_group(array(
		'key' => 'group_58ff529930c76',
		'title' => esc_html__( 'Albums Photos', 'alchemists' ),
		'fields' => array(
			array(
				'key' => 'field_58ff52b4656af',
				'label' => esc_html__( 'Album Photos', 'alchemists' ),
				'name' => 'album_photos',
				'type' => 'gallery',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'min' => '',
				'max' => '',
				'insert' => 'append',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
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
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

	acf_add_local_field_group(array(
		'key' => 'group_5924aece2672e',
		'title' => esc_html__( 'Page Options', 'alchemists' ),
		'fields' => array(
			array(
				'key' => 'field_5924aed817453',
				'label' => esc_html__( 'Page Heading', 'alchemists' ),
				'name' => 'page_heading',
				'type' => 'radio',
				'instructions' => esc_html__( 'Select Page Heading Type', 'alchemists' ),
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'choices' => array(
					'page_default' => esc_html__( 'Title', 'alchemists' ),
					'page_hero' => esc_html__( 'Hero Unit - Static', 'alchemists' ),
					'page_hero_posts_slider' => esc_html__( 'Hero Unit - Posts Slider', 'alchemists' ),
					'page_none' => esc_html__( 'None', 'alchemists' ),
				),
				'allow_null' => 0,
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'page_default : Default',
				'layout' => 'vertical',
				'return_format' => 'value',
			),
			array(
				'key' => 'field_5a033537c16f6',
				'label' => esc_html__( 'Customize Page Heading?', 'alchemists' ),
				'name' => 'page_heading_customize',
				'type' => 'true_false',
				'instructions' => esc_html__( 'Enables customization options.', 'alchemists' ),
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_5924aed817453',
							'operator' => '==',
							'value' => 'page_default',
						),
					),
				),
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'message' => '',
				'default_value' => 0,
				'ui' => 1,
				'ui_on_text' => '',
				'ui_off_text' => '',
			),
			array(
				'key' => 'field_5a03339124ad4',
				'label' => esc_html__( 'Custom Background Image', 'alchemists' ),
				'name' => 'page_heading_custom_background_img',
				'type' => 'image',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_5a033537c16f6',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			),
			array(
				'key' => 'field_5a0336f7d7c68',
				'label' => esc_html__( 'Custom Background Color', 'alchemists' ),
				'name' => 'page_heading_custom_background_color',
				'type' => 'color_picker',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_5a033537c16f6',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
			),
			array(
				'key' => 'field_5a03379a1b077',
				'label' => esc_html__( 'Add Overlay?', 'alchemists' ),
				'name' => 'page_heading_add_overlay_on',
				'type' => 'true_false',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_5a033537c16f6',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'message' => '',
				'default_value' => 1,
				'ui' => 1,
				'ui_on_text' => '',
				'ui_off_text' => '',
			),
			array(
				'key' => 'field_5a036662eacd6',
				'label' => esc_html__( 'Remove Overlay Pattern?', 'alchemists' ),
				'name' => 'page_heading_remove_overlay_pattern',
				'type' => 'true_false',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_5a033537c16f6',
							'operator' => '==',
							'value' => '1',
						),
						array(
							'field' => 'field_5a03379a1b077',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'message' => '',
				'default_value' => 0,
				'ui' => 1,
				'ui_on_text' => '',
				'ui_off_text' => '',
			),
			array(
				'key' => 'field_5a0339208dda6',
				'label' => esc_html__( 'Custom Overlay Color', 'alchemists' ),
				'name' => 'page_heading_custom_overlay_color',
				'type' => 'color_picker',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_5a033537c16f6',
							'operator' => '==',
							'value' => '1',
						),
						array(
							'field' => 'field_5a03379a1b077',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
			),
			array(
				'key' => 'field_5a033a068d85a',
				'label' => esc_html__( 'Custom Overlay Opacity', 'alchemists' ),
				'name' => 'page_heading_custom_overlay_opacity',
				'type' => 'range',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_5a033537c16f6',
							'operator' => '==',
							'value' => '1',
						),
						array(
							'field' => 'field_5a03379a1b077',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => 40,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'prepend' => '',
				'append' => '',
			),
			array(
				'key' => 'field_592d75db746a5',
				'label' => esc_html__( 'Content Top Padding', 'alchemists' ),
				'name' => 'page_content_top_padding',
				'type' => 'select',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'choices' => array(
					'default' => esc_html__( 'Default', 'alchemists' ),
					'none' => esc_html__( 'None', 'alchemists' ),
				),
				'default_value' => array(
					0 => 'default',
				),
				'allow_null' => 0,
				'multiple' => 0,
				'ui' => 0,
				'ajax' => 0,
				'return_format' => 'value',
				'placeholder' => '',
			),
			array(
				'key' => 'field_592d76ad746a6',
				'label' => esc_html__( 'Content Bottom Padding', 'alchemists' ),
				'name' => 'page_content_bottom_padding',
				'type' => 'select',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'choices' => array(
					'default' => esc_html__( 'Default', 'alchemists' ),
					'none' => esc_html__( 'None', 'alchemists' ),
				),
				'default_value' => array(
					0 => 'default',
				),
				'allow_null' => 0,
				'multiple' => 0,
				'ui' => 0,
				'ajax' => 0,
				'return_format' => 'value',
				'placeholder' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
				),
			),
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'sp_team',
				),
			),
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'sp_directory',
				),
			),
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'sp_tournament',
				),
			),
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'sp_event',
				),
			),
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'sp_table',
				),
			),
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'sp_calendar',
				),
			),
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'albums',
				),
			),
		),
		'menu_order' => 100,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'left',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

	acf_add_local_field_group(array(
		'key' => 'group_58f3ecce6e041',
		'title' => esc_html__( 'Player Bio', 'alchemists' ),
		'fields' => array(
			array(
				'key' => 'field_58f3f4ac21e0c',
				'label' => esc_html__( 'Player Image', 'alchemists' ),
				'name' => 'player_image',
				'type' => 'image',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '12',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'array',
				'preview_size' => 'thumbnail',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			),
			array(
				'key' => 'field_58f3ecdb1d6cb',
				'label' => esc_html__( 'Player Bio Content', 'alchemists' ),
				'name' => 'player_bio_content',
				'type' => 'wysiwyg',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '53',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => 1,
				'delay' => 0,
			),
			array(
				'key' => 'field_58f3ed471d6cc',
				'label' => esc_html__( 'Player Bio Events', 'alchemists' ),
				'name' => 'player_bio_events',
				'type' => 'repeater',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '35',
					'class' => '',
					'id' => '',
				),
				'collapsed' => '',
				'min' => 0,
				'max' => 0,
				'layout' => 'row',
				'button_label' => esc_html__( 'Add Event', 'alchemists' ),
				'sub_fields' => array(
					array(
						'key' => 'field_58f3ede1d832c',
						'label' => esc_html__( 'Type', 'alchemists' ),
						'name' => 'event_type',
						'type' => 'select',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'Injury' => esc_html__( 'Injury', 'alchemists' ),
							'Join' => esc_html__( 'Join', 'alchemists' ),
							'Award' => esc_html__( 'Award', 'alchemists' ),
							'Exit' => esc_html__( 'Exit', 'alchemists' ),
							'Oth-Pos' => esc_html__( 'Other Positive', 'alchemists' ),
							'Oth-Neg' => esc_html__( 'Other Negative', 'alchemists' ),
						),
						'default_value' => array(
						),
						'allow_null' => 0,
						'multiple' => 0,
						'ui' => 0,
						'ajax' => 0,
						'return_format' => 'value',
						'placeholder' => '',
					),
					array(
						'key' => 'field_58f3ee12d832d',
						'label' => esc_html__( 'Content', 'alchemists' ),
						'name' => 'event_content',
						'type' => 'textarea',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => 3,
						'new_lines' => '',
					),
					array(
						'key' => 'field_58f3ee23d832e',
						'label' => esc_html__( 'Date', 'alchemists' ),
						'name' => 'event_date',
						'type' => 'date_picker',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'display_format' => 'F j, Y',
						'return_format' => 'F j, Y',
						'first_day' => 1,
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'sp_player',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

	acf_add_local_field_group(array(
		'key' => 'group_58fcbfbd2560e',
		'title' => esc_html__( 'Player Heading Photo', 'alchemists' ),
		'fields' => array(
			array(
				'key' => 'field_58fcc00499d46',
				'label' => esc_html__( 'Alternative Photo', 'alchemists' ),
				'name' => 'heading_player_photo',
				'type' => 'image',
				'instructions' => esc_html__( 'This photo displayed in the Page Header and Featured Player widgets.', 'alchemists' ),
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'id',
				'preview_size' => 'medium',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'sp_player',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'side',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

	acf_add_local_field_group(array(
		'key' => 'group_5940438ed751f',
		'title' => esc_html__( 'Product Options', 'alchemists' ),
		'fields' => array(
			array(
				'key' => 'field_59404484e31db',
				'label' => esc_html__( 'Product Gradient Color 1', 'alchemists' ),
				'name' => 'product_grad_color_1',
				'type' => 'color_picker',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '#fe2b00',
			),
			array(
				'key' => 'field_59404507e31dc',
				'label' => esc_html__( 'Product Gradient Color 2', 'alchemists' ),
				'name' => 'product_grad_color_2',
				'type' => 'color_picker',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '#f7d500',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
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

	acf_add_local_field_group(array(
		'key' => 'group_58ff538a7cb77',
		'title' => esc_html__( 'Team Gallery', 'alchemists' ),
		'fields' => array(
			array(
				'key' => 'field_58ff5392bec33',
				'label' => esc_html__( 'Albums', 'alchemists' ),
				'name' => 'team_gallery_albums',
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
					0 => 'albums',
				),
				'taxonomy' => array(
				),
				'allow_null' => 0,
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
					'value' => 'sp_team',
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


	if ( alchemists_sp_preset('soccer') ) {

		// Team Roster Option - Soccer
		acf_add_local_field_group(array(
			'key' => 'group_58fca7b5b53ec',
			'title' => esc_html__( 'Team Roster', 'alchemists' ),
			'fields' => array(
				array(
					'key' => 'field_58fca7bbfbeb5',
					'label' => esc_html__( 'Featured Gallery Roster', 'alchemists' ),
					'name' => 'gallery_roster_show',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => '',
					'default_value' => 1,
					'ui' => 0,
					'ui_on_text' => '',
					'ui_off_text' => '',
				),
				array(
					'key' => 'field_58fca8b1aadab',
					'label' => esc_html__( 'Select Gallery Roster', 'alchemists' ),
					'name' => 'gallery_roster',
					'type' => 'post_object',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_58fca7bbfbeb5',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => array(
						0 => 'sp_list',
					),
					'taxonomy' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'return_format' => 'object',
					'ui' => 1,
				),
				array(
					'key' => 'field_5901f759b8d8c',
					'label' => esc_html__( 'Gallery Roster Type', 'alchemists' ),
					'name' => 'gallery_roster_type',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_58fca7bbfbeb5',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'grid' => esc_html__( 'Grid', 'alchemists' ),
						'blocks' => esc_html__( 'Blocks', 'alchemists' ),
						'slider' => esc_html__( 'Slider Soccer', 'alchemists' ),
						'slider-card' => esc_html__( 'Slider Default', 'alchemists' ),
						'cards' => esc_html__( 'Cards', 'alchemists' ),
					),
					'default_value' => array(
						0 => 'grid',
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'ajax' => 0,
					'return_format' => 'value',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5901fa1554dbb',
					'label' => esc_html__( 'Slider Autoplay', 'alchemists' ),
					'name' => 'roster_slider_autoplay',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5901f759b8d8c',
								'operator' => '==',
								'value' => 'slider',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => '',
					'default_value' => 1,
					'ui' => 0,
					'ui_on_text' => '',
					'ui_off_text' => '',
				),
				array(
					'key' => 'field_58fcafde0456f',
					'label' => esc_html__( 'List Roster(s)', 'alchemists' ),
					'name' => 'list_roster_show',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => '',
					'default_value' => 1,
					'ui' => 0,
					'ui_on_text' => '',
					'ui_off_text' => '',
				),
				array(
					'key' => 'field_58fcb01004570',
					'label' => esc_html__( 'Select List Roster(s)', 'alchemists' ),
					'name' => 'list_roster',
					'type' => 'post_object',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_58fcafde0456f',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => array(
						0 => 'sp_list',
					),
					'taxonomy' => array(
					),
					'allow_null' => 0,
					'multiple' => 1,
					'return_format' => 'object',
					'ui' => 1,
				),
				array(
					'key' => 'field_58fcd61f40f10',
					'label' => esc_html__( 'Featured Player', 'alchemists' ),
					'name' => 'featured_player',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => '',
					'default_value' => 1,
					'ui' => 0,
					'ui_on_text' => '',
					'ui_off_text' => '',
				),
				array(
					'key' => 'field_58fcd5ddd46f3',
					'label' => esc_html__( 'Select Featured Player', 'alchemists' ),
					'name' => 'team_featured_player',
					'type' => 'post_object',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_58fcd61f40f10',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => array(
						0 => 'sp_player',
					),
					'taxonomy' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'return_format' => 'id',
					'ui' => 1,
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'sp_team',
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

	} else {

		// Team Roster Option - Basketball
		acf_add_local_field_group(array(
			'key' => 'group_58fca7b5b53ec',
			'title' => esc_html__( 'Team Roster', 'alchemists' ),
			'fields' => array(
				array(
					'key' => 'field_58fca7bbfbeb5',
					'label' => esc_html__( 'Featured Gallery Roster', 'alchemists' ),
					'name' => 'gallery_roster_show',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => '',
					'default_value' => 1,
					'ui' => 0,
					'ui_on_text' => '',
					'ui_off_text' => '',
				),
				array(
					'key' => 'field_58fca8b1aadab',
					'label' => esc_html__( 'Select Gallery Roster', 'alchemists' ),
					'name' => 'gallery_roster',
					'type' => 'post_object',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_58fca7bbfbeb5',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => array(
						0 => 'sp_list',
					),
					'taxonomy' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'return_format' => 'object',
					'ui' => 1,
				),
				array(
					'key' => 'field_5901f759b8d8c',
					'label' => esc_html__( 'Gallery Roster Type', 'alchemists' ),
					'name' => 'gallery_roster_type',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_58fca7bbfbeb5',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'grid' => esc_html__( 'Grid', 'alchemists' ),
						'blocks' => esc_html__( 'Blocks', 'alchemists' ),
						'slider' => esc_html__( 'Slider', 'alchemists' ),
					),
					'default_value' => array(
						0 => 'grid',
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'ajax' => 0,
					'return_format' => 'value',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5901fa1554dbb',
					'label' => esc_html__( 'Slider Autoplay', 'alchemists' ),
					'name' => 'roster_slider_autoplay',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5901f759b8d8c',
								'operator' => '==',
								'value' => 'slider',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => '',
					'default_value' => 1,
					'ui' => 0,
					'ui_on_text' => '',
					'ui_off_text' => '',
				),
				array(
					'key' => 'field_5901fc6bda17d',
					'label' => esc_html__( 'Slider Custom Background Image', 'alchemists' ),
					'name' => 'roster_slider_background_image',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5901f759b8d8c',
								'operator' => '==',
								'value' => 'slider',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'url',
					'preview_size' => 'thumbnail',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array(
					'key' => 'field_58fcafde0456f',
					'label' => esc_html__( 'List Roster(s)', 'alchemists' ),
					'name' => 'list_roster_show',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => '',
					'default_value' => 1,
					'ui' => 0,
					'ui_on_text' => '',
					'ui_off_text' => '',
				),
				array(
					'key' => 'field_58fcb01004570',
					'label' => esc_html__( 'Select List Roster(s)', 'alchemists' ),
					'name' => 'list_roster',
					'type' => 'post_object',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_58fcafde0456f',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => array(
						0 => 'sp_list',
					),
					'taxonomy' => array(
					),
					'allow_null' => 0,
					'multiple' => 1,
					'return_format' => 'object',
					'ui' => 1,
				),
				array(
					'key' => 'field_58fcd61f40f10',
					'label' => esc_html__( 'Featured Player', 'alchemists' ),
					'name' => 'featured_player',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => '',
					'default_value' => 1,
					'ui' => 0,
					'ui_on_text' => '',
					'ui_off_text' => '',
				),
				array(
					'key' => 'field_58fcd5ddd46f3',
					'label' => esc_html__( 'Select Featured Player', 'alchemists' ),
					'name' => 'team_featured_player',
					'type' => 'post_object',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_58fcd61f40f10',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => array(
						0 => 'sp_player',
					),
					'taxonomy' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'return_format' => 'id',
					'ui' => 1,
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'sp_team',
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

	acf_add_local_field_group(array(
		'key' => 'group_591dc7aae82be',
		'title' => esc_html__( 'Team Standings', 'alchemists' ),
		'fields' => array(
			array(
				'key' => 'field_591dc7dcfa595',
				'label' => esc_html__( 'Team Leagues', 'alchemists' ),
				'name' => 'team_leagues',
				'type' => 'post_object',
				'instructions' => esc_html__( 'Select Leagues you want to display on Team Standings page.', 'alchemists' ),
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'post_type' => array(
					0 => 'sp_table',
				),
				'taxonomy' => array(
				),
				'allow_null' => 0,
				'multiple' => 1,
				'return_format' => 'id',
				'ui' => 1,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'sp_team',
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

	acf_add_local_field_group(array(
		'key' => 'group_58f3a3264df65',
		'title' => esc_html__( 'Player Gallery', 'alchemists' ),
		'fields' => array(
			array(
				'key' => 'field_58f3a330f283b',
				'label' => esc_html__( 'Images', 'alchemists' ),
				'name' => 'images',
				'type' => 'gallery',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'min' => '',
				'max' => '',
				'insert' => 'append',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'sp_player',
				),
			),
		),
		'menu_order' => 1,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

	acf_add_local_field_group(array(
		'key' => 'group_58f50e018853f',
		'title' => esc_html__( 'Player Related News', 'alchemists' ),
		'fields' => array(
			array(
				'key' => 'field_58f50e0bab60a',
				'label' => esc_html__( 'Post Tags', 'alchemists' ),
				'name' => 'post_tags',
				'type' => 'taxonomy',
				'instructions' => esc_html__( 'Selected Posts tag that are related to the Player.', 'alchemists' ),
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'taxonomy' => 'post_tag',
				'field_type' => 'multi_select',
				'allow_null' => 0,
				'add_term' => 1,
				'save_terms' => 0,
				'load_terms' => 0,
				'return_format' => 'id',
				'multiple' => 0,
			),
			array(
				'key' => 'field_58f518c888fa2',
				'label' => esc_html__( 'Number of Posts', 'alchemists' ),
				'name' => 'number_of_posts',
				'type' => 'number',
				'instructions' => esc_html__( 'Enter number of displayed Posts.', 'alchemists' ),
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => 5,
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => 1,
				'max' => '',
				'step' => 1,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'sp_player',
				),
			),
		),
		'menu_order' => 2,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'left',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

	acf_add_local_field_group(array(
		'key' => 'group_59d3aa54eafe0',
		'title' => esc_html__( 'Player Header', 'alchemists' ),
		'fields' => array(
			array(
				'key' => 'field_59d3ac2622f31',
				'label' => esc_html__( 'Player List', 'alchemists' ),
				'name' => 'player_header_list',
				'type' => 'post_object',
				'instructions' => esc_html__( 'Select Player List for statistics comparing.', 'alchemists' ),
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'post_type' => array(
					0 => 'sp_list',
				),
				'taxonomy' => array(
				),
				'allow_null' => 0,
				'multiple' => 0,
				'return_format' => 'id',
				'ui' => 1,
			),
			array(
				'key' => 'field_5a086c7655435',
				'label' => esc_html__( 'Show Advanced Stats?', 'alchemists' ),
				'name' => 'player_page_heading_advanced_stats',
				'type' => 'true_false',
				'instructions' => esc_html__( 'Progress bars, radar charts etc.', 'alchemists' ),
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'message' => '',
				'default_value' => 1,
				'ui' => 1,
				'ui_on_text' => '',
				'ui_off_text' => '',
			),
			array(
				'key' => 'field_5a037bf1115c5',
				'label' => esc_html__( 'Customize Page Heading?', 'alchemists' ),
				'name' => 'player_page_heading_customize',
				'type' => 'true_false',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'message' => '',
				'default_value' => 0,
				'ui' => 1,
				'ui_on_text' => '',
				'ui_off_text' => '',
			),
			array(
				'key' => 'field_5a037c4f115c6',
				'label' => esc_html__( 'Custom Background Image', 'alchemists' ),
				'name' => 'player_page_heading_custom_background_img',
				'type' => 'image',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_5a037bf1115c5',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			),
			array(
				'key' => 'field_5a037cdf115c7',
				'label' => esc_html__( 'Custom Background Color', 'alchemists' ),
				'name' => 'player_page_heading_custom_background_color',
				'type' => 'color_picker',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_5a037bf1115c5',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
			),
			array(
				'key' => 'field_5a037d46cd50d',
				'label' => esc_html__( 'Add Overlay?', 'alchemists' ),
				'name' => 'player_page_heading_add_overlay_on',
				'type' => 'true_false',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_5a037bf1115c5',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'message' => '',
				'default_value' => 1,
				'ui' => 1,
				'ui_on_text' => '',
				'ui_off_text' => '',
			),
			array(
				'key' => 'field_5a037d7acd50e',
				'label' => esc_html__( 'Remove Overlay Pattern?', 'alchemists' ),
				'name' => 'player_page_heading_remove_overlay_pattern',
				'type' => 'true_false',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_5a037bf1115c5',
							'operator' => '==',
							'value' => '1',
						),
						array(
							'field' => 'field_5a037d46cd50d',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'message' => '',
				'default_value' => 0,
				'ui' => 1,
				'ui_on_text' => '',
				'ui_off_text' => '',
			),
			array(
				'key' => 'field_5a037dbb01a83',
				'label' => esc_html__( 'Custom Overlay Color', 'alchemists' ),
				'name' => 'player_page_heading_custom_overlay_color',
				'type' => 'color_picker',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_5a037bf1115c5',
							'operator' => '==',
							'value' => '1',
						),
						array(
							'field' => 'field_5a037d46cd50d',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
			),
			array(
				'key' => 'field_5a037de501a85',
				'label' => esc_html__( 'Custom Overlay Opacity', 'alchemists' ),
				'name' => 'player_page_heading_custom_overlay_opacity',
				'type' => 'range',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_5a037bf1115c5',
							'operator' => '==',
							'value' => '1',
						),
						array(
							'field' => 'field_5a037d46cd50d',
							'operator' => '==',
							'value' => '1',
						),
					),
				),
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => 40,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'prepend' => '',
				'append' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'sp_player',
				),
			),
		),
		'menu_order' => 3,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'left',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

	acf_add_local_field_group(array(
		'key' => 'group_5a078cb3065eb',
		'title' => esc_html__( 'Post Options', 'alchemists' ),
		'fields' => array(
			array(
				'key' => 'field_5a078cc4e78ab',
				'label' => esc_html__( 'Post Layout', 'alchemists' ),
				'name' => 'post_layout',
				'type' => 'select',
				'instructions' => esc_html__( 'This option overrides the general post layout.', 'alchemists' ),
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'choices' => array(
					'layout_1' => esc_html__( 'Post Layout 1', 'alchemists' ),
					'layout_2' => esc_html__( 'Post Layout 2', 'alchemists' ),
					'layout_3' => esc_html__( 'Post Layout 3', 'alchemists' ),
					'layout_4' => esc_html__( 'Post Layout 4', 'alchemists' ),
				),
				'default_value' => array(
				),
				'allow_null' => 1,
				'multiple' => 0,
				'ui' => 0,
				'ajax' => 0,
				'return_format' => 'value',
				'placeholder' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'left',
		'instruction_placement' => 'field',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

}

add_action('acf/init', 'alchemists_acf_add_local_field_groups');
