<?php
namespace App\Filament\Resources;
use App\Filament\Resources\NewsletterResource\Pages;
use App\Filament\Resources\NewsletterResource\RelationManagers;
use App\Models\Newsletter;
use App\Models\NewsletterLanguage;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewsletterResource extends Resource
{
  protected static ?string $model = Newsletter::class;

  protected static ?string $navigationIcon = 'heroicon-o-envelope-open';

  protected static ?string $navigationGroup = 'Newsletter';

  protected static ?string $navigationLabel = 'Newsletter';

  protected static ?string $modelLabel = 'Newsletter';

  protected static ?string $pluralModelLabel = 'Newsletter';

  protected static ?int $navigationSort = 1;

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Grid::make()->schema([
          Section::make('Newsletter')
          ->schema([
            Select::make('language_id')
            ->label('Sprache')
            ->required()
            ->options(NewsletterLanguage::all()->pluck('description', 'id')),
            TextInput::make('title')
            ->label('Titel / Betreff')
            ->required()
            ->columnSpan('full')
            ->maxLength(255),
          ])->columnSpan(7),

          Section::make('Einstellungen')
          ->schema([
            Grid::make()
            ->schema([
              Toggle::make('active')
              ->columnSpan(6)
              ->label('Aktiv?'),
              Toggle::make('show_in_archiv')
              ->columnSpan(6)
              ->label('im Archiv zeigen?')
            ])->columns(12)
          ])->columnSpan(5)

        ])->columns(12)
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('title')
        ->label('Titel/Betreff')
        ->searchable()
        ->sortable(),
        TextColumn::make('language.description')
        ->label('Sprache')
        ->sortable(),
        IconColumn::make('active')
        ->label('Aktiv')
        ->sortable()
        ->boolean(),
        TextColumn::make('created_at')
        ->label('Erstellt am')
        ->date('d.m.Y')
        ->sortable(),
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
      RelationManagers\ArticlesRelationManager::class,
    ];
  }
  
  public static function getPages(): array
  {
    return [
      'index' => Pages\ListNewsletters::route('/'),
      'create' => Pages\CreateNewsletter::route('/create'),
      'edit' => Pages\EditNewsletter::route('/{record}/edit'),
    ];
  }    
}
