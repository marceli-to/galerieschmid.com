<?php
namespace App\Filament\Resources;
use App\Filament\Resources\ArtworkResource\Pages;
use App\Filament\Resources\ArtworkResource\RelationManagers;
use App\Models\Artwork;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArtworkResource extends Resource
{
  protected static ?string $model = Artwork::class;

  protected static ?string $navigationIcon = 'heroicon-o-photo';

  protected static ?string $navigationLabel = 'Objekte';

  protected static ?string $modelLabel = 'Objekt';

  protected static ?string $pluralModelLabel = 'Objekte';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
    ->columns([
      SpatieMediaLibraryImageColumn::make('image')
      ->label('Bild')
      ->height(40)
      ->collection('artwork_images')
      ->circular()
      ->conversion('preview'),
      
      TextColumn::make('artist.artist_name')
      ->label('Künstler')
      ->searchable()
      ->sortable(),

      TextColumn::make('description_de')
      ->label('Beschreibung')
      ->searchable()
      ->sortable(),

      TextColumn::make('inventoryState.description_de')
      ->label('Bestandesstatus')
      ->badge()
      ->searchable()
      ->sortable(),

      TextColumn::make('artworkState.description_de')
      ->label('Status')
      ->badge()
      ->color(static function ($state): string {
        if ($state === 'inaktiv') {
            return 'warning';
        }
        return 'success';
      })
      ->searchable()
      ->sortable(),
    ])
    ->filters([
      SelectFilter::make('artwork_state_id')
      ->label('Objektstatus')
      ->relationship('artworkState', 'description_de', fn (Builder $query) => $query->withTrashed())
    ])
    ->actions([
      ActionGroup::make([
        EditAction::make(),
        DeleteAction::make(),
      ]),
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
      'index' => Pages\ListArtworks::route('/'),
      'create' => Pages\CreateArtwork::route('/create'),
      'edit' => Pages\EditArtwork::route('/{record}/edit'),
    ];
  }    
}
