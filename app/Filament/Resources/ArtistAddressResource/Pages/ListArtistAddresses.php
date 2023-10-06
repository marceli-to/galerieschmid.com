<?php
namespace App\Filament\Resources\ArtistAddressResource\Pages;
use App\Filament\Resources\ArtistAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtistAddresses extends ListRecords
{
  protected static string $resource = ArtistAddressResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
