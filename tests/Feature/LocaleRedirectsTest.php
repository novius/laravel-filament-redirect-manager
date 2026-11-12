<?php

declare(strict_types=1);

use Novius\LaravelFilamentRedirectManager\Tests\Support\HostLocaleResolver;

describe('redirects by locale', function () {
    beforeEach(function () {
        config(['laravel-filament-redirect-manager.locale_resolver' => HostLocaleResolver::class]);

        createRedirect('/legal', '/legal-notice');
        createRedirect('/legal', '/mentions-legales', 'fr');
    });

    it('prefers the redirect of the locale of the request', function () {
        $this->get('http://site.fr/legal')->assertRedirect('http://site.fr/mentions-legales');
    });

    it('falls back on the redirect without locale', function () {
        $this->get('http://site.com/legal')->assertRedirect('http://site.com/legal-notice');
    });

    it('ignores the redirects of another locale', function () {
        createRedirect('/only-fr', '/seulement-fr', 'fr');

        $this->get('http://site.com/only-fr')->assertNotFound();
        $this->get('http://site.fr/only-fr')->assertRedirect('http://site.fr/seulement-fr');
    });

    it('only uses the redirects without locale for a locale that is not one of the redirects', function () {
        $this->get('http://site.de/legal')->assertRedirect('http://site.de/legal-notice');
    });

    it('only uses the redirects without locale when the locale is unknown', function () {
        createRedirect('/only-fr', '/seulement-fr', 'fr');

        $this->get('http://localhost/legal')->assertRedirect('http://localhost/legal-notice');
        $this->get('http://localhost/only-fr')->assertNotFound();
    });

    it('uses the locale of the application by default', function () {
        config(['laravel-filament-redirect-manager.locale_resolver' => null]);
        app()->setLocale('fr');

        $this->get('/legal')->assertRedirect('/mentions-legales');
    });
});

describe('without locales', function () {
    it('ignores the locale of the redirects', function () {
        redirectLocales([]);
        config(['laravel-filament-redirect-manager.locale_resolver' => HostLocaleResolver::class]);
        createRedirect('/only-fr', '/seulement-fr', 'fr');

        $this->get('http://site.com/only-fr')->assertRedirect('http://site.com/seulement-fr');
    });
});
