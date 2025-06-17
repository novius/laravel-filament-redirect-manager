<?php

namespace Novius\LaravelFilamentRedirectManager\Filament\RedirectResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Novius\LaravelFilamentRedirectManager\Filament\RedirectResource;

class EditRedirectResource extends EditRecord
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            RestoreAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return RedirectResource::getUrl('index');
    }
}
