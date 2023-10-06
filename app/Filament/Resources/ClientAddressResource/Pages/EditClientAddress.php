<?php
namespace App\Filament\Resources\ClientAddressResource\Pages;
use App\Filament\Resources\ClientAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClientAddress extends EditRecord
{
  protected static string $resource = ClientAddressResource::class;

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
