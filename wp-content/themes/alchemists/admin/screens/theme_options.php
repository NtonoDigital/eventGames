<?php

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
?>

<div class="wrap about-wrap df-about-wrap">
  <?php df_get_admin_tabs('theme-options'); ?>

	<?php
	$theme                = df_get_theme_info();
	$theme_name           = $theme['name'];
	$theme_name_sanitized = 'df-admin';
	$registration_link    = esc_url_raw( admin_url( 'admin.php?page=' . $theme_name_sanitized ) );

  echo '<div class="notice-error settings-error df-notice">';
		echo '<h3>';
			printf( __( '%s Can Only Be Customized With A Valid Token Registration', 'alchemists'), $theme_name );
		echo '</h3>';
    echo '<p>';
		printf( __( 'Please visit the <a href="%s">Product Registration</a> page and enter a valid token to enable Theme Options and customize the theme.', 'alchemists'), $registration_link );
		echo '</p>';
  echo '</div>';
  ?>
</div>
