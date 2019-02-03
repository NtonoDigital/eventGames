<?php
$includes = get_template_directory() . '/admin/includes/';
define('DF_ITEM_NAME', 'alchemists');

// Envato Market plugin
if ( !class_exists( 'Envato_Market' ) ) {
	require_once $includes . '/envato-market/envato-market.php' ;
}

require_once $includes . 'theme.php';
require_once $includes . 'admin-screens.php';

$tr = get_site_transient( 'update_themes' );
