<?php
namespace App\Filament\Resources\ArtistResource\Pages;
use App\Filament\Resources\ArtistResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtist extends EditRecord
{
  protected static string $resource = ArtistResource::class;

  protected function mutateFormDataBeforeSave(array $data): array
  {
    $data['user_id'] = auth()->user()->id;
    $data['artist_name'] = (isset($data['firstname']) ? $data['firstname'] . ' ' : '') . $data['lastname'];
    if (isset($data['website']) && !empty($data['website']))
    {
      if (!preg_match("~^(?:f|ht)tps?://~i", $data['website']))
      {
        $data['website'] = "http://" . $data['website'];
      }
    }
    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
