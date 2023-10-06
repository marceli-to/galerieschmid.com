<?php
namespace App\Filament\Resources\ArtistTypeResource\Pages;
use App\Filament\Resources\ArtistTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtistTypes extends ListRecords
{
  use ListRecords\Concerns\Translatable;

  protected static string $resource = ArtistTypeResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
