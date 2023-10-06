<?php
namespace App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClient extends EditRecord
{
  protected static string $resource = ClientResource::class;

  protected function mutateFormDataBeforeSave(array $data): array
  {
    $data['user_id'] = auth()->user()->id;
    $data['alfa'] = (isset($data['firstname']) ? strtoupper($data['firstname']) . ' ' : '') . strtoupper($data['lastname']);
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
