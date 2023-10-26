<?php
namespace App\Filament\Resources;
use App\Filament\Resources\NewsletterSubscriberResource\Pages;
use App\Models\NewsletterSubscriber;
use App\Models\NewsletterLanguage;
use App\Models\NewsletterList;
use App\Enums\Salutation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\CheckboxList;
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

class NewsletterSubscriberResource extends Resource
{
  protected static ?string $model = NewsletterSubscriber::class;

  protected static ?string $navigationIcon = 'heroicon-o-user-group';

  protected static ?string $navigationGroup = 'Newsletter';

  protected static ?string $navigationLabel = 'Abonnenten';

  protected static ?string $modelLabel = 'Abonnent';

  protected static ?string $pluralModelLabel = 'Abonnenten';

  protected static ?int $navigationSort = 2;

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Grid::make()->schema([
          Section::make('Daten')
          ->schema([
            Select::make('salutation')
            ->label('Anrede')
            ->options(Salutation::class)
            ->columnSpan('full')
            ->required()
            ->selectablePlaceholder(false),
            TextInput::make('firstname')
              ->label('Vorname')
              ->required()
              ->columnSpan('full')
              ->maxLength(255),
            TextInput::make('lastname')
              ->label('Name')
              ->required()
              ->columnSpan('full')
              ->maxLength(255),
            TextInput::make('email')
              ->label('E-Mail')
              ->columnSpan('full')
              ->email()
              ->required()
              ->prefixIcon('heroicon-m-at-symbol')
              ->maxLength(255),
            Select::make('language_id')
              ->label('Sprache')
              ->required()
              ->options(NewsletterLanguage::all()->pluck('description', 'id')),
          ])->columnSpan(7),

          Group::make()->schema([
            // Section::make('Einstellungen')
            // ->schema([
            //   Grid::make()
            //   ->schema([
            //     Toggle::make('confirmed')
            //       ->columnSpan(6)
            //       ->label('Bestätigt?')
            //   ])->columns(12)
            // ]),
            Section::make('Listen')
              ->schema([
                CheckboxList::make('newsletterLists')
                  ->label('Zugewiesene Listen')
                  ->options(NewsletterList::all()->pluck('description', 'id'))
                  ->relationship('newsletterLists', 'description')
            ])
          ])->columnSpan(5)



        ])->columns(12)
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->defaultSort('lastname', 'asc')
      ->columns([
        // salutation
        TextColumn::make('salutation')
          ->label('Anrede'),

        // firstname
        TextColumn::make('firstname')
          ->label('Vorname')
          ->searchable()
          ->sortable(),
        
        // lastname
        TextColumn::make('lastname')
          ->label('Name')
          ->searchable()
          ->sortable(),
        
        // email
        TextColumn::make('email')
          ->label('E-Mail')
          ->searchable()
          ->sortable(),

        // created_at (date format: d.m.Y H:i:s)
        TextColumn::make('created_at')
          ->label('Anmeldung am')
          ->date('d.m.Y H:i:s')
          ->searchable()
          ->sortable(),
      ])
      ->filters([
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
      'index' => Pages\ListNewsletterSubscribers::route('/'),
      'create' => Pages\CreateNewsletterSubscriber::route('/create'),
      'edit' => Pages\EditNewsletterSubscriber::route('/{record}/edit'),
    ];
  }    
}
