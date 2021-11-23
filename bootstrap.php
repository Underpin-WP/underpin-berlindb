<?php

use Underpin\Abstracts\Underpin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

Underpin::attach( 'setup', new \Underpin\Factories\Observers\Loader( 'berlin_db', [
	'class' => 'Underpin\BerlinDB\Loaders\Database',
] ) );