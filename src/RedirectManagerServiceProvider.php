<?php

namespace Novius\LaravelFilamentRedirectManager;

use Illuminate\Support\ServiceProvider;

class RedirectManagerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $packageDir = dirname(__DIR__);

        $this->publishes([$packageDir.'/config' => config_path()], 'config');

        $this->publishes([$packageDir.'/database/migrations' => database_path('migrations')], 'migrations');
        $this->loadMigrationsFrom($packageDir.'/database/migrations');

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
