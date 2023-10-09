<?php
namespace App\Filament\Resources\ArtworkAdditionalFieldResource\Pages;
use App\Filament\Resources\ArtworkAdditionalFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtworkAdditionalField extends EditRecord
{
  protected static string $resource = ArtworkAdditionalFieldResource::class;

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
