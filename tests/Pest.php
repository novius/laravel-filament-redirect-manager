<?php

declare(strict_types=1);

use Novius\LaravelFilamentRedirectManager\Models\Redirect;
use Novius\LaravelFilamentRedirectManager\Tests\TestCase;

pest()->extend(TestCase::class)->in(__DIR__);

/**
 * Locales of the redirects (fr and en by default), empty for redirects without locale.
 *
 * @param  array<string, string>  $locales  code => label
 */
function redirectLocales(array $locales): void
{
    config(['laravel-filament-redirect-manager.locales' => $locales]);
}

function createRedirect(string $from, string $to, ?string $locale = null): Redirect
{
    return Redirect::query()->create(['from' => $from, 'to' => $to, 'locale' => $locale]);
}
