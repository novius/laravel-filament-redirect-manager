<?php

return [

    'redirector_model' => \Novius\LaravelFilamentRedirectManager\Models\Redirect::class,

    'redirect_url_max_length' => 1000,

    'redirector' => \Novius\LaravelFilamentRedirectManager\Redirector\DatabaseRedirector::class,

    'resources' => [
        'RedirectResource' => \Novius\LaravelFilamentRedirectManager\Filament\RedirectResource::class,
    ],
];
