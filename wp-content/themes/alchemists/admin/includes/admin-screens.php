<?php
//Register scripts and styles for admin pages
function df_startup_styles() {
	$check_token = df_check_token();
	wp_enqueue_style('df-admin-css', get_template_directory_uri() . '/admin/assets/css/df-admin.css', null, wp_get_theme()->get( 'Version' ), 'all');

	if ( !$check_token ) {
		wp_enqueue_style('df-admin-not-registered-css', get_template_directory_uri() . '/admin/assets/css/df-admin-not-registered.css', null, wp_get_theme()->get( 'Version' ), 'all');
	}
}
add_action('admin_enqueue_scripts', 'df_startup_styles');

//Register Startup page in admin menu
function df_register_startup_screen() {
	$theme = df_get_theme_info();
	$check_token = df_check_token();
	$theme_name = $theme['name'];
	$theme_name_sanitized = 'df-admin';

	// Work around for Theme Check
	$df_admin_menu_page_creation_method = 'add_menu_page';
	$df_admin_submenu_page_creation_method = 'add_submenu_page';

	if ( $check_token ) {
		$submenu_demo_url          = 'pt-one-click-demo-import';
		$submenu_theme_options_url = '_options&tab=1';
	} else {
		$submenu_demo_url          = $theme_name_sanitized . '-demos';
		$submenu_theme_options_url = $theme_name_sanitized . '-theme-options';
	}

	// Registration
	$df_admin_menu_page_creation_method(
		$theme_name,
		$theme_name,
		'manage_options',
		$theme_name_sanitized,
		'df_theme_admin_page_functions',
		get_template_directory_uri() . '/admin/assets/images/theme-icon.svg',
		'2.1111111111'
	);

	// Support page
	$df_admin_submenu_page_creation_method(
		$theme_name_sanitized,
		esc_html__('Support', 'alchemists'),
		esc_html__('Support', 'alchemists'),
		'manage_options',
		$theme_name_sanitized . '-support',
		'df_theme_admin_support_page'
	);

	// Plugins
	$df_admin_submenu_page_creation_method(
		$theme_name_sanitized,
		esc_html__('Plugins', 'alchemists'),
		esc_html__('Plugins', 'alchemists'),
		'manage_options',
		'tgmpa-install-plugins',
		'df_theme_admin_plugins_page'
	);

	// Demo Import
	$df_admin_submenu_page_creation_method(
		$theme_name_sanitized,
		esc_html__('Demo Import', 'alchemists'),
		esc_html__('Demo Import', 'alchemists'),
		'manage_options',
		$submenu_demo_url,
		'df_theme_admin_install_demo_page'
	);

	// Theme Options
	$df_admin_submenu_page_creation_method(
		$theme_name_sanitized,
		esc_html__('Theme Options', 'alchemists'),
		esc_html__('Theme Options', 'alchemists'),
		'manage_options',
		$submenu_theme_options_url,
		'df_theme_admin_system_options_page'
	);

	// System status
	$df_admin_submenu_page_creation_method(
		$theme_name_sanitized,
		esc_html__('System status', 'alchemists'),
		esc_html__('System status', 'alchemists'),
		'manage_options',
		$theme_name_sanitized . '-system-status',
		'df_theme_admin_system_status_page'
	);

}

add_action('admin_menu', 'df_register_startup_screen');

function df_startup_templates( $path ) {
	$path = 'admin/screens/' . $path . '.php';

	$located = locate_template($path);

	if ($located) {
		load_template($located);
	}
}

//Startup screen menu page welcome
function df_theme_admin_page_functions() {
	df_startup_templates('startup');
}

/*Support Screen*/
function df_theme_admin_support_page() {
	df_startup_templates('support');
}

/*Install Plugins*/
function df_theme_admin_plugins_page() {
	df_startup_templates('plugins');
}

/*Install Demo*/
function df_theme_admin_install_demo_page() {
	df_startup_templates('install_demo');
}

/*Theme Options (empty)*/
function df_theme_admin_system_options_page() {
	df_startup_templates('theme_options');
}

