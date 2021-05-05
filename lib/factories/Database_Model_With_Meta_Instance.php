<?php

namespace Underpin_BerlinDB\Factories;

use BerlinDB\Database\Table;
use Underpin\Traits\Instance_Setter;
use Underpin_BerlinDB\Abstracts\Database_Model;
use Underpin_BerlinDB\Traits\With_Meta;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Database_Model_With_Meta_Instance extends Database_Model {
	use Instance_Setter, With_Meta;

	protected $sanitize_callback;
	protected $get_meta_table_callback;

	public function __construct( $args ) {
		$this->set_values( $args );
		parent::__construct();
	}

	public function sanitize_callback( $key, $value ) {
		return $this->set_callable( $this->sanitize_callback, $key, $value );
	}

	function get_meta_table() {
		return $this->set_callable( $this->get_meta_table_callback );
	}

}