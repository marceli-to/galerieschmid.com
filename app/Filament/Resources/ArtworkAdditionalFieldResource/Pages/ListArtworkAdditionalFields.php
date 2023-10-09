<?php
namespace App\Filament\Resources\ArtworkAdditionalFieldResource\Pages;
use App\Filament\Resources\ArtworkAdditionalFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtworkAdditionalFields extends ListRecords
{
  protected static string $resource = ArtworkAdditionalFieldResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
