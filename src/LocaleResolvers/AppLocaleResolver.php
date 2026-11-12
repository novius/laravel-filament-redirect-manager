<?php

namespace Novius\LaravelFilamentRedirectManager\LocaleResolvers;

use Novius\LaravelFilamentRedirectManager\Contracts\LocaleResolver;
use Symfony\Component\HttpFoundation\Request;

/**
 * Default resolver: the current locale of the application. Enough when a global middleware sets it before the redirects
 * are looked for; otherwise, configure a resolver that reads the request (`locale_resolver`).
 */
class AppLocaleResolver implements LocaleResolver
{
    public function resolve(Request $request): ?string
    {
        return app()->getLocale();
    }
}
