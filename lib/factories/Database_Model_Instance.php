<?php

namespace Underpin_BerlinDB\Factories;

use Underpin\Traits\Instance_Setter;
use Underpin_BerlinDB\Abstracts\Database_Model;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Database_Model_Instance extends Database_Model {
	use Instance_Setter;

	protected $sanitize_callback;
	protected $meta_table_callback;

	public function __construct( $args ) {
		$this->set_values( $args );
		parent::__construct();
	}

	public function sanitize_callback( $key, $value ) {
		return $this->set_callable( $this->sanitize_callback, $key, $value );
	}

}