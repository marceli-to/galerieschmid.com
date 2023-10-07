<?php
namespace App\Filament\Resources\ArtworkResource\Pages;
use App\Filament\Resources\ArtworkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtwork extends EditRecord
{
  protected static string $resource = ArtworkResource::class;

  protected function mutateFormDataBeforeSave(array $data): array
  {
    $data['user_id'] = auth()->user()->id;
    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
