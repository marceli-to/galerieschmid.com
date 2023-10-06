<?php
namespace App\Filament\Resources\ArtistAddressResource\Pages;
use App\Filament\Resources\ArtistAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtistAddress extends EditRecord
{
  protected static string $resource = ArtistAddressResource::class;

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
