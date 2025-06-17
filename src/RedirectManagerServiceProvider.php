<?php

namespace Novius\LaravelFilamentRedirectManager;

use Illuminate\Support\ServiceProvider;
use Spatie\LaravelPackageTools\Package;

class RedirectManagerServiceProvider extends ServiceProvider
{
    public static string $name = 'laravel-filament-redirect-manager';

    public function configurePackage(Package $package): void
    {
        $package->name('laravel-filament-redirect-manager')
            ->hasRoute('web')
            ->hasConfigFile('laravel-filament-redirect-manager')
            ->hasTranslations()
            ->hasMigration('create_redirects_table');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $packageDir = dirname(__DIR__);

        $this->publishes([$packageDir.'/config' => config_path()], 'config');

        $this->publishes([
            $packageDir.'/database/migrations' => database_path('migrations'),
        ], 'migrations');

        $this->loadTranslationsFrom($packageDir.'/lang', 'laravel-filament-redirect-manager');
        $this->publishes([__DIR__.'/../lang' => resource_path('../lang/vendor/laravel-filament-redirect-manager')], 'lang');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-filament-redirect-manager.php',
            'laravel-filament-redirect-manager'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../config/missing-page-redirector.php',
            'missing-page-redirector'
        );
    }
}
