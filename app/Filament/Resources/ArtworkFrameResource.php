<?php
namespace App\Filament\Resources;
use App\Filament\Resources\ArtworkFrameResource\Pages;
use App\Filament\Resources\ArtworkFrameResource\RelationManagers;
use App\Models\ArtworkFrame;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Concerns\Translatable;

class ArtworkFrameResource extends Resource
{
  use Translatable;

  protected static ?string $model = ArtworkFrame::class;

  protected static ?string $navigationIcon = 'heroicon-o-photo';

  protected static ?string $navigationLabel = 'Rahmen';

  protected static ?string $modelLabel = 'Rahmen';
  
  protected static ?string $pluralModelLabel = 'Rahmen';

  protected static ?string $navigationGroup = 'Settings';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('description')
        ->label('Description')
        ->required()
        ->maxLength(255),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('display_name')
          ->label('Description')
          ->searchable()
          ->sortable(),
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
      ])->defaultSort('display_name', 'asc');
  }

  public static function getRelations(): array
  {
    return [
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListArtworkFrames::route('/'),
      'create' => Pages\CreateArtworkFrame::route('/create'),
      'edit' => Pages\EditArtworkFrame::route('/{record}/edit'),
    ];
  }
  
  public function validationRules()
  {
    $locale = app()->getLocale();
    return ArtworkFrame::rules($locale);
  }
}
