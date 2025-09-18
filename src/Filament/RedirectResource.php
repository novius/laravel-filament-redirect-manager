<?php

namespace Novius\LaravelFilamentRedirectManager\Filament;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Novius\LaravelFilamentRedirectManager\Filament\RedirectResource\Pages\ListRedirectResource;
use Novius\LaravelFilamentRedirectManager\Filament\RedirectResource\Pages\CreateRedirectResource;
use Novius\LaravelFilamentRedirectManager\Filament\RedirectResource\Pages\EditRedirectResource;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Novius\LaravelFilamentRedirectManager\Filament\RedirectResource\Pages;
use Novius\LaravelFilamentRedirectManager\Models\Redirect;
use Novius\LaravelFilamentRedirectManager\Rules\UrlAbsoluteOrRelative;
use Novius\LaravelFilamentRedirectManager\Rules\UrlRelative;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-link';

    public static function getModelLabel(): string
    {
        return trans('laravel-filament-redirect-manager::redirect.redirect');
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
            ], RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRedirectResource::route('/'),
            'create' => CreateRedirectResource::route('/create'),
            'edit' => EditRedirectResource::route('/{record}/edit'),
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
