<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( function_exists( 'Underpin\underpin' ) ) {
	define( 'UNDERPIN_BERLIN_DB_PATH', trailingslashit( __DIR__ ) );
	require_once( UNDERPIN_BERLIN_DB_PATH . 'lib/Service_Locator.php' );
	Underpin\underpin()->extensions()->add( 'berlin_db', '\Underpin_Berlin_DB\Service_Locator' );
}