<?php
/**
 * Database Loader
 *
 * @since   1.0.0
 * @package Underpin_Berlin_DB\Loaders
 */


namespace Underpin_Berlin_DB\Loaders;
use Underpin\Abstracts\Registries\Loader_Registry;
use Underpin_Berlin_DB\Abstracts\Database_Model;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Database
 * Database Registry
 *
 * @since   1.0.0
 * @package Underpin_Berlin_DB\Loaders
 */
class Database extends Loader_Registry {

	/**
	 * @inheritDoc
	 */
	protected $abstraction_class = '\Underpin_Berlin_DB\Abstracts\Database_Model';

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