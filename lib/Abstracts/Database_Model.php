<?php
/**
 * Database Engine Table Abstraction
 *
 * @since   1.0.0
 * @package Loader Instance
 */


namespace Underpin\BerlinDB\Abstracts;


use \BerlinDB\Database\Schema;
use \BerlinDB\Database\Table;
use \BerlinDB\Database\Query;

use Underpin\Loaders\Logger;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class BerlinDB_Table
 * Abstract Class Underpin
 *
 * @since   1.1.0
 * @package Underpin
 */
abstract class Database_Model {

	/**
	 * Database engine Table class name
	 *
	 * @since 1.0.0
	 * @var $table
	 *
	 */
	protected $table;

	/**
	 * Database engine Schema class name.
	 *
	 * @since 1.0.0
	 * @var $schema
	 *
	 */
	protected $schema;

	/**
	 * Database engine Query class name.
	 *
	 * @since 1.0.0
	 * @var $schema
	 *
	 */
	protected $query;

	/**
	 * Human readable name
	 *
	 * @since 1.0.0
	 * @var string
	 *
	 */
	protected $name = '';

	/**
	 * Human readable description.
	 *
	 * @since 1.0.0
	 * @var string
	 *
	 */
	protected $description = '';

	/**
	 * A list of errors that occurred when constructing this model.
	 *
	 * @var WP_Error
	 */
	protected $errors;

	/**
	 * Sanitize Callback.
	 *
	 * @since 1.2.0
	 *
	 * @param string $key   The column to sanitize
	 * @param mixed  $value The value to sanitize
	 *
	 * @return mixed
	 */
	abstract public function sanitize_callback( $key, $value );

	/**
	 * Database_Model constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->errors = new WP_Error();

		// Validate this class.
		$this->validate();

		// Log errors if something went wrong.
		if ( $this->errors->has_errors() ) {
			Logger::log(
				'error',
				'failed_to_create_database_model',
				'A database model failed to be created',
				[ 'errors' => $this->errors ]
			);
		} else {

			// Instantiate the table.
			$this->table();

			// Set default name, if it is not set.
			$this->set_name();

			// Set default description, if it is not set.
			$this->set_description();

		}
	}

	/**
	 * @param string $key The key to retrieve
	 * @return mixed|WP_Error The value of the param, or a WP_Error if the key is not set.
	 */
	public function __get( $key ) {
		if ( isset( $this->$key ) ) {
			return $this->$key;
		} else {
			return new WP_error( 'post_template_param_not_set', 'The batch task key ' . $key . ' could not be found.' );
		}
	}

	/**
	 * Sets the model name to the table name if the name is not set.
	 *
	 * @since 1.0.0
	 */
	protected function set_name() {
		if ( empty( $this->name ) ) {
			$this->name = $this->table()->__get( 'name' );
		}
	}

	/**
	 * Sets the model description to the table description if the name is not set.
	 *
	 * @since 1.0.0
	 */
	protected function set_description() {
		if ( empty( $this->description ) ) {
			$this->description = $this->table()->__get( 'description' );
		}
	}

	/**
	 * Installs the table.
	 *
	 * @since 1.0.0
	 *
	 * @return true|WP_Error True if the table was set up, WP_Error otherwise.
	 */
	public function install() {
		if ( is_wp_error( $this->table() ) ) {
			return $this->table();
		}

		if ( ! $this->table()->exists() ) {
			$this->table()->install();
			Logger::log(
				'notice',
				'table_installed',
				'The table ' . $this->name . ' has been installed successfully.'
				);
		}

		return true;
	}

	/**
	 * Uninstalls the table.
	 *
	 * @since 1.0.0
	 *
	 * @return true|WP_Error True if the table was set up, WP_Error otherwise.
	 */
	public function uninstall() {
		if ( is_wp_error( $this->table() ) ) {
			return $this->table();
		}

		if ( $this->table()->exists() ) {
			$this->table()->uninstall();
			wp_cache_flush();
			Logger::log(
				'notice',
				'table_uninstalled',
				'The table ' . $this->name . ' has been uninstalled successfully.'
			);
		}

		return true;
	}

