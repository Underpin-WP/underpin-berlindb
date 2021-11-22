<?php

use Underpin\Abstracts\Underpin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

Underpin::attach( 'setup', new \Underpin\Factories\Observer( 'berlin_db', [
	'id'     => 'berlin_db',
	'update' => function ( Underpin $plugin ) {
		if ( ! defined( 'UNDERPIN_BERLIN_DB_PATH' ) ) {
			define( 'UNDERPIN_BERLIN_DB_PATH', trailingslashit( __DIR__ ) );
		}
		require_once( UNDERPIN_BERLIN_DB_PATH . 'lib/abstracts/Database_Model.php' );
		require_once( UNDERPIN_BERLIN_DB_PATH . 'lib/loaders/Database.php' );
		require_once( UNDERPIN_BERLIN_DB_PATH . 'lib/traits/With_Meta.php' );
		require_once( UNDERPIN_BERLIN_DB_PATH . 'lib/factories/Database_Model_Instance.php' );
		require_once( UNDERPIN_BERLIN_DB_PATH . 'lib/factories/Database_Model_With_Meta_Instance.php' );

		$plugin->loaders()->add( 'berlin_db', [
			'class' => 'Underpin_BerlinDB\Loaders\Database',
		] );
	},
] ) );