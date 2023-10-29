<?php
namespace App\Filament\Resources\ArtistResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
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
      ->recordTitle(fn ($record): string => "{$record->description_de} ({$record->inventory_number})")
      ->columns([
        SpatieMediaLibraryImageColumn::make('artwork.image')
        ->label('Bild')
        ->height(40)
        ->collection('artwork_images')
        ->circular()
        ->conversion('preview'),
        TextColumn::make('description_de')
        ->label('Beschreibung'),
        TextColumn::make('inventory_number')
        ->label('Inventar Nr.'),
        TextColumn::make('inventoryState.description_de')
        ->label('Bestandesstatus')
        ->badge()
        ->color('tertiary')
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
        TextColumn::make('position')
        ->label('Position'),
      ])
      ->reorderable('position')
      ->defaultSort('position', 'ASC')
      ->filters([
        SelectFilter::make('artwork_state_id')
        ->label('Objektstatus')
        ->relationship('artworkState', 'description_de', fn (Builder $query) => $query->withTrashed()),
        SelectFilter::make('inventory_state_id')
        ->label('Bestandesstatus')
        ->relationship('inventoryState', 'description_de', fn (Builder $query) => $query->withTrashed()),
      ])
      ->headerActions([

      ])
      ->actions([
        // Tables\Actions\EditAction::make('edit')->label('Bearbeiten'),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
          Tables\Actions\BulkAction::make('exportArtistsToPdf')
          ->action(function ($records, array $data) {
            return response()->streamDownload(function () use ($records) {
              echo \Pdf::loadHtml(
                \Blade::render('pdf.artwork-label', ['records' => $records])
              )->stream();
            }, 'galerieschmid-etiketten-'. \Str::slug($records[0]->artist->fullname).'-'. date('d-m-Y-H-i-s', time()) .'.pdf');
          })
          ->label('Etiketten erstellen')
          ->icon('heroicon-o-document-arrow-down')
          ->color('warning')
          ->deselectRecordsAfterCompletion(),   
        ]),
      ]);
  }
}
