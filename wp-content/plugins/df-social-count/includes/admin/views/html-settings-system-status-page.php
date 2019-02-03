<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<table id="df-social-count-system-status" class="widefat" cellspacing="0">

	<thead>
		<tr>
			<th colspan="2"><?php _e( 'Environment', 'df-social-count' ); ?></th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td><?php _e( 'DF Social Count Version', 'df-social-count' ); ?>:</td>
			<td><?php echo DF_Social_Count::VERSION; ?></td>
		</tr>
		<tr>
			<td><?php _e( 'WordPress Version', 'df-social-count' ); ?>:</td>
			<td><?php echo esc_attr( get_bloginfo( 'version' ) ); ?></td>
		</tr>
		<tr>
			<td><?php _e( 'WP Multisite Enabled', 'df-social-count' ); ?>:</td>
			<td><?php if ( is_multisite() ) echo __( 'Yes', 'df-social-count' ); else echo __( 'No', 'df-social-count' ); ?></td>
		</tr>
		<tr>
			<td><?php _e( 'Web Server Info', 'df-social-count' ); ?>:</td>
			<td><?php echo esc_html( $_SERVER['SERVER_SOFTWARE'] ); ?></td>
		</tr>
		<tr>
			<td><?php _e( 'PHP Version', 'df-social-count' ); ?>:</td>
			<td><?php if ( function_exists( 'phpversion' ) ) { echo esc_html( phpversion() ); } ?></td>
		</tr>
		<tr>
			<?php
				$connection_status = 'error';
				$connection_note   = __( 'Your server does not have fsockopen or cURL enabled. The scripts which communicate with the social APIs will not work. Contact your hosting provider.', 'df-social-count' );

				if ( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ) {
					if ( function_exists( 'fsockopen' ) && function_exists( 'curl_init' ) ) {
						$connection_note = __( 'Your server has fsockopen and cURL enabled.', 'df-social-count' );
					} elseif ( function_exists( 'fsockopen' ) ) {
						$connection_note = __( 'Your server has fsockopen enabled, cURL is disabled.', 'df-social-count' );
					} else {
						$connection_note = __( 'Your server has cURL enabled, fsockopen is disabled.', 'df-social-count' );
					}

					$connection_status = 'yes';
				}
			?>
			<td><?php _e( 'fsockopen/cURL', 'df-social-count' ); ?>:</td>
			<td>
				<mark class="<?php echo $connection_status; ?>">
					<?php echo $connection_note; ?>
				</mark>
			</td>
		</tr>
		<tr>
			<?php
				$remote_status = 'error';
				$remote_note   = __( 'wp_remote_get() failed. This may not work with your server.', 'df-social-count' );
				$response      = wp_remote_get( 'https://httpbin.org/ip', array( 'timeout' => 60 ) );

				if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
					$remote_status = 'yes';
					$remote_note   = __( 'wp_remote_get() was successful.', 'df-social-count' );
				} elseif ( is_wp_error( $response ) ) {
					$remote_note = __( 'wp_remote_get() failed. This plugin won\'t work with your server. Contact your hosting provider. Error:', 'df-social-count' ) . ' ' . $response->get_error_message();
				}
			?>
			<td><?php _e( 'WP Remote Get', 'df-social-count' ); ?>:</td>
			<td>
				<mark class="<?php echo $remote_status; ?>">
					<?php echo $remote_note; ?>
				</mark>
			</td>
		</tr>
	</tbody>
</table>

<p class="submit"><a href="<?php echo esc_url( add_query_arg( array( 'page' => 'df-social-count', 'tab' => 'system_status', 'debug_file' => 'true' ), admin_url( 'admin.php' ) ) ); ?>" class="button-primary"><?php _e( 'Get System Report', 'df-social-count' ); ?></a></p>
