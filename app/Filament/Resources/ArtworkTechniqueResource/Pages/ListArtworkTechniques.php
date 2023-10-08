<?php
namespace App\Filament\Resources\ArtworkTechniqueResource\Pages;
use App\Filament\Resources\ArtworkTechniqueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtworkTechniques extends ListRecords
{
  protected static string $resource = ArtworkTechniqueResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
