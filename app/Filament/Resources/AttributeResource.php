<?php
namespace App\Filament\Resources;
use App\Filament\Resources\AttributeResource\Pages;
use App\Filament\Resources\AttributeResource\RelationManagers;
use App\Models\Attribute;
use App\Models\AttributeGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttributeResource extends Resource
{
  protected static ?string $model = Attribute::class;

  protected static ?string $navigationIcon = 'heroicon-o-document';

  protected static ?string $navigationLabel = 'Attribute';

  protected static ?string $modelLabel = 'Attribut';
  
  protected static ?string $pluralModelLabel = 'Attribute';

  protected static ?string $navigationGroup = 'Settings';

  public static function form(Form $form): Form
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

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('description_de')
          ->label('Description')
          ->searchable()
          ->sortable(),
        TextColumn::make('attributeGroup.description_de')
        ->label('Kategorie')
        ->badge()
        ->color('primary')
        ->searchable()
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
    ];
  }
  
  public static function getPages(): array
  {
    return [
      'index' => Pages\ListAttributes::route('/'),
      'create' => Pages\CreateAttribute::route('/create'),
      'edit' => Pages\EditAttribute::route('/{record}/edit'),
    ];
  }    
}
