<?php

declare(strict_types=1);

namespace Novius\LaravelFilamentRedirectManager\Tests\Support;

use Novius\LaravelFilamentRedirectManager\Contracts\LocaleResolver;
use Symfony\Component\HttpFoundation\Request;

/**
 * One domain per locale, as the README suggests for a site where no route matches the missing path.
 */
class HostLocaleResolver implements LocaleResolver
{
    public function resolve(Request $request): ?string
    {
        return match ($request->getHost()) {
            'site.fr' => 'fr',
            'site.com' => 'en',
            'site.de' => 'de',
            default => null,
        };
    }
}
