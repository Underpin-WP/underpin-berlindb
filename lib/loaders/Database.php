<?php
/**
 * Database Loader
 *
 * @since   1.0.0
 * @package Underpin_BerlinDB\Loaders
 */


namespace Underpin_BerlinDB\Loaders;
use Underpin\Abstracts\Registries\Object_Registry;
use Underpin_BerlinDB\Abstracts\Database_Model;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Database
 * Database Registry
 *
 * @since   1.0.0
 * @package Underpin_BerlinDB\Loaders
 */
class Database extends Object_Registry {

	/**
	 * @inheritDoc
	 */
	protected $abstraction_class = '\Underpin_BerlinDB\Abstracts\Database_Model';

	protected $default_factory = '\Underpin_BerlinDB\Factories\Database_Model_Instance';

	/**
	 * @inheritDoc
	 */
	protected function set_default_items() {}

	/**
	 * Retrieves a registered database model.
	 *
	 * @param string $key The identifier for the item.
	 * @return Database_Model|WP_Error the database model.
	 */
	public function get( $key ) {
		return parent::get( $key );
	}

	/**
	 * Installs all tables registered by this plugin.
	 *
	 * @since 1.1.0
	 */
	public function install() {
		foreach ( $this as $key => $table ) {
			$table = $this->get( $key );
			if ( ! is_wp_error( $table ) ) {
				$table->install();
			}
		}
	}

	/**
	 * Resets all tables registered by this plugin.
	 *
	 * @since 1.1.0
	 */
	public function reset() {
		foreach ( $this as $key => $model ) {
			$model = $this->get( $key );
			if ( ! is_wp_error( $model ) ) {
				$model->reset();
			}
		}
	}

	/**
	 * Uninstalls all tables registered by this plugin.
	 *
	 * @since 1.1.0
	 */
	public function uninstall() {
		foreach ( $this as $key => $table ) {
			$table = $this->get( $key );
			if ( ! is_wp_error( $table ) ) {
				$table->uninstall();
			}
		}
	}
}