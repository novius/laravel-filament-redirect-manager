<?php

declare(strict_types=1);

namespace Novius\LaravelFilamentRedirectManager\Tests;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Novius\LaravelFilamentRedirectManager\RedirectManagerServiceProvider;
use Novius\LaravelFilamentRedirectManager\Tests\Support\TestPanelProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\MissingPageRedirector\MissingPageRedirectorServiceProvider;
use Spatie\MissingPageRedirector\RedirectsMissingPages;
use Workbench\App\Models\User;

abstract class TestCase extends Orchestra
{
    use RefreshDatabase;
    use WithWorkbench;

    /**
     * Load every package discovered in vendor/ (Filament, Livewire, laravel-lang...), as a host project does.
     *
     * @return array<int, string>
     */
    public function ignorePackageDiscoveriesFrom(): array
    {
        return [];
    }

    protected function getPackageProviders($app): array
    {
        return [
            MissingPageRedirectorServiceProvider::class,
            RedirectManagerServiceProvider::class,
            TestPanelProvider::class,
        ];
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadLaravelMigrations();
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('app.locale', 'en');
        $app['config']->set('auth.providers.users.model', User::class);
        // A site with one domain per locale
        $app['config']->set('laravel-filament-redirect-manager.locales', ['fr' => 'Français', 'en' => 'English']);

        // As the README asks the host application to do
        $app->make(Kernel::class)->pushMiddleware(RedirectsMissingPages::class);
    }
}
