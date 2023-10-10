<?php
namespace App\Filament\Resources\ArtworkAttributeResource\Pages;
use App\Filament\Resources\ArtworkAttributeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtworkAttributes extends ListRecords
{
  protected static string $resource = ArtworkAttributeResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
