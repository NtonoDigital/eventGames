<?php

/**
 * TGM Init Class
 */

include_once get_template_directory() . '/admin/tgm/class-tgm-plugin-activation.php';

if ( ! function_exists('alchemists_register_required_plugins')) {
	function alchemists_register_required_plugins() {

		$plugins = array(
			array(
				'name'         => 'Redux Framework',
				'slug'         => 'redux-framework',
				'required'     => true,
			),
			array(
				'name'         => 'Advanced Custom Fields Pro',
				'slug'         => 'advanced-custom-fields-pro',
				'source'       => 'https://s3.us-east-2.amazonaws.com/danfisher-bucket-1/plugins/RKyjLhX8/advanced-custom-fields-pro.zip',
				'required'     => true,
				'version'      => '5.7.8'
			),
			array(
				'name'         => 'WPBakery Page Builder for WordPress',
				'slug'         => 'js_composer',
				'source'       => 'https://s3.us-east-2.amazonaws.com/danfisher-bucket-1/plugins/RKyjLhX8/js_composer.zip',
				'required'     => true,
				'version'      => '5.6'
			),
			array(
				'name'         => 'Alchemists Advanced Posts',
				'slug'         => 'alc-advanced-posts',
				'source'       => 'https://s3.us-east-2.amazonaws.com/danfisher-bucket-1/plugins/RKyjLhX8/alc-advanced-posts.zip',
				'required'     => true,
				'version'      => '1.0.6'
			),
			array(
				'name'         => 'Alchemists SCSS Compiler',
				'slug'         => 'alc-scss',
				'source'       => 'https://s3.us-east-2.amazonaws.com/danfisher-bucket-1/plugins/RKyjLhX8/alc-scss.zip',
				'required'     => true,
				'version'      => '3.0.4',
			),
			array(
				'name'         => 'One Click Demo Import',
				'slug'         => 'one-click-demo-import',
				'required' 	   => true,
			),
			array(
				'name'         => 'Contact Form 7',
				'slug'         => 'contact-form-7',
				'required'     => false,
			),
			array(
				'name'         => 'Breadcrumb Trail',
				'slug'         => 'breadcrumb-trail',
				'required'     => true,
			),
			array(
				'name'         => 'MailChimp for WordPress',
				'slug'         => 'mailchimp-for-wp',
				'required'     => false,
			),
			array(
				'name'         => 'Easy Custom Sidebars',
				'slug'         => 'easy-custom-sidebars',
				'required'     => false,
			),
			array(
				'name'         => 'DF Twitter Widget',
				'slug'         => 'df-twitter-widget',
				'source'       => 'https://github.com/danfisher85/df-twitter-widget/archive/master.zip',
				'external_url' => 'https://github.com/danfisher85/df-twitter-widget',
				'required'     => false,
				'version'      => '1.0.2'
			),
			array(
				'name'         => 'DF Social Count',
				'slug'         => 'df-social-count',
				'source'       => 'https://s3.us-east-2.amazonaws.com/danfisher-bucket-1/plugins/RKyjLhX8/df-social-count.zip',
				'required'     => false,
				'version'      => '1.0.0'
			),
			array(
				'name'         => 'WooCommerce',
				'slug'         => 'woocommerce',
				'required'     => false,
			),
			array(
				'name'         => 'Alchemists WooCommerce Grid / List toggle',
				'slug'         => 'alc-woocommerce-grid-list-toggle',
				'source'       => 'https://github.com/danfisher85/alc-woocommerce-grid-list-toggle/archive/master.zip',
				'external_url' => 'https://github.com/danfisher85/alc-woocommerce-grid-list-toggle',
				'required'     => false,
				'version'      => '1.1.2'
			),
			array(
				'name'         => 'Alchemists Color Filters for WooCommerce',
				'slug'         => 'alc-color-filters',
				'source'       => 'https://github.com/danfisher85/alc-color-filters/archive/master.zip',
				'external_url' => 'https://github.com/danfisher85/alc-color-filters',
				'required'     => false,
				'version'      => '1.0.1'
			),
			array(
				'name'         => 'Nav Menu Roles',
				'slug'         => 'nav-menu-roles',
				'required'     => true,
			),
		);

		// Require SportsPress only if SportsPress Pro is not activated
		if ( ! class_exists( 'SportsPress_Pro') ) {
			$plugins[] = array(
				'name'         => 'SportsPress',
				'slug'         => 'sportspress',
				'required'     => true,
			);
		}

		$config = array(
			'id'             => 'alchemists',               // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path'   => '',                         // Default absolute path to pre-packaged plugins
			'menu'           => 'tgmpa-install-plugins',    // Menu slug
			'has_notices'    => true,                       // Show admin notices or not
			'is_automatic'   => true,                       // Automatically activate plugins after installation or not
			'dismissable'    => true,                       // If false, a user cannot dismiss the nag message.
			'dismiss_msg'    => '',                         // If 'dismissable' is false, this message will be output at top of nag.
			'message'        => '',
		);

		tgmpa( $plugins, $config );

	}
}

add_action( 'tgmpa_register', 'alchemists_register_required_plugins' );
