<?php

namespace Novius\LaravelFilamentRedirectManager\Filament\Redirects\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Novius\LaravelFilamentRedirectManager\Filament\Redirects\RedirectResource;

class ListRedirect extends ListRecords
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return RedirectResource::getUrl('index');
    }
}
