<?php
namespace App\Filament\Resources\ArtworkFrameResource\Pages;
use App\Filament\Resources\ArtworkFrameResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtworkFrames extends ListRecords
{
  protected static string $resource = ArtworkFrameResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
