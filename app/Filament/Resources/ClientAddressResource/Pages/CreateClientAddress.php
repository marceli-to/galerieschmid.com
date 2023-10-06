<?php
namespace App\Filament\Resources\ClientAddressResource\Pages;
use App\Filament\Resources\ClientAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClientAddress extends CreateRecord
{
  protected static string $resource = ClientAddressResource::class;
  
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
