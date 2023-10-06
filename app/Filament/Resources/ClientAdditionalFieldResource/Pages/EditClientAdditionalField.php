<?php
namespace App\Filament\Resources\ClientAdditionalFieldResource\Pages;
use App\Filament\Resources\ClientAdditionalFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClientAdditionalField extends EditRecord
{
  protected static string $resource = ClientAdditionalFieldResource::class;

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
