<?php
namespace App\Filament\Resources\ClientResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddressRelationManager extends RelationManager
{
  protected static string $relationship = 'addresses';

  protected static string $tabLabel = 'Adresse';

  protected static ?string $modelLabel = 'Adresse';
  
  protected static ?string $pluralModelLabel = 'Adressen';

  public function form(Form $form): Form
  {
    return $form
      ->schema([

        Grid::make()
        ->schema([
          Toggle::make('primary')
          ->label('Primäre Adresse?')
          ->columnSpan('full'),
          TextArea::make('address')
          ->label('Adresse')
          ->columnSpan(6),
          TextArea::make('address_additional')
          ->label('Adresszusatz')
          ->columnSpan(6),
        ])->columns(12),

        Grid::make()
        ->schema([
          TextInput::make('street')
          ->label('Strasse, Nr.')
          ->maxLength(50)
          ->columnSpan(6),
          TextInput::make('box')
          ->label('Postfach')
          ->maxLength(50)
          ->columnSpan(6),
          TextInput::make('zip')
          ->label('PLZ')
          ->maxLength(50)
          ->columnSpan(6),
          TextInput::make('city')
          ->label('Ort')
          ->maxLength(255)
          ->columnSpan(6),
          TextInput::make('state')
          ->label('State')
          ->maxLength(255)
          ->columnSpan(6),
          TextInput::make('country')
          ->label('Land')
          ->maxLength(255)
          ->columnSpan(6),
        ])->columns(12),
        Grid::make()
        ->schema([
          TextInput::make('phone')
          ->label('Telefon')
          ->tel()
          ->prefixIcon('heroicon-m-phone')
          ->columnSpan(6),
          TextInput::make('phone_business')
          ->label('Telefon G.')
          ->tel()
          ->prefixIcon('heroicon-m-phone')
          ->columnSpan(6),
          TextInput::make('fax')
          ->label('Fax')
          ->tel()
          ->prefixIcon('heroicon-m-table-cells')
          ->columnSpan(6),
        ])->columns(12),
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->heading('Adressen')
      ->columns([
        IconColumn::make('primary')
        ->label('Primär')
        ->boolean(),
        TextColumn::make('address')->label('Adresse'),
        TextColumn::make('street')->label('Strasse/Nr.'),
        TextColumn::make('zip')->label('PLZ'),
        TextColumn::make('city')->label('Ort'),
      ])
      ->filters([
      ])
      ->headerActions([
        Tables\Actions\CreateAction::make('create')
        ->modalWidth('3xl')
        ->mutateFormDataUsing(function (array $data): array {
          $data['user_id'] = auth()->id();
          return $data;
        }),
      ])
      ->actions([
        Tables\Actions\EditAction::make('edit')
        ->modalWidth('3xl')
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
