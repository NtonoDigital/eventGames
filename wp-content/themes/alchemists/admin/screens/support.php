<?php

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

$theme      = df_get_theme_info();
$theme_name = $theme['name'];
?>
<div class="wrap about-wrap df-about-wrap">
	<?php df_get_admin_tabs('support'); ?>

	<div class="notice-info settings-error df-notice df-notice--padding mb-20">
		<p><?php printf( __('%s comes with 6 months of free support for every license you purchase. Support can be %s via ThemeForest.', 'alchemists' ), $theme_name, '<a href="https://help.market.envato.com/hc/en-us/articles/207886473-Extending-and-Renewing-Item-Support">extended through subscriptions</a>'); ?></p>
	</div>


	<div class="df-admin-container">

		<div class="feature-section two-col">
			<div class="col">
				<div class="df-admin-feature-box">
					<h3><span class="dashicons dashicons-sos"></span> <?php esc_html_e( 'Submit a Ticket', 'alchemists' ); ?></h3>
					<p><?php esc_html_e( 'We offer excellent support through our ticket system. Make sure to register your purchase first to access our support services and other resources.', 'alchemists' ); ?></p>
					<a href="<?php echo df_theme_support_url(); ?>" class="button button-primary" target="_blank">
						<?php esc_html_e('Submit a ticket', 'alchemists'); ?>
					</a>
				</div>
			</div>
			<div class="col">
				<div class="df-admin-feature-box">
					<h3><span class="dashicons dashicons-book"></span> <?php esc_html_e( 'Documentation', 'alchemists' ); ?></h3>
					<p><?php printf(__('Our online documentaiton is a useful resource for learning the every aspect and features of %s.', 'alchemists'), $theme_name); ?></p>
					<a href="<?php echo df_theme_support_url() . '/articles/100010358'; ?>" class="button button-primary" target="_blank">
						<?php esc_html_e('Documentation', 'alchemists'); ?>
					</a>
				</div>
			</div>
			<div class="col">
				<div class="df-admin-feature-box">
					<h3><span class="dashicons dashicons-format-video"></span> <?php esc_html_e( 'Video Tutorials', 'alchemists' ); ?></h3>
					<p><?php printf(__('Watch video tutorials before you start the theme customization. Our video tutorials can teach you the different aspects of using %s.', 'alchemists'), $theme_name); ?></p>
					<a href="https://www.youtube.com/playlist?list=PLizcnx02zDuJLxvthGpjzbebOH_jqs5O5" class="button button-primary" target="_blank">
						<?php esc_html_e( 'Watch Videos', 'alchemists' ); ?>
					</a>
				</div>
			</div>
			<div class="col">
				<div class="df-admin-feature-box">
					<h3><span class="dashicons dashicons-facebook"></span> <?php esc_html_e( 'Facebook Page', 'alchemists' ); ?></h3>
					<p><?php esc_html_e( 'Want to know about feature plans and updates first? Come and follow our Facebook Page. Please note, we do not provide support here.', 'alchemists' ); ?></p>
					<a href="<?php echo df_theme_fb_page_url(); ?>" class="button button-primary" target="_blank">
						<?php esc_html_e( 'Facebook Page', 'alchemists' ); ?>
					</a>
				</div>
			</div>
		</div>

	</div>

</div>
