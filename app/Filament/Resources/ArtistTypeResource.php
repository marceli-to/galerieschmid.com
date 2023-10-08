<?php
namespace App\Filament\Resources;
use App\Filament\Resources\ArtistTypeResource\Pages;
use App\Filament\Resources\ArtistTypeResource\RelationManagers;
use App\Models\ArtistType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArtistTypeResource extends Resource
{
  protected static ?string $model = ArtistType::class;

  protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

  protected static ?string $navigationLabel = 'Künstlertyp';

  protected static ?string $modelLabel = 'Künstlertyp';
  
  protected static ?string $pluralModelLabel = 'Künstlertypen';

  protected static ?string $navigationGroup = 'Settings';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Section::make('Deutsch')
        ->collapsible()
        ->schema([
          Forms\Components\TextInput::make('description_de')
            ->label('Beschreibung')
            ->required()
            ->maxLength(255),
        ]),
        Section::make('Englisch')
        ->collapsible()
        ->collapsed()
        ->schema([
          Forms\Components\TextInput::make('description_en')
            ->label('Beschreibung')
            ->maxLength(255),
        ]),
      ]);
  }


  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('description_de')
        ->label('Description')
        ->searchable()
        ->sortable(),
      ])
      ->filters([
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ])->defaultSort('description_de', 'asc');
  }
  
  public static function getRelations(): array
  {
    return [
    ];
  }
  
  public static function getPages(): array
  {
    return [
      'index' => Pages\ListArtistTypes::route('/'),
      'create' => Pages\CreateArtistType::route('/create'),
      'edit' => Pages\EditArtistType::route('/{record}/edit'),
    ];
  }
  
}
