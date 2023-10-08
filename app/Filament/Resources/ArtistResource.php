<?php
namespace App\Filament\Resources;
use App\Filament\Resources\ArtistResource\Pages;
use App\Filament\Resources\ArtistResource\RelationManagers;
use App\Models\Artist;
use App\Models\ArtistType;
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
use Filament\Notifications\Notification; 

class ArtistResource extends Resource
{
  protected static ?string $model = Artist::class;

  protected static ?string $navigationIcon = 'heroicon-o-user';

  protected static ?string $navigationLabel = 'Künstler';

  protected static ?string $modelLabel = 'Künstler';

  protected static ?string $pluralModelLabel = 'Künstler';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Grid::make()->schema([

          Section::make('Data')
          ->schema([

            Select::make('artist_type_id')
            ->label('Status')
            ->required()
            ->options(ArtistType::all()->pluck('description_de', 'id')),

            TextInput::make('salutation')
            ->label('Salutation')
            ->columnSpan('full')
            ->maxLength(255),

            TextInput::make('firstname')
            ->label('Firstname')
            ->columnSpan('full')
            ->maxLength(255),

            TextInput::make('lastname')
            ->label('Lastname')
            ->columnSpan('full')
            ->required()
            ->maxLength(255),

            TextInput::make('email')
            ->label('E-Mail')
            ->columnSpan('full')
            ->email()
            ->prefixIcon('heroicon-m-at-symbol'),

            TextInput::make('mobile')
            ->label('Mobile')
            ->columnSpan('full')
            ->tel()
            ->prefixIcon('heroicon-m-device-phone-mobile'),

            TextInput::make('website')
            ->label('Website')
            ->columnSpan('full')
            ->url()
            ->prefixIcon('heroicon-m-globe-alt'),

            TextArea::make('bank_account')
            ->label('Bank Account')
            ->columnSpan('full')
            ->rows(3)
            ->maxLength(255),
          ])->columnSpan(7),

          Grid::make()->schema([

          Section::make('Settings')
            ->schema([
              Toggle::make('publish')
              ->columnSpan(6)
              ->label('Publizieren?'),
              Toggle::make('newsletter_subscriber')
              ->columnSpan(6)
              ->label('Newsletter?')
            ])->columns(12),

          Section::make('Portrait')
            ->collapsible()
            ->collapsed()
            ->schema([
              SpatieMediaLibraryFileUpload::make('image')
              ->collection('artist_portraits')
              ->label('Image')
              ->directory('artists')
              ->image()
              ->imageEditor()
              ->downloadable()
              ->helperText('Allowed types: JPG, PNG')
              ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, $get): string {
                return (string) str('galerieschmid-kuenstler-portrait-' . uniqid() . '.' . $file->extension());
              }),
            ]),

            Section::make('Biography')
            ->collapsible()
            ->collapsed()
            ->schema([
  
              RichEditor::make('biography_de')
              ->label('Deutsch')
              ->toolbarButtons([
                'h2',
                'bold',
                'bulletList',
                'link',
              ]),
  
              RichEditor::make('biography_en')
              ->label('Englisch')
              ->toolbarButtons([
                'h2',
                'bold',
                'bulletList',
                'link',
              ]),
          
              SpatieMediaLibraryFileUpload::make('biography_file')
              ->collection('artist_files')
              ->label('PDF')
              ->directory('artists')
              ->moveFiles()
              ->downloadable()
              ->acceptedFileTypes(['application/pdf'])
              ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, $get): string {
                return (string) str('galerieschmid-kuenstler-bio-' . uniqid() . '.' . $file->extension());
              })
              ->helperText('Allowed types: PDF')
  
            ]),

          ])->columnSpan(5)->columns(12),

        ])->columns(12)
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        SpatieMediaLibraryImageColumn::make('image')
        ->label('Portrait')
        ->height(40)
        ->collection('artist_portraits')
        ->circular()
        ->conversion('preview'),
        TextColumn::make('firstname')
        ->label('Firstname')
        ->searchable()
        ->sortable(),
        TextColumn::make('lastname')
        ->label('Lastname')
        ->searchable()
        ->sortable(),
        TextColumn::make('email')
        ->label('E-Mail')
        ->searchable()
        ->sortable(),
        IconColumn::make('publish')
        ->sortable()
        ->boolean(),
      ])
      ->filters([
        Filter::make('publish')
          ->label('Publiziert')
          ->toggle()
          ->query(fn (Builder $query): Builder => $query->where('publish', true)),
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
          BulkAction::make('exportArtistsToPdf')
            ->action(function ($records, array $data) {
              // foreach ($records as $record)
              // {
              //   $record->artist_type_id = $data['artist_type_id'];
              //   $record->save();
              // }
              // Notification::make() 
              // ->title('Saved successfully')
              // ->success()
              // ->send();
              return response()->streamDownload(function () use ($records) {
                echo \Pdf::loadHtml(
                  \Blade::render('pdf.artwork-label', ['records' => $records])
                )->stream();
              }, 'galerieschmid-kuenstler.pdf');
            })
          // ->form([
          //     Forms\Components\Select::make('artist_type_id')
          //       ->label('Type')
          //       ->options(ArtistType::query()->pluck('description', 'id'))
          //       ->required(),
          // ])
            ->label('Künstler exportieren')
            ->icon('heroicon-o-document-arrow-down')
            ->color('warning')
            ->deselectRecordsAfterCompletion()
        ]),
      ]);
  }
  
  public static function getRelations(): array
  {
    return [
      RelationManagers\AddressRelationManager::class,
      RelationManagers\PublicationsRelationManager::class,
    ];
  }
  
  public static function getPages(): array
  {
    return [
      'index' => Pages\ListArtists::route('/'),
      'create' => Pages\CreateArtist::route('/create'),
      'edit' => Pages\EditArtist::route('/{record}/edit'),
    ];
  }    
}
