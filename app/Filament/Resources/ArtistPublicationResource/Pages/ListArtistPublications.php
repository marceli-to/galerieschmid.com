<?php
namespace App\Filament\Resources\ArtistPublicationResource\Pages;
use App\Filament\Resources\ArtistPublicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtistPublications extends ListRecords
{
  protected static string $resource = ArtistPublicationResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
