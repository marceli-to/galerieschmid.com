<?php
namespace App\Filament\Resources\ArtworkStateResource\Pages;
use App\Filament\Resources\ArtworkStateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtworkStates extends ListRecords
{

  protected static string $resource = ArtworkStateResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
