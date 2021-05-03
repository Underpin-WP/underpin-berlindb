<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'underpin/before_setup', function ( $class ) {
	if ( 'Underpin\Underpin' === $class ) {
		define( 'UNDERPIN_BERLIN_DB_PATH', trailingslashit( __DIR__ ) );
		require_once( UNDERPIN_BERLIN_DB_PATH . 'lib/Service_Locator.php' );
		Underpin\underpin()->extensions()->add( 'berlin_db', '\Underpin_Berlin_DB\Service_Locator' );
	}
} );