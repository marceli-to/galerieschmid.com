<?php
namespace App\Filament\Resources\ArtworkAttributeResource\Pages;

use App\Filament\Resources\ArtworkAttributeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArtworkAttribute extends CreateRecord
{
  protected static string $resource = ArtworkAttributeResource::class;

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
