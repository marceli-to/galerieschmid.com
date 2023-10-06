<?php
namespace App\Filament\Resources\ClientAdditionalFieldResource\Pages;
use App\Filament\Resources\ClientAdditionalFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClientAdditionalField extends CreateRecord
{
  protected static string $resource = ClientAdditionalFieldResource::class;
  
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
