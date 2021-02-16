# Underpin BerlinDB Extension

[BerlinDB](https://github.com/berlindb/core/) Integration for the [Underpin](https://github.com/alexstandiford/underpin) WordPress framework.

A few key benefits:

1. Tables are registered through a `Database_Model` class. This class provides useful context that makes working
with BerlinDB a little easier helps keep your code DRY.
1. All tables are stored in a registry. This allows you to interact with _all_ tables at one time. Need to
   uninstall everything? You can do that with a single method, instead of manually looping through tables.
1. All CRUD actions happen through database model instead of creating `Query` instances everywhere.

## Installation

### Using Composer

`composer require alexstandiford/underpin-berlin-db`

### Manually

This plugin uses a built-in autoloader, so as long as BerlinDB is required _before_
this extension, it should work as-expected.

`require_once(__DIR__ . '/underpin-berlin-db/underpin-berlin-db.php');`

## Setup

1. Install BerlinDB and Underpin BerlinDB
1. Create BerlinDB tables, schemas, queries, and rows.
1. Create and extend the `Database_Model` class
1. Register your model:

`\Underpin\underpin()->extensions()->get('berlin_db')->db()->add('model_key','Namespace\To\Model_Class')`

It is highly recommended that you overload the Model loader with an extended loader. This will register your database
models into their own registry instead of loading them in the global registry. This is important because install and
uninstall functions will impact all items in the registry, and you could inadvertently delete data from other tables.

1. Install BerlinDB and Underpin BerlinDB
1. Create BerlinDB tables, schemas, queries, and rows.
1. Create and extend the `Database_Model` class
1. Create a loader class that extends `Loaders\Database`. It should be saved in the `loaders` directory.
1. Add that class to your Underpin instance `Service_Locator`
   
```php

//...
	/**
	 * Fetches the DB instance
	 *
	 * @return Loaders\Database
	 */
	public function db() {
		return $this->_get_loader( 'Database' );
	}
//...
```
1. Register your model by calling your loader class:

`$this->db()->add( 'test', 'Plugin_Name_Replace_Me\Database\Models\Test' );`
