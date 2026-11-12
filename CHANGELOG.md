# Changelog

All notable changes to `novius/laravel-filament-redirect-manager` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased](https://github.com/novius/laravel-filament-redirect-manager/compare/1.0.3...main)

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
