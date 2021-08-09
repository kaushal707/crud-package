# Laravel CRUD Generator

This package provides a super easy way to make a laravel crud opration.

## Features
* It Creates a Model with all feilds validation
* It Creates a Migration Table with table fields provided by users.
* It Runs the migration of specific table .
* It Creates resource controller with all functionallity .
* It Creates view files Index.blade.php, Create.blade.php, show.blade.php, edit.blade.php .
* Laravel 7 and higher
* PHP 7.3 and higher.


## Support

We proudly support the community by developing Laravel packages and giving them away for free. Keeping track of issues and pull requests takes time, but we're happy to help!

## Installation

You can install the package via composer:

```bash

composer require kaushalmaurya/crud

```

Add the Service Provider  to your ```app.php``` config file if you're not using Package Discovery.

```php

// config/app.php

'providers' => [
    ...

    Kaushal\Crud\CrudServiceProvider::class,
    ...
];


```

## License

The MIT License (MIT). 