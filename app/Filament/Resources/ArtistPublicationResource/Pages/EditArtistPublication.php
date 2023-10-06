<?php
namespace App\Filament\Resources\ArtistPublicationResource\Pages;
use App\Filament\Resources\ArtistPublicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtistPublication extends EditRecord
{
  protected static string $resource = ArtistPublicationResource::class;

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
