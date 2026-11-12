<?php

use Novius\LaravelFilamentRedirectManager\Filament\Redirects\RedirectResource;
use Novius\LaravelFilamentRedirectManager\LocaleResolvers\AppLocaleResolver;
use Novius\LaravelFilamentRedirectManager\Models\Redirect;
use Novius\LaravelFilamentRedirectManager\Redirector\DatabaseRedirector;

return [

    'redirector_model' => Redirect::class,

    'redirect_url_max_length' => 1000,

    'redirector' => DatabaseRedirector::class,

    /*
     * Locales of the redirects (code => label), for a site with one domain or prefix per locale: a redirect can then be
     * limited to a locale, the same old path leading to a different page in each one. Empty: redirects without locale.
     */
    'locales' => [],

    /*
     * Class giving the locale of a request that ends in a 404 (Contracts\LocaleResolver). The default one takes the
     * locale of the application, which is often not set yet for a path that no route matches.
     */
    'locale_resolver' => AppLocaleResolver::class,

    'resources' => [
        'RedirectResource' => RedirectResource::class,
    ],

    'filament' => [
        'RedirectResource' => [
            'navigationLabel' => null,
            'navigationIcon' => 'heroicon-o-link',
            'navigationSort' => null,
            'navigationGroup' => null,
            'shouldRegisterNavigation' => true,
        ],
    ],
];
