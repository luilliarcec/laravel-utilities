# Laravel Utilities

![run-tests](https://github.com/luilliarcec/laravel-utilities/workflows/run-tests/badge.svg)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/luilliarcec/laravel-utilities.svg)](https://packagist.org/packages/luilliarcec/laravel-utilities)
[![Total Downloads](https://img.shields.io/packagist/dt/luilliarcec/laravel-utilities)](https://packagist.org/packages/luilliarcec/laravel-utilities)
[![GitHub license](https://img.shields.io/github/license/luilliarcec/laravel-utilities)](https://github.com/luilliarcec/laravel-utilities/blob/develop/LICENSE.md)

## Installation

You can install the package via composer:

```bash
composer require luilliarcec/laravel-utilities
```

Now publish the configuration file into your app's config directory, by running the following command:

```bash
php artisan vendor:publish --provider="Luilliarcec\Utilities\UtilitiesServiceProvider"
```

## Table of Contents

- [Set Attributes Uppercase](#set-attributes-uppercase)
- [Belongs To Auth](#belongs-to-auth)
- [Decimals Rule](#decimals-rule)

## Set Attributes Uppercase

This section is for when you want to set all, or some of your attributes to uppercase.

#### Usage

```php
// ...
use Luilliarcec\Utilities\Concerns\SetAttributesUppercase;

class User extends Authenticable
{
    use SetAttributesUppercase;
}
```

If you want to ignore some attributes of your model, it can be set in the `dontApplyCase` property as follows.

```php
// ...
use Luilliarcec\Utilities\Concerns\SetAttributesUppercase;

class User extends Authenticable
{
    use SetAttributesUppercase;
    
    protected $dontApplyCase = [
        'username'
    ];
}    
```

If you want to ignore attributes globally, add them in the `utilities` config file under
the` attributes_ignored_globally` key.

## Belongs To Auth

This section is useful when you have tables in your DB model that are related to the authenticated user. By default, the
name 'user_id' is used as the foreign key for the relationship, but you can change it from the `utilities` configuration
file in the` auth_foreign_id_column` key.

You can use the `BelongsTo Auth` Trait.

1. This Trait will add a listener for the `creating` event to associate the authenticated user with the model in
   question when it is being created.
2. Also add a global scope to retrieve all the records associated with the authenticated user, you can disable this
   scope by calling the `withoutAuth` function when building your query.
3. In addition, a custom rule is available for the `exists` and` unique` rules that add the `where` condition for the
   authenticated user, for you. It can also concatenate more conditions and other functionalities of the base
   rules `exists` and` unique`.

#### Using Trait

```php
// ...
use Luilliarcec\Utilities\Concerns\BelongsToAuth;

class Invoice extends Model
{
    use BelongsToAuth;
}
```

#### Using withoutAuth function

```php
Invoice::withoutAuth()
    // ->where(...)
    ->get();
```

#### Using Rules

```php

use Luilliarcec\Utilities\Rules\Auth;

Request::validate([
    'invoice_id' => Auth::exists('invoices', 'id') // ->where(...)
]);
```

## Decimals Rule

If you want to check decimal numbers, and the number of decimal places, you can use this rule as follows.

```php
use Luilliarcec\Utilities\Rules\Decimals;

Request::validate([
    'amount' => new Decimals // by default they are 8 integers and 2 decimals
]);

Request::validate([
    'amount' => new Decimals(20, 4) // 20 integers and 4 decimals
]);
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email luilliarcec@gmail.com instead of using the issue tracker.

## Credits

- [Luis Andrés Arce C.](https://github.com/luilliarcec)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
