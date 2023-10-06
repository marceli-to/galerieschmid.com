<?php
namespace App\Filament\Resources;
use App\Filament\Resources\ArtistAddressResource\Pages;
use App\Filament\Resources\ArtistAddressResource\RelationManagers;
use App\Models\ArtistAddress;
use App\Models\Artist;
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
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArtistAddressResource extends Resource
{
  protected static ?string $model = ArtistAddress::class;

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
  
  protected static bool $shouldRegisterNavigation = false;
  
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
      'index' => Pages\ListArtistAddresses::route('/'),
      'create' => Pages\CreateArtistAddress::route('/create'),
      'edit' => Pages\EditArtistAddress::route('/{record}/edit'),
    ];
  }    
}
