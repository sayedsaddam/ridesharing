<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\CreateRecord;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\RolesRelationManager;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Name'),
                    TextInput::make('email')
                        ->label('Email Address')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Email Address'),
                    TextInput::make('password')
                        ->password()
                        ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                        ->minLength(6)
                        ->placeholder('Password')
                        ->same('passwordConfirmation')
                        ->dehydrated(fn($state) => filled($state))
                        ->dehydrateStateUsing(fn($state) => Hash::make($state)),
                    TextInput::make('passwordConfirmation')
                        ->password()
                        ->label('Password Confirmation')
                        ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                        ->minLength(6)
                        ->placeholder('Password Confirmation')
                        ->dehydrated(false),
                    Toggle::make('is_admin')
                        ->label('Is Admin')
                        ->required()
                        ->onColor('success'),
                    CheckboxList::make('roles')
                        ->relationship('roles',  'name')
                        ->columns(2)
                        ->helperText('Only Choose One!')
                        ->required()
                ])
                ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->sortable()->searchable(),
                IconColumn::make('is_admin')->boolean(),
                TextColumn::make('roles.name')->sortable()->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('created_at')->since(),
                TextColumn::make('deleted_at')->since(),
            ])
            ->filters([
                TrashedFilter::make()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RolesRelationManager::class
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
