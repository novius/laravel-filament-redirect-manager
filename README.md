<div align="center">

# Laravel Filament Redirect Manager

[![Novius CI](https://github.com/novius/laravel-filament-redirect-manager/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/novius/laravel-filament-redirect-manager/actions/workflows/ci.yml)
[![Packagist Release](https://img.shields.io/packagist/v/novius/laravel-filament-redirect-manager.svg?maxAge=1800&style=flat-square)](https://packagist.org/packages/novius/laravel-filament-redirect-manager)
[![License: AGPL v3](https://img.shields.io/badge/License-AGPL%20v3-blue.svg)](http://www.gnu.org/licenses/agpl-3.0)

</div>

## Introduction

This package provides an interface to manage redirects with [Laravel Filament Redirect Manager](https://github.com/novius/laravel-filament-redirect-manager) in [Laravel Filament](https://filamentphp.com/).

## Requirements

* Laravel Filament >= 4
* Laravel >= 11.0
* PHP >= 8.2

## Installation

### Composer

Install the package via composer:

```bash
composer require novius/laravel-filament-redirect-manager
```

### Middleware

Next, prepend/append the Spatie\MissingPageRedirector\RedirectsMissingPages middleware to your global middleware stack:

```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    $middleware->append([
        \Spatie\MissingPageRedirector\RedirectsMissingPages::class,
    ]);
})
```

### Filament plugin

Add the `LaravelFilamentRedirectManager` plugin in your Filament Panel

```php
use Novius\LaravelFilamentRedirectManager\LaravelFilamentRedirectManager;

class AdminFilamentPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ...
            ->plugins([
                // ...
                LaravelFilamentRedirectManager::make(),
            // ...
            ])
            // ...
            ;
    }
}
```

### Lang files

If you want to customize the lang files, you can publish them with:

```bash
php artisan vendor:publish --provider="Novius\LaravelFilamentRedirectManager\RedirectManagerServiceProvider" --tag="lang"
```

## Usage
This package allows you to manage redirects in a Laravel application through a Filament interface.

### Adding a Redirect

To add a redirect, use the Filament interface provided by the package. You can configure the following fields:

* Original URL (from): The relative URL to redirect (e.g., /old-url).
* Redirection URL (to): The absolute or relative URL to redirect to (e.g., https://www.site.com/new-url or /new-url).

### Redirects by locale

On a site with one domain or one prefix per locale, the same old path can lead to a different page in each locale
(`/legal-notice.html` on `www.site.fr` and on `www.site.com`). A redirect can then be limited to a locale.

Publish the config and list the locales of the redirects:

```bash
php artisan vendor:publish --provider="Novius\LaravelFilamentRedirectManager\RedirectManagerServiceProvider" --tag="config"
```

```php
// config/laravel-filament-redirect-manager.php
'locales' => [
    'fr' => 'Français',
    'en' => 'English',
],
'locale_resolver' => \App\Redirects\RequestLocaleResolver::class,
```

The Filament form and list then show a « Locale » field and filter. A redirect without locale applies to every
locale; for the same path, the redirect of the locale of the request wins. With `locales` empty (the default), the
redirects have no locale and the behaviour is unchanged.

The locale of the request comes from the `locale_resolver` (`Contracts\LocaleResolver`). The default one takes the
locale of the application, but the middleware that sets it usually belongs to the routes and does not run for a path
that no route matches: on such a site, write a resolver that reads the locale from the request (its domain or its
prefix).

## Lint

Lint your code with Laravel Pint using:

```bash
composer lint
```

## Static analysis

Analyse your code with PHPStan using:

```bash
composer analyse
```

## Tests

Run the tests with Pest using:

```bash
composer test
```

## Licence

This package is under [GNU Affero General Public License v3](http://www.gnu.org/licenses/agpl-3.0.html) or (at your option) any later version.
