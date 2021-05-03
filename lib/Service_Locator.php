<?php

namespace Underpin_Berlin_DB;

use Underpin\Abstracts\Extension;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Service_Locator
 *
 * @package Underpin_Berlin_DB
 * @method Loaders\Database|\WP_Error database
 */
class Service_Locator extends Extension {

	protected $file = UNDERPIN_BERLIN_DB_PATH;
	protected $minimum_wp_version  = '5.1';
	protected $minimum_php_version = '5.6';
	protected $version             = '1.0.0';
	protected $root_namespace      = 'Underpin_Berlin_DB';
	protected $text_domain         = 'underpin_berlin_db';

	/**
	 * Shorthand Alias for database.
	 *
	 * @param $key
	 *
	 * @return Loaders\Database|\WP_Error
	 */
	public function db() {
		return $this->database();
	}

	protected function _setup() {
		$this->dir = UNDERPIN_BERLIN_DB_PATH;
	}

}