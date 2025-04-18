<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Image;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Markdown;
use Filament\Forms\Components\View;
use Filament\Forms\Components\Html;
use Filament\Forms\Components\Text;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make([
                    Forms\Components\Section::make('Basic Information')->columns(3)->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->default(fn ($record) => $record->title) // Set default value
                            ->columnSpan(2), 
                        TextInput::make('price')
                            ->label('Price')
                            ->default(fn ($record) => '₱' . number_format($record->price, 2))
                            ->columnSpan(1),
                        TextArea::make('description')
                            ->label('Description')
                            ->default(fn ($record) => $record->description ?? 'No description available') // Set default value
                            ->columnSpan(2),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'available' => 'available',
                                'pending' => 'pending',
                                'soldout' => 'sold out',
                            ])
                            ->default(fn ($record) => $record->status)
                            ->columnSpan(1), 
                    ]),

                    Forms\Components\Section::make('Product image')->columns(3/4)->schema([
                        Placeholder::make('')
                            ->content(fn ($record) => view('filament.components.display-image', [
                                'file_path' => $record->file_path,
                                'file_name' => $record->file_name,
                            ]))
                            ->columnSpanFull(),
                    ]),
                ])->columnSpan(['lg' => 2]),
                Forms\Components\Group::make([
                    Forms\Components\Section::make('Seller')->columns(1)->schema([
                        Placeholder::make('createdBy.name')
                            ->label('Fullname')
                            ->content(fn ($record) => $record->createdBy->name ?? 'No creator available')
                            ->columnSpan(1),
                        placeholder::make('createdBy.email')
                            ->label('Email')
                            ->content(fn ($record) => $record->createdBy->email ?? 'No email available')
                            ->columnSpan(1),
                        
                    ]),
                ])->columnSpan(['lg' => 1]),
                ])->columns(['lg' => 3]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('image')
                    ->label('Item Image')
                    ->square()
                    ->disk('public')
                    ->getStateUsing(fn ($record) => asset("storage/{$record->file_path}/{$record->file_name}")),
                
                Tables\Columns\TextColumn::make('price')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('createdBy.name')
                    ->label('Created_by')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
            'view' => Pages\ViewItem::route('/{record}'),
        ];
    }
}
