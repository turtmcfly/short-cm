# short-cm
<p align="center">
  <a href="https://packagist.org/packages/ignittion/short"><img src="https://poser.pugx.org/ignittion/short/downloads?format=flat" alt="Total Downloads" /></a>
  <a href="https://packagist.org/packages/ignittion/short"><img src="https://poser.pugx.org/ignittion/short/v/stable?format=flat" alt="Latest Stable Version" /></a>
  <a href="https://packagist.org/packages/ignittion/short"><img src="https://poser.pugx.org/ignittion/short/license?format=flat" alt="License" /></a>
</p>

## About
Library for working with the Short.cm service

## Issues
If you have any problems please open an [Issue](https://github.com/ignittion/short-cm/issues).

## Setup

### Requirements
- PHP >= 7.0
- guzzlehttp/guzzle ^6.3
- A [short.cm](https://short.cm) account.

### Installation
Install via Composer:
```
composer require ignittion/short
```

### Configuration

#### PHP
Import the Composer autoload file.
```
require require __DIR__.'/vendor/autoload.php';
```

Create a new instance of Short.
```
$api = 'https://api.short.cm';
$domain = 'short.tld';
$key = 'abc123';

$short = new Ignittion\Short($api, $domain, $key);
```

#### Laravel 5.1+
Add the Service Provider in `config/app.php`:
```
Ignittion\Short\ShortServiceProvider::class,
```

Add the Class Alias in `config/app.php`:
```
'Short' => Ignittion\Short\Facades\Short::class,
```

Publish the Config file:
```
php artisan vendor:publish
```

Add config settings to .env
```
SHORTCM_API=https://api.short.cm
SHORTCM_DOMAIN=
SHORTCM_KEY=
```
