<?php

// If uninstall not called from WordPress exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) || ! WP_UNINSTALL_PLUGIN || dirname( WP_UNINSTALL_PLUGIN ) != dirname( plugin_basename( __FILE__ ) ) ) {

    status_header( 404 );
    exit;
}

delete_option( 'dfsocialcount_settings' );
delete_option( 'dfsocialcount_design' );
delete_option( 'dfsocialcount_version' );
