<?php
namespace App\Filament\Resources;
use App\Filament\Resources\ArtworkResource\Pages;
use App\Filament\Resources\ArtworkResource\RelationManagers;
use App\Models\Artwork;
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
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArtworkResource extends Resource
{
  protected static ?string $model = Artwork::class;

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
    ->columns([
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
      'index' => Pages\ListArtworks::route('/'),
      'create' => Pages\CreateArtwork::route('/create'),
      'edit' => Pages\EditArtwork::route('/{record}/edit'),
    ];
  }    
}
