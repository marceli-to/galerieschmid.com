<?php
namespace App\Filament\Resources\ArtistResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
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

  public function form(Form $form): Form
  {
    return $form
      ->schema([

        Grid::make()
        ->schema([
          TextArea::make('address')
          ->label('Address')
          ->columnSpan('full'),
          TextArea::make('address_additional')
          ->label('Additional address')
          ->columnSpan('full'),
        ])->columns(12),

        Grid::make()
        ->schema([
          TextInput::make('street')
          ->label('Street, No.')
          ->maxLength(50)
          ->columnSpan(6),
          TextInput::make('box')
          ->label('P.O. Box')
          ->maxLength(50)
          ->columnSpan(6),
          TextInput::make('zip')
          ->label('ZIP')
          ->maxLength(50)
          ->columnSpan(6),
          TextInput::make('city')
          ->label('City')
          ->maxLength(255)
          ->columnSpan(6),
          TextInput::make('country')
          ->label('Country')
          ->maxLength(255)
          ->columnSpan('full'),
        ])->columns(12),
        Grid::make()
        ->schema([
          TextInput::make('phone')
          ->label('Phone')
          ->tel()
          ->prefixIcon('heroicon-m-phone')
          ->columnSpan(6),
          TextInput::make('phone_business')
          ->label('Phone Business')
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
      ->heading('Addresses')
      ->columns([
        TextColumn::make('address'),
        TextColumn::make('street'),
        TextColumn::make('zip'),
        TextColumn::make('city'),
      ])
      ->filters([
      ])
      ->headerActions([
        Tables\Actions\CreateAction::make('create')
          ->mutateFormDataUsing(function (array $data): array {
            $data['user_id'] = auth()->id();
            return $data;
        }),
      ])
      ->actions([
        Tables\Actions\EditAction::make('edit')
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