/*System status*/
function df_theme_admin_system_status_page() {
	df_startup_templates('system_status');
}

//Admin tabs
function df_get_admin_tabs( $screen = 'welcome' ) {

	$check_token          = df_check_token();
	$theme                = df_get_theme_info();
	$theme_name           = $theme['name'];
	$theme_version        = $theme['v'];
	$theme_name_sanitized = 'df-admin';

	if (empty( $screen )) {
		$screen = $theme_name_sanitized;
	}

	?>
	<div class="clearfix">
		<h1><?php printf( esc_html__('Welcome to %s!', 'alchemists'), $theme_name ); ?></h1>
		<div class="about-text">
			<?php printf( esc_html__( '%s is now installed and ready to use! Get ready to build something beautiful. Please register your purchase to get automatic theme updates, import %1$s demos and customize the theme. Read below for additional information. We hope you enjoy it!', 'alchemists' ), $theme_name ); ?>
		</div>
		<div class="wp-badge wp-badge--theme"><?php esc_html_e( 'Version', 'alchemists' ); ?> <?php echo esc_html( $theme_version ); ?></div>
	</div>
	<h2 class="nav-tab-wrapper">
		<a href="<?php echo ('welcome' === $screen) ? '#' : esc_url_raw(admin_url('admin.php?page=' . $theme_name_sanitized)); ?>"
		   class="<?php echo ('welcome' === $screen) ? 'nav-tab-active' : ''; ?> nav-tab"><?php esc_attr_e('Registration', 'alchemists'); ?></a>

		<a href="<?php echo ('support' === $screen) ? '#' : esc_url_raw(admin_url('admin.php?page=' . $theme_name_sanitized . '-support')); ?>"
		   class="<?php echo ('support' === $screen) ? 'nav-tab-active' : ''; ?> nav-tab"><?php esc_attr_e('Support', 'alchemists'); ?></a>

		<a href="<?php echo ('plugins' === $screen) ? '#' : esc_url_raw(admin_url('admin.php?page=tgmpa-install-plugins')); ?>"
		   class="nav-tab"><?php esc_attr_e('Plugins', 'alchemists'); ?></a>

		<?php if ( $check_token ) : ?>
		<a href="<?php echo esc_url_raw(admin_url('themes.php?page=pt-one-click-demo-import'));; ?>"
		   class="nav-tab"><?php esc_attr_e( 'Demo Import', 'alchemists' ); ?></a>
		<?php else : ?>
		<a href="<?php echo ('demos' === $screen) ? '#' : esc_url_raw(admin_url('admin.php?page=' . $theme_name_sanitized . '-demos')); ?>"
		   class="<?php echo ('demos' === $screen) ? 'nav-tab-active' : ''; ?> nav-tab"><?php esc_attr_e( 'Demo Import', 'alchemists' ); ?></a>
		<?php endif; ?>

		<?php if ( $check_token ) : ?>
		<a href="<?php echo esc_url_raw(admin_url('admin.php?page=_options&tab=1'));; ?>"
		   class="nav-tab"><?php esc_attr_e('Theme Options', 'alchemists'); ?></a>
		<?php else : ?>
		<a href="<?php echo ('theme-options' === $screen) ? '#' : esc_url_raw(admin_url('admin.php?page=' . $theme_name_sanitized . '-theme-options')); ?>"
		   class="<?php echo ('theme-options' === $screen) ? 'nav-tab-active' : ''; ?> nav-tab"><?php esc_attr_e('Theme Options', 'alchemists'); ?></a>
		<?php endif; ?>

		<a href="<?php echo ('system-status' === $screen) ? '#' : esc_url_raw(admin_url('admin.php?page=' . $theme_name_sanitized . '-system-status')); ?>"
		   class="<?php echo ('system-status' === $screen) ? 'nav-tab-active' : ''; ?> nav-tab"><?php esc_attr_e('System Status', 'alchemists'); ?></a>
	</h2>
	<?php
}
