# COMPREDICT Service Provider for Laravel 5

This is a simple [Laravel](http://laravel.com/) service provider for making it easy to include the official
[COMPREDICT SDK for PHP](https://github.com/compredict/ai-sdk-php) in your Laravel and Lumen applications.

This README is for version 1.x of the service provider, which is implemented to work with Version 1 of the
COMPREDICT AI Core SDK for PHP and Laravel 5.x.

## Installation

The COMPREDICT Service Provider can be installed via [Composer](http://getcomposer.org) by requiring the
`compredict/ai-sdk-laravel` package in your project's `composer.json`.

```json
{
    "require": {
        "compredict/ai-sdk-laravel": "dev-master"
    }
}
```

Then run a composer update
```sh
php composer.phar update
```

To use the COMPREDICT Service Provider, you must register the provider when bootstrapping your application.


### Lumen
In Lumen find the `Register Service Providers` in your `bootstrap/app.php` and register the COMPREDICT Service Provider.

```php
    $app->register(Compredict\Laravel\CompredictServiceProvider::class);
```

### Laravel
In Laravel find the `providers` key in your `config/app.php` and register the COMPREDICT Service Provider.

```php
    'providers' => array(
        // ...
        Compredict\Laravel\CompredictServiceProvider::class,
    )
```

Find the `aliases` key in your `config/app.php` and add the COMPREDICT facade alias.

```php
    'aliases' => array(
        // ...
        'COMPREDICT' => Compredict\Laravel\CompredictFacade::class,
    )
```

## Configuration

By default, the package uses the following environment variables to auto-configure the plugin without modification:
```
COMPREDICT_AI_CORE_KEY=
COMPREDICT_AI_CORE_USER=
COMPREDICT_AI_CORE_CALLBACK=
COMPREDICT_AI_CORE_FAIL_ON_ERROR=true
COMPREDICT_AI_CORE_PPK=Path/to/PPK.pem
COMPREIDCT_AI_CORE_PASSPHRASE=
```

To customize the configuration file, publish the package configuration using Artisan.

```sh
php artisan vendor:publish  --provider="Compredict\Laravel\CompredictServiceProvider"
```

Update your settings in the generated `app/config/compredict.php` configuration file.

## Usage

In order to use the COMPREDICT's AI Core SDK for PHP within your app, you need to retrieve it from the [Laravel IoC
Container](http://laravel.com/docs/ioc). The following example gets all the algorithms allowed for the user.

```php
$algorithms = App::make('compredict')->getAlgorithms();
```