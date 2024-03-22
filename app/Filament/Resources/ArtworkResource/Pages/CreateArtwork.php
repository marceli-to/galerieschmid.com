<?php
namespace App\Filament\Resources\ArtworkResource\Pages;
use App\Filament\Resources\ArtworkResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArtwork extends CreateRecord
{
  protected static string $resource = ArtworkResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['user_id'] = auth()->user()->id;
    //$data['alfa'] = (isset($data['firstname']) ? strtoupper($data['firstname']) . ' ' : '') . strtoupper($data['lastname']);
    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
