<?php

namespace Novius\LaravelFilamentRedirectManager\Redirector;

use Illuminate\Database\Eloquent\Builder;
use Novius\LaravelFilamentRedirectManager\Contracts\LocaleResolver;
use Novius\LaravelFilamentRedirectManager\LocaleResolvers\AppLocaleResolver;
use Spatie\MissingPageRedirector\Redirector\Redirector;
use Symfony\Component\HttpFoundation\Request;

class DatabaseRedirector implements Redirector
{
    /**
     * Redirects that can match the path of the request: without locales (`locales` empty), all of them; otherwise those
     * without locale and those of the locale of the request, the latter winning for the same path.
     */
    public function getRedirectsFor(Request $request): array
    {
        $model = config('missing-page-redirector.redirector_model');
        $query = $model::query()->select('to', 'from');

        // Only the redirects of the path of the request, and those with a wildcard or a parameter that the router of
        // Spatie matches itself: no need to load and register as routes all the redirects at each 404
        $query->where(function (Builder $query) use ($request) {
            $query->whereIn('from', $this->fromCandidates($request))
                ->orWhere('from', 'like', '%*%')
                ->orWhere('from', 'like', '%{%');
        });

        if (! empty(config('laravel-filament-redirect-manager.locales'))) {
            $locale = $this->localeResolver()->resolve($request);
            $query->where(function (Builder $query) use ($locale) {
                $query->whereNull('locale');
                if ($locale !== null) {
                    $query->orWhere('locale', $locale);
                }
            })
                // The redirects of the locale come last: for the same path, they replace those without locale
                ->orderByRaw('locale IS NOT NULL');
        }

        // In the order of creation: the first route that matches wins, so an exact path created before a wildcard keeps
        // its own target
        return $query->orderBy((new $model)->getKeyName())->get()->pluck('to', 'from')->toArray();
    }

    /**
     * Values of `from` matching the path of the request. The router of Laravel ignores the slashes around the URI of a
     * route and those at the end of the path, and matches the decoded path: `/old-url`, `/old-url/`, `old-url`… all
     * match the path `/old-url`, encoded or not.
     *
     * @return array<int, string>
     */
    protected function fromCandidates(Request $request): array
    {
        $candidates = [];
        foreach (array_unique([$request->getPathInfo(), rawurldecode($request->getPathInfo())]) as $path) {
            $path = trim($path, '/');
            array_push($candidates, '/'.$path, '/'.$path.'/', $path, $path.'/');
        }

        return array_values(array_unique($candidates));
    }

    protected function localeResolver(): LocaleResolver
    {
        return app(config('laravel-filament-redirect-manager.locale_resolver') ?: AppLocaleResolver::class);
    }
}
