<?php
namespace App\Filament\Resources\ExhibitionResource\RelationManagers;
use App\Models\Artwork;
use App\Models\Artist;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArtworksRelationManager extends RelationManager
{
  protected static string $relationship = 'artworks';

  protected static ?string $modelLabel = 'Kunstobjekt';

  protected static ?string $pluralModelLabel = 'Kunstobjekte';

  public function form(Form $form): Form
  {
    return $form
      ->schema([
          TextInput::make('position')
            ->label('Beschreibung')
            ->numeric()
            ->required(),
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->heading('Objekte')
      ->recordTitle(fn ($record): string => "{$record->description_de} ({$record->artist->artist_name}/{$record->inventory_number})")
      ->columns([
        SpatieMediaLibraryImageColumn::make('artwork.image')
        ->label('Bild')
        ->height(40)
        ->collection('artwork_images')
        ->circular()
        ->conversion('preview'),
        TextColumn::make('sort')
        ->sortable()
        ->label('Position'),
        TextColumn::make('description_de')
        ->label('Beschreibung'),
        TextColumn::make('artist.artist_name')
        ->label('Künstler'),
      ])
      ->reorderable('sort')
      ->defaultSort('sort', 'ASC')
      ->filters([
      ])
      ->headerActions([
        Tables\Actions\AttachAction::make('attach')
        ->form(fn (Tables\Actions\AttachAction $action): array => [
          Select::make('artist_id')
          ->label('Künstler')
          ->options(Artist::has('artworksActive')->get()->sortBy('fullname')->pluck('fullname', 'id'))
          ->required()
          ->reactive(),

          Select::make('recordId')
          ->label('Kunstobjekt')
          ->options(function(callable $get){
            return Artwork::get()
              ->where('artist_id',  $get('artist_id'))
              ->whereNotIn('artwork_state_id', [3, 4])
              ->sortBy('description_full')
              ->pluck('description_full','id');
          })
          ->required()
          ->reactive(),
          Forms\Components\TextInput::make('sort')->required(),
        ])
        ->recordSelectSearchColumns(['inventory_number', 'description_de', 'position'])
      ])
      ->actions([
        Tables\Actions\DetachAction::make('detach')->label('Entfernen'),
      ])
      ->bulkActions([
        // Tables\Actions\BulkActionGroup::make([
        //   Tables\Actions\DeleteBulkAction::make(),
        // ]),
      ]);
  }
}