	/**
	 * Resets this table, removing all data and configurations.
	 *
	 * @since 1.2.3
	 */
	public function reset() {
		$this->uninstall();
		$this->install();
	}

	/**
	 * Validates this class. This runs before anything is instantiated.
	 *
	 * @since 1.0.0
	 */
	protected function validate() {
		if ( ! is_subclass_of( $this->table, '\BerlinDB\Database\Table' ) && ! $this->table instanceof Table ) {
			$this->errors->add( 'invalid_table_instance', 'The provided table is not an instance of BerlinDB\Database\Table', [ 'value' => $this->table ] );
		}

		if ( ! is_subclass_of( $this->schema, '\BerlinDB\Database\Schema' ) && ! $this->schema instanceof Schema ) {
			$this->errors->add( 'invalid_schema_instance', 'The provided schema is not an instance of BerlinDB\Database\Schema', [ 'value' => $this->schema ] );
		}

		if ( ! is_subclass_of( $this->query, '\BerlinDB\Database\Query' ) && ! $this->query instanceof Query ) {
			$this->errors->add( 'invalid_query_instance', 'The provided query is not an instance of BerlinDB\Database\Query', [ 'value' => $this->query ] );
		}
	}

	/**
	 * Retrieves the table instance.
	 *
	 * @since 1.0.0
	 *
	 * @return Table|WP_Error The table instance if this was set as expected, otherwise WP_Error.
	 */
	public function table() {
		if ( $this->errors->has_errors() ) {
			return $this->errors;
		}

		if ( ! $this->table instanceof Table ) {
			$this->table = new $this->table;
		}

		return $this->table;
	}

	/**
	 * Retrieves the schema instance.
	 *
	 * @since 1.0.0
	 *
	 * @return Schema|WP_Error The table instance if this was set as expected, otherwise WP_Error.z
	 */
	public function schema() {
		if ( $this->errors->has_errors() ) {
			return $this->errors;
		}

		if ( ! $this->schema instanceof Schema ) {
			$this->schema = new $this->schema();
		}

		return $this->schema;
	}

	/**
	 * Instantiates a new query.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args array of query arguments.
	 * @return Query|WP_Error A query instance if this was set as expected, otherwise WP_Error.
	 */
	public function query( $args = [] ) {
		if ( $this->errors->has_errors() ) {
			return $this->errors;
		}

		return new $this->query( $args );
	}

	/**
	 * Sanitizes the value before saving to the database.
	 *
	 * @since 1.2.3
	 *
	 * @param $params
	 *
	 * @return mixed
	 */
	public function sanitize_items( $params ) {
		foreach ( $params as $key => $value ) {
			$params[ $key ] = $this->sanitize_item( $key, $value );
		}

		return $params;
	}

	/**
	 * Callback to sanitize a single value.
	 *
	 * @since 1.2.3
	 *
	 * @param string $key   The key to sanitize. Generally, this is the name of the column.
	 * @param mixed  $value The value to sanitize.
	 * @return string
	 */
	public function sanitize_item( $key, $value ) {
		if ( is_array( $value ) ) {
			$sanitized = [];

			// Recursively sanitize arrays.
			foreach ( $value as $value_key => $sub_value ) {
				$sanitized[ $value_key ] = $this->sanitize_item( $value_key, $sub_value );
			}
		} else {
			$sanitized = $this->sanitize_callback( $key, $value );
		}

		return $sanitized;
	}

	/**
	 * Saves an item to the database.
	 *
	 * @since 1.0.0
	 *
	 * @param $params
	 * @return bool|int
	 */
	public function save( $params ) {
		$params = $this->sanitize_items( $params );

		if ( isset( $params['id'] ) ) {
			$id = intval( $params['id'] );
			$this->query()->update_item( $id, $params );
		} else {
			$id = $this->query()->add_item( $params );
		}

		return $id;
	}

	/**
	 * Deletes an item.
	 *
	 * @since 1.0.0
	 *
	 * @param $id
	 * @return bool
	 */
	public function delete( $id ) {
		$deleted = $this->query()->delete_item( $id );

		return $deleted;
	}
}