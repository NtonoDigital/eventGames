<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$defaults = array(
	'number' => -1,
	'columns' => null,
	'highlight' => null,
	'show_full_table_link' => false,
	'title' => false,
	'show_title' => get_option( 'sportspress_table_show_title', 'yes' ) == 'yes' ? true : false,
	'show_team_logo' => get_option( 'sportspress_table_show_logos', 'yes' ) == 'yes' ? true : false,
	'link_posts' => null,
	'responsive' => get_option( 'sportspress_enable_responsive_tables', 'no' ) == 'yes' ? true : false,
	'sortable' => get_option( 'sportspress_enable_sortable_tables', 'yes' ) == 'yes' ? true : false,
	'scrollable' => get_option( 'sportspress_enable_scrollable_tables', 'yes' ) == 'yes' ? true : false,
	'paginated' => get_option( 'sportspress_table_paginated', 'yes' ) == 'yes' ? true : false,
	'rows' => get_option( 'sportspress_table_rows', 10 ),
);

extract( $defaults, EXTR_SKIP );

$title = esc_html__('Tournament Results', 'alchemists');

$output = '';

$output .= '<div class="card card--has-table">';

if ( $title ) {
	$output .= '<header class="card__header">';
    $output .= '<h4 class="sp-table-caption">' . $title . '</h4>';
	$output .= '</header>';
}

$output .= '<div class="card__content">';

$output .= '<div class="table-responsive sp-table-wrapper">';

$output .= '<table class="table table-hover table-standings sp-league-table sp-data-table' . ( $responsive ? ' sp-responsive-table ' . $identifier : '' ). ( $scrollable ? ' sp-scrollable-table' : '' ) . ( $paginated ? ' sp-paginated-table' : '' ) . '" data-sp-rows="' . $rows . '">' . '<thead>' . '<tr>';

foreach($results as $result){
$table = new SP_Event((int)$result->meta_value);

$data = $table->outcome();

print_r($data);
}