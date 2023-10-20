<?php
namespace App\Filament\Resources;
use App\Filament\Resources\NewsletterLanguageResource\Pages;
use App\Filament\Resources\NewsletterLanguageResource\RelationManagers;
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

class NewsletterLanguageResource extends Resource
{
  protected static ?string $model = NewsletterLanguage::class;

  protected static ?string $navigationIcon = 'heroicon-o-language';

  protected static ?string $navigationGroup = 'Newsletter';

  protected static ?string $navigationLabel = 'Sprachen';

  protected static ?string $modelLabel = 'Sprache';

  protected static ?string $pluralModelLabel = 'Sprachen';

  protected static ?int $navigationSort = 2;

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Grid::make('Sprache')
        ->columns(12)
        ->schema([
          Section::make('Daten')
          ->schema([
            TextInput::make('acronym')
            ->label('Abkürzung')
            ->required()
            ->maxLength(3),
            TextInput::make('description')
            ->label('Beschreibung')
            ->required()
            ->maxLength(255),
          ])
          ->columnSpan(7)
        ])
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('acronym')
          ->label('Abkürzung')
          ->searchable()
          ->sortable(),
        TextColumn::make('description')
          ->label('Beschreibung')
          ->searchable()
          ->sortable()
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
  
  public static function getPages(): array
  {
    return [
      'index' => Pages\ListNewsletterLanguages::route('/'),
      'create' => Pages\CreateNewsletterLanguage::route('/create'),
      'edit' => Pages\EditNewsletterLanguage::route('/{record}/edit'),
    ];
  }    
}
