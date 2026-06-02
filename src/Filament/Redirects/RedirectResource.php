<?php

namespace Novius\LaravelFilamentRedirectManager\Filament\Redirects;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Novius\LaravelFilamentRedirectManager\Filament\Redirects\Pages\CreateRedirect;
use Novius\LaravelFilamentRedirectManager\Filament\Redirects\Pages\EditRedirect;
use Novius\LaravelFilamentRedirectManager\Filament\Redirects\Pages\ListRedirect;
use Novius\LaravelFilamentRedirectManager\Models\Redirect;
use Novius\LaravelFilamentRedirectManager\Rules\UrlAbsoluteOrRelative;
use Novius\LaravelFilamentRedirectManager\Rules\UrlRelative;
use UnitEnum;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return config('laravel-filament-redirect-manager.filament.RedirectResource.navigationGroup');
    }

    public static function getNavigationSort(): ?int
    {
        return config('laravel-filament-redirect-manager.filament.RedirectResource.navigationSort');
    }

    public static function getNavigationLabel(): string
    {
        return config('laravel-filament-redirect-manager.filament.RedirectResource.navigationLabel', static::getPluralModelLabel());
    }

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return config('laravel-filament-redirect-manager.filament.RedirectResource.navigationIcon', 'heroicon-o-link');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return config('laravel-filament-redirect-manager.filament.RedirectResource.shouldRegisterNavigation', true);
    }

    public static function getModelLabel(): string
    {
        return trans('laravel-filament-redirect-manager::redirect.redirect');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('laravel-filament-redirect-manager::redirect.redirects');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('from')
                ->label(trans('laravel-filament-redirect-manager::redirect.from'))
                ->helperText(trans('laravel-filament-redirect-manager::redirect.relative_url_help'))
                ->required()
                ->maxLength(self::maxLengthUrl())
                ->rules(['string', new UrlRelative]),

            TextInput::make('to')
                ->label(trans('laravel-filament-redirect-manager::redirect.to'))
                ->helperText(trans('laravel-filament-redirect-manager::redirect.url_help'))
                ->required()
                ->maxLength(self::maxLengthUrl())
                ->rules(['string', new UrlAbsoluteOrRelative, 'different:from']),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('from')
            ->columns([
                TextColumn::make('id')
                    ->label(trans('laravel-filament-redirect-manager::redirect.id'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('from')
                    ->label(trans('laravel-filament-redirect-manager::redirect.from'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('to')
                    ->label(trans('laravel-filament-redirect-manager::redirect.to'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label(trans('laravel-filament-redirect-manager::redirect.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(trans('laravel-filament-redirect-manager::redirect.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRedirect::route('/'),
            'create' => CreateRedirect::route('/create'),
            'edit' => EditRedirect::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['from', 'to'];
    }

    protected static function maxLengthUrl(): int
    {
        return (int) config('missing-page-redirector.redirect_url_max_length', 1000);
    }
}
