<?php
namespace App\Filament\Resources;
use App\Filament\Resources\ArtworkResource\Pages;
use App\Filament\Resources\ArtworkResource\RelationManagers;
use App\Models\Artwork;
use App\Models\ArtworkState;
use App\Models\ArtworkTechnique;
use App\Models\ArtworkFrame;
use App\Models\InventoryState;
use App\Models\Artist;
use App\Models\ArtistType;
use App\Models\Client;
use App\Models\VatType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
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
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification; 

class ArtworkResource extends Resource
{
  protected static ?string $model = Artwork::class;

  protected static ?string $navigationIcon = 'heroicon-o-photo';

  protected static ?string $navigationLabel = 'Kunstobjekte';

  protected static ?string $modelLabel = 'Kunstobjekt';

  protected static ?string $pluralModelLabel = 'Kunstobjekte';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Grid::make()->schema([
          Section::make('Objektdaten')
          ->schema([

            TextInput::make('description_de')
            ->label('Titel')
            ->columnSpan('full'),
            TextInput::make('description_en')
            ->label('Titel (EN)')
            ->columnSpan('full'),
            SpatieMediaLibraryFileUpload::make('image')
            ->label('Bild')
            ->collection('artwork_images')
            ->image()
            ->imageEditor()
            ->downloadable()
            ->multiple()
            ->reorderable()
            ->helperText('Erlaubte Dateitypen: JPG, PNG')
            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, $get): string {
              $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
              $name = $fileName . '-' . uniqid() . '.' . $file->extension();
              return (string) str($name);
            }),
            Textarea::make('info')
            ->label('Kurztext')
            ->columnSpan('full')
            ->rows(3),
            Textarea::make('info_arttrade')
            ->label('Text Kunsthandel')
            ->columnSpan('full')
            ->rows(3),
            TextInput::make('inventory_number')
            ->label('Inventar Nr.')
            ->columnSpan('full'),
            TextInput::make('year')
            ->label('Jahr')
            ->mask('9999')
            ->placeholder('1970'),
            Grid::make('Dimensionen')
            ->schema([
              TextInput::make('height')
              ->hint('cm')
              ->label('Höhe')
              ->columnSpan(6),
              TextInput::make('width')
              ->hint('cm')
              ->label('Breite')
              ->columnSpan(6),
              TextInput::make('depth')
              ->hint('cm')
              ->label('Tiefe')
              ->columnSpan(6),
              TextInput::make('diameter')
              ->hint('cm')
              ->label('Durchmesser')
              ->columnSpan(6),
            ])->columns(12),
            Select::make('artist_id')
            ->label('Künstler')
            ->options(Artist::all()->sortBy('artist_name')->pluck('artist_name', 'id'))
            ->columnSpan('full')
            ->searchable()
            ->selectablePlaceholder(false),
            TextInput::make('artist_inventory_number')
            ->label('Künstler Inventar Nr.')
            ->columnSpan('full'),
            TextInput::make('litho_number')
            ->label('Lithonummer')
            ->columnSpan('full'),
            Select::make('artwork_technique_id')
            ->label('Technik')
            ->options(ArtworkTechnique::all()->sortBy('description_de')->pluck('description_de', 'id'))
            ->columnSpan('full')
            ->searchable()
            ->selectablePlaceholder(false),
            Select::make('artwork_frame_id')
            ->label('Rahmen')
            ->options(ArtworkFrame::all()->sortBy('description_de')->pluck('description_de', 'id'))
            ->columnSpan('full')
            ->searchable()
            ->selectablePlaceholder(false),
            TextInput::make('location')
            ->label('Standort')
            ->columnSpan('full'),
            Select::make('client_id')
            ->label('Besitzer')
            ->options(Client::all()->sortBy('fullname')->pluck('fullname', 'id'))
            ->columnSpan('full')
            ->searchable(),
            Select::make('previous_client')
            ->label('Eigentümer')
            ->options(Client::all()->sortBy('fullname')->pluck('fullname', 'fullname'))
            ->columnSpan('full')
            ->searchable(),

          ])->columnSpan(7),

