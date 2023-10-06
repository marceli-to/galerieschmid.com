<?php
namespace App\Filament\Resources;
use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use App\Enums\Gallery;
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
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientResource extends Resource
{
  protected static ?string $model = Client::class;

  protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

  protected static ?string $navigationLabel = 'Kunden';

  protected static ?string $modelLabel = 'Kunde';

  protected static ?string $pluralModelLabel = 'Kunden';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Grid::make()->schema([

          Section::make('Data')
          ->schema([

            TextInput::make('salutation')
            ->label('Salutation')
            ->columnSpan('full')
            ->maxLength(100),

            TextInput::make('firstname')
            ->label('Firstname')
            ->columnSpan('full')
            ->maxLength(255),

            TextInput::make('lastname')
            ->label('Lastname')
            ->columnSpan('full')
            ->required()
            ->maxLength(255),

            TextInput::make('alfa')
            ->label('ALFA')
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

          ])->columnSpan(7),

          Grid::make()->schema([

            Section::make('Settings')
              ->schema([
                
                Toggle::make('publish')
                ->columnSpan(6)
                ->label('Publizieren?'),
                
                Toggle::make('newsletter_subscriber')
                ->columnSpan(6)
                ->label('Newsletter?'),

                Select::make('gallery')
                ->label('Gallery')
                ->options(Gallery::class)
                ->columnSpan('full')
                ->selectablePlaceholder(false),

                TextInput::make('language')
                ->label('Language')
                ->columnSpan('full')
                ->maxLength(255),

                TextArea::make('letter_salutation')
                ->label('Letter salutation')
                ->columnSpan('full')
                ->rows(3),

                TextInput::make('invitations')
                ->label('Invitations')
                ->columnSpan('full')
                ->maxLength(255),

                TextArea::make('remarks')
                ->label('Remarks')
                ->columnSpan('full')
                ->rows(3)

              ])->columns(12),

            ])->columnSpan(5)->columns(12),

            Section::make('Artists')
            ->collapsible()
            ->collapsed()
            ->schema([
              TextArea::make('artists')
              ->label('List of artists')
              ->columnSpan('full')
              ->rows(3),
            ])->columnSpan(7),

          ])->columns(12)
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
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
        TextColumn::make('gallery')
        ->badge(),
        IconColumn::make('publish')
        ->sortable()
        ->boolean(),
      ])
      ->filters([
        Filter::make('gap')->label('GAP')->query(fn (Builder $query): Builder => $query->where('gallery', '=', 'gap')),
        Filter::make('eule')->label('Eule')->query(fn (Builder $query): Builder => $query->where('gallery', '=', 'eule')),
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
      RelationManagers\AddressRelationManager::class,
      RelationManagers\AdditionalFieldRelationManager::class,
    ];
  }
  
  public static function getPages(): array
  {
    return [
      'index' => Pages\ListClients::route('/'),
      'create' => Pages\CreateClient::route('/create'),
      'edit' => Pages\EditClient::route('/{record}/edit'),
    ];
  }    
}
