<?php

namespace Underpin_Berlin_DB;

use Underpin\Abstracts\Extension;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Service_Locator extends Extension {

	protected $file = UNDERPIN_BERLIN_DB_PATH;
	protected $minimum_wp_version  = '5.1';
	protected $minimum_php_version = '5.6';
	protected $version             = '1.0.0';
	protected $root_namespace      = 'Underpin_Berlin_DB';
	protected $text_domain         = 'underpin_berlin_db';

	/**
	 * @param $key
	 *
	 * @return Loaders\Database|\WP_Error
	 */
	public function db() {
		return $this->_get_loader('Database');
	}

	protected function _setup() {
		$this->dir = UNDERPIN_BERLIN_DB_PATH;
	}

}