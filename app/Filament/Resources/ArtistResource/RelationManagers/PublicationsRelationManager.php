<?php
namespace App\Filament\Resources\ArtistResource\RelationManagers;
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
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PublicationsRelationManager extends RelationManager
{
  protected static string $relationship = 'publications';

  protected static ?string $modelLabel = 'Publikation';

  protected static ?string $pluralModelLabel = 'Publikationen';

  public function form(Form $form): Form
  {
    return $form
      ->schema([

        Tabs::make('Label')
        ->tabs([
          Tabs\Tab::make('Deutsch')
            ->columnSpan('full')
            ->schema([

              Forms\Components\TextInput::make('title_de')
              ->label('Titel')
              ->required()
              ->maxLength(255),
              
              RichEditor::make('text_de')
              ->label('Text')
              ->toolbarButtons([
                'h2',
                'bold',
                'bulletList',
                'link',
              ])
          ]),

          Tabs\Tab::make('Englisch')
            ->columnSpan('full')
            ->schema([
            
              Forms\Components\TextInput::make('title_en')
              ->label('Titel')
              ->maxLength(255),
              
              RichEditor::make('text_en')
              ->label('Text')
              ->toolbarButtons([
                'h2',
                'bold',
                'bulletList',
                'link',
              ])
          ]),
        ])
        ->columnSpan('full'),

        SpatieMediaLibraryFileUpload::make('image')
        ->collection('artist_publications')
        ->label('Bild')
        ->image()
        ->imageEditor()
        ->downloadable()
        ->helperText('Erlaubte Dateitypen: JPG, PNG')
        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, $get): string {
          return (string) str('galerieschmid-kuenstler-publikation-' . uniqid() . '.' . $file->extension());
        })
        ->columnSpan('full'),
          
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->heading('Publikationen')
      ->columns([
        SpatieMediaLibraryImageColumn::make('image')
        ->label('Bild')
        ->height(40)
        ->collection('artist_publications')
        ->circular()
        ->conversion('preview'),
        Tables\Columns\TextColumn::make('title_de')
        ->label('Titel'),
        Tables\Columns\TextColumn::make('text_de')
        ->label('Text'),
      ])
      ->filters([
      ])
      ->headerActions([
        Tables\Actions\CreateAction::make('create')
          ->modalWidth('2xl')
          ->mutateFormDataUsing(function (array $data): array {
            $data['user_id'] = auth()->id();
            return $data;
        }),
      ])
      ->actions([
        Tables\Actions\EditAction::make('edit')
          ->modalWidth('2xl')
          ->mutateRecordDataUsing(function (array $data): array {
            $data['user_id'] = auth()->id();
            return $data;
        }),
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ]);
  }
}
