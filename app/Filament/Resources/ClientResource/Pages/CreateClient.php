<?php
namespace App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClient extends CreateRecord
{
  protected static string $resource = ClientResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['user_id'] = auth()->user()->id;
    $data['alfa'] = (isset($data['firstname']) ? strtoupper($data['firstname']) . ' ' : '') . strtoupper($data['lastname']);
    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
