<?php

use Novius\LaravelFilamentRedirectManager\Filament\Redirects\RedirectResource;
use Novius\LaravelFilamentRedirectManager\Models\Redirect;
use Novius\LaravelFilamentRedirectManager\Redirector\DatabaseRedirector;

return [

    'redirector_model' => Redirect::class,

    'redirect_url_max_length' => 1000,

    'redirector' => DatabaseRedirector::class,

    'resources' => [
        'RedirectResource' => RedirectResource::class,
    ],

    'filament' => [
        'RedirectResource' => [
            'navigationLabel' => null,
            'navigationIcon' => null,
            'navigationSort' => null,
            'navigationGroup' => null,
            'shouldRegisterNavigation' => true,
        ],
    ],
];
