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
        $this->extendConfigFrom(
            __DIR__.'/../config/laravel-filament-redirect-manager.php',
            'missing-page-redirector'
        );
    }

    /**
     * Merges the specified config from another package. Does the opposite of mergeConfigFrom().
     */
    protected function extendConfigFrom($path, $key)
    {
        $config = $this->app['config']->get($key, []);

        $this->app['config']->set($key, array_merge($config, require $path));
    }
}
