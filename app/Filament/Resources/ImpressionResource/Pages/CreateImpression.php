<?php
namespace App\Filament\Resources\ImpressionResource\Pages;
use App\Filament\Resources\ImpressionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateImpression extends CreateRecord
{
  protected static string $resource = ImpressionResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['position'] = isset($data['position']) ? $data['position'] : 0;
    $data['user_id'] = auth()->user()->id;
    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
