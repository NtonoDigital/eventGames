<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * DF Social Count Admin.
 *
 * @package  DF_Social_Count/Admin
 * @category Admin
 * @author   Dan Fisher
 */
class DF_Social_Count_Admin {

	/**
	 * Plugin settings screen.
	 *
	 * @var string
	 */
	public $settings_screen = null;

	/**
	 * Plugin settings.
	 *
	 * @var array
	 */
	public $plugin_settings = array();

	/**
	 * Plugin settings.
	 *
	 * @var array
	 */
	public $plugin_design = array();

	/**
	 * Initialize the plugin admin.
	 */
	public function __construct() {
		// Adds admin menu.
		add_action( 'admin_menu', array( $this, 'settings_menu' ) );

		// Init plugin options form.
		add_action( 'admin_init', array( $this, 'plugin_settings' ) );

		// Style and scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'styles_and_scripts' ) );

		// Actions links.
		add_filter( 'plugin_action_links_df-social-count/df-social-count.php', array( $this, 'action_links' ) );

		// System status report.
		add_action( 'admin_init', array( $this, 'report_file' ) );

		// Install/update plugin options.
		$this->maybe_install();
	}

	/**
	 * Get the plugin options.
	 *
	 * @return array
	 */
	protected static function get_plugin_options() {
		$twitter_oauth_description = sprintf( __( 'Create an App on Twitter in %s and get this data.', 'df-social-count' ), '<a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a>' );

		$facebook_app_description = sprintf( __( 'Please read %s about generating a never expiring Facebook Access Token.', 'df-social-count' ), '<a href="https://danfisher.ticksy.com/article/13178/" target="_blank">this article</a>' );

		$instagram_access_token = sprintf( __( 'In order to get access to your Instagram account info you are required to provide an Instagram Access Token. You can generate it here %s.', 'df-social-count' ), '<a href="http://instagram.pixelunion.net" target="_blank">http://instagram.pixelunion.net</a>' );

		$tumblr_oauth_description = sprintf( __( 'Register an App on Tumblr in %s, when the app is ready click in "Explore API" and allow your app access your Tumblr account and get this data.', 'df-social-count' ), '<a href="https://www.tumblr.com/oauth/apps" target="_blank">https://www.tumblr.com/oauth/apps</a>' );

		$custom_txt_description = __( '(Optional) Add custom counter label.', 'df-social-count' );

		$settings = array(
			'dfsocialcount_settings' => array(
				'comments' => array(
					'title'  => __( 'Comments', 'df-social-count' ),
					'fields' => array(
						'comments_active' => array(
							'title'   => __( 'Display Comments Counter', 'df-social-count' ),
							'default' => true,
							'type'    => 'checkbox'
						),
						'comments_url' => array(
							'title'   => __( 'URL', 'df-social-count' ),
							'default' => get_home_url(),
							'type'    => 'text'
						),
						'comments_txt' => array(
							'title'       => __( 'Custom Label', 'df-social-count' ),
							'type'        => 'text',
							'description' => $custom_txt_description
						)
					)
				),
				'facebook' => array(
					'title'  => __( 'Facebook', 'df-social-count' ),
					'fields' => array(
						'facebook_active' => array(
							'title'   => __( 'Display Facebook Counter', 'df-social-count' ),
							'type'    => 'checkbox'
						),
						'facebook_id'     => array(
							'title'       => __( 'Facebook Page ID', 'df-social-count' ),
							'type'        => 'text',
							'description' => sprintf(
								'%s<br /><code>https://www.facebook.com/pages/edit/?id=<strong>1806581039617476</strong></code> %s <code>https://www.facebook.com/<strong>WordPress</strong></code>. %s <a href="https://danfisher.ticksy.com/article/13048/">%s</a>',
								__( 'ID Facebook page. Must be the numeric ID or your page slug.', 'df-social-count' ),
								__( 'or', 'df-social-count' ),
								__( 'More info', 'df-social-count' ),
								__( 'here', 'df-social-count' )
							)
						),
						'facebook_token' => array(
							'title'       => __( 'Facebook Token', 'df-social-count' ),
							'type'        => 'text',
							'description' => $facebook_app_description
						),
						'facebook_txt' => array(
							'title'       => __( 'Facebook Custom Label', 'df-social-count' ),
							'type'        => 'text',
							'description' => $custom_txt_description
						)
					)
				),
				'github' => array(
					'title'  => __( 'GitHub', 'df-social-count' ),
					'fields' => array(
						'github_active' => array(
							'title'   => __( 'Display GitHub Counter', 'df-social-count' ),
							'type'    => 'checkbox'
						),
						'github_username' => array(
							'title'       => __( 'GitHub Username', 'df-social-count' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Insert your GitHub username. Example: %s.', 'df-social-count' ), '<code>danfisher85</code>' )
						),
						'github_txt' => array(
							'title'       => __( 'GitHub Custom Label', 'df-social-count' ),
							'type'        => 'text',
							'description' => $custom_txt_description
						)
					)
				),
				'googleplus' => array(
					'title'  => __( 'Google+', 'df-social-count' ),
					'fields' => array(
						'googleplus_active' => array(
							'title' => __( 'Display Google+ Counter', 'df-social-count' ),
							'type'  => 'checkbox'
						),
						'googleplus_id' => array(
							'title'       => __( 'Google+ ID', 'df-social-count' ),
							'type'        => 'text',
							'description' => sprintf(
								'%s<br />%s <code>https://plus.google.com/<strong>118779183783887381366</strong></code> or <code>https://plus.google.com/<strong>+DanFisher</strong></code>',
								__( 'Google+ page or profile ID.', 'df-social-count' ),
								__( 'Example:', 'df-social-count' )
							)
						),
						'googleplus_api_key' => array(
							'title'       => __( 'Google API Key', 'df-social-count' ),
							'type'        => 'text',
							'description' => sprintf(
								__( 'Get your API key creating a project/app in %s, then inside your project go to "APIs & auth > APIs" and turn on the "Google+ API", finally go to "APIs & auth > APIs > Credentials > Public API access" and click in the "CREATE A NEW KEY" button, select the "Browser key" option and click in the "CREATE" button, now just copy your API key and paste here.', 'df-social-count' ),
								'<a href="https://console.developers.google.com/project" target="_blank">https://console.developers.google.com/project</a>'
							)
						),
						'googleplus_txt' => array(
							'title'       => __( 'Google+ Custom Label', 'df-social-count' ),
							'type'        => 'text',
							'description' => $custom_txt_description
						)
					)
				),
				'instagram' => array(
					'title'  => __( 'Instagram', 'df-social-count' ),
					'fields' => array(
						'instagram_active' => array(
							'title' => __( 'Display Instagram Counter', 'df-social-count' ),
							'type'  => 'checkbox'
						),
						'instagram_username' => array(
							'title'       => __( 'Instagram Username', 'df-social-count' ),
							'type'        => 'text',
							'description' => __( 'Insert your Instagram Username.', 'df-social-count' )
						),
						'instagram_user_id' => array(
							'title'       => __( 'Instagram User ID', 'df-social-count' ),
							'type'        => 'text',
							'description' => __( 'Insert your Instagram User ID.', 'df-social-count' )
						),
						'instagram_access_token' => array(
							'title'       => __( 'Instagram Access Token', 'df-social-count' ),
							'type'        => 'text',
							'description' => __( 'Insert your Instagram Access Token.', 'df-social-count' ) . ' ' . $instagram_access_token
						),
						'instagram_txt' => array(
							'title'       => __( 'Instagram Custom Label', 'df-social-count' ),
							'type'        => 'text',
							'description' => $custom_txt_description
						)
					)
				),
				'pinterest' => array(
					'title'  => __( 'Pinterest', 'df-social-count' ),
					'fields' => array(
						'pinterest_active' => array(
							'title' => __( 'Display Pinterest Counter', 'df-social-count' ),
							'type'  => 'checkbox'
						),
						'pinterest_username' => array(
							'title'       => __( 'Pinterest Username', 'df-social-count' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Insert your Pinterest username. Example: %s.', 'df-social-count' ), '<code>envato</code>' )
						),
						'pinterest_txt' => array(
							'title'       => __( 'Pinterest Custom Label', 'df-social-count' ),
							'type'        => 'text',
							'description' => $custom_txt_description
						)
					)
				),
				'posts' => array(
					'title'  => __( 'Posts', 'df-social-count' ),
					'fields' => array(
						'posts_active' => array(
							'title'   => __( 'Display Posts Counter', 'df-social-count' ),
							'default' => true,
							'type'    => 'checkbox'
						),
						'posts_post_type' => array(
							'title'   => __( 'Post Type', 'df-social-count' ),
							'default' => 'post',
							'type'    => 'post_type'
						),
						'posts_url' => array(
							'title'   => __( 'URL', 'df-social-count' ),
							'default' => get_home_url(),
							'type'    => 'text'
						),
						'posts_txt' => array(
							'title'       => __( 'Custom Label', 'df-social-count' ),
							'type'        => 'text',
							'description' => $custom_txt_description
						)
					)
				),
				'steam' => array(
					'title'  => __( 'Steam', 'df-social-count' ),
					'fields' => array(
						'steam_active' => array(
							'title' => __( 'Display Steam Counter', 'df-social-count' ),
							'type'  => 'checkbox'
						),
						'steam_group_name' => array(
							'title'       => __( 'Steam Group Name', 'df-social-count' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Insert your Steam Community group name. Example: %s.', 'df-social-count' ), '<code>DOTALT</code>' )
						),
						'steam_txt' => array(
							'title'       => __( 'Steam Custom Label', 'df-social-count' ),
							'type'        => 'text',
							'description' => $custom_txt_description
						)
					)
				),
				'tumblr' => array(
					'title'  => __( 'Tumblr', 'df-social-count' ),
					'fields' => array(
						'tumblr_active' => array(
							'title' => __( 'Display Tumblr counter', 'df-social-count' ),
							'type'  => 'checkbox'
						),
						'tumblr_hostname' => array(
							'title'       => __( 'Tumblr Hostname', 'df-social-count' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Insert your Tumblr Hostname. Example: %s.', 'df-social-count' ), '<code>http://cutekittensarefun.tumblr.com</code>' )
						),
						'tumblr_consumer_key' => array(
							'title'       => __( 'Tumblr Consumer Key', 'df-social-count' ),
							'type'        => 'text',
							'description' => $tumblr_oauth_description
						),
						'tumblr_consumer_secret' => array(
							'title'       => __( 'Tumblr Consumer Secret', 'df-social-count' ),
							'type'        => 'text',
							'description' => $tumblr_oauth_description
						),
						'tumblr_token' => array(
							'title'       => __( 'Tumblr Token', 'df-social-count' ),
							'type'        => 'text',
							'description' => $tumblr_oauth_description
						),
						'tumblr_token_secret' => array(
							'title'       => __( 'Tumblr Token Secret', 'df-social-count' ),
							'type'        => 'text',
							'description' => $tumblr_oauth_description
						),
						'tumblr_txt' => array(
							'title'       => __( 'Tumblr Custom Label', 'df-social-count' ),
							'type'        => 'text',
							'description' => $custom_txt_description
						)
					)
				),
				'twitch' => array(
					'title'  => __( 'Twitch', 'df-social-count' ),
					'fields' => array(
						'twitch_active' => array(
							'title' => __( 'Display Twitch Counter', 'df-social-count' ),
							'type'  => 'checkbox'
						),
						'twitch_username' => array(
							'title'       => __( 'Twitch Username', 'df-social-count' ),
							'type'        => 'text',
							'description' => __( 'Insert your Twitch username.', 'df-social-count' )
						),
						'twitch_client_ID' => array(
							'title'       => __( 'Twitch Client ID', 'df-social-count' ),
							'type'        => 'text',
							'description' => __( 'Insert your Twitch Client ID.', 'df-social-count' ),
						),
						'twitch_txt' => array(
							'title'       => __( 'Twitch Custom Label', 'df-social-count' ),
							'type'        => 'text',
							'description' => $custom_txt_description
						)
					),
				),
				'twitter' => array(
					'title'  => __( 'Twitter', 'df-social-count' ),
					'fields' => array(
						'twitter_active' => array(
							'title'   => __( 'Display Twitter Counter', 'df-social-count' ),
							'type'    => 'checkbox'
						),
						'twitter_user' => array(
							'title'       => __( 'Twitter Username', 'df-social-count' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Insert the Twitter username. Example: %s.', 'df-social-count' ), '<code>danfisher_dev</code>' )
						),
						'twitter_consumer_key' => array(
							'title'       => __( 'Twitter Consumer key', 'df-social-count' ),
							'type'        => 'text',
							'description' => $twitter_oauth_description
						),
						'twitter_consumer_secret' => array(
							'title'       => __( 'Twitter Consumer secret', 'df-social-count' ),
							'type'        => 'text',
							'description' => $twitter_oauth_description
						),
						'twitter_access_token' => array(
							'title'       => __( 'Twitter Access token', 'df-social-count' ),
							'type'        => 'text',
							'description' => $twitter_oauth_description
						),
						'twitter_access_token_secret' => array(
							'title'       => __( 'Twitter Access token secret', 'df-social-count' ),
							'type'        => 'text',
							'description' => $twitter_oauth_description
						),
						'twitter_txt' => array(
							'title'       => __( 'Twitter Custom Label', 'df-social-count' ),
							'type'        => 'text',
							'description' => $custom_txt_description
						)
					)
				),
				'users' => array(
					'title'  => __( 'Users', 'df-social-count' ),
					'fields' => array(
						'users_active' => array(
							'title'   => __( 'Display Users Counter', 'df-social-count' ),
							'default' => true,
							'type'    => 'checkbox'
						),
						'users_user_role' => array(
							'title'   => __( 'User Role', 'df-social-count' ),
							'default' => 'subscriber',
							'type'    => 'user_role'
						),
						'users_label' => array(
							'title'   => __( 'Label', 'df-social-count' ),
							'default' => __( 'users', 'df-social-count' ),
							'type'    => 'text'
						),
						'users_url' => array(
							'title'   => __( 'URL', 'df-social-count' ),
							'default' => get_home_url(),
							'type'    => 'text'
						),
						'users_txt' => array(
							'title'       => __( 'Custom Label', 'df-social-count' ),
							'type'        => 'text',
							'description' => $custom_txt_description
						)
					)
				),
				'vimeo' => array(
					'title'  => __( 'Vimeo', 'df-social-count' ),
					'fields' => array(
						'vimeo_active' => array(
							'title' => __( 'Display Vimeo Counter', 'df-social-count' ),
							'type'  => 'checkbox'
						),
						'vimeo_channel' => array(
							'title'       => __( 'Vimeo Channel', 'df-social-count' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Insert your Vimeo channel name. Example: %s.', 'df-social-count' ), '<code>staffpicks</code>' )
						),
						'vimeo_txt' => array(
							'title'       => __( 'Vimeo Custom Label', 'df-social-count' ),
							'type'        => 'text',
							'description' => $custom_txt_description
						)
					)
				),
				'youtube' => array(
					'title'  => __( 'YouTube', 'df-social-count' ),
					'fields' => array(
						'youtube_active' => array(
							'title'   => __( 'Display YouTube Counter', 'df-social-count' ),
							'type'    => 'checkbox'
						),
						'youtube_user' => array(
							'title'       => __( 'YouTube Channel ID', 'df-social-count' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Insert the YouTube Channel ID. Example: %s.', 'df-social-count' ), '<code>UCbYqVTgLVezPsFZAA_QsvFw</code>' )
						),
						'youtube_url' => array(
							'title'       => __( 'YouTube Channel URL', 'df-social-count' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Insert the YouTube channel URL. Example: %s.', 'df-social-count' ), '<code>https://www.youtube.com/channel/UCbYqVTgLVezPsFZAA_QsvFw</code>' )
						),
						'youtube_api_key' => array(
							'title'       => __( 'Google API Key', 'df-social-count' ),
							'type'        => 'text',
							'description' => sprintf(
								__( 'Get your API key creating a project/app in %s, then inside your project go to "APIs & auth > APIs" and turn on the "YouTube API", finally go to "APIs & auth > APIs > Credentials > Public API access" and click in the "CREATE A NEW KEY" button, select the "Browser key" option and click in the "CREATE" button, now just copy your API key and paste here.', 'df-social-count' ),
								'<a href="https://console.developers.google.com/project" target="_blank">https://console.developers.google.com/project</a>'
							)
						),
						'youtube_txt' => array(
							'title'       => __( 'YouTube Custom Label', 'df-social-count' ),
							'type'        => 'text',
							'description' => $custom_txt_description
						)
					)
				),
				'settings' => array(
					'title'  => __( 'Settings', 'df-social-count' ),
					'fields' => array(
						'target_blank' => array(
							'title'       => __( 'Open URLs in new tab/window', 'df-social-count' ),
							'type'        => 'checkbox',
							'description' => sprintf( __( 'This option add %s in all counters URLs.', 'df-social-count' ), '<code>target="_blank"</code>' )
						),
					)
				)
			),
			'dfsocialcount_design' => array(
				'design' => array(
					'title'  => __( 'Design', 'df-social-count' ),
					'fields' => array(
						'models' => array(
							'title'   => __( 'Layout Models', 'df-social-count' ),
							'default' => '0',
							'type'    => 'models',
							'options' => array( 0, 1, 2 )
						),
						'icons' => array(
							'title' => __( 'Order', 'df-social-count' ),
							'type'  => 'icons_order',
							'description' => __( 'This option controls the order of the icons in the widget.', 'df-social-count' )
						)
					)
				)
			)
		);

		return $settings;
	}

	/**
	 * Add plugin settings menu.
	 */
	public function settings_menu() {
		$this->settings_screen = add_options_page(
			__( 'DF Social Count', 'df-social-count' ),
			__( 'DF Social Count', 'df-social-count' ),
			'manage_options',
			'df-social-count',
			array( $this, 'settings_page' )
		);
	}

	/**
	 * Plugin settings page.
	 *
	 * @return string
	 */
	public function settings_page() {
		$screen = get_current_screen();

		if ( ! $this->settings_screen || $screen->id !== $this->settings_screen ) {
			return;
		}

		// Load the plugin options.
		$this->plugin_settings = get_option( 'dfsocialcount_settings' );
		$this->plugin_design   = get_option( 'dfsocialcount_design' );

		// Create tabs current class.
		$current_tab = '';
		if ( isset( $_GET['tab'] ) ) {
			$current_tab = $_GET['tab'];
		} else {
			$current_tab = 'settings';
		}

		// Reset transients when save settings page.
		if ( isset( $_GET['settings-updated'] ) && ! ( isset( $_GET['tab'] ) && 'design' == $_GET['tab'] ) ) {
			if ( true == $_GET['settings-updated'] ) {
				// Set transients.
				DF_Social_Count_Generator::reset_count();

				// Set the icons order.
				$icons           = self::get_current_icons();
				$design          = get_option( 'dfsocialcount_design', array() );
				$design['icons'] = implode( ',', $icons );
				update_option( 'dfsocialcount_design', $design );
			}
		}

		include 'views/html-settings-page.php';
	}

	/**
	 * Plugin settings form fields.
	 */
	public function plugin_settings() {

		// Process the settings.
		foreach ( self::get_plugin_options() as $settings_id => $sections ) {

			// Create the sections.
			foreach ( $sections as $section_id => $section ) {
				add_settings_section(
					$section_id,
					$section['title'],
					array( $this, 'title_element_callback' ),
					$settings_id
				);

				// Create the fields.
				foreach ( $section['fields'] as $field_id => $field ) {
					switch ( $field['type'] ) {
						case 'text':
							add_settings_field(
								$field_id,
								$field['title'],
								array( $this, 'text_element_callback' ),
								$settings_id,
								$section_id,
								array(
									'tab'         => $settings_id,
									'id'          => $field_id,
									'class'       => 'regular-text',
									'description' => isset( $field['description'] ) ? $field['description'] : ''
								)
							);
							break;
						case 'checkbox':
							add_settings_field(
								$field_id,
								$field['title'],
								array( $this, 'checkbox_element_callback' ),
								$settings_id,
								$section_id,
								array(
									'tab'         => $settings_id,
									'id'          => $field_id,
									'description' => isset( $field['description'] ) ? $field['description'] : ''
								)
							);
							break;
						case 'post_type':
							add_settings_field(
								$field_id,
								$field['title'],
								array( $this, 'post_type_element_callback' ),
								$settings_id,
								$section_id,
								array(
									'tab'         => $settings_id,
									'id'          => $field_id,
									'description' => isset( $field['description'] ) ? $field['description'] : ''
								)
							);
							break;
						case 'user_role':
							add_settings_field(
								$field_id,
								$field['title'],
								array( $this, 'user_role_element_callback' ),
								$settings_id,
								$section_id,
								array(
									'tab'         => $settings_id,
									'id'          => $field_id,
									'description' => isset( $field['description'] ) ? $field['description'] : ''
								)
							);
							break;
						case 'models':
							add_settings_field(
								$field_id,
								$field['title'],
								array( $this, 'models_element_callback' ),
								$settings_id,
								$section_id,
								array(
									'tab'         => $settings_id,
									'id'          => $field_id,
									'description' => isset( $field['description'] ) ? $field['description'] : '',
									'options'     => $field['options']
								)
							);
							break;
						case 'icons_order':
							add_settings_field(
								$field_id,
								$field['title'],
								array( $this, 'icons_order_element_callback' ),
								$settings_id,
								$section_id,
								array(
									'tab'         => $settings_id,
									'id'          => $field_id,
									'description' => isset( $field['description'] ) ? $field['description'] : ''
								)
							);
							break;
						case 'color':
							add_settings_field(
								$field_id,
								$field['title'],
								array( $this, 'color_element_callback' ),
								$settings_id,
								$section_id,
								array(
									'tab'         => $settings_id,
									'id'          => $field_id,
									'description' => isset( $field['description'] ) ? $field['description'] : ''
								)
							);
							break;

						default:
							break;
					}
				}
			}

			// Register the setting.
			register_setting( $settings_id, $settings_id, array( $this, 'validate_options' ) );
		}
	}

	/**
	 * Get option value.
	 *
	 * @param  string $id      Option ID.
	 * @param  mixed  $default Default value.
	 *
	 * @return string
	 */
	protected function get_option_value( $id, $default = '' ) {
		$options = array_merge( $this->plugin_settings, $this->plugin_design );

		return ( isset( $options[ $id ] ) ) ? $options[ $id ] : $default;
	}

	/**
	 * Title element callback.
	 *
	 * @param array $args Field arguments.
	 */
	public function title_element_callback( $args ) {
		echo ! empty( $args['id'] ) ? '<div id="section-' . esc_attr( $args['id'] ) . '"></div>' : '';
	}

	/**
	 * Text element callback.
	 *
	 * @param array $args Field arguments.
	 */
	public function text_element_callback( $args ) {
		$tab     = $args['tab'];
		$id      = $args['id'];
		$class   = isset( $args['class'] ) ? $args['class'] : 'small-text';
		$default = isset( $args['default'] ) ? $args['default'] : '';
		$current = $this->get_option_value( $id, $default );
		$html    = sprintf( '<input type="text" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="%4$s" />', $id, $tab, $current, $class );

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Checkbox field callback.
	 *
	 * @param array $args Field arguments.
	 */
	public function checkbox_element_callback( $args ) {
		$tab     = $args['tab'];
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : '';
		$current = $this->get_option_value( $id, $default );
		$html    = sprintf( '<input type="checkbox" id="%1$s" name="%2$s[%1$s]" value="1"%3$s />', $id, $tab, checked( 1, $current, false ) );
		$html   .= sprintf( '<label for="%s"> %s</label><br />', $id, __( 'Activate/Deactivate', 'df-social-count' ) );

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Post Type element callback.
	 *
	 * @param array $args Field arguments.
	 */
	public function post_type_element_callback( $args ) {
		$tab     = $args['tab'];
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : 'post';
		$current = $this->get_option_value( $id, $default );
		$html    = '';

		$html = sprintf( '<select id="%1$s" name="%2$s[%1$s]">', $id, $tab );
		foreach ( get_post_types( array( 'public' => true ), 'objects' ) as $key => $value ) {
			$html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $current, $key, false ), $value->label );
		}
		$html .= '</select>';

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * User Role element callback.
	 *
	 * @param array $args Field arguments.
	 */
	public function user_role_element_callback( $args ) {
		global $wp_roles;

		$tab     = $args['tab'];
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : 'subscriber';
		$current = $this->get_option_value( $id, $default );
		$html    = '';

		$html = sprintf( '<select id="%1$s" name="%2$s[%1$s]">', $id, $tab );
		foreach ( $wp_roles->get_names() as $key => $value ) {
			$html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $current, $key, false ), $value );
		}
		$html .= sprintf( '<option value="%s"%s>%s</option>', 'all', selected( $current, 'all', false ), __( 'All Roles', 'df-social-count' ) );
		$html .= '</select>';

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Models element callback.
	 *
	 * @param array $args Field arguments.
	 */
	public function models_element_callback( $args ) {
		$tab     = $args['tab'];
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : 0;
		$current = $this->get_option_value( $id, $default );
		$html    = '';

		foreach ( $args['options'] as $option ) {

			$html .= '<div class="df-social-layout-item">';
				$html .= sprintf( '<input type="radio" name="%1$s[%2$s]" class="df-social-count-model-input" value="%3$s"%4$s />', $tab, $id, $option, checked( $current, $option, false ) );

				$style = DF_Social_Count_View::get_view_model( $option );

				$html .= '<img src="' . plugins_url( '../', dirname( __FILE__ ) ) . 'assets/images/layout-' . $style . '.png' . '">';

			$html .= '</div>';
		}

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Icons order element callback.
	 *
	 * @param array $args Field arguments.
	 */
	public function icons_order_element_callback( $args ) {
		$tab       = $args['tab'];
		$id        = $args['id'];
		$current   = $this->get_option_value( $id );
		$html      = '';

		$html .= '<div class="df-social-count-icons-order">';
		$html .= sprintf( '<input type="hidden" id="%1$s" name="%2$s[%1$s]" value="%3$s" />', $id, $tab, $current );
		foreach ( explode( ',', $current ) as $icon ) {
			$html .= '<div class="social-icon" data-icon="' . $icon . '">' . $this->get_icon_name_i18n( $icon ) . '</div>';
		}
		$html .= '</div>';

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Color element callback.
	 *
	 * @param array $args Field arguments.
	 */
	public function color_element_callback( $args ) {
		$tab     = $args['tab'];
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : '#333333';
		$current = $this->get_option_value( $id, $default );
		$html    = sprintf( '<input type="text" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="df-social-count-color-field" />', $id, $tab, $current );

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Valid options.
	 *
	 * @param  array $input options to valid.
	 *
	 * @return array        validated options.
	 */
	public function validate_options( $input ) {
		$output = array();

		foreach ( $input as $key => $value ) {
			if ( isset( $input[ $key ] ) ) {
				$output[ $key ] = sanitize_text_field( $input[ $key ] );
			}
		}

		return $output;
	}

	/**
	 * Register admin styles and scripts.
	 */
	public function styles_and_scripts() {
		$screen = get_current_screen();

		if ( $this->settings_screen && $screen->id === $this->settings_screen ) {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			wp_enqueue_style( 'df-social-count', plugins_url( 'assets/css/counter.css', plugin_dir_path( dirname( __FILE__ ) ) ), array(), DF_Social_Count::VERSION, 'all' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_style( 'df-social-count-admin', plugins_url( 'assets/css/admin.css', plugin_dir_path( dirname( __FILE__ ) ) ), array(), DF_Social_Count::VERSION, 'all' );
			wp_enqueue_script( 'df-social-count-admin', plugins_url( 'assets/js/admin' . $suffix . '.js', plugin_dir_path( dirname( __FILE__ ) ) ), array( 'jquery', 'wp-color-picker' ), DF_Social_Count::VERSION, true );
		}
	}

	/**
	 * Adds custom settings url in plugins page.
	 *
	 * @param  array $links Default links.
	 *
	 * @return array        Default links and settings link.
	 */
	public function action_links( $links ) {
		$settings = array(
			'settings' => sprintf(
				'<a href="%s">%s</a>',
				admin_url( 'options-general.php?page=df-social-count' ),
				__( 'Settings', 'df-social-count' )
			)
		);

		return array_merge( $settings, $links );
	}

	/**
	 * Generate a system report file.
	 *
	 * @return string
	 */
	public function report_file() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( ! isset( $_GET['page'] ) || ! isset( $_GET['tab'] ) || ! isset( $_GET['debug_file'] ) ) {
			return;
		}

		@ob_clean();

		$debug    = array();
		$settings = get_option( 'dfsocialcount_settings' );
		$cache    = get_option( DF_Social_Count_Generator::$cache );
		$content  = '';
		$counters = apply_filters( 'DF_Social_Count_counters_test', array(
			'DF_Social_Count_Facebook_Counter',
			'DF_Social_Count_GitHub_Counter',
			'DF_Social_Count_GooglePlus_Counter',
			'DF_Social_Count_Instagram_Counter',
			'DF_Social_Count_Pinterest_Counter',
			'DF_Social_Count_Steam_Counter',
			'DF_Social_Count_Tumblr_Counter',
			'DF_Social_Count_Twitch_Counter',
			'DF_Social_Count_Twitter_Counter',
			'DF_Social_Count_Vimeo_Counter',
			'DF_Social_Count_YouTube_Counter',
		) );

		foreach ( $counters as $counter ) {
			$_counter = new $counter();

			if ( $_counter->is_available( $settings ) ) {
				$_counter->get_total( $settings, $cache );
				$debug[ $_counter->id ] = $_counter->debug();
			}
		}

		// Set the content.
		$content .= '# ' .  __( 'General Info', 'df-social-count' ) . ' #' . PHP_EOL . PHP_EOL;
		$content .= __( 'Social Count Plus Version', 'df-social-count' ) . ': ' . DF_Social_Count::VERSION . PHP_EOL;
		$content .= __( 'WordPress Version', 'df-social-count' ) . ': ' . esc_attr( get_bloginfo( 'version' ) ) . PHP_EOL;
		$content .= __( 'WP Multisite Enabled', 'df-social-count' ) . ': ' . ( ( is_multisite() ) ? __( 'Yes', 'df-social-count' ) : __( 'No', 'df-social-count' ) ) . PHP_EOL;
		$content .= __( 'Web Server Info', 'df-social-count' ) . ': ' . esc_html( $_SERVER['SERVER_SOFTWARE'] ) . PHP_EOL;
		$content .= __( 'PHP Version', 'df-social-count' ) . ': ' . ( function_exists( 'phpversion' ) ? esc_html( phpversion() ) : '' ) . PHP_EOL;
		$content .= 'fsockopen: ' . ( function_exists( 'fsockopen' ) ? __( 'Yes', 'df-social-count' ) : __( 'No', 'df-social-count' ) ) . PHP_EOL;
		$content .= 'cURL: ' . ( function_exists( 'curl_init' ) ? __( 'Yes', 'df-social-count' ) : __( 'No', 'df-social-count' ) ) . PHP_EOL . PHP_EOL;
		$content .= '# ' . __( 'Social Connections', 'df-social-count' ) . ' #';
		$content .= PHP_EOL . PHP_EOL;

		if ( ! empty( $debug ) ) {
			foreach ( $debug as $key => $value ) {
				$content .= '### ' . strtoupper( esc_attr( $key ) ) . ' ###' . PHP_EOL;
				$content .= print_r( $value, true );
				$content .= PHP_EOL . PHP_EOL;
			}
		} else {
			$content .= __( 'You do not have any counter that needs to connect remotely currently active', 'df-social-count' );
		}

		header( 'Cache-Control: public' );
		header( 'Content-Description: File Transfer' );
		header( 'Content-Disposition: attachment; filename=df-social-count-debug-' . date( 'y-m-d-H-i' ) . '.txt' );
		header( 'Content-Type: text/plain' );
		header( 'Content-Transfer-Encoding: binary' );

		echo $content;
		exit;
	}

	/**
	 * Maybe install.
	 */
	public static function maybe_install() {
		$version = get_option( 'dfsocialcount_version', '0' );

		if ( version_compare( $version, DF_Social_Count::VERSION, '<' ) ) {

			// Install options and updated old versions for 3.0.0.
			if ( version_compare( $version, '3.0.0', '<' ) ) {
				foreach ( self::get_plugin_options() as $settings_id => $sections ) {
					$saved = get_option( $settings_id, array() );

					foreach ( $sections as $section_id => $section ) {
						foreach ( $section['fields'] as $field_id => $field ) {
							$default = isset( $field['default'] ) ? $field['default'] : '';

							if ( isset( $saved[ $field_id ] ) || '' === $default ) {
								continue;
							}

							$saved[ $field_id ] = $default;
						}
					}

					update_option( $settings_id, $saved );
				}

				// Set the icons order.
				$icons           = self::get_current_icons();
				$design          = get_option( 'dfsocialcount_design', array() );
				$design['icons'] = implode( ',', $icons );
				update_option( 'dfsocialcount_design', $design );
			}

			// Save plugin version.
			update_option( 'dfsocialcount_version', DF_Social_Count::VERSION );

			// Reset the counters.
			DF_Social_Count_Generator::reset_count();
		}
	}

	/**
	 * Get current icons.
	 *
	 * @return array
	 */
	protected static function get_current_icons() {
		$settings = get_option( 'dfsocialcount_settings', array() );
		$design   = get_option( 'dfsocialcount_design', array() );
		$current  = isset( $design['icons'] ) ? explode( ',', $design['icons'] ) : array();
		$icons    = array();

		if ( function_exists( 'preg_filter' ) ) {
			$saved = array_values( preg_filter('/^(.*)_active/', '$1', array_keys( $settings ) ) );
		} else {
			$saved = array_values( array_diff( preg_replace( '/^(.*)_active/', '$1', array_keys( $settings ) ), array_keys( $settings ) ) );
		}

		$icons = array_unique( array_filter( array_merge( $current, $saved ) ) );

		// Exclude extra values.
		$diff = array_diff( $current, $saved );
		foreach ( $diff as $key => $value ) {
			unset( $icons[ $key ] );
		}

		return $icons;
	}

	/**
	 * Get i18n counters.
	 *
	 * @return array
	 */
	public function get_i18n_counters() {
		return apply_filters( 'DF_Social_Count_icon_name_i18n', array(
			'comments'   => __( 'Comments', 'df-social-count' ),
			'facebook'   => __( 'Facebook', 'df-social-count' ),
			'github'     => __( 'GitHub', 'df-social-count' ),
			'googleplus' => __( 'Google+', 'df-social-count' ),
			'instagram'  => __( 'Instagram', 'df-social-count' ),
			'pinterest'  => __( 'Pinterest', 'df-social-count' ),
			'posts'      => __( 'Posts', 'df-social-count' ),
			'steam'      => __( 'Steam', 'df-social-count' ),
			'tumblr'     => __( 'Tumblr', 'df-social-count' ),
			'twitch'     => __( 'Twitch', 'df-social-count' ),
			'twitter'    => __( 'Twitter', 'df-social-count' ),
			'users'      => __( 'Users', 'df-social-count' ),
			'vimeo'      => __( 'Vimeo', 'df-social-count' ),
			'youtube'    => __( 'YouTube', 'df-social-count' ),
		) );
	}

	/**
	 * Get icons names.
	 *
	 * @param  string $slug
	 *
	 * @return string
	 */
	protected function get_icon_name_i18n( $slug ) {
		$names = $this->get_i18n_counters();

		if ( ! isset( $names[ $slug ] ) ) {
			return $slug;
		}

		return $names[ $slug ];
	}
}

new DF_Social_Count_Admin;
