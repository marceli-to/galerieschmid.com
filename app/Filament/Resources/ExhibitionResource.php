<?php
namespace App\Filament\Resources;
use App\Filament\Resources\ExhibitionResource\Pages;
use App\Filament\Resources\ExhibitionResource\RelationManagers;
use App\Models\Exhibition;
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
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExhibitionResource extends Resource
{
  protected static ?string $model = Exhibition::class;

  protected static ?string $navigationIcon = 'heroicon-o-film';

  protected static ?string $navigationLabel = 'Austellungen';

  protected static ?string $modelLabel = 'Austellung';

  protected static ?string $pluralModelLabel = 'Austellungen';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Grid::make()->schema([
          Section::make('Ausstellungsdaten')
          ->schema([
            Tabs::make('Ausstellungsdaten')
            ->tabs([
              Tabs\Tab::make('Deutsch')
              ->schema([
                TextInput::make('title_de')
                ->label('Titel / Künstler')
                ->required()
                ->columnSpan('full'),
                TextInput::make('subtitle_de')
                ->label('Subtitel / Thema')
                ->required()
                ->columnSpan('full'),
                TextArea::make('summary_de')
                ->label('Zusammenfassung')
                ->columnSpan('full')
                ->rows(3),
                RichEditor::make('text_de')
                ->label('Text')
                ->toolbarButtons([
                  'h2',
                  'bold',
                  'bulletList',
                  'link',
                ]),
                TextArea::make('keywords_de')
                ->label('Keywords')
                ->columnSpan('full')
                ->rows(3),
              ]),
              Tabs\Tab::make('English')
              ->schema([
                TextInput::make('title_en')
                ->label('Titel')
                ->columnSpan('full'),
              TextInput::make('subitle_en')
                ->label('Subtitel')
                ->columnSpan('full'),
              TextArea::make('summary_en')
                ->label('Zusammenfassung')
                ->columnSpan('full')
                ->rows(3),
                RichEditor::make('text_de')
                ->label('Text')
                ->toolbarButtons([
                  'h2',
                  'bold',
                  'bulletList',
                  'link',
                ]),
                TextArea::make('keywords_en')
                ->label('Keywords')
                ->columnSpan('full')
                ->rows(3),
              ]),
            ]),
          ])->columnSpan(7),

          Grid::make()
          ->schema([
            Section::make('Einstellungen')
            ->schema([
              Toggle::make('active')
              ->columnSpan(6)
              ->label('Aktiv'),
            ]),


            Section::make('Cover')
              ->collapsible()
              ->schema([
                SpatieMediaLibraryFileUpload::make('image')
                ->collection('exhibition_cover')
                ->label('Bild')
                ->image()
                ->imageEditor()
                ->downloadable()
                ->helperText('Erlaubte Dateitypen: JPG, PNG')
                ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, $get): string {
                  return (string) str('galerieschmid-ausstellung-cover-' . uniqid() . '.' . $file->extension());
                }),
              ]),


            Section::make('Daten')
            ->collapsible()
            ->schema([
              DatePicker::make('date_start')
              ->label('Start der Ausstellung')
              ->native(false)
              ->closeOnDateSelection()
              ->displayFormat('d.m.Y'),
              DatePicker::make('date_end')
              ->label('Ende der Ausstellung')
              ->native(false)
              ->closeOnDateSelection()
              ->displayFormat('d.m.Y'),
              DatePicker::make('date_show_from')
              ->label('Publizieren von')
              ->native(false)
              ->closeOnDateSelection()
              ->displayFormat('d.m.Y'),
              DatePicker::make('date_show_to')
              ->label('Publizieren bis')
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
        ->columns([
          TextColumn::make('id')
          ->label('ID')
          ->searchable(),
          TextColumn::make('subtitle_de')
          ->label('Subtitel / Thema')
          ->searchable(),
          TextColumn::make('title_de')
          ->label('Titel / Künstler')
          ->searchable(),
          TextColumn::make('date_start')
          ->label('Datum von')
          ->date('d.m.Y')
          ->searchable()
          ->sortable(),
          TextColumn::make('date_end')
          ->label('Datum bis')
          ->date('d.m.Y')
          ->searchable()
          ->sortable(),
        ])
        ->defaultSort('date_start', 'DESC')
        ->filters([
        ])
        ->actions([
          ActionGroup::make([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
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
      RelationManagers\ArtworksRelationManager::class,
    ];
  }
  
  public static function getPages(): array
  {
    return [
      'index' => Pages\ListExhibitions::route('/'),
      'create' => Pages\CreateExhibition::route('/create'),
      'edit' => Pages\EditExhibition::route('/{record}/edit'),
    ];
  }    
}
