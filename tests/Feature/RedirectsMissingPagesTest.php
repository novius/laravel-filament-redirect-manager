<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Novius\LaravelFilamentRedirectManager\Redirector\DatabaseRedirector;

describe('redirects of a missing page', function () {
    it('redirects a missing path permanently', function () {
        createRedirect('/old', '/new');

        $this->get('/old')->assertStatus(301)->assertRedirect('/new');
    });

    it('redirects to an absolute URL', function () {
        createRedirect('/old', 'https://www.example.com/new');

        $this->get('/old')->assertRedirect('https://www.example.com/new');
    });

    it('ignores the slashes around the path, as the router does', function (string $from, string $path) {
        createRedirect($from, '/new');

        $this->get($path)->assertRedirect('/new');
    })->with([
        'trailing slash in the request' => ['/old', '/old/'],
        'trailing slash in the redirect' => ['/old/', '/old'],
        'no leading slash in the redirect' => ['old', '/old'],
    ]);

    it('matches an encoded path with a redirect stored decoded', function () {
        createRedirect('/été', '/summer');

        $this->get('/%C3%A9t%C3%A9')->assertRedirect('/summer');
    });

    it('redirects with a wildcard', function () {
        createRedirect('/blog/*', '/news');

        $this->get('/blog/2024/a-post')->assertRedirect('/news');
    });

    it('redirects with a route parameter', function () {
        createRedirect('/old-blog/{slug}', '/posts/{slug}');

        $this->get('/old-blog/a-post')->assertRedirect('/posts/a-post');
    });

    it('keeps a 404 when no redirect matches', function () {
        createRedirect('/old', '/new');

        $this->get('/unknown')->assertNotFound();
    });

    it('does not redirect a page that exists', function () {
        createRedirect('/admin/login', '/new');

        $this->get('/admin/login')->assertOk();
    });
});

describe('loaded redirects', function () {
    it('only loads the redirects that can match the path', function () {
        createRedirect('/old', '/new');
        createRedirect('/old/', '/new');
        createRedirect('/other', '/new');
        createRedirect('/blog/*', '/news');
        createRedirect('/old-blog/{slug}', '/posts/{slug}');

        $redirects = app(DatabaseRedirector::class)->getRedirectsFor(Request::create('/old'));

        expect(array_keys($redirects))->toEqualCanonicalizing(['/old', '/old/', '/blog/*', '/old-blog/{slug}']);
    });
});
