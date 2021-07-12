<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'underpin/before_setup', function ( $file, $class ) {
	if ( ! defined( 'UNDERPIN_BERLIN_DB_PATH' ) ) {
		define( 'UNDERPIN_BERLIN_DB_PATH', trailingslashit( __DIR__ ) );
	}
	require_once( UNDERPIN_BERLIN_DB_PATH . 'lib/abstracts/Database_Model.php' );
	require_once( UNDERPIN_BERLIN_DB_PATH . 'lib/loaders/Database.php' );
	require_once( UNDERPIN_BERLIN_DB_PATH . 'lib/traits/With_Meta.php' );
	require_once( UNDERPIN_BERLIN_DB_PATH . 'lib/factories/Database_Model_Instance.php' );
	require_once( UNDERPIN_BERLIN_DB_PATH . 'lib/factories/Database_Model_With_Meta_Instance.php' );

	Underpin\underpin()->get( $file, $class )->loaders()->add( 'berlin_db', [
		'registry' => 'Underpin_BerlinDB\Loaders\Database'
	] );
}, 20, 2 );