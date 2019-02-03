<?php

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

$theme       = df_get_theme_info();
$theme_name  = $theme['name'];

$token       = df_get_token();
$check_token = df_check_token();

$message = '';
$notice_class = '';

if ( $check_token ) {
	$icon = 'dashicons dashicons-yes';
	$notice_class = 'notice-success settings-success df-notice df-notice--bordered mb-30';
	$message = __( '<strong>Congratulations!</strong> Your product is registered now.', 'alchemists' );
} else {
	$icon = 'dashicons dashicons-no';
	$notice_class = 'notice-error settings-error df-notice df-notice--bordered mb-30';
	$message = __( '<strong>Invalid Token!</strong> Please make sure you have purchased this theme with the account you registered current token.', 'alchemists' );
}

if ( empty( $token ) ) {
	$icon    = 'dashicons dashicons-post-status';
	$message = '';
}

$envato_market = Envato_Market::instance();
$envato_market->items()->set_themes(true);
$themes = $envato_market->items()->themes('purchased');
?>

<div class="wrap about-wrap df-about-wrap">

	<?php df_get_admin_tabs(); ?>

	<p class="about-description mb-40">
		<?php printf( esc_html__( 'Thank you for choosing %s! Please make sure your product is registered to enable the %1$s demos, theme auto updates and customize the theme. The instructions below must be followed exactly.', 'alchemists'), $theme_name); ?>
	</p>

	<?php if ( !empty( $themes ) and !empty( $token )) { ?>
	<div class="two-col panel">
		<?php envato_market_themes_column('active'); ?>
	</div>
	<?php } ?>

	<div class="df-notice df-notice--registration">

		<form id="df_product_registration" class="df-product-registration" method="post" action="">
			<?php settings_fields('df_registration'); ?>
			<div class="df-product-registration__input">
				<span class="<?php echo $icon; ?>"></span>
				<input type="text" name="df_registration[token]" value="<?php echo esc_attr($token); ?>"/>
			</div>
			<?php submit_button( esc_attr__('Submit', 'alchemists'), array('primary', 'large')); ?>
		</form>

		<?php if ( !empty( $message ) ): ?>
			<div class="<?php echo esc_attr( $notice_class ); ?>"><?php echo $message; ?></div>
		<?php endif; ?>

		<hr>

		<h3><?php esc_html_e( 'Instructions For Generating A Token', 'alchemists'); ?></h3>
		<ol class="df-product-registration__list">
			<li><?php printf(__('Click on this <a href="%s" target="_blank">Generate A Personal Token</a> link. <strong>IMPORTANT:</strong> You must be logged into the same Themeforest account that purchased %s. If you are logged in already, look in the top menu bar to ensure it is the right account. If you are not logged in, you will be directed to login then directed back to the Create A Token Page.', 'alchemists'), 'https://build.envato.com/create-token/?purchase:download=t&purchase:verify=t&purchase:list=t', $theme_name); ?></li>
			<li><?php _e('Enter a name for your token, then check the boxes for <strong>View Your Envato Account Username, Download Your Purchased Items, Verify Purchases You\'ve Made</strong> and <strong>List Purchases You\'ve Made</strong> from the permissions needed section. Check the box to agree to the terms and conditions, then click the <strong>Create Token</strong> button.', 'alchemists'); ?></li>
			<li><?php _e('A new page will load with a token number in a box. Copy the token number then come back to this registration page and paste it into the field below and click the <strong>Submit</strong> button.', 'alchemists'); ?></li>
			<li><?php _e('You will see a green check mark for success, or a failure message if something went wrong. If it failed, please make sure you followed the steps above correctly. You can also view our <a href="https://danfisher.ticksy.com/article/11205/">documentation post</a> for getting more information.', 'alchemists'); ?></li>
		</ol>
	</div>


</div>
