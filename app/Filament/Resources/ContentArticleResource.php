<?php
namespace App\Filament\Resources;
use App\Filament\Resources\ContentArticleResource\Pages;
use App\Filament\Resources\ContentArticleResource\RelationManagers;
use App\Models\ContentArticle;
use Filament\Resources\Resource;
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
use Filament\Forms\Components\KeyValue;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContentArticleResource extends Resource
{
  protected static ?string $model = ContentArticle::class;

  protected static ?string $navigationIcon = 'heroicon-o-document-text';

  protected static ?string $navigationGroup = 'Seiteninhalt';

  protected static ?string $navigationLabel = 'Texte';

  protected static ?string $modelLabel = 'Text';

  protected static ?string $pluralModelLabel = 'Texte';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Grid::make('Inhalt')
        ->columns(12)
        ->schema([

          Section::make('Deutsch')
          ->columnSpan('full')
          ->collapsible()
          ->schema([
            
            TextInput::make('title_de')
              ->label('Titel')
              ->columnSpan('full')
              ->maxLength(255),
            
            RichEditor::make('text_de')
              ->label('Inhalt')
              ->toolbarButtons([
                'h2',
                'bold',
                'bulletList',
                'link',
                'table'
            ]),
        ]),

        Section::make('Englisch')
        ->columnSpan('full')
        ->collapsible()
        ->collapsed()
        ->schema([
        
          TextInput::make('title_en')
            ->label('Titel')
            ->columnSpan('full')
            ->maxLength(255),

          RichEditor::make('text_en')
            ->label('Inhalt')
            ->toolbarButtons([
              'h2',
              'bold',
              'bulletList',
              'link',
            ]),
          ])
        ]),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('title_de')->label('Titel')
      ])
      ->filters([
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
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
      'index' => Pages\ListContentArticles::route('/'),
      'create' => Pages\CreateContentArticle::route('/create'),
      'edit' => Pages\EditContentArticle::route('/{record}/edit'),
    ];
  }    
}
