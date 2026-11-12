<?php

declare(strict_types=1);

namespace Novius\LaravelFilamentRedirectManager\Tests\Support;

use Filament\Http\Middleware\Authenticate;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Novius\LaravelFilamentRedirectManager\LaravelFilamentRedirectManager;

class TestPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->plugin(LaravelFilamentRedirectManager::make())
            ->middleware([
                EncryptCookies::class,
                StartSession::class,
                ShareErrorsFromSession::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
