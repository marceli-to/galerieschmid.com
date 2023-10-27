<?php
namespace App\Filament\Resources\ArtworkResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
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

  protected static ?string $modelLabel = 'Zusatzfeld';
  
  protected static ?string $pluralModelLabel = 'Zusatzfelder';

  protected static ?string $tabItemLabel = 'Zusatzfelder';

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Grid::make()
        ->schema([
          Forms\Components\TextInput::make('description')
          ->label('Beschreibung')
          ->required()
          ->columnSpan('full')
          ->maxLength(255),
        ])->columns(12),

      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->heading('Zusatzfelder')
      ->columns([
        TextColumn::make('description')
        ->label('Beschreibung'),
      ])
      ->filters([
      ])
      ->headerActions([
        Tables\Actions\CreateAction::make('create')
          ->modalWidth('lg')
          ->mutateFormDataUsing(function (array $data): array {
            $data['user_id'] = auth()->id();
            return $data;
        }),
      ])
      ->actions([
        Tables\Actions\EditAction::make()->modalWidth('lg'),
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
          Tables\Actions\BulkActionGroup::make([
            Tables\Actions\DeleteBulkAction::make(),
          ]),
      ]);
  }
}
