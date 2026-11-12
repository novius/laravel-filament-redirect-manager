# Changelog

All notable changes to `novius/laravel-filament-redirect-manager` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased](https://github.com/novius/laravel-filament-redirect-manager/compare/1.1.0...HEAD)

## [1.1.0](https://github.com/novius/laravel-filament-redirect-manager/compare/1.0.3...1.1.0) - 2026-11-12

### Added

- Redirects by locale, for sites with one domain or one prefix per locale. A new migration adds an optional
  `locale` column to `redirects`: run `php artisan migrate`.
- `locales` config key (`code => label`): the locales with their own domain or prefix. When it is set, the Filament
  resource shows a locale field, column and filter. A redirect without locale applies to every locale; for the same
  path, the redirect of the request's locale wins. With `locales` empty (the default), nothing changes.
- `locale_resolver` config key and `Contracts\LocaleResolver` interface, to give the locale of a request that ends in
  a 404. The default `AppLocaleResolver` returns the locale of the application.

### Changed

- On a 404, only the redirects that can match the path of the request are loaded (exact path, plus those with `*` or
  a route parameter), instead of all of them.

### Fixed

- The redirection URL must differ from the original URL: the `different:from` rule was never applied, as Filament
  validates the fields under `data.`.
- The package config is merged into `laravel-filament-redirect-manager`, so the navigation options have their default
  values without publishing the config.
- The `id` of the `Redirect` model is typed `int` in its PHPDoc.

## [1.0.3](https://github.com/novius/laravel-filament-redirect-manager/compare/1.0.2...1.0.3) - 2026-06-02

### Fixed

- The navigation label and icon of the redirects resource fall back to the translated plural label and
  `heroicon-o-link` when their config value is `null`.

## [1.0.2](https://github.com/novius/laravel-filament-redirect-manager/compare/1.0.1...1.0.2) - 2026-06-02

### Added

- Config options for the Filament navigation of the redirects resource (`filament.RedirectResource`): label, icon,
  sort, group and whether it is registered.

## [1.0.1](https://github.com/novius/laravel-filament-redirect-manager/compare/1.0.0...1.0.1) - 2026-05-12

### Added

- Laravel 13 compatibility (`orchestra/testbench` 11 allowed).

### Changed

- Requires `spatie/laravel-missing-page-redirector` 2.10 or later; `laravel/framework` is no longer required
  directly.

## [1.0.0](https://github.com/novius/laravel-filament-redirect-manager/releases/tag/1.0.0) - 2026-02-18

First release of the Filament package. Requires PHP 8.2+, Laravel 11 or 12 and Filament 4 or 5.

### Added

- Filament resource to manage redirects (relative `from` URL, absolute or relative `to` URL), registered with the
  `LaravelFilamentRedirectManager` plugin.
- Database redirector for `spatie/laravel-missing-page-redirector`.
- Configurable model and resource classes, and maximum URL length.
- English and French translations.
