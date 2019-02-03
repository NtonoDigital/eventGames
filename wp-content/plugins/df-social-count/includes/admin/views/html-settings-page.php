<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wrap">
	<h2 class="nav-tab-wrapper">
		<a href="options-general.php?page=df-social-count&amp;tab=settings" class="nav-tab <?php echo $current_tab == 'settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Settings', 'df-social-count' ); ?></a><a href="options-general.php?page=df-social-count&amp;tab=design" class="nav-tab <?php echo $current_tab == 'design' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Design', 'df-social-count' ); ?></a><a href="options-general.php?page=df-social-count&amp;tab=system_status" class="nav-tab <?php echo $current_tab == 'system_status' ? 'nav-tab-active' : ''; ?>"><?php _e( 'System Status', 'df-social-count' ); ?></a>
	</h2>

	<form method="post" action="options.php">
		<?php
			if ( 'design' == $current_tab ) {
				settings_fields( 'dfsocialcount_design' );
				do_settings_sections( 'dfsocialcount_design' );
				submit_button();
			} elseif ( 'system_status' == $current_tab ) {
				include dirname( __FILE__ ) . '/html-settings-system-status-page.php';
			} else {
				settings_fields( 'dfsocialcount_settings' );
				do_settings_sections( 'dfsocialcount_settings' );
				submit_button();
			}
		?>
	</form>
</div>
