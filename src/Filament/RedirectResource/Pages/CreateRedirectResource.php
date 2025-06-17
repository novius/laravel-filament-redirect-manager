<?php

namespace Novius\LaravelFilamentRedirectManager\Filament\RedirectResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\CreateRecord;
use Novius\LaravelFilamentRedirectManager\Filament\RedirectResource;

class CreateRedirectResource extends CreateRecord
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
