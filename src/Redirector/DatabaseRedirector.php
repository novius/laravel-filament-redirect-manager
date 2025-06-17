<?php

namespace Novius\LaravelFilamentRedirectManager\Redirector;

use Spatie\MissingPageRedirector\Redirector\Redirector;
use Symfony\Component\HttpFoundation\Request;

class DatabaseRedirector implements Redirector
{
    public function getRedirectsFor(Request $request): array
    {
        $model = config('laravel-filament-redirect-manager.redirector_model');

        return $model::select('to', 'from')->get()->pluck('to', 'from')->toArray();
    }
}
