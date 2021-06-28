# Underpin BerlinDB Extension

[BerlinDB](https://github.com/berlindb/core/) Integration for the [Underpin](https://github.com/underpin-wp/underpin) WordPress framework.

A few key benefits:

1. Tables are registered through a `Database_Model` class. This class provides useful context that makes working
with BerlinDB a little easier helps keep your code DRY.
1. All tables are stored in a registry. This allows you to interact with _all_ tables at one time. Need to
   uninstall everything? You can do that with a single method, instead of manually looping through tables.
1. All CRUD actions happen through database model instead of creating `Query` instances everywhere.

## Installation

### Using Composer

`composer require underpin/berlindb-extension`

### Manually

This plugin uses a built-in autoloader, so as long as BerlinDB is required _before_
this extension, it should work as-expected.

`require_once(__DIR__ . '/underpin-berlin-db/underpin-berlin-db.php');`

## Setup

1. Install [BerlinDB](https://www.github.com/berlindb/core)
1. Install Underpin. See [Underpin Docs](https://www.github.com/underpin-wp/underpin)
1. Create BerlinDB classes.
1. Register new database models as-needed.

## Example

If you currently have all BerlinDB classes built, you can reference them directly like-so. This will create a new database
model called `example`, which can be referenced with `underpin()->berlin_db()->get('example')`.

```php
underpin()->berlin_db()->add( 'example', [
	'table'             => 'Namespace\To\Berlin_DB\Table',
	'schema'            => 'Namespace\To\Berlin_DB\Schema',
	'query'             => 'Namespace\To\Berlin_DB\Query',
	'name'              => 'Human Readable Table Name',
	'description'       => 'Description of the purpose of this table',
	'sanitize_callback' => function( $key, $value ){
		// Function to sanitize fields before saving.
	}
] );
```

Alternatively, you can extend `Database_Model` and reference the extended class directly, like so:

```php
underpin()->berlin_db()->add('database-model-key','Namespace\To\Class');
```

## Working With the Model

Once registered, you can access any of the classes inside the model using the various helper methods.

```php
// Run a query using the specified model
underpin()->berlin_db()->get('example')->query([/*...*/]);

// Get table object
underpin()->berlin_db()->get('example')->table();

// Get schema
underpin()->berlin_db()->get('example')->schema();
```

## Creating, Updating, and Deleting

The model includes a handful of helper functions to make it a little easier to update data.

```php
// Automatically sanitize, and then create/update a record.
// If the provided arguments include an ID, it will update that record.
// Otherwise, it will simply create a new record.
$id = underpin()->berlin_db()->save( [/*...*/] );

// Delete a record
$deleted = underpin()->berlin_db()->delete( $id );
```

## Table Setup

```php
// Install all tables
underpin()->berlin_db()->install();

// Reset all tables
underpin()->berlin_db()->reset();

// Delete all tables
underpin()->berlin_db()->uninstall();
```

## Meta Tables

If a database model also has a meta table, it is possible to instruct the model to make that table accessible in the
model. To-do this, you simply have to use the `Database_Model_With_Meta_Instance` when registering your model.

```php
// Meta Table
underpin()->berlin_db()->add( 'example-meta-table', [
	'table'             => 'Namespace\To\Berlin_DB\Table',
	'schema'            => 'Namespace\To\Berlin_DB\Schema',
	'query'             => 'Namespace\To\Berlin_DB\Query',
	'name'              => 'Human Readable Table Name',
	'description'       => 'Description of the purpose of this table',
	'sanitize_callback' => function( $key, $value ){
		// Function to sanitize fields before saving.
	}
] );

// Table
underpin()->berlin_db()->add( 'example', [
    'class' => 'Underpin_BerlinDB\Factories\Database_Model_With_Meta_Instance',
    'args' => [
       'table'             => 'Namespace\To\Berlin_DB\Table',
       'schema'            => 'Namespace\To\Berlin_DB\Schema',
       'query'             => 'Namespace\To\Berlin_DB\Query',
       'name'              => 'Human Readable Table Name',
       'description'       => 'Description of the purpose of this table',
       'sanitize_callback' => function( $key, $value ){
           // Function to sanitize fields before saving.
       },
       'get_meta_table_callback' => function(){
          return underpin()->berlin_db()->get('example-meta-table');
       }
	]
] );
```

Alternatively, you can extend `Database_Model`, use the `With_Meta` trait, and then reference the extended class directly,
like so:

```php
underpin()->berlin_db()->add('database-model-key','Namespace\To\Class\Using\With_Meta\Trait');
```


With this setup, you now have access to a few other methods from within the `example` model's context.

```php
//add_meta
underpin()->berlin_db()->get('example')->add_meta(/*...*/);

//update_meta
underpin()->berlin_db()->get('example')->update_meta(/*...*/);

//delete_meta
underpin()->berlin_db()->get('example')->delete_meta(/*...*/);

//get_meta
underpin()->berlin_db()->get('example')->get_meta(/*...*/);
```
