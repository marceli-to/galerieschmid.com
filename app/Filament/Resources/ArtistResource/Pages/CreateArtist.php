<?php
namespace App\Filament\Resources\ArtistResource\Pages;
use App\Filament\Resources\ArtistResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArtist extends CreateRecord
{
  protected static string $resource = ArtistResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['artist_name'] = (isset($data['firstname']) ? $data['firstname'] . ' ' : '') . $data['lastname'];
    $data['user_id'] = auth()->user()->id;
    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
  
}
