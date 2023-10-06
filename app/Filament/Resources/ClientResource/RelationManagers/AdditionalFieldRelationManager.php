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
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdditionalFieldRelationManager extends RelationManager
{
  protected static string $relationship = 'additional_fields';

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Grid::make()
        ->schema([
          Forms\Components\TextInput::make('description')
          ->required()
          ->columnSpan('full')
          ->maxLength(255),
        ])->columns(12),

      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->heading('Additional fields')
      ->columns([
        TextColumn::make('description'),
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