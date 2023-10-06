<?php
namespace App\Filament\Resources\ArtistAddressResource\Pages;
use App\Filament\Resources\ArtistAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArtistAddress extends CreateRecord
{
  protected static string $resource = ArtistAddressResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['user_id'] = auth()->user()->id;
    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
