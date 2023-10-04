<?php
namespace App\Filament\Resources;
use App\Filament\Resources\VatTypeResource\Pages;
use App\Filament\Resources\VatTypeResource\RelationManagers;
use App\Models\VatType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VatTypeResource extends Resource
{
  protected static ?string $model = VatType::class;

  protected static ?string $navigationIcon = 'heroicon-o-banknotes';

  protected static ?string $navigationGroup = 'Settings';

  protected static ?string $navigationLabel = 'MwSt.-Sätze';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('description')
          ->required()
          ->maxLength(255),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('description')->sortable(),
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
        'index' => Pages\ListVatTypes::route('/'),
        'create' => Pages\CreateVatType::route('/create'),
        'edit' => Pages\EditVatType::route('/{record}/edit'),
      ];
  }    
}
