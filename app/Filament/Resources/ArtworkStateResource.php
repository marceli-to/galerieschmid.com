<?php
namespace App\Filament\Resources;
use App\Filament\Resources\ArtworkStateResource\Pages;
use App\Filament\Resources\ArtworkStateResource\RelationManagers;
use App\Models\ArtworkState;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Concerns\Translatable;

class ArtworkStateResource extends Resource
{
  use Translatable;

  protected static ?string $model = ArtworkState::class;

  protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

  protected static ?string $navigationLabel = 'Objektstatus';

  protected static ?string $modelLabel = 'Objektstatus';
  
  protected static ?string $pluralModelLabel = 'Objektstatus';

  protected static ?string $navigationGroup = 'Settings';

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
      ]);
  }
  
  public static function getRelations(): array
  {
    return [
    ];
  }
  
  public static function getPages(): array
  {
    return [
      'index' => Pages\ListArtworkStates::route('/'),
      'create' => Pages\CreateArtworkState::route('/create'),
      'edit' => Pages\EditArtworkState::route('/{record}/edit'),
    ];
  }
  
  public function validationRules()
  {
    $locale = app()->getLocale();
    return ArtworkFrame::rules($locale);
  }
}
