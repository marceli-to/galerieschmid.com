<?php
namespace App\Filament\Resources;
use App\Filament\Resources\NewsletterListResource\Pages;
use App\Filament\Resources\NewsletterListResource\RelationManagers;
use App\Models\NewsletterList;
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
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewsletterListResource extends Resource
{
  protected static ?string $model = NewsletterList::class;

  protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

  protected static ?string $navigationGroup = 'Newsletter';

  protected static ?string $navigationLabel = 'Listen';

  protected static ?string $modelLabel = 'Liste';

  protected static ?string $pluralModelLabel = 'Listen';

  protected static ?int $navigationSort = 3;

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Section::make('Daten')
        ->schema([
          TextInput::make('description')
          ->label('Beschreibung')
          ->required()
          ->maxLength(255),
          Toggle::make('public')
          ->columnSpan(6)
          ->label('Öffentliche Liste'),
        ])
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('description')
          ->label('Beschreibung')
          ->searchable()
          ->sortable(),
          IconColumn::make('public')
          ->label('Öffentlich')
          ->boolean(),
        TextColumn::make('newsletterSubscribers')
          ->label('Abonnenten')
          ->badge()
          ->getStateUsing(fn ($record): string => $record->newsletterSubscribers()->count())

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
      RelationManagers\SubscribersRelationManager::class,

    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListNewsletterLists::route('/'),
      'create' => Pages\CreateNewsletterList::route('/create'),
      'edit' => Pages\EditNewsletterList::route('/{record}/edit'),
    ];
  }    
}
