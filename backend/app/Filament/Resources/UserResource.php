<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Group::make([
                Forms\Components\Section::make('Basic Information')->columns(1)->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Name')
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->required()
                        ->email(),
                ]),
                Forms\Components\Section::make('Password')->columns(1)->schema([
                    Forms\Components\TextInput::make('password')
                        ->label('Password')
                        ->required()
                        ->revealable()
                        ->password(),
                    Forms\Components\TextInput::make('confirm_password')
                        ->label('Confirm Password')
                        ->required()
                        ->revealable()
                        ->password(),
                    Forms\Components\Actions::make([
                        Forms\Components\Actions\Action::make('Generate password')
                            ->action(function (Forms\Get $get, Forms\Set $set) {
                                $set('password', Str::random(16));
                                $set('confirm_password', str($get('password')));
                            }),
                    ]),
                ]),
            ])->columnSpan(['lg' => 2]),
            Forms\Components\Group::make([
                Forms\Components\Section::make('Roles')->columns(1)->schema([
                    Forms\Components\Select::make('roles')
                        ->options(RolesEnum::class)
                        ->relationship(titleAttribute: 'name')
                        ->multiple(),
                ]),
            ])->columnSpan(['lg' => 1]),
        ])->columns(['lg' => 3]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('email')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('roles')->state(function (User $user) {
                return $user->roles->pluck('name')->join(', ');
            }),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ])
        ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
