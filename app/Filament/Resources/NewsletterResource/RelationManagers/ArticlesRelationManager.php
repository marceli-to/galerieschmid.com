<?php
namespace App\Filament\Resources\NewsletterResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticlesRelationManager extends RelationManager
{
  protected static string $relationship = 'articles';

  protected static ?string $modelLabel = 'Artikel';

  protected static ?string $pluralModelLabel = 'Artikel';

  public function form(Form $form): Form
  {
    return $form
      ->schema([
          TextInput::make('title')
            ->label('Titel')
            ->required()
            ->maxLength(255)
            ->columnSpan('full'),
          RichEditor::make('text')
            ->label('Inhalt')
            ->toolbarButtons([
              'bold',
              'bulletList',
              'link',
            ])
            ->columnSpan('full'),
          SpatieMediaLibraryFileUpload::make('image')
            ->collection('newsletter_articles')
            ->label('Bild')
            ->image()
            ->imageEditor()
            ->downloadable()
            ->columnSpan('full')
            ->helperText('Erlaubte Dateitypen: JPG, PNG')
            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, $get): string {
              return (string) str('galerieschmid-newsletter-' . uniqid() . '.' . $file->extension());
            }),
          TextInput::make('position')
            ->label('Position')
            ->maxLength(255)
            ->columnSpan('full'),
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->heading('Artikel')
      ->recordTitleAttribute('title')
      ->columns([
        SpatieMediaLibraryImageColumn::make('image')
        ->label('Bild')
        ->height(40)
        ->collection('newsletter_articles')
        ->circular()
        ->conversion('preview'),
        TextColumn::make('title')
          ->label('Titel'),
        TextColumn::make('text')
          ->label('Text')
          ->words(10)
          ->html(),
        TextColumn::make('position')
          ->label('Position'),
      ])
      ->reorderable('position')
      ->defaultSort('position', 'ASC')
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
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ]);
  }
}
