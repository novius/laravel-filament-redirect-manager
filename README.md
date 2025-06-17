# Laravel Filament Redirect Manager

[![Packagist Release](https://img.shields.io/packagist/v/novius/laravel-filament-redirect-manager.svg?maxAge=1800&style=flat-square)](https://packagist.org/packages/novius/laravel-filament-redirect-manager)
[![License: AGPL v3](https://img.shields.io/badge/License-AGPL%20v3-blue.svg)](http://www.gnu.org/licenses/agpl-3.0)

## Introduction

This package provides an interface to manage redirects with [Laravel Filament Redirect Manager](https://github.com/novius/laravel-filament-redirect-manager) in [Laravel Filament](https://filamentphp.com/).

## Requirements

* Laravel Filament >= 3.3
* Laravel >= 11.0
* PHP >= 8.2

> **NOTE**: These instructions are for Laravel >= 10.0 and PHP >= 8.2 If you are using prior version, please
> see the [previous version's docs](https://github.com/novius/laravel-filament-redirect-manager/tree/2.x).

## Installation

You can install the package via composer:

```bash
composer require novius/laravel-filament-redirect-manager
```

## Usage
This package allows you to manage redirects in a Laravel application through a Filament interface.


### Adding a Redirect
To add a redirect, use the Filament interface provided by the package. You can configure the following fields:

* Original URL (from): The relative URL to redirect (e.g., /old-url).
* Redirection URL (to): The absolute or relative URL to redirect to (e.g., https://www.site.com/new-url or /new-url).

```php
use Novius\LaravelFilamentRedirectManager\Filament\RedirectResource;

class RedirectResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('from')
                ->label(trans('laravel-filament-redirect-manager::redirect.from'))
                ->helperText(trans('laravel-filament-redirect-manager::redirect.relative_url_help'))
                ->required()
                ->maxLength(1000)
                ->rules(['string', new UrlRelative]),

            TextInput::make('to')
                ->label(trans('laravel-filament-redirect-manager::redirect.to'))
                ->helperText(trans('laravel-filament-redirect-manager::redirect.url_help'))
                ->required()
                ->maxLength(1000)
                ->rules(['string', new UrlAbsoluteOrRelative, 'different:from']),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('from')
                ->label(trans('laravel-filament-redirect-manager::redirect.from'))
                ->sortable()
                ->searchable(),

            TextColumn::make('to')
                ->label(trans('laravel-filament-redirect-manager::redirect.to'))
                ->sortable()
                ->searchable(),
        ]);
    }
}
```

## Lang files

If you want to customize the lang files, you can publish them with:

```bash
php artisan vendor:publish --provider="Novius\LaravelFilamentRedirectManager\RedirectManagerServiceProvider" --tag="lang"
```

## Lint

Lint your code with Laravel Pint using:

```bash
composer run-script lint
```

## Licence

This package is under [GNU Affero General Public License v3](http://www.gnu.org/licenses/agpl-3.0.html) or (at your option) any later version.
