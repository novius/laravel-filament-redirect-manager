<?php

namespace Novius\LaravelFilamentRedirectManager\Contracts;

use Symfony\Component\HttpFoundation\Request;

/**
 * Locale of a request that ends in a 404, to choose the redirects of that locale. The middleware that sets the locale
 * of the application usually belongs to the routes, and does not run for a path that no route matches: a resolver reads
 * the locale from the request itself (domain, prefix…).
 */
interface LocaleResolver
{
    public function resolve(Request $request): ?string;
}
