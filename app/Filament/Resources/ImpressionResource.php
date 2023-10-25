<?php
namespace App\Filament\Resources;
use App\Filament\Resources\ImpressionResource\Pages;
use App\Filament\Resources\ImpressionResource\RelationManagers;
use App\Models\Impression;
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
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
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

class ImpressionResource extends Resource
{
  protected static ?string $model = Impression::class;

  protected static ?string $navigationIcon = 'heroicon-o-photo';

  protected static ?string $navigationGroup = 'Seiteninhalt';

  protected static ?string $navigationLabel = 'Impressionen';

  protected static ?string $modelLabel = 'Bild';

  protected static ?string $pluralModelLabel = 'Impressionen';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Grid::make()->schema([

          Section::make('Bild')
          ->schema([
            SpatieMediaLibraryFileUpload::make('image')
            ->collection('impressions')
            ->label('Bildupload')
            ->image()
            ->imageEditor()
            ->downloadable()
            ->helperText('Erlaubte Dateitypen: JPG, PNG')
            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, $get): string {
              return (string) str('galerieschmid-impression-' . uniqid() . '.' . $file->extension());
            }),
            TextInput::make('title')
            ->label('Titel'),
            TextInput::make('position')
            ->label('Position')
            ->numeric(),
          ])->columnSpan(7),

          Section::make('Einstellungen')
          ->schema([
            Toggle::make('publish')
            ->columnSpan(6)
            ->label('Publizieren?'),
          ])->columnSpan(5),


        ])->columns(12)
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->striped()
      ->reorderable('position')
      ->defaultSort('position', 'ASC')
      ->columns([
        SpatieMediaLibraryImageColumn::make('image')
        ->label('Bild')
        ->height(40)
        ->collection('impressions')
        ->circular()
        ->conversion('preview'),
        TextColumn::make('position')
        ->label('Position')
        ->sortable(),
        TextColumn::make('title')
        ->label('Beschreibung')
        ->searchable()
        ->sortable(),
        IconColumn::make('publish')
        ->label('Publiziert')
        ->boolean(),
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
      'index' => Pages\ListImpressions::route('/'),
      'create' => Pages\CreateImpression::route('/create'),
      'edit' => Pages\EditImpression::route('/{record}/edit'),
    ];
  }    
}
