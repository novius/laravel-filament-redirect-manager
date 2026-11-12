<?php

declare(strict_types=1);

use Livewire\Livewire;
use Novius\LaravelFilamentRedirectManager\Filament\Redirects\Pages\CreateRedirect;
use Novius\LaravelFilamentRedirectManager\Filament\Redirects\Pages\EditRedirect;
use Novius\LaravelFilamentRedirectManager\Filament\Redirects\Pages\ListRedirect;
use Novius\LaravelFilamentRedirectManager\Filament\Redirects\RedirectResource;
use Novius\LaravelFilamentRedirectManager\Models\Redirect;
use Workbench\Database\Factories\UserFactory;

beforeEach(function () {
    $this->actingAs(UserFactory::new()->create());
});

describe('list', function () {
    it('lists the redirects', function () {
        $redirects = collect([
            createRedirect('/old', '/new'),
            createRedirect('/legal', '/mentions-legales', 'fr'),
        ]);

        $this->get(RedirectResource::getUrl())->assertOk();

        Livewire::test(ListRedirect::class)
            ->assertCanSeeTableRecords($redirects)
            ->assertTableColumnVisible('locale')
            ->assertTableColumnFormattedStateSet('locale', 'Français', $redirects->last());
    });

    it('filters the redirects by locale', function () {
        $all = createRedirect('/old', '/new');
        $fr = createRedirect('/legal', '/mentions-legales', 'fr');

        Livewire::test(ListRedirect::class)
            ->filterTable('locale', 'fr')
            ->assertCanSeeTableRecords([$fr])
            ->assertCanNotSeeTableRecords([$all]);
    });

    it('hides the locale without locales', function () {
        redirectLocales([]);

        Livewire::test(ListRedirect::class)
            ->assertTableColumnHidden('locale')
            ->assertTableFilterHidden('locale');
    });
});

describe('creation', function () {
    it('creates a redirect for a locale', function () {
        Livewire::test(CreateRedirect::class)
            ->assertFormFieldVisible('locale')
            ->fillForm(['locale' => 'fr', 'from' => '/legal', 'to' => '/mentions-legales'])
            ->call('create')
            ->assertHasNoFormErrors();

        $redirect = Redirect::query()->sole();
        expect($redirect->locale)->toBe('fr')
            ->and($redirect->from)->toBe('/legal')
            ->and($redirect->to)->toBe('/mentions-legales');
    });

    it('creates a redirect for every locale', function () {
        Livewire::test(CreateRedirect::class)
            ->fillForm(['from' => '/old', 'to' => '/new'])
            ->call('create')
            ->assertHasNoFormErrors();

        expect(Redirect::query()->sole()->locale)->toBeNull();
    });

    it('refuses a locale that is not one of the redirects', function () {
        Livewire::test(CreateRedirect::class)
            ->fillForm(['locale' => 'de', 'from' => '/old', 'to' => '/new'])
            ->call('create')
            ->assertHasFormErrors(['locale' => 'in']);

        expect(Redirect::query()->count())->toBe(0);
    });

    it('hides the locale without locales', function () {
        redirectLocales([]);

        Livewire::test(CreateRedirect::class)
            ->assertFormFieldHidden('locale')
            ->fillForm(['from' => '/old', 'to' => '/new'])
            ->call('create')
            ->assertHasNoFormErrors();

        expect(Redirect::query()->sole()->locale)->toBeNull();
    });

    it('validates the URLs', function (array $data, array $errors) {
        Livewire::test(CreateRedirect::class)
            ->fillForm($data)
            ->call('create')
            ->assertHasFormErrors($errors);
    })->with([
        'missing URLs' => [['from' => '', 'to' => ''], ['from' => 'required', 'to' => 'required']],
        'absolute original URL' => [['from' => 'https://www.example.com/old', 'to' => '/new'], ['from']],
        'invalid redirection URL' => [['from' => '/old', 'to' => 'not an url'], ['to']],
        'same URLs' => [['from' => '/old', 'to' => '/old'], ['to' => 'different']],
    ]);
});

describe('edition', function () {
    it('changes the locale of a redirect', function () {
        $redirect = createRedirect('/legal', '/mentions-legales', 'fr');

        Livewire::test(EditRedirect::class, ['record' => $redirect->getRouteKey()])
            ->assertSchemaStateSet(['locale' => 'fr', 'from' => '/legal'])
            ->fillForm(['locale' => 'en', 'to' => '/legal-notice'])
            ->call('save')
            ->assertHasNoFormErrors();

        expect($redirect->refresh()->locale)->toBe('en')
            ->and($redirect->to)->toBe('/legal-notice');
    });
});

describe('navigation', function () {
    it('has the default navigation without the config published', function () {
        expect(RedirectResource::getNavigationIcon())->toBe('heroicon-o-link')
            ->and(RedirectResource::getNavigationLabel())->toBe('Redirects')
            ->and(RedirectResource::shouldRegisterNavigation())->toBeTrue();
    });
});
