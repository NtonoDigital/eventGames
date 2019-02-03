<?php

// Redirect to theme Welcome screen
global $pagenow;

if (is_admin() && 'themes.php' == $pagenow && isset($_GET['activated'])) {
	wp_redirect(admin_url("admin.php?page=df-admin"));
}

// Theme Info
function df_get_theme_info() {
	$theme      = wp_get_theme();
	$theme_name = $theme->get('Name');
	$theme_v    = $theme->get('Version');

	$theme_info = array(
		'name' => $theme_name,
		'slug' => sanitize_file_name( strtolower( $theme_name ) ),
		'v'    => $theme_v,
	);

	return $theme_info;
}

function df_theme_response_comb( $theme ) {
	return array(
		'id'            => $theme['id'],
		'name'          => (!empty($theme['wordpress_theme_metadata']['theme_name']) ? $theme['wordpress_theme_metadata']['theme_name'] : ''),
		'author'        => (!empty($theme['wordpress_theme_metadata']['author_name']) ? $theme['wordpress_theme_metadata']['author_name'] : ''),
		'version'       => (!empty($theme['wordpress_theme_metadata']['version']) ? $theme['wordpress_theme_metadata']['version'] : ''),
		'url'           => (!empty($theme['url']) ? $theme['url'] : ''),
		'author_url'    => (!empty($theme['author_url']) ? $theme['author_url'] : ''),
		'thumbnail_url' => (!empty($theme['previews']['icon_preview']['icon_url']) ? $theme['previews']['icon_preview']['icon_url'] : ''),
		'rating'        => (!empty($theme['rating']) ? $theme['rating'] : ''),
	);
}

function df_get_token() {
	$token        = get_option( 'envato_market', array() );
	$return_token = '';
	if (!empty($token['token'])) {
		$return_token = $token['token'];
	}

	return $return_token;
}

function df_check_token($args = array()) {

	$has_token = get_site_transient( 'df_theme_token_added' );

	$purchased = false;

	if ( false === $has_token ) {
		$defaults = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . df_get_token(),
				'User-Agent' => 'WordPress - Alchemists',
			),
			'filter_by' => 'wordpress-themes',
			'timeout' => 20,
		);
		$args = wp_parse_args($args, $defaults);

		$url = 'https://api.envato.com/v3/market/buyer/list-purchases?filter_by=wordpress-themes';

		$response = wp_remote_get(esc_url_raw($url), $args);

		// Check the response code.
		$response_code = wp_remote_retrieve_response_code( $response );

		if ( $response_code == '200' ) {
			$return = json_decode( wp_remote_retrieve_body( $response ), true );
			foreach ($return['results'] as $theme) {
				$theme_info = df_theme_response_comb( $theme['item'] );

				if ( DF_ITEM_NAME == strtolower( $theme_info['name'] ) ) {
					$purchased = true;
					set_site_transient('df_theme_token_added', 'token_set');
				}
			}

			if (!$purchased) {
				$purchased = false;
				delete_site_transient('df_theme_token_added');
			}
		}
	} else {
		$purchased = true;
	}

	return $purchased;
}

function df_set_token() {
	if (isset($_POST['df_registration'])) {
		if (isset($_POST['df_registration']['token'])) {
			delete_site_transient('df_theme_token_added');

			$token = array();
			$token['token'] = sanitize_text_field($_POST['df_registration']['token']);

			update_option('envato_market', $token);

			$envato_market = Envato_Market::instance();
			$envato_market->items()->set_themes(true);
		}
	}
}

add_action('init', 'df_set_token');

function df_convert_memory($size) {
	$l = substr($size, -1);
	$ret = substr($size, 0, -1);
	switch (strtoupper($l)) {
		case 'P':
			$ret *= 1024;
		case 'T':
			$ret *= 1024;
		case 'G':
			$ret *= 1024;
		case 'M':
			$ret *= 1024;
		case 'K':
			$ret *= 1024;
	}
	return $ret;
}

function df_theme_support_url() {
	return 'https://danfisher.ticksy.com';
}

function df_theme_fb_page_url() {
	return 'https://www.facebook.com/danfisher.dev/';
}

function df_remove_theme_options_submenu() {
	$check_token = df_check_token();
	if ( !$check_token ) {
		remove_menu_page( '_options' );
		remove_submenu_page( 'themes.php', 'pt-one-click-demo-import' );
	}
}
add_action( 'admin_menu', 'df_remove_theme_options_submenu', 999 );


function df_remove_customizer() {
	$check_token = df_check_token();
	// remove Customizer
	if ( !$check_token ) {
		require_once get_template_directory() . '/admin/includes/wp-crap.php';
	}
}
add_action( 'after_setup_theme', 'df_remove_customizer' );


function df_remove_toolbar_theme_options() {
	$check_token = df_check_token();
	// remove Customizer
	if ( !$check_token ) {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('_options');
	}
}
add_action('wp_before_admin_bar_render', 'df_remove_toolbar_theme_options', 999);