          Grid::make()
          ->schema([
            Section::make('Einstellungen')
            ->collapsible()
            ->schema([
              Select::make('artworkState')
              ->label('Status')
              ->options(ArtworkState::all()->sortBy('description_de')->pluck('description_de', 'id'))
              ->columnSpan('full')
              ->selectablePlaceholder(false),
              Select::make('inventoryState')
              ->label('Bestandesstatus')
              ->options(InventoryState::all()->sortBy('description_de')->pluck('description_de', 'id'))
              ->columnSpan('full')
              ->selectablePlaceholder(false),
            ]),

            Section::make('Preise')
            ->collapsible()
            ->schema([
              TextInput::make('purchase_price_soll')
              ->label('Einkaufspreis Soll'),
              TextInput::make('purchase_price_ist')
              ->label('Einkaufspreis Ist'),
              TextInput::make('purchase_price_frame')
              ->label('Einkaufspreis Rahmen'),
              TextInput::make('sale_price_soll')
              ->label('Verkaufspreis Soll'),
              Toggle::make('show_exact_price')
              ->label('Exakter Preis anzeigen')
              ->inline(false),
              TextInput::make('sale_price_internal')
              ->label('Verkaufspreis Intern'),
              TextInput::make('sale_price_ist')
              ->label('Verkaufspreis Ist'),
              TextInput::make('sale_price_frame')
              ->label('Verkaufspreis Rahmen'),
              // vat
              Select::make('vat_type_id')
              ->label('MwSt.')
              ->options(VatType::all()->sortByDesc('description_de')->pluck('description_de', 'id'))
              ->columnSpan('full'),
              
              TextInput::make('discount')
              ->label('Rabatt')
              ->columnSpan('full'),
            ]),

            Section::make('Historie')
            ->collapsible()
            ->schema([
              DatePicker::make('date_in')
              ->label('Datum Eingang')
              ->native(false)
              ->closeOnDateSelection()
              ->displayFormat('d.m.Y'),
              DatePicker::make('date_out')
              ->label('Datum Ausgang')
              ->native(false)
              ->closeOnDateSelection()
              ->displayFormat('d.m.Y'),
              DatePicker::make('date_sold')
              ->label('Datum Verkauft')
              ->native(false)
              ->closeOnDateSelection()
              ->displayFormat('d.m.Y'),
              DatePicker::make('date_billed')
              ->label('Datum Abgerechnet')
              ->native(false)
              ->closeOnDateSelection()
              ->displayFormat('d.m.Y'),
            ]),

          ])->columnSpan(5),
          
        ])->columns(12)
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
    ->striped()
    ->defaultSort('updated_at', 'DESC')
    ->columns([
      SpatieMediaLibraryImageColumn::make('image')
      ->label('Bild')
      ->height(40)
      ->collection('artwork_images')
      ->circular()
      ->conversion('preview'),

      TextColumn::make('description_de')
      ->label('Beschreibung')
      ->searchable()
      ->sortable(),

      TextColumn::make('artist.artist_name')
      ->label('Künstler')
      ->searchable()
      ->sortable(),

      TextColumn::make('inventory_number')
      ->label('Inventar Nr.')
      ->searchable()
      ->sortable(),

      TextColumn::make('sale_price_internal')
      ->label('VK Intern')
      ->searchable()
      ->sortable(),

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
    ])
    ->filters([
      SelectFilter::make('artist_id')
      ->label('Künstler')
      ->relationship('artist', 'artist_name', fn (Builder $query) => $query->withTrashed()),
      SelectFilter::make('artwork_state_id')
      ->label('Objektstatus')
      ->relationship('artworkState', 'description_de', fn (Builder $query) => $query->withTrashed()),
      SelectFilter::make('inventory_state_id')
      ->label('Bestandesstatus')
      ->relationship('inventoryState', 'description_de', fn (Builder $query) => $query->withTrashed()),
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
        BulkAction::make('changeArtworkFields')
        ->action(function ($records, array $data) {
          foreach ($records as $record) {
            if (isset($data['location'])) {
              $record->location = $data['location'];
            }
            if (isset($data['inventory_state_id'])) {
              $record->inventory_state_id = $data['inventory_state_id'];
            }
            if (isset($data['date_in'])) {
              $record->date_in = $data['date_in'];
            }
            if (isset($data['date_out'])) {
              $record->date_out = $data['date_out'];
            }
            if (isset($data['date_billed'])) {
              $record->date_billed = $data['date_billed'];
            }
            $record->save();
          }
          Notification::make() 
            ->title('Änderungen gespeichert')
            ->success()
            ->send();
        })
        ->form([
            TextInput::make('location')
              ->label('Standort'),
            Select::make('inventory_state_id')
              ->label('Bestandesstatus')
              ->options(InventoryState::query()->pluck('description_de', 'id')),
            DatePicker::make('date_in')
              ->label('Datum Eingang')
              ->native(false)
              ->closeOnDateSelection()
              ->displayFormat('d.m.Y'),
            DatePicker::make('date_out')
              ->label('Datum Ausgang')
              ->native(false)
              ->closeOnDateSelection()
              ->displayFormat('d.m.Y'),
            DatePicker::make('date_billed')
              ->label('Datum Abgerechnet')
              ->native(false)
              ->closeOnDateSelection()
              ->displayFormat('d.m.Y'),
        ])
        ->label('Ausgewählte mutieren')
        ->icon('heroicon-o-pencil-square')
        ->deselectRecordsAfterCompletion()
        ->modalWidth('lg'),

        BulkAction::make('exportArtistsToPdf')
        ->action(function ($records, array $data) {
          return response()->streamDownload(function () use ($records) {
            echo \Pdf::loadHtml(
              \Blade::render('pdf.artwork-label', ['records' => $records])
            )->stream();
          }, 'galerieschmid-etiketten-'. date('d-m-Y-H-i-s', time()) .'.pdf');
        })
        ->label('Etiketten erstellen')
        ->icon('heroicon-o-document-arrow-down')
        ->color('warning')
        ->deselectRecordsAfterCompletion(),        


      ]),
    ]);
  }
    
  public static function getRelations(): array
  {
    return [
      RelationManagers\AttributesRelationManager::class,
      RelationManagers\AdditionalFieldRelationManager::class,
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
