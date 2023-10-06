<?php
namespace App\Filament\Resources;
use App\Filament\Resources\ArtistPublicationResource\Pages;
use App\Filament\Resources\ArtistPublicationResource\RelationManagers;
use App\Models\ArtistPublication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArtistPublicationResource extends Resource
{
  protected static ?string $model = ArtistPublication::class;

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

  protected static bool $shouldRegisterNavigation = false;

  protected static ?string $modelLabel = 'Publikation';

  protected static ?string $pluralModelLabel = 'Publikationen';

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
      'index' => Pages\ListArtistPublications::route('/'),
      'create' => Pages\CreateArtistPublication::route('/create'),
      'edit' => Pages\EditArtistPublication::route('/{record}/edit'),
    ];
  }    
}
