<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryStateResource\Pages;
use App\Filament\Resources\InventoryStateResource\RelationManagers;
use App\Models\InventoryState;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Translatable\HasTranslations;

class InventoryStateResource extends Resource
{
    protected static ?string $model = InventoryState::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = 'Bestandes Status';

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              Forms\Components\TextInput::make('description_de')
                ->label('Description')
                ->hint('DE')
                ->required()
                ->maxLength(255),
              Forms\Components\TextInput::make('description_en')
                ->label('Description')
                ->hint('EN')
                ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
              Tables\Columns\TextColumn::make('description_de')->label('Description')->sortable(),
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
            'index' => Pages\ListInventoryStates::route('/'),
            'create' => Pages\CreateInventoryState::route('/create'),
            'edit' => Pages\EditInventoryState::route('/{record}/edit'),
        ];
    }    
}
