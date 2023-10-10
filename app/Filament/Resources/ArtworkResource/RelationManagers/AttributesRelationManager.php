<?php
namespace App\Filament\Resources\ArtworkResource\RelationManagers;
use App\Models\AttributeGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttributesRelationManager extends RelationManager
{
  protected static string $relationship = 'attributes';

  protected static ?string $modelLabel = 'Attribut';

  protected static ?string $pluralModelLabel = 'Attribute';

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Section::make('Deutsch')
        ->collapsible()
        ->schema([
          TextInput::make('description_de')
            ->label('Beschreibung')
            ->required()
            ->maxLength(255),
        ]),
        Section::make('Englisch')
        ->collapsible()
        ->collapsed()
        ->schema([
          TextInput::make('description_en')
            ->label('Beschreibung')
            ->maxLength(255),
        ]),
        Section::make('Kategorie')
        ->schema([
          Select::make('attribute_group_id')
          ->label('Technik')
          ->options(AttributeGroup::all()->sortBy('description_de')->pluck('description_de', 'id'))
          ->columnSpan('full')
          ->searchable()
          ->selectablePlaceholder(false),
        ])
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->heading('Attribute')
      ->recordTitleAttribute('description_de')
      ->columns([
        TextColumn::make('description_de')
        ->label('Beschreibung'),
        TextColumn::make('attributeGroup.description_de')
        ->label('Kategorie')
        ->badge()
        ->color('primary')
        ->sortable(),
      ])
      ->filters([
      ])
      ->headerActions([
        Tables\Actions\AttachAction::make('attach')
      ])
      ->actions([
        Tables\Actions\DetachAction::make('detach')->label('Entfernen'),
        Tables\Actions\EditAction::make('edit')->modalWidth('2xl')
        ->mutateRecordDataUsing(function (array $data): array {
          $data['user_id'] = auth()->id();
          return $data;
        }),
        //Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        // Tables\Actions\BulkActionGroup::make([
        //   Tables\Actions\DeleteBulkAction::make(),
        // ]),
      ]);
  }
}
