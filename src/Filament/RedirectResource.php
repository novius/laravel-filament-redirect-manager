<?php

namespace Novius\LaravelFilamentRedirectManager\Filament;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Novius\LaravelFilamentRedirectManager\Filament\RedirectResource\Pages;
use Novius\LaravelFilamentRedirectManager\Models\Redirect;
use Novius\LaravelFilamentRedirectManager\Rules\UrlAbsoluteOrRelative;
use Novius\LaravelFilamentRedirectManager\Rules\UrlRelative;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    public static function getModelLabel(): string
    {
        return trans('laravel-filament-redirect-manager::redirect.redirect');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
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
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRedirectResource::route('/'),
            'create' => Pages\CreateRedirectResource::route('/create'),
            'edit' => Pages\EditRedirectResource::route('/{record}/edit'),
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
