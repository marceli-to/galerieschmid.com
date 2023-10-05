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
use Filament\Resources\Concerns\Translatable;

class VatTypeResource extends Resource
{
  use Translatable;

  protected static ?string $model = VatType::class;

  protected static ?string $navigationIcon = 'heroicon-o-banknotes';

  protected static ?string $navigationGroup = 'Settings';

  protected static ?string $navigationLabel = 'MwSt.-Sätze';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('description')
          ->label('Description')
          ->required()
          ->maxLength(255),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('display_name')
        ->label('Description')
        ->searchable()
        ->sortable(),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ])->defaultSort('display_name', 'asc');
  }

  public static function getRelations(): array
  {
    return [
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

  public function validationRules()
  {
    $locale = app()->getLocale();
    return InventoryState::rules($locale);
  }
}
